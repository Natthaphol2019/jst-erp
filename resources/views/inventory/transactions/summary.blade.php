@extends('layouts.app')

@section('title', 'สรุปยอดคงเหลือสต๊อก - JST ERP')

@section('content')
<style>
@media print {
    .no-print, .no-print * { display: none !important; }
    .sidebar, .navbar, .btn, .alert, .erp-card-body form { display: none !important; }
    .content { padding: 0 !important; margin: 0 !important; }
    .erp-card { border: 1px solid #dee2e6 !important; box-shadow: none !important; margin-bottom: 1rem !important; }
    .erp-card-header { background-color: #f8f9fa !important; color: #000 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    table { font-size: 10pt !important; }
    th, td { border: 1px solid #dee2e6 !important; }
    .erp-badge { border: 1px solid #6c757d !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    body { background-color: #fff !important; }
    .container-fluid { width: 100% !important; max-width: 100% !important; }
    .row { page-break-inside: avoid; }
    @page { margin: 1.5cm; }
}
.print-header { display: none; }
@media print {
    .print-header { display: block !important; text-align: center; margin-bottom: 20px; }
    .print-header h2 { margin: 0; font-size: 18pt; }
    .print-header p { margin: 5px 0 0; font-size: 10pt; color: #666; }
}
</style>

<div class="print-header">
    <h2>สรุปยอดคงเหลือสต๊อก</h2>
    <p>พิมพ์เมื่อ {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
</div>

<div class="d-flex justify-content-between align-items-start mb-4 no-print">
    <div>
        <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            <i class="fas fa-chart-bar me-2" style="color: #818cf8;"></i>สรุปยอดคงเหลือสต๊อก
        </h4>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">ภาพรวมสต๊อกสินค้าทั้งหมด</p>
    </div>
    <div class="d-flex gap-2 no-print">
        <button onclick="window.print()" class="erp-btn-secondary">
            <i class="fas fa-print me-2"></i>พิมพ์
        </button>
        <a href="{{ route('inventory.transactions.index') }}" class="erp-btn-secondary">
            <i class="fas fa-clock me-2"></i>ประวัติเคลื่อนไหว
        </a>
    </div>
</div>

{{-- Overview Cards --}}
<div class="row g-3 mb-4 no-print">
    <div class="col-md-3">
        <div class="erp-stat-card">
            <div class="erp-stat-icon" style="background: rgba(99,102,241,0.12); color: #818cf8;">
                <i class="fas fa-box"></i>
            </div>
            <div class="erp-stat-body">
                <div class="erp-stat-label">สินค้าทั้งหมด</div>
                <div class="erp-stat-value">{{ $overview['total_items'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="erp-stat-card">
            <div class="erp-stat-icon" style="background: rgba(52,211,153,0.12); color: #34d399;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="erp-stat-body">
                <div class="erp-stat-label">สินค้ามีสต๊อก</div>
                <div class="erp-stat-value">{{ $overview['total_items'] - $overview['zero_stock_count'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="erp-stat-card">
            <div class="erp-stat-icon" style="background: rgba(251,191,36,0.12); color: #fbbf24;">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="erp-stat-body">
                <div class="erp-stat-label">สต๊อกต่ำกว่าขั้นต่ำ</div>
                <div class="erp-stat-value" style="color: #fbbf24;">{{ $overview['low_stock_count'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="erp-stat-card">
            <div class="erp-stat-icon" style="background: rgba(239,68,68,0.12); color: #f87171;">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="erp-stat-body">
                <div class="erp-stat-label">สินค้าหมดสต๊อก</div>
                <div class="erp-stat-value" style="color: #f87171;">{{ $overview['zero_stock_count'] }}</div>
            </div>
        </div>
    </div>
</div>

{{-- Filter Form --}}
<div class="erp-card mb-4 no-print">
    <div class="erp-card-body">
        <form method="GET" action="{{ route('inventory.transactions.summary') }}" class="row g-3">
            <div class="col-md-4">
                <label class="erp-label">ค้นหา</label>
                <input type="text" name="search" class="erp-input"
                       value="{{ request('search') }}"
                       placeholder="ชื่อสินค้า, รหัสสินค้า">
            </div>
            <div class="col-md-3">
                <label class="erp-label">หมวดหมู่</label>
                <select name="category_id" class="erp-select">
                    <option value="">-- ทั้งหมด --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="erp-label">สถานะ</label>
                <select name="status" class="erp-select">
                    <option value="">-- ทั้งหมด --</option>
                    <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>มีสต๊อก</option>
                    <option value="low_stock" {{ request('status') == 'low_stock' ? 'selected' : '' }}>ต่ำกว่าขั้นต่ำ</option>
                    <option value="zero" {{ request('status') == 'zero' ? 'selected' : '' }}>หมดสต๊อก</option>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="erp-btn-primary w-100">
                    <i class="fas fa-search me-1"></i>ค้นหา
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Stock Summary Table --}}
<div class="erp-card no-print">
    <div class="erp-table-wrap">
        <table class="erp-table">
            <thead>
                <tr>
                    <th width="100">รหัสสินค้า</th>
                    <th>ชื่อสินค้า</th>
                    <th width="100">หมวดหมู่</th>
                    <th width="80" style="text-align: center;">หน่วย</th>
                    <th width="120" style="text-align: center;">สต๊อกปัจจุบัน</th>
                    <th width="120" style="text-align: center;">ขั้นต่ำ</th>
                    <th width="100" style="text-align: center;">สถานะ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    @php
                        $isLowStock = $item->current_stock <= $item->min_stock;
                        $isZero = $item->current_stock == 0;

                        $statusBadge = match(true) {
                            $isZero => ['bg' => 'rgba(239,68,68,0.12)', 'color' => '#f87171', 'text' => 'หมดสต๊อก'],
                            $isLowStock => ['bg' => 'rgba(251,191,36,0.12)', 'color' => '#fbbf24', 'text' => 'ต่ำกว่าขั้นต่ำ'],
                            default => ['bg' => 'rgba(52,211,153,0.12)', 'color' => '#34d399', 'text' => 'ปกติ']
                        };
                    @endphp
                    <tr>
                        <td><code style="color: var(--text-secondary);">{{ $item->item_code }}</code></td>
                        <td style="color: var(--text-secondary);">{{ $item->name }}</td>
                        <td style="color: var(--text-secondary);">{{ $item->category->name ?? '-' }}</td>
                        <td style="text-align: center; color: var(--text-secondary);">{{ $item->unit }}</td>
                        <td style="text-align: center;">
                            <strong style="font-size: 1.2rem; color: {{ $isZero ? '#f87171' : ($isLowStock ? '#fbbf24' : '#34d399') }};">
                                {{ $item->current_stock }}
                            </strong>
                        </td>
                        <td style="text-align: center; color: var(--text-secondary);">{{ $item->min_stock }}</td>
                        <td style="text-align: center;">
                            <span class="erp-badge" style="background: {{ $statusBadge['bg'] }}; color: {{ $statusBadge['color'] }};">
                                {{ $statusBadge['text'] }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center" style="padding: 3rem;">
                            <div class="erp-empty" style="padding: 1rem;">
                                <i class="fas fa-inbox" style="font-size: 2rem; color: var(--text-muted);"></i>
                                <div style="color: var(--text-muted); margin-top: 8px;">ไม่พบข้อมูลสินค้า</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Pagination --}}
@if($items->hasPages())
    <div style="padding: 16px; border-top: 1px solid var(--border);">
        <div class="d-flex justify-content-between align-items-center">
            <div style="font-size: 13px; color: var(--text-secondary);">
                แสดง <strong style="color: var(--text-primary);">{{ $items->firstItem() }}</strong> ถึง <strong style="color: var(--text-primary);">{{ $items->lastItem() }}</strong> จาก <strong style="color: var(--text-primary);">{{ $items->total() }}</strong> รายการ
            </div>
            {{ $items->links() }}
        </div>
    </div>
@endif
@endsection
