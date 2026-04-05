@extends('layouts.app')

@section('title', 'บันทึกกิจกรรม - JST ERP')

@section('content')

{{-- Page Header --}}
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            <i class="fas fa-clipboard-check me-2" style="color: #818cf8;"></i>บันทึกกิจกรรม (Activity Log)
        </h4>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">ตรวจสอบการเปลี่ยนแปลงข้อมูลทั้งหมดในระบบ</p>
    </div>
</div>

{{-- Filters --}}
<div class="erp-card mb-4">
    <div class="erp-card-header">
        <span class="erp-card-title">
            <i class="fas fa-filter me-2" style="color: #818cf8;"></i>ตัวกรอง
        </span>
    </div>
    <div class="erp-card-body">
        <form method="GET" action="{{ route('admin.activity-logs.index') }}" class="row g-3">
            <!-- Date From -->
            <div class="col-md-3">
                <label class="erp-label">วันที่เริ่มต้น</label>
                <input type="date" name="date_from" class="erp-input"
                    value="{{ request('date_from') }}">
            </div>

            <!-- Date To -->
            <div class="col-md-3">
                <label class="erp-label">วันที่สิ้นสุด</label>
                <input type="date" name="date_to" class="erp-input"
                    value="{{ request('date_to') }}">
            </div>

            <!-- User Filter -->
            @if(isset($users))
            <div class="col-md-3">
                <label class="erp-label">ผู้ใช้งาน</label>
                <select name="user_id" class="erp-select">
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
                <label class="erp-label">ประเภทการกระทำ</label>
                <select name="action_type" class="erp-select">
                    <option value="">-- ทั้งหมด --</option>
                    <option value="created" {{ request('action_type') == 'created' ? 'selected' : '' }}>สร้าง</option>
                    <option value="updated" {{ request('action_type') == 'updated' ? 'selected' : '' }}>แก้ไข</option>
                    <option value="deleted" {{ request('action_type') == 'deleted' ? 'selected' : '' }}>ลบ</option>
                </select>
            </div>

            <!-- Subject Type Filter -->
            @if(isset($subjectTypes))
            <div class="col-md-3">
                <label class="erp-label">ประเภทข้อมูล</label>
                <select name="subject_type" class="erp-select">
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
                <label class="erp-label">ชื่อ Log</label>
                <select name="log_name" class="erp-select">
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
                <label class="erp-label">ค้นหา</label>
                <input type="text" name="search" class="erp-input"
                    placeholder="ค้นหาจากคำอธิบาย..."
                    value="{{ request('search') }}">
            </div>

            <!-- Buttons -->
            <div class="col-12 d-flex gap-2 align-items-end">
                <button type="submit" class="erp-btn-primary">
                    <i class="fas fa-search me-1"></i> ค้นหา
                </button>
                <a href="{{ route('admin.activity-logs.index') }}" class="erp-btn-secondary">
                    <i class="fas fa-times me-1"></i> ล้างตัวกรอง
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Subject Info Banner --}}
@if(isset($subject) && $subject)
<div class="erp-alert erp-alert-info mb-4">
    <i class="fas fa-info-circle me-2"></i>
    <strong>แสดงบันทึกกิจกรรมของ {{ $subjectTypeName ?? class_basename($subject) }}:</strong>
    {{ $subject->name ?? $subject->employee_code ?? 'ID: ' . $subject->id }}
</div>
@endif

