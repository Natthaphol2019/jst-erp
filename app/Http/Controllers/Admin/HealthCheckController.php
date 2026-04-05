<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;

class HealthCheckController extends Controller
{
    /**
     * Show system health status.
     */
    public function index()
    {
        $checks = [];

        // 1. Database Connection
        $checks['database'] = $this->checkDatabase();

        // 2. Disk Space
        $checks['disk_space'] = $this->checkDiskSpace();

        // 3. PHP Version
        $checks['php_version'] = $this->checkPhpVersion();

        // 4. Laravel Version
        $checks['laravel_version'] = $this->checkLaravelVersion();

        // 5. Cache Status
        $checks['cache'] = $this->checkCache();

        // 6. Storage Permissions
        $checks['storage_permissions'] = $this->checkStoragePermissions();

        // 7. Environment
        $checks['environment'] = $this->checkEnvironment();

        // 8. Session Driver
        $checks['session'] = $this->checkSession();

        // 9. Log File
        $checks['log_file'] = $this->checkLogFile();

        // 10. Recent Errors
        $checks['recent_errors'] = $this->getRecentErrors();

        // Calculate overall status
        $allOk = collect($checks)->except('recent_errors')->every(fn($c) => $c['status'] === 'ok');

        return view('admin.health.index', compact('checks', 'allOk'));
    }

