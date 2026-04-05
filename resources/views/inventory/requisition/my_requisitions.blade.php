@extends('layouts.app')

@section('title', 'รายการเบิกของฉัน - JST ERP')

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            <i class="fas fa-clipboard-list me-2" style="color: #818cf8;"></i>รายการเบิกของฉัน
        </h4>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">ดูประวัติการเบิกอุปทาน</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('employee.requisition.create') }}" class="erp-btn-primary">
            <i class="fas fa-plus me-2"></i>เบิกอุปทานใหม่
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
    <div class="col-6 col-md-4">
        <div class="erp-stat-card">
            <div class="erp-stat-icon" style="background: rgba(52,211,153,0.12); color: #34d399;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="erp-stat-body">
                <div class="erp-stat-label">เบิกแล้ว</div>
                <div class="erp-stat-value">{{ $requisitions->where('status', 'issued')->count() }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="erp-stat-card">
            <div class="erp-stat-icon" style="background: rgba(251,191,36,0.12); color: #fbbf24;">
                <i class="fas fa-clock"></i>
            </div>
            <div class="erp-stat-body">
                <div class="erp-stat-label">รออนุมัติ</div>
                <div class="erp-stat-value">{{ $requisitions->where('status', 'pending')->count() }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="erp-stat-card">
            <div class="erp-stat-icon" style="background: rgba(239,68,68,0.12); color: #f87171;">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="erp-stat-body">
                <div class="erp-stat-label">ปฏิเสธ</div>
                <div class="erp-stat-value">{{ $requisitions->where('status', 'rejected')->count() }}</div>
            </div>
        </div>
    </div>
</div>

{{-- Requisitions Table --}}
<div class="erp-card">
    <div class="erp-table-wrap">
        <table class="erp-table">
            <thead>
                <tr>
                    <th width="80">เลขที่</th>
                    <th width="100">วันที่เบิก</th>
                    <th>สินค้า</th>
                    <th width="80" style="text-align: center;">จำนวน</th>
                    <th width="100" style="text-align: center;">สถานะ</th>
                    <th width="100" style="text-align: center;">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requisitions as $requisition)
                    <tr>
                        <td><strong style="color: var(--text-primary);">#{{ str_pad($requisition->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                        <td style="color: var(--text-secondary);">{{ \Carbon\Carbon::parse($requisition->req_date)->format('d/m/Y') }}</td>
                        <td style="color: var(--text-secondary);">{{ $requisition->items->pluck('item.name')->join(', ') }}</td>
                        <td style="text-align: center; color: var(--text-secondary);">{{ $requisition->items->sum('quantity_requested') }}</td>
                        <td style="text-align: center;">
                            @php
                                $statusBadge = match($requisition->status) {
                                    'issued' => ['bg' => 'rgba(52,211,153,0.12)', 'color' => '#34d399', 'text' => 'เบิกแล้ว'],
                                    'pending' => ['bg' => 'rgba(251,191,36,0.12)', 'color' => '#fbbf24', 'text' => 'รออนุมัติ'],
                                    'rejected' => ['bg' => 'rgba(239,68,68,0.12)', 'color' => '#f87171', 'text' => 'ปฏิเสธ'],
                                    default => ['bg' => 'rgba(107,114,128,0.12)', 'color' => '#9ca3af', 'text' => $requisition->status]
                                };
                            @endphp
                            <span class="erp-badge" style="background: {{ $statusBadge['bg'] }}; color: {{ $statusBadge['color'] }}">
                                {{ $statusBadge['text'] }}
                            </span>
                        </td>
                        <td style="text-align: center;">
                            <a href="{{ route('employee.requisition.show', $requisition->id) }}"
                               class="erp-btn-secondary" title="ดูรายละเอียด" style="padding: 4px 8px; font-size: 12px;">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="erp-empty">
                                <i class="fas fa-inbox"></i>
                                <div>ไม่มีรายการเบิก</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($requisitions->hasPages())
        <div style="padding: 16px; border-top: 1px solid var(--border);">
            <div class="d-flex justify-content-between align-items-center">
                <div style="font-size: 13px; color: var(--text-secondary);">
                    แสดง <strong style="color: var(--text-primary);">{{ $requisitions->firstItem() }}</strong> ถึง <strong style="color: var(--text-primary);">{{ $requisitions->lastItem() }}</strong> จาก <strong style="color: var(--text-primary);">{{ $requisitions->total() }}</strong> รายการ
                </div>
                {{ $requisitions->links() }}
            </div>
        </div>
    @endif
</div>

@endsection
