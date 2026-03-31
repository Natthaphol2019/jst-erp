<?php
namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        // ดึงข้อมูลพนักงานทั้งหมด พร้อมกับข้อมูลแผนก (Eager Loading เพื่อลดจำนวน Query)
        // และเรียงลำดับจากพนักงานที่เพิ่งเพิ่มล่าสุด
        $employees = Employee::with('department')->latest()->paginate(10);

        // โยนข้อมูลไปที่หน้า View ในโฟลเดอร์ hr/employees
        return view('hr.employees.index', compact('employees'));
    }

    // ... (ฟังก์ชันอื่นๆ ปล่อยว่างไว้ก่อนได้ครับ)
}