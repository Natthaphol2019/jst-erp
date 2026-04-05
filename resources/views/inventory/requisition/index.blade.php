@extends('layouts.app')

@section('content')
<style>
@media print {
    .no-print, .no-print * { display: none !important; }
    .sidebar, .navbar, .btn, .alert, .card-body form { display: none !important; }
    .content { padding: 0 !important; margin: 0 !important; }
    .card { border: 1px solid #dee2e6 !important; box-shadow: none !important; margin-bottom: 1rem !important; }
    table { font-size: 10pt !important; }
    th, td { border: 1px solid #dee2e6 !important; }
    .badge { border: 1px solid #6c757d !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    body { background-color: #fff !important; }
    .container-fluid { width: 100% !important; max-width: 100% !important; }
    @page { margin: 1.5cm; }
}
.print-header { display: none; }
@media print {
    .print-header { display: block !important; text-align: center; margin-bottom: 20px; }
    .print-header h2 { margin: 0; font-size: 18pt; }
    .print-header p { margin: 5px 0 0; font-size: 10pt; color: #666; }
}
</style>

<div class="print-header">
    <h2>ระบบเบิกอุปทาน</h2>
    <p>พิมพ์เมื่อ {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
</div>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h2 class="no-print">
                <i class="bi bi-clipboard-check me-2"></i>ระบบเบิกอุปทาน
            </h2>
            <h2 class="d-print-block" style="display:none;">ระบบเบิกอุปทาน</h2>
        </div>
        <div class="col text-end no-print">
            <button onclick="window.print()" class="btn btn-outline-dark me-2">
                <i class="bi bi-printer me-1"></i>พิมพ์
            </button>
            <a href="{{ route('exports.requisitions') }}" class="btn btn-success me-2">
                <i class="bi bi-file-earmark-excel"></i> Export Excel
            </a>
            <a href="{{ route('inventory.requisition.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i>สร้างใบเบิกใหม่
            </a>
        </div>
    </div>

    {{-- Filter Form --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('inventory.requisition.index') }}" class="row g-3">
                <div class="col-md-5">
                    <label class="form-label">ค้นหา</label>
                    <input type="text" name="search" class="form-control" 
                           value="{{ request('search') }}" 
                           placeholder="ชื่อพนักงาน, รหัสพนักงาน">
                </div>
                <div class="col-md-4">
                    <label class="form-label">สถานะ</label>
                    <select name="status" class="form-select">
                        <option value="">-- ทั้งหมด --</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>รออนุมัติ</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>อนุมัติแล้ว</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>ปฏิเสธ</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-search me-1"></i>ค้นหา
                    </button>
                    <a href="{{ route('inventory.requisition.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-1"></i>รีเซ็ต
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Success/Error Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-1"></i>{{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Requisition Table --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="80">เลขที่</th>
                            <th width="120">วันที่เบิก</th>
                            <th>ผู้เบิก</th>
                            <th width="100">จำนวนรายการ</th>
                            <th width="120">สถานะ</th>
                            <th width="120">ผู้อนุมัติ</th>
                            <th width="180">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requisitions as $req)
                            @php
                                $statusBadge = match($req->status) {
                                    'pending' => 'bg-warning text-dark',
                                    'approved' => 'bg-success',
                                    'rejected' => 'bg-danger',
                                    default => 'bg-secondary'
                                };
                                $statusText = match($req->status) {
                                    'pending' => 'รออนุมัติ',
                                    'approved' => 'อนุมัติแล้ว',
                                    'rejected' => 'ปฏิเสธ',
                                    default => $req->status
                                };
                            @endphp
                            <tr>
                                <td><strong>#{{ str_pad($req->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                                <td>{{ \Carbon\Carbon::parse($req->req_date)->format('d/m/Y') }}</td>
                                <td>
                                    <div>{{ $req->employee->firstname }} {{ $req->employee->lastname }}</div>
                                    <small class="text-muted">{{ $req->employee->employee_code }}</small>
                                </td>
                                <td class="text-center">{{ $req->items->count() }} รายการ</td>
                                <td>
                                    <span class="badge {{ $statusBadge }}">
                                        {{ $statusText }}
                                    </span>
                                </td>
                                <td>{{ $req->approver->name ?? '-' }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('inventory.requisition.show', $req->id) }}" 
                                           class="btn btn-outline-primary" title="ดูรายละเอียด">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if($req->status === 'pending')
                                            <a href="{{ route('inventory.requisition.edit', $req->id) }}" 
                                               class="btn btn-outline-warning" title="แก้ไข">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="{{ route('inventory.requisition.approve', $req->id) }}" 
                                               class="btn btn-outline-success" title="อนุมัติ/ปฏิเสธ">
                                                <i class="bi bi-check-circle"></i> อนุมัติ
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                    <p class="mt-2">ไม่พบข้อมูลใบเบิก</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $requisitions->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
