@extends('layouts.app')

@section('title', 'รายชื่อพนักงาน')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">รายชื่อพนักงาน</h2>
        <a href="{{ route('hr.employees.create') }}" class="btn btn-primary shadow-sm">+ เพิ่มพนักงานใหม่</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4">รหัสพนักงาน</th>
                            <th>ชื่อ-นามสกุล</th>
                            <th>แผนก</th>
                            <th>ตำแหน่ง</th>
                            <th class="text-center">สถานะ</th>
                            <th class="text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $emp)
                        <tr>
                            <td class="ps-4 fw-bold text-primary">{{ $emp->employee_code }}</td>
                            <td>{{ $emp->prefix }}{{ $emp->firstname }} {{ $emp->lastname }}</td>
                            <td>
                                <span class="badge bg-info text-dark">
                                    {{ $emp->department->name ?? 'ไม่มีแผนก' }}
                                </span>
                            </td>
                            <td>{{ $emp->position->name ?? '-' }}</td>
                            
                            <td class="text-center">
                                @if($emp->status == 'active')
                                    <span class="badge bg-success rounded-pill">ทำงานอยู่</span>
                                @elseif($emp->status == 'inactive')
                                    <span class="badge bg-secondary rounded-pill">พักงาน</span>
                                @else
                                    <span class="badge bg-danger rounded-pill">ลาออก</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('hr.employees.edit', $emp->id) }}" class="btn btn-sm btn-outline-warning">แก้ไข</a>
                                <form action="{{ route('hr.employees.destroy', $emp->id) }}" method="POST" class="d-inline" onsubmit="return confirm('ยืนยันการลบ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">ลบ</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">ไม่พบข้อมูลพนักงานในระบบ</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($employees->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                {{ $employees->links() }}
            </div>
        @endif
    </div>
</div>
@endsection