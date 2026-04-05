@extends('layouts.app')

@section('title', 'นําเข้าข้อมูลพนักงาน')

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            <i class="fas fa-file-import me-2" style="color: #818cf8;"></i>นําเข้าข้อมูลพนักงาน
        </h4>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">อัปโหลดไฟล์ CSV หรือ Excel เพื่อนําเข้าข้อมูลพนักงาน</p>
    </div>
</div>

@if (session('error'))
    <div class="erp-alert erp-alert-danger mb-4">
        <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
    </div>
@endif

@if (session('import_results'))
    @php
        $results = session('import_results');
    @endphp
    <div class="erp-alert {{ $results['failed'] > 0 ? 'erp-alert-warning' : 'erp-alert-success' }} mb-4">
        <h6 class="alert-heading" style="color: var(--text-primary);">สรุปผลการนําเข้า</h6>
        <div class="mb-2">
            <span class="erp-badge" style="background: rgba(52,211,153,0.12); color: #34d399;">
                <i class="fas fa-check me-1"></i>สําเร็จ: {{ $results['success'] }} รายการ
            </span>
            @if ($results['failed'] > 0)
                <span class="erp-badge" style="background: rgba(239,68,68,0.12); color: #f87171;">
                    <i class="fas fa-times me-1"></i>ไม่สําเร็จ: {{ $results['failed'] }} รายการ
                </span>
            @endif
        </div>

        @if (!empty($results['errors']))
            <hr style="border-color: var(--border);">
            <h6 class="mb-2" style="color: var(--text-primary);">รายละเอียดข้อผิดพลาด:</h6>
            <div class="erp-table-wrap" style="max-height: 300px; overflow-y: auto;">
                <table class="erp-table">
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
                                <td style="color: var(--text-secondary);">{{ $error['row'] }}</td>
                                <td style="color: var(--text-secondary);">{{ $error['employee_code'] }}</td>
                                <td>
                                    <ul class="mb-0 ps-3" style="color: var(--text-secondary);">
                                        @foreach ($error['errors'] as $err)
                                            <li style="color: #f87171;">{{ $err }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endif

<div class="row g-3">
    <div class="col-md-8">
        <div class="erp-card">
            <div class="erp-card-header">
                <span class="erp-card-title">
                    <i class="fas fa-upload me-2" style="color: #818cf8;"></i>อัปโหลดไฟล์
                </span>
            </div>
            <div class="erp-card-body">
                <form action="{{ route('admin.imports.employees.process') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="file" class="erp-label">เลือกไฟล์ CSV หรือ Excel</label>
                        <input type="file" name="file" id="file" class="erp-input" accept=".csv,.xlsx,.xls" required>
                        <div style="font-size: 11px; color: var(--text-muted); margin-top: 4px;">รองรับไฟล์ .csv, .xlsx, .xls ขนาดสูงสุด 5MB</div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="erp-btn-primary" id="submitBtn" disabled>
                            <i class="fas fa-upload me-2"></i>นําเข้าข้อมูล
                        </button>
                        <a href="{{ route('admin.imports.template.employees') }}" class="erp-btn-secondary">
                            <i class="fas fa-download me-2"></i>ดาวน์โหลดเทมเพลต
                        </a>
                        <a href="{{ route('hr.employees.index') }}" class="erp-btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>กลับ
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="erp-card">
            <div class="erp-card-header">
                <span class="erp-card-title">
                    <i class="fas fa-info-circle me-2" style="color: #818cf8;"></i>คําแนะนํา
                </span>
            </div>
            <div class="erp-card-body">
                <h6 style="color: var(--text-primary); font-size: 13px; font-weight: 600; margin-bottom: 8px;">คอลัมน์ที่จําเป็น:</h6>
                <ul class="mb-3" style="color: var(--text-secondary); font-size: 13px;">
                    <li><code>employee_code</code> - รหัสพนักงาน (จําเป็น, ไม่ซ้ํา)</li>
                    <li><code>firstname</code> - ชื่อ (จําเป็น)</li>
                    <li><code>lastname</code> - นามสกุล (จําเป็น)</li>
                </ul>

                <h6 style="color: var(--text-primary); font-size: 13px; font-weight: 600; margin-bottom: 8px;">คอลัมน์เพิ่มเติม:</h6>
                <ul class="mb-3" style="color: var(--text-secondary); font-size: 13px;">
                    <li><code>prefix</code> - คํานําหน้า (นาย/นาง/นางสาว)</li>
                    <li><code>gender</code> - เพศ (male/female/other)</li>
                    <li><code>department_name</code> - ชื่อแผนก</li>
                    <li><code>position_name</code> - ชื่อตําแหน่ง</li>
                    <li><code>start_date</code> - วันที่เริ่มงาน (YYYY-MM-DD)</li>
                    <li><code>status</code> - สถานะ (active/inactive/resigned)</li>
                    <li><code>phone</code> - เบอร์โทรศัพท์</li>
                    <li><code>address</code> - ที่อยู่</li>
                </ul>

                <hr style="border-color: var(--border);">
                <div class="erp-alert erp-alert-warning mb-0 py-2" style="padding: 8px;">
                    <small style="color: var(--text-secondary);">
                        <strong>หมายเหตุ:</strong> หากมีรหัสพนักงานซ้ํากับข้อมูลเดิม ระบบจะอัปเดตข้อมูลแทนการสร้างใหม่
                    </small>
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
