@extends('layouts.app')

@section('title', 'รายละเอียดสินค้า - JST ERP')

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            <i class="fas fa-box-open me-2" style="color: #818cf8;"></i>รายละเอียดสินค้า: {{ $item->item_code }}
        </h4>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">ข้อมูลสินค้าและอุปกรณ์</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('inventory.items.print-barcode', $item->id) }}"
           class="erp-btn-secondary" target="_blank">
            <i class="fas fa-barcode me-2"></i>พิมพ์บาร์โค้ด
        </a>
        <a href="{{ route('inventory.items.edit', $item->id) }}" class="erp-btn-primary">
            <i class="fas fa-edit me-2"></i>แก้ไข
        </a>
    </div>
</div>

{{-- Image Preview --}}
@if(!empty($item->image_url))
<div class="erp-card mb-4">
    <div class="erp-card-header">
        <span class="erp-card-title">
            <i class="fas fa-image me-2" style="color: #38bdf8;"></i>รูปภาพสินค้า
        </span>
    </div>
    <div class="erp-card-body text-center">
        <img src="{{ asset('storage/' . $item->image_url) }}"
             alt="{{ $item->name }}"
             class="img-fluid rounded"
             style="max-height: 400px; border: 2px solid var(--border);">
    </div>
</div>
@endif

{{-- Basic Info --}}
<div class="erp-card mb-4">
    <div class="erp-card-header">
        <span class="erp-card-title">
            <i class="fas fa-info-circle me-2" style="color: #6366f1;"></i>ข้อมูลพื้นฐาน
        </span>
    </div>
    <div class="erp-card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <div style="font-size: 11px; color: var(--text-muted); margin-bottom: 4px;">รหัสสินค้า</div>
                <div style="font-size: 14px; font-weight: 600; color: var(--text-primary);">{{ $item->item_code }}</div>
            </div>
            <div class="col-md-6">
                <div style="font-size: 11px; color: var(--text-muted); margin-bottom: 4px;">ชื่อสินค้า</div>
                <div style="font-size: 14px; font-weight: 600; color: var(--text-primary);">{{ $item->name }}</div>
            </div>
            <div class="col-md-6">
                <div style="font-size: 11px; color: var(--text-muted); margin-bottom: 4px;">หมวดหมู่</div>
                <div style="font-size: 14px; color: var(--text-primary);">
                    @if($item->category)
                        <span class="erp-badge" style="background: rgba(99,102,241,0.12); color: #818cf8;">
                            <i class="fas fa-tag me-1"></i>{{ $item->category->name }}
                        </span>
                    @else
                        <span style="color: var(--text-muted);">-</span>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div style="font-size: 11px; color: var(--text-muted); margin-bottom: 4px;">ประเภท</div>
                <div>
                    <span class="erp-badge" style="background: {{ $item->type == 'equipment' ? 'rgba(56,189,248,0.12)' : 'rgba(107,114,128,0.12)' }}; color: {{ $item->type == 'equipment' ? '#38bdf8' : '#9ca3af' }};">
                        {{ $item->type == 'equipment' ? 'อุปกรณ์ (ยืม-คืนได้)' : 'วัสดุสิ้นเปลือง (ใช้แล้วหมดไป)' }}
                    </span>
                </div>
            </div>
            <div class="col-md-6">
                <div style="font-size: 11px; color: var(--text-muted); margin-bottom: 4px;">หน่วยนับ</div>
                <div style="font-size: 14px; color: var(--text-primary);">{{ $item->unit }}</div>
            </div>
            <div class="col-md-6">
                <div style="font-size: 11px; color: var(--text-muted); margin-bottom: 4px;">จุดจัดเก็บ</div>
                <div style="font-size: 14px; color: var(--text-primary);">{{ $item->location ?: '-' }}</div>
            </div>
        </div>
    </div>
</div>

