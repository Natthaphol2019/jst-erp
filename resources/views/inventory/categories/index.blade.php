@extends('layouts.app')

@section('title', 'จัดการหมวดหมู่สินค้า - JST ERP')

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            <i class="fas fa-tags me-2" style="color: #818cf8;"></i>จัดการหมวดหมู่สินค้า
        </h4>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">จัดการหมวดหมู่ของสินค้าในคลัง</p>
    </div>
    <a href="{{ route('inventory.categories.create') }}" class="erp-btn-primary">
        <i class="fas fa-plus me-2"></i>เพิ่มหมวดหมู่ใหม่
    </a>
</div>

@if(session('success'))
    <div class="erp-alert erp-alert-success mb-4">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="erp-alert erp-alert-danger mb-4">
        <i class="fas fa-exclamation-triangle me-2"></i>{{ $errors->first() }}
    </div>
@endif

<div class="erp-card">
    <div class="erp-table-wrap">
        <table class="erp-table">
            <thead>
                <tr>
                    <th>ชื่อหมวดหมู่</th>
                    <th>รายละเอียด</th>
                    <th style="text-align: center;">จำนวนสินค้า</th>
                    <th style="text-align: center;">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                <tr>
                    <td style="color: var(--text-primary);">{{ $cat->name }}</td>
                    <td style="color: var(--text-secondary);">{{ $cat->description ?? '-' }}</td>
                    <td style="text-align: center;">
                        <span class="erp-badge" style="background: rgba(56,189,248,0.12); color: #38bdf8;">
                            {{ $cat->items_count }} รายการ
                        </span>
                    </td>
                    <td style="text-align: center;">
                        <div class="d-flex gap-1 justify-content-center">
                            <a href="{{ route('inventory.categories.edit', $cat->id) }}" class="erp-btn-secondary" style="padding: 4px 8px; font-size: 12px;">
                                <i class="fas fa-edit me-1"></i>แก้ไข
                            </a>
                            <form action="{{ route('inventory.categories.destroy', $cat->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('คุณแน่ใจหรือว่าจะลบหมวดหมู่นี้?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="erp-btn-danger" style="padding: 4px 8px; font-size: 12px;">
                                    <i class="fas fa-trash me-1"></i>ลบ
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center" style="color: var(--text-muted); padding: 2rem;">
                        <div class="erp-empty" style="padding: 2rem;">
                            <i class="fas fa-inbox" style="font-size: 2rem; color: var(--text-muted);"></i>
                            <div style="color: var(--text-muted); margin-top: 8px;">ยังไม่มีข้อมูลหมวดหมู่สินค้า</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($categories->hasPages())
    <div style="padding: 16px; border-top: 1px solid var(--border);">
        <div class="d-flex justify-content-between align-items-center">
            <div style="font-size: 13px; color: var(--text-secondary);">
                แสดง <strong style="color: var(--text-primary);">{{ $categories->firstItem() }}</strong> ถึง <strong style="color: var(--text-primary);">{{ $categories->lastItem() }}</strong> จาก <strong style="color: var(--text-primary);">{{ $categories->total() }}</strong> รายการ
            </div>
            {{ $categories->links() }}
        </div>
    </div>
@endif
@endsection
