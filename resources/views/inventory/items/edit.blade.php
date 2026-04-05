@extends('layouts.app')

@section('title', 'แก้ไขสินค้า - JST ERP')

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            <i class="fas fa-edit me-2" style="color: #818cf8;"></i>แก้ไขข้อมูลสินค้า: {{ $item->item_code }}
        </h4>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">แก้ไขรายละเอียดสินค้า</p>
    </div>
    <a href="{{ route('inventory.items.print-barcode', $item->id) }}"
       class="erp-btn-secondary" target="_blank">
        <i class="fas fa-barcode me-2"></i>พิมพ์บาร์โค้ด
    </a>
</div>

{{-- Barcode / QR Code Preview --}}
<div class="erp-card mb-4">
    <div class="erp-card-header">
        <span class="erp-card-title">
            <i class="fas fa-barcode me-2" style="color: #818cf8;"></i>บาร์โค้ด / QR Code
        </span>
    </div>
    <div class="erp-card-body">
        <div class="row text-center">
            <div class="col-md-6">
                <h6 style="font-size: 13px; color: var(--text-muted); margin-bottom: 8px;">บาร์โค้ด ({{ $item->item_code }})</h6>
                <img src="{{ route('inventory.items.barcode', $item->id) }}"
                     alt="Barcode for {{ $item->item_code }}"
                     class="img-fluid border rounded p-2"
                     style="max-height: 80px; background: var(--bg-surface);"
                     loading="lazy">
            </div>
            <div class="col-md-6">
                <h6 style="font-size: 13px; color: var(--text-muted); margin-bottom: 8px;">QR Code</h6>
                <img src="{{ route('inventory.items.qrcode', $item->id) }}"
                     alt="QR Code for {{ $item->name }}"
                     class="img-fluid border rounded p-2"
                     style="max-height: 120px; max-width: 120px; background: var(--bg-surface);"
                     loading="lazy">
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="erp-alert erp-alert-success mb-4">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    </div>
@endif

