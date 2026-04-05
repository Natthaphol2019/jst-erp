@extends('layouts.app')

@section('title', 'Admin Dashboard - JST ERP')

@section('content')

{{-- Page Header --}}
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            <i class="fas fa-tachometer-alt me-2" style="color: #818cf8;"></i>แดชบอร์ดผู้ดูแลระบบ
        </h4>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">
            ยินดีต้อนรับกลับมา, <span style="color: var(--text-secondary); font-weight: 500;">{{ auth()->user()->name }}</span>
        </p>
    </div>
    <span style="font-size: 11px; padding: 5px 12px; border-radius: 10px;
                 background: rgba(99,102,241,0.12); color: #818cf8; font-weight: 600; letter-spacing: 0.05em;">
        <i class="fas fa-shield-alt me-1"></i> ADMIN
    </span>
</div>

{{-- ── Stats Row 1 ── --}}
<div class="row g-3 mb-3">

    {{-- พนักงานทั้งหมด --}}
    <div class="col-xl-3 col-md-6">
        <div class="erp-stat-card">
            <div class="erp-stat-icon" style="background: rgba(99,102,241,0.12); color: #818cf8;">
                <i class="fas fa-users"></i>
            </div>
            <div class="erp-stat-body">
                <div class="erp-stat-label">พนักงานทั้งหมด</div>
                <div class="erp-stat-value">{{ number_format($totalEmployees) }}</div>
            </div>
            <a href="{{ route('hr.employees.index') }}" class="erp-stat-link" style="color: #818cf8;">
                ดูรายละเอียด <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

    {{-- สินค้าในคลัง --}}
    <div class="col-xl-3 col-md-6">
        <div class="erp-stat-card">
            <div class="erp-stat-icon" style="background: rgba(52,211,153,0.12); color: #34d399;">
                <i class="fas fa-box-open"></i>
            </div>
            <div class="erp-stat-body">
                <div class="erp-stat-label">สินค้าในคลัง</div>
                <div class="erp-stat-value">{{ number_format($totalItems) }}</div>
            </div>
            <a href="{{ route('inventory.items.index') }}" class="erp-stat-link" style="color: #34d399;">
                จัดการสินค้า <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

    {{-- รออนุมัติ --}}
    <div class="col-xl-3 col-md-6">
        <div class="erp-stat-card">
            <div class="erp-stat-icon" style="background: rgba(251,191,36,0.12); color: #fbbf24;">
                <i class="fas fa-clock"></i>
            </div>
            <div class="erp-stat-body">
                <div class="erp-stat-label">รออนุมัติ</div>
                <div class="erp-stat-value">{{ number_format($pendingRequisitions) }}</div>
            </div>
            <a href="{{ route('inventory.requisition.index') }}" class="erp-stat-link" style="color: #fbbf24;">
                ตรวจสอบรายการ <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

    {{-- เกินกำหนดคืน --}}
    <div class="col-xl-3 col-md-6">
        <div class="erp-stat-card">
            <div class="erp-stat-icon" style="background: rgba(239,68,68,0.12); color: #f87171;">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="erp-stat-body">
                <div class="erp-stat-label">เกินกำหนดคืน</div>
                <div class="erp-stat-value" style="color: #f87171;">{{ number_format($overdueBorrowings) }}</div>
            </div>
            <a href="{{ route('inventory.borrowing.index') }}" class="erp-stat-link" style="color: #f87171;">
                ดูรายการค้าง <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

{{-- ── Stats Row 2 ── --}}
<div class="row g-3 mb-4">

    {{-- เข้างานวันนี้ --}}
    <div class="col-xl-4 col-md-6">
        <div class="erp-stat-card">
            <div class="erp-stat-icon" style="background: rgba(56,189,248,0.12); color: #38bdf8;">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="erp-stat-body">
                <div class="erp-stat-label">เข้างานวันนี้</div>
                <div class="erp-stat-value">{{ number_format($todayAttendance) }}</div>
            </div>
        </div>
    </div>

    {{-- แผนก --}}
    <div class="col-xl-4 col-md-6">
        <div class="erp-stat-card">
            <div class="erp-stat-icon" style="background: rgba(167,139,250,0.12); color: #a78bfa;">
                <i class="fas fa-sitemap"></i>
            </div>
            <div class="erp-stat-body">
                <div class="erp-stat-label">แผนกทั้งหมด</div>
                <div class="erp-stat-value">{{ number_format($departmentCount) }}</div>
            </div>
        </div>
    </div>

    {{-- ผู้ใช้งานระบบ --}}
    <div class="col-xl-4 col-md-12">
        <div class="erp-stat-card">
            <div class="erp-stat-icon" style="background: rgba(45,212,191,0.12); color: #2dd4bf;">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="erp-stat-body">
                <div class="erp-stat-label">ผู้ใช้งานระบบ</div>
                <div class="erp-stat-value">{{ number_format($totalUsers) }}</div>
            </div>
        </div>
    </div>
</div>

