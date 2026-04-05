@extends('layouts.app')

@section('title', 'นําเข้าข้อมูลพนักงาน')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2><i class="bi bi-file-earmark-arrow-up me-2"></i>นําเข้าข้อมูลพนักงาน</h2>
            <p class="text-muted">อัปโหลดไฟล์ CSV หรือ Excel เพื่อนําเข้าข้อมูลพนักงาน</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">อัปโหลดไฟล์</h5>
                </div>
                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('import_results'))
                        @php
                            $results = session('import_results');
                        @endphp
                        <div class="alert {{ $results['failed'] > 0 ? 'alert-warning' : 'alert-success' }} alert-dismissible fade show" role="alert">
                            <h6 class="alert-heading">สรุปผลการนําเข้า</h6>
                            <div class="mb-2">
                                <span class="badge bg-success me-2">สําเร็จ: {{ $results['success'] }} รายการ</span>
                                @if ($results['failed'] > 0)
                                    <span class="badge bg-danger">ไม่สําเร็จ: {{ $results['failed'] }} รายการ</span>
                                @endif
                            </div>

                            @if (!empty($results['errors']))
                                <hr>
                                <h6 class="mb-2">รายละเอียดข้อผิดพลาด:</h6>
                                <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                                    <table class="table table-sm table-bordered">
                                        <thead>
                                            <tr>
                                                <th>แถวที่</th>
                                                <th>รหัสพนักงาน</th>
                                                <th>ข้อผิดพลาด</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($results['errors'] as $error)
                                                <tr>
                                                    <td>{{ $error['row'] }}</td>
                                                    <td>{{ $error['employee_code'] }}</td>
                                                    <td>
                                                        <ul class="mb-0 ps-3">
                                                            @foreach ($error['errors'] as $err)
                                                                <li class="text-danger">{{ $err }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.imports.employees.process') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="file" class="form-label">เลือกไฟล์ CSV หรือ Excel</label>
                            <input type="file" name="file" id="file" class="form-control" accept=".csv,.xlsx,.xls" required>
                            <div class="form-text">รองรับไฟล์ .csv, .xlsx, .xls ขนาดสูงสุด 5MB</div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
                                <i class="bi bi-upload me-2"></i>นําเข้าข้อมูล
                            </button>
                            <a href="{{ route('admin.imports.template.employees') }}" class="btn btn-outline-success">
                                <i class="bi bi-download me-2"></i>ดาวน์โหลดเทมเพลต
                            </a>
                            <a href="{{ route('hr.employees.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>กลับ
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>คําแนะนํา</h6>
                </div>
                <div class="card-body">
                    <h6>คอลัมน์ที่จําเป็น:</h6>
                    <ul class="mb-3">
                        <li><code>employee_code</code> - รหัสพนักงาน (จําเป็น, ไม่ซ้ํา)</li>
                        <li><code>firstname</code> - ชื่อ (จําเป็น)</li>
                        <li><code>lastname</code> - นามสกุล (จําเป็น)</li>
                    </ul>

                    <h6>คอลัมน์เพิ่มเติม:</h6>
                    <ul class="mb-3">
                        <li><code>prefix</code> - คํานําหน้า (นาย/นาง/นางสาว)</li>
                        <li><code>gender</code> - เพศ (male/female/other)</li>
                        <li><code>department_name</code> - ชื่อแผนก</li>
                        <li><code>position_name</code> - ชื่อตําแหน่ง</li>
                        <li><code>start_date</code> - วันที่เริ่มงาน (YYYY-MM-DD)</li>
                        <li><code>status</code> - สถานะ (active/inactive/resigned)</li>
                        <li><code>phone</code> - เบอร์โทรศัพท์</li>
                        <li><code>address</code> - ที่อยู่</li>
                    </ul>

                    <hr>
                    <div class="alert alert-warning mb-0 py-2">
                        <small>
                            <strong>หมายเหตุ:</strong> หากมีรหัสพนักงานซ้ํากับข้อมูลเดิม ระบบจะอัปเดตข้อมูลแทนการสร้างใหม่
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('file').addEventListener('change', function() {
    const submitBtn = document.getElementById('submitBtn');
    if (this.files.length > 0) {
        submitBtn.disabled = false;
        // Check file size
        const fileSize = this.files[0].size / 1024 / 1024; // in MB
        if (fileSize > 5) {
            alert('ขนาดไฟล์เกิน 5MB กรุณาใช้ไฟล์ที่มีขนาดเล็กลง');
            this.value = '';
            submitBtn.disabled = true;
            return;
        }
    } else {
        submitBtn.disabled = true;
    }
});
</script>
@endsection