<div class="erp-card">
    <div class="erp-card-body">
        <form action="{{ route('inventory.items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Image Upload Section Inside Form --}}
            <div class="mb-4">
                <label class="erp-label" style="font-size: 14px; font-weight: 600;">
                    <i class="fas fa-image me-1" style="color: #38bdf8;"></i>รูปภาพสินค้า
                </label>
                <div class="row">
                    <div class="col-md-4 text-center">
                        <div id="imagePreview" style="width: 150px; height: 150px; border-radius: 12px; background: var(--input-bg); border: 2px solid var(--border); display: inline-flex; align-items: center; justify-content: center; overflow: hidden; margin-bottom: 12px;">
                            @if($item->image_url)
                                <img src="{{ asset('storage/' . $item->image_url) }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <i class="fas fa-camera" style="color: var(--text-muted); font-size: 32px;"></i>
                            @endif
                        </div>
                        @if($item->image_url)
                        <br>
                        <button type="button" class="erp-btn-danger" style="padding: 4px 10px; font-size: 11px;" onclick="removeImage()">
                            <i class="fas fa-trash me-1"></i>ลบรูป
                        </button>
                        <input type="hidden" name="remove_image" id="removeImageInput" value="0">
                        @endif
                    </div>
                    <div class="col-md-8">
                        <input type="file" name="image" id="imageInput" class="erp-input" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" onchange="previewImage(this)">
                        <div style="font-size: 11px; color: var(--text-muted); margin-top: 6px;">
                            <i class="fas fa-info-circle me-1"></i>JPG, PNG, GIF, WebP (สูงสุด 2MB) • อัปโหลดรูปใหม่จะแทนที่รูปเก่า
                        </div>
                        <div class="erp-alert erp-alert-info mt-3" style="padding: 10px 14px; font-size: 12px;">
                            <i class="fas fa-lightbulb me-1"></i>
                            <strong>คำแนะนำ:</strong> ใช้รูปสี่เหลี่ยมจัตุรัส ขนาดแนะนำ 400x400 พิกเซลขึ้นไป
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="erp-label">รหัสสินค้า <span style="color: #f87171;">*</span></label>
                    <input type="text" name="item_code" class="erp-input" value="{{ old('item_code', $item->item_code) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="erp-label">บาร์โค้ด</label>
                    <input type="text" class="erp-input" value="{{ $item->item_code }}" disabled style="opacity: 0.6; cursor: not-allowed;">
                    <div style="font-size: 11px; color: var(--text-muted); margin-top: 4px;">
                        <i class="fas fa-info-circle me-1"></i>บาร์โค้ดใช้รหัสสินค้า ไม่สามารถแก้ไขได้
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="erp-label">ชื่อสินค้า <span style="color: #f87171;">*</span></label>
                    <input type="text" name="name" class="erp-input" value="{{ old('name', $item->name) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="erp-label">หมวดหมู่ <span style="color: #f87171;">*</span></label>
                    <select name="category_id" class="erp-select" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ (old('category_id', $item->category_id) == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="erp-label">ประเภท <span style="color: #f87171;">*</span></label>
                    <select name="type" class="erp-select" required>
                        <option value="returnable" {{ (old('type', $item->type) == 'returnable') ? 'selected' : '' }}>🔧 อุปกรณ์ (ยืม-คืนได้)</option>
                        <option value="disposable" {{ (old('type', $item->type) == 'disposable') ? 'selected' : '' }}>📦 วัสดุสิ้นเปลือง (ใช้แล้วหมดไป)</option>
                        <option value="equipment" {{ (old('type', $item->type) == 'equipment') ? 'selected' : '' }}>🏭 เครื่องจักร/อุปกรณ์ถาวร</option>
                        <option value="consumable" {{ (old('type', $item->type) == 'consumable') ? 'selected' : '' }}>🧴 วัสดุบริโภค (ใช้แล้วหมดไป)</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="erp-label">หน่วยนับ <span style="color: #f87171;">*</span></label>
                    <input type="text" name="unit" class="erp-input" value="{{ old('unit', $item->unit) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="erp-label">สถานะการใช้งาน <span style="color: #f87171;">*</span></label>
                    <select name="status" class="erp-select" required>
                        <option value="available" {{ (old('status', $item->status) == 'available') ? 'selected' : '' }}>พร้อมใช้งาน</option>
                        <option value="maintenance" {{ (old('status', $item->status) == 'maintenance') ? 'selected' : '' }}>อยู่ระหว่างซ่อมบำรุง</option>
                        <option value="unavailable" {{ (old('status', $item->status) == 'unavailable') ? 'selected' : '' }}>ไม่พร้อมใช้งาน / ช้ารุด</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="erp-label">จุดจัดเก็บ (Location)</label>
                    <input type="text" name="location" class="erp-input" value="{{ old('location', $item->location) }}">
                </div>

                <div class="col-md-3">
                    <label class="erp-label">จำนวนคงเหลือ</label>
                    <input type="number" name="current_stock" class="erp-input" value="{{ old('current_stock', $item->current_stock) }}" min="0">
                </div>
                <div class="col-md-3">
                    <label class="erp-label">Min Stock</label>
                    <input type="number" name="min_stock" class="erp-input" value="{{ old('min_stock', $item->min_stock) }}" min="0">
                </div>
            </div>

            <div class="d-flex gap-2 mt-4 pt-3" style="border-top: 1px solid var(--border);">
                <button type="submit" class="erp-btn-primary"><i class="fas fa-save me-2"></i>อัปเดตข้อมูล</button>
                <a href="{{ route('inventory.items.index') }}" class="erp-btn-secondary"><i class="fas fa-times me-2"></i>ยกเลิก</a>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const file = input.files[0];

    if (file) {
        if (file.size > 2 * 1024 * 1024) {
            alert('ไฟล์มีขนาดเกิน 2MB');
            input.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = '<img src="' + e.target.result + '" style="width: 100%; height: 100%; object-fit: cover;">';
        };
        reader.readAsDataURL(file);
    }
}

function removeImage() {
    const preview = document.getElementById('imagePreview');
    const removeInput = document.getElementById('removeImageInput');
    preview.innerHTML = '<i class="fas fa-camera" style="color: var(--text-muted); font-size: 32px;"></i>';
    removeInput.value = '1';
}
</script>
@endpush
