@extends('layouts.app')

@section('title', 'จัดการสํารองข้อมูล')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2><i class="bi bi-database me-2"></i>จัดการสํารองข้อมูล</h2>
                <p class="text-muted">สํารองและกู้คืนข้อมูลฐานข้อมูลของระบบ</p>
            </div>
            <form action="{{ route('admin.backups.create') }}" method="POST" id="createBackupForm">
                @csrf
                <button type="submit" class="btn btn-primary" onclick="return confirm('ต้องการสร้างสํารองข้อมูลใหม่? ระบบอาจใช้เวลาสักครู่')">
                    <i class="bi bi-plus-circle me-2"></i>สร้างสํารองข้อมูล
                </button>
            </form>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title text-muted">พื้นที่ดิสก์ที่ใช้</h5>
                    <h3 class="text-primary">{{ round(($diskUsed / $diskTotal) * 100, 1) }}%</h3>
                    <div class="progress mb-2" style="height: 10px;">
                        <div class="progress-bar {{ ($diskUsed / $diskTotal) > 0.8 ? 'bg-danger' : 'bg-success' }}"
                             style="width: {{ ($diskUsed / $diskTotal) * 100 }}%"></div>
                    </div>
                    <small class="text-muted">
                        ใช้ {{ round($diskUsed / 1024 / 1024 / 1024, 2) }} GB / {{ round($diskTotal / 1024 / 1024 / 1024, 2) }} GB
                    </small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title text-muted">จํานวนไฟล์สํารอง</h5>
                    <h3 class="text-info">{{ count($backups) }}</h3>
                    <small class="text-muted">ไฟล์</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title text-muted">พื้นที่ว่าง</h5>
                    <h3 class="text-success">{{ round($diskFree / 1024 / 1024 / 1024, 2) }} GB</h3>
                    <small class="text-muted">เหลืออยู่</small>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>รายการสํารองข้อมูลทั้งหมด</h5>
        </div>
        <div class="card-body p-0">
            @if (count($backups) > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ลําดับ</th>
                                <th>ชื่อไฟล์</th>
                                <th>วันที่สร้าง</th>
                                <th>ขนาด</th>
                                <th>ประเภท</th>
                                <th class="text-center">การจัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($backups as $index => $backup)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><code>{{ $backup['filename'] }}</code></td>
                                    <td>{{ $backup['date']->format('d/m/Y H:i:s') }}</td>
                                    <td>{{ $backup['size_formatted'] }}</td>
                                    <td>
                                        @if ($backup['is_compressed'])
                                            <span class="badge bg-success">Gzip</span>
                                        @else
                                            <span class="badge bg-secondary">SQL</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.backups.download', $backup['filename']) }}"
                                               class="btn btn-sm btn-outline-primary" title="ดาวน์โหลด">
                                                <i class="bi bi-download"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-warning"
                                                    title="กู้คืนข้อมูล"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#restoreModal{{ $index }}">
                                                <i class="bi bi-arrow-clockwise"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                    title="ลบ"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $index }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>

                                        <!-- Restore Modal -->
                                        <div class="modal fade" id="restoreModal{{ $index }}" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-warning">
                                                        <h5 class="modal-title">
                                                            <i class="bi bi-exclamation-triangle me-2"></i>
                                                            ยืนยันการกู้คืนข้อมูล
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="alert alert-danger">
                                                            <strong>คําเตือน:</strong> การกู้คืนข้อมูลจะแทนที่ข้อมูลปัจจุบันทั้งหมดในฐานข้อมูล
                                                            <br>ข้อมูลปัจจุบันจะสูญหายและไม่อาจกู้คืนได้
                                                        </div>
                                                        <p>ไฟล์ที่จะใช้กู้คืน: <code>{{ $backup['filename'] }}</code></p>
                                                        <p>วันที่สร้าง: {{ $backup['date']->format('d/m/Y H:i:s') }}</p>
                                                        <p>ขนาด: {{ $backup['size_formatted'] }}</p>
                                                        <hr>
                                                        <form action="{{ route('admin.backups.restore', $backup['filename']) }}" method="POST">
                                                            @csrf
                                                            <div class="form-check mb-3">
                                                                <input class="form-check-input" type="checkbox" id="confirmRestore{{ $index }}" required>
                                                                <label class="form-check-label" for="confirmRestore{{ $index }}">
                                                                    ข้าพเจ้าเข้าใจว่าการดําเนินการนี้ไม่สามารถย้อนกลับได้
                                                                </label>
                                                            </div>
                                                            <div class="d-flex justify-content-end gap-2">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                                                <button type="submit" class="btn btn-danger" id="restoreBtn{{ $index }}" disabled>
                                                                    <i class="bi bi-arrow-clockwise me-1"></i>กู้คืนข้อมูล
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
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title">
                                                            <i class="bi bi-trash me-2"></i>
                                                            ยืนยันการลบ
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>คุณต้องการลบไฟล์สํารองข้อมูลนี้ใช่หรือไม่?</p>
                                                        <p><code>{{ $backup['filename'] }}</code></p>
                                                        <p class="text-muted">การสร้างวันที่ {{ $backup['date']->format('d/m/Y H:i:s') }}</p>
                                                        <hr>
                                                        <form action="{{ route('admin.backups.delete', $backup['filename']) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="d-flex justify-content-end gap-2">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                                                <button type="submit" class="btn btn-danger">
                                                                    <i class="bi bi-trash me-1"></i>ลบ
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
                <div class="text-center py-5">
                    <i class="bi bi-database-x text-muted" style="font-size: 3rem;"></i>
                    <h5 class="text-muted mt-3">ยังไม่มีไฟล์สํารองข้อมูล</h5>
                    <p class="text-muted">กดปุ่ม "สร้างสํารองข้อมูล" เพื่อสร้างไฟล์สํารองข้อมูลแรก</p>
                </div>
            @endif
        </div>
    </div>

    <div class="card shadow-sm mt-4">
        <div class="card-header bg-info text-white">
            <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>คําแนะนําการสํารองข้อมูล</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6><i class="bi bi-check-circle text-success me-2"></i>สิ่งที่ควรถาม</h6>
                    <ul class="mb-0">
                        <li>สร้างสํารองข้อมูลก่อนอัปเดตระบบ</li>
                        <li>สร้างสํารองข้อมูลอย่างสม่ําเสมอ</li>
                        <li>ดาวน์โหลดไฟล์สํารองสํารองไว้ภายนอก</li>
                        <li>ทดสอบการกู้คืนข้อมูลเป็นระยะ</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6><i class="bi bi-x-circle text-danger me-2"></i>ข้อควรระวัง</h6>
                    <ul class="mb-0">
                        <li>การกู้คืนข้อมูลจะแทนที่ข้อมูลปัจจุบันทั้งหมด</li>
                        <li>อย่าลบไฟล์สํารองข้อมูลล่าสุด</li>
                        <li>เก็บไฟล์สํารองข้อมูลไว้ในที่ปลอดภัย</li>
                        <li>ตรวจสอบพื้นที่ดิสก์ก่อนสร้างสํารองข้อมูล</li>
                    </ul>
                </div>
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
