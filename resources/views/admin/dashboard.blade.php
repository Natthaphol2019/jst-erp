@extends('layouts.app')

@section('title', 'Admin Dashboard - JST ERP')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h4 mb-1 text-dark">
                        <i class="bi bi-speedometer2 me-2"></i>แดชบอร์ดผู้ดูแลระบบ
                    </h2>
                    <p class="text-muted mb-0">ยินดีต้อนรับ, <strong>{{ auth()->user()->name }}</strong></p>
                </div>
                <div class="d-none d-md-block">
                    <span class="badge bg-primary fs-6 px-3 py-2">
                        <i class="bi bi-shield-fill-check me-1"></i> Admin
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
                    <a href="{{ route('hr.employees.index') }}" class="text-primary text-decoration-none small fw-semibold">
                        ดูรายละเอียด <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Total Items -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 rounded-3 p-3">
                                <i class="bi bi-box-seam-fill text-success fs-3"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1" style="font-size: 0.85rem;">สินค้าในคลัง</h6>
                            <h3 class="mb-0 fw-bold">{{ number_format($totalItems) }}</h3>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('inventory.items.index') }}" class="text-success text-decoration-none small fw-semibold">
                        จัดการสินค้า <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Pending Requisitions -->
        <div class="col-xl-3 col-md-6">
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
                            <h3 class="mb-0 fw-bold">{{ number_format($pendingRequisitions) }}</h3>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('inventory.requisition.index') }}" class="text-warning text-decoration-none small fw-semibold">
                        ตรวจสอบรายการ <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Overdue Borrowings -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-danger bg-opacity-10 rounded-3 p-3">
                                <i class="bi bi-exclamation-triangle-fill text-danger fs-3"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1" style="font-size: 0.85rem;">เกินกำหนดคืน</h6>
                            <h3 class="mb-0 fw-bold text-danger">{{ number_format($overdueBorrowings) }}</h3>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('inventory.borrowing.index') }}" class="text-danger text-decoration-none small fw-semibold">
                        ดูรายการค้าง <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Stats Row -->
    <div class="row g-4 mb-4">
        <!-- Today's Attendance -->
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-opacity-10 rounded-3 p-3">
                                <i class="bi bi-calendar-check-fill text-info fs-3"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1" style="font-size: 0.85rem;">เข้างานวันนี้</h6>
                            <h3 class="mb-0 fw-bold">{{ number_format($todayAttendance) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Departments -->
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-secondary bg-opacity-10 rounded-3 p-3">
                                <i class="bi bi-diagram-3-fill text-secondary fs-3"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1" style="font-size: 0.85rem;">แผนก</h6>
                            <h3 class="mb-0 fw-bold">{{ number_format($departmentCount) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="col-xl-4 col-md-12">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-dark bg-opacity-10 rounded-3 p-3">
                                <i class="bi bi-person-badge-fill text-dark fs-3"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1" style="font-size: 0.85rem;">ผู้ใช้งานระบบ</h6>
                            <h3 class="mb-0 fw-bold">{{ number_format($totalUsers) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Requisitions -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold text-dark">
                        <i class="bi bi-list-ul me-2"></i>รายการล่าสุด
                    </h6>
                    <a href="{{ route('inventory.requisition.index') }}" class="btn btn-sm btn-outline-primary">
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
                                    <th>วันที่ขอ</th>
                                    <th>สถานะ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentRequisitions as $req)
                                <tr>
                                    <td class="ps-4">
                                        <a href="{{ route('inventory.requisition.show', $req->id) }}" class="text-decoration-none fw-semibold">
                                            #{{ $req->id }}
                                        </a>
                                    </td>
                                    <td>
                                        @if($req->employee)
                                            {{ $req->employee->firstname }} {{ $req->employee->lastname }}
                                        @else
                                            <span class="text-muted">-</span>
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
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                                        ยังไม่มีรายการ
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Low Stock Items -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold text-danger">
                        <i class="bi bi-bell-fill me-2"></i>สินค้าใกล้หมด
                    </h6>
                    <a href="{{ route('inventory.items.index') }}" class="btn btn-sm btn-outline-danger">
                        จัดการ <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">สินค้า</th>
                                    <th class="text-end pe-4">คงเหลือ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lowStockItems as $item)
                                <tr>
                                    <td class="ps-4">
                                        <div>
                                            <strong>{{ $item->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $item->item_code }}</small>
                                        </div>
                                    </td>
                                    <td class="text-end pe-4">
                                        <span class="badge {{ $item->current_stock == 0 ? 'bg-danger' : 'bg-warning text-dark' }}">
                                            {{ number_format($item->current_stock) }} {{ $item->unit }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="text-center py-4 text-success">
                                        <i class="bi bi-check-circle fs-4 d-block mb-2"></i>
                                        สินค้าทั้งหมดเพียงพอ
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
</div>
@endsection
