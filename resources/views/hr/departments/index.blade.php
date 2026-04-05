@extends('layouts.app')

@section('title', 'จัดการแผนก')

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
                <i class="fas fa-sitemap me-2" style="color: #818cf8;"></i>จัดการแผนก
            </h4>
            <p style="font-size: 13px; color: var(--text-muted); margin: 0;">จัดการข้อมูลแผนกทั้งหมดในระบบ</p>
        </div>
        <a href="{{ route('hr.departments.create') }}" class="erp-btn-primary">
            <i class="fas fa-plus me-2"></i>เพิ่มแผนกใหม่
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
                        <th style="width: 8%;">ID</th>
                        <th style="width: 25%;">ชื่อแผนก</th>
                        <th style="width: 30%;">รายละเอียด</th>
                        <th style="width: 17%; text-align: center;">ตำแหน่งในแผนก</th>
                        <th style="width: 20%; text-align: center;">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($departments as $dept)
                    <tr>
                        <td style="color: var(--text-muted);">{{ $dept->id }}</td>
                        <td style="color: #818cf8; font-weight: 600; font-size: 15px;">{{ $dept->name }}</td>
                        <td style="color: var(--text-muted);">{{ Str::limit($dept->description, 50, '...') }}</td>

                        <td class="text-center">
                            <button type="button" class="erp-btn-secondary" style="background: rgba(56,189,248,0.12); color: #38bdf8; border: 1px solid rgba(56,189,248,0.2);" data-bs-toggle="modal" data-bs-target="#positionModal{{ $dept->id }}">
                                <i class="fas fa-eye me-1"></i>{{ $dept->positions_count }} ตำแหน่ง
                            </button>
                        </td>

                        <td class="text-center">
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="{{ route('hr.departments.edit', $dept->id) }}" class="erp-btn-secondary" style="background: rgba(251,191,36,0.12); color: #fbbf24; border: 1px solid rgba(251,191,36,0.2);">
                                    <i class="fas fa-edit me-1"></i>แก้ไข
                                </a>
                                <form action="{{ route('hr.departments.destroy', $dept->id) }}" method="POST" onsubmit="return confirm('ยืนยันการลบแผนก {{ $dept->name }} ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="erp-btn-danger">
                                        <i class="fas fa-trash me-1"></i>ลบ
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    {{-- Position Modal --}}
                    <div class="modal fade" id="positionModal{{ $dept->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content" style="background: var(--bg-raised); border: 1px solid var(--border);">
                                <div class="modal-header" style="background: var(--bg-surface); border-bottom: 1px solid var(--border);">
                                    <h5 class="modal-title" style="font-weight: 600; color: var(--text-primary);">
                                        <i class="fas fa-briefcase me-2" style="color: #818cf8;"></i>ตำแหน่ง: {{ $dept->name }}
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-0">
                                    @if($dept->positions->count() > 0)
                                        <ul class="list-group list-group-flush">
                                            @foreach($dept->positions as $pos)
                                                <li class="list-group-item d-flex justify-content-between align-items-start px-4 py-3" style="background: var(--bg-raised); border-color: var(--border);">
                                                    <div class="ms-2 me-auto">
                                                        <div class="fw-bold" style="color: var(--text-primary);">{{ $pos->name }}</div>
                                                        <span style="color: var(--text-secondary); font-size: 0.85rem;">หน้าที่: {{ $pos->job_description ?? '-' }}</span>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <div class="text-center py-5">
                                            <div style="font-size: 2.5rem; color: var(--text-muted); margin-bottom: 8px;"><i class="fas fa-inbox"></i></div>
                                            <p style="color: var(--text-muted);">ยังไม่มีตำแหน่งในแผนกนี้</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="modal-footer" style="background: var(--bg-surface); border-top: 1px solid var(--border);">
                                    <button type="button" class="erp-btn-secondary" data-bs-dismiss="modal">
                                        <i class="fas fa-times me-1"></i>ปิดหน้าต่าง
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="erp-empty">
                                <i class="fas fa-inbox"></i>
                                <div>ไม่พบข้อมูลแผนก</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($departments->hasPages())
            <div style="padding: 16px; border-top: 1px solid var(--border);">
                <div class="d-flex justify-content-between align-items-center">
                    <div style="font-size: 13px; color: var(--text-secondary);">
                        แสดง <strong style="color: var(--text-primary);">{{ $departments->firstItem() }}</strong> ถึง <strong style="color: var(--text-primary);">{{ $departments->lastItem() }}</strong> จาก <strong style="color: var(--text-primary);">{{ $departments->total() }}</strong> รายการ
                    </div>
                    {{ $departments->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
