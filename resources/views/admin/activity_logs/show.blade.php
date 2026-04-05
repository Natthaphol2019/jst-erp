@extends('layouts.app')

@section('title', 'รายละเอียดบันทึกกิจกรรม - JST ERP')

@section('content')
<div class="container-fluid py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.activity-logs.index') }}">
                    <i class="bi bi-clipboard2-pulse me-1"></i>บันทึกกิจกรรม
                </a>
            </li>
            <li class="breadcrumb-item active">รายละเอียด #{{ $activityLog->id }}</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h4 mb-1 text-dark">
                        <i class="bi bi-clipboard2-pulse me-2"></i>รายละเอียดบันทึกกิจกรรม
                    </h2>
                    <p class="text-muted mb-0">ID: {{ $activityLog->id }} | {{ $activityLog->created_at->format('d/m/Y H:i:s') }}</p>
                </div>
                <a href="{{ route('admin.activity-logs.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> กลับ
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Main Info -->
        <div class="col-lg-8">
            <!-- Activity Details -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-dark">
                        <i class="bi bi-info-circle me-2"></i>รายละเอียดกิจกรรม
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <label class="text-muted small fw-semibold">ประเภทการกระทำ</label>
                        </div>
                        <div class="col-sm-9">
                            <span class="badge {{ $activityLog->action_badge_class }} fs-6 px-3 py-2">
                                {{ $activityLog->action_label }}
                            </span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <label class="text-muted small fw-semibold">คำอธิบาย</label>
                        </div>
                        <div class="col-sm-9">
                            <p class="mb-0">{{ $activityLog->description }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <label class="text-muted small fw-semibold">ผู้ใช้งาน</label>
                        </div>
                        <div class="col-sm-9">
                            @if($activityLog->user)
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                                    style="width: 40px; height: 40px; font-size: 1rem;">
                                    {{ strtoupper(substr($activityLog->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $activityLog->user->name }}</div>
                                    <div class="text-muted small">บทบาท: {{ $activityLog->user->role }}</div>
                                </div>
                            </div>
                            @else
                            <span class="text-muted"><i class="bi bi-gear me-1"></i>ระบบ (System)</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <label class="text-muted small fw-semibold">ประเภทข้อมูล</label>
                        </div>
                        <div class="col-sm-9">
                            @if($activityLog->subject_type)
                            <span class="badge bg-light text-dark">{{ class_basename($activityLog->subject_type) }}</span>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <label class="text-muted small fw-semibold">วันที่-เวลา</label>
                        </div>
                        <div class="col-sm-9">
                            <span class="fw-semibold">{{ $activityLog->created_at->format('d/m/Y H:i:s') }}</span>
                            <span class="text-muted ms-2">({{ $activityLog->created_at->diffForHumans() }})</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Before/After Comparison (for updates) -->
            @if($activityLog->action_type === 'updated' && $activityLog->properties)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-dark">
                        <i class="bi bi-arrow-left-right me-2"></i>การเปลี่ยนแปลงข้อมูล
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead class="table-light">
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
                                    <td class="fw-semibold">{{ ucfirst(str_replace('_', ' ', $key)) }}</td>
                                    <td>
                                        @if(isset($oldValues[$key]))
                                            @if(is_null($oldValues[$key]))
                                                <span class="text-muted">(ว่าง)</span>
                                            @elseif(is_bool($oldValues[$key]))
                                                <span class="badge {{ $oldValues[$key] ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $oldValues[$key] ? 'ใช่' : 'ไม่ใช่' }}
                                                </span>
                                            @else
                                                <code>{{ $oldValues[$key] }}</code>
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($newValues[$key]))
                                            @if(is_null($newValues[$key]))
                                                <span class="text-muted">(ว่าง)</span>
                                            @elseif(is_bool($newValues[$key]))
                                                <span class="badge {{ $newValues[$key] ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $newValues[$key] ? 'ใช่' : 'ไม่ใช่' }}
                                                </span>
                                            @else
                                                <code>{{ $newValues[$key] }}</code>
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <!-- Record Data (for create/delete) -->
            @if(in_array($activityLog->action_type, ['created', 'deleted']) && $activityLog->properties)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-dark">
                        <i class="bi bi-database me-2"></i>ข้อมูลบันทึก
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead class="table-light">
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
                                    <td class="fw-semibold">{{ ucfirst(str_replace('_', ' ', $key)) }}</td>
                                    <td>
                                        @if(is_null($value))
                                            <span class="text-muted">(ว่าง)</span>
                                        @elseif(is_bool($value))
                                            <span class="badge {{ $value ? 'bg-success' : 'bg-danger' }}">
                                                {{ $value ? 'ใช่' : 'ไม่ใช่' }}
                                            </span>
                                        @elseif(is_array($value) || is_object($value))
                                            <code>{{ json_encode($value) }}</code>
                                        @else
                                            <code>{{ $value }}</code>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Subject Info -->
            @if($activityLog->subject)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-dark">
                        <i class="bi bi-link-45deg me-2"></i>ข้อมูลที่เกี่ยวข้อง
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                            style="width: 40px; height: 40px;">
                            <i class="bi bi-file-earmark"></i>
                        </div>
                        <div>
                            <div class="fw-semibold">
                                {{ $activityLog->subject->name ?? $activityLog->subject->employee_code ?? 'ID: ' . $activityLog->subject_id }}
                            </div>
                            <div class="text-muted small">{{ class_basename($activityLog->subject) }}</div>
                        </div>
                    </div>
                    <a href="{{ $activityLog->subject ? routeForSubject($activityLog->subject) : '#' }}"
                        class="btn btn-sm btn-outline-primary w-100"
                        {{ !$activityLog->subject ? 'disabled' : '' }}>
                        <i class="bi bi-box-arrow-up-right me-1"></i> ไปที่ข้อมูล
                    </a>
                </div>
            </div>
            @endif

            <!-- Related Activity Logs -->
            @if(isset($relatedLogs) && $relatedLogs->count() > 0)
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-dark">
                        <i class="bi bi-clock-history me-2"></i>ประวัติกิจกรรมที่เกี่ยวข้อง
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($relatedLogs as $relatedLog)
                        <a href="{{ route('admin.activity-logs.show', $relatedLog->id) }}"
                            class="list-group-item list-group-item-action px-3 py-3">
                            <div class="d-flex align-items-center mb-1">
                                <span class="badge {{ $relatedLog->action_badge_class }} me-2">
                                    {{ $relatedLog->action_label }}
                                </span>
                                <small class="text-muted">{{ $relatedLog->created_at->diffForHumans() }}</small>
                            </div>
                            <div class="small text-truncate">{{ $relatedLog->description }}</div>
                            <div class="text-muted small mt-1">
                                <i class="bi bi-person me-1"></i>{{ $relatedLog->user?->name ?? 'ระบบ' }}
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer bg-white py-2 text-center">
                    <a href="{{ route('admin.activity-logs.index', ['subject_type' => $activityLog->subject_type, 'subject_type_filter' => class_basename($activityLog->subject_type)]) }}"
                        class="text-decoration-none small">
                        ดูทั้งหมด <i class="bi bi-arrow-right"></i>
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
