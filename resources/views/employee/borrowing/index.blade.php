@extends('layouts.app')

@section('title', 'รายการยืมของฉัน - JST ERP')

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            <i class="fas fa-hand-holding me-2" style="color: #818cf8;"></i>รายการยืมของฉัน
        </h4>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">ดูประวัติการยืม-คืนอุปกรณ์</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('employee.borrowing.create') }}" class="erp-btn-primary">
            <i class="fas fa-plus me-2"></i>ยืมอุปกรณ์ใหม่
        </a>
        <a href="{{ route('employee.dashboard') }}" class="erp-btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>กลับ
        </a>
    </div>
</div>

@if(session('success'))
    <div class="erp-alert erp-alert-success mb-4">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    </div>
@endif

{{-- Stats Cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="erp-stat-card">
            <div class="erp-stat-icon" style="background: rgba(52,211,153,0.12); color: #34d399;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="erp-stat-body">
                <div class="erp-stat-label">กำลังยืม</div>
                <div class="erp-stat-value">{{ $borrowings->where('status', 'approved')->count() }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="erp-stat-card">
            <div class="erp-stat-icon" style="background: rgba(56,189,248,0.12); color: #38bdf8;">
                <i class="fas fa-hand-holding"></i>
            </div>
            <div class="erp-stat-body">
                <div class="erp-stat-label">คืนบางส่วน</div>
                <div class="erp-stat-value">{{ $borrowings->where('status', 'returned_partial')->count() }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="erp-stat-card">
            <div class="erp-stat-icon" style="background: rgba(107,114,128,0.12); color: #6b7280;">
                <i class="fas fa-check-double"></i>
            </div>
            <div class="erp-stat-body">
                <div class="erp-stat-label">คืนครบแล้ว</div>
                <div class="erp-stat-value">{{ $borrowings->where('status', 'returned_all')->count() }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="erp-stat-card">
            <div class="erp-stat-icon" style="background: rgba(239,68,68,0.12); color: #f87171;">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="erp-stat-body">
                <div class="erp-stat-label">เกินกำหนด</div>
                <div class="erp-stat-value">{{ $overdueCount }}</div>
            </div>
        </div>
    </div>
</div>

{{-- Borrowings Table --}}
<div class="erp-card">
    <div class="erp-table-wrap">
        <table class="erp-table">
            <thead>
                <tr>
                    <th width="80">เลขที่</th>
                    <th width="100">วันที่ยืม</th>
                    <th width="100">กำหนดคืน</th>
                    <th>สินค้า</th>
                    <th width="80" style="text-align: center;">จำนวน</th>
                    <th width="100" style="text-align: center;">สถานะ</th>
                    <th width="100" style="text-align: center;">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($borrowings as $borrowing)
                    @php
                        $isOverdue = $borrowing->due_date < now() && in_array($borrowing->status, ['approved', 'returned_partial']);
                    @endphp
                    <tr class="{{ $isOverdue ? 'table-danger' : '' }}">
                        <td><strong style="color: var(--text-primary);">#{{ str_pad($borrowing->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                        <td style="color: var(--text-secondary);">{{ \Carbon\Carbon::parse($borrowing->req_date)->format('d/m/Y') }}</td>
                        <td>
                            <span style="color: {{ $isOverdue ? '#f87171' : 'var(--text-secondary)' }}; font-weight: {{ $isOverdue ? '600' : '400' }};">
                                {{ \Carbon\Carbon::parse($borrowing->due_date)->format('d/m/Y') }}
                                @if($isOverdue)
                                    <i class="fas fa-exclamation-circle" title="เกินกำหนด" style="color: #f87171;"></i>
                                @endif
                            </span>
                        </td>
                        <td style="color: var(--text-secondary);">{{ $borrowing->items->pluck('item.name')->join(', ') }}</td>
                        <td style="text-align: center; color: var(--text-secondary);">{{ $borrowing->items->sum('quantity_requested') }}</td>
                        <td style="text-align: center;">
                            @php
                                $statusBadge = match($borrowing->status) {
                                    'approved' => ['bg' => 'rgba(52,211,153,0.12)', 'color' => '#34d399', 'text' => 'กำลังยืม'],
                                    'returned_partial' => ['bg' => 'rgba(56,189,248,0.12)', 'color' => '#38bdf8', 'text' => 'คืนบางส่วน'],
                                    'returned_all' => ['bg' => 'rgba(107,114,128,0.12)', 'color' => '#6b7280', 'text' => 'คืนครบแล้ว'],
                                    default => ['bg' => 'rgba(107,114,128,0.12)', 'color' => '#9ca3af', 'text' => $borrowing->status]
                                };
                            @endphp
                            <span class="erp-badge" style="background: {{ $statusBadge['bg'] }}; color: {{ $statusBadge['color'] }}">
                                {{ $statusBadge['text'] }}
                            </span>
                        </td>
                        <td style="text-align: center;">
                            <div class="d-flex gap-1 justify-content-center">
                                <a href="{{ route('employee.borrowing.show', $borrowing->id) }}"
                                   class="erp-btn-secondary" title="ดูรายละเอียด" style="padding: 4px 8px; font-size: 12px;">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if(in_array($borrowing->status, ['approved', 'returned_partial']))
                                    <a href="{{ route('employee.borrowing.return', $borrowing->id) }}"
                                       class="erp-btn-primary" title="คืนสินค้า" style="padding: 4px 8px; font-size: 12px;">
                                        <i class="fas fa-undo"></i>
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="erp-empty">
                                <i class="fas fa-inbox"></i>
                                <div>ไม่มีรายการยืม</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($borrowings->hasPages())
        <div style="padding: 16px; border-top: 1px solid var(--border);">
            <div class="d-flex justify-content-between align-items-center">
                <div style="font-size: 13px; color: var(--text-secondary);">
                    แสดง <strong style="color: var(--text-primary);">{{ $borrowings->firstItem() }}</strong> ถึง <strong style="color: var(--text-primary);">{{ $borrowings->lastItem() }}</strong> จาก <strong style="color: var(--text-primary);">{{ $borrowings->total() }}</strong> รายการ
                </div>
                {{ $borrowings->links() }}
            </div>
        </div>
    @endif
</div>

@endsection