    /**
     * Check database connection.
     */
    protected function checkDatabase()
    {
        try {
            DB::connection()->getPdo();
            $dbName = DB::connection()->getDatabaseName();

            // Get database size
            $size = DB::select("
                SELECT SUM(data_length + index_length) AS size
                FROM information_schema.tables
                WHERE table_schema = '{$dbName}'
            ");

            $sizeBytes = $size[0]->size ?? 0;

            return [
                'status' => 'ok',
                'message' => 'เชื่อมต่อฐานข้อมูลสําเร็จ',
                'details' => [
                    'driver' => DB::connection()->getDriverName(),
                    'database' => $dbName,
                    'host' => DB::connection()->getConfig('host'),
                    'size' => $this->formatBytes($sizeBytes),
                ],
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'ไม่สามารถเชื่อมต่อฐานข้อมูล: ' . $e->getMessage(),
                'details' => [],
            ];
        }
    }

    /**
     * Check disk space.
     */
    protected function checkDiskSpace()
    {
        $path = storage_path();
        $total = disk_total_space($path);
        $free = disk_free_space($path);
        $used = $total - $free;
        $percentUsed = ($used / $total) * 100;

        $status = 'ok';
        if ($percentUsed > 90) {
            $status = 'error';
        } elseif ($percentUsed > 75) {
            $status = 'warning';
        }

        return [
            'status' => $status,
            'message' => "ใช้พื้นที่ {$percentUsed}%",
            'details' => [
                'total' => $this->formatBytes($total),
                'used' => $this->formatBytes($used),
                'free' => $this->formatBytes($free),
                'percent_used' => round($percentUsed, 1) . '%',
            ],
        ];
    }

    /**
     * Check PHP version.
     */
    protected function checkPhpVersion()
    {
        $currentVersion = PHP_VERSION;
        $requiredVersion = '8.2.0';
        $status = version_compare($currentVersion, $requiredVersion, '>=') ? 'ok' : 'error';

        return [
            'status' => $status,
            'message' => "PHP {$currentVersion}",
            'details' => [
                'current' => $currentVersion,
                'required' => ">= {$requiredVersion}",
                'extensions' => $this->checkRequiredExtensions(),
            ],
        ];
    }

    /**
     * Check required PHP extensions.
     */
    protected function checkRequiredExtensions()
    {
        $required = ['mbstring', 'xml', 'curl', 'mysql', 'zip', 'gd', 'fileinfo'];
        $status = [];

        foreach ($required as $ext) {
            $status[$ext] = extension_loaded($ext);
        }

        return $status;
    }

    /**
     * Check Laravel version.
     */
    protected function checkLaravelVersion()
    {
        $version = app()->version();

        return [
            'status' => 'ok',
            'message' => "Laravel {$version}",
            'details' => [
                'version' => $version,
                'environment' => app()->environment(),
                'debug' => config('app.debug') ? 'เปิด' : 'ปิด',
                'timezone' => config('app.timezone'),
                'locale' => config('app.locale'),
            ],
        ];
    }

    /**
     * Check cache status.
     */
    protected function checkCache()
    {
        try {
            $driver = config('cache.default');

            // Test cache write/read
            $testKey = 'health_check_' . time();
            Cache::put($testKey, 'ok', 10);
            $result = Cache::get($testKey);

            $status = $result === 'ok' ? 'ok' : 'warning';

            return [
                'status' => $status,
                'message' => $status === 'ok' ? 'ระบบแคชทํางานปกติ' : 'ระบบแคชอาจมีปัญหา',
                'details' => [
                    'driver' => $driver,
                    'test_write' => $result === 'ok' ? 'สําเร็จ' : 'ล้มเหลว',
                    'store' => config('cache.stores.' . $driver . '.driver', $driver),
                ],
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'เกิดข้อผิดพลาดระบบแคช: ' . $e->getMessage(),
                'details' => [],
            ];
        }
    }

    /**
     * Check storage permissions.
     */
    protected function checkStoragePermissions()
    {
        $paths = [
            'storage/app' => storage_path('app'),
            'storage/framework' => storage_path('framework'),
            'storage/logs' => storage_path('logs'),
            'bootstrap/cache' => base_path('bootstrap/cache'),
        ];

        $allWritable = true;
        $details = [];

        foreach ($paths as $name => $path) {
            $writable = is_writable($path);
            if (!$writable) {
                $allWritable = false;
            }
            $details[$name] = $writable ? 'เขียนได้' : 'เขียนไม่ได้';
        }

        return [
            'status' => $allWritable ? 'ok' : 'error',
            'message' => $allWritable ? 'สิทธิ์การเขียนไฟล์ปกติ' : 'บางโฟลเดอร์ไม่มีสิทธิ์เขียน',
            'details' => $details,
        ];
    }

    /**
     * Check environment configuration.
     */
    protected function checkEnvironment()
    {
        $env = app()->environment();
        $appDebug = config('app.debug');
        $logLevel = config('logging.channels.stack.level', 'debug');

        $status = 'ok';
        $warnings = [];

        if ($env === 'production' && $appDebug) {
            $status = 'warning';
            $warnings[] = 'APP_DEBUG เปิดอยู่ใน production';
        }

        if ($env === 'production' && $logLevel === 'debug') {
            $status = 'warning';
            $warnings[] = 'LOG_LEVEL เป็น debug ใน production (ควรเป็น error)';
        }

        return [
            'status' => $status,
            'message' => $env === 'production' ? 'โหมด Production' : 'โหมด Development',
            'details' => [
                'environment' => $env,
                'app_debug' => $appDebug ? 'เปิด' : 'ปิด',
                'log_level' => $logLevel,
                'app_name' => config('app.name'),
                'app_url' => config('app.url'),
                'warnings' => $warnings,
            ],
        ];
    }

    /**
     * Check session configuration.
     */
    protected function checkSession()
    {
        $driver = config('session.driver');
        $lifetime = config('session.lifetime');

        return [
            'status' => 'ok',
            'message' => "Session: {$driver} ({$lifetime} นาที)",
            'details' => [
                'driver' => $driver,
                'lifetime' => $lifetime . ' นาที',
                'secure' => config('session.secure') ? 'เปิด' : 'ปิด',
                'same_site' => config('session.same_site', 'lax'),
            ],
        ];
    }

    /**
     * Check log file.
     */
    protected function checkLogFile()
    {
        $logFile = storage_path('logs/laravel.log');

        if (!file_exists($logFile)) {
            return [
                'status' => 'ok',
                'message' => 'ไม่มีไฟล์ล็อก (ปกติ)',
                'details' => ['size' => 'ไม่มีไฟล์'],
            ];
        }

        $size = filesize($logFile);
        $status = $size > 10 * 1024 * 1024 ? 'warning' : 'ok'; // 10MB

        return [
            'status' => $status,
            'message' => $status === 'ok' ? 'ไฟล์ล็อกปกติ' : 'ไฟล์ล็อกมีขนาดใหญ่มาก',
            'details' => [
                'size' => $this->formatBytes($size),
                'path' => $logFile,
                'warning' => $status === 'warning' ? 'ควรลบล็อกเก่า' : null,
            ],
        ];
    }

    /**
     * Get recent errors from log file.
     */
    protected function getRecentErrors()
    {
        $logFile = storage_path('logs/laravel.log');

        if (!file_exists($logFile)) {
            return ['count' => 0, 'errors' => []];
        }

        $content = file_get_contents($logFile);
        $errors = [];

        // Parse log entries for errors
        $lines = explode("\n", $content);
        $currentError = null;

        foreach ($lines as $line) {
            if (preg_match('/^\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\].*\.ERROR:/', $line)) {
                if ($currentError) {
                    $errors[] = $currentError;
                }
                $currentError = trim($line);
            } elseif ($currentError && !empty(trim($line)) && count($errors) < 20) {
                $currentError .= "\n" . trim($line);
            }
        }

        if ($currentError && count($errors) < 20) {
            $errors[] = $currentError;
        }

        // Limit to last 10 errors
        $errors = array_slice($errors, -10);

        return [
            'count' => preg_match_all('/\.ERROR:/', $content),
            'errors' => $errors,
        ];
    }

    /**
     * Format bytes to human-readable.
     */
    protected function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        if ($bytes <= 0) {
            return '0 B';
        }

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
