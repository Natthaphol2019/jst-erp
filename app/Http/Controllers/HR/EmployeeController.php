<?php
namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $departments = \App\Models\Department::all();
        // Eager Load ทั้ง department และ position
        $employees = Employee::with(['department', 'position'])->latest()->paginate(10);
        return view('hr.employees.index', compact('employees', 'departments'));
    }

    // --- 1. เพิ่มฟังก์ชัน create เพื่อเปิดหน้าฟอร์ม ---
    public function create()
    {
        $departments = \App\Models\Department::all();
        $positions = \App\Models\Position::all();

        // สร้างรหัสพนักงานอัตโนมัติ (Format: JST-001)
        $latestEmployee = Employee::orderBy('id', 'desc')->first();

        if ($latestEmployee && preg_match('/^JST-(\d+)$/', $latestEmployee->employee_code, $matches)) {
            // ถ้ารหัสล่าสุดคือ JST-005 จะเอาเลข 5 มาบวก 1 แล้วเติม 0 ด้านหน้าให้ครบ 3 หลัก
            $nextNumber = intval($matches[1]) + 1;
            $nextEmployeeCode = 'JST-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        } else {
            // ถ้ายังไม่มีพนักงานเลยในระบบ ให้เริ่มที่ JST-001
            $nextEmployeeCode = 'JST-001';
        }

        // ส่งตัวแปร $nextEmployeeCode ไปที่หน้า View ด้วย
        return view('hr.employees.create', compact('departments', 'positions', 'nextEmployeeCode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_code' => 'required|unique:employees,employee_code|max:50',
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id', // เพิ่มบรรทัดนี้
            'firstname' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
        ], [
            'employee_code.required' => 'กรุณากรอกรหัสพนักงาน',
            'employee_code.unique' => 'รหัสพนักงานนี้มีในระบบแล้ว',
            'department_id.required' => 'กรุณาเลือกแผนก',
            'position_id.required' => 'กรุณาเลือกตำแหน่ง', // เพิ่มแจ้งเตือน
            'firstname.required' => 'กรุณากรอกชื่อ',
            'lastname.required' => 'กรุณากรอกนามสกุล',
        ]);

        $employee = Employee::create($request->all());

        User::create([
            'name' => $request->prefix . $request->firstname . ' ' . $request->lastname,
            'username' => strtolower($request->employee_code),
            'password' => Hash::make('password123'),
            'role' => 'employee',
            'employee_id' => $employee->id
        ]);

        return redirect()->route('hr.employees.index')
            ->with('success', 'เพิ่มพนักงานและสร้างบัญชีผู้ใช้สำเร็จ!');
    }

    public function edit(Employee $employee)
    {
        $departments = \App\Models\Department::all();
        $positions = \App\Models\Position::all(); // ส่งตำแหน่งไปให้หน้าฟอร์มด้วย
        return view('hr.employees.edit', compact('employee', 'departments', 'positions'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'employee_code' => 'required|max:50|unique:employees,employee_code,' . $employee->id,
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id', // เพิ่มบรรทัดนี้
            'firstname' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
        ]);

        $employee->update($request->all());

        if ($employee->user) {
            $employee->user->update([
                'name' => $request->prefix . $request->firstname . ' ' . $request->lastname,
                'username' => strtolower($request->employee_code)
            ]);
        }

        return redirect()->route('hr.employees.index')->with('success', 'อัปเดตข้อมูลพนักงานสำเร็จ!');
    }

    public function destroy(Employee $employee)
    {
        if ($employee->user) {
            $employee->user->delete();
        }
        $employee->delete();
        return redirect()->route('hr.employees.index')->with('success', 'ลบพนักงานออกจากระบบเรียบร้อยแล้ว!');
    }
}