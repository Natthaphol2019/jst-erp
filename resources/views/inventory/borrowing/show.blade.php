@extends('layouts.app')

@section('title', 'รายละเอียดใบยืม - JST ERP')

@section('content')
<style>
.print-header { display: none; }
.print-content { display: none; }

@media print {
    .print-header { display: block !important; }
    .print-content { display: block !important; }
    .no-print, .no-print * { display: none !important; }
    .erp-card, .row.g-3, .d-flex.mb-4 { display: none !important; }

    body {
        background: #fff !important;
        margin: 0 !important;
        padding: 15px !important;
        font-family: 'Noto Sans Thai', 'Tahoma', sans-serif !important;
        color: #000 !important;
    }

    /* Print header */
    .print-header {
        display: block !important;
        text-align: center;
        margin-bottom: 20px;
        border-bottom: 2px solid #333;
        padding-bottom: 10px;
    }
    .print-header h2 { margin: 0; font-size: 20pt; font-weight: bold; }
    .print-header p { margin: 5px 0 0; font-size: 10pt; color: #555; }

    /* Print section layout */
    .print-section {
        margin-bottom: 15px;
        border: 1px solid #999;
        page-break-inside: avoid;
    }
    .print-section-title {
        background: #eee;
        padding: 8px 12px;
        font-weight: bold;
        border-bottom: 1px solid #999;
        font-size: 12pt;
        -webkit-print-color-adjust: exact;
    }
    .print-row {
        display: table;
        width: 100%;
        border-bottom: 1px solid #ddd;
    }
    .print-row:last-child { border-bottom: none; }
    .print-label {
        display: table-cell;
        width: 130px;
        padding: 6px 10px;
        background: #f5f5f5;
        font-size: 11px;
        font-weight: bold;
        border-right: 1px solid #ddd;
        -webkit-print-color-adjust: exact;
    }
    .print-value {
        display: table-cell;
        padding: 6px 10px;
        font-size: 12px;
        color: #000;
    }

    /* Table */
    .print-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 10pt;
        margin-top: 10px;
    }
    .print-table thead { background: #ddd !important; -webkit-print-color-adjust: exact; }
    .print-table th, .print-table td {
        border: 1px solid #999;
        padding: 5px 8px;
        text-align: left;
    }
    .print-table th { font-weight: bold; }
    .print-table tfoot { font-weight: bold; background: #f5f5f5 !important; -webkit-print-color-adjust: exact; }

    .erp-badge { border: 1px solid #666 !important; padding: 2px 6px !important; }

    @page { margin: 1cm; }
}
</style>

<div class="print-header">
    <h2>ใบยืม-คืนอุปกรณ์</h2>
    <p>เลขที่ #{{ str_pad($borrowing->id, 4, '0', STR_PAD_LEFT) }} | พิมพ์เมื่อ {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
</div>

{{-- Print-only content - ซ่อนบนหน้าจอ แสดงเฉพาะตอนพิมพ์ --}}
<div class="print-content">

    <div class="print-section">
        <div class="print-section-title">ข้อมูลใบยืม</div>
        <div class="print-row">
            <div class="print-label">เลขที่ใบยืม</div>
            <div class="print-value"><strong>#{{ str_pad($borrowing->id, 4, '0', STR_PAD_LEFT) }}</strong></div>
        </div>
        <div class="print-row">
            <div class="print-label">วันที่ยืม</div>
            <div class="print-value">{{ \Carbon\Carbon::parse($borrowing->req_date)->format('d/m/Y') }}</div>
        </div>
        <div class="print-row">
            <div class="print-label">กำหนดคืน</div>
            <div class="print-value">
                {{ \Carbon\Carbon::parse($borrowing->due_date)->format('d/m/Y') }}
                @php
                    $isOverdue = in_array($borrowing->status, ['approved', 'returned_partial']) && now()->gt(\Carbon\Carbon::parse($borrowing->due_date));
                @endphp
                @if($isOverdue)
                    <span style="color: #ef4444; font-weight: bold;"> (เกินกำหนด {{ now()->diffInDays(\Carbon\Carbon::parse($borrowing->due_date)) }} วัน)</span>
                @endif
            </div>
        </div>
        <div class="print-row">
            <div class="print-label">สถานะ</div>
            <div class="print-value">
                @php
                    $statusText = match($borrowing->status) {
                        'approved' => $isOverdue ? 'เกินกำหนด' : 'กำลังยืม',
                        'returned_all' => 'คืนครบแล้ว',
                        'returned_partial' => 'คืนบางส่วน',
                        'rejected' => 'ปฏิเสธ',
                        default => $borrowing->status
                    };
                @endphp
                {{ $statusText }}
            </div>
        </div>
        <div class="print-row">
            <div class="print-label">ผู้อนุมัติ</div>
            <div class="print-value">{{ $borrowing->approver->name ?? '-' }}</div>
        </div>
        @if($borrowing->note)
        <div class="print-row">
            <div class="print-label">หมายเหตุ</div>
            <div class="print-value">{{ $borrowing->note }}</div>
        </div>
        @endif
    </div>

    <div class="print-section">
        <div class="print-section-title">ข้อมูลผู้ยืม</div>
        <div class="print-row">
            <div class="print-label">รหัสพนักงาน</div>
            <div class="print-value">{{ $borrowing->employee->employee_code }}</div>
        </div>
        <div class="print-row">
            <div class="print-label">ชื่อ-นามสกุล</div>
            <div class="print-value"><strong>{{ $borrowing->employee->firstname }} {{ $borrowing->employee->lastname }}</strong></div>
        </div>
        @if($borrowing->employee->department)
        <div class="print-row">
            <div class="print-label">แผนก</div>
            <div class="print-value">{{ $borrowing->employee->department->name }}</div>
        </div>
        @endif
        @if($borrowing->employee->position)
        <div class="print-row">
            <div class="print-label">ตำแหน่ง</div>
            <div class="print-value">{{ $borrowing->employee->position->name }}</div>
        </div>
        @endif
    </div>

    <div class="print-section">
        <div class="print-section-title">รายการสินค้ายืม</div>
        <table class="print-table">
            <thead>
                <tr>
                    <th>สินค้า</th>
                    <th style="width: 60px; text-align: center;">ยืม</th>
                    <th style="width: 60px; text-align: center;">คืนแล้ว</th>
                    <th style="width: 60px; text-align: center;">คงเหลือ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($borrowing->items as $item)
                    <tr>
                        <td>{{ $item->item->name }}</td>
                        <td style="text-align: center;">{{ $item->quantity_requested }}</td>
                        <td style="text-align: center;">{{ $item->quantity_returned }}</td>
                        <td style="text-align: center;"><strong>{{ $item->quantity_requested - $item->quantity_returned }}</strong></td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>รวม</th>
                    <th style="text-align: center;">{{ $borrowing->items->sum('quantity_requested') }}</th>
                    <th style="text-align: center;">{{ $borrowing->items->sum('quantity_returned') }}</th>
                    <th style="text-align: center;">{{ $borrowing->items->sum(fn($i) => $i->quantity_requested - $i->quantity_returned) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<div class="d-flex justify-content-between align-items-start mb-4 no-print">
    <div>
        <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            <i class="fas fa-eye me-2" style="color: #818cf8;"></i>รายละเอียดใบยืม
        </h4>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">ดูข้อมูลใบยืม</p>
    </div>
    <div class="d-flex gap-2 no-print">
        <button onclick="window.open('{{ route('inventory.borrowing.pdf', $borrowing->id) }}', '_blank', 'width=800,height=600')" class="erp-btn-secondary">
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
                <div style="background: var(--bg-surface); border: 1px solid var(--border); border-radius: 10px; overflow: hidden;">
                    <div style="display: flex; flex-direction: column;">
                        <div class="info-row" style="display: flex; border-bottom: 1px solid var(--border);">
                            <div class="info-label" style="width: 150px; padding: 12px 16px; background: var(--bg-raised); font-size: 12px; color: var(--text-muted); font-weight: 500; flex-shrink: 0;">
                                <i class="fas fa-file-invoice me-1" style="color: var(--accent);"></i>เลขที่ใบยืม
                            </div>
                            <div class="info-value" style="flex: 1; padding: 12px 16px; font-size: 14px; font-weight: 600; color: var(--text-primary);">
                                #{{ str_pad($borrowing->id, 4, '0', STR_PAD_LEFT) }}
                            </div>
                        </div>
                        <div class="info-row" style="display: flex; border-bottom: 1px solid var(--border);">
                            <div class="info-label" style="width: 150px; padding: 12px 16px; background: var(--bg-raised); font-size: 12px; color: var(--text-muted); font-weight: 500; flex-shrink: 0;">
                                <i class="fas fa-calendar me-1" style="color: var(--accent);"></i>วันที่ยืม
                            </div>
                            <div class="info-value" style="flex: 1; padding: 12px 16px; font-size: 13px; color: var(--text-secondary);">
                                {{ \Carbon\Carbon::parse($borrowing->req_date)->format('d/m/Y') }}
                            </div>
                        </div>
                        <div class="info-row" style="display: flex; border-bottom: 1px solid var(--border);">
                            <div class="info-label" style="width: 150px; padding: 12px 16px; background: var(--bg-raised); font-size: 12px; color: var(--text-muted); font-weight: 500; flex-shrink: 0;">
                                <i class="fas fa-calendar-check me-1" style="color: var(--accent);"></i>กำหนดคืน
                            </div>
                            <div class="info-value" style="flex: 1; padding: 12px 16px; font-size: 13px; color: var(--text-secondary); display: flex; align-items: center; gap: 8px;">
                                {{ \Carbon\Carbon::parse($borrowing->due_date)->format('d/m/Y') }}
                                @php
                                    $isOverdue = in_array($borrowing->status, ['approved', 'returned_partial']) && now()->gt(\Carbon\Carbon::parse($borrowing->due_date));
                                @endphp
                                @if($isOverdue)
                                    <span class="erp-badge" style="background: rgba(239,68,68,0.12); color: #f87171;">เกินกำหนด</span>
                                    <small style="color: #f87171;">
                                        ({{ now()->diffInDays(\Carbon\Carbon::parse($borrowing->due_date)) }} วัน)
                                    </small>
                                @endif
                            </div>
                        </div>
                        <div class="info-row" style="display: flex; border-bottom: 1px solid var(--border);">
                            <div class="info-label" style="width: 150px; padding: 12px 16px; background: var(--bg-raised); font-size: 12px; color: var(--text-muted); font-weight: 500; flex-shrink: 0;">
                                <i class="fas fa-circle-dot me-1" style="color: var(--accent);"></i>สถานะ
                            </div>
                            <div class="info-value" style="flex: 1; padding: 12px 16px; display: flex; align-items: center;">
                                @php
                                    $statusBadge = match($borrowing->status) {
                                        'approved' => $isOverdue ? ['bg' => 'rgba(239,68,68,0.12)', 'color' => '#f87171', 'text' => 'เกินกำหนด'] : ['bg' => 'rgba(99,102,241,0.12)', 'color' => '#818cf8', 'text' => 'กำลังยืม'],
                                        'returned_all' => ['bg' => 'rgba(52,211,153,0.12)', 'color' => '#34d399', 'text' => 'คืนครบแล้ว'],
                                        'returned_partial' => ['bg' => 'rgba(56,189,248,0.12)', 'color' => '#38bdf8', 'text' => 'คืนบางส่วน'],
                                        'rejected' => ['bg' => 'rgba(239,68,68,0.12)', 'color' => '#f87171', 'text' => 'ปฏิเสธ'],
                                        default => ['bg' => 'rgba(107,114,128,0.12)', 'color' => '#9ca3af', 'text' => $borrowing->status]
                                    };
                                @endphp
                                <span class="erp-badge" style="background: {{ $statusBadge['bg'] }}; color: {{ $statusBadge['color'] }}">
                                    {{ $statusBadge['text'] }}
                                </span>
                            </div>
                        </div>
                        <div class="info-row" style="display: flex; border-bottom: 1px solid var(--border);">
                            <div class="info-label" style="width: 150px; padding: 12px 16px; background: var(--bg-raised); font-size: 12px; color: var(--text-muted); font-weight: 500; flex-shrink: 0;">
                                <i class="fas fa-user-check me-1" style="color: var(--accent);"></i>ผู้อนุมัติ
                            </div>
                            <div class="info-value" style="flex: 1; padding: 12px 16px; font-size: 13px; color: var(--text-secondary);">
                                {{ $borrowing->approver->name ?? '-' }}
                            </div>
                        </div>
                        @if($borrowing->note)
                        <div class="info-row" style="display: flex;">
                            <div class="info-label" style="width: 150px; padding: 12px 16px; background: var(--bg-raised); font-size: 12px; color: var(--text-muted); font-weight: 500; flex-shrink: 0;">
                                <i class="fas fa-comment me-1" style="color: var(--accent);"></i>หมายเหตุ
                            </div>
                            <div class="info-value" style="flex: 1; padding: 12px 16px; font-size: 13px; color: var(--text-secondary);">
                                {{ $borrowing->note }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
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
                <div style="background: var(--bg-surface); border: 1px solid var(--border); border-radius: 10px; overflow: hidden;">
                    <div style="display: flex; flex-direction: column;">
                        <div class="info-row" style="display: flex; border-bottom: 1px solid var(--border);">
                            <div class="info-label" style="width: 150px; padding: 12px 16px; background: var(--bg-raised); font-size: 12px; color: var(--text-muted); font-weight: 500; flex-shrink: 0;">
                                <i class="fas fa-id-badge me-1" style="color: var(--accent);"></i>รหัสพนักงาน
                            </div>
                            <div class="info-value" style="flex: 1; padding: 12px 16px; font-size: 13px; color: var(--text-secondary);">
                                {{ $borrowing->employee->employee_code }}
                            </div>
                        </div>
                        <div class="info-row" style="display: flex; border-bottom: 1px solid var(--border);">
                            <div class="info-label" style="width: 150px; padding: 12px 16px; background: var(--bg-raised); font-size: 12px; color: var(--text-muted); font-weight: 500; flex-shrink: 0;">
                                <i class="fas fa-user me-1" style="color: var(--accent);"></i>ชื่อ-นามสกุล
                            </div>
                            <div class="info-value" style="flex: 1; padding: 12px 16px; font-size: 14px; color: var(--text-primary); font-weight: 500;">
                                {{ $borrowing->employee->firstname }} {{ $borrowing->employee->lastname }}
                            </div>
                        </div>
                        @if($borrowing->employee->department)
                        <div class="info-row" style="display: flex; border-bottom: 1px solid var(--border);">
                            <div class="info-label" style="width: 150px; padding: 12px 16px; background: var(--bg-raised); font-size: 12px; color: var(--text-muted); font-weight: 500; flex-shrink: 0;">
                                <i class="fas fa-building me-1" style="color: var(--accent);"></i>แผนก
                            </div>
                            <div class="info-value" style="flex: 1; padding: 12px 16px; font-size: 13px; color: var(--text-secondary);">
                                {{ $borrowing->employee->department->name }}
                            </div>
                        </div>
                        @endif
                        @if($borrowing->employee->position)
                        <div class="info-row" style="display: flex;">
                            <div class="info-label" style="width: 150px; padding: 12px 16px; background: var(--bg-raised); font-size: 12px; color: var(--text-muted); font-weight: 500; flex-shrink: 0;">
                                <i class="fas fa-briefcase me-1" style="color: var(--accent);"></i>ตำแหน่ง
                            </div>
                            <div class="info-value" style="flex: 1; padding: 12px 16px; font-size: 13px; color: var(--text-secondary);">
                                {{ $borrowing->employee->position->name }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
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
