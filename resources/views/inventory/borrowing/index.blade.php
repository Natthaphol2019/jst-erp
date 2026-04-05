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
    <h2>ระบบยืม-คืนอุปกรณ์</h2>
    <p>พิมพ์เมื่อ {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
</div>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h2 class="no-print">
                <i class="bi bi-basket me-2"></i>ระบบยืม-คืนอุปกรณ์
            </h2>
            <h2 class="d-print-block" style="display:none;">ระบบยืม-คืนอุปกรณ์</h2>
        </div>
        <div class="col text-end no-print">
            <button onclick="window.print()" class="btn btn-outline-dark me-2">
                <i class="bi bi-printer me-1"></i>พิมพ์
            </button>
            <a href="{{ route('exports.borrowings') }}" class="btn btn-success me-2">
                <i class="bi bi-file-earmark-excel"></i> Export Excel
            </a>
            <a href="{{ route('inventory.borrowing.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i>สร้างใบยืมใหม่
            </a>
        </div>
    </div>

    {{-- Filter Form --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('inventory.borrowing.index') }}" class="row g-3">
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
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>กำลังยืม</option>
                        <option value="returned_all" {{ request('status') == 'returned_all' ? 'selected' : '' }}>คืนครบแล้ว</option>
                        <option value="returned_partial" {{ request('status') == 'returned_partial' ? 'selected' : '' }}>คืนบางส่วน</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-search me-1"></i>ค้นหา
                    </button>
                    <a href="{{ route('inventory.borrowing.index') }}" class="btn btn-secondary">
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

    {{-- Borrowing Table --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="80">เลขที่</th>
                            <th width="120">วันที่ยืม</th>
                            <th width="120">กำหนดคืน</th>
                            <th>ผู้ยืม</th>
                            <th width="100">จำนวนรายการ</th>
                            <th width="120">สถานะ</th>
                            <th width="150">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($borrowings as $borrowing)
                            @php
                                $isOverdue = in_array($borrowing->status, ['approved', 'returned_partial']) && now()->gt(\Carbon\Carbon::parse($borrowing->due_date));
                                $statusBadge = match($borrowing->status) {
                                    'approved' => $isOverdue ? 'bg-danger' : 'bg-warning text-dark',
                                    'returned_all' => 'bg-success',
                                    'returned_partial' => 'bg-info',
                                    default => 'bg-secondary'
                                };
                                $statusText = match($borrowing->status) {
                                    'approved' => $isOverdue ? 'เกินกำหนด' : 'กำลังยืม',
                                    'returned_all' => 'คืนครบแล้ว',
                                    'returned_partial' => 'คืนบางส่วน',
                                    default => $borrowing->status
                                };
                            @endphp
                            <tr>
                                <td><strong>#{{ str_pad($borrowing->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                                <td>{{ \Carbon\Carbon::parse($borrowing->req_date)->format('d/m/Y') }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($borrowing->due_date)->format('d/m/Y') }}
                                    @if($isOverdue)
                                        <br><small class="text-danger">
                                            (เกิน {{ now()->diffInDays(\Carbon\Carbon::parse($borrowing->due_date)) }} วัน)
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    <div>{{ $borrowing->employee->firstname }} {{ $borrowing->employee->lastname }}</div>
                                    <small class="text-muted">{{ $borrowing->employee->employee_code }}</small>
                                </td>
                                <td class="text-center">{{ $borrowing->items->count() }} รายการ</td>
                                <td>
                                    <span class="badge {{ $statusBadge }}">
                                        {{ $statusText }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('inventory.borrowing.show', $borrowing->id) }}" 
                                           class="btn btn-outline-primary" title="ดูรายละเอียด">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if(!in_array($borrowing->status, ['returned_all', 'rejected']))
                                            <a href="{{ route('inventory.borrowing.edit', $borrowing->id) }}" 
                                               class="btn btn-outline-warning" title="แก้ไข">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        @endif
                                        @if(!in_array($borrowing->status, ['returned_all', 'rejected']))
                                            <a href="{{ route('inventory.borrowing.return', $borrowing->id) }}" 
                                               class="btn btn-outline-success" title="คืนสินค้า">
                                                <i class="bi bi-box-arrow-in-left"></i> คืน
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                    <p class="mt-2">ไม่พบข้อมูลใบยืม</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $borrowings->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
