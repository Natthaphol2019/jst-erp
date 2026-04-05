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
    <h2>ใบเบิกอุปทาน</h2>
    <p>เลขที่ #{{ str_pad($requisition->id, 4, '0', STR_PAD_LEFT) }} | พิมพ์เมื่อ {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
</div>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h2 class="no-print">
                <i class="bi bi-eye me-2"></i>รายละเอียดใบเบิก
            </h2>
        </div>
        <div class="col text-end no-print">
            <button onclick="window.print()" class="btn btn-outline-dark me-2">
                <i class="bi bi-printer me-1"></i>พิมพ์
            </button>
            <a href="{{ route('inventory.requisition.index') }}" class="btn btn-secondary">
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
        {{-- Left Column - Requisition Info --}}
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-info-circle me-1"></i>ข้อมูลใบเบิก
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="150">เลขที่ใบเบิก</th>
                            <td><strong>#{{ str_pad($requisition->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                        </tr>
                        <tr>
                            <th>วันที่เบิก</th>
                            <td>{{ \Carbon\Carbon::parse($requisition->req_date)->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <th>สถานะ</th>
                            <td>
                                @php
                                    $statusBadge = match($requisition->status) {
                                        'pending' => 'bg-warning text-dark',
                                        'approved' => 'bg-success',
                                        'rejected' => 'bg-danger',
                                        default => 'bg-secondary'
                                    };
                                    $statusText = match($requisition->status) {
                                        'pending' => 'รออนุมัติ',
                                        'approved' => 'อนุมัติแล้ว',
                                        'rejected' => 'ปฏิเสธ',
                                        default => $requisition->status
                                    };
                                @endphp
                                <span class="badge {{ $statusBadge }}">{{ $statusText }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th>ผู้อนุมัติ</th>
                            <td>{{ $requisition->approver->name ?? '-' }}</td>
                        </tr>
                        @if($requisition->note)
                        <tr>
                            <th>หมายเหตุ</th>
                            <td>{{ $requisition->note }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>

            {{-- Employee Info --}}
            <div class="card">
                <div class="card-header bg-info text-white">
                    <i class="bi bi-person me-1"></i>ข้อมูลผู้เบิก
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="150">รหัสพนักงาน</th>
                            <td>{{ $requisition->employee->employee_code }}</td>
                        </tr>
                        <tr>
                            <th>ชื่อ-นามสกุล</th>
                            <td>{{ $requisition->employee->firstname }} {{ $requisition->employee->lastname }}</td>
                        </tr>
                        @if($requisition->employee->department)
                        <tr>
                            <th>แผนก</th>
                            <td>{{ $requisition->employee->department->name }}</td>
                        </tr>
                        @endif
                        @if($requisition->employee->position)
                        <tr>
                            <th>ตำแหน่ง</th>
                            <td>{{ $requisition->employee->position->name }}</td>
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
                    <i class="bi bi-box me-1"></i>รายการสินค้าเบิก
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>สินค้า</th>
                                    <th width="100" class="text-center">จำนวนเบิก</th>
                                    @if($requisition->status === 'approved')
                                    <th width="100" class="text-center">สถานะ</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($requisition->items as $item)
                                    <tr>
                                        <td>{{ $item->item->name }}</td>
                                        <td class="text-center"><strong>{{ $item->quantity_requested }}</strong></td>
                                        @if($requisition->status === 'approved')
                                        <td class="text-center">
                                            <span class="badge bg-success">เบิกสำเร็จ</span>
                                        </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th>รวม</th>
                                    <th class="text-center">{{ $requisition->items->sum('quantity_requested') }}</th>
                                    @if($requisition->status === 'approved')
                                    <th></th>
                                    @endif
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
                        @if($requisition->status === 'pending')
                            <a href="{{ route('inventory.requisition.edit', $requisition->id) }}" class="btn btn-warning">
                                <i class="bi bi-pencil me-1"></i>แก้ไข
                            </a>
                            <a href="{{ route('inventory.requisition.approve', $requisition->id) }}" class="btn btn-success">
                                <i class="bi bi-check-circle me-1"></i>อนุมัติ/ปฏิเสธ
                            </a>
                        @endif
                        <a href="{{ route('inventory.requisition.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i>กลับ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
