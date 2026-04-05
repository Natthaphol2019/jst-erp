<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Requisition;
use App\Models\RequisitionItem;
use App\Models\StockTransaction;
use App\Models\Item;
use App\Models\Employee;
use App\Models\User;
use App\Notifications\BorrowingOverdue;
use App\Notifications\LowStockAlert;
use App\Services\StockService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;
use Exception;

class BorrowingController extends Controller
{
    protected StockService $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    /**
     * แสดงรายการยืมทั้งหมด
     */
    public function index(Request $request)
    {
        // ตรวจสอบใบยืมที่เกินกำหนดและส่งการแจ้งเตือน
        $this->checkOverdueBorrowings();

        // ตรวจสอบสินค้าที่สต๊อกต่ำกว่าขั้นต่ำและส่งการแจ้งเตือน
        $this->checkLowStockItems();

        $query = Requisition::with(['employee', 'items.item', 'approver'])
            ->where('req_type', 'borrow')
            ->latest();

        // กรองตามสถานะ
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // ค้นหาตามชื่อพนักงาน
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('employee', function ($q) use ($search) {
                $q->where('firstname', 'like', "%{$search}%")
                  ->orWhere('lastname', 'like', "%{$search}%")
                  ->orWhere('employee_code', 'like', "%{$search}%");
            });
        }

        $borrowings = $query->paginate(15);

        // นับจำนวนใบยืมที่เกินกำหนด
        $overdueCount = Requisition::where('req_type', 'borrow')
            ->whereIn('status', ['approved', 'returned_partial'])
            ->where('due_date', '<', Carbon::today())
            ->count();

