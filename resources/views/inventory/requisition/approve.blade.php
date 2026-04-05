@extends('layouts.app')

@section('title', 'อนุมัติ/ปฏิเสธ ใบเบิก - JST ERP')

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            <i class="fas fa-check-circle me-2" style="color: #818cf8;"></i>อนุมัติ/ปฏิเสธ ใบเบิก #{{ str_pad($requisition->id, 4, '0', STR_PAD_LEFT) }}
        </h4>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">ตรวจสอบและอนุมัติใบเบิก</p>
    </div>
    <a href="{{ route('inventory.requisition.show', $requisition->id) }}" class="erp-btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>กลับ
    </a>
</div>

@if($errors->any())
    <div class="erp-alert erp-alert-danger mb-4" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>{{ $errors->first() }}
    </div>
@endif

<div class="row g-3">
    {{-- Left Column - Requisition Summary --}}
    <div class="col-md-6">
        <div class="erp-card mb-3">
            <div class="erp-card-header">
                <span class="erp-card-title">
                    <i class="fas fa-user me-2" style="color: #818cf8;"></i>ข้อมูลผู้เบิก
                </span>
            </div>
            <div class="erp-card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <th width="120" style="color: var(--text-muted); font-size: 12px;">ผู้เบิก</th>
                        <td style="color: var(--text-secondary);">{{ $requisition->employee->firstname }} {{ $requisition->employee->lastname }}</td>
                    </tr>
                    <tr>
                        <th style="color: var(--text-muted); font-size: 12px;">วันที่เบิก</th>
                        <td style="color: var(--text-secondary);">{{ \Carbon\Carbon::parse($requisition->req_date)->format('d/m/Y') }}</td>
                    </tr>
                    @if($requisition->note)
                    <tr>
                        <th style="color: var(--text-muted); font-size: 12px;">หมายเหตุ</th>
                        <td style="color: var(--text-secondary);">{{ $requisition->note }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>

        <div class="erp-card">
            <div class="erp-card-header">
                <span class="erp-card-title" style="color: #fbbf24;">
                    <i class="fas fa-exclamation-triangle me-2" style="color: #fbbf24;"></i>คำเตือน
                </span>
            </div>
            <div class="erp-card-body">
                <ul class="mb-0" style="color: var(--text-secondary);">
                    <li>อนุมัติ: สินค้าจะถูกหักจากสต๊อกทันที</li>
                    <li>ปฏิเสธ: ใบเบิกจะถูกยกเลิก ไม่มีการหักสต๊อก</li>
                    <li>การดำเนินการไม่สามารถย้อนกลับได้</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Right Column - Items --}}
    <div class="col-md-6">
        <div class="erp-card">
            <div class="erp-card-header">
                <span class="erp-card-title">
                    <i class="fas fa-box me-2" style="color: #818cf8;"></i>รายการสินค้าเบิก
                </span>
            </div>
            <div class="erp-card-body">
                <div class="erp-table-wrap">
                    <table class="erp-table">
                        <thead>
                            <tr>
                                <th>สินค้า</th>
                                <th width="100" style="text-align: center;">จำนวน</th>
                                <th width="100" style="text-align: center;">คงเหลือในสต๊อก</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requisition->items as $item)
                                <tr>
                                    <td style="color: var(--text-secondary);">{{ $item->item->name }}</td>
                                    <td style="text-align: center; color: var(--text-primary);"><strong>{{ $item->quantity_requested }}</strong></td>
                                    <td style="text-align: center;">
                                        @if($item->item->current_stock >= $item->quantity_requested)
                                            <span style="color: #34d399; font-weight: 600;">{{ $item->item->current_stock }}</span>
                                        @else
                                            <span style="color: #f87171; font-weight: 600;">{{ $item->item->current_stock }} (ไม่พอ)</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Approve/Reject Form --}}
<div class="row mt-3">
    <div class="col-12">
        <div class="erp-card">
            <div class="erp-card-header">
                <span class="erp-card-title">
                    <i class="fas fa-file-signature me-2" style="color: #818cf8;"></i>ดำเนินการใบเบิก
                </span>
            </div>
            <div class="erp-card-body">
                <form action="{{ route('inventory.requisition.approve.store', $requisition->id) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="approve_note" class="erp-label">หมายเหตุผู้อนุมัติ</label>
                        <textarea name="approve_note" id="approve_note" rows="3"
                                  class="erp-textarea"
                                  placeholder="บันทึกเพิ่มเติม (ถ้ามี)">{{ old('approve_note') }}</textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('inventory.requisition.show', $requisition->id) }}" class="erp-btn-secondary">
                            <i class="fas fa-times me-2"></i>ยกเลิก
                        </a>
                        <button type="submit" name="action" value="rejected" class="erp-btn-danger"
                                onclick="return confirm('คุณแน่ใจหรือว่าจะปฏิเสธใบเบิกนี้?')">
                            <i class="fas fa-times me-2"></i>ปฏิเสธ
                        </button>
                        <button type="submit" name="action" value="approved" class="erp-btn-primary" style="background: #22c55e; border-color: #22c55e;"
                                onclick="return confirm('คุณแน่ใจหรือว่าจะอนุมัติใบเบิกนี้?')">
                            <i class="fas fa-check me-2"></i>อนุมัติ
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
