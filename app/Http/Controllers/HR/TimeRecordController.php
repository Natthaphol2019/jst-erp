<?php
namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\TimeRecord;
use Illuminate\Http\Request;

class TimeRecordController extends Controller
{
    // เปิดหน้าฟอร์มคีย์ข้อมูลแบบตาราง (Batch Entry)
    public function batchCreate(Request $request)
    {
        // 1. รับค่าวันที่ที่เลือก (ถ้าไม่เลือก ให้ใช้วันที่ปัจจุบัน)
        $selectedDate = $request->date ?? date('Y-m-d');

        // 2. ดึงพนักงานที่ยัง "ทำงานอยู่" ทั้งหมดมาแสดง
        $employees = Employee::with('department', 'position')->where('status', 'active')->get();

        // 3. ดึงข้อมูลเวลาของ "วันที่เลือก" เพื่อเอามาแสดงซ้ำถ้า HR จะแก้ไข (เปลี่ยน record_date เป็น work_date)
        $existingRecords = TimeRecord::where('work_date', $selectedDate)
            ->get()
            ->keyBy('employee_id');

        return view('hr.time_records.batch', compact('employees', 'selectedDate', 'existingRecords'));
    }

    // รับข้อมูลจากตารางมาบันทึกลงฐานข้อมูลแบบรวดเดียว
    public function batchStore(Request $request)
    {
        // เปลี่ยนมาใช้ work_date ตาม Model
        $selectedDate = $request->work_date;
        $records = $request->records;

        foreach ($records as $employeeId => $data) {
            // เช็คว่ามีการกรอกเวลา หรือสถานะไม่ใช่ "มาปกติ" หรือมีหมายเหตุ 
            if (!empty($data['check_in_time']) || !empty($data['check_out_time']) || $data['status'] !== 'present' || !empty($data['remark'])) {

                // ใช้ updateOrCreate เพื่อบันทึกข้อมูล
                TimeRecord::updateOrCreate(
                    [
                        'employee_id' => $employeeId,
                        'work_date' => $selectedDate,
                    ],
                    [
                        'check_in_time' => $data['check_in_time'] ?: null,
                        'check_out_time' => $data['check_out_time'] ?: null,
                        'status' => $data['status'],
                        'source' => 'batch', // บันทึกว่ามาจากการคีย์แบบกลุ่ม
                        'remark' => $data['remark'],
                        // is_locked ให้เป็น default ตามฐานข้อมูลไปก่อนครับ
                    ]
                );
            }
        }

        return redirect()->route('hr.time-records.batch', ['date' => $selectedDate])
            ->with('success', 'บันทึกเวลาทำงานประจำวันที่ ' . \Carbon\Carbon::parse($selectedDate)->format('d/m/Y') . ' เรียบร้อยแล้ว!');
    }

    // ==========================================
    // รายงานสรุปเวลาทำงานรายเดือน
    // ==========================================
    public function summary(Request $request)
    {
        // 1. รับค่าเดือนที่ต้องการดู (ถ้าไม่เลือก ให้ใช้เดือนปัจจุบัน เช่น 2026-04)
        $selectedMonth = $request->month_year ?? date('Y-m');
        $year = date('Y', strtotime($selectedMonth));
        $month = date('m', strtotime($selectedMonth));

        // 2. ดึงพนักงานทั้งหมด และดึงเฉพาะข้อมูลลงเวลา "ในเดือนและปีที่เลือก" มาคำนวณ
        $employees = Employee::with([
            'department',
            'timeRecords' => function ($query) use ($year, $month) {
                $query->whereYear('work_date', $year)->whereMonth('work_date', $month);
            }
        ])->where('status', 'active')->get();

        return view('hr.time_records.summary', compact('employees', 'selectedMonth'));
    }
}