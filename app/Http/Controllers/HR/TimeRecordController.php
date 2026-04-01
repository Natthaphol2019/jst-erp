<?php
namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;
use App\Models\TimeRecord;
use Illuminate\Http\Request;
use Carbon\CarbonPeriod;

class TimeRecordController extends Controller
{
    // หน้า 1: เลือกช่วงวันที่และแผนก + แสดงภาพรวม
    public function batchSelect(Request $request)
    {
        $departments = Department::all();
        $department_id = $request->department_id;
        $start_date = $request->start_date ?? date('Y-m-d');
        $end_date = $request->end_date ?? date('Y-m-d');

        $employees = collect();
        if ($department_id) {
            // ดึงพนักงานในแผนก พร้อมนับจำนวนวันที่เคยบันทึกเวลาไปแล้วในช่วงเวลานี้
            $employees = Employee::with('department')
                ->withCount([
                    'timeRecords' => function ($query) use ($start_date, $end_date) {
                        $query->whereBetween('work_date', [$start_date, $end_date]);
                    }
                ])
                ->where('department_id', $department_id)
                ->where('status', 'active')
                ->get();
        }

        return view('hr.time_records.batch_select', compact('departments', 'department_id', 'start_date', 'end_date', 'employees'));
    }

    // หน้า 2: ฟอร์มกรอกเวลา (เฉพาะ 1 คน - อัปเกรด 3 ช่วงเวลา)
    public function batchForm(Request $request)
    {
        $employee_id = $request->employee_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if (!$employee_id || !$start_date || !$end_date) {
            return redirect()->route('hr.time-records.batch.select')->with('error', 'ข้อมูลไม่ครบถ้วน');
        }

        $employee = Employee::with('department', 'position')->findOrFail($employee_id);

        $dates = [];
        $period = \Carbon\CarbonPeriod::create($start_date, $end_date);
        foreach ($period as $date) {
            $dates[] = $date->format('Y-m-d');
        }

        // ดึงประวัติเก่า พร้อมกับ Detail (เช้า, บ่าย, OT) ของคนๆ นี้มาแสดง
        $existingRecords = TimeRecord::with('details')->where('employee_id', $employee_id)
            ->whereBetween('work_date', [$start_date, $end_date])
            ->get()
            ->keyBy('work_date');

        return view('hr.time_records.batch_form', compact('employee', 'start_date', 'end_date', 'dates', 'existingRecords'));
    }

    // หน้า 3: บันทึกข้อมูล (แยกลงตาราง Detail)
    // หน้า 3: บันทึกข้อมูล (แยกลงตาราง Detail)
    public function batchStore(Request $request)
    {
        $employee_id = $request->employee_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        // 🌟 จุดที่แก้บัค: ต้องเจาะเข้าไปที่ [$employee_id] ก่อนดึงวันที่มาวนลูป
        $records = $request->records[$employee_id] ?? [];

        if (!empty($records)) {
            foreach ($records as $date => $data) {
                // เช็ค Lock
                $existing = TimeRecord::where('employee_id', $employee_id)->where('work_date', $date)->first();
                if ($existing && $existing->is_locked)
                    continue;

                $status = $data['status'] ?? 'present';
                $remark = $data['remark'] ?? '';

                // เช็คว่ามีการกรอกอะไรมาบ้างไหม
                $hasData = !empty($data['morning_in']) || !empty($data['morning_out']) ||
                    !empty($data['afternoon_in']) || !empty($data['afternoon_out']) ||
                    !empty($data['ot_in']) || !empty($data['ot_out']) ||
                    $status !== 'present' || !empty($remark);

                if ($hasData) {
                    // 1. บันทึกตารางหลัก (TimeRecord) -> เก็บสถานะและหมายเหตุ
                    $tr = TimeRecord::updateOrCreate(
                        ['employee_id' => $employee_id, 'work_date' => $date],
                        [
                            'status' => $status,
                            'source' => 'batch',
                            'remark' => $remark,
                        ]
                    );

                    // 2. บันทึกตารางย่อย (TimeRecordDetail) -> เก็บเวลา เช้า/บ่าย/OT
                    $periods = ['morning', 'afternoon', 'overtime'];
                    foreach ($periods as $p) {
                        $inKey = $p === 'overtime' ? 'ot_in' : $p . '_in';
                        $outKey = $p === 'overtime' ? 'ot_out' : $p . '_out';

                        $inTime = $data[$inKey] ?? null;
                        $outTime = $data[$outKey] ?? null;

                        if ($inTime || $outTime) {
                            \App\Models\TimeRecordDetail::updateOrCreate(
                                ['time_record_id' => $tr->id, 'period_type' => $p],
                                ['check_in_time' => $inTime, 'check_out_time' => $outTime]
                            );
                        } else {
                            // ถ้าลบเวลาบนหน้าจอ ให้ลบในฐานข้อมูลด้วย
                            \App\Models\TimeRecordDetail::where('time_record_id', $tr->id)->where('period_type', $p)->delete();
                        }
                    }
                }
            }
        }

        // ดึงแผนกเพื่อ Redirect กลับ
        $emp = Employee::find($employee_id);
        return redirect()->route('hr.time-records.batch.select', [
            'department_id' => $emp ? $emp->department_id : null,
            'start_date' => $start_date,
            'end_date' => $end_date
        ])->with('success', 'บันทึกเวลาทำงานสำเร็จ! ข้อมูลอัปเดตแล้ว');
    }


