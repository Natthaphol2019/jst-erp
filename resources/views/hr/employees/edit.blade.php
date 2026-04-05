@extends('layouts.app')
@section('title', 'แก้ไขข้อมูลพนักงาน')

@section('content')
    <div class="container-fluid">
        {{-- Page Header --}}
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
                    <i class="fas fa-user-edit me-2" style="color: #818cf8;"></i>แก้ไขข้อมูล: {{ $employee->employee_code }}
                </h4>
                <p style="font-size: 13px; color: var(--text-muted); margin: 0;">แก้ไขข้อมูลพนักงานในระบบ</p>
            </div>
            <a href="{{ route('hr.employees.index') }}" class="erp-btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>ย้อนกลับ
            </a>
        </div>

        @if ($errors->any())
            <div class="erp-alert erp-alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="erp-card">
            <div class="erp-card-body">
                {{-- Success Message --}}
                @if(session('success'))
                    <div class="erp-alert erp-alert-success">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Image Upload Section --}}
                @include('components.image-upload', [
                    'entity' => $employee,
                    'type' => 'employee',
                    'route' => route('uploads.employee', $employee->id)
                ])

                <form action="{{ route('hr.employees.update', $employee->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <h5 class="mb-3" style="font-size: 14px; font-weight: 600; color: #818cf8; border-bottom: 1px solid var(--border); padding-bottom: 8px;">
                        <i class="fas fa-briefcase me-2"></i>ข้อมูลการทำงาน
                    </h5>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="erp-label">รหัสพนักงาน <span style="color: var(--text-muted);">(ไม่สามารถแก้ไขได้)</span></label>
                            <input type="text" name="employee_code" class="erp-input" style="color: #818cf8; font-weight: 600; background: var(--input-bg);"
                                value="{{ $employee->employee_code }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="erp-label">แผนก <span style="color: #f87171;">*</span></label>
                            <select name="department_id" id="department_id" class="erp-select" required>
                                @foreach ($departments as $dept)
                                    <option value="{{ $dept->id }}"
                                        {{ $employee->department_id == $dept->id ? 'selected' : '' }}>
                                        {{ $dept->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="erp-label">ตำแหน่ง <span style="color: #f87171;">*</span></label>
                            <select name="position_id" id="position_id" class="erp-select" required>
                                @foreach ($positions as $pos)
                                    <option value="{{ $pos->id }}" data-department="{{ $pos->department_id }}"
                                        {{ $employee->position_id == $pos->id ? 'selected' : '' }}
                                        style="{{ $employee->department_id == $pos->department_id ? 'display:block;' : 'display:none;' }}">
                                        {{ $pos->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <h5 class="mb-3 mt-4" style="font-size: 14px; font-weight: 600; color: #818cf8; border-bottom: 1px solid var(--border); padding-bottom: 8px;">
                        <i class="fas fa-user me-2"></i>ข้อมูลส่วนตัว
                    </h5>
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label class="erp-label">คำนำหน้า</label>
                            <select name="prefix" class="erp-select">
                                <option value="นาย" {{ $employee->prefix == 'นาย' ? 'selected' : '' }}>นาย</option>
                                <option value="นาง" {{ $employee->prefix == 'นาง' ? 'selected' : '' }}>นาง</option>
                                <option value="นางสาว" {{ $employee->prefix == 'นางสาว' ? 'selected' : '' }}>นางสาว
                                </option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label class="erp-label">ชื่อ <span style="color: #f87171;">*</span></label>
                            <input type="text" name="firstname" class="erp-input" value="{{ $employee->firstname }}"
                                required>
                        </div>
                        <div class="col-md-5">
                            <label class="erp-label">นามสกุล <span style="color: #f87171;">*</span></label>
                            <input type="text" name="lastname" class="erp-input" value="{{ $employee->lastname }}"
                                required>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="erp-label">วันที่เริ่มงาน</label>
                            <input type="date" name="start_date" class="erp-input"
                                value="{{ $employee->start_date }}">
                        </div>
                        <div class="col-md-4">
                            <label class="erp-label">เพศ</label>
                            <select name="gender" class="erp-select">
                                <option value="male" {{ $employee->gender == 'male' ? 'selected' : '' }}>ชาย</option>
                                <option value="female" {{ $employee->gender == 'female' ? 'selected' : '' }}>หญิง</option>
                                <option value="other" {{ $employee->gender == 'other' ? 'selected' : '' }}>อื่นๆ</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="erp-label">สถานะ</label>
                            <select name="status" class="erp-select">
                                <option value="active" {{ $employee->status == 'active' ? 'selected' : '' }}>ทำงานอยู่
                                </option>
                                <option value="inactive" {{ $employee->status == 'inactive' ? 'selected' : '' }}>พักงาน
                                </option>
                                <option value="resigned" {{ $employee->status == 'resigned' ? 'selected' : '' }}>ลาออก
                                </option>
                            </select>
                        </div>
                    </div>

                    <h5 class="mb-3 mt-4" style="font-size: 14px; font-weight: 600; color: #fbbf24; border-bottom: 1px solid rgba(251,191,36,0.2); padding-bottom: 8px;">
                        <i class="fas fa-lock me-2"></i>ข้อมูลเข้าระบบ & เปลี่ยนรหัสผ่าน
                        @if($employee->user && $employee->user->role === 'admin')
                            <span class="erp-badge" style="background: rgba(239,68,68,0.12); color: #f87171; margin-left: 8px;">
                                <i class="fas fa-shield-alt me-1"></i>Admin (ไม่สามารถแก้ไขได้)
                            </span>
                        @endif
                    </h5>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="erp-label">ชื่อผู้ใช้งาน (Username)</label>
                            <input type="text" class="erp-input" style="color: var(--text-muted); background: var(--input-bg);"
                                value="{{ $employee->user ? $employee->user->username : 'ไม่มีบัญชี' }}" readonly>
                            <small style="color: #f87171;"><i class="fas fa-lock"></i> ไม่สามารถแก้ไขได้</small>
                        </div>
                        <div class="col-md-4">
                            <label class="erp-label" style="color: #f87171; font-weight: 600;">ตั้งรหัสผ่านใหม่</label>
                            @if($employee->user && $employee->user->role === 'admin')
                                <input type="text" class="erp-input" style="opacity: 0.5; cursor: not-allowed; background: var(--input-bg);"
                                    placeholder="🔒 Admin เท่านั้น" disabled>
                                <small style="color: var(--text-muted);"><i class="fas fa-shield-alt"></i> HR ไม่สามารถเปลี่ยนรหัสผ่าน Admin ได้</small>
                            @else
                                <input type="text" name="password" class="erp-input" style="border-color: rgba(248,113,113,0.3);"
                                    placeholder="พิมพ์รหัสผ่านใหม่ที่นี่...">
                                <small style="color: var(--text-muted);">หากไม่เปลี่ยน <strong>ให้ปล่อยว่างไว้</strong></small>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <label class="erp-label">สิทธิ์การใช้งานระบบ (Role) <span style="color: #f87171;">*</span></label>
                            @php
                                $currentRole = $employee->user ? $employee->user->role : 'employee';
                            @endphp
                            @if($employee->user && $employee->user->role === 'admin')
                                <select class="erp-select" disabled style="opacity: 0.6; cursor: not-allowed;">
                                    <option value="admin" selected>ผู้ดูแลระบบ (Admin) 🔒</option>
                                </select>
                                <small style="color: var(--text-muted);"><i class="fas fa-info-circle"></i> HR สามารถดูได้อย่างเดียว</small>
                            @else
                                <select name="role" class="erp-select" required>
                                    <option value="employee" {{ $currentRole == 'employee' ? 'selected' : '' }}>พนักงานทั่วไป (Employee)</option>
                                    <option value="hr" {{ $currentRole == 'hr' ? 'selected' : '' }}>ฝ่ายบุคคล (HR)</option>
                                    <option value="manager" {{ $currentRole == 'manager' ? 'selected' : '' }}>ผู้จัดการ (Manager)</option>
                                    <option value="inventory" {{ $currentRole == 'inventory' ? 'selected' : '' }}>ฝ่ายคลังสินค้า (Inventory)</option>
                                    <option value="admin" {{ $currentRole == 'admin' ? 'selected' : '' }}>ผู้ดูแลระบบ (Admin)</option>
                                </select>
                            @endif
                        </div>
                    </div>

                    <hr style="border-color: var(--border);">
                    <div class="d-flex gap-2 justify-content-end mt-4">
                        <button type="submit" class="erp-btn-primary" style="background: rgba(251,191,36,0.12); color: #fbbf24; border: 1px solid rgba(251,191,36,0.2);">
                            <i class="fas fa-save me-2"></i>อัปเดตข้อมูล
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deptSelect = document.getElementById('department_id');
            const posSelect = document.getElementById('position_id');

            function filterPositions() {
                let deptId = deptSelect.value;
                let options = posSelect.querySelectorAll('option');

                if (deptId === "") {
                    posSelect.disabled = true;
                    posSelect.value = "";
                    return;
                }

                posSelect.disabled = false;
                let hasValidOption = false;

                options.forEach(option => {
                    if (option.value === "") return;

                    if (option.getAttribute('data-department') === deptId) {
                        option.hidden = false;
                        option.disabled = false;
                        hasValidOption = true;
                    } else {
                        option.hidden = true;
                        option.disabled = true;
                    }
                });

                // เลื่อนไปเลือกตัวเลือกแรกที่แสดงอยู่ ถ้าช่องเดิมมันถูกซ่อนไปแล้ว
                if (posSelect.selectedOptions[0]?.hidden) {
                    posSelect.value = "";
                }
            }

            deptSelect.addEventListener('change', filterPositions);

            // รันครั้งแรกตอนโหลดหน้า เพื่อให้หน้า Edit โชว์ข้อมูลให้ถูกต้อง
            filterPositions();
        });
    </script>
@endsection
