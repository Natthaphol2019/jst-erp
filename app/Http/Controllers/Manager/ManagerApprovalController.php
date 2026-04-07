<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Requisition;
use App\Models\RequisitionItem;
use App\Models\Employee;
use App\Models\User;
use App\Notifications\RequisitionApproved;
use App\Notifications\RequisitionRejected;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;
use Exception;

class ManagerApprovalController extends Controller
{
    /**
     * แสดงรายการที่รอการอนุมัติ (เฉพาะแผนกที่ตัวเองเป็นหัวหน้า)
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        // หาแผนกที่ผู้ใช้เป็นหัวหน้า
        $managedDepartmentIds = $user->managedDepartments()->pluck('id');

        if ($managedDepartmentIds->isEmpty()) {
            return redirect()->route('manager.dashboard')
                ->with('error', 'คุณไม่มีสิทธิ์อนุมัติแผนกใด');
        }

        // หาพนักงานในแผนกที่ดูแล
        $employeeIds = Employee::whereIn('department_id', $managedDepartmentIds)->pluck('id');

        // Query รายการที่รอการอนุมัติ
        $query = Requisition::with(['employee', 'items.item', 'approver'])
            ->whereIn('employee_id', $employeeIds)
            ->where('status', 'pending')
            ->latest();

        // กรองตามประเภท
        if ($request->filled('type')) {
            $query->where('req_type', $request->type);
        }

        $pendingItems = $query->paginate(15);

        // นับจำนวนแยกตามประเภท
        $pendingByType = [
            'borrow' => Requisition::whereIn('employee_id', $employeeIds)
                ->where('req_type', 'borrow')
                ->where('status', 'pending')
                ->count(),
            'consume' => Requisition::whereIn('employee_id', $employeeIds)
                ->where('req_type', 'consume')
                ->where('status', 'pending')
                ->count(),
        ];

        return view('manager.approval.index', compact('pendingItems', 'pendingByType'));
    }

    /**
     * แสดงรายละเอียดเพื่ออนุมัติ/ปฏิเสธ
     */
    public function show(Requisition $requisition)
    {
        $user = auth()->user();

        // ตรวจสอบว่าผู้ใช้มีสิทธิ์อนุมัติหรือไม่
        if (!$this->canApprove($user, $requisition)) {
            abort(403, 'คุณไม่มีสิทธิ์อนุมัติรายการนี้');
        }

        $requisition->load(['employee.department', 'items.item']);

        return view('manager.approval.show', compact('requisition'));
    }

