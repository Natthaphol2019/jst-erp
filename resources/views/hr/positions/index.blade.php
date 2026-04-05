@extends('layouts.app')
@section('title', 'จัดการตำแหน่งงาน')

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
                <i class="fas fa-briefcase me-2" style="color: #818cf8;"></i>จัดการตำแหน่งงาน
            </h4>
            <p style="font-size: 13px; color: var(--text-muted); margin: 0;">จัดการตำแหน่งงานทั้งหมดในระบบ</p>
        </div>
        <a href="{{ route('hr.positions.create') }}" class="erp-btn-primary">
            <i class="fas fa-plus me-2"></i>เพิ่มตำแหน่งใหม่
        </a>
    </div>

    @if(session('success'))
        <div class="erp-alert erp-alert-success mb-4">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="erp-alert erp-alert-danger mb-4">
            <i class="fas fa-times-circle me-2"></i>{{ session('error') }}
        </div>
    @endif

    <div class="erp-card rounded-3">
        <div class="erp-table-wrap">
            <table class="erp-table">
                <thead>
                    <tr>
                        <th class="text-start" style="width: 25%;">ชื่อตำแหน่ง</th>
                        <th style="width: 20%;">สังกัดแผนก</th>
                        <th style="width: 30%;">หน้าที่รับผิดชอบ</th>
                        <th style="width: 10%; text-align: center;">จำนวนพนักงาน</th>
                        <th style="width: 15%; text-align: center;">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($positions as $pos)
                    <tr>
                        <td class="text-start" style="color: #818cf8; font-weight: 600;">{{ $pos->name }}</td>
                        <td>
                            <span class="erp-badge" style="background: rgba(56,189,248,0.12); color: #38bdf8;">
                                {{ $pos->department->name ?? 'ไม่ระบุ' }}
                            </span>
                        </td>
                        <td style="color: var(--text-muted);">{{ Str::limit($pos->job_description, 50, '...') }}</td>
                        <td class="text-center">
                            @if($pos->employees_count > 0)
                                <span class="erp-badge" style="background: rgba(52,211,153,0.12); color: #34d399;">
                                    {{ $pos->employees_count }} คน
                                </span>
                            @else
                                <span class="erp-badge" style="background: rgba(255,255,255,0.05); color: var(--text-muted);">
                                    {{ $pos->employees_count }} คน
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="{{ route('hr.positions.edit', $pos->id) }}" class="erp-btn-secondary" style="background: rgba(251,191,36,0.12); color: #fbbf24; border: 1px solid rgba(251,191,36,0.2);">
                                    <i class="fas fa-edit me-1"></i>แก้ไข
                                </a>
                                <form action="{{ route('hr.positions.destroy', $pos->id) }}" method="POST" onsubmit="return confirm('ยืนยันการลบตำแหน่ง {{ $pos->name }} ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="erp-btn-danger">
                                        <i class="fas fa-trash me-1"></i>ลบ
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="erp-empty">
                                <i class="fas fa-inbox"></i>
                                <div>ไม่พบข้อมูลตำแหน่งงาน</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($positions->hasPages())
            <div style="padding: 16px; border-top: 1px solid var(--border);">
                <div class="d-flex justify-content-between align-items-center">
                    <div style="font-size: 13px; color: var(--text-secondary);">
                        แสดง <strong style="color: var(--text-primary);">{{ $positions->firstItem() }}</strong> ถึง <strong style="color: var(--text-primary);">{{ $positions->lastItem() }}</strong> จาก <strong style="color: var(--text-primary);">{{ $positions->total() }}</strong> รายการ
                    </div>
                    {{ $positions->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
