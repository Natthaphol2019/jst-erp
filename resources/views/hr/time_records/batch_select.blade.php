@extends('layouts.app')
@section('title', 'เลือกช่วงบันทึกเวลา')

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
                <i class="fas fa-clock me-2" style="color: #818cf8;"></i>เลือกรอบตอกบัตร (Batch Select)
            </h4>
            <p style="font-size: 13px; color: var(--text-muted); margin: 0;">เลือกรอบวันที่และแผนก เพื่อเข้าสู่การบันทึกเวลาแบบละเอียด (เช้า/บ่าย/OT)</p>
        </div>
    </div>

    @if(session('success'))
        <div class="erp-alert erp-alert-success mb-4">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="erp-alert erp-alert-danger mb-4">
            <i class="fas fa-times-circle me-2"></i>{{ session('error') }}
        </div>
    @endif

    {{-- Filter Form --}}
    <div class="erp-card mb-4">
        <div class="erp-card-body">
            <form action="{{ route('hr.time-records.batch.select') }}" method="GET" id="filterForm">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="erp-label"><i class="fas fa-calendar me-1"></i>ช่วงวันที่บันทึกเวลา</label>
                        <div class="d-flex gap-2 mb-2">
                            <input type="date" name="start_date" id="start_date" class="erp-input" value="{{ $start_date }}" required onchange="handleAutoSubmit()">
                            <span class="d-flex align-items-center" style="color: var(--text-secondary);">ถึง</span>
                            <input type="date" name="end_date" id="end_date" class="erp-input" value="{{ $end_date }}" required onchange="handleAutoSubmit()">
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            <button type="button" class="erp-btn-secondary" style="font-size: 11px; padding: 4px 12px;" onclick="setDateRange('today')">วันต่อวัน</button>
                            <button type="button" class="erp-btn-secondary" style="font-size: 11px; padding: 4px 12px;" onclick="setDateRange('week')">1 สัปดาห์</button>
                            <button type="button" class="erp-btn-secondary" style="font-size: 11px; padding: 4px 12px;" onclick="setDateRange('half1')">ครึ่งเดือนแรก</button>
                            <button type="button" class="erp-btn-secondary" style="font-size: 11px; padding: 4px 12px;" onclick="setDateRange('half2')">ครึ่งเดือนหลัง</button>
                            <button type="button" class="erp-btn-secondary" style="font-size: 11px; padding: 4px 12px;" onclick="setDateRange('month')">ทั้งเดือน</button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="erp-label"><i class="fas fa-building me-1"></i>เลือกแผนก</label>
                        <select name="department_id" class="erp-select" onchange="handleAutoSubmit()">
                            <option value="">-- เลือกแผนก --</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ $department_id == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                            @endforeach
                        </select>
                        <small class="d-block mt-2" style="color: var(--text-muted); display: none !important;" id="loadingText">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> กำลังโหลดข้อมูล...
                        </small>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if($department_id && $employees->isNotEmpty())
        <div class="erp-card rounded-3">
            <div class="erp-card-header">
                <span class="erp-card-title">
                    <i class="fas fa-users me-2" style="color: #818cf8;"></i>ภาพรวมการบันทึกเวลาของแผนก : {{ $employees->first()->department->name }}
                </span>
            </div>
            <div class="erp-table-wrap">
                <table class="erp-table">
                    <thead>
                        <tr>
                            <th class="text-start">รหัสพนักงาน</th>
                            <th class="text-start">ชื่อ - นามสกุล</th>
                            <th class="text-center">บันทึกไปแล้ว (วัน)</th>
                            <th class="text-center">สถานะ</th>
                            <th class="text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $emp)
                            <tr>
                                <td class="text-start" style="color: var(--text-muted);">{{ $emp->employee_code }}</td>
                                <td class="text-start" style="color: var(--text-primary);">
                                    {{ $emp->prefix }}{{ $emp->firstname }} {{ $emp->lastname }}
                                </td>
                                <td class="text-center fs-5 fw-bold {{ $emp->time_records_count > 0 ? '' : '' }}" style="color: {{ $emp->time_records_count > 0 ? '#34d399' : 'var(--text-muted)' }};">
                                    {{ $emp->time_records_count }}
                                </td>
                                <td class="text-center">
                                    @if($emp->time_records_count > 0)
                                        <span class="erp-badge" style="background: rgba(52,211,153,0.12); color: #34d399;">
                                            <i class="fas fa-check-circle me-1"></i>มีข้อมูลแล้ว
                                        </span>
                                    @else
                                        <span class="erp-badge" style="background: rgba(239,68,68,0.12); color: #f87171;">
                                            <i class="fas fa-exclamation-circle me-1"></i>ยังไม่บันทึก
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('hr.time-records.batch.form', ['employee_id' => $emp->id, 'start_date' => $start_date, 'end_date' => $end_date]) }}" class="erp-btn-primary px-4 action-btn">
                                        <i class="fas fa-edit me-1"></i>คีย์ข้อมูลเวลา
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @elseif($department_id)
        <div class="erp-alert erp-alert-warning text-center mt-4 py-4">
            <i class="fas fa-inbox me-2"></i>ไม่พบพนักงานในแผนกที่เลือก
        </div>
    @endif
</div>

<script>
    // ฟังก์ชันจัดการ Auto-Submit และป้องกันบัค
    function handleAutoSubmit() {
        // 1. ปิดการคลิกปุ่ม "คีย์ข้อมูลเวลา" ทันทีที่มีการเปลี่ยนเงื่อนไข เพื่อป้องกันการส่ง Parameter ผิด
        document.querySelectorAll('.action-btn').forEach(btn => {
            btn.classList.add('disabled');
            btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> รอสักครู่...';
        });

        // 2. แสดงข้อความกำลังโหลด
        document.getElementById('loadingText').style.setProperty('display', 'block', 'important');

        // 3. ส่งฟอร์ม
        document.getElementById('filterForm').submit();
    }

    function setDateRange(type) {
        const today = new Date();
        const y = today.getFullYear();
        const m = String(today.getMonth() + 1).padStart(2, '0');
        const d = String(today.getDate()).padStart(2, '0');
        const todayStr = `${y}-${m}-${d}`;
        let start = todayStr, end = todayStr;

        if (type === 'today') { start = todayStr; end = todayStr; }
        else if (type === 'week') {
            let lastWeek = new Date(); lastWeek.setDate(today.getDate() - 6);
            start = `${lastWeek.getFullYear()}-${String(lastWeek.getMonth()+1).padStart(2,'0')}-${String(lastWeek.getDate()).padStart(2,'0')}`;
        }
        else if (type === 'half1') { start = `${y}-${m}-01`; end = `${y}-${m}-15`; }
        else if (type === 'half2') {
            start = `${y}-${m}-16`;
            let lastDay = new Date(y, today.getMonth() + 1, 0).getDate();
            end = `${y}-${m}-${lastDay}`;
        }
        else if (type === 'month') {
            start = `${y}-${m}-01`;
            let lastDay = new Date(y, today.getMonth() + 1, 0).getDate();
            end = `${y}-${m}-${lastDay}`;
        }

        document.getElementById('start_date').value = start;
        document.getElementById('end_date').value = end;

        // เรียกใช้ handleAutoSubmit แทนการ submit ตรงๆ
        handleAutoSubmit();
    }
</script>
@endsection
