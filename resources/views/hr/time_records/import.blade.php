@extends('layouts.app')

@section('title', 'นำเข้าข้อมูลเวลาทำงาน - JST ERP')

@section('content')
<style>
.upload-zone {
    border: 3px dashed #d1d5db;
    border-radius: 16px;
    padding: 60px 40px;
    text-align: center;
    background: #f9fafb;
    transition: all 0.3s ease;
    cursor: pointer;
}

.upload-zone:hover,
.upload-zone.dragover {
    border-color: #818cf8;
    background: rgba(129, 140, 248, 0.05);
    box-shadow: 0 8px 24px rgba(129, 140, 248, 0.15);
}

.upload-zone i {
    font-size: 64px;
    color: #9ca3af;
    margin-bottom: 20px;
}

.upload-zone h4 {
    color: #1f2937;
    margin-bottom: 12px;
    font-size: 20px;
    font-weight: 600;
}

.upload-zone p {
    color: #6b7280;
    font-size: 14px;
    margin: 0;
}

.upload-zone .file-types {
    display: inline-flex;
    gap: 8px;
    margin-top: 16px;
}

.upload-zone .file-type-badge {
    padding: 6px 14px;
    border-radius: 8px;
    background: #e5e7eb;
    color: #4b5563;
    font-size: 12px;
    font-weight: 600;
}

.result-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 20px;
    margin-top: 20px;
}

.result-stat {
    text-align: center;
    padding: 20px;
    border-radius: 12px;
    background: #f9fafb;
}

.result-stat.success {
    background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
    border: 2px solid #10b981;
}

.result-stat.skipped {
    background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
    border: 2px solid #f59e0b;
}

.result-stat.error {
    background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
    border: 2px solid #ef4444;
}

.result-stat .number {
    font-size: 36px;
    font-weight: 700;
    margin-bottom: 8px;
}

.result-stat.success .number {
    color: #10b981;
}

.result-stat.skipped .number {
    color: #f59e0b;
}

.result-stat.error .number {
    color: #ef4444;
}

.result-stat .label {
    font-size: 14px;
    color: #6b7280;
    font-weight: 500;
}

.error-list {
    max-height: 300px;
    overflow-y: auto;
    padding: 16px;
    background: #fef2f2;
    border-radius: 8px;
    margin-top: 16px;
}

.error-list pre {
    margin: 0;
    font-size: 13px;
    color: #991b1b;
    white-space: pre-wrap;
    word-wrap: break-word;
}
</style>

<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            <i class="fas fa-file-import me-2" style="color: #818cf8;"></i>นำเข้าข้อมูลเวลาทำงาน
        </h4>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">
            Upload ไฟล์ Excel/CSV จากเครื่องสแกนนิ้วหรือระบบอื่น
        </p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('hr.time-records.summary') }}" class="erp-btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>กลับ
        </a>
    </div>
</div>

@if(session('success'))
    <div class="erp-alert erp-alert-success mb-4" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="erp-alert erp-alert-danger mb-4" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>{{ $errors->first() }}
    </div>
@endif

