@extends('layouts.app')
@section('title', 'Inventory Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            <i class="fas fa-tachometer-alt me-2" style="color: #818cf8;"></i>ภาพรวมระบบคลังสินค้า
        </h4>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">ยินดีต้อนรับ, <strong style="color: var(--text-secondary);">{{ auth()->user()->name }}</strong></p>
    </div>
    <a href="{{ route('inventory.items.create') }}" class="erp-btn-primary">
        <i class="fas fa-plus me-2"></i>เพิ่มสินค้าใหม่
    </a>
</div>

{{-- Stats Cards --}}
<div class="row g-3 mb-4">
    {{-- Pending Requisitions --}}
    <div class="col-xl-3 col-md-6">
        <div class="erp-stat-card">
            <div class="erp-stat-icon" style="background: rgba(251,191,36,0.12); color: #fbbf24;">
                <i class="fas fa-clipboard-data"></i>
            </div>
            <div class="erp-stat-body">
                <div class="erp-stat-label">รออนุมัติเบิก</div>
                <div class="erp-stat-value" style="color: #fbbf24;">{{ number_format($pendingRequisitions) }}</div>
            </div>
            <a href="{{ route('inventory.requisition.index') }}" class="erp-stat-link" style="color: #fbbf24;">
                ตรวจสอบรายการ <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

    {{-- Total Items --}}
    <div class="col-xl-3 col-md-6">
        <div class="erp-stat-card">
            <div class="erp-stat-icon" style="background: rgba(99,102,241,0.12); color: #818cf8;">
                <i class="fas fa-box-open"></i>
            </div>
            <div class="erp-stat-body">
                <div class="erp-stat-label">สินค้าทั้งหมด</div>
                <div class="erp-stat-value">{{ number_format($totalItems) }}</div>
            </div>
            <a href="{{ route('inventory.items.index') }}" class="erp-stat-link" style="color: #818cf8;">
                จัดการสินค้า <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

    {{-- Low Stock --}}
    <div class="col-xl-3 col-md-6">
        <div class="erp-stat-card">
            <div class="erp-stat-icon" style="background: rgba(239,68,68,0.12); color: #f87171;">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="erp-stat-body">
                <div class="erp-stat-label">ใกล้หมด (Low Stock)</div>
                <div class="erp-stat-value" style="color: #f87171;">{{ number_format($lowStockCount) }}</div>
            </div>
            <a href="#low-stock-table" class="erp-stat-link" style="color: #f87171;">
                ดูรายการที่ต้องสั่งซื้อ <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

    {{-- Active Borrowings --}}
    <div class="col-xl-3 col-md-6">
        <div class="erp-stat-card">
            <div class="erp-stat-icon" style="background: rgba(56,189,248,0.12); color: #38bdf8;">
                <i class="fas fa-hand-holding"></i>
            </div>
            <div class="erp-stat-body">
                <div class="erp-stat-label">กำลังยืม</div>
                <div class="erp-stat-value">{{ number_format($activeBorrowings) }}</div>
            </div>
            <a href="{{ route('inventory.borrowing.index') }}" class="erp-stat-link" style="color: #38bdf8;">
                ดูรายการยืม <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

<div class="row g-3">
    {{-- Low Stock Alert Table --}}
    <div class="col-lg-7">
        <div class="erp-card" id="low-stock-table">
            <div class="erp-card-header">
                <span class="erp-card-title" style="color: #f87171;">
                    <i class="fas fa-bell me-2" style="color: #f87171;"></i>แจ้งเตือน: สินค้าต่ำกว่าเกณฑ์ (Min Stock)
                </span>
            </div>
            <div class="erp-card-body">
                <div class="erp-table-wrap">
                    <table class="erp-table">
                        <thead>
                            <tr>
                                <th>รหัสสินค้า</th>
                                <th>ชื่อสินค้า</th>
                                <th style="text-align: right;">คงเหลือ</th>
                                <th style="text-align: right;">จุดสั่งซื้อ</th>
                                <th style="text-align: center;">สถานะ</th>
                                <th style="text-align: center;">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lowStockItems as $item)
                            <tr>
                                <td><strong style="color: var(--text-primary);">{{ $item->item_code }}</strong></td>
                                <td style="color: var(--text-secondary);">{{ $item->name }}</td>
                                <td style="text-align: right;">
                                    <strong style="color: #f87171;">{{ number_format($item->current_stock) }} {{ $item->unit }}</strong>
                                </td>
                                <td style="text-align: right; color: var(--text-muted);">{{ number_format($item->min_stock) }}</td>
                                <td style="text-align: center;">
                                    @if($item->current_stock == 0)
                                        <span class="erp-badge" style="background: rgba(239,68,68,0.12); color: #f87171;">
                                            <i class="fas fa-times me-1"></i>ของหมด
                                        </span>
                                    @else
                                        <span class="erp-badge" style="background: rgba(251,191,36,0.12); color: #fbbf24;">
                                            <i class="fas fa-exclamation-triangle me-1"></i>ใกล้หมด
                                        </span>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    <a href="{{ route('inventory.items.edit', $item->id) }}" class="erp-btn-secondary" style="padding: 4px 8px; font-size: 12px;">ตรวจสอบ</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center" style="padding: 2rem;">
                                    <div style="color: #34d399;">
                                        <i class="fas fa-check-circle" style="font-size: 1.5rem; display: block; margin-bottom: 8px;"></i>
                                        ยอดเยี่ยม! ไม่มีสินค้าต่ำกว่าเกณฑ์การสั่งซื้อ
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Categories Overview --}}
    <div class="col-lg-5">
        <div class="erp-card h-100">
            <div class="erp-card-header">
                <span class="erp-card-title">
                    <i class="fas fa-th me-2" style="color: #818cf8;"></i>หมวดหมู่สินค้า
                </span>
            </div>
            <div class="erp-card-body">
                @forelse($categories as $category)
                <div class="mb-3" style="border-bottom: 1px solid var(--border); padding-bottom: 12px;">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span style="font-weight: 600; font-size: 13px; color: var(--text-secondary);">{{ $category->name }}</span>
                        <span class="erp-badge" style="background: var(--input-bg); color: var(--text-secondary);">{{ $category->items_count }} รายการ</span>
                    </div>
                    @php
                        $percentage = $totalItems > 0 ? ($category->items_count / $totalItems) * 100 : 0;
                    @endphp
                    <div class="progress" style="height: 6px; background: var(--input-bg);">
                        <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%; background: #818cf8;"></div>
                    </div>
                    @if($category->description)
                        <small style="color: var(--text-muted); display: block; margin-top: 4px;">{{ Str::limit($category->description, 50) }}</small>
                    @endif
                </div>
                @empty
                <div class="text-center" style="color: var(--text-muted); padding: 2rem;">
                    <i class="fas fa-inbox" style="font-size: 1.5rem; display: block; margin-bottom: 8px;"></i>
                    ยังไม่มีหมวดหมู่สินค้า
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- Recent Stock Transactions --}}
<div class="row g-3 mt-2">
    <div class="col-12">
        <div class="erp-card">
            <div class="erp-card-header d-flex justify-content-between align-items-center">
                <span class="erp-card-title">
                    <i class="fas fa-clock me-2" style="color: #818cf8;"></i>รายการเคลื่อนไหวล่าสุด
                </span>
                <a href="{{ route('inventory.transactions.index') }}" class="erp-btn-secondary" style="padding: 4px 8px; font-size: 12px;">
                    ดูทั้งหมด <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="erp-card-body">
                <div class="erp-table-wrap">
                    <table class="erp-table">
                        <thead>
                            <tr>
                                <th>วันที่</th>
                                <th>สินค้า</th>
                                <th>ประเภท</th>
                                <th style="text-align: right;">จำนวน</th>
                                <th style="text-align: right;">คงเหลือ</th>
                                <th>หมายเหตุ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTransactions as $transaction)
                            <tr>
                                <td style="font-size: 12px; color: var(--text-muted);">{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <strong style="color: var(--text-primary);">{{ $transaction->item->name ?? '-' }}</strong>
                                    <br>
                                    <small style="color: var(--text-muted);">{{ $transaction->item->item_code ?? '' }}</small>
                                </td>
                                <td>
                                    @php
                                        $typeBadge = match($transaction->transaction_type) {
                                            'in' => ['bg' => 'rgba(52,211,153,0.12)', 'color' => '#34d399', 'text' => 'รับเข้า'],
                                            'out' => ['bg' => 'rgba(239,68,68,0.12)', 'color' => '#f87171', 'text' => 'จ่ายออก'],
                                            'borrow_out' => ['bg' => 'rgba(251,191,36,0.12)', 'color' => '#fbbf24', 'text' => 'ยืมออก'],
                                            'borrow_return' => ['bg' => 'rgba(56,189,248,0.12)', 'color' => '#38bdf8', 'text' => 'คืนยืม'],
                                            'adjust' => ['bg' => 'rgba(107,114,128,0.12)', 'color' => '#9ca3af', 'text' => 'ปรับยอด'],
                                            default => ['bg' => 'rgba(107,114,128,0.12)', 'color' => '#9ca3af', 'text' => $transaction->transaction_type]
                                        };
                                    @endphp
                                    <span class="erp-badge" style="background: {{ $typeBadge['bg'] }}; color: {{ $typeBadge['color'] }};">
                                        {{ $typeBadge['text'] }}
                                    </span>
                                </td>
                                <td style="text-align: right;" class="{{ $transaction->transaction_type === 'in' || $transaction->transaction_type === 'borrow_return' ? 'text-success' : 'text-danger' }}">
                                    <strong>{{ $transaction->transaction_type === 'in' || $transaction->transaction_type === 'borrow_return' ? '+' : '-' }}{{ number_format($transaction->quantity) }}</strong>
                                </td>
                                <td style="text-align: right; color: var(--text-secondary);">{{ number_format($transaction->balance) }}</td>
                                <td style="font-size: 12px; color: var(--text-muted);">{{ Str::limit($transaction->remark, 40) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center" style="padding: 2rem; color: var(--text-muted);">
                                    <i class="fas fa-inbox" style="font-size: 1.5rem; display: block; margin-bottom: 8px;"></i>
                                    ยังไม่มีรายการเคลื่อนไหว
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
