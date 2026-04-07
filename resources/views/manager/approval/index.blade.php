@extends('layouts.app')

@section('title', 'รออนุมัติ - Manager Approval')

@section('content')
<style>
.pending-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 20px;
    transition: all 0.2s ease;
}

.pending-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    border-color: #818cf8;
}

.type-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
}

.type-badge.borrow {
    background: rgba(99,102,241,0.1);
    color: #6366f1;
}

.type-badge.consume {
    background: rgba(251,191,36,0.1);
    color: #f59e0b;
}
</style>

<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            <i class="fas fa-clipboard-check me-2" style="color: #818cf8;"></i>รออนุมัติ
        </h4>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">
            รายการที่รอการอนุมัติจากคุณ
        </p>
    </div>
    <a href="{{ route('manager.dashboard') }}" class="erp-btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>กลับ
    </a>
</div>

@if(session('success'))
    <div class="erp-alert erp-alert-success mb-4" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="erp-alert erp-alert-danger mb-4" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>{{ $errors->first() }}
    </div>
@endif

<div class="row g-3">
    <div class="col-md-4">
        <div class="pending-card" style="background: linear-gradient(135deg, #f0f9ff 0%, #e0e7ff 100%); border: 2px solid #818cf8;">
            <div class="d-flex align-items-center gap-3">
                <i class="fas fa-hand-holding" style="font-size: 32px; color: #6366f1;"></i>
                <div>
                    <div style="font-size: 28px; font-weight: 700; color: #6366f1;">{{ $pendingByType['borrow'] }}</div>
                    <div style="font-size: 13px; color: #4b5563;">ใบยืมที่รออนุมัติ</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="pending-card" style="background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%); border: 2px solid #f59e0b;">
            <div class="d-flex align-items-center gap-3">
                <i class="fas fa-box-open" style="font-size: 32px; color: #f59e0b;"></i>
                <div>
                    <div style="font-size: 28px; font-weight: 700; color: #f59e0b;">{{ $pendingByType['consume'] }}</div>
                    <div style="font-size: 13px; color: #4b5563;">ใบเบิกที่รออนุมัติ</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="pending-card" style="background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); border: 2px solid #10b981;">
            <div class="d-flex align-items-center gap-3">
                <i class="fas fa-check-circle" style="font-size: 32px; color: #10b981;"></i>
                <div>
                    <div style="font-size: 28px; font-weight: 700; color: #10b981;">{{ $pendingByType['borrow'] + $pendingByType['consume'] }}</div>
                    <div style="font-size: 13px; color: #4b5563;">รวมทั้งหมด</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Filter Form --}}
<div class="erp-card mt-4">
    <div class="erp-card-body">
        <form action="{{ route('manager.approval.index') }}" method="GET" class="d-flex gap-3 align-items-end">
            <div class="flex-grow-1">
                <label class="erp-label">ประเภท</label>
                <select name="type" class="erp-select">
                    <option value="">ทั้งหมด</option>
                    <option value="borrow" {{ request('type') === 'borrow' ? 'selected' : '' }}>ใบยืม-คืน</option>
                    <option value="consume" {{ request('type') === 'consume' ? 'selected' : '' }}>ใบเบิก</option>
                </select>
            </div>
            <button type="submit" class="erp-btn-primary">
                <i class="fas fa-search me-1"></i>ค้นหา
            </button>
            <a href="{{ route('manager.approval.index') }}" class="erp-btn-secondary">
                <i class="fas fa-redo me-1"></i>รีเซ็ต
            </a>
        </form>
    </div>
</div>

{{-- Pending Items Table --}}
<div class="erp-card mt-3">
    <div class="erp-table-wrap">
        <table class="erp-table">
            <thead>
                <tr>
                    <th width="80">เลขที่</th>
                    <th width="100">วันที่</th>
                    <th>พนักงาน</th>
                    <th width="100">ประเภท</th>
                    <th width="80" style="text-align: center;">จำนวน</th>
                    <th width="150" style="text-align: center;">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendingItems as $item)
                    <tr>
                        <td>
                            <strong style="color: var(--text-primary);">#{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</strong>
                        </td>
                        <td style="color: var(--text-secondary);">
                            {{ Carbon\Carbon::parse($item->req_date)->format('d/m/Y') }}
                        </td>
                        <td>
                            <div style="color: var(--text-primary);">
                                {{ $item->employee->firstname }} {{ $item->employee->lastname }}
                            </div>
                            <small style="color: var(--text-muted);">
                                {{ $item->employee->department->name ?? '-' }}
                            </small>
                        </td>
                        <td>
                            @if($item->req_type === 'borrow')
                                <span class="type-badge borrow">
                                    <i class="fas fa-hand-holding"></i>ยืม-คืน
                                </span>
                            @else
                                <span class="type-badge consume">
                                    <i class="fas fa-box-open"></i>เบิก
                                </span>
                            @endif
                        </td>
                        <td style="text-align: center; color: var(--text-secondary);">
                            {{ $item->items->count() }} รายการ
                        </td>
                        <td style="text-align: center;">
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="{{ route('manager.approval.show', $item->id) }}"
                                   class="erp-btn-primary" style="padding: 4px 12px; font-size: 12px;">
                                    <i class="fas fa-eye me-1"></i>ดูรายละเอียด
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-muted);">
                            <i class="fas fa-check-circle" style="font-size: 48px; opacity: 0.3; margin-bottom: 16px; display: block;"></i>
                            ไม่มีรายการที่รอการอนุมัติ
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($pendingItems->hasPages())
        <div class="mt-3">
            {{ $pendingItems->links() }}
        </div>
    @endif
</div>
@endsection