        return view('inventory.borrowing.index', compact('borrowings', 'overdueCount'));
    }

    /**
     * แสดงรายการยืมของ employee คนปัจจุบัน (ดูเฉพาะของตัวเอง)
     */
    public function myBorrowings(Request $request)
    {
        $user = auth()->user();
        
        if (!$user->employee_id) {
            return redirect()->route('employee.dashboard')
                ->with('error', 'ไม่พบข้อมูลพนักงานของคุณ');
        }

        $query = Requisition::with(['employee', 'items.item', 'approver'])
            ->where('req_type', 'borrow')
            ->where('employee_id', $user->employee_id)
            ->latest();

        // กรองตามสถานะ
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $borrowings = $query->paginate(15);

        // นับจำนวนใบยืมที่เกินกำหนดของตัวเอง
        $overdueCount = Requisition::where('req_type', 'borrow')
            ->where('employee_id', $user->employee_id)
            ->whereIn('status', ['approved', 'returned_partial'])
            ->where('due_date', '<', Carbon::today())
            ->count();

        return view('inventory.borrowing.my_borrowings', compact('borrowings', 'overdueCount'));
    }

    /**
     * ฟอร์มสร้างใบยืมสำหรับ employee
     */
    public function createForEmployee()
    {
        $user = auth()->user();
        
        if (!$user->employee_id) {
            return redirect()->route('employee.dashboard')
                ->with('error', 'ไม่พบข้อมูลพนักงานของคุณ');
        }

        $employees = Employee::where('id', $user->employee_id)->get();
        $items = Item::where('status', 'available')
            ->where('type', 'equipment')
            ->orderBy('name')
            ->get();

        return view('inventory.borrowing.create_employee', compact('employees', 'items'));
    }

    /**
     * ตรวจสอบใบยืมที่เกินกำหนดและส่งการแจ้งเตือน
     */
    protected function checkOverdueBorrowings(): void
    {
        $overdueBorrowings = Requisition::with('employee')
            ->where('req_type', 'borrow')
            ->whereIn('status', ['approved', 'returned_partial'])
            ->where('due_date', '<', Carbon::today())
            ->get();

        foreach ($overdueBorrowings as $borrowing) {
            // ตรวจสอบว่าเคยส่งแจ้งเตือนไปแล้วหรือยัง (ภายในวันนี้)
            if ($borrowing->employee && $borrowing->employee->user) {
                $existingNotification = $borrowing->employee->user
                    ->notifications()
                    ->where('type', BorrowingOverdue::class)
                    ->whereDate('created_at', Carbon::today())
                    ->whereJsonContains('data->borrowing_id', $borrowing->id)
                    ->exists();

                if (!$existingNotification) {
                    $borrowing->employee->user->notify(new BorrowingOverdue($borrowing));
                }
            }
        }

        // แจ้งเตือน admin เกี่ยวกับใบยืมเกินกำหนด
        if ($overdueBorrowings->isNotEmpty()) {
            $adminUsers = User::whereIn('role', ['admin', 'inventory'])->get();
            foreach ($overdueBorrowings as $borrowing) {
                $requester = $borrowing->employee;
                $name = $requester ? "{$requester->firstname} {$requester->lastname}" : 'ไม่ระบุ';

                // ส่งแจ้งเตือนให้ admin เฉพาะใบยืมที่ยังไม่แจ้งเตือนวันนี้
                $hasNotifiedToday = false;
                foreach ($adminUsers as $admin) {
                    $existing = $admin->notifications()
                        ->where('type', BorrowingOverdue::class)
                        ->whereDate('created_at', Carbon::today())
                        ->whereJsonContains('data->borrowing_id', $borrowing->id)
                        ->exists();
                    if ($existing) {
                        $hasNotifiedToday = true;
                        break;
                    }
                }

                if (!$hasNotifiedToday) {
                    Notification::send($adminUsers, new BorrowingOverdue($borrowing));
                }
            }
        }
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

    /**
     * ฟอร์มสร้างใบยืม
     */
    public function create()
    {
        $employees = Employee::where('status', 'active')->orderBy('firstname')->get();
        $items = Item::where('status', 'available')
            ->where('type', 'equipment')
            ->orderBy('name')
            ->get();

        return view('inventory.borrowing.create', compact('employees', 'items'));
    }

    /**
     * บันทึกใบยืม
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'borrow_date' => 'required|date',
            'expected_return_date' => 'required|date|after_or_equal:borrow_date',
            'note' => 'nullable|string|max:500',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        // ตรวจสอบสต๊อกเบื้องต้น (ก่อนเข้า transaction)
        try {
            foreach ($validated['items'] as $itemData) {
                $currentStock = $this->stockService->checkStock($itemData['item_id']);
                if ($currentStock < $itemData['quantity']) {
                    $item = Item::find($itemData['item_id']);
                    return back()->withErrors([
                        'items' => "สินค้า {$item->name} มีไม่เพียงพอ (ต้องการ: {$itemData['quantity']}, คงเหลือ: {$currentStock})"
                    ])->withInput();
                }
            }
        } catch (Exception $e) {
            return back()->withErrors(['items' => $e->getMessage()])->withInput();
        }

        DB::beginTransaction();
        try {
            // สร้างใบยืม
            $borrowing = Requisition::create([
                'employee_id' => $validated['employee_id'],
                'req_type' => 'borrow',
                'status' => 'approved', // ยืมไม่ต้องอนุมัติ
                'req_date' => $validated['borrow_date'],
                'due_date' => $validated['expected_return_date'],
                'note' => $validated['note'] ?? null,
                'approved_by' => auth()->id(),
            ]);

            // เตรียมข้อมูลสินค้าสำหรับหักสต๊อก
            $stockItems = [];
            foreach ($validated['items'] as $itemData) {
                $stockItems[] = [
                    'item_id' => $itemData['item_id'],
                    'quantity' => $itemData['quantity'],
                ];

                // เพิ่มรายการสินค้าในใบยืม
                RequisitionItem::create([
                    'requisition_id' => $borrowing->id,
                    'item_id' => $itemData['item_id'],
                    'quantity_requested' => $itemData['quantity'],
                    'quantity_returned' => 0,
                ]);
            }

            // หักสต๊อกโดยใช้ StockService (มี lockForUpdate และตรวจสอบสต๊อกภายใน transaction)
            foreach ($stockItems as $itemData) {
                $this->stockService->deductStock(
                    itemId: $itemData['item_id'],
                    quantity: $itemData['quantity'],
                    transactionType: 'borrow_out',
                    requisitionId: $borrowing->id,
                    userId: auth()->id(),
                    remark: "ยืมโดย: {$borrowing->employee->firstname} {$borrowing->employee->lastname}"
                );
            }

            DB::commit();

            return redirect()->route('inventory.borrowing.show', $borrowing->id)
                ->with('success', 'สร้างใบยืมเรียบร้อยแล้ว');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('BorrowingController@store failed', [
                'error' => $e->getMessage(),
                'employee_id' => $validated['employee_id'] ?? null,
                'items' => $validated['items'] ?? null,
            ]);

            return back()->withErrors(['error' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * แสดงรายละเอียดใบยืม
     */
    public function show(Requisition $borrowing)
    {
        if ($borrowing->req_type !== 'borrow') {
            abort(404, 'ไม่พบข้อมูลใบยืม');
        }

        $borrowing->load(['employee.department', 'employee.position', 'items.item', 'approver']);
        
        return view('inventory.borrowing.show', compact('borrowing'));
    }

    /**
     * ฟอร์มแก้ไขใบยืม (แก้ไขได้เฉพาะสถานะ pending/borrowed)
     */
    public function edit(Requisition $borrowing)
    {
        if ($borrowing->req_type !== 'borrow') {
            abort(404, 'ไม่พบข้อมูลใบยืม');
        }

        if (in_array($borrowing->status, ['returned_all', 'rejected'])) {
            return back()->withErrors(['error' => 'ไม่สามารถแก้ไขใบยืมที่เสร็จสิ้นแล้วได้']);
        }

        $employees = Employee::where('status', 'active')->orderBy('firstname')->get();
        $items = Item::where('status', 'available')
            ->where('type', 'equipment')
            ->orderBy('name')
            ->get();

        return view('inventory.borrowing.edit', compact('borrowing', 'employees', 'items'));
    }

    /**
     * บันทึกการแก้ไขใบยืม
     */
    public function update(Request $request, Requisition $borrowing)
    {
        if ($borrowing->req_type !== 'borrow') {
            abort(404, 'ไม่พบข้อมูลใบยืม');
        }

        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'borrow_date' => 'required|date',
            'expected_return_date' => 'required|date|after_or_equal:borrow_date',
            'note' => 'nullable|string|max:500',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            // คืนสต๊อกเก่าก่อน (ใช้ StockService)
            foreach ($borrowing->items as $oldItem) {
                $returnedQty = $oldItem->quantity_returned ?? 0;
                $borrowedQty = $oldItem->quantity_requested - $returnedQty;

                if ($borrowedQty > 0) {
                    $this->stockService->addStock(
                        itemId: $oldItem->item_id,
                        quantity: $borrowedQty,
                        transactionType: 'borrow_return',
                        requisitionId: $borrowing->id,
                        userId: auth()->id(),
                        remark: "คืนสต๊อกจากการแก้ไขใบยืม: {$borrowing->employee->firstname} {$borrowing->employee->lastname}"
                    );
                }
            }

            // ลบรายการเก่า
            $borrowing->items()->delete();

            // อัปเดตข้อมูลใบยืม
            $borrowing->update([
                'employee_id' => $validated['employee_id'],
                'req_date' => $validated['borrow_date'],
                'due_date' => $validated['expected_return_date'],
                'note' => $validated['note'] ?? null,
            ]);

            // บันทึกสินค้าใหม่ และ หักสต๊อก
            foreach ($validated['items'] as $itemData) {
                RequisitionItem::create([
                    'requisition_id' => $borrowing->id,
                    'item_id' => $itemData['item_id'],
                    'quantity_requested' => $itemData['quantity'],
                    'quantity_returned' => 0,
                ]);

                // หักสต๊อกโดยใช้ StockService
                $this->stockService->deductStock(
                    itemId: $itemData['item_id'],
                    quantity: $itemData['quantity'],
                    transactionType: 'borrow_out',
                    requisitionId: $borrowing->id,
                    userId: auth()->id(),
                    remark: "แก้ไขใบยืม - ยืมโดย: {$borrowing->employee->firstname} {$borrowing->employee->lastname}"
                );
            }

            DB::commit();

            return redirect()->route('inventory.borrowing.show', $borrowing->id)
                ->with('success', 'แก้ไขใบยืมเรียบร้อยแล้ว');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('BorrowingController@update failed', [
                'error' => $e->getMessage(),
                'borrowing_id' => $borrowing->id,
                'items' => $validated['items'] ?? null,
            ]);

            return back()->withErrors(['error' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * ฟอร์มคืนสินค้า
     */
    public function returnForm(Requisition $borrowing)
    {
        if ($borrowing->req_type !== 'borrow') {
            abort(404, 'ไม่พบข้อมูลใบยืม');
        }

        if ($borrowing->status === 'returned_all') {
            return back()->withErrors(['error' => 'ใบยืมนี้คืนสินค้าครบแล้ว']);
        }

        $borrowing->load(['employee', 'items.item']);

        return view('inventory.borrowing.return', compact('borrowing'));
    }

    /**
     * บันทึกการคืนสินค้า
     */
    public function returnStore(Request $request, Requisition $borrowing)
    {
        if ($borrowing->req_type !== 'borrow') {
            abort(404, 'ไม่พบข้อมูลใบยืม');
        }

        $validated = $request->validate([
            'return_items' => 'required|array|min:1',
            'return_items.*.requisition_item_id' => 'required|exists:requisition_items,id',
            'return_items.*.return_quantity' => 'required|integer|min:1',
            'actual_return_date' => 'required|date',
            'return_note' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();
        try {
            $allReturned = true;

            foreach ($validated['return_items'] as $returnData) {
                $requisitionItem = RequisitionItem::findOrFail($returnData['requisition_item_id']);

                // ตรวจสอบจำนวนคืน
                $canReturn = $requisitionItem->quantity_requested - $requisitionItem->quantity_returned;
                if ($returnData['return_quantity'] > $canReturn) {
                    throw new Exception("จำนวนคืนเกินที่ยืมไว้ (สินค้า ID: {$requisitionItem->item_id})");
                }

                // อัปเดตจำนวนที่คืน
                $newReturnedQty = $requisitionItem->quantity_returned + $returnData['return_quantity'];
                $requisitionItem->update(['quantity_returned' => $newReturnedQty]);

                // คืนสต๊อกโดยใช้ StockService (มี lockForUpdate ภายใน transaction)
                $item = Item::find($requisitionItem->item_id);
                $this->stockService->addStock(
                    itemId: $requisitionItem->item_id,
                    quantity: $returnData['return_quantity'],
                    transactionType: 'borrow_return',
                    requisitionId: $borrowing->id,
                    userId: auth()->id(),
                    remark: "คืนสินค้า: {$item->name}" . ($validated['return_note'] ? " - {$validated['return_note']}" : '')
                );

                // ตรวจสอบว่าคืนครบหรือยัง
                if ($newReturnedQty < $requisitionItem->quantity_requested) {
                    $allReturned = false;
                }
            }

            // อัปเดตสถานะใบยืม
            if ($allReturned) {
                $borrowing->update([
                    'status' => 'returned_all',
                ]);
            } else {
                $borrowing->update([
                    'status' => 'returned_partial',
                ]);
            }

            DB::commit();

            return redirect()->route('inventory.borrowing.show', $borrowing->id)
                ->with('success', 'บันทึกการคืนสินค้าเรียบร้อยแล้ว');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('BorrowingController@returnStore failed', [
                'error' => $e->getMessage(),
                'borrowing_id' => $borrowing->id,
                'return_items' => $validated['return_items'] ?? null,
            ]);

            return back()->withErrors(['error' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()])->withInput();
        }
    }
}
