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
        // ถ้าเป็น employee role ให้ redirect ไป dashboard
        if (auth()->user()->role === 'employee') {
            return redirect()->route('employee.dashboard')
                ->with('error', 'พนักงานไม่สามารถแก้ไขข้อมูลส่วนตัวได้ กรุณาติดต่อ HR/Admin');
        }

        $employee = Employee::where('id', Auth::user()->employee_id)->first();

        return view('profile.edit', compact('employee'));
    }

    /**
     * บันทึกการแก้ไขโปรไฟล์
     */
    public function update(Request $request)
    {
        // ถ้าเป็น employee role ให้ redirect กลับ
        if (auth()->user()->role === 'employee') {
            return redirect()->route('employee.dashboard')
                ->with('error', 'พนักงานไม่สามารถแก้ไขข้อมูลส่วนตัวได้ กรุณาติดต่อ HR/Admin');
        }

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
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'remove_image' => 'nullable|boolean',
        ]);

        // จัดการอัปโหลดรูปภาพ
        if ($request->hasFile('profile_image')) {
            // ลบรูปเก่าถ้ามี
            if ($employee->profile_image) {
                \Storage::disk('public')->delete($employee->profile_image);
            }

            $image = $request->file('profile_image');
            $imageName = 'employees/' . time() . '_' . uniqid() . '_' . $image->getClientOriginalName();
            
            // สร้าง directory ถ้ายังไม่มี
            $targetDir = storage_path('app/public/employees');
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

            $image->move($targetDir, basename($imageName));
            $validated['profile_image'] = 'employees/' . basename($imageName);
        } elseif ($request->boolean('remove_image')) {
            // ลบรูปถ้าผู้ใช้ต้องการลบ
            if ($employee->profile_image) {
                \Storage::disk('public')->delete($employee->profile_image);
            }
            $validated['profile_image'] = null;
        } else {
            // ไม่ต้องอัปเดตรูปภาพ
            unset($validated['profile_image']);
        }

        // อัปเดตข้อมูลพนักงาน
        $employee->update([
            'prefix' => $validated['prefix'] ?? $employee->prefix,
            'firstname' => $validated['firstname'],
            'lastname' => $validated['lastname'],
            'gender' => $validated['gender'],
            'phone' => $validated['phone'] ?? $employee->phone,
            'address' => $validated['address'] ?? $employee->address,
            'profile_image' => $validated['profile_image'] ?? $employee->profile_image,
        ]);

        // อัปเดตข้อมูลผู้ใช้ (email)
        if (!empty($validated['email'])) {
            $user->update(['email' => $validated['email']]);
        }

        // อัปเดตชื่อใน user table
        $user->update([
            'name' => trim(($validated['prefix'] ?? $employee->prefix) . ' ' . $validated['firstname'] . ' ' . $validated['lastname']),
        ]);

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
