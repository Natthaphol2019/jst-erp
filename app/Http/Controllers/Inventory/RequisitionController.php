<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Requisition;
use App\Models\RequisitionItem;
use App\Models\StockTransaction;
use App\Models\Item;
use App\Models\Employee;
use App\Models\User;
use App\Notifications\RequisitionSubmitted;
use App\Notifications\RequisitionApproved;
use App\Notifications\RequisitionRejected;
use App\Services\StockService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Exception;

class RequisitionController extends Controller
{
    protected StockService $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    /**
     * แสดงรายการเบิกทั้งหมด
     */
    public function index(Request $request)
    {
        $query = Requisition::with(['employee', 'items.item', 'approver'])
            ->where('req_type', 'consume')
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

        $requisitions = $query->paginate(15);

        return view('inventory.requisition.index', compact('requisitions'));
    }

    /**
     * ฟอร์มสร้างใบเบิก
     */
    public function create()
    {
        $employees = Employee::where('status', 'active')->orderBy('firstname')->get();
        $items = Item::where('status', 'available')
            ->whereIn('type', ['equipment', 'consumable'])
            ->orderBy('name')
            ->get();

        return view('inventory.requisition.create', compact('employees', 'items'));
    }

    /**
     * บันทึกใบเบิก (สถานะ pending รออนุมัติ)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'req_date' => 'required|date',
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
            // สร้างใบเบิก (สถานะ pending)
            $requisition = Requisition::create([
                'employee_id' => $validated['employee_id'],
                'req_type' => 'consume',
                'status' => 'pending',
                'req_date' => $validated['req_date'],
                'note' => $validated['note'] ?? null,
            ]);

            // บันทึกสินค้าในใบเบิก (ยังไม่หักสต๊อก รออนุมัติ)
            foreach ($validated['items'] as $itemData) {
                RequisitionItem::create([
                    'requisition_id' => $requisition->id,
                    'item_id' => $itemData['item_id'],
                    'quantity_requested' => $itemData['quantity'],
                    'quantity_returned' => 0,
                ]);
            }

            DB::commit();

            // ส่งการแจ้งเตือนให้ admin และ inventory users
            $adminAndInventoryUsers = User::whereIn('role', ['admin', 'inventory'])->get();
            Notification::send($adminAndInventoryUsers, new RequisitionSubmitted($requisition));

            return redirect()->route('inventory.requisition.show', $requisition->id)
                ->with('success', 'สร้างใบเบิกเรียบร้อยแล้ว (รอการอนุมัติ)');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('RequisitionController@store failed', [
                'error' => $e->getMessage(),
                'employee_id' => $validated['employee_id'] ?? null,
                'items' => $validated['items'] ?? null,
            ]);

            return back()->withErrors(['error' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()])->withInput();
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

        $requisition->load(['employee.department', 'employee.position', 'items.item', 'approver']);
        
        return view('inventory.requisition.show', compact('requisition'));
    }

    /**
     * ฟอร์มแก้ไขใบเบิก (แก้ไขได้เฉพาะสถานะ pending)
     */
    public function edit(Requisition $requisition)
    {
        if ($requisition->req_type !== 'consume') {
            abort(404, 'ไม่พบข้อมูลใบเบิก');
        }

        if ($requisition->status !== 'pending') {
            return back()->withErrors(['error' => 'สามารถแก้ไขได้เฉพาะใบเบิกที่รออนุมัติ']);
        }

        $employees = Employee::where('status', 'active')->orderBy('firstname')->get();
        $items = Item::where('status', 'available')
            ->whereIn('type', ['equipment', 'consumable'])
            ->orderBy('name')
            ->get();

        return view('inventory.requisition.edit', compact('requisition', 'employees', 'items'));
    }

    /**
     * บันทึกการแก้ไขใบเบิก
     */
    public function update(Request $request, Requisition $requisition)
    {
        if ($requisition->req_type !== 'consume') {
            abort(404, 'ไม่พบข้อมูลใบเบิก');
        }

        if ($requisition->status !== 'pending') {
            return back()->withErrors(['error' => 'สามารถแก้ไขได้เฉพาะใบเบิกที่รออนุมัติ']);
        }

        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'req_date' => 'required|date',
            'note' => 'nullable|string|max:500',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            // ลบรายการเก่า
            $requisition->items()->delete();

            // อัปเดตข้อมูลใบเบิก
            $requisition->update([
                'employee_id' => $validated['employee_id'],
                'req_date' => $validated['req_date'],
                'note' => $validated['note'] ?? null,
            ]);

            // บันทึกสินค้าใหม่
            foreach ($validated['items'] as $itemData) {
                RequisitionItem::create([
                    'requisition_id' => $requisition->id,
                    'item_id' => $itemData['item_id'],
                    'quantity_requested' => $itemData['quantity'],
                    'quantity_returned' => 0,
                ]);
            }

            DB::commit();

            return redirect()->route('inventory.requisition.show', $requisition->id)
                ->with('success', 'แก้ไขใบเบิกเรียบร้อยแล้ว');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * ฟอร์มอนุมัติ/ปฏิเสธ
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
     * บันทึกการอนุมัติ
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
                // หักสต๊อกโดยใช้ StockService (มี lockForUpdate และตรวจสอบสต๊อกภายใน transaction)
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

                // อัปเดตสถานะเป็น approved
                $requisition->update([
                    'status' => 'approved',
                    'approved_by' => auth()->id(),
                    'note' => $validated['approve_note'] ?? $requisition->note,
                ]);

                $message = 'อนุมัติใบเบิกเรียบร้อยแล้ว';
            } else {
                // ปฏิเสธ
                $requisition->update([
                    'status' => 'rejected',
                    'approved_by' => auth()->id(),
                    'note' => $validated['approve_note'] ?? 'ปฏิเสธใบเบิก',
                ]);

                // ส่งการแจ้งเตือนให้ requester ว่าถูกปฏิเสธ
                if ($requisition->employee && $requisition->employee->user) {
                    $requisition->employee->user->notify(new RequisitionRejected($requisition));
                }

                $message = 'ปฏิเสธใบเบิกเรียบร้อยแล้ว';
            }

            DB::commit();

            // ส่งการแจ้งเตือนให้ requester ว่าอนุมัติแล้ว (เฉพาะกรณี approved)
            if ($validated['action'] === 'approved' && $requisition->employee && $requisition->employee->user) {
                $requisition->employee->user->notify(new RequisitionApproved($requisition));
            }

            return redirect()->route('inventory.requisition.show', $requisition->id)
                ->with('success', $message);

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('RequisitionController@approve failed', [
                'error' => $e->getMessage(),
                'requisition_id' => $requisition->id,
                'action' => $validated['action'] ?? null,
            ]);

            return back()->withErrors(['error' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()])->withInput();
        }
    }
}
