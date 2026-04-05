<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * แสดงฟอร์มแก้ไขโปรไฟล์ตัวเอง
     */
    public function edit()
    {
        $employee = Employee::where('id', Auth::user()->employee_id)->first();
        
        return view('profile.edit', compact('employee'));
    }

    /**
     * บันทึกการแก้ไขโปรไฟล์
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $employee = Employee::where('id', $user->employee_id)->first();

        if (!$employee) {
            return back()->withErrors(['error' => 'ไม่พบข้อมูลพนักงาน']);
        }

        $validated = $request->validate([
            'prefix' => 'nullable|string|max:10',
            'firstname' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
            'gender' => 'required|in:male,female,other',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255|unique:users,email,' . $user->id,
            'address' => 'nullable|string|max:500',
        ]);

        // อัปเดตข้อมูลพนักงาน
        $employee->update([
            'prefix' => $validated['prefix'] ?? $employee->prefix,
            'firstname' => $validated['firstname'],
            'lastname' => $validated['lastname'],
            'gender' => $validated['gender'],
            'phone' => $validated['phone'] ?? $employee->phone,
            'address' => $validated['address'] ?? $employee->address,
        ]);

        // อัปเดตข้อมูลผู้ใช้ (email)
        if (!empty($validated['email'])) {
            $user->update(['email' => $validated['email']]);
        }

        return redirect()->route('profile.edit')
            ->with('success', 'อัปเดตข้อมูลส่วนตัวเรียบร้อยแล้ว');
    }

    /**
     * แสดงฟอร์มเปลี่ยนรหัสผ่าน
     */
    public function changePassword()
    {
        return view('profile.change-password');
    }

    /**
     * บันทึกรหัสผ่านใหม่
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();

        // ตรวจสอบรหัสผ่านเก่า
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'รหัสผ่านเก่าไม่ถูกต้อง']);
        }

        // ตรวจสอบว่ารหัสผ่านใหม่ไม่ซ้ำกับรหัสผ่านเก่า
        if ($validated['current_password'] === $validated['new_password']) {
            return back()->withErrors(['new_password' => 'รหัสผ่านใหม่ต้องไม่ซ้ำกับรหัสผ่านเก่า']);
        }

        // อัปเดตรหัสผ่าน
        $user->update([
            'password' => Hash::make($validated['new_password']),
        ]);

        return redirect()->route('profile.change-password')
            ->with('success', 'เปลี่ยนรหัสผ่านเรียบร้อยแล้ว');
    }
}
