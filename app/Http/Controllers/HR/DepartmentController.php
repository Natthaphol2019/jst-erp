<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::withCount('positions')->with('positions')->paginate(10);

        return view('hr.departments.index', compact('departments'));
    }

    public function create()
    {
        // ดึงแผนกทั้งหมดมาทำ Dropdown สำหรับ Workflow
        $departments = Department::all();
        return view('hr.departments.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:departments,name',
            'description' => 'nullable|string|max:255',
            'next_department_id' => 'nullable|exists:departments,id'
        ], [
            'name.required' => 'กรุณากรอกชื่อแผนก',
            'name.unique' => 'ชื่อแผนกนี้มีในระบบแล้ว',
        ]);

        Department::create($request->all());

        return redirect()->route('hr.departments.index')->with('success', 'เพิ่มแผนกใหม่เรียบร้อยแล้ว!');
    }

    public function edit(Department $department)
    {
        // ดึงแผนกอื่นๆ มาทำ Dropdown (ยกเว้นแผนกตัวเอง ป้องกันการส่งงานวนลูป)
        $departments = Department::where('id', '!=', $department->id)->get();
        return view('hr.departments.edit', compact('department', 'departments'));
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:departments,name,' . $department->id,
            'description' => 'nullable|string|max:255',
            'next_department_id' => 'nullable|exists:departments,id'
        ], [
            'name.required' => 'กรุณากรอกชื่อแผนก',
            'name.unique' => 'ชื่อแผนกนี้มีในระบบแล้ว',
        ]);

        $department->update($request->all());

        return redirect()->route('hr.departments.index')->with('success', 'อัปเดตข้อมูลแผนกสำเร็จ!');
    }

    public function destroy(Department $department)
    {
        // เช็คก่อนว่าแผนกนี้มีตำแหน่งงานอยู่ไหม ถ้ามีห้ามลบ!
        if ($department->positions()->count() > 0) {
            return redirect()->route('hr.departments.index')->with('error', 'ไม่สามารถลบได้! เนื่องจากมีตำแหน่งงานอ้างอิงถึงแผนกนี้อยู่');
        }

        $department->delete();
        return redirect()->route('hr.departments.index')->with('success', 'ลบแผนกเรียบร้อยแล้ว!');
    }
}