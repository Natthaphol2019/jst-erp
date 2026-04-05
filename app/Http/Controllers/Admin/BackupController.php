<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BackupController extends Controller
{
    /**
     * Directory where backups are stored.
     */
    protected $backupDir = 'backups';

    /**
     * Display a listing of backups.
     */
    public function index()
    {
        $backups = [];

        if (Storage::disk('local')->exists($this->backupDir)) {
            $files = Storage::disk('local')->files($this->backupDir);

            foreach ($files as $file) {
                if (!str_ends_with($file, '.sql') && !str_ends_with($file, '.sql.gz')) {
                    continue;
                }

                $filename = basename($file);
                $size = Storage::disk('local')->size($file);
                $lastModified = Storage::disk('local')->lastModified($file);

                $backups[] = [
                    'filename' => $filename,
                    'size' => $size,
                    'size_formatted' => $this->formatBytes($size),
                    'date' => Carbon::createFromTimestamp($lastModified),
                    'is_compressed' => str_ends_with($file, '.gz'),
                ];
            }
        }

        // Sort by date (newest first)
        usort($backups, fn($a, $b) => $b['date']->timestamp <=> $a['date']->timestamp);

        // Get disk space info
        $diskTotal = disk_total_space(storage_path('app'));
        $diskFree = disk_free_space(storage_path('app'));
        $diskUsed = $diskTotal - $diskFree;

        return view('admin.backups.index', compact('backups', 'diskTotal', 'diskFree', 'diskUsed'));
    }

    /**
     * Create a new database backup.
     */
    public function create()
    {
        try {
            $filename = 'backup_' . Carbon::now()->format('Y-m-d_His') . '.sql';
            $storagePath = storage_path('app/' . $this->backupDir);

            // Create directory if it doesn't exist
            if (!is_dir($storagePath)) {
                mkdir($storagePath, 0755, true);
            }

            $fullPath = $storagePath . '/' . $filename;
            $gzPath = $fullPath . '.gz';

            // Try mysqldump first
            $success = $this->createUsingMysqldump($fullPath);

            if (!$success) {
                // Fallback to Laravel-based backup
                $success = $this->createUsingLaravel($fullPath);
            }

            if (!$success) {
                return back()->with('error', 'ไม่สามารถสร้างสํารองข้อมูลได้ กรุณาตรวจสอบการตั้งค่าฐานข้อมูล');
            }

            // Compress with gzip
            if (file_exists($fullPath)) {
                $fp = fopen($fullPath, 'rb');
                $gzp = gzopen($gzPath, 'w9');

                if ($gzp) {
                    while (!feof($fp)) {
                        gzwrite($gzp, fread($fp, 1024 * 512));
                    }
                    gzclose($gzp);
                    fclose($fp);

                    // Remove uncompressed file
                    unlink($fullPath);
                    $filename = basename($gzPath);
                }
            }

            // Activity log
            if (method_exists($this, 'logActivity')) {
                $this->logActivity('backups', 'สร้างสํารองข้อมูล', $filename);
            }

            return back()->with('success', 'สร้างสํารองข้อมูลสําเร็จ: ' . $filename);
        } catch (\Exception $e) {
            return back()->with('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
        }
    }

    /**
     * Create backup using mysqldump.
     */
    protected function createUsingMysqldump($outputPath)
    {
        $dbConfig = config('database.connections.' . config('database.default'));

        $mysqldumpPath = $this->findMysqldump();

        if (!$mysqldumpPath) {
            return false;
        }

        $command = sprintf(
            '"%s" --user="%s" --password="%s" --host="%s" --port="%s" "%s" > "%s" 2>&1',
            $mysqldumpPath,
            $dbConfig['username'],
            $dbConfig['password'],
            $dbConfig['host'],
            $dbConfig['port'],
            $dbConfig['database'],
            $outputPath
        );

        exec($command, $output, $returnVar);

        return $returnVar === 0 && file_exists($outputPath) && filesize($outputPath) > 0;
    }

    /**
     * Create backup using Laravel DB facade (fallback).
     */
    protected function createUsingLaravel($outputPath)
    {
        try {
            $dbConfig = config('database.connections.' . config('database.default'));
            $database = $dbConfig['database'];

            // Get all tables
            $tables = DB::select('SHOW TABLES');
            $tableKey = 'Tables_in_' . $database;
            $tableNames = array_map(fn($t) => $t->$tableKey, $tables);

            $sql = "-- Database Backup - JST ERP\n";
            $sql .= "-- Generated: " . Carbon::now()->format('Y-m-d H:i:s') . "\n";
            $sql .= "-- Database: {$database}\n\n";
            $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

            foreach ($tableNames as $table) {
                // Get create table statement
                $createStatement = DB::select("SHOW CREATE TABLE `{$table}`");
                if (!empty($createStatement)) {
                    $sql .= "-- Table structure for table `{$table}`\n";
                    $sql .= "DROP TABLE IF EXISTS `{$table}`;\n";
                    $sql .= $createStatement[0]->{'Create Table'} . ";\n\n";

                    // Get data
                    $rows = DB::table($table)->get()->toArray();

                    if (!empty($rows)) {
                        $sql .= "-- Data for table `{$table}`\n";
                        $sql .= "LOCK TABLES `{$table}` WRITE;\n";

                        foreach ($rows as $row) {
                            $rowArray = (array) $row;
                            $values = array_map(function ($value) {
                                if (is_null($value)) {
                                    return 'NULL';
                                }
                                if (is_int($value) || is_float($value)) {
                                    return $value;
                                }
                                return "'" . addslashes((string) $value) . "'";
                            }, $rowArray);

                            $columns = array_keys($rowArray);
                            $colStr = '`' . implode('`, `', $columns) . '`';
                            $valStr = implode(', ', $values);

                            $sql .= "INSERT INTO `{$table}` ({$colStr}) VALUES ({$valStr});\n";
                        }

                        $sql .= "UNLOCK TABLES;\n\n";
                    }
                }
            }

            $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

            return file_put_contents($outputPath, $sql) !== false;
        } catch (\Exception $e) {
            \Log::error('Backup failed (Laravel method): ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Find mysqldump executable.
     */
    protected function findMysqldump()
    {
        $paths = [
            'mysqldump',
            '/usr/bin/mysqldump',
            '/usr/local/bin/mysqldump',
            'C:\\xampp\\mysql\\bin\\mysqldump.exe',
            'C:\\xampp\\mysql\\bin\\mysqldump',
        ];

        foreach ($paths as $path) {
            $cmd = PHP_OS_FAMILY === 'Windows' ? "where {$path} 2>nul" : "which {$path} 2>/dev/null";
            exec($cmd, $output, $return);

            if ($return === 0 && !empty($output)) {
                return trim($output[0]);
            }
        }

        // For XAMPP on Windows, try directly
        if (file_exists('C:\\xampp\\mysql\\bin\\mysqldump.exe')) {
            return 'C:\\xampp\\mysql\\bin\\mysqldump.exe';
        }

        return null;
    }

    /**
     * Download a backup file.
     */
    public function download($filename)
    {
        $path = $this->backupDir . '/' . $filename;

        if (!Storage::disk('local')->exists($path)) {
            return back()->with('error', 'ไม่พบไฟล์สํารองข้อมูล');
        }

        return Storage::disk('local')->download($path, $filename);
    }

    /**
     * Delete a backup file.
     */
    public function delete($filename)
    {
        $path = $this->backupDir . '/' . $filename;

        if (!Storage::disk('local')->exists($path)) {
            return back()->with('error', 'ไม่พบไฟล์สํารองข้อมูล');
        }

        Storage::disk('local')->delete($path);

        return back()->with('success', 'ลบไฟล์สํารองข้อมูลสําเร็จ: ' . $filename);
    }

    /**
     * Restore from a backup file.
     */
    public function restore($filename)
    {
        $path = $this->backupDir . '/' . $filename;

        if (!Storage::disk('local')->exists($path)) {
            return back()->with('error', 'ไม่พบไฟล์สํารองข้อมูล');
        }

        try {
            $fullPath = storage_path('app/' . $path);
            $content = '';

            if (str_ends_with($filename, '.gz')) {
                // Decompress gzip file
                $content = gzdecode(file_get_contents($fullPath));
            } else {
                $content = file_get_contents($fullPath);
            }

            if (empty($content)) {
                return back()->with('error', 'ไฟล์สํารองข้อมูลว่างเปล่า');
            }

            // Disable foreign key checks and execute SQL
            DB::unprepared('SET FOREIGN_KEY_CHECKS=0;');

            // Split SQL by statements
            $statements = array_filter(
                array_map('trim', explode(";\n", $content)),
                fn($s) => !empty($s) && !str_starts_with($s, '--')
            );

            foreach ($statements as $statement) {
                if (!empty(trim($statement))) {
                    DB::unprepared($statement);
                }
            }

            DB::unprepared('SET FOREIGN_KEY_CHECKS=1;');

            // Activity log
            if (method_exists($this, 'logActivity')) {
                $this->logActivity('backups', 'กู้คืนข้อมูลจากสํารอง', $filename);
            }

            return back()->with('success', 'กู้คืนข้อมูลสําเร็จจากระบบสํารอง: ' . $filename);
        } catch (\Exception $e) {
            DB::unprepared('SET FOREIGN_KEY_CHECKS=1;');
            return back()->with('error', 'เกิดข้อผิดพลาดในการกู้คืนข้อมูล: ' . $e->getMessage());
        }
    }

    /**
     * Format bytes to human-readable.
     */
    protected function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
