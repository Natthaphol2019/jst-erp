@extends('layouts.app')
@section('title', 'รายชื่อพนักงาน')

@section('content')
<style>
@media print {
    .no-print, .no-print * { display: none !important; }
    .sidebar, .navbar, .btn, .alert { display: none !important; }
    .content { padding: 0 !important; margin: 0 !important; }
    .erp-card { border: 1px solid #dee2e6 !important; box-shadow: none !important; margin-bottom: 1rem !important; }
    table { font-size: 10pt !important; }
    th, td { border: 1px solid #dee2e6 !important; }
    body { background-color: #fff !important; }
    .container-fluid { width: 100% !important; max-width: 100% !important; }
    @page { margin: 1.5cm; }
}
.print-header { display: none; }
@media print {
    .print-header { display: block !important; text-align: center; margin-bottom: 20px; }
    .print-header h2 { margin: 0; font-size: 18pt; }
    .print-header p { margin: 5px 0 0; font-size: 10pt; color: var(--text-secondary); }
}
</style>

<div class="print-header">
    <h2>รายชื่อพนักงาน</h2>
    <p>พิมพ์เมื่อ {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
</div>

<div class="container-fluid">
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4 no-print">
        <div>
            <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
                <i class="fas fa-users me-2" style="color: #818cf8;"></i>รายชื่อพนักงาน
            </h4>
            <p style="font-size: 13px; color: var(--text-muted); margin: 0;">จัดการข้อมูล เพิ่ม ลบ แก้ไข พนักงานทั้งหมดในระบบ</p>
        </div>
        <div class="d-flex gap-2 d-print-none">
            <button onclick="window.print()" class="erp-btn-secondary">
                <i class="fas fa-print me-2"></i>พิมพ์
            </button>
            <a href="{{ route('exports.employees') }}" class="erp-btn-primary" style="background: rgba(52,211,153,0.12); color: #34d399; border: 1px solid rgba(52,211,153,0.2);">
                <i class="fas fa-file-excel me-2"></i>Export Excel
            </a>
            <a href="{{ route('hr.employees.create') }}" class="erp-btn-primary">
                <i class="fas fa-plus me-2"></i>เพิ่มพนักงานใหม่
            </a>
        </div>
    </div>
    <h2 class="d-print-block" style="display:none;">รายชื่อพนักงาน</h2>

    @if(session('success'))
        <div class="erp-alert erp-alert-success mb-4 no-print">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    {{-- Search Form --}}
    <div class="erp-card mb-4 no-print">
        <div class="erp-card-body">
            <form action="{{ route('hr.employees.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="erp-input" placeholder="ค้นหารหัสพนักงาน, ชื่อ, นามสกุล..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="department_id" class="erp-select">
                        <option value="">-- ทุกแผนก --</option>
                        @isset($departments)
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>
                                    {{ $dept->name }}
                                </option>
                            @endforeach
                        @endisset
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="erp-btn-primary w-100">ค้นหา</button>
                </div>
                @if(request('search') || request('department_id'))
                <div class="col-md-2">
                    <a href="{{ route('hr.employees.index') }}" class="erp-btn-secondary" style="background: rgba(239,68,68,0.12); color: #f87171; border: 1px solid rgba(239,68,68,0.2);">
                        <i class="fas fa-times me-1"></i>ล้างตัวกรอง
                    </a>
                </div>
                @endif
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="erp-card rounded-3 mb-5">
        <div class="erp-table-wrap">
            <table class="erp-table">
                <thead>
                    <tr>
                        <th class="text-start" style="width: 12%;">รหัสพนักงาน</th>
                        <th class="text-start" style="width: 25%;">ชื่อ-นามสกุล</th>
                        <th style="width: 15%;">แผนก</th>
                        <th style="width: 15%;">ตำแหน่ง</th>
                        <th style="width: 15%;">บัญชีผู้ใช้ (Login)</th>
                        <th style="width: 10%;">สถานะ</th>
                        <th class="no-print" style="width: 18%;">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $emp)
                    <tr>
                        <td class="text-start fw-semibold" style="color: #818cf8;">{{ $emp->employee_code }}</td>
                        <td class="text-start" style="color: var(--text-primary);">
                            {{ $emp->prefix }}{{ $emp->firstname }} {{ $emp->lastname }}
                        </td>
                        <td>
                            <span class="erp-badge" style="background: rgba(56,189,248,0.12); color: #38bdf8;">
                                {{ $emp->department->name ?? 'ไม่มีแผนก' }}
                            </span>
                        </td>
                        <td style="color: var(--text-secondary);">{{ $emp->position->name ?? '-' }}</td>

                        <td>
                            @if($emp->user)
                                <span class="erp-badge" style="background: rgba(255,255,255,0.05); color: var(--text-secondary);">
                                    <i class="fas fa-user me-1"></i>{{ $emp->user->username }}
                                </span>
                            @else
                                <span class="small" style="color: #f87171;">ไม่มีบัญชี</span>
                            @endif
                        </td>

                        <td>
                            @if($emp->status == 'active')
                                <span class="erp-badge" style="background: rgba(52,211,153,0.12); color: #34d399;">
                                    <i class="fas fa-check me-1"></i>ทำงานอยู่
                                </span>
                            @elseif($emp->status == 'inactive')
                                <span class="erp-badge" style="background: rgba(251,191,36,0.12); color: #fbbf24;">
                                    <i class="fas fa-pause me-1"></i>พักงาน
                                </span>
                            @else
                                <span class="erp-badge" style="background: rgba(239,68,68,0.12); color: #f87171;">
                                    <i class="fas fa-times me-1"></i>ลาออก
                                </span>
                            @endif
                        </td>
                        <td class="no-print">
                            <div class="d-flex gap-2">
                                <a href="{{ route('hr.employees.edit', $emp->id) }}" class="erp-btn-secondary" style="background: rgba(251,191,36,0.12); color: #fbbf24; border: 1px solid rgba(251,191,36,0.2);">
                                    <i class="fas fa-edit me-1"></i>แก้ไข
                                </a>
                                @if($emp->user && $emp->user->role === 'admin')
                                    <span class="erp-btn-secondary" style="opacity: 0.4; cursor: not-allowed; padding: 4px 10px; font-size: 12px;" title="HR ไม่สามารถลบ Admin ได้">
                                        <i class="fas fa-shield-alt me-1"></i>ลบไม่ได้
                                    </span>
                                @else
                                    <form action="{{ route('hr.employees.destroy', $emp->id) }}" method="POST" onsubmit="return confirm('ยืนยันการลบพนักงานคนนี้หรือไม่?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="erp-btn-danger">
                                            <i class="fas fa-trash me-1"></i>ลบ
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="erp-empty">
                                <i class="fas fa-inbox"></i>
                                <div>ไม่พบข้อมูลพนักงานในระบบ</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($employees->hasPages())
            <div style="padding: 16px; border-top: 1px solid var(--border);">
                <div class="d-flex justify-content-between align-items-center">
                    <div style="font-size: 13px; color: var(--text-secondary);">
                        แสดง <strong style="color: var(--text-primary);">{{ $employees->firstItem() }}</strong> ถึง <strong style="color: var(--text-primary);">{{ $employees->lastItem() }}</strong> จาก <strong style="color: var(--text-primary);">{{ $employees->total() }}</strong> รายการ
                    </div>
                    {{ $employees->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
