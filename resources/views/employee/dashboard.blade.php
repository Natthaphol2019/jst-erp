@extends('layouts.app')

@section('title', 'Employee Dashboard - JST ERP')

@section('content')

<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            <i class="fas fa-user-tie me-2" style="color: #818cf8;"></i>แดชบอร์ดพนักงาน
        </h4>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">สวัสดี, <strong style="color: var(--text-primary);">{{ auth()->user()->name }}</strong></p>
    </div>
    <div class="d-flex gap-2">
        <span class="erp-badge" style="background: rgba(107,114,128,0.12); color: #6b7280;">
            <i class="fas fa-user me-1"></i> Employee
        </span>
        <span class="erp-badge" style="background: rgba(52,211,153,0.12); color: #34d399;">
            <i class="fas fa-circle me-1" style="font-size: 6px;"></i> Online
        </span>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-3 g-md-4 mb-4">
    <!-- Active Borrowings -->
    <div class="col-6 col-xl-3">
        <div class="erp-stat-card">
            <div class="erp-stat-icon" style="background: rgba(56,189,248,0.12); color: #38bdf8;">
                <i class="fas fa-hand-holding"></i>
            </div>
            <div class="erp-stat-body">
                <div class="erp-stat-label">กำลังยืม</div>
                <div class="erp-stat-value">{{ number_format($activeBorrowingsCount) }}</div>
            </div>
            <a href="{{ route('employee.borrowings') }}" class="erp-stat-link" style="color: #38bdf8;">
                ดูรายละเอียด <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- Pending Requests -->
    <div class="col-6 col-xl-3">
        <div class="erp-stat-card">
            <div class="erp-stat-icon" style="background: rgba(251,191,36,0.12); color: #fbbf24;">
                <i class="fas fa-clock"></i>
            </div>
            <div class="erp-stat-body">
                <div class="erp-stat-label">รออนุมัติ</div>
                <div class="erp-stat-value">{{ number_format($pendingRequestsCount) }}</div>
            </div>
            <a href="{{ route('employee.requisitions') }}" class="erp-stat-link" style="color: #fbbf24;">
                ตรวจสอบสถานะ <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- Total Borrowings -->
    <div class="col-6 col-xl-3">
        <div class="erp-stat-card">
            <div class="erp-stat-icon" style="background: rgba(167,139,250,0.12); color: #a78bfa;">
                <i class="fas fa-history"></i>
            </div>
            <div class="erp-stat-body">
                <div class="erp-stat-label">ยืมทั้งหมด</div>
                <div class="erp-stat-value">{{ number_format($totalBorrowings) }}</div>
            </div>
            <span style="color: var(--text-secondary); font-size: 13px;">ครั้ง</span>
        </div>
    </div>

    <!-- Total Requisitions -->
    <div class="col-6 col-xl-3">
        <div class="erp-stat-card">
            <div class="erp-stat-icon" style="background: rgba(52,211,153,0.12); color: #34d399;">
                <i class="fas fa-file-invoice"></i>
            </div>
            <div class="erp-stat-body">
                <div class="erp-stat-label">เบิกทั้งหมด</div>
                <div class="erp-stat-value">{{ number_format($totalRequisitions) }}</div>
            </div>
            <span style="color: var(--text-secondary); font-size: 13px;">ครั้ง</span>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Left Column - Main Content -->
    <div class="col-lg-8">
        <!-- Quick Actions -->
        <div class="erp-card mb-4">
            <div class="erp-card-header">
                <span class="erp-card-title">
                    <i class="fas fa-bolt me-2" style="color: #818cf8;"></i>เมนูด่วน
                </span>
            </div>
            <div class="erp-card-body">
                <div class="row g-3">
                    <div class="col-6 col-md-3">
                        <a href="{{ route('employee.borrowing.create') }}" class="erp-quick-action">
                            <div class="erp-quick-action-icon" style="background: rgba(129,140,248,0.15); color: #818cf8;">
                                <i class="fas fa-hand-holding"></i>
                            </div>
                            <div class="erp-quick-action-text">
                                <strong>ยืมอุปกรณ์</strong>
                                <small>ยื่นคำขอยืม</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="{{ route('employee.requisition.create') }}" class="erp-quick-action">
                            <div class="erp-quick-action-icon" style="background: rgba(99,102,241,0.15); color: #6366f1;">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <div class="erp-quick-action-text">
                                <strong>เบิกอุปทาน</strong>
                                <small>ยื่นคำขอเบิก</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="{{ route('employee.borrowings') }}" class="erp-quick-action">
                            <div class="erp-quick-action-icon" style="background: rgba(56,189,248,0.15); color: #38bdf8;">
                                <i class="fas fa-list-check"></i>
                            </div>
                            <div class="erp-quick-action-text">
                                <strong>รายการยืม</strong>
                                <small>ดูทั้งหมด</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="{{ route('employee.requisitions') }}" class="erp-quick-action">
                            <div class="erp-quick-action-icon" style="background: rgba(52,211,153,0.15); color: #34d399;">
                                <i class="fas fa-file-invoice"></i>
                            </div>
                            <div class="erp-quick-action-text">
                                <strong>รายการเบิก</strong>
                                <small>ดูทั้งหมด</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- My Active Borrowings -->
        <div class="erp-card mb-4">
            <div class="erp-card-header d-flex justify-content-between align-items-center">
                <span class="erp-card-title">
                    <i class="fas fa-hand-holding me-2" style="color: #818cf8;"></i>อุปกรณ์ที่ยืมอยู่
                </span>
                <a href="{{ route('employee.borrowings') }}" class="erp-btn-secondary" style="padding: 4px 12px; font-size: 12px;">
                    ดูทั้งหมด <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="erp-card-body p-0">
                <div class="erp-table-wrap">
                    <table class="erp-table">
                        <thead>
                            <tr>
                                <th class="ps-4">เลขที่</th>
                                <th>วันที่ยืม</th>
                                <th>กำหนดคืน</th>
                                <th>สถานะ</th>
                                <th class="text-center">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($myBorrowings as $borrowing)
                            <tr>
                                <td class="ps-4">
                                    <a href="{{ route('employee.borrowing.show', $borrowing->id) }}" class="text-decoration-none fw-semibold" style="color: var(--accent);">
                                        #{{ str_pad($borrowing->id, 4, '0', STR_PAD_LEFT) }}
                                    </a>
                                </td>
                                <td style="color: var(--text-secondary);">{{ \Carbon\Carbon::parse($borrowing->req_date)->format('d/m/Y') }}</td>
                                <td>
                                    @php
                                        $dueDate = \Carbon\Carbon::parse($borrowing->due_date);
                                        $isOverdue = $dueDate->isPast() && $borrowing->status !== 'returned_all';
                                        $daysLeft = $dueDate->diffInDays(now(), false);
                                    @endphp
                                    <span class="{{ $isOverdue ? 'fw-bold' : '' }}" style="color: {{ $isOverdue ? '#f87171' : 'var(--text-secondary)' }};">
                                        {{ $dueDate->format('d/m/Y') }}
                                        @if($isOverdue)
                                            <br><small style="color: #f87171;"><i class="fas fa-exclamation-triangle"></i> เกิน {{ abs($daysLeft) }} วัน</small>
                                        @elseif($daysLeft > 0 && $daysLeft <= 3)
                                            <br><small style="color: #fbbf24;"><i class="fas fa-clock"></i> อีก {{ $daysLeft }} วัน</small>
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    @if($borrowing->status === 'approved')
                                        <span class="erp-badge" style="background: rgba(52,211,153,0.12); color: #34d399;">กำลังยืม</span>
                                    @elseif($borrowing->status === 'returned_partial')
                                        <span class="erp-badge" style="background: rgba(56,189,248,0.12); color: #38bdf8;">คืนบางส่วน</span>
                                    @elseif($borrowing->status === 'returned_all')
                                        <span class="erp-badge" style="background: rgba(107,114,128,0.12); color: #6b7280;">คืนครบ</span>
                                    @else
                                        <span class="erp-badge" style="background: rgba(107,114,128,0.12); color: #6b7280;">{{ $borrowing->status }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-1 justify-content-center">
                                        <a href="{{ route('employee.borrowing.show', $borrowing->id) }}" class="erp-btn-secondary" style="padding: 4px 8px; font-size: 12px;" title="ดูรายละเอียด">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('employee.borrowings', ['status' => 'approved']) }}" class="erp-btn-secondary" style="padding: 4px 8px; font-size: 12px; border-color: #34d399; color: #34d399;" title="คืนสินค้า">
                                            <i class="fas fa-undo"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center" style="color: var(--text-muted); padding: 2rem 0;">
                                    <i class="fas fa-inbox fs-4 d-block mb-2" style="opacity: 0.5;"></i>
                                    ไม่มีอุปกรณ์ที่ยืมอยู่
                                    <br>
                                    <a href="{{ route('employee.borrowing.create') }}" class="text-decoration-none" style="color: var(--accent); font-size: 13px;">
                                        <i class="fas fa-plus me-1"></i>ยืมอุปกรณ์ใหม่
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- My Requisitions -->
        <div class="erp-card">
            <div class="erp-card-header d-flex justify-content-between align-items-center">
                <span class="erp-card-title">
                    <i class="fas fa-list-check me-2" style="color: #818cf8;"></i>รายการเบิกของฉัน
                </span>
                <a href="{{ route('employee.requisitions') }}" class="erp-btn-secondary" style="padding: 4px 12px; font-size: 12px;">
                    ดูทั้งหมด <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="erp-card-body p-0">
                <div class="erp-table-wrap">
                    <table class="erp-table">
                        <thead>
                            <tr>
                                <th class="ps-4">เลขที่</th>
                                <th>ประเภท</th>
                                <th>วันที่ขอ</th>
                                <th>กำหนดรับ</th>
                                <th>สถานะ</th>
                                <th class="text-center">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($myRequisitions as $req)
                            <tr>
                                <td class="ps-4">
                                    @if($req->req_type === 'borrow')
                                        <a href="{{ route('employee.borrowing.show', $req->id) }}" class="text-decoration-none fw-semibold" style="color: var(--accent);">
                                            #{{ str_pad($req->id, 4, '0', STR_PAD_LEFT) }}
                                        </a>
                                    @else
                                        <a href="{{ route('employee.requisition.show', $req->id) }}" class="text-decoration-none fw-semibold" style="color: var(--accent);">
                                            #{{ str_pad($req->id, 4, '0', STR_PAD_LEFT) }}
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    @if($req->req_type === 'borrow')
                                        <span class="erp-badge" style="background: rgba(56,189,248,0.12); color: #38bdf8;"><i class="fas fa-hand-holding me-1"></i>ยืม</span>
                                    @else
                                        <span class="erp-badge" style="background: rgba(99,102,241,0.12); color: #818cf8;"><i class="fas fa-clipboard-list me-1"></i>เบิก</span>
                                    @endif
                                </td>
                                <td style="color: var(--text-secondary);">{{ \Carbon\Carbon::parse($req->req_date)->format('d/m/Y') }}</td>
                                <td style="color: var(--text-secondary);">{{ \Carbon\Carbon::parse($req->due_date)->format('d/m/Y') }}</td>
                                <td>
                                    @if($req->status === 'pending')
                                        <span class="erp-badge" style="background: rgba(251,191,36,0.12); color: #fbbf24;"><i class="fas fa-clock me-1"></i>รออนุมัติ</span>
                                    @elseif($req->status === 'approved')
                                        <span class="erp-badge" style="background: rgba(52,211,153,0.12); color: #34d399;"><i class="fas fa-check me-1"></i>อนุมัติ</span>
                                    @elseif($req->status === 'returned_all')
                                        <span class="erp-badge" style="background: rgba(107,114,128,0.12); color: #6b7280;"><i class="fas fa-check-double me-1"></i>คืนครบ</span>
                                    @elseif($req->status === 'returned_partial')
                                        <span class="erp-badge" style="background: rgba(56,189,248,0.12); color: #38bdf8;">คืนบางส่วน</span>
                                    @elseif($req->status === 'rejected')
                                        <span class="erp-badge" style="background: rgba(239,68,68,0.12); color: #f87171;"><i class="fas fa-times me-1"></i>ปฏิเสธ</span>
                                    @else
                                        <span class="erp-badge" style="background: rgba(107,114,128,0.12); color: #6b7280;">{{ $req->status }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ $req->req_type === 'borrow' ? route('employee.borrowing.show', $req->id) : route('employee.requisition.show', $req->id) }}" class="erp-btn-secondary" style="padding: 4px 8px; font-size: 12px;">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center" style="color: var(--text-muted); padding: 2rem 0;">
                                    <i class="fas fa-inbox fs-4 d-block mb-2" style="opacity: 0.5;"></i>
                                    ยังไม่มีรายการเบิก
                                    <br>
                                    <a href="{{ route('employee.requisition.create') }}" class="text-decoration-none" style="color: var(--accent); font-size: 13px;">
                                        <i class="fas fa-plus me-1"></i>เบิกอุปทานใหม่
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column - Sidebar -->
    <div class="col-lg-4">
        <!-- My Profile Summary (Read-only) -->
        <div class="erp-card mb-4">
            <div class="erp-card-header">
                <span class="erp-card-title">
                    <i class="fas fa-user-circle me-2" style="color: #818cf8;"></i>ข้อมูลของฉัน
                </span>
            </div>
            <div class="erp-card-body">
                <div class="text-center mb-3">
                    <div style="width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, var(--accent), #a78bfa); display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; color: white; font-size: 32px; overflow: hidden; border: 3px solid var(--accent);">
                        @if(auth()->user()->employee && auth()->user()->employee->profile_image)
                            <img src="{{ asset('storage/' . auth()->user()->employee->profile_image) }}" 
                                 style="width: 100%; height: 100%; object-fit: cover;"
                                 onerror="this.style.display='none'; this.parentElement.innerHTML='<i class=\'fas fa-user\'></i>'; this.parentElement.style.fontSize='32px';">
                        @else
                            <i class="fas fa-user"></i>
                        @endif
                    </div>
                    <h6 style="margin: 0; color: var(--text-primary);">{{ auth()->user()->employee->firstname }} {{ auth()->user()->employee->lastname }}</h6>
                    <small style="color: var(--text-muted);">{{ auth()->user()->employee->employee_code }}</small>
                </div>
                <div class="erp-info-list">
                    <div class="erp-info-item">
                        <i class="fas fa-building" style="color: var(--accent);"></i>
                        <div>
                            <small style="color: var(--text-muted); display: block;">แผนก</small>
                            <strong style="color: var(--text-primary);">{{ auth()->user()->employee->department->name ?? '-' }}</strong>
                        </div>
                    </div>
                    <div class="erp-info-item">
                        <i class="fas fa-briefcase" style="color: var(--accent);"></i>
                        <div>
                            <small style="color: var(--text-muted); display: block;">ตำแหน่ง</small>
                            <strong style="color: var(--text-primary);">{{ auth()->user()->employee->position->name ?? '-' }}</strong>
                        </div>
                    </div>
                    <div class="erp-info-item">
                        <i class="fas fa-phone" style="color: var(--accent);"></i>
                        <div>
                            <small style="color: var(--text-muted); display: block;">โทรศัพท์</small>
                            <strong style="color: var(--text-primary);">{{ auth()->user()->employee->phone ?? '-' }}</strong>
                        </div>
                    </div>
                </div>
                <div class="erp-alert erp-alert-info mt-3" style="font-size: 12px; padding: 8px 12px;">
                    <i class="fas fa-info-circle me-1"></i>หากต้องการแก้ไขข้อมูล กรุณาติดต่อ HR/Admin
                </div>
            </div>
        </div>

        <!-- Overdue Borrowings Alert -->
        @if($overdueBorrowings->count() > 0)
        <div class="erp-card mb-4" style="border-color: #f87171;">
            <div class="erp-card-header" style="background: rgba(239,68,68,0.08); border-bottom-color: rgba(239,68,68,0.2);">
                <span class="erp-card-title" style="color: #f87171;">
                    <i class="fas fa-exclamation-triangle me-2"></i>เกินกำหนดคืน
                </span>
                <span class="erp-badge" style="background: rgba(239,68,68,0.15); color: #f87171;">{{ $overdueBorrowings->count() }} รายการ</span>
            </div>
            <div class="erp-card-body p-0">
                <div class="erp-list">
                    @foreach($overdueBorrowings->take(3) as $borrowing)
                        <div class="erp-list-item" style="padding: 12px 16px; border-bottom: 1px solid var(--border);">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <a href="{{ route('employee.borrowing.show', $borrowing->id) }}" class="text-decoration-none fw-semibold" style="color: var(--accent);">
                                        #{{ str_pad($borrowing->id, 4, '0', STR_PAD_LEFT) }}
                                    </a>
                                    <div style="font-size: 12px; color: var(--text-muted);">
                                        กำหนดคืน: {{ \Carbon\Carbon::parse($borrowing->due_date)->format('d/m/Y') }}
                                    </div>
                                </div>
                                <span class="erp-badge" style="background: rgba(239,68,68,0.12); color: #f87171; font-size: 11px;">
                                    เกิน {{ \Carbon\Carbon::parse($borrowing->due_date)->diffInDays(now()) }} วัน
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="erp-card-footer" style="text-align: center;">
                <a href="{{ route('employee.borrowings', ['status' => 'approved']) }}" style="color: #f87171; font-size: 13px; text-decoration: none;">
                    ดูทั้งหมด <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
        @endif

        <!-- Recent Notifications -->
        <div class="erp-card mb-4">
            <div class="erp-card-header d-flex justify-content-between align-items-center">
                <span class="erp-card-title">
                    <i class="fas fa-bell me-2" style="color: #818cf8;"></i>การแจ้งเตือน
                </span>
                <a href="{{ route('notifications.index') }}" class="erp-btn-secondary" style="padding: 4px 12px; font-size: 12px;">
                    ดูทั้งหมด
                </a>
            </div>
            <div class="erp-card-body p-0">
                @if($recentNotifications->count() > 0)
                    <div class="erp-list">
                        @foreach($recentNotifications->take(5) as $notif)
                            <div class="erp-list-item" style="padding: 10px 16px; border-bottom: 1px solid var(--border); {{ $notif->read_at ? '' : 'background: rgba(129,140,248,0.05);' }}">
                                <div class="d-flex gap-3">
                                    <div style="margin-top: 2px;">
                                        @if(str_contains($notif->type, 'borrowing'))
                                            <i class="fas fa-hand-holding" style="color: #38bdf8;"></i>
                                        @elseif(str_contains($notif->type, 'requisition'))
                                            <i class="fas fa-clipboard-list" style="color: #818cf8;"></i>
                                        @else
                                            <i class="fas fa-bell" style="color: #6b7280;"></i>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <div style="font-size: 13px; color: var(--text-primary); {{ $notif->read_at ? 'opacity: 0.7;' : 'font-weight: 500;' }}">
                                            {{ $notif->data['message'] ?? 'แจ้งเตือนใหม่' }}
                                        </div>
                                        <small style="color: var(--text-muted);">
                                            {{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}
                                        </small>
                                    </div>
                                    @if(!$notif->read_at)
                                        <span style="width: 8px; height: 8px; border-radius: 50%; background: var(--accent); flex-shrink: 0; margin-top: 6px;"></span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4" style="color: var(--text-muted);">
                        <i class="fas fa-bell-slash fs-4 d-block mb-2" style="opacity: 0.5;"></i>
                        ไม่มีการแจ้งเตือนใหม่
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Links -->
        <div class="erp-card">
            <div class="erp-card-header">
                <span class="erp-card-title">
                    <i class="fas fa-link me-2" style="color: #818cf8;"></i>ลิงก์ด่วน
                </span>
            </div>
            <div class="erp-card-body p-0">
                <div class="erp-list">
                    <a href="{{ route('employee.borrowing.create') }}" class="erp-list-item" style="padding: 12px 16px; text-decoration: none; color: inherit; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 12px;">
                        <i class="fas fa-plus-circle" style="color: #38bdf8; width: 20px; text-align: center;"></i>
                        <div class="flex-grow-1">
                            <strong style="color: var(--text-primary);">ยืมอุปกรณ์ใหม่</strong>
                            <div style="font-size: 11px; color: var(--text-muted);">ยื่นคำขอยืมอุปกรณ์</div>
                        </div>
                        <i class="fas fa-chevron-right" style="color: var(--text-muted); font-size: 12px;"></i>
                    </a>
                    <a href="{{ route('employee.requisition.create') }}" class="erp-list-item" style="padding: 12px 16px; text-decoration: none; color: inherit; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 12px;">
                        <i class="fas fa-clipboard-list" style="color: #818cf8; width: 20px; text-align: center;"></i>
                        <div class="flex-grow-1">
                            <strong style="color: var(--text-primary);">เบิกอุปทานใหม่</strong>
                            <div style="font-size: 11px; color: var(--text-muted);">ยื่นคำขอเบิกวัสดุ</div>
                        </div>
                        <i class="fas fa-chevron-right" style="color: var(--text-muted); font-size: 12px;"></i>
                    </a>
                    <a href="{{ route('employee.borrowings', ['status' => 'approved']) }}" class="erp-list-item" style="padding: 12px 16px; text-decoration: none; color: inherit; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 12px;">
                        <i class="fas fa-undo" style="color: #34d399; width: 20px; text-align: center;"></i>
                        <div class="flex-grow-1">
                            <strong style="color: var(--text-primary);">คืนอุปกรณ์</strong>
                            <div style="font-size: 11px; color: var(--text-muted);">คืนสินค้ายืม</div>
                        </div>
                        <i class="fas fa-chevron-right" style="color: var(--text-muted); font-size: 12px;"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
/* Quick Actions */
.erp-quick-action {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px;
    border-radius: 12px;
    background: var(--input-bg, #f9fafb);
    border: 2px solid var(--border, #e5e7eb);
    text-decoration: none;
    color: inherit;
    transition: all 0.2s ease;
    height: 100%;
}

.erp-quick-action:hover {
    border-color: var(--accent, #818cf8);
    background: rgba(129,140,248,0.08);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(129,140,248,0.15);
    text-decoration: none;
    color: inherit;
}

.erp-quick-action-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}

.erp-quick-action-text {
    display: flex;
    flex-direction: column;
}

.erp-quick-action-text strong {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-primary);
}

.erp-quick-action-text small {
    font-size: 12px;
    color: var(--text-muted);
}

/* Info List */
.erp-info-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.erp-info-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
}

.erp-info-item i {
    margin-top: 3px;
    width: 20px;
    text-align: center;
}

/* List Styles */
.erp-list {
    display: flex;
    flex-direction: column;
}

.erp-list-item {
    transition: background 0.2s ease;
}

.erp-list-item:hover {
    background: rgba(129,140,248,0.05);
}
</style>
@endpush

@endsection
