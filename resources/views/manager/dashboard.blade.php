@extends('layouts.app')

@section('title', 'Manager Dashboard - JST ERP')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
                <i class="fas fa-briefcase me-2" style="color: #818cf8;"></i>แดชบอร์ดผู้จัดการ
            </h4>
            <p style="font-size: 13px; color: var(--text-muted); margin: 0;">ยินดีต้อนรับ, <strong style="color: var(--text-primary);">{{ auth()->user()->name }}</strong></p>
        </div>
        <div>
            <span class="erp-badge" style="background: rgba(251,191,36,0.12); color: #fbbf24;">
                <i class="fas fa-shield-alt me-1"></i> Manager
            </span>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Employees -->
        <div class="col-xl-3 col-md-6">
            <div class="erp-stat-card">
                <div class="erp-stat-icon" style="background: rgba(99,102,241,0.12); color: #818cf8;">
                    <i class="fas fa-users"></i>
                </div>
                <div class="erp-stat-body">
                    <div class="erp-stat-label">พนักงานทั้งหมด</div>
                    <div class="erp-stat-value">{{ number_format($totalEmployees) }}</div>
                </div>
                <span style="color: var(--text-secondary); font-size: 13px;">พนักงาน aktif</span>
            </div>
        </div>

        <!-- Departments -->
        <div class="col-xl-3 col-md-6">
            <div class="erp-stat-card">
                <div class="erp-stat-icon" style="background: rgba(56,189,248,0.12); color: #38bdf8;">
                    <i class="fas fa-sitemap"></i>
                </div>
                <div class="erp-stat-body">
                    <div class="erp-stat-label">แผนก</div>
                    <div class="erp-stat-value">{{ number_format($totalDepartments) }}</div>
                </div>
                <span style="color: var(--text-secondary); font-size: 13px;">หน่วยงานทั้งหมด</span>
            </div>
        </div>

        <!-- Pending Approvals -->
        <div class="col-xl-3 col-md-6">
            <div class="erp-stat-card">
                <div class="erp-stat-icon" style="background: rgba(251,191,36,0.12); color: #fbbf24;">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <div class="erp-stat-body">
                    <div class="erp-stat-label">รออนุมัติ</div>
                    <div class="erp-stat-value">{{ number_format($pendingApprovals) }}</div>
                </div>
                <a href="{{ route('inventory.requisition.index') }}?status=pending" class="erp-stat-link" style="color: #fbbf24;">
                    ตรวจสอบรายการ <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Today Attendance -->
        <div class="col-xl-3 col-md-6">
            <div class="erp-stat-card">
                <div class="erp-stat-icon" style="background: rgba(52,211,153,0.12); color: #34d399;">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="erp-stat-body">
                    <div class="erp-stat-label">เข้างานวันนี้</div>
                    <div class="erp-stat-value">{{ number_format($todayAttendance) }}</div>
                </div>
                <span style="color: var(--text-secondary); font-size: 13px;">
                    {{ \Carbon\Carbon::now()->translatedFormat('l ที่ d F Y') }}
                </span>
            </div>
        </div>
    </div>

    <!-- Requisition Status Summary -->
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="erp-card">
                <div class="erp-card-header">
                    <span class="erp-card-title">
                        <i class="fas fa-chart-bar me-2" style="color: #818cf8;"></i>สรุปสถานะคำขอ
                    </span>
                </div>
                <div class="erp-card-body">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center p-3 rounded-3" style="background: rgba(251,191,36,0.12);">
                                <div class="flex-shrink-0">
                                    <div style="background: #fbbf24; border-radius: 50%; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-clock" style="color: #fff; font-size: 1.25rem;"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3 text-center">
                                    <h4 class="mb-0 fw-bold" style="color: #fbbf24;">{{ number_format($pendingCount) }}</h4>
                                    <small style="color: var(--text-secondary);">รออนุมัติ</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center p-3 rounded-3" style="background: rgba(52,211,153,0.12);">
                                <div class="flex-shrink-0">
                                    <div style="background: #34d399; border-radius: 50%; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-check" style="color: #fff; font-size: 1.25rem;"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3 text-center">
                                    <h4 class="mb-0 fw-bold" style="color: #34d399;">{{ number_format($approvedCount) }}</h4>
                                    <small style="color: var(--text-secondary);">อนุมัติ/กําลังยืม</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center p-3 rounded-3" style="background: rgba(107,114,128,0.12);">
                                <div class="flex-shrink-0">
                                    <div style="background: #6b7280; border-radius: 50%; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-check-double" style="color: #fff; font-size: 1.25rem;"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3 text-center">
                                    <h4 class="mb-0 fw-bold" style="color: #6b7280;">{{ number_format($completedCount) }}</h4>
                                    <small style="color: var(--text-secondary);">คืนครบแล้ว</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Department Statistics -->
        <div class="col-lg-5">
            <div class="erp-card h-100">
                <div class="erp-card-header">
                    <span class="erp-card-title">
                        <i class="fas fa-building me-2" style="color: #818cf8;"></i>สถิติแผนก
                    </span>
                </div>
                <div class="erp-card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($departments as $dept)
                        <div class="list-group-item border-0 px-3 py-3" style="background: var(--bg-surface); color: var(--text-secondary);">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <span class="fw-semibold" style="color: var(--text-primary);">{{ $dept->name }}</span>
                                    @if($dept->description)
                                        <br>
                                        <small style="color: var(--text-secondary);">{{ Str::limit($dept->description, 40) }}</small>
                                    @endif
                                </div>
                                <span class="erp-badge" style="background: rgba(99,102,241,0.12); color: #818cf8;">{{ $dept->employees_count }} คน</span>
                            </div>
                            @php
                                $percentage = $totalEmployees > 0 ? ($dept->employees_count / $totalEmployees) * 100 : 0;
                            @endphp
                            <div class="progress" style="height: 8px; background: var(--input-bg);">
                                <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%; background: #6366f1;"></div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4" style="color: var(--text-secondary);">
                            <i class="fas fa-inbox fs-4 d-block mb-2" style="color: var(--text-muted);"></i>
                            ยังไม่มีข้อมูลแผนก
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-lg-7">
            <div class="erp-card h-100">
                <div class="erp-card-header">
                    <span class="erp-card-title">
                        <i class="fas fa-activity me-2" style="color: #818cf8;"></i>กิจกรรมล่าสุด
                    </span>
                    <a href="{{ route('inventory.requisition.index') }}" class="erp-card-action">
                        ดูทั้งหมด <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="erp-card-body p-0">
                    <div class="erp-table-wrap">
                        <table class="erp-table">
                            <thead>
                                <tr>
                                    <th class="ps-4">เลขที่</th>
                                    <th>ผู้ขอ</th>
                                    <th>ประเภท</th>
                                    <th>วันที่</th>
                                    <th>สถานะ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentActivity as $activity)
                                <tr>
                                    <td class="ps-4">
                                        <a href="{{ route('inventory.requisition.show', $activity->id) }}" class="text-decoration-none fw-semibold" style="color: var(--accent);">
                                            #{{ $activity->id }}
                                        </a>
                                    </td>
                                    <td style="color: var(--text-secondary);">
                                        @if($activity->employee)
                                            {{ $activity->employee->firstname }} {{ $activity->employee->lastname }}
                                        @else
                                            <span style="color: var(--text-muted);">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($activity->req_type === 'borrow')
                                            <span class="erp-badge" style="background: rgba(56,189,248,0.12); color: #38bdf8;">ยืม</span>
                                        @else
                                            <span class="erp-badge" style="background: rgba(99,102,241,0.12); color: #818cf8;">เบิก</span>
                                        @endif
                                    </td>
                                    <td style="color: var(--text-secondary);">{{ \Carbon\Carbon::parse($activity->req_date)->format('d/m/Y') }}</td>
                                    <td>
                                        @if($activity->status === 'pending')
                                            <span class="erp-badge" style="background: rgba(251,191,36,0.12); color: #fbbf24;">รออนุมัติ</span>
                                        @elseif($activity->status === 'approved')
                                            <span class="erp-badge" style="background: rgba(52,211,153,0.12); color: #34d399;">อนุมัติ</span>
                                        @elseif($activity->status === 'returned_all')
                                            <span class="erp-badge" style="background: rgba(107,114,128,0.12); color: #6b7280;">คืนครบ</span>
                                        @elseif($activity->status === 'returned_partial')
                                            <span class="erp-badge" style="background: rgba(56,189,248,0.12); color: #38bdf8;">คืนบางส่วน</span>
                                        @elseif($activity->status === 'rejected')
                                            <span class="erp-badge" style="background: rgba(239,68,68,0.12); color: #f87171;">ปฏิเสธ</span>
                                        @else
                                            <span class="erp-badge" style="background: rgba(107,114,128,0.12); color: #6b7280;">{{ $activity->status }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center" style="color: var(--text-muted); padding: 2rem 0;">
                                        <i class="fas fa-inbox fs-4 d-block mb-2"></i>
                                        ยังไม่มีกิจกรรม
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

    <!-- Active Borrowings Summary -->
    <div class="row g-4 mt-2">
        <div class="col-12">
            <div class="erp-card">
                <div class="erp-card-header">
                    <span class="erp-card-title">
                        <i class="fas fa-sign-out-alt me-2" style="color: #818cf8;"></i>อุปกรณ์ที่กำลังยืม
                    </span>
                    <span class="erp-badge" style="background: rgba(56,189,248,0.12); color: #38bdf8;">{{ number_format($activeBorrowings) }} รายการ</span>
                </div>
                <div class="erp-card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="erp-card" style="background: var(--bg-raised);">
                                <div class="erp-card-body text-center">
                                    <i class="fas fa-box-open display-4 mb-3" style="color: #6366f1;"></i>
                                    <h5 class="fw-bold" style="color: #6366f1;">{{ number_format($activeBorrowings) }}</h5>
                                    <p class="mb-0" style="color: var(--text-secondary);">รายการที่กำลังยืม</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="erp-card" style="background: var(--bg-raised);">
                                <div class="erp-card-body text-center">
                                    <i class="fas fa-users display-4 mb-3" style="color: #34d399;"></i>
                                    <h5 class="fw-bold" style="color: #34d399;">{{ number_format($totalEmployees) }}</h5>
                                    <p class="mb-0" style="color: var(--text-secondary);">พนักงาน aktif</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