{{-- ── Bottom: Table + Low Stock ── --}}
<div class="row g-3">

    {{-- รายการล่าสุด --}}
    <div class="col-lg-8">
        <div class="erp-card h-100">
            <div class="erp-card-header">
                <span class="erp-card-title">
                    <i class="fas fa-list-ul me-2" style="color: #818cf8;"></i>รายการเบิก/ยืมล่าสุด
                </span>
                <a href="{{ route('inventory.requisition.index') }}" class="erp-card-action">
                    ดูทั้งหมด <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="erp-table-wrap">
                <table class="erp-table">
                    <thead>
                        <tr>
                            <th style="width: 80px;">เลขที่</th>
                            <th>ผู้ขอ</th>
                            <th style="width: 90px;">ประเภท</th>
                            <th style="width: 110px;">วันที่ขอ</th>
                            <th style="width: 110px;">สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentRequisitions as $req)
                        <tr>
                            <td>
                                <a href="{{ route('inventory.requisition.show', $req->id) }}"
                                   style="color: #818cf8; text-decoration: none; font-weight: 500;">
                                    #{{ $req->id }}
                                </a>
                            </td>
                            <td style="color: var(--text-secondary);">
                                @if($req->employee)
                                    {{ $req->employee->firstname }} {{ $req->employee->lastname }}
                                @else
                                    <span style="color: var(--text-muted);">-</span>
                                @endif
                            </td>
                            <td>
                                @if($req->req_type === 'borrow')
                                    <span class="erp-badge" style="background: rgba(56,189,248,0.12); color: #38bdf8;">
                                        <i class="fas fa-hand-holding me-1"></i>ยืม
                                    </span>
                                @else
                                    <span class="erp-badge" style="background: rgba(99,102,241,0.12); color: #818cf8;">
                                        <i class="fas fa-file-alt me-1"></i>เบิก
                                    </span>
                                @endif
                            </td>
                            <td style="color: var(--text-muted); font-size: 12px;">
                                {{ \Carbon\Carbon::parse($req->req_date)->format('d/m/Y') }}
                            </td>
                            <td>
                                @if($req->status === 'pending')
                                    <span class="erp-badge" style="background: rgba(251,191,36,0.12); color: #fbbf24;">
                                        <i class="fas fa-clock me-1"></i>รออนุมัติ
                                    </span>
                                @elseif($req->status === 'approved')
                                    <span class="erp-badge" style="background: rgba(52,211,153,0.12); color: #34d399;">
                                        <i class="fas fa-check me-1"></i>อนุมัติ
                                    </span>
                                @elseif($req->status === 'returned_all')
                                    <span class="erp-badge" style="background: rgba(255,255,255,0.06); color: var(--text-muted);">
                                        <i class="fas fa-undo me-1"></i>คืนครบ
                                    </span>
                                @elseif($req->status === 'returned_partial')
                                    <span class="erp-badge" style="background: rgba(56,189,248,0.1); color: #38bdf8;">
                                        <i class="fas fa-undo me-1"></i>คืนบางส่วน
                                    </span>
                                @elseif($req->status === 'rejected')
                                    <span class="erp-badge" style="background: rgba(239,68,68,0.12); color: #f87171;">
                                        <i class="fas fa-times me-1"></i>ปฏิเสธ
                                    </span>
                                @else
                                    <span class="erp-badge" style="background: rgba(255,255,255,0.06); color: var(--text-muted);">
                                        {{ $req->status }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 40px 0; color: var(--text-muted);">
                                <i class="fas fa-inbox" style="font-size: 28px; display: block; margin-bottom: 8px;"></i>
                                ยังไม่มีรายการ
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- สินค้าใกล้หมด --}}
    <div class="col-lg-4">
        <div class="erp-card h-100">
            <div class="erp-card-header">
                <span class="erp-card-title">
                    <i class="fas fa-bell me-2" style="color: #f87171;"></i>สินค้าใกล้หมด
                </span>
                <a href="{{ route('inventory.items.index') }}" class="erp-card-action" style="color: #f87171; border-color: rgba(239,68,68,0.25);">
                    จัดการ <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="erp-table-wrap">
                <table class="erp-table">
                    <thead>
                        <tr>
                            <th>สินค้า</th>
                            <th style="text-align: right; width: 90px;">คงเหลือ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lowStockItems as $item)
                        <tr>
                            <td>
                                <div style="font-size: 13px; font-weight: 500; color: var(--text-secondary); line-height: 1.3;">
                                    {{ $item->name }}
                                </div>
                                <div style="font-size: 11px; color: var(--text-muted); margin-top: 2px;">
                                    {{ $item->item_code }}
                                </div>
                            </td>
                            <td style="text-align: right;">
                                @if($item->current_stock == 0)
                                    <span class="erp-badge" style="background: rgba(239,68,68,0.12); color: #f87171;">
                                        หมด
                                    </span>
                                @else
                                    <span class="erp-badge" style="background: rgba(251,191,36,0.12); color: #fbbf24;">
                                        {{ number_format($item->current_stock) }} {{ $item->unit }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" style="text-align: center; padding: 40px 0; color: #34d399;">
                                <i class="fas fa-check-circle" style="font-size: 28px; display: block; margin-bottom: 8px;"></i>
                                <span style="font-size: 13px;">สินค้าทั้งหมดเพียงพอ</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection