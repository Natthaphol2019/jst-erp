@extends('layouts.app')

@section('title', 'อนุมัติรายการ - JST ERP')

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            <i class="fas fa-clipboard-check me-2" style="color: #818cf8;"></i>อนุมัติรายการ
        </h4>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">
            ตรวจสอบและอนุมัติ/ปฏิเสธรายการ
        </p>
    </div>
    <a href="{{ route('manager.approval.index') }}" class="erp-btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>กลับ
    </a>
</div>

@if(session('success'))
    <div class="erp-alert erp-alert-success mb-4" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="erp-alert erp-alert-danger mb-4" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>{{ $errors->first() }}
    </div>
@endif

<div class="row g-3">
    {{-- Left Column - Request Info --}}
    <div class="col-lg-6">
        <div class="erp-card mb-3">
            <div class="erp-card-header">
                <span class="erp-card-title">
                    <i class="fas fa-file-invoice me-2" style="color: #818cf8;"></i>ข้อมูลคำขอ
                </span>
            </div>
            <div class="erp-card-body">
                <div style="background: var(--bg-surface); border: 1px solid var(--border); border-radius: 10px; overflow: hidden;">
                    <div style="display: flex; flex-direction: column;">
                        <div style="display: flex; border-bottom: 1px solid var(--border);">
                            <div style="width: 150px; padding: 12px 16px; background: var(--bg-raised); font-size: 12px; color: var(--text-muted); font-weight: 500; flex-shrink: 0;">
                                <i class="fas fa-file-invoice me-1" style="color: var(--accent);"></i>เลขที่
                            </div>
                            <div style="flex: 1; padding: 12px 16px; font-size: 14px; font-weight: 600; color: var(--text-primary);">
                                #{{ str_pad($requisition->id, 4, '0', STR_PAD_LEFT) }}
                            </div>
                        </div>
                        <div style="display: flex; border-bottom: 1px solid var(--border);">
                            <div style="width: 150px; padding: 12px 16px; background: var(--bg-raised); font-size: 12px; color: var(--text-muted); font-weight: 500; flex-shrink: 0;">
                                <i class="fas fa-calendar me-1" style="color: var(--accent);"></i>วันที่
                            </div>
                            <div style="flex: 1; padding: 12px 16px; font-size: 13px; color: var(--text-secondary);">
                                {{ \Carbon\Carbon::parse($requisition->req_date)->format('d/m/Y') }}
                            </div>
                        </div>
                        <div style="display: flex; border-bottom: 1px solid var(--border);">
                            <div style="width: 150px; padding: 12px 16px; background: var(--bg-raised); font-size: 12px; color: var(--text-muted); font-weight: 500; flex-shrink: 0;">
                                <i class="fas fa-circle-dot me-1" style="color: var(--accent);"></i>ประเภท
                            </div>
                            <div style="flex: 1; padding: 12px 16px;">
                                @if($requisition->req_type === 'borrow')
                                    <span class="erp-badge" style="background: rgba(99,102,241,0.12); color: #818cf8;">
                                        <i class="fas fa-hand-holding me-1"></i>ยืม-คืน
                                    </span>
                                @else
                                    <span class="erp-badge" style="background: rgba(251,191,36,0.12); color: #f59e0b;">
                                        <i class="fas fa-box-open me-1"></i>เบิก
                                    </span>
                                @endif
                            </div>
                        </div>
                        @if($requisition->req_type === 'borrow' && $requisition->due_date)
                        <div style="display: flex; border-bottom: 1px solid var(--border);">
                            <div style="width: 150px; padding: 12px 16px; background: var(--bg-raised); font-size: 12px; color: var(--text-muted); font-weight: 500; flex-shrink: 0;">
                                <i class="fas fa-calendar-check me-1" style="color: var(--accent);"></i>กำหนดคืน
                            </div>
                            <div style="flex: 1; padding: 12px 16px; font-size: 13px; color: var(--text-secondary);">
                                {{ \Carbon\Carbon::parse($requisition->due_date)->format('d/m/Y') }}
                            </div>
                        </div>
                        @endif
                        @if($requisition->note)
                        <div style="display: flex;">
                            <div style="width: 150px; padding: 12px 16px; background: var(--bg-raised); font-size: 12px; color: var(--text-muted); font-weight: 500; flex-shrink: 0;">
                                <i class="fas fa-comment me-1" style="color: var(--accent);"></i>หมายเหตุ
                            </div>
                            <div style="flex: 1; padding: 12px 16px; font-size: 13px; color: var(--text-secondary);">
                                {{ $requisition->note }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Employee Info --}}
        <div class="erp-card">
            <div class="erp-card-header">
                <span class="erp-card-title">
                    <i class="fas fa-user me-2" style="color: #818cf8;"></i>ข้อมูลผู้ขอ
                </span>
            </div>
            <div class="erp-card-body">
                <div style="background: var(--bg-surface); border: 1px solid var(--border); border-radius: 10px; overflow: hidden;">
                    <div style="display: flex; flex-direction: column;">
                        <div style="display: flex; border-bottom: 1px solid var(--border);">
                            <div style="width: 150px; padding: 12px 16px; background: var(--bg-raised); font-size: 12px; color: var(--text-muted); font-weight: 500; flex-shrink: 0;">
                                <i class="fas fa-id-badge me-1" style="color: var(--accent);"></i>รหัสพนักงาน
                            </div>
                            <div style="flex: 1; padding: 12px 16px; font-size: 13px; color: var(--text-secondary);">
                                {{ $requisition->employee->employee_code }}
                            </div>
                        </div>
                        <div style="display: flex; border-bottom: 1px solid var(--border);">
                            <div style="width: 150px; padding: 12px 16px; background: var(--bg-raised); font-size: 12px; color: var(--text-muted); font-weight: 500; flex-shrink: 0;">
                                <i class="fas fa-user me-1" style="color: var(--accent);"></i>ชื่อ-นามสกุล
                            </div>
                            <div style="flex: 1; padding: 12px 16px; font-size: 14px; color: var(--text-primary); font-weight: 500;">
                                {{ $requisition->employee->firstname }} {{ $requisition->employee->lastname }}
                            </div>
                        </div>
                        @if($requisition->employee->department)
                        <div style="display: flex; border-bottom: 1px solid var(--border);">
                            <div style="width: 150px; padding: 12px 16px; background: var(--bg-raised); font-size: 12px; color: var(--text-muted); font-weight: 500; flex-shrink: 0;">
                                <i class="fas fa-building me-1" style="color: var(--accent);"></i>แผนก
                            </div>
                            <div style="flex: 1; padding: 12px 16px; font-size: 13px; color: var(--text-secondary);">
                                {{ $requisition->employee->department->name }}
                            </div>
                        </div>
                        @endif
                        @if($requisition->employee->position)
                        <div style="display: flex;">
                            <div style="width: 150px; padding: 12px 16px; background: var(--bg-raised); font-size: 12px; color: var(--text-muted); font-weight: 500; flex-shrink: 0;">
                                <i class="fas fa-briefcase me-1" style="color: var(--accent);"></i>ตำแหน่ง
                            </div>
                            <div style="flex: 1; padding: 12px 16px; font-size: 13px; color: var(--text-secondary);">
                                {{ $requisition->employee->position->name }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Right Column - Items & Actions --}}
    <div class="col-lg-6">
        <div class="erp-card mb-3">
            <div class="erp-card-header">
                <span class="erp-card-title">
                    <i class="fas fa-box me-2" style="color: #818cf8;"></i>รายการสินค้า
                </span>
            </div>
            <div class="erp-card-body">
                <div class="erp-table-wrap">
                    <table class="erp-table">
                        <thead>
                            <tr>
                                <th>สินค้า</th>
                                <th width="80" style="text-align: center;">จำนวน</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requisition->items as $item)
                                <tr>
                                    <td style="color: var(--text-secondary);">
                                        <div style="font-weight: 500;">{{ $item->item->name }}</div>
                                        @if($item->item->item_code)
                                            <small style="color: var(--text-muted);">{{ $item->item->item_code }}</small>
                                        @endif
                                    </td>
                                    <td style="text-align: center; font-weight: 600; color: var(--text-primary);">
                                        {{ $item->quantity_requested }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>รวม</th>
                                <th style="text-align: center; color: var(--text-primary);">
                                    {{ $requisition->items->sum('quantity_requested') }}
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        {{-- Approval Actions --}}
        <div class="erp-card" style="border: 2px solid #818cf8;">
            <div class="erp-card-header" style="background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);">
                <span class="erp-card-title" style="color: #4f46e5;">
                    <i class="fas fa-gavel me-2"></i>ดำเนินการ
                </span>
            </div>
            <div class="erp-card-body">
                <p style="font-size: 14px; color: var(--text-secondary); margin-bottom: 20px;">
                    กรุณาตรวจสอบรายละเอียดและเลือกดำเนินการด้านล่าง
                </p>

                <div class="d-flex gap-3">
                    {{-- Approve Button --}}
                    <form action="{{ route('manager.approval.approve', $requisition->id) }}" method="POST" class="flex-grow-1">
                        @csrf
                        <div class="mb-3">
                            <label for="approval_note" class="erp-label">หมายเหตุการอนุมัติ (ถ้ามี)</label>
                            <textarea name="approval_note" id="approval_note" rows="3"
                                      class="erp-input"
                                      placeholder="ข้อมูลเพิ่มเติม...">{{ old('approval_note') }}</textarea>
                        </div>
                        <button type="submit" class="erp-btn-primary w-100"
                                style="background: linear-gradient(135deg, #10b981, #059669); border: none;"
                                onclick="return confirm('ยืนยันการอนุมัติรายการนี้?')">
                            <i class="fas fa-check-circle me-2"></i>อนุมัติ
                        </button>
                    </form>

                    {{-- Reject Button --}}
                    <button type="button" class="erp-btn-secondary flex-grow-1"
                            style="background: #ef4444; border-color: #ef4444; color: white;"
                            onclick="showRejectModal()">
                        <i class="fas fa-times-circle me-2"></i>ปฏิเสธ
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Reject Modal --}}
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: #fef2f2;">
                <h5 class="modal-title" id="rejectModalLabel" style="color: #dc2626;">
                    <i class="fas fa-times-circle me-2"></i>ปฏิเสธรายการ
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('manager.approval.reject', $requisition->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert" style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 12px; color: #991b1b; font-size: 13px; margin-bottom: 16px;">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        การปฏิเสธจะไม่สามารถย้อนกลับได้ กรุณาระบุเหตุผลในการปฏิเสธ
                    </div>
                    <div class="mb-3">
                        <label for="rejection_note" class="form-label" style="font-weight: 600;">
                            เหตุผลในการปฏิเสธ <span style="color: #ef4444;">*</span>
                        </label>
                        <textarea class="form-control" id="rejection_note" name="rejection_note" rows="4"
                                  required placeholder="ระบุเหตุผลในการปฏิเสธ..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="erp-btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="erp-btn-secondary" style="background: #ef4444; border-color: #ef4444; color: white;">
                        <i class="fas fa-times-circle me-2"></i>ยืนยันปฏิเสธ
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function showRejectModal() {
    const modal = new bootstrap.Modal(document.getElementById('rejectModal'));
    modal.show();
}
</script>
@endpush
@endsection
