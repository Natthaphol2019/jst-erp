@extends('layouts.app')

@section('title', 'Manager Dashboard - JST ERP')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h4 mb-1 text-dark">
                        <i class="bi bi-briefcase me-2"></i>แดชบอร์ดผู้จัดการ
                    </h2>
                    <p class="text-muted mb-0">ยินดีต้อนรับ, <strong>{{ auth()->user()->name }}</strong></p>
                </div>
                <div class="d-none d-md-block">
                    <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                        <i class="bi bi-shield-fill-check me-1"></i> Manager
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Employees -->
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
                            <h6 class="text-muted mb-1" style="font-size: 0.85rem;">พนักงานทั้งหมด</h6>
                            <h3 class="mb-0 fw-bold">{{ number_format($totalEmployees) }}</h3>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <span class="text-primary text-decoration-none small fw-semibold">
                        พนักงาน aktif
                    </span>
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
                    <span class="text-info text-decoration-none small fw-semibold">
                        หน่วยงานทั้งหมด
                    </span>
                </div>
            </div>
        </div>

        <!-- Pending Approvals -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 rounded-3 p-3">
                                <i class="bi bi-hourglass-split text-warning fs-3"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1" style="font-size: 0.85rem;">รออนุมัติ</h6>
                            <h3 class="mb-0 fw-bold">{{ number_format($pendingApprovals) }}</h3>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('inventory.requisition.index') }}?status=pending" class="text-warning text-decoration-none small fw-semibold">
                        ตรวจสอบรายการ <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Today Attendance -->
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
                    <span class="text-success text-decoration-none small fw-semibold">
                        {{ \Carbon\Carbon::now()->translatedFormat('l ที่ d F Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Requisition Status Summary -->
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-dark"><i class="bi bi-bar-chart-line-fill me-2"></i>สรุปสถานะคำขอ</h6>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center p-3 bg-warning bg-opacity-10 rounded-3">
                                <div class="flex-shrink-0">
                                    <div class="bg-warning rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                        <i class="bi bi-clock text-white fs-5"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3 text-center">
                                    <h4 class="mb-0 fw-bold text-warning">{{ number_format($pendingCount) }}</h4>
                                    <small class="text-muted">รออนุมัติ</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center p-3 bg-success bg-opacity-10 rounded-3">
                                <div class="flex-shrink-0">
                                    <div class="bg-success rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                        <i class="bi bi-check-lg text-white fs-5"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3 text-center">
                                    <h4 class="mb-0 fw-bold text-success">{{ number_format($approvedCount) }}</h4>
                                    <small class="text-muted">อนุมัติ/กำลังยืม</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center p-3 bg-secondary bg-opacity-10 rounded-3">
                                <div class="flex-shrink-0">
                                    <div class="bg-secondary rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                        <i class="bi bi-check2-all text-white fs-5"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3 text-center">
                                    <h4 class="mb-0 fw-bold text-secondary">{{ number_format($completedCount) }}</h4>
                                    <small class="text-muted">คืนครบแล้ว</small>
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
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-dark"><i class="bi bi-building me-2"></i>สถิติแผนก</h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($departments as $dept)
                        <div class="list-group-item border-0 px-3 py-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <span class="fw-semibold">{{ $dept->name }}</span>
                                    @if($dept->description)
                                        <br>
                                        <small class="text-muted">{{ Str::limit($dept->description, 40) }}</small>
                                    @endif
                                </div>
                                <span class="badge bg-primary">{{ $dept->employees_count }} คน</span>
                            </div>
                            @php
                                $percentage = $totalEmployees > 0 ? ($dept->employees_count / $totalEmployees) * 100 : 0;
                            @endphp
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $percentage }}%;"></div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                            ยังไม่มีข้อมูลแผนก
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold text-dark">
                        <i class="bi bi-activity me-2"></i>กิจกรรมล่าสุด
                    </h6>
                    <a href="{{ route('inventory.requisition.index') }}" class="btn btn-sm btn-outline-secondary">
                        ดูทั้งหมด <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
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
                                        <a href="{{ route('inventory.requisition.show', $activity->id) }}" class="text-decoration-none fw-semibold">
                                            #{{ $activity->id }}
                                        </a>
                                    </td>
                                    <td>
                                        @if($activity->employee)
                                            {{ $activity->employee->firstname }} {{ $activity->employee->lastname }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($activity->req_type === 'borrow')
                                            <span class="badge bg-info">ยืม</span>
                                        @else
                                            <span class="badge bg-primary">เบิก</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($activity->req_date)->format('d/m/Y') }}</td>
                                    <td>
                                        @if($activity->status === 'pending')
                                            <span class="badge bg-warning text-dark">รออนุมัติ</span>
                                        @elseif($activity->status === 'approved')
                                            <span class="badge bg-success">อนุมัติ</span>
                                        @elseif($activity->status === 'returned_all')
                                            <span class="badge bg-secondary">คืนครบ</span>
                                        @elseif($activity->status === 'returned_partial')
                                            <span class="badge bg-info">คืนบางส่วน</span>
                                        @elseif($activity->status === 'rejected')
                                            <span class="badge bg-danger">ปฏิเสธ</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $activity->status }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox fs-4 d-block mb-2"></i>
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
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold text-dark">
                        <i class="bi bi-box-arrow-right me-2"></i>อุปกรณ์ที่กำลังยืม
                    </h6>
                    <span class="badge bg-info">{{ number_format($activeBorrowings) }} รายการ</span>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card border bg-light rounded-3">
                                <div class="card-body text-center">
                                    <i class="bi bi-box-seam display-4 text-primary mb-3"></i>
                                    <h5 class="fw-bold text-primary">{{ number_format($activeBorrowings) }}</h5>
                                    <p class="text-muted mb-0">รายการที่กำลังยืม</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border bg-light rounded-3">
                                <div class="card-body text-center">
                                    <i class="bi bi-people display-4 text-success mb-3"></i>
                                    <h5 class="fw-bold text-success">{{ number_format($totalEmployees) }}</h5>
                                    <p class="text-muted mb-0">พนักงาน aktif</p>
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
