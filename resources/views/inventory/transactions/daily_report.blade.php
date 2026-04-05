@extends('layouts.app')

@section('title', 'รายงานสต๊อกเข้า-ออก รายวัน - JST ERP')

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            <i class="fas fa-chart-line me-2" style="color: #818cf8;"></i>รายงานสต๊อกเข้า-ออก รายวัน
        </h4>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">สรุปการเคลื่อนไหวสต๊อกตามวัน</p>
    </div>
    <a href="{{ route('inventory.transactions.index') }}" class="erp-btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>กลับ
    </a>
</div>

{{-- Date Picker --}}
<div class="erp-card mb-4">
    <div class="erp-card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="erp-label">เลือกวันที่</label>
                <input type="date" name="date" class="erp-input" value="{{ $date }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="erp-btn-primary w-100">
                    <i class="fas fa-search me-1"></i>ค้นหา
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Stats Cards --}}
<div class="row g-3 mb-4">
    @foreach($dailyStats as $stat)
    <div class="col-md-3">
        <div class="erp-stat-card">
            <div class="erp-stat-icon" style="background: {{ $stat->transaction_type === 'borrow_return' ? 'rgba(52,211,153,0.12)' : ($stat->transaction_type === 'consume_out' ? 'rgba(239,68,68,0.12)' : 'rgba(251,191,36,0.12)') }}; color: {{ $stat->transaction_type === 'borrow_return' ? '#34d399' : ($stat->transaction_type === 'consume_out' ? '#f87171' : '#fbbf24') }};">
                <i class="fas {{ $stat->transaction_type === 'borrow_return' ? 'fa-check-circle' : ($stat->transaction_type === 'consume_out' ? 'fa-arrow-up' : 'fa-exchange-alt') }}"></i>
            </div>
            <div class="erp-stat-body">
                <div class="erp-stat-label">{{ $stat->transaction_type }}</div>
                <div class="erp-stat-value">{{ $stat->total_quantity }} ชิ้น</div>
                <div style="font-size: 12px; color: var(--text-muted);">{{ $stat->count }} รายการ</div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Transactions Table --}}
<div class="erp-card">
    <div class="erp-card-header">
        <span class="erp-card-title">
            <i class="fas fa-list me-2" style="color: #818cf8;"></i>รายการทั้งหมดวันที่ {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
        </span>
    </div>
    <div class="erp-card-body">
        <div class="erp-table-wrap">
            <table class="erp-table">
                <thead>
                    <tr>
                        <th>เวลา</th>
                        <th>สินค้า</th>
                        <th>ประเภท</th>
                        <th style="text-align: center;">จำนวน</th>
                        <th style="text-align: center;">คงเหลือ</th>
                        <th>ผู้ทำรายการ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $txn)
                    <tr>
                        <td style="color: var(--text-secondary);">{{ $txn->created_at->format('H:i') }}</td>
                        <td style="color: var(--text-secondary);">{{ $txn->item->name }}</td>
                        <td>
                            @php
                                $typeBadge = match($txn->transaction_type) {
                                    'borrow_out' => ['bg' => 'rgba(251,191,36,0.12)', 'color' => '#fbbf24'],
                                    'borrow_return' => ['bg' => 'rgba(56,189,248,0.12)', 'color' => '#38bdf8'],
                                    'consume_out' => ['bg' => 'rgba(239,68,68,0.12)', 'color' => '#f87171'],
                                    'in' => ['bg' => 'rgba(52,211,153,0.12)', 'color' => '#34d399'],
                                    default => ['bg' => 'rgba(107,114,128,0.12)', 'color' => '#9ca3af']
                                };
                            @endphp
                            <span class="erp-badge" style="background: {{ $typeBadge['bg'] }}; color: {{ $typeBadge['color'] }};">
                                {{ $txn->transaction_type }}
                            </span>
                        </td>
                        <td style="text-align: center; color: var(--text-secondary);">{{ $txn->quantity }}</td>
                        <td style="text-align: center; color: var(--text-secondary);">{{ $txn->balance }}</td>
                        <td style="color: var(--text-secondary);">{{ $txn->creator->name }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center" style="color: var(--text-muted); padding: 2rem;">ไม่มีรายการ</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
