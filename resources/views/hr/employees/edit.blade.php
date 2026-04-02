@extends('layouts.app')
@section('title', 'แก้ไขข้อมูลพนักงาน')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>✏️ แก้ไขข้อมูล: {{ $employee->employee_code }}</h2>
            <a href="{{ route('hr.employees.index') }}" class="btn btn-secondary">ย้อนกลับ</a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ route('hr.employees.update', $employee->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <h5 class="text-primary border-bottom pb-2 mb-3">ข้อมูลการทำงาน</h5>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">รหัสพนักงาน <span
                                    class="text-muted">(ไม่สามารถแก้ไขได้)</span></label>
                            <input type="text" name="employee_code" class="form-control bg-light text-primary fw-bold"
                                value="{{ $employee->employee_code }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">แผนก <span class="text-danger">*</span></label>
                            <select name="department_id" id="department_id" class="form-select" required>
                                @foreach ($departments as $dept)
                                    <option value="{{ $dept->id }}"
                                        {{ $employee->department_id == $dept->id ? 'selected' : '' }}>
                                        {{ $dept->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">ตำแหน่ง <span class="text-danger">*</span></label>
                            <select name="position_id" id="position_id" class="form-select" required>
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

                    <h5 class="text-primary border-bottom pb-2 mb-3 mt-4">ข้อมูลส่วนตัว</h5>
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label class="form-label">คำนำหน้า</label>
                            <select name="prefix" class="form-select">
                                <option value="นาย" {{ $employee->prefix == 'นาย' ? 'selected' : '' }}>นาย</option>
                                <option value="นาง" {{ $employee->prefix == 'นาง' ? 'selected' : '' }}>นาง</option>
                                <option value="นางสาว" {{ $employee->prefix == 'นางสาว' ? 'selected' : '' }}>นางสาว
                                </option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">ชื่อ <span class="text-danger">*</span></label>
                            <input type="text" name="firstname" class="form-control" value="{{ $employee->firstname }}"
                                required>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">นามสกุล <span class="text-danger">*</span></label>
                            <input type="text" name="lastname" class="form-control" value="{{ $employee->lastname }}"
                                required>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label">วันที่เริ่มงาน</label>
                            <input type="date" name="start_date" class="form-control"
                                value="{{ $employee->start_date }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">เพศ</label>
                            <select name="gender" class="form-select">
                                <option value="male" {{ $employee->gender == 'male' ? 'selected' : '' }}>ชาย</option>
                                <option value="female" {{ $employee->gender == 'female' ? 'selected' : '' }}>หญิง</option>
                                <option value="other" {{ $employee->gender == 'other' ? 'selected' : '' }}>อื่นๆ</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">สถานะ</label>
                            <select name="status" class="form-select">
                                <option value="active" {{ $employee->status == 'active' ? 'selected' : '' }}>ทำงานอยู่
                                </option>
                                <option value="inactive" {{ $employee->status == 'inactive' ? 'selected' : '' }}>พักงาน
                                </option>
                                <option value="resigned" {{ $employee->status == 'resigned' ? 'selected' : '' }}>ลาออก
                                </option>
                            </select>
                        </div>
                    </div>

                    <h5 class="text-warning border-bottom border-warning pb-2 mb-3 mt-4">🔐 ข้อมูลเข้าระบบ & เปลี่ยนรหัสผ่าน
                    </h5>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label">ชื่อผู้ใช้งาน (Username)</label>
                            <input type="text" class="form-control bg-light text-muted"
                                value="{{ $employee->user ? $employee->user->username : 'ไม่มีบัญชี' }}" readonly>
                            <small class="text-danger"><i class="bi bi-lock-fill"></i> ไม่สามารถแก้ไขได้</small>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-danger fw-bold">ตั้งรหัสผ่านใหม่</label>
                            <input type="text" name="password" class="form-control border-danger"
                                placeholder="พิมพ์รหัสผ่านใหม่ที่นี่...">
                            <small class="text-muted">หากไม่เปลี่ยน <strong>ให้ปล่อยว่างไว้</strong></small>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">สิทธิ์การใช้งานระบบ (Role) <span class="text-danger">*</span></label>
                            @php
                                $currentRole = $employee->user ? $employee->user->role : 'employee';
                            @endphp
                            <select name="role" class="form-select border-warning fw-bold" required>
                                <option value="employee" {{ $currentRole == 'employee' ? 'selected' : '' }}>👤
                                    พนักงานทั่วไป (Employee)</option>
                                <option value="hr" {{ $currentRole == 'hr' ? 'selected' : '' }}>👥 ฝ่ายบุคคล (HR)
                                </option>
                                <option value="manager" {{ $currentRole == 'manager' ? 'selected' : '' }}>👔 ผู้จัดการ
                                    (Manager)</option>
                                <option value="inventory" {{ $currentRole == 'inventory' ? 'selected' : '' }}>📦
                                    ฝ่ายคลังสินค้า (Inventory)</option>
                                <option value="admin" {{ $currentRole == 'admin' ? 'selected' : '' }}>⚙️ ผู้ดูแลระบบ
                                    (Admin)</option>
                            </select>
                        </div>
                    </div>

                    <hr>
                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-warning">💾 อัปเดตข้อมูล</button>
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
