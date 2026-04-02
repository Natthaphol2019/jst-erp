<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    // ==========================================
    // หน้า 1: แสดงรายชื่อพนักงานทั้งหมด + ค้นหา
    // ==========================================
    public function index(Request $request)
    {
        $search = $request->search;
        $department_id = $request->department_id;

        // ดึงข้อมูลพร้อมกับแผนก, ตำแหน่ง และ User (เพื่อเอา Username มาโชว์)
        $query = Employee::with(['department', 'position', 'user']);

        // ระบบค้นหาจากชื่อ, นามสกุล หรือ รหัสพนักงาน
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('firstname', 'LIKE', "%{$search}%")
                    ->orWhere('lastname', 'LIKE', "%{$search}%")
                    ->orWhere('employee_code', 'LIKE', "%{$search}%");
            });
        }

        // ระบบกรองตามแผนก
        if ($department_id) {
            $query->where('department_id', $department_id);
        }

        $employees = $query->orderBy('id', 'desc')->paginate(20);
        $departments = Department::all();

        return view('hr.employees.index', compact('employees', 'departments', 'search', 'department_id'));
    }

    // ==========================================
    // หน้า 2: เปิดฟอร์มเพิ่มพนักงาน
    // ==========================================
    public function create()
    {
        $departments = Department::all();
        $positions = Position::all();

        // สร้างรหัสพนักงานอัตโนมัติ (Format: JST-001)
        $latestEmployee = Employee::orderBy('id', 'desc')->first();

        if ($latestEmployee && preg_match('/^JST-(\d+)$/', $latestEmployee->employee_code, $matches)) {
            $nextNumber = intval($matches[1]) + 1;
            $nextEmployeeCode = 'JST-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        } else {
            $nextEmployeeCode = 'JST-001';
        }

        return view('hr.employees.create', compact('departments', 'positions', 'nextEmployeeCode'));
    }

    // ==========================================
    // หน้า 3: บันทึกข้อมูลพนักงานใหม่ลงฐานข้อมูล
    // ==========================================
    public function store(Request $request)
    {
        $request->validate([
            'employee_code' => 'required|unique:employees,employee_code|max:50',
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
            'prefix' => 'nullable|string|max:10',
            'firstname' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
            'start_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'status' => 'required|in:active,inactive,resigned',
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:admin,hr,manager,employee,inventory' // 🌟 1. รับค่าสิทธิ์การใช้งาน
        ]);

        $employee = Employee::create($request->all());

        $password = $request->filled('password') ? $request->password : 'password123';

        User::create([
            'name' => trim($request->prefix . $request->firstname . ' ' . $request->lastname),
            'username' => strtolower($request->username),
            'password' => \Illuminate\Support\Facades\Hash::make($password),
            'role' => $request->role, // 🌟 2. ใช้ค่า Role ที่ HR เลือกมาเซฟลงฐานข้อมูล
            'employee_id' => $employee->id
        ]);

        return redirect()->route('hr.employees.index')->with('success', 'เพิ่มพนักงานและสร้างบัญชีผู้ใช้สำเร็จ!');
    }
    // ==========================================
    // หน้า 4: เปิดฟอร์มแก้ไขพนักงาน
    // ==========================================
    public function edit(Employee $employee)
    {
        $departments = Department::all();
        $positions = Position::all();

        // ส่งตัวแปร $employee (ข้อมูลพนักงานคนนั้นๆ) ไปที่หน้า view เพื่อให้ฟอร์มดึงข้อมูลเก่ามาโชว์
        return view('hr.employees.edit', compact('employee', 'departments', 'positions'));
    }
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'employee_code' => 'required|max:50|unique:employees,employee_code,' . $employee->id,
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
            'prefix' => 'nullable|string|max:10',
            'firstname' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
            'start_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'status' => 'required|in:active,inactive,resigned',
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:admin,hr,manager,employee,inventory' // 🌟 3. รับค่าสิทธิ์ตอนแก้ไข
        ]);

        $employee->update($request->all());

        if ($employee->user) {
            $userData = [
                'name' => trim($request->prefix . $request->firstname . ' ' . $request->lastname),
                'role' => $request->role, // 🌟 4. อัปเดต Role ให้ด้วย
            ];

            if ($request->filled('password')) {
                $userData['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
            }

            $employee->user->update($userData);
        }

        return redirect()->route('hr.employees.index')->with('success', 'อัปเดตข้อมูลพนักงานสำเร็จ!');
    }

    // ==========================================
    // หน้า 6: ลบ/เปลี่ยนสถานะพนักงาน
    // ==========================================
    public function destroy(Employee $employee)
    {
        if ($employee->user) {
            $employee->user->delete();
        }
        $employee->delete();
        return redirect()->route('hr.employees.index')->with('success', 'ลบพนักงานออกจากระบบเรียบร้อยแล้ว!');
    }
}