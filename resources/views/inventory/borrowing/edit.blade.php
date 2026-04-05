@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h2>
                <i class="bi bi-pencil me-2"></i>แก้ไขใบยืม
            </h2>
        </div>
        <div class="col text-end">
            <a href="{{ route('inventory.borrowing.show', $borrowing->id) }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i>กลับ
            </a>
        </div>
    </div>

    {{-- Error Messages --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-1"></i>{{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('inventory.borrowing.update', $borrowing->id) }}" method="POST" id="borrowingForm">
        @csrf
        @method('PUT')
        <div class="row">
            {{-- Left Column - Main Info --}}
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                        <i class="bi bi-info-circle me-1"></i>ข้อมูลใบยืม
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="employee_id" class="form-label required">ผู้ยืม</label>
                            <select name="employee_id" id="employee_id" class="form-select @error('employee_id') is-invalid @enderror" required>
                                <option value="">-- เลือกพนักงาน --</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}" {{ old('employee_id', $borrowing->employee_id) == $employee->id ? 'selected' : '' }}>
                                        {{ $employee->employee_code }} - {{ $employee->firstname }} {{ $employee->lastname }}
                                    </option>
                                @endforeach
                            </select>
                            @error('employee_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="borrow_date" class="form-label required">วันที่ยืม</label>
                                <input type="date" name="borrow_date" id="borrow_date" 
                                       class="form-control @error('borrow_date') is-invalid @enderror" 
                                       value="{{ old('borrow_date', \Carbon\Carbon::parse($borrowing->req_date)->format('Y-m-d')) }}" required>
                                @error('borrow_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="expected_return_date" class="form-label required">กำหนดคืน</label>
                                <input type="date" name="expected_return_date" id="expected_return_date" 
                                       class="form-control @error('expected_return_date') is-invalid @enderror" 
                                       value="{{ old('expected_return_date', \Carbon\Carbon::parse($borrowing->due_date)->format('Y-m-d')) }}" required>
                                @error('expected_return_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="note" class="form-label">หมายเหตุ</label>
                            <textarea name="note" id="note" rows="3" 
                                      class="form-control @error('note') is-invalid @enderror" 
                                      placeholder="บันทึกเพิ่มเติม (ถ้ามี)">{{ old('note', $borrowing->note) }}</textarea>
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column - Items --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-box me-1"></i>รายการสินค้ายืม</span>
                        <button type="button" class="btn btn-sm btn-light" onclick="addItem()">
                            <i class="bi bi-plus-circle"></i> เพิ่มรายการ
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="items-container">
                            @php
                                $itemIndex = 0;
                            @endphp
                            
                            @foreach($borrowing->items as $borrowItem)
                                <div class="item-row border rounded p-3 mb-3">
                                    <div class="d-flex justify-content-between mb-2">
                                        <strong>รายการที่ {{ $itemIndex + 1 }}</strong>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="removeItem(this)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8 mb-2">
                                            <select name="items[{{ $itemIndex }}][item_id]" class="form-select item-select" required>
                                                <option value="">-- เลือกสินค้า --</option>
                                                @foreach($items as $item)
                                                    <option value="{{ $item->id }}" 
                                                            data-stock="{{ $item->current_stock + $borrowItem->quantity_requested }}"
                                                            {{ $borrowItem->item_id == $item->id ? 'selected' : '' }}>
                                                        {{ $item->name }} (คงเหลือ: {{ $item->current_stock + $borrowItem->quantity_requested }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <input type="number" name="items[{{ $itemIndex }}][quantity]" 
                                                   class="form-control quantity-input" 
                                                   placeholder="จำนวน" min="1" 
                                                   value="{{ $borrowItem->quantity_requested }}" required>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $itemIndex++;
                                @endphp
                            @endforeach
                        </div>

                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle me-1"></i>
                            <strong>คำเตือน:</strong> การแก้ไขจะคืนสต๊อกเดิมและหักสต๊อกใหม่ตามข้อมูลแก้ไข
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Submit Button --}}
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('inventory.borrowing.show', $borrowing->id) }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-1"></i>ยกเลิก
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-check-circle me-1"></i>บันทึกการแก้ไข
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
let itemIndex = {{ $itemIndex }};

function addItem() {
    const container = document.getElementById('items-container');
    const newItem = `
        <div class="item-row border rounded p-3 mb-3">
            <div class="d-flex justify-content-between mb-2">
                <strong>รายการที่ ${itemIndex + 1}</strong>
                <button type="button" class="btn btn-sm btn-danger" onclick="removeItem(this)">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
            <div class="row">
                <div class="col-md-8 mb-2">
                    <select name="items[${itemIndex}][item_id]" class="form-select item-select" required>
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
                           class="form-control quantity-input" 
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
    
    // ตรวจสอบว่ามีรายการเหลืออย่างน้อย 1 รายการ
    const items = document.querySelectorAll('.item-row');
    if (items.length === 0) {
        addItem();
    }
}

// ตรวจสอบจำนวนไม่ให้เกินสต๊อก
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
