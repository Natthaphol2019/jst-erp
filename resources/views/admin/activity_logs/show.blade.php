@extends('layouts.app')

@section('title', 'รายละเอียดบันทึกกิจกรรม - JST ERP')

@section('content')

{{-- Page Header --}}
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            <i class="fas fa-clipboard-check me-2" style="color: #818cf8;"></i>รายละเอียดบันทึกกิจกรรม
        </h4>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">ID: {{ $activityLog->id }} | {{ $activityLog->created_at->format('d/m/Y H:i:s') }}</p>
    </div>
    <a href="{{ route('admin.activity-logs.index') }}" class="erp-btn-secondary">
        <i class="fas fa-arrow-left me-1"></i> กลับ
    </a>
</div>

{{-- Breadcrumb --}}
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb" style="background: var(--bg-surface); border: 1px solid var(--border); border-radius: 8px; padding: 8px 16px;">
        <li class="breadcrumb-item">
            <a href="{{ route('admin.activity-logs.index') }}" style="color: var(--text-secondary); text-decoration: none;">
                <i class="fas fa-clipboard-check me-1"></i>บันทึกกิจกรรม
            </a>
        </li>
        <li class="breadcrumb-item active" style="color: var(--text-muted);">รายละเอียด #{{ $activityLog->id }}</li>
    </ol>
</nav>

