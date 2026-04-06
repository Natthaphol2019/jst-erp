@extends('layouts.app')

@section('title', 'ระบบเบิกอุปทาน - JST ERP')

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
    <h2>ระบบเบิกอุปทาน</h2>
    <p>พิมพ์เมื่อ {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
</div>

<div class="d-flex justify-content-between align-items-start mb-4 no-print">
    <div>
        <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            <i class="fas fa-file-alt me-2" style="color: #818cf8;"></i>ระบบเบิกอุปทาน
        </h4>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">จัดการใบเบิกสินค้าจากคลัง</p>
    </div>
    <div class="d-flex gap-2 no-print">
        <button onclick="window.print()" class="erp-btn-secondary">
            <i class="fas fa-print me-2"></i>พิมพ์
        </button>
        @if(in_array(auth()->user()->role, ['admin', 'inventory']))
            <a href="{{ route('exports.requisitions') }}" class="erp-btn-primary" style="background: #22c55e; border-color: #22c55e;">
                <i class="fas fa-file-excel me-2"></i>Export Excel
            </a>
        @endif
        <a href="{{ route('inventory.requisition.create') }}" class="erp-btn-primary">
            <i class="fas fa-plus me-2"></i>สร้างใบเบิกใหม่
        </a>
    </div>
</div>

{{-- Filter Form --}}
<div class="erp-card mb-4 no-print">
    <div class="erp-card-body">
        <form method="GET" action="{{ route('inventory.requisition.index') }}" class="row g-3">
            <div class="col-md-5">
                <label class="erp-label">ค้นหา</label>
                <input type="text" name="search" class="erp-input"
                       value="{{ request('search') }}"
                       placeholder="ชื่อพนักงาน, รหัสพนักงาน">
            </div>
            <div class="col-md-4">
                <label class="erp-label">สถานะ</label>
                <div class="d-flex gap-2 flex-wrap" style="padding-top: 6px;">
                    <a href="{{ route('inventory.requisition.index', array_merge(request()->query(), ['status' => ''])) }}"
                       class="erp-filter-btn {{ !request('status') ? 'active' : '' }}">
                        <i class="fas fa-layer-group me-1"></i>ทั้งหมด
                    </a>
                    <a href="{{ route('inventory.requisition.index', array_merge(request()->query(), ['status' => 'issued'])) }}"
                       class="erp-filter-btn {{ request('status') == 'issued' ? 'active' : '' }}"
                       style="{{ request('status') == 'issued' ? '' : 'background: rgba(52,211,153,0.08); border-color: rgba(52,211,153,0.3); color: #34d399;' }}">
                        <i class="fas fa-check-circle me-1"></i>เบิกแล้ว
                    </a>
                    <a href="{{ route('inventory.requisition.index', array_merge(request()->query(), ['status' => 'rejected'])) }}"
                       class="erp-filter-btn {{ request('status') == 'rejected' ? 'active' : '' }}"
                       style="{{ request('status') == 'rejected' ? '' : 'background: rgba(239,68,68,0.08); border-color: rgba(239,68,68,0.3); color: #f87171;' }}">
                        <i class="fas fa-times-circle me-1"></i>ปฏิเสธ
                    </a>
                </div>
            </div>
            <div class="col-md-3 d-flex align-items-end gap-2">
                <button type="submit" class="erp-btn-primary flex-grow-1">
                    <i class="fas fa-search me-1"></i>ค้นหา
                </button>
                <a href="{{ route('inventory.requisition.index') }}" class="erp-btn-secondary">
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
                        <a href="{{ route('inventory.requisition.index', array_filter(request()->query(), fn($k, $v) => $k !== 'search', ARRAY_FILTER_USE_BOTH)) }}" style="color: inherit; margin-left: 4px;">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                @endif
                @if(request('status'))
                    @php
                        $statusText = match(request('status')) {
                            'issued' => 'เบิกแล้ว',
                            'rejected' => 'ปฏิเสธ',
                            default => request('status')
                        };
                        $statusColor = match(request('status')) {
                            'issued' => '#34d399',
                            'rejected' => '#f87171',
                            default => '#6366f1'
                        };
                    @endphp
                    <span class="erp-badge" style="background: rgba(52,211,153,0.1); color: {{ $statusColor }}; font-size: 11px;">
                        <i class="fas fa-filter me-1"></i>สถานะ: {{ $statusText }}
                        <a href="{{ route('inventory.requisition.index', array_filter(request()->query(), fn($k, $v) => $k !== 'status', ARRAY_FILTER_USE_BOTH)) }}" style="color: inherit; margin-left: 4px;">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                @endif
                <a href="{{ route('inventory.requisition.index') }}" style="font-size: 11px; color: #ef4444; text-decoration: underline;">
                    <i class="fas fa-redo me-1"></i>ล้างตัวกรองทั้งหมด
                </a>
            </div>
        </div>
        @endif
    </div>
</div>

{{-- Success/Error Messages --}}
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

{{-- Requisition Table --}}
<div class="erp-card no-print">
    <div class="erp-table-wrap">
        <table class="erp-table">
            <thead>
                <tr>
                    <th width="80">เลขที่</th>
                    <th width="100">วันที่เบิก</th>
                    <th width="100" style="text-align: center;">เวลา</th>
                    <th>ผู้เบิก</th>
                    <th width="100" style="text-align: center;">จำนวน</th>
                    <th width="100">สถานะ</th>
                    <th width="150" style="text-align: center;">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requisitions as $req)
                    @php
                        $statusBadge = match($req->status) {
                            'issued' => ['bg' => 'rgba(52,211,153,0.12)', 'color' => '#34d399', 'text' => 'เบิกแล้ว'],
                            'pending' => ['bg' => 'rgba(251,191,36,0.12)', 'color' => '#fbbf24', 'text' => 'รออนุมัติ'],
                            'approved' => ['bg' => 'rgba(52,211,153,0.12)', 'color' => '#34d399', 'text' => 'อนุมัติแล้ว'],
                            'rejected' => ['bg' => 'rgba(239,68,68,0.12)', 'color' => '#f87171', 'text' => 'ปฏิเสธ'],
                            default => ['bg' => 'rgba(107,114,128,0.12)', 'color' => '#9ca3af', 'text' => $req->status]
                        };
                    @endphp
                    <tr>
                        <td><strong style="color: var(--text-primary);">#{{ str_pad($req->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                        <td style="color: var(--text-secondary);">{{ \Carbon\Carbon::parse($req->req_date)->format('d/m/Y') }}</td>
                        <td style="text-align: center;">
                            @if($req->created_at)
                                <span style="color: var(--text-secondary); font-size: 11px;">{{ $req->created_at->format('H:i') }}</span>
                            @else
                                <span style="color: var(--text-muted); font-size: 11px;">-</span>
                            @endif
                        </td>
                        <td>
                            <div style="color: var(--text-primary);">{{ $req->employee->firstname }} {{ $req->employee->lastname }}</div>
                            <small style="color: var(--text-muted);">{{ $req->employee->employee_code }}</small>
                        </td>
                        <td style="text-align: center; color: var(--text-secondary);">{{ $req->items->sum('quantity_requested') }}</td>
                        <td>
                            <span class="erp-badge" style="background: {{ $statusBadge['bg'] }}; color: {{ $statusBadge['color'] }};">
                                {{ $statusBadge['text'] }}
                            </span>
                        </td>
                        <td style="text-align: center;">
                            <div class="d-flex gap-1 justify-content-center">
                                <a href="{{ route('inventory.requisition.show', $req->id) }}"
                                   class="erp-btn-secondary" title="ดูรายละเอียด" style="padding: 4px 8px; font-size: 12px;">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if(in_array($req->status, ['issued', 'pending']))
                                    <a href="{{ route('inventory.requisition.edit', $req->id) }}"
                                       class="erp-btn-secondary" title="แก้ไข" style="padding: 4px 8px; font-size: 12px; border-color: #f59e0b; color: #f59e0b;">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endif
                                @if($req->status === 'pending' && in_array(auth()->user()->role, ['admin', 'inventory']))
                                    <a href="{{ route('inventory.requisition.approve', $req->id) }}"
                                       class="erp-btn-secondary" title="อนุมัติ/ปฏิเสธ" style="padding: 4px 8px; font-size: 12px; border-color: #34d399; color: #34d399;">
                                        <i class="fas fa-check"></i>
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
                                <div style="color: var(--text-muted); margin-top: 8px;">ไม่พบข้อมูลใบเบิก</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Pagination --}}
@if($requisitions->hasPages())
    <div style="padding: 16px; border-top: 1px solid var(--border);">
        <div class="d-flex justify-content-between align-items-center">
            <div style="font-size: 13px; color: var(--text-secondary);">
                แสดง <strong style="color: var(--text-primary);">{{ $requisitions->firstItem() }}</strong> ถึง <strong style="color: var(--text-primary);">{{ $requisitions->lastItem() }}</strong> จาก <strong style="color: var(--text-primary);">{{ $requisitions->total() }}</strong> รายการ
            </div>
            {{ $requisitions->links() }}
        </div>
    </div>
@endif
@endsection