    /**
     * อนุมัติรายการ
     */
    public function approve(Request $request, Requisition $requisition)
    {
        $user = auth()->user();

        // ตรวจสอบว่าผู้ใช้มีสิทธิ์อนุมัติหรือไม่
        if (!$this->canApprove($user, $requisition)) {
            abort(403, 'คุณไม่มีสิทธิ์อนุมัติรายการนี้');
        }

        if ($requisition->status !== 'pending') {
            return back()->withErrors(['error' => 'รายการนี้ถูกดำเนินการไปแล้ว']);
        }

        $validated = $request->validate([
            'approval_note' => 'nullable|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            // ตรวจสอบสต๊อกก่อนอนุมัติ (เฉพาะใบเบิกที่ต้องหักสต๊อก)
            if ($requisition->req_type === 'consume') {
                foreach ($requisition->items as $item) {
                    $availableStock = $item->item->current_stock - $item->item->getReservedQuantity();
                    // ลบเฉพาะที่จองไว้จากใบอื่น (ไม่รวมใบนี้เพราะกำลังจะอนุมัติ)
                    $reservedFromOthers = $item->item->getReservedQuantity() - $item->quantity_requested;
                    $availableForThis = $item->item->current_stock - max(0, $reservedFromOthers);

                    if ($availableForThis < $item->quantity_requested) {
                        throw new Exception(
                            "สินค้า {$item->item->name} มีไม่เพียงพอ " .
                            "(ต้องการ: {$item->quantity_requested}, พร้อมใช้: {$availableForThis})"
                        );
                    }
                }
            }

            // อัพเดทสถานะ
            $requisition->update([
                'status' => 'approved',
                'approved_by' => $user->id,
                'note' => $validated['approval_note'] ?? $requisition->note,
            ]);

            // หักสต๊อกเฉพาะใบเบิก (consume)
            if ($requisition->req_type === 'consume') {
                $stockService = app(\App\Services\StockService::class);
                foreach ($requisition->items as $item) {
                    $stockService->deductStock(
                        itemId: $item->item_id,
                        quantity: $item->quantity_requested,
                        transactionType: 'consume_out',
                        requisitionId: $requisition->id,
                        userId: $user->id,
                        remark: "เบิกโดย: {$requisition->employee->firstname} {$requisition->employee->lastname}"
                    );
                }
            }

            // ส่งการแจ้งเตือนถึงพนักงาน
            $employee = $requisition->employee;
            if ($employee && $employee->user) {
                Notification::send($employee->user, new RequisitionApproved($requisition));
            }

            // ส่งการแจ้งเตือนถึง admin/inventory (ถ้ามี)
            $adminUsers = User::whereIn('role', ['admin', 'inventory'])->get();
            Notification::send($adminUsers, new \App\Notifications\RequisitionApproved($requisition));

            DB::commit();

            return redirect()->route('manager.approval.index')
                ->with('success', 'อนุมัติรายการเรียบร้อยแล้ว');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Manager approval failed', [
                'error' => $e->getMessage(),
                'requisition_id' => $requisition->id,
                'manager_id' => $user->id,
            ]);

            return back()->withErrors(['error' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()]);
        }
    }

    /**
     * ปฏิเสธรายการ
     */
    public function reject(Request $request, Requisition $requisition)
    {
        $user = auth()->user();

        // ตรวจสอบว่าผู้ใช้มีสิทธิ์อนุมัติหรือไม่
        if (!$this->canApprove($user, $requisition)) {
            abort(403, 'คุณไม่มีสิทธิ์อนุมัติรายการนี้');
        }

        if ($requisition->status !== 'pending') {
            return back()->withErrors(['error' => 'รายการนี้ถูกดำเนินการไปแล้ว']);
        }

        $validated = $request->validate([
            'rejection_note' => 'required|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            // อัพเดทสถานะ
            $requisition->update([
                'status' => 'rejected',
                'approved_by' => $user->id,
                'note' => $validated['rejection_note'],
            ]);

            // ส่งการแจ้งเตือนถึงพนักงาน
            $employee = $requisition->employee;
            if ($employee && $employee->user) {
                Notification::send($employee->user, new RequisitionRejected($requisition));
            }

            DB::commit();

            return redirect()->route('manager.approval.index')
                ->with('success', 'ปฏิเสธรายการเรียบร้อยแล้ว');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Manager rejection failed', [
                'error' => $e->getMessage(),
                'requisition_id' => $requisition->id,
                'manager_id' => $user->id,
            ]);

            return back()->withErrors(['error' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()]);
        }
    }

    /**
     * ตรวจสอบว่าผู้ใช้มีสิทธิ์อนุมัติรายการนี้หรือไม่
     */
    private function canApprove(User $user, Requisition $requisition): bool
    {
        // Admin อนุมัติได้ทุกอย่าง
        if ($user->role === 'admin') {
            return true;
        }

        // Manager อนุมัติได้เฉพาะแผนกที่ตัวเองเป็นหัวหน้า
        $managedDepartmentIds = $user->managedDepartments()->pluck('id');

        if ($managedDepartmentIds->isEmpty()) {
            return false;
        }

        $employee = $requisition->employee;

        if (!$employee) {
            return false;
        }

        return in_array($employee->department_id, $managedDepartmentIds);
    }
}
