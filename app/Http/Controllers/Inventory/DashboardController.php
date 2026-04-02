<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Requisition;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. นับจำนวนรายการรออนุมัติเบิก (เช็กสถานะ pending จากตารางใบเบิก)
        // ถ้าคุณซียังไม่ได้ทำระบบเบิก (Requisition) ให้ใส่ 0 ไว้ก่อนได้ครับ แต่ผมเตรียมเผื่อไว้ให้แล้ว
        $pendingRequisitions = 0;
        if (class_exists(Requisition::class)) {
            $pendingRequisitions = Requisition::where('status', 'pending')->count();
        }

        // 2. นับจำนวนสินค้าทั้งหมดในระบบ
        $totalItems = Item::count();

        // 3. ดึงรายการสินค้าที่ "ใกล้หมดสต๊อก" (current_stock <= min_stock) 
        // เฉพาะสินค้าที่ยัง available อยู่
        $lowStockItems = Item::whereColumn('current_stock', '<=', 'min_stock')
                             ->where('status', 'available')
                             ->get();
        $lowStockCount = $lowStockItems->count();

        // 4. นับจำนวนอุปกรณ์ที่ส่งซ่อมบำรุง (status = 'maintenance')
        $maintenanceCount = Item::where('status', 'maintenance')->count();

        // ส่งตัวแปรทั้งหมดไปที่หน้า View
        return view('inventory.dashboard', compact(
            'pendingRequisitions',
            'totalItems',
            'lowStockCount',
            'maintenanceCount',
            'lowStockItems'
        ));
    }
}