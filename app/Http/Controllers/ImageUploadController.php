<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploadController extends Controller
{
    /**
     * อัปโหลดรูปพนักงาน
     */
    public function uploadEmployeeImage(Request $request, Employee $employee)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // ลบรูปเก่าถ้ามี
        if ($employee->profile_image) {
            Storage::disk('public')->delete($employee->profile_image);
        }

        // อัปโหลดรูปใหม่
        $file = $request->file('profile_image');
        $filename = 'employee_' . $employee->id . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('employees', $filename, 'public');

        // บันทึก path ลง database
        $employee->update(['profile_image' => $path]);

        return back()->with('success', 'อัปโหลดรูปโปรไฟล์เรียบร้อยแล้ว');
    }

    /**
     * ลบรูปพนักงาน
     */
    public function deleteEmployeeImage(Employee $employee)
    {
        if ($employee->profile_image) {
            Storage::disk('public')->delete($employee->profile_image);
            $employee->update(['profile_image' => null]);
        }

        return back()->with('success', 'ลบรูปโปรไฟล์เรียบร้อยแล้ว');
    }

    /**
     * อัปโหลดรูปสินค้า
     */
    public function uploadItemImage(Request $request, Item $item)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // ลบรูปเก่าถ้ามี
        if ($item->image_url) {
            Storage::disk('public')->delete($item->image_url);
        }

        // อัปโหลดรูปใหม่
        $file = $request->file('image');
        $filename = 'item_' . $item->id . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('products', $filename, 'public');

        // บันทึก path ลง database
        $item->update(['image_url' => $path]);

        return back()->with('success', 'อัปโหลดรูปสินค้าเรียบร้อยแล้ว');
    }

    /**
     * ลบรูปสินค้า
     */
    public function deleteItemImage(Item $item)
    {
        if ($item->image_url) {
            Storage::disk('public')->delete($item->image_url);
            $item->update(['image_url' => null]);
        }

        return back()->with('success', 'ลบรูปสินค้าเรียบร้อยแล้ว');
    }

    /**
     * แสดงรูปภาพ (สำหรับแสดงในหน้าเว็บ)
     */
    public function showImage($type, $filename)
    {
        $path = "{$type}/{$filename}";
        
        if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }

        $file = Storage::disk('public')->get($path);
        $mimeType = Storage::disk('public')->mimeType($path);

        return response($file, 200)->header('Content-Type', $mimeType);
    }
}
