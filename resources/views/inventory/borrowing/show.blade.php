@extends('layouts.app')

@section('content')
<style>
@media print {
    .no-print, .no-print * { display: none !important; }
    .sidebar, .navbar, .btn, .alert, .card-body .d-flex { display: none !important; }
    .content { padding: 0 !important; margin: 0 !important; }
    .card { border: 1px solid #dee2e6 !important; box-shadow: none !important; margin-bottom: 1rem !important; }
    .card-header { background-color: #f8f9fa !important; color: #000 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    table { font-size: 10pt !important; }
    th, td { border: 1px solid #dee2e6 !important; }
    .badge { border: 1px solid #6c757d !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    .bg-primary { background-color: #0d6efd !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    .bg-success { background-color: #198754 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    .bg-info { background-color: #0dcaf0 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    .bg-warning { background-color: #ffc107 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    .bg-danger { background-color: #dc3545 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    body { background-color: #fff !important; }
    .container-fluid { width: 100% !important; max-width: 100% !important; }
    .row { page-break-inside: avoid; }
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
    <h2>ใบยืม-คืนอุปกรณ์</h2>
    <p>เลขที่ #{{ str_pad($borrowing->id, 4, '0', STR_PAD_LEFT) }} | พิมพ์เมื่อ {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
</div>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h2 class="no-print">
                <i class="bi bi-eye me-2"></i>รายละเอียดใบยืม
            </h2>
        </div>
        <div class="col text-end no-print">
            <button onclick="window.print()" class="btn btn-outline-dark me-2">
                <i class="bi bi-printer me-1"></i>พิมพ์
            </button>
            <a href="{{ route('inventory.borrowing.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i>กลับ
            </a>
        </div>
    </div>

    {{-- Success/Error Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show no-print" role="alert">
            <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show no-print" role="alert">
            <i class="bi bi-exclamation-triangle me-1"></i>{{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        {{-- Left Column - Borrowing Info --}}
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-info-circle me-1"></i>ข้อมูลใบยืม
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="150">เลขที่ใบยืม</th>
                            <td><strong>#{{ str_pad($borrowing->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                        </tr>
                        <tr>
                            <th>วันที่ยืม</th>
                            <td>{{ \Carbon\Carbon::parse($borrowing->req_date)->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <th>กำหนดคืน</th>
                            <td>
                                {{ \Carbon\Carbon::parse($borrowing->due_date)->format('d/m/Y') }}
                                @php
                                    $isOverdue = in_array($borrowing->status, ['approved', 'returned_partial']) && now()->gt(\Carbon\Carbon::parse($borrowing->due_date));
                                @endphp
                                @if($isOverdue)
                                    <span class="badge bg-danger ms-2">เกินกำหนด</span>
                                    <br><small class="text-danger">
                                        เกิน {{ now()->diffInDays(\Carbon\Carbon::parse($borrowing->due_date)) }} วัน
                                    </small>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>สถานะ</th>
                            <td>
                                @php
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
                                <span class="badge {{ $statusBadge }}">{{ $statusText }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th>ผู้อนุมัติ</th>
                            <td>{{ $borrowing->approver->name ?? '-' }}</td>
                        </tr>
                        @if($borrowing->note)
                        <tr>
                            <th>หมายเหตุ</th>
                            <td>{{ $borrowing->note }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>

            {{-- Employee Info --}}
            <div class="card">
                <div class="card-header bg-info text-white">
                    <i class="bi bi-person me-1"></i>ข้อมูลผู้ยืม
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="150">รหัสพนักงาน</th>
                            <td>{{ $borrowing->employee->employee_code }}</td>
                        </tr>
                        <tr>
                            <th>ชื่อ-นามสกุล</th>
                            <td>{{ $borrowing->employee->firstname }} {{ $borrowing->employee->lastname }}</td>
                        </tr>
                        @if($borrowing->employee->department)
                        <tr>
                            <th>แผนก</th>
                            <td>{{ $borrowing->employee->department->name }}</td>
                        </tr>
                        @endif
                        @if($borrowing->employee->position)
                        <tr>
                            <th>ตำแหน่ง</th>
                            <td>{{ $borrowing->employee->position->name }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>

        {{-- Right Column - Items --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-box me-1"></i>รายการสินค้ายืม
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>สินค้า</th>
                                    <th width="80" class="text-center">ยืม</th>
                                    <th width="80" class="text-center">คืนแล้ว</th>
                                    <th width="80" class="text-center">คงเหลือยืม</th>
                                    <th width="80" class="text-center">สถานะ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($borrowing->items as $item)
                                    <tr>
                                        <td>{{ $item->item->name }}</td>
                                        <td class="text-center">{{ $item->quantity_requested }}</td>
                                        <td class="text-center">{{ $item->quantity_returned }}</td>
                                        <td class="text-center"><strong>{{ $item->quantity_requested - $item->quantity_returned }}</strong></td>
                                        <td class="text-center">
                                            @if($item->quantity_returned >= $item->quantity_requested)
                                                <span class="badge bg-success">คืนแล้ว</span>
                                            @else
                                                <span class="badge bg-warning text-dark">กำลังยืม</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th>รวม</th>
                                    <th class="text-center">{{ $borrowing->items->sum('quantity_requested') }}</th>
                                    <th class="text-center">{{ $borrowing->items->sum('quantity_returned') }}</th>
                                    <th class="text-center">{{ $borrowing->items->sum(fn($i) => $i->quantity_requested - $i->quantity_returned) }}</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="row mt-3">
        <div class="col-12">
            <div class="card no-print">
                <div class="card-body">
                    <div class="d-flex justify-content-end gap-2">
                        @if(!in_array($borrowing->status, ['returned_all', 'returned_partial', 'rejected']))
                            <a href="{{ route('inventory.borrowing.edit', $borrowing->id) }}" class="btn btn-warning">
                                <i class="bi bi-pencil me-1"></i>แก้ไข
                            </a>
                            <a href="{{ route('inventory.borrowing.return', $borrowing->id) }}" class="btn btn-success">
                                <i class="bi bi-box-arrow-in-left me-1"></i>คืนสินค้า
                            </a>
                        @endif
                        <a href="{{ route('inventory.borrowing.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i>กลับ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