<div class="row g-3">
    {{-- Left Column - Upload Form --}}
    <div class="col-lg-7">
        <div class="erp-card">
            <div class="erp-card-header">
                <span class="erp-card-title">
                    <i class="fas fa-cloud-upload-alt me-2" style="color: #818cf8;"></i>Upload ไฟล์
                </span>
            </div>
            <div class="erp-card-body">
                <form action="{{ route('hr.time-records.import.store') }}" method="POST" enctype="multipart/form-data" id="importForm">
                    @csrf

                    <div class="mb-4">
                        <label class="erp-label">โหมดการนำเข้า <span style="color: #f87171;">*</span></label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="import_mode" id="modeCreate" value="create" checked>
                                <label class="form-check-label" for="modeCreate">
                                    <strong>สร้างเฉพาะข้อมูลใหม่</strong>
                                    <br><small style="color: #6b7280;">ข้ามข้อมูลที่มีอยู่แล้ว</small>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="import_mode" id="modeUpdate" value="update">
                                <label class="form-check-label" for="modeUpdate">
                                    <strong>อัพเดทข้อมูลเดิม</strong>
                                    <br><small style="color: #6b7280;">แก้ไขข้อมูลที่มีอยู่แล้ว</small>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="upload-zone" id="uploadZone" onclick="document.getElementById('fileInput').click()">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <h4>ลากไฟล์มาวางที่นี่ หรือคลิกเพื่อเลือก</h4>
                        <p>รองรับไฟล์ Excel (.xlsx, .xls) และ CSV ขนาดไม่เกิน 10MB</p>
                        <div class="file-types">
                            <span class="file-type-badge">.XLSX</span>
                            <span class="file-type-badge">.XLS</span>
                            <span class="file-type-badge">.CSV</span>
                        </div>
                    </div>

                    <input type="file" name="import_file" id="fileInput" class="d-none" accept=".xlsx,.xls,.csv">

                    <div id="fileInfo" class="mt-3" style="display: none;">
                        <div class="d-flex align-items-center gap-3" style="padding: 16px; background: #f0fdf4; border: 2px solid #10b981; border-radius: 12px;">
                            <i class="fas fa-file-excel" style="font-size: 32px; color: #10b981;"></i>
                            <div class="flex-grow-1">
                                <div id="fileName" style="font-weight: 600; color: #065f46;"></div>
                                <div id="fileSize" style="font-size: 12px; color: #059669;"></div>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearFile()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="button" class="erp-btn-secondary" onclick="document.getElementById('importForm').reset(); clearFile();">
                            <i class="fas fa-redo me-2"></i>รีเซ็ต
                        </button>
                        <button type="submit" class="erp-btn-primary" id="submitBtn">
                            <i class="fas fa-upload me-2"></i>นำเข้าข้อมูล
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Right Column - Instructions & Template --}}
    <div class="col-lg-5">
        <div class="erp-card mb-3">
            <div class="erp-card-header">
                <span class="erp-card-title">
                    <i class="fas fa-download me-2" style="color: #818cf8;"></i>ดาวน์โหลด Template
                </span>
            </div>
            <div class="erp-card-body">
                <p style="font-size: 14px; color: var(--text-secondary); margin-bottom: 16px;">
                    ดาวน์โหลด Template เพื่อเตรียมข้อมูลให้ถูกต้องตามรูปแบบ
                </p>
                <a href="{{ route('hr.time-records.import.template') }}" class="erp-btn-primary w-100">
                    <i class="fas fa-file-excel me-2"></i>ดาวน์โหลด Template Excel
                </a>
            </div>
        </div>

        <div class="erp-card">
            <div class="erp-card-header">
                <span class="erp-card-title">
                    <i class="fas fa-info-circle me-2" style="color: #818cf8;"></i>คำแนะนำ
                </span>
            </div>
            <div class="erp-card-body">
                <div style="font-size: 13px; color: var(--text-secondary); line-height: 1.8;">
                    <h6 style="font-weight: 600; color: var(--text-primary); margin-bottom: 12px;">รูปแบบไฟล์ที่ถูกต้อง:</h6>
                    <ul style="padding-left: 20px; margin-bottom: 16px;">
                        <li><strong>employee_code</strong> - รหัสพนักงาน (ต้องมีในระบบ)</li>
                        <li><strong>work_date</strong> - วันที่ (YYYY-MM-DD เช่น 2026-04-07)</li>
                        <li><strong>status</strong> - present, late, leave, absent</li>
                        <li><strong>morning_in/out</strong> - เวลาเข้า-ออกเช้า (HH:MM เช่น 08:00)</li>
                        <li><strong>afternoon_in/out</strong> - เวลาเข้า-ออกบ่าย</li>
                        <li><strong>ot_in/out</strong> - เวลาเข้า-ออก OT (ถ้ามี)</li>
                        <li><strong>remark</strong> - หมายเหตุ (ถ้ามี)</li>
                    </ul>

                    <h6 style="font-weight: 600; color: var(--text-primary); margin-bottom: 12px;">โหมดการนำเข้า:</h6>
                    <ul style="padding-left: 20px; margin-bottom: 0;">
                        <li><strong>สร้างเฉพาะข้อมูลใหม่:</strong> ข้าม row ที่มีข้อมูลอยู่แล้ว</li>
                        <li><strong>อัพเดทข้อมูลเดิม:</strong> แก้ไขข้อมูลที่มีอยู่แล้ว</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Results Section (แสดงหลัง import) --}}
