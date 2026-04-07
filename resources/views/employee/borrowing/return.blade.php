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
    <a href="{{ route('employee.borrowing.show', $borrowing->id) }}" class="erp-btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>กลับ
    </a>
</div>

@if($errors->any())
    <div class="erp-alert erp-alert-danger mb-4" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>{{ $errors->first() }}
    </div>
@endif

<form action="{{ route('employee.borrowing.return.store', $borrowing->id) }}" method="POST" enctype="multipart/form-data">
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
                    <div style="background: var(--bg-surface); border: 1px solid var(--border); border-radius: 10px; overflow: hidden;">
                        <div style="display: flex; flex-direction: column;">
                            <div class="info-row" style="display: flex; border-bottom: 1px solid var(--border);">
                                <div style="width: 120px; padding: 12px 16px; background: var(--bg-raised); font-size: 12px; color: var(--text-muted); font-weight: 500; flex-shrink: 0;">
                                    <i class="fas fa-user me-1" style="color: var(--accent);"></i>ผู้ยืม
                                </div>
                                <div style="flex: 1; padding: 12px 16px; font-size: 13px; color: var(--text-secondary);">
                                    {{ $borrowing->employee->firstname }} {{ $borrowing->employee->lastname }}
                                </div>
                            </div>
                            <div class="info-row" style="display: flex; border-bottom: 1px solid var(--border);">
                                <div style="width: 120px; padding: 12px 16px; background: var(--bg-raised); font-size: 12px; color: var(--text-muted); font-weight: 500; flex-shrink: 0;">
                                    <i class="fas fa-calendar me-1" style="color: var(--accent);"></i>วันที่ยืม
                                </div>
                                <div style="flex: 1; padding: 12px 16px; font-size: 13px; color: var(--text-secondary);">
                                    {{ \Carbon\Carbon::parse($borrowing->req_date)->format('d/m/Y') }}
                                </div>
                            </div>
                            <div class="info-row" style="display: flex;">
                                <div style="width: 120px; padding: 12px 16px; background: var(--bg-raised); font-size: 12px; color: var(--text-muted); font-weight: 500; flex-shrink: 0;">
                                    <i class="fas fa-calendar-check me-1" style="color: var(--accent);"></i>กำหนดคืน
                                </div>
                                <div style="flex: 1; padding: 12px 16px; font-size: 13px; color: var(--text-secondary); display: flex; align-items: center; gap: 8px;">
                                    <span>{{ \Carbon\Carbon::parse($borrowing->due_date)->format('d/m/Y') }}</span>
                                    @php
                                        $isOverdue = in_array($borrowing->status, ['approved', 'returned_partial']) && now()->gt(\Carbon\Carbon::parse($borrowing->due_date));
                                    @endphp
                                    @if($isOverdue)
                                        <span class="erp-badge" style="background: rgba(239,68,68,0.12); color: #f87171;">เกินกำหนด</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
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
                    @if($borrowing->items->isEmpty())
                        <div class="alert alert-warning text-center">
                            <i class="fas fa-exclamation-triangle me-2"></i>ไม่มีรายการสินค้าในใบยืมนี้
                        </div>
                    @else
                        <div class="erp-table-wrap">
                            <table class="erp-table">
                                <thead>
                                    <tr>
                                        <th width="60" style="text-align: center;">รูป</th>
                                        <th>สินค้า</th>
                                        <th width="80" style="text-align: center;">ยืม</th>
                                        <th width="80" style="text-align: center;">คืนแล้ว</th>
                                        <th width="80" style="text-align: center;">ยังไม่ได้คืน</th>
                                        <th width="100" style="text-align: center;">จำนวนคืน</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $hasItems = false; @endphp
                                    @foreach($borrowing->items as $index => $item)
                                        @php
                                            $canReturn = $item->quantity_requested - $item->quantity_returned;
                                            if ($canReturn > 0) $hasItems = true;
                                        @endphp
                                        @if($canReturn > 0)
                                        <tr>
                                            <td style="text-align: center;">
                                                @if($item->item && $item->item->image_url)
                                                    <img src="{{ asset('storage/' . $item->item->image_url) }}" 
                                                         alt="{{ $item->item->name }}"
                                                         style="width: 45px; height: 45px; object-fit: cover; border-radius: 6px; border: 1px solid var(--border);"
                                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                    <div style="display: none; width: 45px; height: 45px; border-radius: 6px; background: var(--input-bg); align-items: center; justify-content: center; color: var(--text-muted);">
                                                        <i class="fas fa-image"></i>
                                                    </div>
                                                @else
                                                    <div style="width: 45px; height: 45px; border-radius: 6px; background: var(--input-bg); display: flex; align-items: center; justify-content: center; color: var(--text-muted); margin: 0 auto;">
                                                        <i class="fas fa-image"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td style="color: var(--text-secondary);">
                                                <div style="font-weight: 500;">{{ $item->item->name ?? 'ไม่มีข้อมูลสินค้า' }}</div>
                                                @if($item->item && $item->item->item_code)
                                                    <small style="color: var(--text-muted);">{{ $item->item->item_code }}</small>
                                                @endif
                                            </td>
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
                                    @if(!$hasItems)
                                        <tr>
                                            <td colspan="6" class="text-center py-3" style="color: var(--text-muted);">
                                                <i class="fas fa-check-circle me-2"></i>คืนสินค้าครบทั้งหมดแล้ว
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    @endif

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

                    <div class="mb-3">
                        <label for="return_images" class="erp-label">
                            <i class="fas fa-camera me-1" style="color: #6366f1;"></i>หลักฐานการคืน (รูปภาพ)
                        </label>
                        <div style="background: var(--bg-raised); border: 2px dashed var(--border); border-radius: 10px; padding: 20px; text-align: center;">
                            <input type="file" name="return_images[]" id="return_images" 
                                   class="d-none" accept="image/*" multiple
                                   onchange="previewReturnImages(this)">
                            <label for="return_images" style="cursor: pointer; display: block;">
                                <i class="fas fa-cloud-upload-alt" style="font-size: 32px; color: #6366f1; margin-bottom: 8px;"></i>
                                <div style="color: var(--text-secondary); font-size: 13px;">คลิกเพื่อเลือกรูปภาพ หรือลากรูปมาวางที่นี่</div>
                                <div style="color: var(--text-muted); font-size: 11px; margin-top: 4px;">รองรับไฟล์: JPG, PNG, GIF (สูงสุด 5 รูป, รูปละไม่เกิน 5MB)</div>
                            </label>
                        </div>
                        <div id="imagePreviewContainer" class="d-flex flex-wrap gap-2 mt-2" style="min-height: 20px;"></div>
                        @error('return_images.*')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
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
                        <a href="{{ route('employee.borrowing.show', $borrowing->id) }}" class="erp-btn-secondary">
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
// Preview รูปภาพที่เลือก
function previewReturnImages(input) {
    const container = document.getElementById('imagePreviewContainer');
    container.innerHTML = '';
    
    if (input.files && input.files.length > 5) {
        alert('สามารถอัพโหลดได้สูงสุด 5 รูปเท่านั้น');
        input.value = '';
        return;
    }
    
    Array.from(input.files).forEach((file) => {
        if (file.size > 5 * 1024 * 1024) {
            alert(`ไฟล์ ${file.name} มีขนาดเกิน 5MB`);
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'position-relative';
            div.style.width = '80px';
            div.style.height = '80px';
            div.innerHTML = `
                <img src="${e.target.result}" class="img-thumbnail" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                <button type="button" class="btn-close position-absolute top-0 end-0" 
                        style="font-size: 8px; background: white; border-radius: 50%; padding: 4px;" 
                        onclick="this.parentElement.remove()"></button>
            `;
            container.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
}

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
