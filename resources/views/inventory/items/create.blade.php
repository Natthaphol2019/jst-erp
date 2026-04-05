@extends('layouts.app')

@section('title', 'ลงทะเบียนสินค้าใหม่ - JST ERP')

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            <i class="fas fa-plus me-2" style="color: #818cf8;"></i>ลงทะเบียนสินค้าใหม่
        </h4>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">เพิ่มสินค้าเข้าคลัง</p>
    </div>
</div>

@if($errors->any())
    <div class="erp-alert erp-alert-danger mb-4">
        <i class="fas fa-exclamation-triangle me-2"></i>{{ $errors->first() }}
    </div>
@endif

<div class="erp-card">
    <div class="erp-card-body">
        <form action="{{ route('inventory.items.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                {{-- Image Upload --}}
                <div class="col-12">
                    <label class="erp-label">รูปภาพสินค้า</label>
                    <div class="d-flex align-items-center gap-3">
                        <div id="imagePreview" style="width: 100px; height: 100px; border-radius: 12px; background: var(--input-bg); border: 2px dashed var(--border); display: flex; align-items: center; justify-content: center; overflow: hidden;">
                            <i class="fas fa-camera" style="color: var(--text-muted); font-size: 24px;"></i>
                        </div>
                        <div class="flex-grow-1">
                            <input type="file" name="image" id="imageInput" class="erp-input" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" onchange="previewImage(this)">
                            <div style="font-size: 11px; color: var(--text-muted); margin-top: 4px;">
                                <i class="fas fa-info-circle me-1"></i>JPG, PNG, GIF, WebP (สูงสุด 2MB)
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="erp-label">รหัสสินค้า <span style="color: #f87171;">*</span></label>
                    <input type="text" name="item_code" class="erp-input" placeholder="เช่น ITEM-001" required>
                </div>
                <div class="col-md-6">
                    <label class="erp-label">บาร์โค้ด</label>
                    <input type="text" class="erp-input" placeholder="จะสร้างอัตโนมัติหลังบันทึกสินค้า" disabled style="opacity: 0.6; cursor: not-allowed;">
                    <div style="font-size: 11px; color: var(--text-muted); margin-top: 4px;">
                        <i class="fas fa-info-circle me-1"></i>บาร์โค้ดจะสร้างหลังจากบันทึกสินค้า
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="erp-label">ชื่อสินค้า <span style="color: #f87171;">*</span></label>
                    <input type="text" name="name" class="erp-input" required>
                </div>
                <div class="col-md-6">
                    <label class="erp-label">หมวดหมู่ <span style="color: #f87171;">*</span></label>
                    <select name="category_id" class="erp-select" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="erp-label">ประเภท <span style="color: #f87171;">*</span></label>
                    <select name="type" class="erp-select" required>
                        <option value="returnable">🔧 อุปกรณ์ (ยืม-คืนได้)</option>
                        <option value="disposable">📦 วัสดุสิ้นเปลือง (ใช้แล้วหมดไป)</option>
                        <option value="equipment">🏭 เครื่องจักร/อุปกรณ์ถาวร</option>
                        <option value="consumable">🧴 วัสดุบริโภค (ใช้แล้วหมดไป)</option>
                    </select>
                    <div style="font-size: 11px; color: var(--text-muted); margin-top: 4px;">
                        <i class="fas fa-info-circle me-1"></i>
                        <strong>อุปกรณ์:</strong> ยืมแล้วต้องคืน (เช่น เครื่องมือ, PPE) | 
                        <strong>วัสดุสิ้นเปลือง:</strong> เบิกแล้วหมดไป (เช่น น้ำยา, กระดาษ)
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="erp-label">จำนวนตั้งต้น</label>
                    <input type="number" name="current_stock" class="erp-input" value="0">
                </div>
                <div class="col-md-4">
                    <label class="erp-label">หน่วยนับ <span style="color: #f87171;">*</span></label>
                    <input type="text" name="unit" class="erp-input" placeholder="เช่น ชิ้น, ตัว" required>
                </div>
                <div class="col-md-4">
                    <label class="erp-label">Min Stock</label>
                    <input type="number" name="min_stock" class="erp-input" value="0">
                </div>
            </div>
            <div class="d-flex gap-2 mt-4 pt-3" style="border-top: 1px solid var(--border);">
                <a href="{{ route('inventory.items.index') }}" class="erp-btn-secondary"><i class="fas fa-times me-2"></i>ยกเลิก</a>
                <button type="submit" class="erp-btn-primary"><i class="fas fa-save me-2"></i>บันทึกข้อมูล</button>
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
</script>
@endpush