@if(session('import_results'))
<div class="result-card mt-4">
    <h5 style="font-weight: 600; color: var(--text-primary); margin-bottom: 20px;">
        <i class="fas fa-chart-bar me-2" style="color: #818cf8;"></i>ผลการนำเข้า
    </h5>

    @php
        $results = session('import_results');
    @endphp

    <div class="row g-3">
        <div class="col-md-4">
            <div class="result-stat success">
                <div class="number">{{ $results['success'] }}</div>
                <div class="label">สำเร็จ</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="result-stat skipped">
                <div class="number">{{ $results['skipped'] }}</div>
                <div class="label">ข้าม</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="result-stat error">
                <div class="number">{{ count($results['errors']) }}</div>
                <div class="label">ข้อผิดพลาด</div>
            </div>
        </div>
    </div>

    @if(count($results['errors']) > 0)
    <div class="error-list">
        <h6 style="font-weight: 600; color: #991b1b; margin-bottom: 12px;">
            <i class="fas fa-exclamation-circle me-2"></i>รายการที่มีข้อผิดพลาด:
        </h6>
        <pre>@foreach($results['errors'] as $error){{ $error }}
@endforeach</pre>
    </div>
    @endif

    @if(count($results['warnings']) > 0)
    <div class="mt-3" style="padding: 16px; background: #fffbeb; border-radius: 8px; border: 2px solid #f59e0b;">
        <h6 style="font-weight: 600; color: #92400e; margin-bottom: 8px;">
            <i class="fas fa-exclamation-triangle me-2"></i>คำเตือน:
        </h6>
        <ul style="margin: 0; padding-left: 20px; color: #78350f; font-size: 13px;">
            @foreach(array_slice($results['warnings'], 0, 5) as $warning)
                <li>{{ $warning }}</li>
            @endforeach
            @if(count($results['warnings']) > 5)
                <li>...และอีก {{ count($results['warnings']) - 5 }} รายการ</li>
            @endif
        </ul>
    </div>
    @endif
</div>
@endif

@endsection

@push('scripts')
<script>
const uploadZone = document.getElementById('uploadZone');
const fileInput = document.getElementById('fileInput');
const fileInfo = document.getElementById('fileInfo');
const fileName = document.getElementById('fileName');
const fileSize = document.getElementById('fileSize');

// Drag and Drop
uploadZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    uploadZone.classList.add('dragover');
});

uploadZone.addEventListener('dragleave', () => {
    uploadZone.classList.remove('dragover');
});

uploadZone.addEventListener('drop', (e) => {
    e.preventDefault();
    uploadZone.classList.remove('dragover');
    
    if (e.dataTransfer.files.length) {
        fileInput.files = e.dataTransfer.files;
        displayFile(e.dataTransfer.files[0]);
    }
});

// File Input Change
fileInput.addEventListener('change', (e) => {
    if (e.target.files.length) {
        displayFile(e.target.files[0]);
    }
});

function displayFile(file) {
    const maxSize = 10 * 1024 * 1024; // 10MB
    
    if (file.size > maxSize) {
        alert('ไฟล์มีขนาดใหญ่เกินไป (สูงสุด 10MB)');
        return;
    }

    const validTypes = [
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'text/csv',
        'application/csv'
    ];
    
    const fileExt = file.name.split('.').pop().toLowerCase();
    if (!['xlsx', 'xls', 'csv'].includes(fileExt)) {
        alert('รูปแบบไฟล์ไม่ถูกต้อง (รองรับ: .xlsx, .xls, .csv)');
        return;
    }

    fileName.textContent = file.name;
    fileSize.textContent = formatFileSize(file.size);
    fileInfo.style.display = 'block';
    uploadZone.style.display = 'none';
}

function clearFile() {
    fileInput.value = '';
    fileInfo.style.display = 'none';
    uploadZone.style.display = 'block';
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
}
</script>
@endpush
