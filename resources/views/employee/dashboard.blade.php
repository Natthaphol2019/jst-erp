@extends('layouts.app')

@section('title', 'Employee Dashboard - JST ERP')

@section('content')
{{-- Mobile Navbar for Employee --}}
<nav class="employee-navbar d-lg-none">
    <div class="navbar-container">
        <div class="navbar-brand">
            <i class="fas fa-user-circle"></i>
            <span>เมนูพนักงาน</span>
        </div>
        <div class="navbar-toggle" onclick="toggleEmployeeMenu()">
            <i class="fas fa-bars"></i>
        </div>
    </div>
    <div class="navbar-menu" id="employeeMenu">
        <a href="{{ route('employee.dashboard') }}" class="navbar-link {{ request()->routeIs('employee.dashboard') ? 'active' : '' }}">
            <i class="fas fa-home"></i> แดชบอร์ด
        </a>
        <a href="{{ route('inventory.borrowing.create') }}" class="navbar-link">
            <i class="fas fa-hand-holding"></i> ยืมอุปกรณ์
        </a>
        <a href="{{ route('inventory.requisition.create') }}" class="navbar-link">
            <i class="fas fa-clipboard-list"></i> เบิกอุปทาน
        </a>
        <a href="{{ route('inventory.borrowing.index') }}" class="navbar-link">
            <i class="fas fa-list-alt"></i> รายการยืมของฉัน
        </a>
        <a href="{{ route('inventory.requisition.index') }}" class="navbar-link">
            <i class="fas fa-file-invoice"></i> รายการเบิกของฉัน
        </a>
        <a href="{{ route('profile.edit') }}" class="navbar-link">
            <i class="fas fa-user-edit"></i> โปรไฟล์
        </a>
        <a href="{{ route('notifications.index') }}" class="navbar-link">
            <i class="fas fa-bell"></i> การแจ้งเตือน
        </a>
        <form action="{{ route('logout') }}" method="POST" class="navbar-link logout-link">
            @csrf
            <button type="submit">
                <i class="fas fa-sign-out-alt"></i> ออกจากระบบ
            </button>
        </form>
    </div>
</nav>

