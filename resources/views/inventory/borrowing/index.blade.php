@extends('layouts.app')

@section('title', 'ระบบยืม-คืนอุปกรณ์ - JST ERP')

@section('content')
<style>
/* Filter Buttons */
.erp-filter-btn {
    display: inline-flex;
    align-items: center;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 500;
    text-decoration: none;
    background: var(--input-bg);
    border: 1px solid var(--input-border);
    color: var(--text-secondary);
    transition: all 0.15s;
    cursor: pointer;
    white-space: nowrap;
}
.erp-filter-btn:hover {
    background: rgba(99,102,241,0.12);
    border-color: rgba(99,102,241,0.3);
    color: var(--accent);
    text-decoration: none;
}
.erp-filter-btn.active {
    background: var(--accent);
    border-color: var(--accent);
    color: white;
    font-weight: 600;
}
.erp-filter-btn.active i {
    color: white;
}

.print-header { display: none; }

@media print {
    /* ซ่อน UI elements ที่ไม่ต้องการ */
    .no-print, .no-print * { display: none !important; }

    /* ใช้ Font ที่รองรับภาษาไทย */
    body, h1, h2, h3, h4, h5, h6, p, span, div, td, th, strong, small {
        font-family: 'Noto Sans Thai', 'Tahoma', 'Segoe UI', sans-serif !important;
        text-shadow: none !important;
        text-decoration: none !important;
    }

    /* Print header */
    .print-header { display: block !important; text-align: center; margin-bottom: 20px; }
    .print-header h2 { margin: 0; font-size: 18pt; font-weight: bold; }
    .print-header p { margin: 5px 0 0; font-size: 10pt; color: #666; }

    /* จัดหน้ากระดาษ */
    body { background-color: #fff !important; margin: 0 !important; padding: 0 !important; }
    .erp-layout { display: block !important; }
    .erp-main { width: 100% !important; }
    .container-fluid { width: 100% !important; max-width: 100% !important; padding: 0 !important; margin: 0 !important; }
    .content { padding: 0 !important; margin: 0 !important; }
    .row { margin: 0 !important; }
    .col-md-12, .col-12 { width: 100% !important; flex: 0 0 100% !important; max-width: 100% !important; }

    /* Table - แสดงข้อมูลให้ครบ */
    .erp-card { border: 1px solid #dee2e6 !important; box-shadow: none !important; margin-bottom: 1rem !important; }
    .erp-table-wrap { overflow: visible !important; }
    table { font-size: 9pt !important; width: 100% !important; border-collapse: collapse !important; display: table !important; }
    table thead { display: table-header-group !important; background-color: #f8f9fa !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    table tbody { display: table-row-group !important; }
    table tr { display: table-row !important; page-break-inside: avoid; }
    table th, table td { display: table-cell !important; border: 1px solid #dee2e6 !important; padding: 4px 6px !important; }
    table th { font-weight: 600 !important; background-color: #f8f9fa !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }

    /* Badge */
    .erp-badge { border: 1px solid #6c757d !important; padding: 2px 6px !important; border-radius: 4px !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }

    @page { margin: 1.5cm; }
}
</style>

<div class="print-header">
    <h2>ระบบยืม-คืนอุปกรณ์</h2>
    <p>พิมพ์เมื่อ {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
</div>

<div class="d-flex justify-content-between align-items-start mb-4 no-print">
    <div>
        <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            <i class="fas fa-hand-holding me-2" style="color: #818cf8;"></i>ระบบยืม-คืนอุปกรณ์
        </h4>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">จัดการการยืมและคืนอุปกรณ์</p>
    </div>
    <div class="d-flex gap-2 no-print">
        <button onclick="window.open('{{ route('inventory.borrowing.pdf-list') }}', '_blank', 'width=1000,height=700')" class="erp-btn-secondary">
            <i class="fas fa-print me-2"></i>พิมพ์รายการทั้งหมด
        </button>
        <a href="{{ route('exports.borrowings') }}" class="erp-btn-primary" style="background: #22c55e; border-color: #22c55e;">
            <i class="fas fa-file-excel me-2"></i>Export Excel
        </a>
        <a href="{{ route('inventory.borrowing.create') }}" class="erp-btn-primary">
            <i class="fas fa-plus me-2"></i>สร้างใบยืมใหม่
        </a>
    </div>
</div>

{{-- Filter Form --}}
<div class="erp-card mb-4 no-print">
    <div class="erp-card-body">
        <form method="GET" action="{{ route('inventory.borrowing.index') }}" class="row g-3">
            <div class="col-md-5">
                <label class="erp-label">ค้นหา</label>
                <input type="text" name="search" class="erp-input"
                       value="{{ request('search') }}"
                       placeholder="ชื่อพนักงาน, รหัสพนักงาน">
            </div>
            <div class="col-md-4">
                <label class="erp-label">สถานะ</label>
                <div class="d-flex gap-2 flex-wrap" style="padding-top: 6px;">
                    <a href="{{ route('inventory.borrowing.index', array_merge(request()->query(), ['status' => ''])) }}"
                       class="erp-filter-btn {{ !request('status') ? 'active' : '' }}">
                        <i class="fas fa-layer-group me-1"></i>ทั้งหมด
                    </a>
                    <a href="{{ route('inventory.borrowing.index', array_merge(request()->query(), ['status' => 'approved'])) }}"
                       class="erp-filter-btn {{ request('status') == 'approved' ? 'active' : '' }}"
                       style="{{ request('status') == 'approved' ? '' : 'background: rgba(96,165,250,0.08); border-color: rgba(96,165,250,0.3); color: #60a5fa;' }}">
                        <i class="fas fa-hand-holding me-1"></i>กำลังยืม
                    </a>
                    <a href="{{ route('inventory.borrowing.index', array_merge(request()->query(), ['status' => 'returned_partial'])) }}"
                       class="erp-filter-btn {{ request('status') == 'returned_partial' ? 'active' : '' }}"
                       style="{{ request('status') == 'returned_partial' ? '' : 'background: rgba(251,191,36,0.08); border-color: rgba(251,191,36,0.3); color: #fbbf24;' }}">
                        <i class="fas fa-clock me-1"></i>คืนบางส่วน
                    </a>
                    <a href="{{ route('inventory.borrowing.index', array_merge(request()->query(), ['status' => 'returned_all'])) }}"
                       class="erp-filter-btn {{ request('status') == 'returned_all' ? 'active' : '' }}"
                       style="{{ request('status') == 'returned_all' ? '' : 'background: rgba(52,211,153,0.08); border-color: rgba(52,211,153,0.3); color: #34d399;' }}">
                        <i class="fas fa-check-double me-1"></i>คืนครบแล้ว
                    </a>
                </div>
            </div>
            <div class="col-md-3 d-flex align-items-end gap-2">
                <button type="submit" class="erp-btn-primary flex-grow-1">
                    <i class="fas fa-search me-1"></i>ค้นหา
                </button>
                <a href="{{ route('inventory.borrowing.index') }}" class="erp-btn-secondary">
                    <i class="fas fa-redo me-1"></i>รีเซ็ต
                </a>
            </div>
        </form>
        
        {{-- Active Filters Indicator --}}
        @if(request()->hasAny(['search', 'status']))
        <div style="margin-top: 12px; padding-top: 12px; border-top: 1px solid var(--border);">
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <span style="font-size: 11px; color: var(--text-muted); font-weight: 500;">
                    <i class="fas fa-info-circle me-1"></i>กำลังกรอง:
                </span>
                @if(request('search'))
                    <span class="erp-badge" style="background: rgba(99,102,241,0.1); color: #6366f1; font-size: 11px;">
                        <i class="fas fa-search me-1"></i>ค้นหา: "{{ request('search') }}"
                        <a href="{{ route('inventory.borrowing.index', array_filter(request()->query(), fn($k, $v) => $k !== 'search', ARRAY_FILTER_USE_BOTH)) }}" style="color: inherit; margin-left: 4px;">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                @endif
                @if(request('status'))
                    @php
                        $statusText = match(request('status')) {
                            'approved' => 'กำลังยืม',
                            'returned_partial' => 'คืนบางส่วน',
                            'returned_all' => 'คืนครบแล้ว',
                            default => request('status')
                        };
                        $statusColor = match(request('status')) {
                            'approved' => '#60a5fa',
                            'returned_partial' => '#fbbf24',
                            'returned_all' => '#34d399',
                            default => '#6366f1'
                        };
                    @endphp
                    <span class="erp-badge" style="background: rgba(52,211,153,0.1); color: {{ $statusColor }}; font-size: 11px;">
                        <i class="fas fa-filter me-1"></i>สถานะ: {{ $statusText }}
                        <a href="{{ route('inventory.borrowing.index', array_filter(request()->query(), fn($k, $v) => $k !== 'status', ARRAY_FILTER_USE_BOTH)) }}" style="color: inherit; margin-left: 4px;">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                @endif
                <a href="{{ route('inventory.borrowing.index') }}" style="font-size: 11px; color: #ef4444; text-decoration: underline;">
                    <i class="fas fa-redo me-1"></i>ล้างตัวกรองทั้งหมด
                </a>
            </div>
        </div>
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

{{-- Borrowing Table --}}
<div class="erp-card" id="printableTable">
    <div class="erp-table-wrap">
        <table class="erp-table">
            <thead>
                <tr>
                    <th width="80">เลขที่</th>
                    <th width="120">วันที่ยืม</th>
                    <th width="120">กำหนดคืน</th>
                    <th>ผู้ยืม</th>
                    <th width="100" style="text-align: center;">จำนวนรายการ</th>
                    <th width="120">สถานะ</th>
                    <th width="150" class="no-print" style="text-align: center;">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($borrowings as $borrowing)
                    @php
                        $isOverdue = in_array($borrowing->status, ['approved', 'returned_partial']) && now()->gt(\Carbon\Carbon::parse($borrowing->due_date));
                        $statusBadge = match($borrowing->status) {
                            'approved' => $isOverdue ? ['bg' => 'rgba(239,68,68,0.12)', 'color' => '#f87171', 'text' => 'เกินกำหนด'] : ['bg' => 'rgba(99,102,241,0.12)', 'color' => '#818cf8', 'text' => 'กำลังยืม'],
                            'returned_all' => ['bg' => 'rgba(52,211,153,0.12)', 'color' => '#34d399', 'text' => 'คืนครบแล้ว'],
                            'returned_partial' => ['bg' => 'rgba(56,189,248,0.12)', 'color' => '#38bdf8', 'text' => 'คืนบางส่วน'],
                            'rejected' => ['bg' => 'rgba(239,68,68,0.12)', 'color' => '#f87171', 'text' => 'ปฏิเสธ'],
                            default => ['bg' => 'rgba(107,114,128,0.12)', 'color' => '#9ca3af', 'text' => $borrowing->status]
                        };
                    @endphp
                    <tr>
                        <td><strong style="color: var(--text-primary);">#{{ str_pad($borrowing->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                        <td style="color: var(--text-secondary);">{{ \Carbon\Carbon::parse($borrowing->req_date)->format('d/m/Y') }}</td>
                        <td>
                            <span style="color: var(--text-secondary);">{{ \Carbon\Carbon::parse($borrowing->due_date)->format('d/m/Y') }}</span>
                            @if($isOverdue)
                                <br><small style="color: #f87171;">
                                    (เกิน {{ now()->diffInDays(\Carbon\Carbon::parse($borrowing->due_date)) }} วัน)
                                </small>
                            @endif
                        </td>
                        <td>
                            <div style="color: var(--text-primary);">{{ $borrowing->employee->firstname }} {{ $borrowing->employee->lastname }}</div>
                            <small style="color: var(--text-muted);">{{ $borrowing->employee->employee_code }}</small>
                        </td>
                        <td style="text-align: center; color: var(--text-secondary);">{{ $borrowing->items->count() }} รายการ</td>
                        <td>
                            <span class="erp-badge" style="background: {{ $statusBadge['bg'] }}; color: {{ $statusBadge['color'] }};">
                                {{ $statusBadge['text'] }}
                            </span>
                        </td>
                        <td class="no-print" style="text-align: center;">
                            <div class="d-flex gap-1 justify-content-center">
                                <a href="{{ route('inventory.borrowing.show', $borrowing->id) }}"
                                   class="erp-btn-secondary" title="ดูรายละเอียด" style="padding: 4px 8px; font-size: 12px;">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if(!in_array($borrowing->status, ['returned_all', 'rejected']))
                                    <a href="{{ route('inventory.borrowing.edit', $borrowing->id) }}"
                                       class="erp-btn-secondary" title="แก้ไข" style="padding: 4px 8px; font-size: 12px; border-color: #f59e0b; color: #f59e0b;">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endif
                                @if(!in_array($borrowing->status, ['returned_all', 'rejected']))
                                    <a href="{{ route('inventory.borrowing.return', $borrowing->id) }}"
                                       class="erp-btn-secondary" title="คืนสินค้า" style="padding: 4px 8px; font-size: 12px; border-color: #34d399; color: #34d399;">
                                        <i class="fas fa-undo"></i> คืน
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center" style="padding: 3rem;">
                            <div class="erp-empty" style="padding: 1rem;">
                                <i class="fas fa-inbox" style="font-size: 2rem; color: var(--text-muted);"></i>
                                <div style="color: var(--text-muted); margin-top: 8px;">ไม่พบข้อมูลใบยืม</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Pagination --}}
@if($borrowings->hasPages())
    <div class="no-print" style="padding: 16px; border-top: 1px solid var(--border);">
        <div class="d-flex justify-content-between align-items-center">
            <div style="font-size: 13px; color: var(--text-secondary);">
                แสดง <strong style="color: var(--text-primary);">{{ $borrowings->firstItem() }}</strong> ถึง <strong style="color: var(--text-primary);">{{ $borrowings->lastItem() }}</strong> จาก <strong style="color: var(--text-primary);">{{ $borrowings->total() }}</strong> รายการ
            </div>
            {{ $borrowings->links() }}
        </div>
    </div>
@endif
@endsection
