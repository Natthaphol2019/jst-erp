@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h2>
                <i class="bi bi-box-arrow-in-left me-2"></i>คืนสินค้า - ใบยืม #{{ str_pad($borrowing->id, 4, '0', STR_PAD_LEFT) }}
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

    <form action="{{ route('inventory.borrowing.return.store', $borrowing->id) }}" method="POST">
        @csrf
        
        <div class="row">
            {{-- Left Column - Borrowing Summary --}}
            <div class="col-md-5">
                <div class="card mb-3">
                    <div class="card-header bg-info text-white">
                        <i class="bi bi-person me-1"></i>ข้อมูลผู้ยืม
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <th width="120">ผู้ยืม</th>
                                <td>{{ $borrowing->employee->firstname }} {{ $borrowing->employee->lastname }}</td>
                            </tr>
                            <tr>
                                <th>วันที่ยืม</th>
                                <td>{{ \Carbon\Carbon::parse($borrowing->req_date)->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <th>กำหนดคืน</th>
                                <td>
                                    {{ \Carbon\Carbon::parse($borrowing->due_date)->format('d/m/Y') }}
                                    @php
                                        $isOverdue = in_array($borrowing->status, ['approved', 'returned_partial']) && now()->gt(\Carbon\Carbon::parse($borrowing->due_date));
                                    @endphp
                                    @if($isOverdue)
                                        <span class="badge bg-danger ms-2">เกินกำหนด</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <i class="bi bi-exclamation-triangle me-1"></i>คำเตือน
                    </div>
                    <div class="card-body">
                        <ul class="mb-0">
                            <li>ตรวจสอบจำนวนสินค้าที่คืนให้ถูกต้อง</li>
                            <li>สินค้าที่คืนจะกลับเข้าสต๊อกทันที</li>
                            <li>สามารถคืนได้บางส่วนหรือทั้งหมด</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Right Column - Return Items --}}
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <i class="bi bi-box me-1"></i>รายการคืนสินค้า
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>สินค้า</th>
                                        <th width="80" class="text-center">ยืม</th>
                                        <th width="80" class="text-center">คืนแล้ว</th>
                                        <th width="80" class="text-center">ยังไม่ได้คืน</th>
                                        <th width="100" class="text-center">จำนวนคืน</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($borrowing->items as $index => $item)
                                        @php
                                            $canReturn = $item->quantity_requested - $item->quantity_returned;
                                        @endphp
                                        @if($canReturn > 0)
                                        <tr>
                                            <td>{{ $item->item->name }}</td>
                                            <td class="text-center">{{ $item->quantity_requested }}</td>
                                            <td class="text-center">{{ $item->quantity_returned }}</td>
                                            <td class="text-center"><strong class="text-danger">{{ $canReturn }}</strong></td>
                                            <td class="text-center">
                                                <input type="number" 
                                                       name="return_items[{{ $index }}][requisition_item_id]" 
                                                       value="{{ $item->id }}" 
                                                       class="d-none">
                                                <input type="number" 
                                                       name="return_items[{{ $index }}][return_quantity]" 
                                                       class="form-control form-control-sm return-quantity-input" 
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
                            <label for="actual_return_date" class="form-label required">วันที่คืนจริง</label>
                            <input type="date" name="actual_return_date" id="actual_return_date" 
                                   class="form-control @error('actual_return_date') is-invalid @enderror" 
                                   value="{{ old('actual_return_date', date('Y-m-d')) }}" required>
                            @error('actual_return_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="return_note" class="form-label">หมายเหตุการคืน</label>
                            <textarea name="return_note" id="return_note" rows="3" 
                                      class="form-control @error('return_note') is-invalid @enderror" 
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
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('inventory.borrowing.show', $borrowing->id) }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-1"></i>ยกเลิก
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle me-1"></i>บันทึกการคืน
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
// ตรวจสอบจำนวนคืนไม่ให้เกินที่ยังไม่ได้คืน
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
