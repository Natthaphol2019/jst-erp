@extends('layouts.app')

@section('title', 'รายละเอียดใบเบิก - JST ERP')

@section('content')
<style>
/* Fix table background for dark mode */
.erp-card-body .table {
    background: transparent !important;
    color: var(--text-primary) !important;
    margin-bottom: 0;
}
.erp-card-body .table th,
.erp-card-body .table td {
    background: transparent !important;
    border-color: var(--border) !important;
    color: inherit;
}
.erp-card-body .table tbody tr:hover {
    background: rgba(99, 102, 241, 0.05) !important;
}

@media print {
    .no-print, .no-print * { display: none !important; }
    .sidebar, .navbar, .btn, .alert, .erp-card-body .d-flex { display: none !important; }
    .content { padding: 0 !important; margin: 0 !important; }
    .erp-card { border: 1px solid #dee2e6 !important; box-shadow: none !important; margin-bottom: 1rem !important; }
    .erp-card-header { background-color: #f8f9fa !important; color: #000 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    table { font-size: 10pt !important; }
    th, td { border: 1px solid #dee2e6 !important; }
    .erp-badge { border: 1px solid #6c757d !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
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

<div class="d-flex justify-content-between align-items-start mb-4 no-print">
    <div>
        <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            <i class="fas fa-eye me-2" style="color: #818cf8;"></i>รายละเอียดใบเบิก
        </h4>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">ดูข้อมูลใบเบิก</p>
    </div>
    <div class="d-flex gap-2 no-print">
        <button onclick="window.print()" class="erp-btn-secondary">
            <i class="fas fa-print me-2"></i>พิมพ์
        </button>
        @if(auth()->user()->role === 'employee')
            <a href="{{ route('employee.dashboard') }}" class="erp-btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>กลับ
            </a>
        @else
            <a href="{{ route('inventory.requisition.index') }}" class="erp-btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>กลับ
            </a>
        @endif
    </div>
</div>

@if(session('success'))
    <div class="erp-alert erp-alert-success mb-4 no-print" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="erp-alert erp-alert-danger mb-4 no-print" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>{{ $errors->first() }}
    </div>
@endif

<div class="row g-3">
    {{-- Left Column - Requisition Info --}}
    <div class="col-md-6">
        <div class="erp-card mb-3">
            <div class="erp-card-header">
                <span class="erp-card-title">
                    <i class="fas fa-info-circle me-2" style="color: #818cf8;"></i>ข้อมูลใบเบิก
                </span>
            </div>
            <div class="erp-card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="150" style="color: var(--text-muted); font-size: 12px;">เลขที่ใบเบิก</th>
                        <td><strong style="color: var(--text-primary);">#{{ str_pad($requisition->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                    </tr>
                    <tr>
                        <th style="color: var(--text-muted); font-size: 12px;">วันที่เบิก</th>
                        <td style="color: var(--text-secondary);">{{ \Carbon\Carbon::parse($requisition->req_date)->format('d/m/Y') }}</td>
                    </tr>
                    @if($requisition->period)
                    <tr>
                        <th style="color: var(--text-muted); font-size: 12px;">ช่วงเวลา</th>
                        <td>
                            @php
                                $periodLabel = match($requisition->period) {
                                    'morning' => 'เช้า (08:00-12:00)',
                                    'afternoon' => 'บ่าย (13:00-17:00)',
                                    'evening' => 'เย็น/OT (17:00-20:00)',
                                    default => $requisition->period,
                                };
                            @endphp
                            <span class="erp-badge" style="background: rgba(56,189,248,0.12); color: #38bdf8;">{{ $periodLabel }}</span>
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <th style="color: var(--text-muted); font-size: 12px;">สถานะ</th>
                        <td>
                            @php
                                $statusBadge = match($requisition->status) {
                                    'issued' => ['bg' => 'rgba(52,211,153,0.12)', 'color' => '#34d399', 'text' => 'เบิกแล้ว'],
                                    'pending' => ['bg' => 'rgba(251,191,36,0.12)', 'color' => '#fbbf24', 'text' => 'รออนุมัติ'],
                                    'approved' => ['bg' => 'rgba(52,211,153,0.12)', 'color' => '#34d399', 'text' => 'อนุมัติแล้ว'],
                                    'rejected' => ['bg' => 'rgba(239,68,68,0.12)', 'color' => '#f87171', 'text' => 'ปฏิเสธ'],
                                    default => ['bg' => 'rgba(107,114,128,0.12)', 'color' => '#9ca3af', 'text' => $requisition->status]
                                };
                            @endphp
                            <span class="erp-badge" style="background: {{ $statusBadge['bg'] }}; color: {{ $statusBadge['color'] }}">{{ $statusBadge['text'] }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th style="color: var(--text-muted); font-size: 12px;">ผู้อนุมัติ</th>
                        <td style="color: var(--text-secondary);">{{ $requisition->approver->name ?? '-' }}</td>
                    </tr>
                    @if($requisition->note)
                    <tr>
                        <th style="color: var(--text-muted); font-size: 12px;">หมายเหตุ</th>
                        <td style="color: var(--text-secondary);">{{ $requisition->note }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>

        {{-- Employee Info --}}
        <div class="erp-card">
            <div class="erp-card-header">
                <span class="erp-card-title">
                    <i class="fas fa-user me-2" style="color: #818cf8;"></i>ข้อมูลผู้เบิก
                </span>
            </div>
            <div class="erp-card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="150" style="color: var(--text-muted); font-size: 12px;">รหัสพนักงาน</th>
                        <td style="color: var(--text-secondary);">{{ $requisition->employee->employee_code }}</td>
                    </tr>
                    <tr>
                        <th style="color: var(--text-muted); font-size: 12px;">ชื่อ-นามสกุล</th>
                        <td style="color: var(--text-primary);">{{ $requisition->employee->firstname }} {{ $requisition->employee->lastname }}</td>
                    </tr>
                    @if($requisition->employee->department)
                    <tr>
                        <th style="color: var(--text-muted); font-size: 12px;">แผนก</th>
                        <td style="color: var(--text-secondary);">{{ $requisition->employee->department->name }}</td>
                    </tr>
                    @endif
                    @if($requisition->employee->position)
                    <tr>
                        <th style="color: var(--text-muted); font-size: 12px;">ตำแหน่ง</th>
                        <td style="color: var(--text-secondary);">{{ $requisition->employee->position->name }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>

    {{-- Right Column - Items --}}
    <div class="col-md-6">
        <div class="erp-card">
            <div class="erp-card-header">
                <span class="erp-card-title">
                    <i class="fas fa-box me-2" style="color: #818cf8;"></i>รายการสินค้าเบิก
                </span>
            </div>
            <div class="erp-card-body">
                <div class="erp-table-wrap">
                    <table class="erp-table">
                        <thead>
                            <tr>
                                <th>สินค้า</th>
                                <th width="100" style="text-align: center;">จำนวนเบิก</th>
                                @if($requisition->status === 'approved')
                                <th width="100" style="text-align: center;">สถานะ</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requisition->items as $item)
                                <tr>
                                    <td style="color: var(--text-secondary);">{{ $item->item->name }}</td>
                                    <td style="text-align: center; color: var(--text-primary);"><strong>{{ $item->quantity_requested }}</strong></td>
                                    @if($requisition->status === 'approved')
                                    <td style="text-align: center;">
                                        <span class="erp-badge" style="background: rgba(52,211,153,0.12); color: #34d399;">เบิกสำเร็จ</span>
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="color: var(--text-primary);">รวม</th>
                                <th style="text-align: center; color: var(--text-primary);">{{ $requisition->items->sum('quantity_requested') }}</th>
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
<div class="row mt-3 no-print">
    <div class="col-12">
        <div class="erp-card">
            <div class="erp-card-body">
                <div class="d-flex justify-content-end gap-2">
                    @if($requisition->status === 'pending')
                        <a href="{{ route('inventory.requisition.edit', $requisition->id) }}" class="erp-btn-secondary" style="border-color: #f59e0b; color: #f59e0b;">
                            <i class="fas fa-edit me-2"></i>แก้ไข
                        </a>
                        @if(in_array(auth()->user()->role, ['admin', 'inventory']))
                            <a href="{{ route('inventory.requisition.approve', $requisition->id) }}" class="erp-btn-secondary" style="border-color: #34d399; color: #34d399;">
                                <i class="fas fa-check me-2"></i>อนุมัติ/ปฏิเสธ
                            </a>
                        @endif
                    @endif
                    @if(auth()->user()->role === 'employee')
                        <a href="{{ route('employee.dashboard') }}" class="erp-btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>กลับ
                        </a>
                    @else
                        <a href="{{ route('inventory.requisition.index') }}" class="erp-btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>กลับ
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
