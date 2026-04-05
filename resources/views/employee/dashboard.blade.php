@extends('layouts.app')

@section('title', 'Employee Dashboard - JST ERP')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h4 mb-1 text-dark">
                        <i class="bi bi-person-workspace me-2"></i>แดชบอร์ดพนักงาน
                    </h2>
                    <p class="text-muted mb-0">สวัสดี, <strong>{{ auth()->user()->name }}</strong></p>
                </div>
                <div class="d-none d-md-block">
                    <span class="badge bg-secondary fs-6 px-3 py-2">
                        <i class="bi bi-person-fill me-1"></i> Employee
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <!-- Active Borrowings -->
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-opacity-10 rounded-3 p-3">
                                <i class="bi bi-box-arrow-right text-info fs-3"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1" style="font-size: 0.85rem;">กำลังยืม</h6>
                            <h3 class="mb-0 fw-bold">{{ number_format($activeBorrowingsCount) }}</h3>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="#my-borrowings" class="text-info text-decoration-none small fw-semibold">
                        ดูรายละเอียด <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Pending Requests -->
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 rounded-3 p-3">
                                <i class="bi bi-clock-history text-warning fs-3"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1" style="font-size: 0.85rem;">รออนุมัติ</h6>
                            <h3 class="mb-0 fw-bold">{{ number_format($pendingRequestsCount) }}</h3>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="#my-requisitions" class="text-warning text-decoration-none small fw-semibold">
                        ตรวจสอบสถานะ <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Attendance This Month -->
        <div class="col-xl-4 col-md-12">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 rounded-3 p-3">
                                <i class="bi bi-calendar-check-fill text-success fs-3"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1" style="font-size: 0.85rem;">เข้างานเดือนนี้</h6>
                            <h3 class="mb-0 fw-bold">{{ number_format($attendanceThisMonth) }} <span class="fs-6 fw-normal text-muted">วัน</span></h3>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <span class="text-success text-decoration-none small fw-semibold">
                        {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-dark"><i class="bi bi-lightning-fill me-2"></i>เมนูด่วน</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <a href="{{ route('inventory.borrowing.create') }}" class="btn btn-outline-info w-100 py-3">
                                <i class="bi bi-plus-circle d-block mb-2 fs-3"></i>
                                <span class="fw-semibold">ยืมอุปกรณ์</span>
                                <br>
                                <small class="text-muted">ยื่นคำขอยืมอุปกรณ์</small>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('inventory.requisition.create') }}" class="btn btn-outline-primary w-100 py-3">
                                <i class="bi bi-clipboard-plus d-block mb-2 fs-3"></i>
                                <span class="fw-semibold">เบิกอุปทาน</span>
                                <br>
                                <small class="text-muted">ยื่นคำขอเบิกสินค้า</small>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('inventory.borrowing.index') }}" class="btn btn-outline-secondary w-100 py-3">
                                <i class="bi bi-list-check d-block mb-2 fs-3"></i>
                                <span class="fw-semibold">ดูรายการทั้งหมด</span>
                                <br>
                                <small class="text-muted">ตรวจสอบสถานะคำขอ</small>
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
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold text-dark">
                        <i class="bi bi-box-arrow-right me-2"></i>อุปกรณ์ที่ยืมอยู่
                    </h6>
                    <span class="badge bg-info">{{ $myBorrowings->count() }} รายการ</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
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
                                        <a href="{{ route('inventory.borrowing.show', $borrowing->id) }}" class="text-decoration-none fw-semibold">
                                            #{{ $borrowing->id }}
                                        </a>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($borrowing->req_date)->format('d/m/Y') }}</td>
                                    <td>
                                        @php
                                            $dueDate = \Carbon\Carbon::parse($borrowing->due_date);
                                            $isOverdue = $dueDate->isPast();
                                        @endphp
                                        <span class="{{ $isOverdue ? 'text-danger fw-bold' : '' }}">
                                            {{ $dueDate->format('d/m/Y') }}
                                            @if($isOverdue)
                                                <i class="bi bi-exclamation-circle" title="เกินกำหนด"></i>
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        @if($borrowing->status === 'approved')
                                            <span class="badge bg-success">กำลังยืม</span>
                                        @elseif($borrowing->status === 'returned_partial')
                                            <span class="badge bg-warning text-dark">คืนบางส่วน</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $borrowing->status }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox fs-4 d-block mb-2"></i>
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
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold text-dark">
                        <i class="bi bi-list-ul me-2"></i>คำขอของฉัน
                    </h6>
                    <span class="badge bg-secondary">{{ $myRequisitions->count() }} รายการ</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
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
                                            <a href="{{ route('inventory.borrowing.show', $req->id) }}" class="text-decoration-none fw-semibold">
                                                #{{ $req->id }}
                                            </a>
                                        @else
                                            <a href="{{ route('inventory.requisition.show', $req->id) }}" class="text-decoration-none fw-semibold">
                                                #{{ $req->id }}
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        @if($req->req_type === 'borrow')
                                            <span class="badge bg-info">ยืม</span>
                                        @else
                                            <span class="badge bg-primary">เบิก</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($req->req_date)->format('d/m/Y') }}</td>
                                    <td>
                                        @if($req->status === 'pending')
                                            <span class="badge bg-warning text-dark">รออนุมัติ</span>
                                        @elseif($req->status === 'approved')
                                            <span class="badge bg-success">อนุมัติ</span>
                                        @elseif($req->status === 'returned_all')
                                            <span class="badge bg-secondary">คืนครบ</span>
                                        @elseif($req->status === 'returned_partial')
                                            <span class="badge bg-info">คืนบางส่วน</span>
                                        @elseif($req->status === 'rejected')
                                            <span class="badge bg-danger">ปฏิเสธ</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $req->status }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox fs-4 d-block mb-2"></i>
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
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-dark"><i class="bi bi-clock-history me-2"></i>ประวัติการเข้างานล่าสุด</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
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
                                        <strong>{{ \Carbon\Carbon::parse($attendance->work_date)->format('d/m/Y') }}</strong>
                                        <br>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($attendance->work_date)->translatedFormat('l') }}</small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success">{{ $attendance->check_in_time ?? '-' }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if($attendance->check_out_time)
                                            <span class="badge bg-secondary">{{ $attendance->check_out_time }}</span>
                                        @else
                                            <span class="badge bg-light text-muted">ยังไม่ออก</span>
                                        @endif
                                    </td>
                                    <td><small class="text-muted">{{ $attendance->remark ?? '-' }}</small></td>
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
@endsection