<div class="row g-3">
    <!-- Main Info -->
    <div class="col-lg-8">
        <!-- Activity Details -->
        <div class="erp-card mb-4">
            <div class="erp-card-header">
                <span class="erp-card-title">
                    <i class="fas fa-info-circle me-2" style="color: #818cf8;"></i>รายละเอียดกิจกรรม
                </span>
            </div>
            <div class="erp-card-body">
                <div class="mb-3" style="display: grid; grid-template-columns: 160px 1fr; gap: 8px; align-items: start;">
                    <label style="font-size: 12px; font-weight: 600; color: var(--text-muted);">ประเภทการกระทำ</label>
                    <div>
                        <span class="erp-badge {{ $activityLog->action_badge_class }} fs-6 px-3 py-2">
                            {{ $activityLog->action_label }}
                        </span>
                    </div>
                </div>

                <div class="mb-3" style="display: grid; grid-template-columns: 160px 1fr; gap: 8px; align-items: start;">
                    <label style="font-size: 12px; font-weight: 600; color: var(--text-muted);">คำอธิบาย</label>
                    <div>
                        <p style="margin: 0; color: var(--text-secondary);">{{ $activityLog->description }}</p>
                    </div>
                </div>

                <div class="mb-3" style="display: grid; grid-template-columns: 160px 1fr; gap: 8px; align-items: start;">
                    <label style="font-size: 12px; font-weight: 600; color: var(--text-muted);">ผู้ใช้งาน</label>
                    <div>
                        @if($activityLog->user)
                        <div class="d-flex align-items-center gap-2">
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: rgba(99,102,241,0.12); color: #818cf8; display: flex; align-items: center; justify-content: center; font-size: 1rem; font-weight: 600;">
                                {{ strtoupper(substr($activityLog->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-size: 13px; font-weight: 500; color: var(--text-primary);">{{ $activityLog->user->name }}</div>
                                <div style="font-size: 11px; color: var(--text-muted);">บทบาท: {{ $activityLog->user->role }}</div>
                            </div>
                        </div>
                        @else
                        <span style="color: var(--text-muted);"><i class="fas fa-cog me-1"></i>ระบบ (System)</span>
                        @endif
                    </div>
                </div>

                <div class="mb-3" style="display: grid; grid-template-columns: 160px 1fr; gap: 8px; align-items: start;">
                    <label style="font-size: 12px; font-weight: 600; color: var(--text-muted);">ประเภทข้อมูล</label>
                    <div>
                        @if($activityLog->subject_type)
                        <span class="erp-badge" style="background: var(--input-bg); color: var(--text-secondary);">{{ class_basename($activityLog->subject_type) }}</span>
                        @else
                        <span style="color: var(--text-muted);">-</span>
                        @endif
                    </div>
                </div>

                <div class="mb-3" style="display: grid; grid-template-columns: 160px 1fr; gap: 8px; align-items: start;">
                    <label style="font-size: 12px; font-weight: 600; color: var(--text-muted);">วันที่-เวลา</label>
                    <div>
                        <span style="font-weight: 600; color: var(--text-primary);">{{ $activityLog->created_at->format('d/m/Y H:i:s') }}</span>
                        <span style="color: var(--text-muted); margin-left: 8px;">({{ $activityLog->created_at->diffForHumans() }})</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Before/After Comparison (for updates) -->
        @if($activityLog->action_type === 'updated' && $activityLog->properties)
        <div class="erp-card mb-4">
            <div class="erp-card-header">
                <span class="erp-card-title">
                    <i class="fas fa-exchange-alt me-2" style="color: #818cf8;"></i>การเปลี่ยนแปลงข้อมูล
                </span>
            </div>
            <div class="erp-table-wrap">
                <table class="erp-table">
                    <thead>
                        <tr>
                            <th style="width: 200px;">ฟิลด์</th>
                            <th style="width: 40%;">ค่าเดิม (Before)</th>
                            <th style="width: 40%;">ค่าใหม่ (After)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $oldValues = $activityLog->properties['old'] ?? [];
                            $newValues = $activityLog->properties['attributes'] ?? [];
                            $allKeys = array_unique(array_merge(array_keys($oldValues), array_keys($newValues)));
                        @endphp
                        @foreach($allKeys as $key)
                        @if(isset($oldValues[$key]) || isset($newValues[$key]))
                        <tr>
                            <td style="font-weight: 600; color: var(--text-secondary);">{{ ucfirst(str_replace('_', ' ', $key)) }}</td>
                            <td>
                                @if(isset($oldValues[$key]))
                                    @if(is_null($oldValues[$key]))
                                        <span style="color: var(--text-muted);">(ว่าง)</span>
                                    @elseif(is_bool($oldValues[$key]))
                                        <span class="erp-badge" style="background: {{ $oldValues[$key] ? 'rgba(52,211,153,0.12)' : 'rgba(239,68,68,0.12)' }}; color: {{ $oldValues[$key] ? '#34d399' : '#f87171' }};">
                                            {{ $oldValues[$key] ? 'ใช่' : 'ไม่ใช่' }}
                                        </span>
                                    @else
                                        <code style="color: var(--text-secondary);">{{ $oldValues[$key] }}</code>
                                    @endif
                                @else
                                    <span style="color: var(--text-muted);">-</span>
                                @endif
                            </td>
                            <td>
                                @if(isset($newValues[$key]))
                                    @if(is_null($newValues[$key]))
                                        <span style="color: var(--text-muted);">(ว่าง)</span>
                                    @elseif(is_bool($newValues[$key]))
                                        <span class="erp-badge" style="background: {{ $newValues[$key] ? 'rgba(52,211,153,0.12)' : 'rgba(239,68,68,0.12)' }}; color: {{ $newValues[$key] ? '#34d399' : '#f87171' }};">
                                            {{ $newValues[$key] ? 'ใช่' : 'ไม่ใช่' }}
                                        </span>
                                    @else
                                        <code style="color: var(--text-secondary);">{{ $newValues[$key] }}</code>
                                    @endif
                                @else
                                    <span style="color: var(--text-muted);">-</span>
                                @endif
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Record Data (for create/delete) -->
        @if(in_array($activityLog->action_type, ['created', 'deleted']) && $activityLog->properties)
        <div class="erp-card mb-4">
            <div class="erp-card-header">
                <span class="erp-card-title">
                    <i class="fas fa-database me-2" style="color: #818cf8;"></i>ข้อมูลบันทึก
                </span>
            </div>
            <div class="erp-table-wrap">
                <table class="erp-table">
                    <thead>
                        <tr>
                            <th style="width: 200px;">ฟิลด์</th>
                            <th>ค่า</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $attributes = $activityLog->properties['attributes'] ?? [];
                        @endphp
                        @foreach($attributes as $key => $value)
                        <tr>
                            <td style="font-weight: 600; color: var(--text-secondary);">{{ ucfirst(str_replace('_', ' ', $key)) }}</td>
                            <td>
                                @if(is_null($value))
                                    <span style="color: var(--text-muted);">(ว่าง)</span>
                                @elseif(is_bool($value))
                                    <span class="erp-badge" style="background: {{ $value ? 'rgba(52,211,153,0.12)' : 'rgba(239,68,68,0.12)' }}; color: {{ $value ? '#34d399' : '#f87171' }};">
                                        {{ $value ? 'ใช่' : 'ไม่ใช่' }}
                                    </span>
                                @elseif(is_array($value) || is_object($value))
                                    <code style="color: var(--text-secondary);">{{ json_encode($value) }}</code>
                                @else
                                    <code style="color: var(--text-secondary);">{{ $value }}</code>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Subject Info -->
        @if($activityLog->subject)
        <div class="erp-card mb-4">
            <div class="erp-card-header">
                <span class="erp-card-title">
                    <i class="fas fa-link me-2" style="color: #818cf8;"></i>ข้อมูลที่เกี่ยวข้อง
                </span>
            </div>
            <div class="erp-card-body">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: rgba(56,189,248,0.12); color: #38bdf8; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-file-earmark"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight: 500; color: var(--text-primary);">
                            {{ $activityLog->subject->name ?? $activityLog->subject->employee_code ?? 'ID: ' . $activityLog->subject_id }}
                        </div>
                        <div style="font-size: 11px; color: var(--text-muted);">{{ class_basename($activityLog->subject) }}</div>
                    </div>
                </div>
                <a href="{{ $activityLog->subject ? routeForSubject($activityLog->subject) : '#' }}"
                    class="erp-btn-secondary w-100 text-center"
                    {{ !$activityLog->subject ? 'disabled' : '' }}
                    style="padding: 6px 12px; font-size: 13px;">
                    <i class="fas fa-external-link-alt me-1"></i> ไปที่ข้อมูล
                </a>
            </div>
        </div>
        @endif

        <!-- Related Activity Logs -->
        @if(isset($relatedLogs) && $relatedLogs->count() > 0)
        <div class="erp-card">
            <div class="erp-card-header">
                <span class="erp-card-title">
                    <i class="fas fa-history me-2" style="color: #818cf8;"></i>ประวัติกิจกรรมที่เกี่ยวข้อง
                </span>
            </div>
            <div class="erp-card-body" style="padding: 0;">
                @foreach($relatedLogs as $relatedLog)
                <a href="{{ route('admin.activity-logs.show', $relatedLog->id) }}"
                    style="display: block; padding: 12px 16px; text-decoration: none; border-bottom: 1px solid var(--border); transition: background 0.15s;"
                    onmouseover="this.style.background='var(--input-bg)'"
                    onmouseout="this.style.background='transparent'">
                    <div class="d-flex align-items-center mb-1">
                        <span class="erp-badge {{ $relatedLog->action_badge_class }} me-2">
                            {{ $relatedLog->action_label }}
                        </span>
                        <small style="color: var(--text-muted);">{{ $relatedLog->created_at->diffForHumans() }}</small>
                    </div>
                    <div style="font-size: 13px; color: var(--text-secondary); overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $relatedLog->description }}</div>
                    <div style="font-size: 11px; color: var(--text-muted); margin-top: 4px;">
                        <i class="fas fa-user me-1"></i>{{ $relatedLog->user?->name ?? 'ระบบ' }}
                    </div>
                </a>
                @endforeach
            </div>
            <div style="padding: 10px 16px; border-top: 1px solid var(--border); text-align: center;">
                <a href="{{ route('admin.activity-logs.index', ['subject_type' => $activityLog->subject_type, 'subject_type_filter' => class_basename($activityLog->subject_type)]) }}"
                    style="text-decoration: none; font-size: 13px; color: var(--text-secondary);">
                    ดูทั้งหมด <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
</div>
@endsection

@php
/**
 * Helper function to generate route for subject
 */
function routeForSubject($subject) {
    $class = class_basename($subject);
    $id = $subject->id;

    return match($class) {
        'Employee' => route('hr.employees.show', $id),
        'Department' => route('hr.departments.show', $id),
        'Position' => route('hr.positions.show', $id),
        'Item' => route('inventory.items.show', $id),
        'ItemCategory' => route('inventory.categories.show', $id),
        'Requisition' => route('inventory.requisition.show', $id),
        default => '#',
    };
}
@endphp
