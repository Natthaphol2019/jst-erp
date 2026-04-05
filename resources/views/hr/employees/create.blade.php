@extends('layouts.app')
@section('title', 'เพิ่มพนักงานใหม่')

@section('content')
    <div class="container-fluid">
        {{-- Page Header --}}
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
                    <i class="fas fa-user-plus me-2" style="color: #818cf8;"></i>เพิ่มพนักงานใหม่
                </h4>
                <p style="font-size: 13px; color: var(--text-muted); margin: 0;">กรอกข้อมูลพนักงานใหม่เข้าสู่ระบบ</p>
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
                <form action="{{ route('hr.employees.store') }}" method="POST">
                    @csrf

                    <h5 class="mb-3" style="font-size: 14px; font-weight: 600; color: #818cf8; border-bottom: 1px solid var(--border); padding-bottom: 8px;">
                        <i class="fas fa-briefcase me-2"></i>ข้อมูลการทำงาน
                    </h5>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="erp-label">รหัสพนักงาน <span style="color: var(--text-muted);">(สร้างอัตโนมัติ)</span></label>
                            <input type="text" name="employee_code" class="erp-input" style="color: #818cf8; font-weight: 600; background: var(--input-bg);"
                                value="{{ $nextEmployeeCode }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="erp-label">แผนก <span style="color: #f87171;">*</span></label>
                            <select name="department_id" id="department_id" class="erp-select" required>
                                <option value="">-- เลือกแผนก --</option>
                                @foreach ($departments as $dept)
                                    <option value="{{ $dept->id }}"
                                        {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="erp-label">ตำแหน่ง <span style="color: #f87171;">*</span></label>
                            <select name="position_id" id="position_id" class="erp-select" required disabled>
                                <option value="">-- กรุณาเลือกแผนกก่อน --</option>
                                @foreach ($positions as $pos)
                                    <option value="{{ $pos->id }}" data-department="{{ $pos->department_id }}">
                                        {{ $pos->name }}</option>
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
                                <option value="นาย">นาย</option>
                                <option value="นาง">นาง</option>
                                <option value="นางสาว">นางสาว</option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label class="erp-label">ชื่อ <span style="color: #f87171;">*</span></label>
                            <input type="text" name="firstname" class="erp-input" required
                                value="{{ old('firstname') }}">
                        </div>
                        <div class="col-md-5">
                            <label class="erp-label">นามสกุล <span style="color: #f87171;">*</span></label>
                            <input type="text" name="lastname" class="erp-input" required
                                value="{{ old('lastname') }}">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="erp-label">วันที่เริ่มงาน</label>
                            <input type="date" name="start_date" class="erp-input"
                                value="{{ old('start_date', date('Y-m-d')) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="erp-label">เพศ</label>
                            <select name="gender" class="erp-select">
                                <option value="male">ชาย</option>
                                <option value="female">หญิง</option>
                                <option value="other">อื่นๆ</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="erp-label">สถานะ</label>
                            <select name="status" class="erp-select">
                                <option value="active" selected>ทำงานอยู่</option>
                                <option value="inactive">พักงาน</option>
                            </select>
                        </div>
                    </div>

                    <h5 class="mb-3 mt-4" style="font-size: 14px; font-weight: 600; color: #fbbf24; border-bottom: 1px solid var(--border); padding-bottom: 8px;">
                        <i class="fas fa-lock me-2"></i>ข้อมูลการเข้าสู่ระบบ (Login)
                    </h5>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="erp-label">ชื่อผู้ใช้งาน (Username) <span style="color: #f87171;">*</span></label>
                            <input type="text" name="username" class="erp-input" style="color: #818cf8; font-weight: 600;"
                                value="{{ old('username', strtolower($nextEmployeeCode)) }}" required>
                            <small style="color: var(--text-muted);">ระบบแนะนำให้ใช้รหัสพนักงาน</small>
                        </div>
                        <div class="col-md-4">
                            <label class="erp-label">รหัสผ่าน (Password)</label>
                            <input type="text" name="password" class="erp-input" placeholder="กำหนดรหัสผ่าน...">
                            <small style="color: var(--text-muted);">ถ้าว่างไว้ จะใช้ <code>password123</code></small>
                        </div>
                        <div class="col-md-4">
                            <label class="erp-label">สิทธิ์การใช้งานระบบ (Role) <span style="color: #f87171;">*</span></label>
                            <select name="role" class="erp-select" required>
                                <option value="employee" selected>พนักงานทั่วไป (Employee)</option>
                                <option value="hr">ฝ่ายบุคคล (HR)</option>
                                <option value="manager">ผู้จัดการ (Manager)</option>
                                <option value="inventory">ฝ่ายคลังสินค้า (Inventory)</option>
                                <option value="admin">ผู้ดูแลระบบ (Admin)</option>
                            </select>
                        </div>
                    </div>

                    <hr style="border-color: var(--border);">
                    <div class="d-flex gap-2 justify-content-end mt-4">
                        <button type="reset" class="erp-btn-secondary">
                            <i class="fas fa-eraser me-2"></i>ล้างค่า
                        </button>
                        <button type="submit" class="erp-btn-primary">
                            <i class="fas fa-save me-2"></i>บันทึกข้อมูล
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('department_id').addEventListener('change', function() {
            let deptId = this.value;
            let positionSelect = document.getElementById('position_id');
            let options = positionSelect.querySelectorAll('option');

            if (deptId === "") {
                positionSelect.disabled = true;
                positionSelect.value = "";
                return;
            }

            positionSelect.disabled = false;
            positionSelect.value = "";

            options.forEach(option => {
                if (option.value === "") return;
                if (option.getAttribute('data-department') === deptId) {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                }
            });
        });
    </script>
@endsection
