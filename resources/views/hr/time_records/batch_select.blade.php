@extends('layouts.app')
@section('title', 'เลือกช่วงบันทึกเวลา')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold m-0 text-primary">⏱️ เลือกรอบตอกบัตร (Batch Select)</h2>
            <small class="text-muted">เลือกรอบวันที่และแผนก เพื่อเข้าสู่การบันทึกเวลาแบบละเอียด (เช้า/บ่าย/OT)</small>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm"><i class="bi bi-x-circle-fill"></i> {{ session('error') }}</div>
    @endif

    <div class="card shadow-sm border-0 mb-4 bg-white">
        <div class="card-body p-4">
            <form action="{{ route('hr.time-records.batch.select') }}" method="GET" id="filterForm">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">📅 ช่วงวันที่บันทึกเวลา</label>
                        <div class="input-group shadow-sm">
                            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $start_date }}" required onchange="handleAutoSubmit()">
                            <span class="input-group-text bg-light">ถึง</span>
                            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $end_date }}" required onchange="handleAutoSubmit()">
                        </div>
                        <div class="mt-2 d-flex gap-2 flex-wrap">
                            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill" onclick="setDateRange('today')">วันต่อวัน</button>
                            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill" onclick="setDateRange('week')">1 สัปดาห์</button>
                            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill" onclick="setDateRange('half1')">ครึ่งเดือนแรก</button>
                            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill" onclick="setDateRange('half2')">ครึ่งเดือนหลัง</button>
                            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill" onclick="setDateRange('month')">ทั้งเดือน</button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">🏢 เลือกแผนก</label>
                        <select name="department_id" class="form-select shadow-sm" onchange="handleAutoSubmit()">
                            <option value="">-- เลือกแผนก --</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ $department_id == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted d-block mt-2" id="loadingText" style="display: none !important;">
                            <span class="spinner-border spinner-border-sm text-primary" role="status" aria-hidden="true"></span> กำลังโหลดข้อมูล...
                        </small>
                    </div>
                    </div>
            </form>
        </div>
    </div>

    @if($department_id && $employees->isNotEmpty())
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white py-3 border-bottom border-2 border-primary">
                <h5 class="m-0 fw-bold text-dark">ภาพรวมการบันทึกเวลาของแผนก : {{ $employees->first()->department->name }}</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="ps-4">รหัสพนักงาน</th>
                                <th>ชื่อ - นามสกุล</th>
                                <th class="text-center">บันทึกไปแล้ว (วัน)</th>
                                <th class="text-center">สถานะ</th>
                                <th class="text-center">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employees as $emp)
                                <tr>
                                    <td class="ps-4 text-muted">{{ $emp->employee_code }}</td>
                                    <td class="fw-bold text-dark">
                                        {{ $emp->prefix }}{{ $emp->firstname }} {{ $emp->lastname }}
                                    </td>
                                    <td class="text-center fs-5 fw-bold {{ $emp->time_records_count > 0 ? 'text-success' : 'text-muted' }}">
                                        {{ $emp->time_records_count }}
                                    </td>
                                    <td class="text-center">
                                        @if($emp->time_records_count > 0)
                                            <span class="badge bg-success shadow-sm px-3 py-2"><i class="bi bi-check-circle"></i> มีข้อมูลแล้ว</span>
                                        @else
                                            <span class="badge bg-danger shadow-sm px-3 py-2"><i class="bi bi-exclamation-circle"></i> ยังไม่บันทึก</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('hr.time-records.batch.form', ['employee_id' => $emp->id, 'start_date' => $start_date, 'end_date' => $end_date]) }}" class="btn btn-sm btn-primary px-4 shadow-sm fw-bold rounded-pill action-btn">
                                            📝 คีย์ข้อมูลเวลา
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @elseif($department_id)
        <div class="alert alert-warning text-center mt-4 shadow-sm py-4 border-0">
            <h5 class="mb-0 text-dark">📭 ไม่พบพนักงานในแผนกที่เลือก</h5>
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