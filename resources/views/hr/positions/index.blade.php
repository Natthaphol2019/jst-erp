@extends('layouts.app')
@section('title', 'จัดการตำแหน่งงาน')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">จัดการตำแหน่งงาน (Positions)</h2>
        <a href="{{ route('hr.positions.create') }}" class="btn btn-primary shadow-sm">+ เพิ่มตำแหน่งใหม่</a>
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
                            <th class="ps-4" width="25%">ชื่อตำแหน่ง</th>
                            <th width="20%">สังกัดแผนก</th>
                            <th width="30%">หน้าที่รับผิดชอบ</th>
                            <th class="text-center" width="10%">จำนวนพนักงาน</th>
                            <th class="text-center" width="15%">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($positions as $pos)
                        <tr>
                            <td class="ps-4 fw-bold text-primary">{{ $pos->name }}</td>
                            <td>
                                <span class="badge bg-info text-dark">{{ $pos->department->name ?? 'ไม่ระบุ' }}</span>
                            </td>
                            <td class="text-muted">{{ Str::limit($pos->job_description, 50, '...') }}</td>
                            <td class="text-center">
                                <span class="badge {{ $pos->employees_count > 0 ? 'bg-success' : 'bg-secondary' }} rounded-pill px-3">
                                    {{ $pos->employees_count }} คน
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('hr.positions.edit', $pos->id) }}" class="btn btn-sm btn-outline-warning">แก้ไข</a>
                                <form action="{{ route('hr.positions.destroy', $pos->id) }}" method="POST" class="d-inline" onsubmit="return confirm('ยืนยันการลบตำแหน่ง {{ $pos->name }} ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">ลบ</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">ไม่พบข้อมูลตำแหน่งงาน</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($positions->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                {{ $positions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection