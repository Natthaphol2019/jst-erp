@extends('layouts.app')

@section('title', 'จัดการแผนก')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">จัดการแผนก (Departments)</h2>
        <a href="{{ route('hr.departments.create') }}" class="btn btn-primary shadow-sm">+ เพิ่มแผนกใหม่</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4" width="10%">ID</th>
                            <th width="30%">ชื่อแผนก</th>
                            <th width="25%">รายละเอียด</th>
                            <th class="text-center" width="20%">ตำแหน่งในแผนก</th>
                            <th class="text-center" width="15%">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($departments as $dept)
                        <tr>
                            <td class="ps-4 text-muted">{{ $dept->id }}</td>
                            <td class="fw-bold text-primary fs-5">{{ $dept->name }}</td>
                            <td class="text-muted">{{ Str::limit($dept->description, 50, '...') }}</td>
                            
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-outline-info rounded-pill px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#positionModal{{ $dept->id }}">
                                    👁️ {{ $dept->positions_count }} ตำแหน่ง
                                </button>
                            </td>
                            
                            <td class="text-center">
                                <a href="{{ route('hr.departments.edit', $dept->id) }}" class="btn btn-sm btn-outline-warning">แก้ไข</a>
                                <form action="{{ route('hr.departments.destroy', $dept->id) }}" method="POST" class="d-inline" onsubmit="return confirm('ยืนยันการลบแผนก {{ $dept->name }} ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">ลบ</button>
                                </form>
                            </td>
                        </tr>

                        <div class="modal fade" id="positionModal{{ $dept->id }}" tabindex="-1" aria-labelledby="positionModalLabel{{ $dept->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-header bg-light">
                                        <h5 class="modal-title fw-bold" id="positionModalLabel{{ $dept->id }}">
                                            รายชื่อตำแหน่ง: {{ $dept->name }}
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-0">
                                        @if($dept->positions->count() > 0)
                                            <ul class="list-group list-group-flush">
                                                @foreach($dept->positions as $pos)
                                                    <li class="list-group-item d-flex justify-content-between align-items-start px-4 py-3">
                                                        <div class="ms-2 me-auto">
                                                            <div class="fw-bold text-dark fs-6">{{ $pos->name }}</div>
                                                            <span class="text-muted" style="font-size: 0.85rem;">หน้าที่: {{ $pos->job_description ?? '-' }}</span>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <div class="text-center py-5 text-muted">
                                                <div class="fs-1 mb-2">📭</div>
                                                <p>ยังไม่มีตำแหน่งในแผนกนี้</p>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="modal-footer border-0 bg-light">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิดหน้าต่าง</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">ไม่พบข้อมูลแผนก</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($departments->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                {{ $departments->links() }}
            </div>
        @endif
    </div>
</div>
@endsection