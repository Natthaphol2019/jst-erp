<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\StockTransaction;
use App\Models\Item;
use App\Models\ItemCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockTransactionController extends Controller
{
    /**
     * แสดงประวัติเคลื่อนไหวสต๊อก
     */
    public function index(Request $request)
    {
        $query = StockTransaction::with(['item.category', 'requisition', 'creator']);

        // กรองตามวันที่
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // กรองตามสินค้า
        if ($request->filled('item_id')) {
            $query->where('item_id', $request->item_id);
        }

        // กรองตามหมวดหมู่
        if ($request->filled('category_id')) {
            $query->whereHas('item', function ($q) use ($request) {
                $q->where('category_id', $request->category_id);
            });
        }

        // กรองตามประเภท
        if ($request->filled('transaction_type')) {
            $query->where('transaction_type', $request->transaction_type);
        }

        // ค้นหาตาม remark
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('remark', 'like', "%{$search}%");
        }

        $transactions = $query->latest()->paginate(20);

        // ดึงข้อมูลสำหรับ filter
        $items = Item::orderBy('name')->get();
        $categories = ItemCategory::orderBy('name')->get();

        return view('inventory.transactions.index', compact('transactions', 'items', 'categories'));
    }

    /**
     * แสดงรายละเอียด transaction
     */
    public function show(StockTransaction $transaction)
    {
        $transaction->load(['item.category', 'requisition.employee', 'requisition.items.item', 'creator']);

        return view('inventory.transactions.show', compact('transaction'));
    }

    /**
     * สรุปยอดสต๊อกปัจจุบัน
     */
    public function summary(Request $request)
    {
        $query = Item::with(['category'])
            ->select('items.*')
            ->addSelect([
                'total_in' => DB::raw('(SELECT COALESCE(SUM(CASE WHEN transaction_type IN ("in", "borrow_return") THEN quantity ELSE 0 END), 0) FROM stock_transactions WHERE stock_transactions.item_id = items.id)'),
                'total_out' => DB::raw('(SELECT COALESCE(SUM(CASE WHEN transaction_type IN ("out", "borrow_out", "consume_out") THEN quantity ELSE 0 END), 0) FROM stock_transactions WHERE stock_transactions.item_id = items.id)'),
            ]);

        // กรองตามหมวดหมู่
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // กรองตามสถานะ
        if ($request->filled('status')) {
            if ($request->status === 'low_stock') {
                $query->whereColumn('current_stock', '<=', 'min_stock');
            } elseif ($request->status === 'available') {
                $query->where('current_stock', '>', 0);
            } elseif ($request->status === 'zero') {
                $query->where('current_stock', '=', 0);
            }
        }

        // ค้นหา
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('item_code', 'like', "%{$search}%");
            });
        }

        $items = $query->orderBy('name')->paginate(20);

        $categories = ItemCategory::orderBy('name')->get();

        // สรุปภาพรวม
        $overview = [
            'total_items' => Item::count(),
            'total_value' => Item::sum(DB::raw('current_stock * COALESCE((SELECT price FROM item_prices WHERE item_prices.item_id = items.id ORDER BY created_at DESC LIMIT 1), 0)')),
            'low_stock_count' => Item::whereColumn('current_stock', '<=', 'min_stock')->count(),
            'zero_stock_count' => Item::where('current_stock', '=', 0)->count(),
        ];

        return view('inventory.transactions.summary', compact('items', 'categories', 'overview'));
    }

    /**
     * รายงานสต๊อกเข้า-ออก รายวัน
     */
    public function dailyReport(Request $request)
    {
        $date = $request->input('date', now()->format('Y-m-d'));

        $dailyStats = StockTransaction::select(
                'transaction_type',
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(quantity) as total_quantity')
            )
            ->whereDate('created_at', $date)
            ->groupBy('transaction_type')
            ->get();

        $transactions = StockTransaction::with(['item', 'creator'])
            ->whereDate('created_at', $date)
            ->latest()
            ->get();

        return view('inventory.transactions.daily_report', compact('dailyStats', 'transactions', 'date'));
    }

    /**
     * รายงานสต๊อกตามหมวดหมู่
     */
    public function categoryReport(Request $request)
    {
        $categoryStats = ItemCategory::withCount(['items'])
            ->withSum('items as total_stock', 'current_stock')
            ->orderBy('name')
            ->get();

        return view('inventory.transactions.category_report', compact('categoryStats'));
    }
}
