@extends('layouts.app')

@section('title', 'รายละเอียดใบยืม - JST ERP')

@section('content')
<style>
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
    <h2>ใบยืม-คืนอุปกรณ์</h2>
    <p>เลขที่ #{{ str_pad($borrowing->id, 4, '0', STR_PAD_LEFT) }} | พิมพ์เมื่อ {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
</div>

<div class="d-flex justify-content-between align-items-start mb-4 no-print">
    <div>
        <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            <i class="fas fa-eye me-2" style="color: #818cf8;"></i>รายละเอียดใบยืม
        </h4>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">ดูข้อมูลใบยืม</p>
    </div>
    <div class="d-flex gap-2 no-print">
        <button onclick="window.print()" class="erp-btn-secondary">
            <i class="fas fa-print me-2"></i>พิมพ์
        </button>
        <a href="{{ route('inventory.borrowing.index') }}" class="erp-btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>กลับ
        </a>
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
    {{-- Left Column - Borrowing Info --}}
    <div class="col-md-6">
        <div class="erp-card mb-3">
            <div class="erp-card-header">
                <span class="erp-card-title">
                    <i class="fas fa-info-circle me-2" style="color: #818cf8;"></i>ข้อมูลใบยืม
                </span>
            </div>
            <div class="erp-card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="150" style="color: var(--text-muted); font-size: 12px;">เลขที่ใบยืม</th>
                        <td><strong style="color: var(--text-primary);">#{{ str_pad($borrowing->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                    </tr>
                    <tr>
                        <th style="color: var(--text-muted); font-size: 12px;">วันที่ยืม</th>
                        <td style="color: var(--text-secondary);">{{ \Carbon\Carbon::parse($borrowing->req_date)->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th style="color: var(--text-muted); font-size: 12px;">กำหนดคืน</th>
                        <td>
                            <span style="color: var(--text-secondary);">{{ \Carbon\Carbon::parse($borrowing->due_date)->format('d/m/Y') }}</span>
                            @php
                                $isOverdue = in_array($borrowing->status, ['approved', 'returned_partial']) && now()->gt(\Carbon\Carbon::parse($borrowing->due_date));
                            @endphp
                            @if($isOverdue)
                                <span class="erp-badge" style="background: rgba(239,68,68,0.12); color: #f87171; margin-left: 8px;">เกินกำหนด</span>
                                <br><small style="color: #f87171;">
                                    เกิน {{ now()->diffInDays(\Carbon\Carbon::parse($borrowing->due_date)) }} วัน
                                </small>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th style="color: var(--text-muted); font-size: 12px;">สถานะ</th>
                        <td>
                            @php
                                $statusBadge = match($borrowing->status) {
                                    'approved' => $isOverdue ? ['bg' => 'rgba(239,68,68,0.12)', 'color' => '#f87171', 'text' => 'เกินกำหนด'] : ['bg' => 'rgba(251,191,36,0.12)', 'color' => '#fbbf24', 'text' => 'กำลังยืม'],
                                    'returned_all' => ['bg' => 'rgba(52,211,153,0.12)', 'color' => '#34d399', 'text' => 'คืนครบแล้ว'],
                                    'returned_partial' => ['bg' => 'rgba(56,189,248,0.12)', 'color' => '#38bdf8', 'text' => 'คืนบางส่วน'],
                                    default => ['bg' => 'rgba(107,114,128,0.12)', 'color' => '#9ca3af', 'text' => $borrowing->status]
                                };
                            @endphp
                            <span class="erp-badge" style="background: {{ $statusBadge['bg'] }}; color: {{ $statusBadge['color'] }}">{{ $statusBadge['text'] }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th style="color: var(--text-muted); font-size: 12px;">ผู้อนุมัติ</th>
                        <td style="color: var(--text-secondary);">{{ $borrowing->approver->name ?? '-' }}</td>
                    </tr>
                    @if($borrowing->note)
                    <tr>
                        <th style="color: var(--text-muted); font-size: 12px;">หมายเหตุ</th>
                        <td style="color: var(--text-secondary);">{{ $borrowing->note }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>

        {{-- Employee Info --}}
        <div class="erp-card">
            <div class="erp-card-header">
                <span class="erp-card-title">
                    <i class="fas fa-user me-2" style="color: #818cf8;"></i>ข้อมูลผู้ยืม
                </span>
            </div>
            <div class="erp-card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="150" style="color: var(--text-muted); font-size: 12px;">รหัสพนักงาน</th>
                        <td style="color: var(--text-secondary);">{{ $borrowing->employee->employee_code }}</td>
                    </tr>
                    <tr>
                        <th style="color: var(--text-muted); font-size: 12px;">ชื่อ-นามสกุล</th>
                        <td style="color: var(--text-primary);">{{ $borrowing->employee->firstname }} {{ $borrowing->employee->lastname }}</td>
                    </tr>
                    @if($borrowing->employee->department)
                    <tr>
                        <th style="color: var(--text-muted); font-size: 12px;">แผนก</th>
                        <td style="color: var(--text-secondary);">{{ $borrowing->employee->department->name }}</td>
                    </tr>
                    @endif
                    @if($borrowing->employee->position)
                    <tr>
                        <th style="color: var(--text-muted); font-size: 12px;">ตำแหน่ง</th>
                        <td style="color: var(--text-secondary);">{{ $borrowing->employee->position->name }}</td>
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
                    <i class="fas fa-box me-2" style="color: #818cf8;"></i>รายการสินค้ายืม
                </span>
            </div>
            <div class="erp-card-body">
                <div class="erp-table-wrap">
                    <table class="erp-table">
                        <thead>
                            <tr>
                                <th>สินค้า</th>
                                <th width="80" style="text-align: center;">ยืม</th>
                                <th width="80" style="text-align: center;">คืนแล้ว</th>
                                <th width="80" style="text-align: center;">คงเหลือยืม</th>
                                <th width="80" style="text-align: center;">สถานะ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($borrowing->items as $item)
                                <tr>
                                    <td style="color: var(--text-secondary);">{{ $item->item->name }}</td>
                                    <td style="text-align: center; color: var(--text-secondary);">{{ $item->quantity_requested }}</td>
                                    <td style="text-align: center; color: var(--text-secondary);">{{ $item->quantity_returned }}</td>
                                    <td style="text-align: center; color: var(--text-primary);"><strong>{{ $item->quantity_requested - $item->quantity_returned }}</strong></td>
                                    <td style="text-align: center;">
                                        @if($item->quantity_returned >= $item->quantity_requested)
                                            <span class="erp-badge" style="background: rgba(52,211,153,0.12); color: #34d399;">คืนแล้ว</span>
                                        @else
                                            <span class="erp-badge" style="background: rgba(251,191,36,0.12); color: #fbbf24;">กำลังยืม</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="color: var(--text-primary);">รวม</th>
                                <th style="text-align: center; color: var(--text-primary);">{{ $borrowing->items->sum('quantity_requested') }}</th>
                                <th style="text-align: center; color: var(--text-primary);">{{ $borrowing->items->sum('quantity_returned') }}</th>
                                <th style="text-align: center; color: var(--text-primary);">{{ $borrowing->items->sum(fn($i) => $i->quantity_requested - $i->quantity_returned) }}</th>
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
<div class="row mt-3 no-print">
    <div class="col-12">
        <div class="erp-card">
            <div class="erp-card-body">
                <div class="d-flex justify-content-end gap-2">
                    @if(!in_array($borrowing->status, ['returned_all', 'returned_partial', 'rejected']))
                        <a href="{{ route('inventory.borrowing.edit', $borrowing->id) }}" class="erp-btn-secondary" style="border-color: #f59e0b; color: #f59e0b;">
                            <i class="fas fa-edit me-2"></i>แก้ไข
                        </a>
                        <a href="{{ route('inventory.borrowing.return', $borrowing->id) }}" class="erp-btn-secondary" style="border-color: #34d399; color: #34d399;">
                            <i class="fas fa-undo me-2"></i>คืนสินค้า
                        </a>
                    @endif
                    <a href="{{ route('inventory.borrowing.index') }}" class="erp-btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>กลับ
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
