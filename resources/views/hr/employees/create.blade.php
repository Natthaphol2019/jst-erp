@extends('layouts.app')
@section('title', 'เพิ่มพนักงานใหม่')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>➕ เพิ่มพนักงานใหม่</h2>
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
                <form action="{{ route('hr.employees.store') }}" method="POST">
                    @csrf

                    <h5 class="text-primary border-bottom pb-2 mb-3">ข้อมูลการทำงาน</h5>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">รหัสพนักงาน <span class="text-muted">(สร้างอัตโนมัติ)</span></label>
                            <input type="text" name="employee_code" class="form-control bg-light text-primary fw-bold"
                                value="{{ $nextEmployeeCode }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">แผนก <span class="text-danger">*</span></label>
                            <select name="department_id" id="department_id" class="form-select" required>
                                <option value="">-- เลือกแผนก --</option>
                                @foreach ($departments as $dept)
                                    <option value="{{ $dept->id }}"
                                        {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">ตำแหน่ง <span class="text-danger">*</span></label>
                            <select name="position_id" id="position_id" class="form-select" required disabled>
                                <option value="">-- กรุณาเลือกแผนกก่อน --</option>
                                @foreach ($positions as $pos)
                                    <option value="{{ $pos->id }}" data-department="{{ $pos->department_id }}">
                                        {{ $pos->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <h5 class="text-primary border-bottom pb-2 mb-3 mt-4">ข้อมูลส่วนตัว</h5>
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label class="form-label">คำนำหน้า</label>
                            <select name="prefix" class="form-select">
                                <option value="นาย">นาย</option>
                                <option value="นาง">นาง</option>
                                <option value="นางสาว">นางสาว</option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">ชื่อ <span class="text-danger">*</span></label>
                            <input type="text" name="firstname" class="form-control" required
                                value="{{ old('firstname') }}">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">นามสกุล <span class="text-danger">*</span></label>
                            <input type="text" name="lastname" class="form-control" required
                                value="{{ old('lastname') }}">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label">วันที่เริ่มงาน</label>
                            <input type="date" name="start_date" class="form-control"
                                value="{{ old('start_date', date('Y-m-d')) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">เพศ</label>
                            <select name="gender" class="form-select">
                                <option value="male">ชาย</option>
                                <option value="female">หญิง</option>
                                <option value="other">อื่นๆ</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">สถานะ</label>
                            <select name="status" class="form-select">
                                <option value="active" selected>ทำงานอยู่</option>
                                <option value="inactive">พักงาน</option>
                            </select>
                        </div>
                    </div>

                    <h5 class="text-primary border-bottom pb-2 mb-3 mt-4">🔐 ข้อมูลการเข้าสู่ระบบ (Login)</h5>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label">ชื่อผู้ใช้งาน (Username) <span class="text-danger">*</span></label>
                            <input type="text" name="username" class="form-control fw-bold text-primary" 
                                value="{{ old('username', strtolower($nextEmployeeCode)) }}" required>
                            <small class="text-muted">ระบบแนะนำให้ใช้รหัสพนักงาน</small>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">รหัสผ่าน (Password)</label>
                            <input type="text" name="password" class="form-control" placeholder="กำหนดรหัสผ่าน...">
                            <small class="text-muted text-danger">ถ้าว่างไว้ จะใช้ <code>password123</code></small>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">สิทธิ์การใช้งานระบบ (Role) <span class="text-danger">*</span></label>
                            <select name="role" class="form-select border-primary fw-bold" required>
                                <option value="employee" selected>👤 พนักงานทั่วไป (Employee)</option>
                                <option value="hr">👥 ฝ่ายบุคคล (HR)</option>
                                <option value="manager">👔 ผู้จัดการ (Manager)</option>
                                <option value="inventory">📦 ฝ่ายคลังสินค้า (Inventory)</option>
                                <option value="admin">⚙️ ผู้ดูแลระบบ (Admin)</option>
                            </select>
                        </div>
                    </div>

                    <hr>
                    <div class="text-end mt-3">
                        <button type="reset" class="btn btn-light me-2">ล้างค่า</button>
                        <button type="submit" class="btn btn-primary">💾 บันทึกข้อมูล</button>
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
