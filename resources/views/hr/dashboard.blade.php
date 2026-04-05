@extends('layouts.app')

@section('title', 'HR Dashboard - JST ERP')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h4 mb-1 text-dark">
                        <i class="bi bi-person-badge me-2"></i>แดชบอร์ดฝ่ายบุคคล
                    </h2>
                    <p class="text-muted mb-0">ยินดีต้อนรับ, <strong>{{ auth()->user()->name }}</strong></p>
                </div>
                <div class="d-none d-md-block">
                    <span class="badge bg-success fs-6 px-3 py-2">
                        <i class="bi bi-shield-fill-check me-1"></i> HR
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <!-- Active Employees -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                                <i class="bi bi-people-fill text-primary fs-3"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1" style="font-size: 0.85rem;">พนักงาน aktif</h6>
                            <h3 class="mb-0 fw-bold">{{ number_format($activeEmployees) }}</h3>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('hr.employees.index') }}" class="text-primary text-decoration-none small fw-semibold">
                        จัดการพนักงาน <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Today's Attendance -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 rounded-3 p-3">
                                <i class="bi bi-calendar-check-fill text-success fs-3"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1" style="font-size: 0.85rem;">เข้างานวันนี้</h6>
                            <h3 class="mb-0 fw-bold">{{ number_format($todayAttendance) }}</h3>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('hr.time-records.summary') }}" class="text-success text-decoration-none small fw-semibold">
                        ดูรายงาน <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Departments -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-opacity-10 rounded-3 p-3">
                                <i class="bi bi-diagram-3-fill text-info fs-3"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1" style="font-size: 0.85rem;">แผนก</h6>
                            <h3 class="mb-0 fw-bold">{{ number_format($totalDepartments) }}</h3>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('hr.departments.index') }}" class="text-info text-decoration-none small fw-semibold">
                        จัดการแผนก <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Positions -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 rounded-3 p-3">
                                <i class="bi bi-briefcase-fill text-warning fs-3"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1" style="font-size: 0.85rem;">ตำแหน่งงาน</h6>
                            <h3 class="mb-0 fw-bold">{{ number_format($totalPositions) }}</h3>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('hr.positions.index') }}" class="text-warning text-decoration-none small fw-semibold">
                        จัดการตำแหน่ง <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Employees -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold text-dark">
                        <i class="bi bi-person-plus-fill me-2"></i>พนักงานใหม่ล่าสุด
                    </h6>
                    <a href="{{ route('hr.employees.create') }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-plus-lg"></i> เพิ่ม
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">รหัส</th>
                                    <th>ชื่อ-นามสกุล</th>
                                    <th>แผนก</th>
                                    <th>สถานะ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentEmployees as $emp)
                                <tr>
                                    <td class="ps-4">
                                        <a href="{{ route('hr.employees.show', $emp->id) }}" class="text-decoration-none fw-semibold">
                                            {{ $emp->employee_code }}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($emp->profile_image)
                                                <img src="{{ asset('storage/' . $emp->profile_image) }}"
                                                     class="rounded-circle me-2" width="32" height="32" alt="">
                                            @else
                                                <div class="bg-secondary rounded-circle me-2 d-flex align-items-center justify-content-center text-white"
                                                     style="width: 32px; height: 32px; font-size: 0.75rem;">
                                                    {{ mb_substr($emp->firstname, 0, 1, 'UTF-8') }}
                                                </div>
                                            @endif
                                            <div>
                                                <div>{{ $emp->firstname }} {{ $emp->lastname }}</div>
                                                <small class="text-muted">{{ $emp->position->name ?? '-' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <small>{{ $emp->department->name ?? '-' }}</small>
                                    </td>
                                    <td>
                                        @if($emp->status === 'active')
                                            <span class="badge bg-success">ทำงาน</span>
                                        @elseif($emp->status === 'inactive')
                                            <span class="badge bg-secondary">พักงาน</span>
                                        @else
                                            <span class="badge bg-danger">ออกแล้ว</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                                        ยังไม่มีข้อมูลพนักงาน
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Weekly Attendance Chart -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-dark">
                        <i class="bi bi-bar-chart-fill me-2"></i>สถิติเข้างานรายสัปดาห์
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column gap-3">
                        @foreach($weeklyAttendance as $day)
                        <div class="d-flex align-items-center">
                            <div class="me-3" style="width: 80px;">
                                <span class="small {{ $day['is_today'] ? 'fw-bold text-primary' : 'text-muted' }}">
                                    {{ $day['day'] }}
                                    @if($day['is_today'])
                                        <span class="badge bg-primary" style="font-size: 0.6rem;">วันนี้</span>
                                    @endif
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <div class="progress" style="height: 20px;">
                                    @php
                                        $percentage = $activeEmployees > 0 ? min(100, ($day['count'] / $activeEmployees) * 100) : 0;
                                    @endphp
                                    <div class="progress-bar {{ $day['is_today'] ? 'bg-primary' : 'bg-info' }}"
                                         role="progressbar"
                                         style="width: {{ $percentage }}%;"
                                         aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                                        @if($percentage > 15)
                                            <span class="small text-white">{{ $day['count'] }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="ms-2" style="width: 30px; text-align: right;">
                                <span class="small fw-semibold {{ $day['count'] > 0 ? 'text-dark' : 'text-muted' }}">
                                    {{ $day['count'] }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @if($activeEmployees > 0)
                    <hr>
                    <div class="d-flex justify-content-between small text-muted">
                        <span>อัตราเข้างาน: {{ $activeEmployees > 0 ? number_format(($todayAttendance / $activeEmployees) * 100, 1) : 0 }}%</span>
                        <span>พนักงาน: {{ $activeEmployees }} คน</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Departments Overview & Gender Stats -->
        <div class="col-lg-3">
            <!-- Gender Distribution -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-dark">
                        <i class="bi bi-gender-ambiguous me-2"></i>สัดส่วนเพศ
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="small text-primary"><i class="bi bi-gender-male me-1"></i>ชาย</span>
                            <span class="small fw-bold">{{ number_format($maleCount) }}</span>
                        </div>
                        @php
                            $total = $maleCount + $femaleCount;
                            $malePercent = $total > 0 ? ($maleCount / $total) * 100 : 0;
                        @endphp
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-primary" style="width: {{ $malePercent }}%;"></div>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="small text-danger"><i class="bi bi-gender-female me-1"></i>หญิง</span>
                            <span class="small fw-bold">{{ number_format($femaleCount) }}</span>
                        </div>
                        @php
                            $femalePercent = $total > 0 ? ($femaleCount / $total) * 100 : 0;
                        @endphp
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-danger" style="width: {{ $femalePercent }}%;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Departments with Employee Counts -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-dark">
                        <i class="bi bi-building me-2"></i>แผนก
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($departments as $dept)
                        <div class="list-group-item border-0 px-3 py-2 d-flex justify-content-between align-items-center">
                            <span class="small">{{ $dept->name }}</span>
                            <span class="badge bg-light text-dark">{{ $dept->employees_count }}</span>
                        </div>
                        @empty
                        <div class="text-center py-3 text-muted small">
                            ยังไม่มีข้อมูลแผนก
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