{{-- Stock & Status --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="erp-stat-card">
            <div class="erp-stat-icon" style="background: rgba(56,189,248,0.12); color: #38bdf8;">
                <i class="fas fa-boxes"></i>
            </div>
            <div class="erp-stat-body">
                <div class="erp-stat-label">จำนวนคงเหลือ</div>
                <div class="erp-stat-value">{{ number_format($item->current_stock) }} {{ $item->unit }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="erp-stat-card">
            <div class="erp-stat-icon" style="background: rgba(251,191,36,0.12); color: #fbbf24;">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="erp-stat-body">
                <div class="erp-stat-label">Min Stock</div>
                <div class="erp-stat-value">{{ number_format($item->min_stock) }} {{ $item->unit }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="erp-stat-card">
            <div class="erp-stat-icon" style="background: {{ $item->status == 'available' ? 'rgba(52,211,153,0.12)' : 'rgba(239,68,68,0.12)' }}; color: {{ $item->status == 'available' ? '#34d399' : '#f87171' }};">
                <i class="fas fa-{{ $item->status == 'available' ? 'check-circle' : 'times-circle' }}"></i>
            </div>
            <div class="erp-stat-body">
                <div class="erp-stat-label">สถานะ</div>
                <div class="erp-stat-value" style="font-size: 18px;">
                    @if($item->status == 'available')
                        <span style="color: #34d399;">พร้อมใช้งาน</span>
                    @elseif($item->status == 'maintenance')
                        <span style="color: #fbbf24;">ซ่อมบำรุง</span>
                    @else
                        <span style="color: #f87171;">ไม่พร้อมใช้งาน</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Timestamps --}}
<div class="erp-card mb-4">
    <div class="erp-card-header">
        <span class="erp-card-title">
            <i class="fas fa-clock me-2" style="color: #8b8fa3;"></i>วันที่สร้าง/แก้ไขล่าสุด
        </span>
    </div>
    <div class="erp-card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <div style="font-size: 11px; color: var(--text-muted); margin-bottom: 4px;">สร้างเมื่อ</div>
                <div style="font-size: 13px; color: var(--text-primary);">
                    <i class="fas fa-calendar-plus me-1" style="color: #8b8fa3;"></i>
                    {{ $item->created_at->format('d/m/Y H:i') }} น.
                </div>
            </div>
            <div class="col-md-6">
                <div style="font-size: 11px; color: var(--text-muted); margin-bottom: 4px;">แก้ไขล่าสุดเมื่อ</div>
                <div style="font-size: 13px; color: var(--text-primary);">
                    <i class="fas fa-calendar-check me-1" style="color: #8b8fa3;"></i>
                    {{ $item->updated_at->format('d/m/Y H:i') }} น.
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Barcode/QR Preview --}}
<div class="erp-card mb-4">
    <div class="erp-card-header">
        <span class="erp-card-title">
            <i class="fas fa-barcode me-2" style="color: #818cf8;"></i>บาร์โค้ด / QR Code
        </span>
    </div>
    <div class="erp-card-body">
        <div class="row text-center">
            <div class="col-md-6">
                <h6 style="font-size: 13px; color: var(--text-muted); margin-bottom: 8px;">บาร์โค้ด</h6>
                <img src="{{ route('inventory.items.barcode', $item->id) }}"
                     alt="Barcode"
                     class="img-fluid border rounded p-2"
                     style="max-height: 80px; background: var(--bg-surface);"
                     loading="lazy">
            </div>
            <div class="col-md-6">
                <h6 style="font-size: 13px; color: var(--text-muted); margin-bottom: 8px;">QR Code</h6>
                <img src="{{ route('inventory.items.qrcode', $item->id) }}"
                     alt="QR Code"
                     class="img-fluid border rounded p-2"
                     style="max-height: 120px; max-width: 120px; background: var(--bg-surface);"
                     loading="lazy">
            </div>
        </div>
    </div>
</div>

{{-- Actions --}}
<div class="d-flex gap-2">
    <a href="{{ route('inventory.items.index') }}" class="erp-btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>กลับหน้ารายการ
    </a>
    <form action="{{ route('inventory.items.destroy', $item->id) }}" method="POST" class="d-inline" id="deleteItemForm">
        @csrf
        @method('DELETE')
        <button type="button" class="erp-btn-danger" onclick="confirmAction('คุณต้องการลบสินค้า "{{ $item->name }}" ใช่หรือไม่? การลบจะไม่สามารถกู้คืนได้', function() { document.getElementById('deleteItemForm').submit(); })">
            <i class="fas fa-trash me-2"></i>ลบสินค้า
        </button>
    </form>
</div>

@endsection
