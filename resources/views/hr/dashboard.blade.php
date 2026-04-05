@extends('layouts.app')

@section('title', 'HR Dashboard - JST ERP')

@section('content')
<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
                <i class="fas fa-user-tie me-2" style="color: #818cf8;"></i>แดชบอร์ดฝ่ายบุคคล
            </h4>
            <p style="font-size: 13px; color: var(--text-muted); margin: 0;">ยินดีต้อนรับ, <strong style="color: var(--text-primary);">{{ auth()->user()->name }}</strong></p>
        </div>
        <div>
            <span class="erp-badge" style="background: rgba(52,211,153,0.12); color: #34d399;">
                <i class="fas fa-shield-alt me-1"></i>HR
            </span>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">
        {{-- Active Employees --}}
        <div class="col-xl-3 col-md-6">
            <div class="erp-stat-card">
                <div class="erp-stat-icon" style="background: rgba(99,102,241,0.12); color: #818cf8;">
                    <i class="fas fa-users"></i>
                </div>
                <div class="erp-stat-body">
                    <div class="erp-stat-label">พนักงานทั้งหมด</div>
                    <div class="erp-stat-value">{{ number_format($activeEmployees) }}</div>
                </div>
                <a href="{{ route('hr.employees.index') }}" class="erp-stat-link" style="color: #818cf8;">
                    จัดการพนักงาน <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        {{-- Today's Attendance --}}
        <div class="col-xl-3 col-md-6">
            <div class="erp-stat-card">
                <div class="erp-stat-icon" style="background: rgba(52,211,153,0.12); color: #34d399;">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="erp-stat-body">
                    <div class="erp-stat-label">เข้างานวันนี้</div>
                    <div class="erp-stat-value">{{ number_format($todayAttendance) }}</div>
                </div>
                <a href="{{ route('hr.time-records.summary') }}" class="erp-stat-link" style="color: #34d399;">
                    ดูรายงาน <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        {{-- Departments --}}
        <div class="col-xl-3 col-md-6">
            <div class="erp-stat-card">
                <div class="erp-stat-icon" style="background: rgba(56,189,248,0.12); color: #38bdf8;">
                    <i class="fas fa-sitemap"></i>
                </div>
                <div class="erp-stat-body">
                    <div class="erp-stat-label">แผนก</div>
                    <div class="erp-stat-value">{{ number_format($totalDepartments) }}</div>
                </div>
                <a href="{{ route('hr.departments.index') }}" class="erp-stat-link" style="color: #38bdf8;">
                    จัดการแผนก <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        {{-- Positions --}}
        <div class="col-xl-3 col-md-6">
            <div class="erp-stat-card">
                <div class="erp-stat-icon" style="background: rgba(251,191,36,0.12); color: #fbbf24;">
                    <i class="fas fa-briefcase"></i>
                </div>
                <div class="erp-stat-body">
                    <div class="erp-stat-label">ตำแหน่งงาน</div>
                    <div class="erp-stat-value">{{ number_format($totalPositions) }}</div>
                </div>
                <a href="{{ route('hr.positions.index') }}" class="erp-stat-link" style="color: #fbbf24;">
                    จัดการตำแหน่ง <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="row g-3">
        {{-- Recent Employees --}}
        <div class="col-lg-5">
            <div class="erp-card h-100">
                <div class="erp-card-header d-flex justify-content-between align-items-center">
                    <span class="erp-card-title">
                        <i class="fas fa-user-plus me-2" style="color: #818cf8;"></i>พนักงานใหม่ล่าสุด
                    </span>
                    <a href="{{ route('hr.employees.create') }}" class="erp-btn-secondary" style="font-size: 11px; padding: 4px 12px;">
                        <i class="fas fa-plus me-1"></i>เพิ่ม
                    </a>
                </div>
                <div class="erp-card-body p-0">
                    <div class="erp-table-wrap">
                        <table class="erp-table">
                            <thead>
                                <tr>
                                    <th class="text-start">รหัส</th>
                                    <th class="text-start">ชื่อ-นามสกุล</th>
                                    <th>แผนก</th>
                                    <th>สถานะ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentEmployees as $emp)
                                <tr>
                                    <td class="text-start">
                                        <a href="{{ route('hr.employees.show', $emp->id) }}" class="text-decoration-none fw-semibold" style="color: #818cf8;">
                                            {{ $emp->employee_code }}
                                        </a>
                                    </td>
                                    <td class="text-start">
                                        <div class="d-flex align-items-center">
                                            @if($emp->profile_image)
                                                <img src="{{ asset('storage/' . $emp->profile_image) }}"
                                                     class="rounded-circle me-2" width="32" height="32" alt="">
                                            @else
                                                <div class="rounded-circle me-2 d-flex align-items-center justify-content-center"
                                                     style="width: 32px; height: 32px; font-size: 0.75rem; background: var(--text-muted); color: var(--bg-surface);">
                                                    {{ mb_substr($emp->firstname, 0, 1, 'UTF-8') }}
                                                </div>
                                            @endif
                                            <div>
                                                <div style="color: var(--text-primary);">{{ $emp->firstname }} {{ $emp->lastname }}</div>
                                                <small style="color: var(--text-muted);">{{ $emp->position->name ?? '-' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <small style="color: var(--text-secondary);">{{ $emp->department->name ?? '-' }}</small>
                                    </td>
                                    <td>
                                        @if($emp->status === 'active')
                                            <span class="erp-badge" style="background: rgba(52,211,153,0.12); color: #34d399;">ทำงาน</span>
                                        @elseif($emp->status === 'inactive')
                                            <span class="erp-badge" style="background: rgba(255,255,255,0.05); color: var(--text-muted);">พักงาน</span>
                                        @else
                                            <span class="erp-badge" style="background: rgba(239,68,68,0.12); color: #f87171;">ออกแล้ว</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">
                                        <div class="erp-empty">
                                            <i class="fas fa-inbox"></i>
                                            <div>ยังไม่มีข้อมูลพนักงาน</div>
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

        {{-- Weekly Attendance Chart --}}
        <div class="col-lg-4">
            <div class="erp-card h-100">
                <div class="erp-card-header">
                    <span class="erp-card-title">
                        <i class="fas fa-chart-bar me-2" style="color: #818cf8;"></i>สถิติเข้างานรายสัปดาห์
                    </span>
                </div>
                <div class="erp-card-body">
                    <div class="d-flex flex-column gap-3">
                        @foreach($weeklyAttendance as $day)
                        <div class="d-flex align-items-center">
                            <div class="me-3" style="width: 80px;">
                                <span class="small {{ $day['is_today'] ? 'fw-bold' : '' }}" style="color: {{ $day['is_today'] ? '#818cf8' : 'var(--text-muted)' }};">
                                    {{ $day['day'] }}
                                    @if($day['is_today'])
                                        <span class="erp-badge" style="background: rgba(99,102,241,0.12); color: #818cf8; font-size: 9px;">วันนี้</span>
                                    @endif
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <div class="progress" style="height: 20px; background: var(--input-bg);">
                                    @php
                                        $percentage = $activeEmployees > 0 ? min(100, ($day['count'] / $activeEmployees) * 100) : 0;
                                    @endphp
                                    <div class="progress-bar"
                                         role="progressbar"
                                         style="width: {{ $percentage }}%; background: {{ $day['is_today'] ? '#6366f1' : '#38bdf8' }};"
                                         aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                                        @if($percentage > 15)
                                            <span class="small" style="color: #fff;">{{ $day['count'] }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="ms-2" style="width: 30px; text-align: right;">
                                <span class="small fw-semibold" style="color: {{ $day['count'] > 0 ? 'var(--text-primary)' : 'var(--text-muted)' }};">
                                    {{ $day['count'] }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @if($activeEmployees > 0)
                    <hr style="border-color: var(--border);">
                    <div class="d-flex justify-content-between small" style="color: var(--text-muted);">
                        <span>อัตราเข้างาน: {{ $activeEmployees > 0 ? number_format(($todayAttendance / $activeEmployees) * 100, 1) : 0 }}%</span>
                        <span>พนักงาน: {{ $activeEmployees }} คน</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Departments Overview & Gender Stats --}}
        <div class="col-lg-3">
            {{-- Gender Distribution --}}
            <div class="erp-card mb-3">
                <div class="erp-card-header">
                    <span class="erp-card-title">
                        <i class="fas fa-venus-mars me-2" style="color: #818cf8;"></i>สัดส่วนเพศ
                    </span>
                </div>
                <div class="erp-card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="small" style="color: #818cf8;"><i class="fas fa-mars me-1"></i>ชาย</span>
                            <span class="small fw-bold" style="color: var(--text-primary);">{{ number_format($maleCount) }}</span>
                        </div>
                        @php
                            $total = $maleCount + $femaleCount;
                            $malePercent = $total > 0 ? ($maleCount / $total) * 100 : 0;
                        @endphp
                        <div class="progress" style="height: 8px; background: var(--input-bg);">
                            <div class="progress-bar" style="width: {{ $malePercent }}%; background: #6366f1;"></div>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="small" style="color: #f87171;"><i class="fas fa-venus me-1"></i>หญิง</span>
                            <span class="small fw-bold" style="color: var(--text-primary);">{{ number_format($femaleCount) }}</span>
                        </div>
                        @php
                            $femalePercent = $total > 0 ? ($femaleCount / $total) * 100 : 0;
                        @endphp
                        <div class="progress" style="height: 8px; background: var(--input-bg);">
                            <div class="progress-bar" style="width: {{ $femalePercent }}%; background: #f87171;"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Departments with Employee Counts --}}
            <div class="erp-card">
                <div class="erp-card-header">
                    <span class="erp-card-title">
                        <i class="fas fa-building me-2" style="color: #818cf8;"></i>แผนก
                    </span>
                </div>
                <div class="erp-card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($departments as $dept)
                        <div class="list-group-item border-0 px-3 py-2 d-flex justify-content-between align-items-center" style="background: transparent;">
                            <span class="small" style="color: var(--text-secondary);">{{ $dept->name }}</span>
                            <span class="erp-badge" style="background: rgba(255,255,255,0.05); color: var(--text-secondary);">{{ $dept->employees_count }}</span>
                        </div>
                        @empty
                        <div class="text-center py-3" style="color: var(--text-muted);">
                            <i class="fas fa-inbox mb-2 d-block"></i>ยังไม่มีข้อมูลแผนก
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
