@extends('layouts.app')

@section('title', 'จัดการสํารองข้อมูล - JST ERP')

@section('content')

{{-- Page Header --}}
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            <i class="fas fa-database me-2" style="color: #818cf8;"></i>จัดการสํารองข้อมูล
        </h4>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">สํารองและกู้คืนข้อมูลฐานข้อมูลของระบบ</p>
    </div>
    <form action="{{ route('admin.backups.create') }}" method="POST" id="createBackupForm">
        @csrf
        <button type="submit" class="erp-btn-primary" onclick="return confirm('ต้องการสร้างสํารองข้อมูลใหม่? ระบบอาจใช้เวลาสักครู่')">
            <i class="fas fa-plus me-2"></i>สร้างสํารองข้อมูล
        </button>
    </form>
</div>

{{-- Flash Messages --}}
@if (session('success'))
    <div class="erp-alert erp-alert-success mb-4">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" style="margin-left: auto;"></button>
    </div>
@endif

@if (session('error'))
    <div class="erp-alert erp-alert-danger mb-4">
        <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" style="margin-left: auto;"></button>
    </div>
@endif

{{-- Stats Cards --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="erp-stat-card">
            <div class="erp-stat-icon" style="background: rgba(99,102,241,0.12); color: #818cf8;">
                <i class="fas fa-hdd"></i>
            </div>
            <div class="erp-stat-body">
                <div class="erp-stat-label">พื้นที่ดิสก์ที่ใช้</div>
                <div class="erp-stat-value" style="color: #818cf8;">{{ round(($diskUsed / $diskTotal) * 100, 1) }}%</div>
                <div style="height: 6px; border-radius: 3px; background: var(--input-bg); margin-top: 8px; overflow: hidden;">
                    <div style="height: 100%; width: {{ ($diskUsed / $diskTotal) * 100 }}%; border-radius: 3px; background: {{ ($diskUsed / $diskTotal) > 0.8 ? '#f87171' : '#34d399' }};"></div>
                </div>
                <div style="font-size: 11px; color: var(--text-muted); margin-top: 4px;">
                    ใช้ {{ round($diskUsed / 1024 / 1024 / 1024, 2) }} GB / {{ round($diskTotal / 1024 / 1024 / 1024, 2) }} GB
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="erp-stat-card">
            <div class="erp-stat-icon" style="background: rgba(56,189,248,0.12); color: #38bdf8;">
                <i class="fas fa-file-archive"></i>
            </div>
            <div class="erp-stat-body">
                <div class="erp-stat-label">จํานวนไฟล์สํารอง</div>
                <div class="erp-stat-value" style="color: #38bdf8;">{{ count($backups) }}</div>
                <div style="font-size: 11px; color: var(--text-muted); margin-top: 4px;">ไฟล์</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="erp-stat-card">
            <div class="erp-stat-icon" style="background: rgba(52,211,153,0.12); color: #34d399;">
                <i class="fas fa-folder-open"></i>
            </div>
            <div class="erp-stat-body">
                <div class="erp-stat-label">พื้นที่ว่าง</div>
                <div class="erp-stat-value" style="color: #34d399;">{{ round($diskFree / 1024 / 1024 / 1024, 2) }} GB</div>
                <div style="font-size: 11px; color: var(--text-muted); margin-top: 4px;">เหลืออยู่</div>
            </div>
        </div>
    </div>
</div>

{{-- Backups Table --}}
<div class="erp-card">
    <div class="erp-card-header">
        <span class="erp-card-title">
            <i class="fas fa-list-ul me-2" style="color: #818cf8;"></i>รายการสํารองข้อมูลทั้งหมด
        </span>
        <span class="erp-badge" style="background: rgba(99,102,241,0.12); color: #818cf8;">
            {{ count($backups) }} ไฟล์
        </span>
    </div>
    <div class="erp-card-body" style="padding: 0;">
        @if (count($backups) > 0)
        <div class="erp-table-wrap">
            <table class="erp-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">ลําดับ</th>
                        <th>ชื่อไฟล์</th>
                        <th style="width: 180px;">วันที่สร้าง</th>
                        <th style="width: 100px;">ขนาด</th>
                        <th style="width: 80px;">ประเภท</th>
                        <th style="width: 160px;" class="text-center">การจัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($backups as $index => $backup)
                    <tr>
                        <td style="color: var(--text-muted);">{{ $index + 1 }}</td>
                        <td><code style="color: var(--text-secondary);">{{ $backup['filename'] }}</code></td>
                        <td style="color: var(--text-secondary);">{{ $backup['date']->format('d/m/Y H:i:s') }}</td>
                        <td style="color: var(--text-secondary);">{{ $backup['size_formatted'] }}</td>
                        <td>
                            @if ($backup['is_compressed'])
                                <span class="erp-badge" style="background: rgba(52,211,153,0.12); color: #34d399;">Gzip</span>
                            @else
                                <span class="erp-badge" style="background: var(--input-bg); color: var(--text-secondary);">SQL</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('admin.backups.download', $backup['filename']) }}"
                                   class="erp-btn-secondary" style="padding: 4px 8px; font-size: 12px;" title="ดาวน์โหลด">
                                    <i class="fas fa-download"></i>
                                </a>
                                <button type="button" class="erp-btn-secondary" style="padding: 4px 8px; font-size: 12px; background: rgba(251,191,36,0.12); border-color: rgba(251,191,36,0.25); color: #fbbf24;"
                                        title="กู้คืนข้อมูล"
                                        data-bs-toggle="modal"
                                        data-bs-target="#restoreModal{{ $index }}">
                                    <i class="fas fa-undo"></i>
                                </button>
                                <button type="button" class="erp-btn-secondary" style="padding: 4px 8px; font-size: 12px; background: rgba(239,68,68,0.12); border-color: rgba(239,68,68,0.25); color: #f87171;"
                                        title="ลบ"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $index }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>

                            <!-- Restore Modal -->
                            <div class="modal fade" id="restoreModal{{ $index }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content" style="background: var(--bg-surface); border: 1px solid var(--border);">
                                        <div class="modal-header" style="background: rgba(251,191,36,0.12); border-bottom: 1px solid var(--border);">
                                            <h5 class="modal-title" style="color: #fbbf24;">
                                                <i class="fas fa-exclamation-triangle me-2"></i>
                                                ยืนยันการกู้คืนข้อมูล
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body" style="color: var(--text-secondary);">
                                            <div class="erp-alert erp-alert-danger">
                                                <i class="fas fa-exclamation-triangle me-2"></i>
                                                <strong>คําเตือน:</strong> การกู้คืนข้อมูลจะแทนที่ข้อมูลปัจจุบันทั้งหมดในฐานข้อมูล
                                                <br>ข้อมูลปัจจุบันจะสูญหายและไม่อาจกู้คืนได้
                                            </div>
                                            <p>ไฟล์ที่จะใช้กู้คืน: <code style="color: var(--text-secondary);">{{ $backup['filename'] }}</code></p>
                                            <p>วันที่สร้าง: {{ $backup['date']->format('d/m/Y H:i:s') }}</p>
                                            <p>ขนาด: {{ $backup['size_formatted'] }}</p>
                                            <hr style="border-color: var(--border);">
                                            <form action="{{ route('admin.backups.restore', $backup['filename']) }}" method="POST">
                                                @csrf
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="checkbox" id="confirmRestore{{ $index }}" required
                                                           style="background-color: var(--input-bg); border-color: var(--input-border);">
                                                    <label class="form-check-label" for="confirmRestore{{ $index }}" style="color: var(--text-secondary);">
                                                        ข้าพเจ้าเข้าใจว่าการดําเนินการนี้ไม่สามารถย้อนกลับได้
                                                    </label>
                                                </div>
                                                <div class="d-flex justify-content-end gap-2">
                                                    <button type="button" class="erp-btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                                    <button type="submit" class="erp-btn-danger" id="restoreBtn{{ $index }}" disabled>
                                                        <i class="fas fa-undo me-1"></i>กู้คืนข้อมูล
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteModal{{ $index }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content" style="background: var(--bg-surface); border: 1px solid var(--border);">
                                        <div class="modal-header" style="background: rgba(239,68,68,0.12); border-bottom: 1px solid var(--border);">
                                            <h5 class="modal-title" style="color: #f87171;">
                                                <i class="fas fa-trash me-2"></i>
                                                ยืนยันการลบ
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body" style="color: var(--text-secondary);">
                                            <p>คุณต้องการลบไฟล์สํารองข้อมูลนี้ใช่หรือไม่?</p>
                                            <p><code style="color: var(--text-secondary);">{{ $backup['filename'] }}</code></p>
                                            <p style="color: var(--text-muted);">สร้างวันที่ {{ $backup['date']->format('d/m/Y H:i:s') }}</p>
                                            <hr style="border-color: var(--border);">
                                            <form action="{{ route('admin.backups.delete', $backup['filename']) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="d-flex justify-content-end gap-2">
                                                    <button type="button" class="erp-btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                                    <button type="submit" class="erp-btn-danger">
                                                        <i class="fas fa-trash me-1"></i>ลบ
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="erp-empty">
            <i class="fas fa-database"></i>
            <div>ยังไม่มีไฟล์สํารองข้อมูล</div>
            <p style="font-size: 13px; color: var(--text-muted);">กดปุ่ม "สร้างสํารองข้อมูล" เพื่อสร้างไฟล์สํารองข้อมูลแรก</p>
        </div>
        @endif
    </div>
</div>

{{-- Tips Card --}}
<div class="erp-card mt-4">
    <div class="erp-card-header">
        <span class="erp-card-title">
            <i class="fas fa-info-circle me-2" style="color: #818cf8;"></i>คําแนะนําการสํารองข้อมูล
        </span>
    </div>
    <div class="erp-card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <h6 style="font-size: 14px; font-weight: 600; color: var(--text-primary);">
                    <i class="fas fa-check-circle me-2" style="color: #34d399;"></i>สิ่งที่ควรทํา
                </h6>
                <ul style="color: var(--text-secondary); padding-left: 20px;">
                    <li>สร้างสํารองข้อมูลก่อนอัปเดตระบบ</li>
                    <li>สร้างสํารองข้อมูลอย่างสม่ําเสมอ</li>
                    <li>ดาวน์โหลดไฟล์สํารองไว้ภายนอก</li>
                    <li>ทดสอบการกู้คืนข้อมูลเป็นระยะ</li>
                </ul>
            </div>
            <div class="col-md-6">
                <h6 style="font-size: 14px; font-weight: 600; color: var(--text-primary);">
                    <i class="fas fa-times-circle me-2" style="color: #f87171;"></i>ข้อควรระวัง
                </h6>
                <ul style="color: var(--text-secondary); padding-left: 20px;">
                    <li>การกู้คืนข้อมูลจะแทนที่ข้อมูลปัจจุบันทั้งหมด</li>
                    <li>อย่าลบไฟล์สํารองข้อมูลล่าสุด</li>
                    <li>เก็บไฟล์สํารองข้อมูลไว้ในที่ปลอดภัย</li>
                    <li>ตรวจสอบพื้นที่ดิสก์ก่อนสร้างสํารองข้อมูล</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
// Enable restore button only when checkbox is checked
document.addEventListener('DOMContentLoaded', function() {
    @foreach ($backups as $index => $backup)
        (function() {
            var checkbox = document.getElementById('confirmRestore{{ $index }}');
            var btn = document.getElementById('restoreBtn{{ $index }}');
            if (checkbox && btn) {
                checkbox.addEventListener('change', function() {
                    btn.disabled = !this.checked;
                });
            }
        })();
    @endforeach
});
</script>
@endsection
