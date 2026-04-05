@extends('layouts.app')

@section('title', 'บันทึกกิจกรรม - JST ERP')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h4 mb-1 text-dark">
                        <i class="bi bi-clipboard2-pulse me-2"></i>บันทึกกิจกรรม (Activity Log)
                    </h2>
                    <p class="text-muted mb-0">ตรวจสอบการเปลี่ยนแปลงข้อมูลทั้งหมดในระบบ</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 fw-bold text-dark">
                <i class="bi bi-funnel me-2"></i>ตัวกรอง
            </h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.activity-logs.index') }}" class="row g-3">
                <!-- Date From -->
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">วันที่เริ่มต้น</label>
                    <input type="date" name="date_from" class="form-control"
                        value="{{ request('date_from') }}">
                </div>

                <!-- Date To -->
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">วันที่สิ้นสุด</label>
                    <input type="date" name="date_to" class="form-control"
                        value="{{ request('date_to') }}">
                </div>

                <!-- User Filter -->
                @if(isset($users))
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">ผู้ใช้งาน</label>
                    <select name="user_id" class="form-select">
                        <option value="">-- ทั้งหมด --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif

                <!-- Action Type Filter -->
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">ประเภทการกระทำ</label>
                    <select name="action_type" class="form-select">
                        <option value="">-- ทั้งหมด --</option>
                        <option value="created" {{ request('action_type') == 'created' ? 'selected' : '' }}>สร้าง</option>
                        <option value="updated" {{ request('action_type') == 'updated' ? 'selected' : '' }}>แก้ไข</option>
                        <option value="deleted" {{ request('action_type') == 'deleted' ? 'selected' : '' }}>ลบ</option>
                    </select>
                </div>

                <!-- Subject Type Filter -->
                @if(isset($subjectTypes))
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">ประเภทข้อมูล</label>
                    <select name="subject_type" class="form-select">
                        <option value="">-- ทั้งหมด --</option>
                        @foreach($subjectTypes as $type)
                            <option value="{{ $type['class'] }}" {{ request('subject_type') == $type['class'] ? 'selected' : '' }}>
                                {{ $type['thai_name'] }} ({{ $type['name'] }})
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif

                <!-- Log Name Filter -->
                @if(isset($logNames) && $logNames->count() > 0)
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">ชื่อ Log</label>
                    <select name="log_name" class="form-select">
                        <option value="">-- ทั้งหมด --</option>
                        @foreach($logNames as $name)
                            <option value="{{ $name }}" {{ request('log_name') == $name ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif

                <!-- Search -->
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">ค้นหา</label>
                    <input type="text" name="search" class="form-control"
                        placeholder="ค้นหาจากคำอธิบาย..."
                        value="{{ request('search') }}">
                </div>

                <!-- Buttons -->
                <div class="col-12 d-flex gap-2 align-items-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i> ค้นหา
                    </button>
                    <a href="{{ route('admin.activity-logs.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle me-1"></i> ล้างตัวกรอง
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Subject Info Banner (if viewing logs for specific subject) -->
    @if(isset($subject) && $subject)
    <div class="alert alert-info d-flex align-items-center mb-4">
        <i class="bi bi-info-circle-fill me-2 fs-5"></i>
        <div>
            <strong>แสดงบันทึกกิจกรรมของ {{ $subjectTypeName ?? class_basename($subject) }}:</strong>
            {{ $subject->name ?? $subject->employee_code ?? 'ID: ' . $subject->id }}
        </div>
    </div>
    @endif

    <!-- Activity Logs Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-dark">
                <i class="bi bi-list-ul me-2"></i>รายการบันทึกกิจกรรม
            </h6>
            <span class="badge bg-secondary">{{ $activityLogs->total() }} รายการ</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width: 50px;">ID</th>
                            <th style="width: 80px;">ประเภท</th>
                            <th>คำอธิบาย</th>
                            <th style="width: 180px;">ผู้ใช้งาน</th>
                            <th style="width: 150px;">ประเภทข้อมูล</th>
                            <th style="width: 160px;">วันที่-เวลา</th>
                            <th style="width: 80px;" class="text-center pe-4">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activityLogs as $log)
                        <tr>
                            <td class="ps-4 text-muted small">{{ $log->id }}</td>
                            <td>
                                <span class="badge {{ $log->action_badge_class }}">
                                    {{ $log->action_label }}
                                </span>
                            </td>
                            <td>
                                <div class="text-truncate" style="max-width: 400px;" title="{{ $log->description }}">
                                    {{ $log->description }}
                                </div>
                            </td>
                            <td>
                                @if($log->user)
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                                        style="width: 32px; height: 32px; font-size: 0.75rem;">
                                        {{ strtoupper(substr($log->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="small fw-semibold">{{ $log->user->name }}</div>
                                        <div class="text-muted small" style="font-size: 0.7rem;">{{ $log->user->role }}</div>
                                    </div>
                                </div>
                                @else
                                <span class="text-muted small"><i class="bi bi-gear me-1"></i>ระบบ</span>
                                @endif
                            </td>
                            <td>
                                @if($log->subject_type)
                                <span class="badge bg-light text-dark">
                                    {{ class_basename($log->subject_type) }}
                                </span>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="small">
                                    <div>{{ $log->created_at->format('d/m/Y') }}</div>
                                    <div class="text-muted">{{ $log->created_at->format('H:i:s') }}</div>
                                </div>
                            </td>
                            <td class="text-center pe-4">
                                <a href="{{ route('admin.activity-logs.show', $log->id) }}"
                                    class="btn btn-sm btn-outline-primary" title="ดูรายละเอียด">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-clipboard2-x fs-1 d-block mb-3"></i>
                                <p class="mb-1">ไม่พบบันทึกกิจกรรม</p>
                                <small>ลองเปลี่ยนตัวกรองหรือค้นหาข้อมูลใหม่</small>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($activityLogs->hasPages())
        <div class="card-footer bg-white py-3">
            {{ $activityLogs->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
