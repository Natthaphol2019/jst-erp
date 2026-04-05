@extends('layouts.app')

@section('title', 'คืนสินค้า - JST ERP')

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            <i class="fas fa-undo me-2" style="color: #818cf8;"></i>คืนสินค้า - ใบยืม #{{ str_pad($borrowing->id, 4, '0', STR_PAD_LEFT) }}
        </h4>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">บันทึกการคืนสินค้ายืม</p>
    </div>
    <a href="{{ route('inventory.borrowing.show', $borrowing->id) }}" class="erp-btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>กลับ
    </a>
</div>

@if($errors->any())
    <div class="erp-alert erp-alert-danger mb-4" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>{{ $errors->first() }}
    </div>
@endif

<form action="{{ route('inventory.borrowing.return.store', $borrowing->id) }}" method="POST">
    @csrf

    <div class="row g-3">
        {{-- Left Column - Borrowing Summary --}}
        <div class="col-md-5">
            <div class="erp-card mb-3">
                <div class="erp-card-header">
                    <span class="erp-card-title">
                        <i class="fas fa-user me-2" style="color: #818cf8;"></i>ข้อมูลผู้ยืม
                    </span>
                </div>
                <div class="erp-card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <th width="120" style="color: var(--text-muted); font-size: 12px;">ผู้ยืม</th>
                            <td style="color: var(--text-secondary);">{{ $borrowing->employee->firstname }} {{ $borrowing->employee->lastname }}</td>
                        </tr>
                        <tr>
                            <th style="color: var(--text-muted); font-size: 12px;">วันที่ยืม</th>
                            <td style="color: var(--text-secondary);">{{ \Carbon\Carbon::parse($borrowing->req_date)->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <th style="color: var(--text-muted); font-size: 12px;">กำหนดคืน</th>
                            <td>
                                <span style="color: var(--text-secondary);">{{ \Carbon\Carbon::parse($borrowing->due_date)->format('d/m/Y') }}</span>
                                @php
                                    $isOverdue = in_array($borrowing->status, ['approved', 'returned_partial']) && now()->gt(\Carbon\Carbon::parse($borrowing->due_date));
                                @endphp
                                @if($isOverdue)
                                    <span class="erp-badge" style="background: rgba(239,68,68,0.12); color: #f87171; margin-left: 8px;">เกินกำหนด</span>
                                @endif
                            </td>
                        </tr>
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
                        <li>ตรวจสอบจำนวนสินค้าที่คืนให้ถูกต้อง</li>
                        <li>สินค้าที่คืนจะกลับเข้าสต๊อกทันที</li>
                        <li>สามารถคืนได้บางส่วนหรือทั้งหมด</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Right Column - Return Items --}}
        <div class="col-md-7">
            <div class="erp-card">
                <div class="erp-card-header">
                    <span class="erp-card-title">
                        <i class="fas fa-box me-2" style="color: #818cf8;"></i>รายการคืนสินค้า
                    </span>
                </div>
                <div class="erp-card-body">
                    <div class="erp-table-wrap">
                        <table class="erp-table">
                            <thead>
                                <tr>
                                    <th>สินค้า</th>
                                    <th width="80" style="text-align: center;">ยืม</th>
                                    <th width="80" style="text-align: center;">คืนแล้ว</th>
                                    <th width="80" style="text-align: center;">ยังไม่ได้คืน</th>
                                    <th width="100" style="text-align: center;">จำนวนคืน</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($borrowing->items as $index => $item)
                                    @php
                                        $canReturn = $item->quantity_requested - $item->quantity_returned;
                                    @endphp
                                    @if($canReturn > 0)
                                    <tr>
                                        <td style="color: var(--text-secondary);">{{ $item->item->name }}</td>
                                        <td style="text-align: center; color: var(--text-secondary);">{{ $item->quantity_requested }}</td>
                                        <td style="text-align: center; color: var(--text-secondary);">{{ $item->quantity_returned }}</td>
                                        <td style="text-align: center;"><strong style="color: #f87171;">{{ $canReturn }}</strong></td>
                                        <td style="text-align: center;">
                                            <input type="number"
                                                   name="return_items[{{ $index }}][requisition_item_id]"
                                                   value="{{ $item->id }}"
                                                   class="d-none">
                                            <input type="number"
                                                   name="return_items[{{ $index }}][return_quantity]"
                                                   class="erp-input return-quantity-input"
                                                   style="width: 80px; margin: 0 auto;"
                                                   min="1"
                                                   max="{{ $canReturn }}"
                                                   value="{{ $canReturn }}"
                                                   data-max="{{ $canReturn }}"
                                                   required>
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mb-3 mt-4">
                        <label for="actual_return_date" class="erp-label">วันที่คืนจริง <span style="color: #f87171;">*</span></label>
                        <input type="date" name="actual_return_date" id="actual_return_date"
                               class="erp-input @error('actual_return_date') is-invalid @enderror"
                               value="{{ old('actual_return_date', date('Y-m-d')) }}" required>
                        @error('actual_return_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="return_note" class="erp-label">หมายเหตุการคืน</label>
                        <textarea name="return_note" id="return_note" rows="3"
                                  class="erp-textarea @error('return_note') is-invalid @enderror"
                                  placeholder="บันทึกสภาพสินค้า หรือหมายเหตุ (ถ้ามี)">{{ old('return_note') }}</textarea>
                        @error('return_note')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Submit Button --}}
    <div class="row mt-3">
        <div class="col-12">
            <div class="erp-card">
                <div class="erp-card-body">
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('inventory.borrowing.show', $borrowing->id) }}" class="erp-btn-secondary">
                            <i class="fas fa-times me-2"></i>ยกเลิก
                        </a>
                        <button type="submit" class="erp-btn-primary" style="background: #22c55e; border-color: #22c55e;">
                            <i class="fas fa-check me-2"></i>บันทึกการคืน
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
document.addEventListener('input', function(e) {
    if (e.target.classList.contains('return-quantity-input')) {
        const max = parseInt(e.target.dataset.max || 0);
        const value = parseInt(e.target.value || 0);

        if (value > max) {
            alert(`จำนวนคืนเกินที่ยังไม่ได้คืน (สูงสุด: ${max})`);
            e.target.value = max;
        }

        if (value < 1) {
            e.target.value = 1;
        }
    }
});
</script>
@endpush
@endsection
