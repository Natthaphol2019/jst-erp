@extends('layouts.app')

@section('title', 'ประวัติแก้ไขเวลา - JST ERP')

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            <i class="fas fa-history me-2" style="color: #818cf8;"></i>ประวัติการแก้ไขเวลาทำงาน
        </h4>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">ตรวจสอบการเปลี่ยนแปลงข้อมูลเวลา (Read-only)</p>
    </div>
</div>

{{-- Filter Bar --}}
<div class="erp-card mb-3">
    <div class="erp-card-body" style="padding: 12px 18px;">
        <form method="GET" action="{{ route('hr.time-records.logs') }}">
            <div class="row g-2 align-items-end">
                <div class="col-auto">
                    <label class="erp-label" style="margin-bottom: 0;">พนักงาน</label>
                    <select name="employee_id" class="erp-select" style="min-width: 200px;">
                        <option value="">-- ทั้งหมด --</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}" {{ $employee_id == $emp->id ? 'selected' : '' }}>
                                {{ $emp->employee_code }} - {{ $emp->firstname }} {{ $emp->lastname }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-auto">
                    <label class="erp-label" style="margin-bottom: 0;">จากวันที่</label>
                    <input type="date" name="start_date" class="erp-input" value="{{ $start_date }}">
                </div>
                <div class="col-auto">
                    <label class="erp-label" style="margin-bottom: 0;">ถึงวันที่</label>
                    <input type="date" name="end_date" class="erp-input" value="{{ $end_date }}">
                </div>
                <div class="col-auto">
                    <button type="submit" class="erp-btn-primary">
                        <i class="fas fa-search me-1"></i>ค้นหา
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Logs Table --}}
<div class="erp-card">
    <div class="erp-table-wrap">
        <table class="erp-table">
            <thead>
                <tr>
                    <th style="width: 140px;">วันที่-เวลาแก้ไข</th>
                    <th>พนักงาน</th>
                    <th style="width: 100px;">วันที่ทำงาน</th>
                    <th style="width: 80px;">ประเภท</th>
                    <th>ข้อมูลเก่า</th>
                    <th>ข้อมูลใหม่</th>
                    <th>เหตุผล</th>
                    <th style="width: 120px;">ผู้แก้ไข</th>
                </tr>
            </thead>
            <tbody>
                @forelse($query as $log)
                    <tr>
                        <td style="font-size: 12px; color: var(--text-muted);">
                            <i class="fas fa-clock me-1"></i>{{ $log->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td>
                            @if($log->timeRecord && $log->timeRecord->employee)
                                <div style="font-size: 12px;">
                                    <strong>{{ $log->timeRecord->employee->employee_code }}</strong><br>
                                    <span style="color: var(--text-secondary);">{{ $log->timeRecord->employee->firstname }}</span>
                                </div>
                            @else
                                <span style="color: var(--text-muted);">-</span>
                            @endif
                        </td>
                        <td style="font-size: 12px;">
                            {{ $log->timeRecord ? \Carbon\Carbon::parse($log->timeRecord->work_date)->format('d/m/Y') : '-' }}
                        </td>
                        <td>
                            @if($log->action === 'create')
                                <span class="erp-badge" style="background: rgba(52,211,153,0.12); color: #34d399;">
                                    <i class="fas fa-plus me-1"></i>สร้างใหม่
                                </span>
                            @else
                                <span class="erp-badge" style="background: rgba(251,191,36,0.12); color: #fbbf24;">
                                    <i class="fas fa-edit me-1"></i>แก้ไข
                                </span>
                            @endif
                        </td>
                        <td style="font-size: 11px;">
                            @if($log->old_data)
                                @php
                                    $old = json_decode($log->old_data, true);
                                @endphp
                                <div style="max-width: 200px;">
                                    @if(isset($old['status']))
                                        <div><strong>สถานะ:</strong> {{ $old['status'] }}</div>
                                    @endif
                                    @if(isset($old['details']) && is_array($old['details']))
                                        @foreach($old['details'] as $detail)
                                            <div style="margin-top: 4px;">
                                                <strong>{{ $detail['period'] }}:</strong><br>
                                                {{ $detail['in'] ?? '-' }} → {{ $detail['out'] ?? '-' }}
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            @else
                                <span style="color: var(--text-muted);">-</span>
                            @endif
                        </td>
                        <td style="font-size: 11px;">
                            @if($log->new_data)
                                @php
                                    $new = json_decode($log->new_data, true);
                                @endphp
                                <div style="max-width: 200px;">
                                    @if(isset($new['status']))
                                        <div><strong>สถานะ:</strong> {{ $new['status'] }}</div>
                                    @endif
                                    @if(isset($new['details']) && is_array($new['details']))
                                        @foreach($new['details'] as $detail)
                                            <div style="margin-top: 4px;">
                                                <strong>{{ $detail['period'] }}:</strong><br>
                                                {{ $detail['in'] ?? '-' }} → {{ $detail['out'] ?? '-' }}
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            @else
                                <span style="color: var(--text-muted);">-</span>
                            @endif
                        </td>
                        <td style="font-size: 12px; color: var(--text-secondary);">
                            {{ $log->reason ?: '-' }}
                        </td>
                        <td style="font-size: 12px;">
                            @if($log->changedBy)
                                <div>
                                    <strong style="color: var(--text-primary);">{{ $log->changedBy->name }}</strong><br>
                                    <span style="color: var(--text-muted);">{{ $log->changedBy->role }}</span>
                                </div>
                            @else
                                <span style="color: var(--text-muted);">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <div class="erp-empty">
                                <i class="fas fa-clipboard-list"></i>
                                <div>ไม่พบประวัติการแก้ไข</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($query->hasPages())
        <div style="padding: 16px; border-top: 1px solid var(--border);">
            <div class="d-flex justify-content-between align-items-center">
                <div style="font-size: 13px; color: var(--text-secondary);">
                    แสดง <strong style="color: var(--text-primary);">{{ $query->firstItem() }}</strong> ถึง <strong style="color: var(--text-primary);">{{ $query->lastItem() }}</strong> จาก <strong style="color: var(--text-primary);">{{ $query->total() }}</strong> รายการ
                </div>
                {{ $query->links() }}
            </div>
        </div>
    @endif
</div>

@endsection
