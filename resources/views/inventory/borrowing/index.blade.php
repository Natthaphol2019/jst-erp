@extends('layouts.app')

@section('title', 'ระบบยืม-คืนอุปกรณ์ - JST ERP')

@section('content')
<style>
@media print {
    .no-print, .no-print * { display: none !important; }
    .sidebar, .navbar, .btn, .alert, .erp-card-body form { display: none !important; }
    .content { padding: 0 !important; margin: 0 !important; }
    .erp-card { border: 1px solid #dee2e6 !important; box-shadow: none !important; margin-bottom: 1rem !important; }
    table { font-size: 10pt !important; }
    th, td { border: 1px solid #dee2e6 !important; }
    .erp-badge { border: 1px solid #6c757d !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
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

<div class="d-flex justify-content-between align-items-start mb-4 no-print">
    <div>
        <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            <i class="fas fa-hand-holding me-2" style="color: #818cf8;"></i>ระบบยืม-คืนอุปกรณ์
        </h4>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">จัดการการยืมและคืนอุปกรณ์</p>
    </div>
    <div class="d-flex gap-2 no-print">
        <button onclick="window.print()" class="erp-btn-secondary">
            <i class="fas fa-print me-2"></i>พิมพ์
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
                <select name="status" class="erp-select">
                    <option value="">-- ทั้งหมด --</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>กำลังยืม</option>
                    <option value="returned_all" {{ request('status') == 'returned_all' ? 'selected' : '' }}>คืนครบแล้ว</option>
                    <option value="returned_partial" {{ request('status') == 'returned_partial' ? 'selected' : '' }}>คืนบางส่วน</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end gap-2">
                <button type="submit" class="erp-btn-primary flex-grow-1">
                    <i class="fas fa-search me-1"></i>ค้นหา
                </button>
                <a href="{{ route('inventory.borrowing.index') }}" class="erp-btn-secondary">
                    <i class="fas fa-times me-1"></i>รีเซ็ต
                </a>
            </div>
        </form>
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
<div class="erp-card no-print">
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
                    <th width="150" style="text-align: center;">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($borrowings as $borrowing)
                    @php
                        $isOverdue = in_array($borrowing->status, ['approved', 'returned_partial']) && now()->gt(\Carbon\Carbon::parse($borrowing->due_date));
                        $statusBadge = match($borrowing->status) {
                            'approved' => $isOverdue ? ['bg' => 'rgba(239,68,68,0.12)', 'color' => '#f87171', 'text' => 'เกินกำหนด'] : ['bg' => 'rgba(251,191,36,0.12)', 'color' => '#fbbf24', 'text' => 'กำลังยืม'],
                            'returned_all' => ['bg' => 'rgba(52,211,153,0.12)', 'color' => '#34d399', 'text' => 'คืนครบแล้ว'],
                            'returned_partial' => ['bg' => 'rgba(56,189,248,0.12)', 'color' => '#38bdf8', 'text' => 'คืนบางส่วน'],
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
                        <td style="text-align: center;">
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
                        <td colspan="7" class="text-center" style="padding: 3rem;">
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
    <div style="padding: 16px; border-top: 1px solid var(--border);">
        <div class="d-flex justify-content-between align-items-center">
            <div style="font-size: 13px; color: var(--text-secondary);">
                แสดง <strong style="color: var(--text-primary);">{{ $borrowings->firstItem() }}</strong> ถึง <strong style="color: var(--text-primary);">{{ $borrowings->lastItem() }}</strong> จาก <strong style="color: var(--text-primary);">{{ $borrowings->total() }}</strong> รายการ
            </div>
            {{ $borrowings->links() }}
        </div>
    </div>
@endif
@endsection
