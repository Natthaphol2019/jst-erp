<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\TimeRecord;
use App\Models\TimeRecordDetail;
use App\Models\TimeRecordLog;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Carbon\Carbon;
use Exception;

class TimeImportController extends Controller
{
    /**
     * แสดงหน้า Import Time Records
     */
    public function index()
    {
        return view('hr.time_records.import');
    }

    /**
     * ดาวน์โหลด Template CSV
     */
    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'employee_code');
        $sheet->setCellValue('B1', 'work_date');
        $sheet->setCellValue('C1', 'status');
        $sheet->setCellValue('D1', 'morning_in');
        $sheet->setCellValue('E1', 'morning_out');
        $sheet->setCellValue('F1', 'afternoon_in');
        $sheet->setCellValue('G1', 'afternoon_out');
        $sheet->setCellValue('H1', 'ot_in');
        $sheet->setCellValue('I1', 'ot_out');
        $sheet->setCellValue('J1', 'remark');

        // Sample data
        $sheet->setCellValue('A2', 'EMP001');
        $sheet->setCellValue('B2', '2026-04-07');
        $sheet->setCellValue('C2', 'present');
        $sheet->setCellValue('D2', '08:00');
        $sheet->setCellValue('E2', '12:00');
        $sheet->setCellValue('F2', '13:00');
        $sheet->setCellValue('G2', '17:00');
        $sheet->setCellValue('H2', '');
        $sheet->setCellValue('I2', '');
        $sheet->setCellValue('J2', '');

        // Styling header
        $headerStyle = [
            'font' => ['bold' => true, 'size' => 12],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E0E7FF']
            ]
        ];
        $sheet->getStyle('A1:J1')->applyFromArray($headerStyle);

        // Auto-size columns
        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Add instructions in row 3
        $sheet->setCellValue('A3', 'คำแนะนำ:');
        $sheet->setCellValue('A4', 'employee_code: รหัสพนักงาน (ต้องมีในระบบ)');
        $sheet->setCellValue('A5', 'work_date: วันที่ (รูปแบบ: YYYY-MM-DD)');
        $sheet->setCellValue('A6', 'status: present, late, leave, absent');
        $sheet->setCellValue('A7', 'เวลา: รูปแบบ HH:MM (เช่น 08:00, 13:30)');
        $sheet->setCellValue('A8', 'ot_in, ot_out: เวลาเข้า-ออก OT (ถ้ามี)');
        
        for ($row = 3; $row <= 8; $row++) {
            $sheet->getStyle("A{$row}")->getFont()->setItalic(true)->setColor(['rgb' => '666666']);
        }

        // Download
        $filename = 'time_records_template_' . date('Y-m-d') . '.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    /**
     * Import ไฟล์ Excel/CSV
     */
    public function import(Request $request)
    {
        $request->validate([
            'import_file' => 'required|file|mimes:xlsx,xls,csv|max:10240', // Max 10MB
            'import_mode' => 'required|in:create,update,upsert',
        ]);

        try {
            $file = $request->file('import_file');
            $importMode = $request->import_mode;

            // อ่านไฟล์
            $spreadsheet = IOFactory::load($file->getPathname());
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            if (count($rows) < 2) {
                return back()->withErrors(['error' => 'ไฟล์ไม่มีข้อมูล']);
            }

            // ตรวจสอบ header
            $header = array_map('trim', $rows[0]);
            $requiredColumns = ['employee_code', 'work_date', 'status'];
            
            foreach ($requiredColumns as $col) {
                if (!in_array($col, $header)) {
                    return back()->withErrors(['error' => "ไฟล์ต้องมีคอลัมน์: {$col}"]);
                }
            }

            // สร้าง column index mapping
            $colMap = [];
            foreach ($header as $index => $name) {
                $colMap[$name] = $index;
            }

            $results = [
                'success' => 0,
                'skipped' => 0,
                'errors' => [],
                'warnings' => []
            ];

            DB::beginTransaction();

            try {
                // เริ่มประมวลผลตั้งแต่ row ที่ 2 (index 1)
                for ($i = 1; $i < count($rows); $i++) {
                    $row = $rows[$i];
                    $rowNumber = $i + 1;

                    // ข้าม row ว่าง
                    if (empty($row[$colMap['employee_code']])) {
                        continue;
                    }

                    try {
                        $result = $this->processRow($row, $colMap, $rowNumber, $importMode);
                        
                        if ($result['status'] === 'success') {
                            $results['success']++;
                        } elseif ($result['status'] === 'skipped') {
                            $results['skipped']++;
                            $results['warnings'][] = $result['message'];
                        } else {
                            $results['errors'][] = $result['message'];
                        }
                    } catch (Exception $e) {
                        $results['errors'][] = "บรรทัดที่ {$rowNumber}: " . $e->getMessage();
                    }
                }

                if (count($results['errors']) > 0 && $results['success'] === 0) {
                    DB::rollBack();
                    return back()->withErrors([
                        'error' => 'Import ล้มเหลว มีข้อผิดพลาด: ' . implode(', ', array_slice($results['errors'], 0, 5))
                    ]);
                }

                DB::commit();

                $message = "Import สำเร็จ: {$results['success']} รายการ";
                if ($results['skipped'] > 0) {
                    $message .= ", ข้าม: {$results['skipped']} รายการ";
                }
                if (count($results['errors']) > 0) {
                    $message .= ", ข้อผิดพลาด: " . count($results['errors']) . " รายการ";
                }

                return redirect()->route('hr.time-records.import')
                    ->with('success', $message)
                    ->with('import_results', $results);

            } catch (Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (Exception $e) {
            Log::error('TimeImport failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withErrors(['error' => 'Import ล้มเหลว: ' . $e->getMessage()]);
        }
    }

    /**
     * ประมวลผลแต่ละ row
     */
    private function processRow(array $row, array $colMap, int $rowNumber, string $mode)
    {
        // ดึงข้อมูล
        $employeeCode = trim($row[$colMap['employee_code']]);
        $workDateStr = trim($row[$colMap['work_date']]);
        $status = strtolower(trim($row[$colMap['status']] ?? 'present'));

        // ตรวจสอบ status
        if (!in_array($status, ['present', 'late', 'leave', 'absent'])) {
            return [
                'status' => 'error',
                'message' => "บรรทัดที่ {$rowNumber}: status ต้องเป็น present, late, leave หรือ absent"
            ];
        }

        // หา employee
        $employee = Employee::where('employee_code', $employeeCode)->first();
        if (!$employee) {
            return [
                'status' => 'error',
                'message' => "บรรทัดที่ {$rowNumber}: ไม่พบรหัสพนักงาน {$employeeCode}"
            ];
        }

        // ตรวจสอบ work_date
        try {
            $workDate = Carbon::parse($workDateStr);
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => "บรรทัดที่ {$rowNumber}: รูปแบบวันที่ไม่ถูกต้อง (ใช้ YYYY-MM-DD)"
            ];
        }

        // ตรวจสอบ existing record
        $existingRecord = TimeRecord::where('employee_id', $employee->id)
            ->where('work_date', $workDate)
            ->first();

        // Mode: create (สร้างเฉพาะที่ยังไม่มี)
        if ($mode === 'create' && $existingRecord) {
            return [
                'status' => 'skipped',
                'message' => "บรรทัดที่ {$rowNumber}: มีข้อมูลอยู่แล้ว ({$employeeCode} - {$workDateStr})"
            ];
        }

        // ดึงเวลา
        $morningIn = $this->parseTime($row, $colMap, 'morning_in');
        $morningOut = $this->parseTime($row, $colMap, 'morning_out');
        $afternoonIn = $this->parseTime($row, $colMap, 'afternoon_in');
        $afternoonOut = $this->parseTime($row, $colMap, 'afternoon_out');
        $otIn = $this->parseTime($row, $colMap, 'ot_in');
        $otOut = $this->parseTime($row, $colMap, 'ot_out');
        $remark = trim($row[$colMap['remark'] ?? ''] ?? '');

        // สร้างหรืออัพเดท
        DB::beginTransaction();

        try {
            if ($existingRecord && $mode === 'update') {
                // อัพเดท
                $oldData = [
                    'status' => $existingRecord->status,
                    'remark' => $existingRecord->remark,
                ];

                $existingRecord->update([
                    'status' => $status,
                    'remark' => $remark ?: null,
                    'source' => 'import',
                ]);

                $timeRecord = $existingRecord;
            } else {
                // สร้างใหม่
                $timeRecord = TimeRecord::create([
                    'employee_id' => $employee->id,
                    'work_date' => $workDate,
                    'status' => $status,
                    'remark' => $remark ?: null,
                    'source' => 'import',
                    'is_locked' => false,
                ]);
            }

            // สร้าง/อัพเดท details
            if ($morningIn || $morningOut || $afternoonIn || $afternoonOut || $otIn || $otOut) {
                $this->upsertDetails($timeRecord, [
                    'morning' => ['in' => $morningIn, 'out' => $morningOut],
                    'afternoon' => ['in' => $afternoonIn, 'out' => $afternoonOut],
                    'overtime' => ['in' => $otIn, 'out' => $otOut],
                ]);
            }

            // บันทึก log
            $this->createLog($timeRecord, $existingRecord ? 'update' : 'create', [
                'status' => $status,
                'remark' => $remark ?: null,
                'source' => 'import',
            ]);

            DB::commit();

            return [
                'status' => 'success',
                'message' => "{$employeeCode} - {$workDateStr}"
            ];

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * แปลงเวลาจาก string เป็น Carbon
     */
    private function parseTime(array $row, array $colMap, string $column)
    {
        if (!isset($colMap[$column])) {
            return null;
        }

        $timeStr = trim($row[$colMap[$column]] ?? '');

        if (empty($timeStr)) {
            return null;
        }

        try {
            return Carbon::createFromFormat('H:i', $timeStr);
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * สร้างหรืออัพเดท time record details
     */
    private function upsertDetails(TimeRecord $timeRecord, array $times)
    {
        foreach ($times as $periodType => $time) {
            if (!$time['in'] && !$time['out']) {
                continue;
            }

            $detail = TimeRecordDetail::updateOrCreate(
                [
                    'time_record_id' => $timeRecord->id,
                    'period_type' => $periodType,
                ],
                [
                    'check_in_time' => $time['in'],
                    'check_out_time' => $time['out'],
                ]
            );
        }
    }

    /**
     * สร้าง audit log
     */
    private function createLog(TimeRecord $timeRecord, string $action, array $newData)
    {
        TimeRecordLog::create([
            'time_record_id' => $timeRecord->id,
            'action' => $action,
            'reason' => 'Import จากไฟล์ Excel/CSV',
            'old_data' => $action === 'create' ? null : $timeRecord->getOriginal(),
            'new_data' => $newData,
            'changed_by' => auth()->id(),
        ]);
    }
}
