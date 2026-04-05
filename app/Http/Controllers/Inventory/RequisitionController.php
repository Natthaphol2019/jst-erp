<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Item;
use App\Models\Requisition;
use App\Models\RequisitionItem;
use App\Models\User;
use App\Notifications\RequisitionSubmitted;
use App\Services\StockService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class RequisitionController extends Controller
{
    protected StockService $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    /**
     * ตรวจสอบสิทธิ์ — employee เข้าถึงได้เฉพาะของตัวเอง
     */
    protected function authorizeRequisition(?Requisition $requisition = null): bool
    {
        $user = auth()->user();

        if (in_array($user->role, ['admin', 'inventory'])) {
            return true;
        }

        if ($user->role === 'employee') {
            if ($requisition === null) {
                return true;
            }

            return $requisition->employee_id === $user->employee_id;
        }

        return false;
    }

    /**
     * แสดงรายการเบิกทั้งหมด
     */
    public function index(Request $request)
    {
        $query = Requisition::with(['employee', 'items.item', 'approver'])
            ->where('req_type', 'consume')
            ->latest();

        // employee เห็นเฉพาะของตัวเอง
        if (auth()->user()->role === 'employee') {
            $query->where('employee_id', auth()->user()->employee_id);
        }

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

        $requisitions = $query->paginate(15);

        return view('inventory.requisition.index', compact('requisitions'));
    }

    /**
     * ฟอร์มสร้างใบเบิก
     */
    public function create()
    {
        $user = auth()->user();
        $isEmployee = $user->role === 'employee';

        if ($isEmployee && ! $user->employee_id) {
            return back()->withErrors(['error' => 'ไม่พบข้อมูลพนักงานของคุณ']);
        }

        $employees = $isEmployee
            ? Employee::where('id', $user->employee_id)->get()
            : Employee::where('status', 'active')->orderBy('firstname')->get();

        // แสดงสินค้าที่เบิกได้: disposable (ใช้แล้วหมดไป) และ consumable
        $items = Item::where('status', 'available')
            ->whereIn('type', ['disposable', 'consumable'])
            ->orderBy('name')
            ->get();

        return view('inventory.requisition.create', compact('employees', 'items', 'isEmployee'));
    }

    /**
     * แสดงรายการเบิกของ employee คนปัจจุบัน (ดูเฉพาะของตัวเอง)
     */
    public function myRequisitions(Request $request)
    {
        $user = auth()->user();
        
        if (!$user->employee_id) {
            return redirect()->route('employee.dashboard')
                ->with('error', 'ไม่พบข้อมูลพนักงานของคุณ');
        }

        $query = Requisition::with(['employee', 'items.item', 'approver'])
            ->where('req_type', 'consume')
            ->where('employee_id', $user->employee_id)
            ->latest();

        // กรองตามสถานะ
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $requisitions = $query->paginate(15);

        return view('inventory.requisition.my_requisitions', compact('requisitions'));
    }

    /**
     * บันทึกใบเบิก — เบิกได้เลย หักสต๊อกทันที
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $isEmployee = $user->role === 'employee';

        $validated = $request->validate([
            'employee_id' => $isEmployee ? 'sometimes|exists:employees,id' : 'required|exists:employees,id',
            'req_date' => 'required|date',
            'note' => 'nullable|string|max:500',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        // ถ้าเป็น employee ใช้ employee_id จาก user เสมอ
        if ($isEmployee) {
            $validated['employee_id'] = $user->employee_id;
        }

        // ใช้เวลาจริงปัจจุบัน (Asia/Bangkok)
        $now = now('Asia/Bangkok');

        // ตรวจสอบสต๊อกเบื้องต้น (ก่อนเข้า transaction)
        try {
            foreach ($validated['items'] as $itemData) {
                $currentStock = $this->stockService->checkStock($itemData['item_id']);
                if ($currentStock < $itemData['quantity']) {
                    $item = Item::find($itemData['item_id']);

                    return back()->withErrors([
                        'items' => "สินค้า {$item->name} มีไม่เพียงพอ (ต้องการ: {$itemData['quantity']}, คงเหลือ: {$currentStock})",
                    ])->withInput();
                }
            }
        } catch (Exception $e) {
            return back()->withErrors(['items' => $e->getMessage()])->withInput();
        }

        DB::beginTransaction();
        try {
            // สร้างใบเบิก — สถานะ 'issued' (เบิกแล้ว) ไม่ต้องรออนุมัติ
            $requisition = Requisition::create([
                'employee_id' => $validated['employee_id'],
                'req_type' => 'consume',
                'status' => 'issued',
                'req_date' => $validated['req_date'],
                'note' => $validated['note'] ?? null,
                'approved_by' => $user->id,
            ]);

            // บันทึกสินค้า + หักสต๊อกทันที
            foreach ($validated['items'] as $itemData) {
                RequisitionItem::create([
                    'requisition_id' => $requisition->id,
                    'item_id' => $itemData['item_id'],
                    'quantity_requested' => $itemData['quantity'],
                    'quantity_returned' => 0,
                ]);

                // หักสต๊อกทันที
                $item = Item::find($itemData['item_id']);
                $this->stockService->deductStock(
                    itemId: $itemData['item_id'],
                    quantity: $itemData['quantity'],
                    transactionType: 'consume_out',
                    requisitionId: $requisition->id,
                    userId: $user->id,
                    remark: "เบิกโดย: {$requisition->employee->firstname} {$requisition->employee->lastname} เมื่อ {$now->format('H:i')} น."
                );
            }

            DB::commit();

            // แจ้งเตือน admin/inventory (เฉพาะกรณี employee เบิก)
            if ($isEmployee) {
                $adminAndInventoryUsers = User::whereIn('role', ['admin', 'inventory'])->get();
                if ($adminAndInventoryUsers->isNotEmpty()) {
                    Notification::send($adminAndInventoryUsers, new RequisitionSubmitted($requisition));
                }
            }

            return redirect()->route('inventory.requisition.show', $requisition->id)
                ->with('success', 'เบิกสินค้าเรียบร้อยแล้ว');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('RequisitionController@store failed', [
                'error' => $e->getMessage(),
                'employee_id' => $validated['employee_id'] ?? null,
                'items' => $validated['items'] ?? null,
            ]);

            return back()->withErrors(['error' => 'เกิดข้อผิดพลาด: '.$e->getMessage()])->withInput();
        }
    }

    /**
     * แสดงรายละเอียดใบเบิก
     */
    public function show(Requisition $requisition)
    {
        if ($requisition->req_type !== 'consume') {
            abort(404, 'ไม่พบข้อมูลใบเบิก');
        }

        if (! $this->authorizeRequisition($requisition)) {
            abort(403, 'คุณไม่มีสิทธิ์ดูข้อมูลนี้');
        }

        $requisition->load(['employee.department', 'employee.position', 'items.item', 'approver']);

        return view('inventory.requisition.show', compact('requisition'));
    }

    /**
     * ฟอร์มแก้ไขใบเบิก (แก้ไขได้เฉพาะสถานะ issued)
     */
    public function edit(Requisition $requisition)
    {
        if ($requisition->req_type !== 'consume') {
            abort(404, 'ไม่พบข้อมูลใบเบิก');
        }

        if (! $this->authorizeRequisition($requisition)) {
            abort(403, 'คุณไม่มีสิทธิ์แก้ไขข้อมูลนี้');
        }

        if ($requisition->status !== 'issued') {
            return back()->withErrors(['error' => 'สามารถแก้ไขได้เฉพาะใบเบิกที่ยังไม่ดำเนินการ']);
        }

        $user = auth()->user();
        $isEmployee = $user->role === 'employee';

        $employees = $isEmployee
            ? Employee::where('id', $user->employee_id)->get()
            : Employee::where('status', 'active')->orderBy('firstname')->get();

        $items = Item::where('status', 'available')
            ->whereIn('type', ['disposable', 'consumable'])
            ->orderBy('name')
            ->get();

        return view('inventory.requisition.edit', compact('requisition', 'employees', 'items', 'isEmployee'));
    }

    /**
     * บันทึกการแก้ไขใบเบิก
     */
    public function update(Request $request, Requisition $requisition)
    {
        if ($requisition->req_type !== 'consume') {
            abort(404, 'ไม่พบข้อมูลใบเบิก');
        }

        if (! $this->authorizeRequisition($requisition)) {
            abort(403, 'คุณไม่มีสิทธิ์แก้ไขข้อมูลนี้');
        }

        if ($requisition->status !== 'issued') {
            return back()->withErrors(['error' => 'สามารถแก้ไขได้เฉพาะใบเบิกที่ยังไม่ดำเนินการ']);
        }

        $user = auth()->user();
        $isEmployee = $user->role === 'employee';

        $validated = $request->validate([
            'employee_id' => $isEmployee ? 'sometimes|exists:employees,id' : 'required|exists:employees,id',
            'req_date' => 'required|date',
            'period' => 'nullable|in:morning,afternoon,evening',
            'note' => 'nullable|string|max:500',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        if ($isEmployee) {
            $validated['employee_id'] = $user->employee_id;
        }

        DB::beginTransaction();
        try {
            // คืนสต๊อกเก่าก่อน
            foreach ($requisition->items as $oldItem) {
                $this->stockService->addStock(
                    itemId: $oldItem->item_id,
                    quantity: $oldItem->quantity_requested,
                    transactionType: 'consume_return',
                    requisitionId: $requisition->id,
                    userId: $user->id,
                    remark: "คืนสต๊อกจากการแก้ไขใบเบิก: {$requisition->employee->firstname} {$requisition->employee->lastname}"
                );
            }

            // ลบรายการเก่า
            $requisition->items()->delete();

            // อัปเดตข้อมูลใบเบิก
            $requisition->update([
                'employee_id' => $validated['employee_id'],
                'req_date' => $validated['req_date'],
                'period' => $validated['period'] ?? null,
                'note' => $validated['note'] ?? null,
            ]);

            // บันทึกสินค้าใหม่ + หักสต๊อก
            foreach ($validated['items'] as $itemData) {
                RequisitionItem::create([
                    'requisition_id' => $requisition->id,
                    'item_id' => $itemData['item_id'],
                    'quantity_requested' => $itemData['quantity'],
                    'quantity_returned' => 0,
                ]);

                $this->stockService->deductStock(
                    itemId: $itemData['item_id'],
                    quantity: $itemData['quantity'],
                    transactionType: 'consume_out',
                    requisitionId: $requisition->id,
                    userId: $user->id,
                    remark: "แก้ไขใบเบิก - เบิกโดย: {$requisition->employee->firstname} {$requisition->employee->lastname}"
                );
            }

            DB::commit();

            return redirect()->route('inventory.requisition.show', $requisition->id)
                ->with('success', 'แก้ไขใบเบิกเรียบร้อยแล้ว');

        } catch (Exception $e) {
            DB::rollBack();

            return back()->withErrors(['error' => 'เกิดข้อผิดพลาด: '.$e->getMessage()])->withInput();
        }
    }

    /**
     * ฟอร์มอนุมัติ/ปฏิเสธ (คงไว้สำหรับ backward compatibility — ไม่ใช้แล้วใน flow ใหม่)
     */
    public function approveForm(Requisition $requisition)
    {
        if ($requisition->req_type !== 'consume') {
            abort(404, 'ไม่พบข้อมูลใบเบิก');
        }

        if ($requisition->status !== 'pending') {
            return back()->withErrors(['error' => 'ใบเบิกนี้ดำเนินการแล้ว']);
        }

        $requisition->load(['employee', 'items.item']);

        return view('inventory.requisition.approve', compact('requisition'));
    }

    /**
     * บันทึกการอนุมัติ (คงไว้สำหรับ backward compatibility)
     */
    public function approve(Request $request, Requisition $requisition)
    {
        if ($requisition->req_type !== 'consume') {
            abort(404, 'ไม่พบข้อมูลใบเบิก');
        }

        if ($requisition->status !== 'pending') {
            return back()->withErrors(['error' => 'ใบเบิกนี้ดำเนินการแล้ว']);
        }

        $validated = $request->validate([
            'action' => 'required|in:approved,rejected',
            'approve_note' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();
        try {
            if ($validated['action'] === 'approved') {
                foreach ($requisition->items as $item) {
                    $this->stockService->deductStock(
                        itemId: $item->item_id,
                        quantity: $item->quantity_requested,
                        transactionType: 'consume_out',
                        requisitionId: $requisition->id,
                        userId: auth()->id(),
                        remark: "เบิกใช้โดย: {$requisition->employee->firstname} {$requisition->employee->lastname}"
                    );
                }

                $requisition->update([
                    'status' => 'approved',
                    'approved_by' => auth()->id(),
                    'note' => $validated['approve_note'] ?? $requisition->note,
                ]);

                $message = 'อนุมัติใบเบิกเรียบร้อยแล้ว';
            } else {
                $requisition->update([
                    'status' => 'rejected',
                    'approved_by' => auth()->id(),
                    'note' => $validated['approve_note'] ?? 'ปฏิเสธใบเบิก',
                ]);

                $message = 'ปฏิเสธใบเบิกเรียบร้อยแล้ว';
            }

            DB::commit();

            return redirect()->route('inventory.requisition.show', $requisition->id)
                ->with('success', $message);

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('RequisitionController@approve failed', [
                'error' => $e->getMessage(),
                'requisition_id' => $requisition->id,
                'action' => $validated['action'] ?? null,
            ]);

            return back()->withErrors(['error' => 'เกิดข้อผิดพลาด: '.$e->getMessage()])->withInput();
        }
    }
}
