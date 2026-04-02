@extends('layouts.app')
@section('title', 'รายชื่อพนักงาน')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold m-0 text-primary">👥 รายชื่อพนักงาน</h2>
            <small class="text-muted">จัดการข้อมูล เพิ่ม ลบ แก้ไข พนักงานทั้งหมดในระบบ</small>
        </div>
        <a href="{{ route('hr.employees.create') }}" class="btn btn-primary shadow-sm rounded-pill px-4 fw-bold">
            <i class="bi bi-person-plus-fill me-1"></i> + เพิ่มพนักงานใหม่
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0 mb-4 bg-white">
        <div class="card-body p-3">
            <form action="{{ route('hr.employees.index') }}" method="GET" class="row g-2">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="🔍 ค้นหารหัสพนักงาน, ชื่อ, นามสกุล..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="department_id" class="form-select">
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
                    <button type="submit" class="btn btn-dark w-100 fw-bold">ค้นหา</button>
                </div>
                @if(request('search') || request('department_id'))
                <div class="col-md-2">
                    <a href="{{ route('hr.employees.index') }}" class="btn btn-outline-danger w-100">ล้างตัวกรอง</a>
                </div>
                @endif
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-3 mb-5">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center">
                    <thead class="table-dark align-middle">
                        <tr>
                            <th class="ps-4 text-start py-3">รหัสพนักงาน</th>
                            <th class="text-start">ชื่อ-นามสกุล</th>
                            <th>แผนก</th>
                            <th>ตำแหน่ง</th>
                            <th>บัญชีผู้ใช้ (Login)</th> <th>สถานะ</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @forelse($employees as $emp)
                        <tr>
                            <td class="ps-4 fw-bold text-primary text-start">{{ $emp->employee_code }}</td>
                            <td class="text-start fw-bold text-dark">
                                {{ $emp->prefix }}{{ $emp->firstname }} {{ $emp->lastname }}
                            </td>
                            <td><span class="badge bg-info text-dark border">{{ $emp->department->name ?? 'ไม่มีแผนก' }}</span></td>
                            <td>{{ $emp->position->name ?? '-' }}</td>
                            
                            <td>
                                @if($emp->user)
                                    <span class="badge bg-dark px-3 py-2"><i class="bi bi-person-badge me-1"></i> {{ $emp->user->username }}</span>
                                @else
                                    <span class="text-danger small">ไม่มีบัญชี</span>
                                @endif
                            </td>
                            
                            <td>
                                @if($emp->status == 'active')
                                    <span class="badge bg-success rounded-pill px-3">ทำงานอยู่</span>
                                @elseif($emp->status == 'inactive')
                                    <span class="badge bg-warning text-dark rounded-pill px-3">พักงาน</span>
                                @else
                                    <span class="badge bg-danger rounded-pill px-3">ลาออก</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group shadow-sm">
                                    <a href="{{ route('hr.employees.edit', $emp->id) }}" class="btn btn-sm btn-outline-warning text-dark fw-bold">✏️ แก้ไข</a>
                                    <form action="{{ route('hr.employees.destroy', $emp->id) }}" method="POST" class="d-inline" onsubmit="return confirm('ยืนยันการลบพนักงานคนนี้หรือไม่?')">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger fw-bold">🗑️ ลบ</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <h5>📭 ไม่พบข้อมูลพนักงานในระบบ</h5>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($employees->hasPages())
            <div class="card-footer bg-white border-0 py-3 d-flex justify-content-center">
                {{ $employees->links() }}
            </div>
        @endif
    </div>
</div>
@endsection