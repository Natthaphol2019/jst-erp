@extends('layouts.app')

@section('title', 'สร้างใบเบิกอุปทาน - JST ERP')

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            <i class="fas fa-plus me-2" style="color: #818cf8;"></i>สร้างใบเบิกอุปทาน
        </h4>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">เบิกสินค้าจากคลัง (หักสต๊อกทันที)</p>
    </div>
    <a href="{{ isset($isEmployee) && $isEmployee ? route('employee.dashboard') : route('inventory.requisition.index') }}" class="erp-btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>กลับ
    </a>
</div>

@if($errors->any())
    <div class="erp-alert erp-alert-danger mb-4" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>{{ $errors->first() }}
    </div>
@endif

<form action="{{ route('inventory.requisition.store') }}" method="POST" id="requisitionForm">
    @csrf
    <div class="row g-3">
        {{-- Left Column - Main Info --}}
        <div class="col-md-6">
            <div class="erp-card mb-3">
                <div class="erp-card-header">
                    <span class="erp-card-title">
                        <i class="fas fa-info-circle me-2" style="color: #818cf8;"></i>ข้อมูลใบเบิก
                    </span>
                </div>
                <div class="erp-card-body">
                    <div class="mb-3">
                        <label for="employee_id" class="erp-label">ผู้เบิก <span style="color: #f87171;">*</span></label>
                        @if(isset($isEmployee) && $isEmployee)
                            <input type="text" class="erp-input" value="{{ $employees->first()->employee_code }} - {{ $employees->first()->firstname }} {{ $employees->first()->lastname }}" readonly>
                            <input type="hidden" name="employee_id" value="{{ $employees->first()->id }}">
                        @else
                            <select name="employee_id" id="employee_id" class="erp-select @error('employee_id') is-invalid @enderror" required>
                                <option value="">-- เลือกพนักงาน --</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                        {{ $employee->employee_code }} - {{ $employee->firstname }} {{ $employee->lastname }}
                                    </option>
                                @endforeach
                            </select>
                        @endif
                        @error('employee_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="req_date" class="erp-label">วันที่เบิก <span style="color: #f87171;">*</span></label>
                        <input type="date" name="req_date" id="req_date"
                               class="erp-input @error('req_date') is-invalid @enderror"
                               value="{{ old('req_date', date('Y-m-d')) }}" required>
                        @error('req_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div style="font-size: 11px; color: var(--text-muted); margin-top: 4px;">
                            <i class="fas fa-clock me-1"></i>เวลาปัจจุบัน: <strong id="currentTime">{{ now('Asia/Bangkok')->format('H:i:s') }}</strong> น. (บันทึกอัตโนมัติ)
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="note" class="erp-label">หมายเหตุ</label>
                        <textarea name="note" id="note" rows="3"
                                  class="erp-textarea @error('note') is-invalid @enderror"
                                  placeholder="เหตุผลในการเบิก">{{ old('note') }}</textarea>
                        @error('note')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="erp-alert erp-alert-info">
                        <i class="fas fa-bolt me-2"></i>
                        <strong>หมายเหตุ:</strong> ใบเบิกจะหักสต๊อกทันทีเมื่อกดบันทึก
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column - Items --}}
        <div class="col-md-6">
            <div class="erp-card">
                <div class="erp-card-header d-flex justify-content-between align-items-center">
                    <span class="erp-card-title" style="margin: 0;">
                        <i class="fas fa-box me-2" style="color: #818cf8;"></i>รายการสินค้าเบิก
                    </span>
                    <button type="button" class="erp-btn-secondary" onclick="addItem()" style="padding: 4px 8px; font-size: 12px;">
                        <i class="fas fa-plus me-1"></i>เพิ่มรายการ
                    </button>
                </div>
                <div class="erp-card-body">
                    <div id="items-container">
                        @if(old('items'))
                            @foreach(old('items') as $index => $oldItem)
                                <div class="item-row border rounded p-3 mb-3" style="border-color: var(--border) !important;">
                                    <div class="d-flex justify-content-between mb-2">
                                        <strong style="color: var(--text-primary);">รายการที่ {{ $index + 1 }}</strong>
                                        <button type="button" class="erp-btn-danger" onclick="removeItem(this)" style="padding: 4px 8px; font-size: 12px;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col-md-8 mb-2">
                                            <select name="items[{{ $index }}][item_id]" class="erp-select item-select" required>
                                                <option value="">-- เลือกสินค้า --</option>
                                                @foreach($items as $item)
                                                    <option value="{{ $item->id }}"
                                                            data-stock="{{ $item->current_stock }}"
                                                            {{ $oldItem['item_id'] == $item->id ? 'selected' : '' }}>
                                                        {{ $item->name }} (คงเหลือ: {{ $item->current_stock }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <input type="number" name="items[{{ $index }}][quantity]"
                                                   class="erp-input quantity-input"
                                                   placeholder="จำนวน" min="1"
                                                   value="{{ $oldItem['quantity'] }}" required>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="item-row border rounded p-3 mb-3" style="border-color: var(--border) !important;">
                                <div class="d-flex justify-content-between mb-2">
                                    <strong style="color: var(--text-primary);">รายการที่ 1</strong>
                                    <button type="button" class="erp-btn-danger" onclick="removeItem(this)" style="padding: 4px 8px; font-size: 12px;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <div class="row g-2">
                                    <div class="col-md-8 mb-2">
                                        <select name="items[0][item_id]" class="erp-select item-select" required>
                                            <option value="">-- เลือกสินค้า --</option>
                                            @foreach($items as $item)
                                                <option value="{{ $item->id }}" data-stock="{{ $item->current_stock }}">
                                                    {{ $item->name }} (คงเหลือ: {{ $item->current_stock }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <input type="number" name="items[0][quantity]"
                                               class="erp-input quantity-input"
                                               placeholder="จำนวน" min="1" value="1" required>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="erp-alert erp-alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>คำเตือน:</strong> สต๊อกจะถูกหักทันทีเมื่อบันทึกใบเบิก
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
                        <a href="{{ isset($isEmployee) && $isEmployee ? route('employee.dashboard') : route('inventory.requisition.index') }}" class="erp-btn-secondary">
                            <i class="fas fa-times me-2"></i>ยกเลิก
                        </a>
                        <button type="submit" class="erp-btn-primary">
                            <i class="fas fa-check me-2"></i>เบิกสินค้า
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
// แสดงเวลาปัจจุบันแบบ real-time (Asia/Bangkok)
function updateTime() {
    const now = new Date();
    const options = { timeZone: 'Asia/Bangkok', hour12: false };
    const timeStr = now.toLocaleTimeString('th-TH', options);
    const el = document.getElementById('currentTime');
    if (el) el.textContent = timeStr;
}
updateTime();
setInterval(updateTime, 1000);

let itemIndex = {{ old('items') ? count(old('items')) : 1 }};

function addItem() {
    const container = document.getElementById('items-container');
    const newItem = `
        <div class="item-row border rounded p-3 mb-3" style="border-color: var(--border) !important;">
            <div class="d-flex justify-content-between mb-2">
                <strong style="color: var(--text-primary);">รายการที่ ${itemIndex + 1}</strong>
                <button type="button" class="erp-btn-danger" onclick="removeItem(this)" style="padding: 4px 8px; font-size: 12px;">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            <div class="row g-2">
                <div class="col-md-8 mb-2">
                    <select name="items[${itemIndex}][item_id]" class="erp-select item-select" required>
                        <option value="">-- เลือกสินค้า --</option>
                        @foreach($items as $item)
                            <option value="{{ $item->id }}" data-stock="{{ $item->current_stock }}">
                                {{ $item->name }} (คงเหลือ: {{ $item->current_stock }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-2">
                    <input type="number" name="items[${itemIndex}][quantity]"
                           class="erp-input quantity-input"
                           placeholder="จำนวน" min="1" value="1" required>
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', newItem);
    itemIndex++;
}

function removeItem(button) {
    const itemRow = button.closest('.item-row');
    itemRow.remove();

    const items = document.querySelectorAll('.item-row');
    if (items.length === 0) {
        addItem();
    }
}

document.addEventListener('change', function(e) {
    if (e.target.classList.contains('quantity-input')) {
        const row = e.target.closest('.item-row');
        const select = row.querySelector('.item-select');
        const stock = parseInt(select.selectedOptions[0]?.dataset.stock || 0);
        const quantity = parseInt(e.target.value || 0);

        if (quantity > stock) {
            alert(`จำนวนที่ระบุเกินคงเหลือ (คงเหลือ: ${stock})`);
            e.target.value = stock;
        }
    }
});
</script>
@endpush
@endsection
