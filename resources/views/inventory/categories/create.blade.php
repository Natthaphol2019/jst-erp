@extends('layouts.app')

@section('title', 'เพิ่มหมวดหมู่สินค้า - JST ERP')

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            <i class="fas fa-plus me-2" style="color: #818cf8;"></i>เพิ่มหมวดหมู่สินค้าใหม่
        </h4>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">สร้างหมวดหมู่สำหรับจัดกลุ่มสินค้า</p>
    </div>
    <a href="{{ route('inventory.categories.index') }}" class="erp-btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>กลับ
    </a>
</div>

@if($errors->any())
    <div class="erp-alert erp-alert-danger mb-4">
        <i class="fas fa-exclamation-triangle me-2"></i>{{ $errors->first() }}
    </div>
@endif

<div class="erp-card">
    <div class="erp-card-body">
        <form action="{{ route('inventory.categories.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="erp-label">ชื่อหมวดหมู่ <span style="color: #f87171;">*</span></label>
                <input type="text" name="name" class="erp-input @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="erp-label">รายละเอียด</label>
                <textarea name="description" class="erp-textarea @error('description') is-invalid @enderror" rows="3">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="erp-btn-primary"><i class="fas fa-check me-2"></i>บันทึก</button>
                <a href="{{ route('inventory.categories.index') }}" class="erp-btn-secondary"><i class="fas fa-times me-2"></i>ยกเลิก</a>
            </div>
        </form>
    </div>
</div>
@endsection
