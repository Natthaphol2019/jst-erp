<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Requisition;
use App\Models\User;
use App\Notifications\LowStockAlert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // ตรวจสอบสินค้าที่สต๊อกต่ำกว่าขั้นต่ำและส่งการแจ้งเตือน
        $this->checkLowStockItems();

        // 1. นับจำนวนรายการรออนุมัติเบิก (เช็กสถานะ pending จากตารางใบเบิก)
        $pendingRequisitions = 0;
        if (class_exists(Requisition::class)) {
            $pendingRequisitions = Requisition::where('status', 'pending')->count();
        }

        // 2. นับจำนวนสินค้าทั้งหมดในระบบ
        $totalItems = Item::count();

        // 3. ดึงรายการสินค้าที่ "ใกล้หมดสต๊อก" (current_stock <= min_stock)
        $lowStockItems = Item::whereColumn('current_stock', '<=', 'min_stock')
                             ->where('status', 'available')
                             ->with('category')
                             ->get();
        $lowStockCount = $lowStockItems->count();

        // 4. นับจำนวนอุปกรณ์ที่ส่งซ่อมบำรุง (status = 'maintenance')
        $maintenanceCount = Item::where('status', 'maintenance')->count();

        // 5. นับจำนวนการยืมที่ยังไม่คืน (active borrowings)
        $activeBorrowings = 0;
        if (class_exists(Requisition::class)) {
            $activeBorrowings = Requisition::where('req_type', 'borrow')
                ->whereIn('status', ['approved', 'returned_partial'])
                ->count();
        }

        // 6. รายการสินค้าคงเหลือล่าสุด (last 10 stock transactions)
        $recentTransactions = \App\Models\StockTransaction::with(['item', 'creator'])
            ->latest()
            ->take(10)
            ->get();

        // 7. หมวดหมู่สินค้าพร้อมจำนวน
        $categories = \App\Models\ItemCategory::withCount('items')->get();

        // ส่งตัวแปรทั้งหมดไปที่หน้า View
        return view('inventory.dashboard', compact(
            'pendingRequisitions',
            'totalItems',
            'lowStockCount',
            'maintenanceCount',
            'lowStockItems',
            'activeBorrowings',
            'recentTransactions',
            'categories'
        ));
    }

    /**
     * ตรวจสอบสินค้าที่สต๊อกต่ำกว่าขั้นต่ำและส่งการแจ้งเตือน
     */
    protected function checkLowStockItems(): void
    {
        $lowStockItems = Item::whereColumn('current_stock', '<', 'min_stock')
            ->where('status', 'available')
            ->get();

        foreach ($lowStockItems as $item) {
            // ตรวจสอบว่าเคยส่งแจ้งเตือนไปแล้วหรือยัง (ภายในวันนี้)
            $adminUsers = User::whereIn('role', ['admin', 'inventory'])->get();

            $hasNotifiedToday = false;
            foreach ($adminUsers as $admin) {
                $existing = $admin->notifications()
                    ->where('type', LowStockAlert::class)
                    ->whereDate('created_at', Carbon::today())
                    ->whereJsonContains('data->item_id', $item->id)
                    ->exists();
                if ($existing) {
                    $hasNotifiedToday = true;
                    break;
                }
            }

            if (!$hasNotifiedToday) {
                Notification::send($adminUsers, new LowStockAlert($item));
            }
        }
    }
}