<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
                <i class="fas fa-user-tie me-2" style="color: #818cf8;"></i>แดชบอร์ดพนักงาน
            </h4>
            <p style="font-size: 13px; color: var(--text-muted); margin: 0;">สวัสดี, <strong style="color: var(--text-primary);">{{ auth()->user()->name }}</strong></p>
        </div>
        <div>
            <span class="erp-badge" style="background: rgba(107,114,128,0.12); color: #6b7280;">
                <i class="fas fa-user me-1"></i> Employee
            </span>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 g-md-4 mb-4">
        <!-- Active Borrowings -->
        <div class="col-6 col-xl-4">
            <div class="erp-stat-card">
                <div class="erp-stat-icon" style="background: rgba(56,189,248,0.12); color: #38bdf8;">
                    <i class="fas fa-sign-out-alt"></i>
                </div>
                <div class="erp-stat-body">
                    <div class="erp-stat-label">กำลังยืม</div>
                    <div class="erp-stat-value">{{ number_format($activeBorrowingsCount) }}</div>
                </div>
                <a href="#my-borrowings" class="erp-stat-link" style="color: #38bdf8;">
                    ดูรายละเอียด <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Pending Requests -->
        <div class="col-6 col-xl-4">
            <div class="erp-stat-card">
                <div class="erp-stat-icon" style="background: rgba(251,191,36,0.12); color: #fbbf24;">
                    <i class="fas fa-history"></i>
                </div>
                <div class="erp-stat-body">
                    <div class="erp-stat-label">รออนุมัติ</div>
                    <div class="erp-stat-value">{{ number_format($pendingRequestsCount) }}</div>
                </div>
                <a href="#my-requisitions" class="erp-stat-link" style="color: #fbbf24;">
                    ตรวจสอบสถานะ <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Attendance This Month -->
        <div class="col-12 col-xl-4">
            <div class="erp-stat-card">
                <div class="erp-stat-icon" style="background: rgba(52,211,153,0.12); color: #34d399;">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="erp-stat-body">
                    <div class="erp-stat-label">เข้างานเดือนนี้</div>
                    <div class="erp-stat-value">{{ number_format($attendanceThisMonth) }} <span class="fs-6 fw-normal" style="color: var(--text-muted);">วัน</span></div>
                </div>
                <span style="color: var(--text-secondary); font-size: 13px;">
                    {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
                </span>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="erp-card">
                <div class="erp-card-header">
                    <span class="erp-card-title">
                        <i class="fas fa-bolt me-2" style="color: #818cf8;"></i>เมนูด่วน
                    </span>
                </div>
                <div class="erp-card-body">
                    <div class="row g-3">
                        <div class="col-6 col-md-4">
                            <a href="{{ route('inventory.borrowing.create') }}" class="erp-btn-primary w-100 py-3 py-md-4 d-block text-center" style="min-height: 100px;">
                                <i class="fas fa-hand-holding d-block mb-2" style="font-size: 28px;"></i>
                                <span class="fw-semibold d-block">ยืมอุปกรณ์</span>
                                <small style="color: var(--text-secondary); font-size: 11px;">ยื่นคำขอยืม</small>
                            </a>
                        </div>
                        <div class="col-6 col-md-4">
                            <a href="{{ route('inventory.requisition.create') }}" class="erp-btn-primary w-100 py-3 py-md-4 d-block text-center" style="background: #6366f1; min-height: 100px;">
                                <i class="fas fa-clipboard-list d-block mb-2" style="font-size: 28px;"></i>
                                <span class="fw-semibold d-block">เบิกอุปทาน</span>
                                <small style="color: var(--text-secondary); font-size: 11px;">ยื่นคำขอเบิก</small>
                            </a>
                        </div>
                        <div class="col-6 col-md-4">
                            <a href="{{ route('inventory.borrowing.index') }}" class="erp-btn-secondary w-100 py-3 py-md-4 d-block text-center" style="min-height: 100px;">
                                <i class="fas fa-list-check d-block mb-2" style="font-size: 28px;"></i>
                                <span class="fw-semibold d-block">รายการยืม</span>
                                <small style="color: var(--text-secondary); font-size: 11px;">ดูทั้งหมด</small>
                            </a>
                        </div>
                        <div class="col-6 col-md-4">
                            <a href="{{ route('inventory.requisition.index') }}" class="erp-btn-secondary w-100 py-3 py-md-4 d-block text-center" style="min-height: 100px;">
                                <i class="fas fa-file-invoice d-block mb-2" style="font-size: 28px;"></i>
                                <span class="fw-semibold d-block">รายการเบิก</span>
                                <small style="color: var(--text-secondary); font-size: 11px;">ดูทั้งหมด</small>
                            </a>
                        </div>
                        <div class="col-6 col-md-4">
                            <a href="{{ route('profile.edit') }}" class="erp-btn-secondary w-100 py-3 py-md-4 d-block text-center" style="min-height: 100px;">
                                <i class="fas fa-user-edit d-block mb-2" style="font-size: 28px;"></i>
                                <span class="fw-semibold d-block">โปรไฟล์</span>
                                <small style="color: var(--text-secondary); font-size: 11px;">แก้ไขข้อมูล</small>
                            </a>
                        </div>
                        <div class="col-6 col-md-4">
                            <a href="{{ route('notifications.index') }}" class="erp-btn-secondary w-100 py-3 py-md-4 d-block text-center" style="min-height: 100px;">
                                <i class="fas fa-bell d-block mb-2" style="font-size: 28px;"></i>
                                <span class="fw-semibold d-block">แจ้งเตือน</span>
                                <small style="color: var(--text-secondary); font-size: 11px;">การแจ้งเตือน</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- My Borrowings -->
        <div class="col-lg-6" id="my-borrowings">
            <div class="erp-card h-100">
                <div class="erp-card-header">
                    <span class="erp-card-title">
                        <i class="fas fa-sign-out-alt me-2" style="color: #818cf8;"></i>อุปกรณ์ที่ยืมอยู่
                    </span>
                    <span class="erp-badge" style="background: rgba(56,189,248,0.12); color: #38bdf8;">{{ $myBorrowings->count() }} รายการ</span>
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
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($myBorrowings as $borrowing)
                                <tr>
                                    <td class="ps-4">
                                        <a href="{{ route('inventory.borrowing.show', $borrowing->id) }}" class="text-decoration-none fw-semibold" style="color: var(--accent);">
                                            #{{ $borrowing->id }}
                                        </a>
                                    </td>
                                    <td style="color: var(--text-secondary);">{{ \Carbon\Carbon::parse($borrowing->req_date)->format('d/m/Y') }}</td>
                                    <td>
                                        @php
                                            $dueDate = \Carbon\Carbon::parse($borrowing->due_date);
                                            $isOverdue = $dueDate->isPast();
                                        @endphp
                                        <span class="{{ $isOverdue ? 'fw-bold' : '' }}" style="color: {{ $isOverdue ? '#f87171' : 'var(--text-secondary)' }};">
                                            {{ $dueDate->format('d/m/Y') }}
                                            @if($isOverdue)
                                                <i class="fas fa-exclamation-circle" title="เกินกำหนด" style="color: #f87171;"></i>
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        @if($borrowing->status === 'approved')
                                            <span class="erp-badge" style="background: rgba(52,211,153,0.12); color: #34d399;">กำลังยืม</span>
                                        @elseif($borrowing->status === 'returned_partial')
                                            <span class="erp-badge" style="background: rgba(251,191,36,0.12); color: #fbbf24;">คืนบางส่วน</span>
                                        @else
                                            <span class="erp-badge" style="background: rgba(107,114,128,0.12); color: #6b7280;">{{ $borrowing->status }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center" style="color: var(--text-muted); padding: 2rem 0;">
                                        <i class="fas fa-inbox fs-4 d-block mb-2"></i>
                                        ไม่มีอุปกรณ์ที่ยืมอยู่
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- My Requisitions -->
        <div class="col-lg-6" id="my-requisitions">
            <div class="erp-card h-100">
                <div class="erp-card-header">
                    <span class="erp-card-title">
                        <i class="fas fa-list-check me-2" style="color: #818cf8;"></i>คำขอของคุณ
                    </span>
                    <span class="erp-badge" style="background: rgba(107,114,128,0.12); color: #6b7280;">{{ $myRequisitions->count() }} รายการ</span>
                </div>
                <div class="erp-card-body p-0">
                    <div class="erp-table-wrap">
                        <table class="erp-table">
                            <thead>
                                <tr>
                                    <th class="ps-4">เลขที่</th>
                                    <th>ประเภท</th>
                                    <th>วันที่ขอ</th>
                                    <th>สถานะ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($myRequisitions as $req)
                                <tr>
                                    <td class="ps-4">
                                        @if($req->req_type === 'borrow')
                                            <a href="{{ route('inventory.borrowing.show', $req->id) }}" class="text-decoration-none fw-semibold" style="color: var(--accent);">
                                                #{{ $req->id }}
                                            </a>
                                        @else
                                            <a href="{{ route('inventory.requisition.show', $req->id) }}" class="text-decoration-none fw-semibold" style="color: var(--accent);">
                                                #{{ $req->id }}
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        @if($req->req_type === 'borrow')
                                            <span class="erp-badge" style="background: rgba(56,189,248,0.12); color: #38bdf8;">ยืม</span>
                                        @else
                                            <span class="erp-badge" style="background: rgba(99,102,241,0.12); color: #818cf8;">เบิก</span>
                                        @endif
                                    </td>
                                    <td style="color: var(--text-secondary);">{{ \Carbon\Carbon::parse($req->req_date)->format('d/m/Y') }}</td>
                                    <td>
                                        @if($req->status === 'pending')
                                            <span class="erp-badge" style="background: rgba(251,191,36,0.12); color: #fbbf24;">รออนุมัติ</span>
                                        @elseif($req->status === 'approved')
                                            <span class="erp-badge" style="background: rgba(52,211,153,0.12); color: #34d399;">อนุมัติ</span>
                                        @elseif($req->status === 'returned_all')
                                            <span class="erp-badge" style="background: rgba(107,114,128,0.12); color: #6b7280;">คืนครบ</span>
                                        @elseif($req->status === 'returned_partial')
                                            <span class="erp-badge" style="background: rgba(56,189,248,0.12); color: #38bdf8;">คืนบางส่วน</span>
                                        @elseif($req->status === 'rejected')
                                            <span class="erp-badge" style="background: rgba(239,68,68,0.12); color: #f87171;">ปฏิเสธ</span>
                                        @else
                                            <span class="erp-badge" style="background: rgba(107,114,128,0.12); color: #6b7280;">{{ $req->status }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center" style="color: var(--text-muted); padding: 2rem 0;">
                                        <i class="fas fa-inbox fs-4 d-block mb-2"></i>
                                        ยังไม่มีคำขอ
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

    <!-- Recent Attendance -->
    @if($recentAttendance->isNotEmpty())
    <div class="row g-4 mt-2">
        <div class="col-12">
            <div class="erp-card">
                <div class="erp-card-header">
                    <span class="erp-card-title">
                        <i class="fas fa-history me-2" style="color: #818cf8;"></i>ประวัติการเข้างานล่าสุด
                    </span>
                </div>
                <div class="erp-card-body p-0">
                    <div class="erp-table-wrap">
                        <table class="erp-table">
                            <thead>
                                <tr>
                                    <th class="ps-4">วันที่</th>
                                    <th class="text-center">เข้างาน</th>
                                    <th class="text-center">ออกงาน</th>
                                    <th>หมายเหตุ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentAttendance as $attendance)
                                <tr>
                                    <td class="ps-4">
                                        <strong style="color: var(--text-primary);">{{ \Carbon\Carbon::parse($attendance->work_date)->format('d/m/Y') }}</strong>
                                        <br>
                                        <small style="color: var(--text-muted);">{{ \Carbon\Carbon::parse($attendance->work_date)->translatedFormat('l') }}</small>
                                    </td>
                                    <td class="text-center">
                                        <span class="erp-badge" style="background: rgba(52,211,153,0.12); color: #34d399;">{{ $attendance->check_in_time ?? '-' }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if($attendance->check_out_time)
                                            <span class="erp-badge" style="background: rgba(107,114,128,0.12); color: #6b7280;">{{ $attendance->check_out_time }}</span>
                                        @else
                                            <span class="erp-badge" style="background: var(--input-bg); color: var(--text-muted);">ยังไม่ออก</span>
                                        @endif
                                    </td>
                                    <td style="color: var(--text-secondary);"><small>{{ $attendance->remark ?? '-' }}</small></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

{{-- Mobile Navbar Styles --}}
<style>
.employee-navbar {
    background: var(--bg-surface);
    border: 1px solid var(--border);
    border-radius: 12px;
    margin-bottom: 16px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.navbar-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 16px;
    background: linear-gradient(135deg, var(--accent) 0%, #818cf8 100%);
    color: white;
}

.navbar-brand {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 600;
    font-size: 16px;
}

.navbar-brand i {
    font-size: 24px;
}

.navbar-toggle {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255,255,255,0.2);
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.2s;
}

.navbar-toggle:active {
    background: rgba(255,255,255,0.3);
}

.navbar-menu {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
}

.navbar-menu.show {
    max-height: 500px;
}

.navbar-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 16px;
    color: var(--text-primary);
    text-decoration: none;
    border-bottom: 1px solid var(--border);
    transition: background 0.2s;
    font-size: 14px;
}

.navbar-link:last-child {
    border-bottom: none;
}

.navbar-link:active,
.navbar-link.active {
    background: rgba(99, 102, 241, 0.1);
    color: var(--accent);
}

.navbar-link i {
    width: 20px;
    text-align: center;
    font-size: 16px;
}

.navbar-link.logout-link {
    color: #f87171;
}

.navbar-link.logout-link button {
    background: none;
    border: none;
    color: inherit;
    font: inherit;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 12px;
    width: 100%;
    padding: 0;
}

/* Desktop: Hide mobile navbar */
@media (min-width: 992px) {
    .employee-navbar {
        display: none !important;
    }
}
</style>

@push('scripts')
<script>
function toggleEmployeeMenu() {
    const menu = document.getElementById('employeeMenu');
    menu.classList.toggle('show');
}

// Auto-close menu when clicking a link
document.querySelectorAll('.navbar-link').forEach(link => {
    link.addEventListener('click', () => {
        document.getElementById('employeeMenu').classList.remove('show');
    });
});
</script>
@endpush

@endsection