    // ==========================================
    // รายงานสรุปเวลาทำงานรายเดือน
    // ==========================================
    public function summary(Request $request)
    {
        $selectedMonth = $request->month_year ?? date('Y-m');
        $year = date('Y', strtotime($selectedMonth));
        $month = date('m', strtotime($selectedMonth));

        $employees = Employee::with([
            'department',
            'timeRecords' => function ($query) use ($year, $month) {
                // 🌟 ต้องมีคำว่า with('details') พ่วงท้ายตรงนี้ด้วยนะครับ สำคัญมาก!
                $query->whereYear('work_date', $year)->whereMonth('work_date', $month)->with('details');
            }
        ])->where('status', 'active')->get();

        return view('hr.time_records.summary', compact('employees', 'selectedMonth'));
    }

    // ==========================================
    // ระบบปิดงวดเวลา (Lock Period)
    // ==========================================
    public function lockPeriod(Request $request)
    {
        $month = $request->month ?? date('Y-m');
        $period = $request->period ?? 1;

        $year = substr($month, 0, 4);
        $mon = substr($month, 5, 2);

        // คำนวณช่วงวันที่ตามงวด (1-15 หรือ 16-สิ้นเดือน)
        if ($period == 1) {
            $startDate = "$year-$mon-01";
            $endDate = "$year-$mon-15";
            $periodLabel = "งวดครึ่งเดือนแรก (วันที่ 1 - 15)";
        } else {
            $startDate = "$year-$mon-16";
            $endDate = date('Y-m-t', strtotime($startDate));
            $periodLabel = "งวดครึ่งเดือนหลัง (วันที่ 16 - สิ้นเดือน)";
        }

        // นับจำนวนรายการที่ "ล็อกแล้ว" และ "ยังไม่ล็อก" ในช่วงเวลานี้
        $unlockedCount = TimeRecord::whereBetween('work_date', [$startDate, $endDate])->where('is_locked', 0)->count();
        $lockedCount = TimeRecord::whereBetween('work_date', [$startDate, $endDate])->where('is_locked', 1)->count();

        return view('hr.time_records.lock_period', compact('month', 'period', 'startDate', 'endDate', 'periodLabel', 'unlockedCount', 'lockedCount'));
    }

    public function lockPeriodStore(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $action = $request->action; // รับค่ามาว่าเป็น 'lock' หรือ 'unlock'

        $is_locked = ($action === 'lock') ? 1 : 0;

        // อัปเดตข้อมูลทั้งหมดในช่วงวันที่เลือก ให้ถูกล็อก หรือ ปลดล็อก
        TimeRecord::whereBetween('work_date', [$startDate, $endDate])->update(['is_locked' => $is_locked]);

        $message = ($action === 'lock') ? '🔒 ปิดงวดและล็อกเวลาทำงานเรียบร้อยแล้ว!' : '🔓 ปลดล็อกงวดเวลาเรียบร้อยแล้ว!';
        
        return redirect()->route('hr.time-records.lock', [
            'month' => substr($startDate, 0, 7),
            'period' => (substr($startDate, 8, 2) == '01') ? 1 : 2
        ])->with('success', $message);
    }
}