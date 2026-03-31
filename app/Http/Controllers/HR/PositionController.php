<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Position;
use App\Models\Department;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index()
    {
        // ดึงข้อมูลตำแหน่ง พร้อมข้อมูลแผนก และนับจำนวนพนักงานในตำแหน่งนั้น
        $positions = Position::with('department')->withCount('employees')->paginate(10);
        return view('hr.positions.index', compact('positions'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('hr.positions.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:100',
            'job_description' => 'nullable|string|max:255',
        ], [
            'department_id.required' => 'กรุณาเลือกแผนก',
            'name.required' => 'กรุณากรอกชื่อตำแหน่ง',
        ]);

        Position::create($request->all());

        return redirect()->route('hr.positions.index')->with('success', 'เพิ่มตำแหน่งงานใหม่เรียบร้อยแล้ว!');
    }

    public function edit(Position $position)
    {
        $departments = Department::all();
        return view('hr.positions.edit', compact('position', 'departments'));
    }

    public function update(Request $request, Position $position)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:100',
            'job_description' => 'nullable|string|max:255',
        ]);

        $position->update($request->all());

        return redirect()->route('hr.positions.index')->with('success', 'อัปเดตข้อมูลตำแหน่งสำเร็จ!');
    }

    public function destroy(Position $position)
    {
        // ป้องกันการลบตำแหน่ง หากมีพนักงานใช้งานอยู่
        if ($position->employees()->count() > 0) {
            return redirect()->route('hr.positions.index')->with('error', 'ไม่สามารถลบได้! เนื่องจากมีพนักงานในตำแหน่งนี้อยู่');
        }

        $position->delete();
        return redirect()->route('hr.positions.index')->with('success', 'ลบตำแหน่งเรียบร้อยแล้ว!');
    }
}