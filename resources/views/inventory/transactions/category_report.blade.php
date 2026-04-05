@extends('layouts.app')

@section('title', 'รายงานสต๊อกตามหมวดหมู่ - JST ERP')

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            <i class="fas fa-chart-pie me-2" style="color: #818cf8;"></i>รายงานสต๊อกตามหมวดหมู่
        </h4>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">สรุปยอดสต๊อกแยกตามหมวดหมู่สินค้า</p>
    </div>
    <a href="{{ route('inventory.transactions.summary') }}" class="erp-btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>กลับ
    </a>
</div>

<div class="erp-card">
    <div class="erp-table-wrap">
        <table class="erp-table">
            <thead>
                <tr>
                    <th>หมวดหมู่</th>
                    <th style="text-align: center;">จำนวนสินค้า</th>
                    <th style="text-align: center;">ยอดรวมสต๊อก</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categoryStats as $cat)
                <tr>
                    <td style="color: var(--text-primary);">{{ $cat->name }}</td>
                    <td style="text-align: center; color: var(--text-secondary);">{{ $cat->items_count }}</td>
                    <td style="text-align: center; color: var(--text-secondary);">{{ $cat->total_stock ?? 0 }}</td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center" style="color: var(--text-muted); padding: 2rem;">ไม่มีข้อมูล</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