{{-- Activity Logs Table --}}
<div class="erp-card">
    <div class="erp-card-header">
        <span class="erp-card-title">
            <i class="fas fa-list-ul me-2" style="color: #818cf8;"></i>รายการบันทึกกิจกรรม
        </span>
        <span class="erp-badge" style="background: rgba(99,102,241,0.12); color: #818cf8;">
            {{ $activityLogs->total() }} รายการ
        </span>
    </div>
    <div class="erp-table-wrap">
        <table class="erp-table">
            <thead>
                <tr>
                    <th style="width: 50px;">ID</th>
                    <th style="width: 80px;">ประเภท</th>
                    <th>คำอธิบาย</th>
                    <th style="width: 180px;">ผู้ใช้งาน</th>
                    <th style="width: 150px;">ประเภทข้อมูล</th>
                    <th style="width: 160px;">วันที่-เวลา</th>
                    <th style="width: 80px;" class="text-center">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($activityLogs as $log)
                <tr>
                    <td style="color: var(--text-muted); font-size: 12px;">{{ $log->id }}</td>
                    <td>
                        @if($log->action_type === 'created')
                            <span class="erp-badge" style="background: rgba(52,211,153,0.12); color: #34d399;">
                                <i class="fas fa-plus me-1"></i>{{ $log->action_label }}
                            </span>
                        @elseif($log->action_type === 'updated')
                            <span class="erp-badge" style="background: rgba(56,189,248,0.12); color: #38bdf8;">
                                <i class="fas fa-edit me-1"></i>{{ $log->action_label }}
                            </span>
                        @elseif($log->action_type === 'deleted')
                            <span class="erp-badge" style="background: rgba(239,68,68,0.12); color: #f87171;">
                                <i class="fas fa-trash me-1"></i>{{ $log->action_label }}
                            </span>
                        @else
                            <span class="erp-badge" style="background: rgba(255,255,255,0.06); color: var(--text-muted);">
                                {{ $log->action_label }}
                            </span>
                        @endif
                    </td>
                    <td>
                        <div style="max-width: 400px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $log->description }}">
                            {{ $log->description }}
                        </div>
                    </td>
                    <td>
                        @if($log->user)
                        <div class="d-flex align-items-center gap-2">
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: rgba(99,102,241,0.12); color: #818cf8; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 600;">
                                {{ strtoupper(substr($log->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-size: 13px; font-weight: 500; color: var(--text-primary);">{{ $log->user->name }}</div>
                                <div style="font-size: 11px; color: var(--text-muted);">{{ $log->user->role }}</div>
                            </div>
                        </div>
                        @else
                        <span style="color: var(--text-muted); font-size: 12px;"><i class="fas fa-cog me-1"></i>ระบบ</span>
                        @endif
                    </td>
                    <td>
                        @if($log->subject_type)
                        <span class="erp-badge" style="background: rgba(255,255,255,0.06); color: var(--text-secondary);">
                            {{ class_basename($log->subject_type) }}
                        </span>
                        @else
                        <span style="color: var(--text-muted);">-</span>
                        @endif
                    </td>
                    <td>
                        <div style="font-size: 12px;">
                            <div style="color: var(--text-secondary);">{{ $log->created_at->format('d/m/Y') }}</div>
                            <div style="color: var(--text-muted);">{{ $log->created_at->format('H:i:s') }}</div>
                        </div>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.activity-logs.show', $log->id) }}"
                            class="erp-btn-secondary" style="padding: 4px 10px; font-size: 12px;" title="ดูรายละเอียด">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 60px 0; color: var(--text-muted);">
                        <i class="fas fa-clipboard-x" style="font-size: 32px; display: block; margin-bottom: 12px;"></i>
                        <div style="font-size: 14px; margin-bottom: 4px;">ไม่พบบันทึกกิจกรรม</div>
                        <div style="font-size: 12px;">ลองเปลี่ยนตัวกรองหรือค้นหาข้อมูลใหม่</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($activityLogs->hasPages())
        <div style="padding: 16px; border-top: 1px solid var(--border);">
            <div class="d-flex justify-content-between align-items-center">
                <div style="font-size: 13px; color: var(--text-secondary);">
                    แสดง <strong style="color: var(--text-primary);">{{ $activityLogs->firstItem() }}</strong> ถึง <strong style="color: var(--text-primary);">{{ $activityLogs->lastItem() }}</strong> จาก <strong style="color: var(--text-primary);">{{ $activityLogs->total() }}</strong> รายการ
                </div>
                {{ $activityLogs->links() }}
            </div>
        </div>
    @endif
</div>

@endsection
