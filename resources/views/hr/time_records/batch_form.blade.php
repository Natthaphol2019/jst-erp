@extends('layouts.app')
@section('title', 'ฟอร์มบันทึกเวลา')

<style>
    .table-compact th, .table-compact td { padding: 0.4rem; vertical-align: middle; }
    .time-format-input { width: 100%; min-width: 55px; text-align: center; padding: 4px; font-size: 0.9rem; }
    .bg-morning { background: rgba(99,102,241,0.05) !important; }
    .bg-afternoon { background: rgba(251,191,36,0.05) !important; }
    .bg-ot { background: rgba(167,139,250,0.05) !important; }
</style>

@php
    function formatThaiDate($date) {
        if (!$date) return '-';
        $months = ['', 'ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
        $time = strtotime($date);
        return date('j', $time) . " " . $months[date('n', $time)] . " " . (date('Y', $time) + 543);
    }
@endphp

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
                <i class="fas fa-clock me-2" style="color: #818cf8;"></i>ฟอร์มบันทึกเวลา (เช้า-บ่าย-OT)
            </h4>
            <p style="font-size: 13px; color: var(--text-muted); margin: 0;">วันที่ {{ formatThaiDate($start_date) }} ถึง {{ formatThaiDate($end_date) }}</p>
        </div>
        <a href="{{ route('hr.time-records.batch.select', ['department_id' => $employee->department_id, 'start_date' => $start_date, 'end_date' => $end_date]) }}" class="erp-btn-secondary rounded-pill px-4">
            <i class="fas fa-arrow-left me-2"></i>กลับหน้าเลือกพนักงาน
        </a>
    </div>

    <form action="{{ route('hr.time-records.batch.store') }}" method="POST">
        @csrf
        <input type="hidden" name="employee_id" value="{{ $employee->id }}">
        <input type="hidden" name="start_date" value="{{ $start_date }}">
        <input type="hidden" name="end_date" value="{{ $end_date }}">

        <div class="erp-card rounded-3 mb-5">
            <div class="erp-card-header d-flex justify-content-between align-items-center">
                <span class="erp-card-title">
                    <i class="fas fa-user me-2" style="color: #818cf8;"></i>{{ $employee->employee_code }} : {{ $employee->prefix }}{{ $employee->firstname }} {{ $employee->lastname }}
                </span>
                <div class="d-flex gap-2">
                    <button type="button" class="erp-btn-secondary" style="background: rgba(251,191,36,0.12); color: #fbbf24; border: 1px solid rgba(251,191,36,0.2);" onclick="window.fillEmpNormal('{{ $employee->id }}')">
                        <i class="fas fa-bolt me-1"></i>เติม "มาปกติ" ทุกช่องว่าง
                    </button>
                    <button type="button" class="erp-btn-secondary" onclick="window.clearAll()">
                        <i class="fas fa-eraser me-1"></i>ล้างข้อมูลบนจอ
                    </button>
                </div>
            </div>

            <div class="erp-table-wrap">
                <table class="erp-table table-compact">
                    <thead>
                        <tr>
                            <th rowspan="2" style="width: 10%;">วันที่</th>
                            <th colspan="2" class="text-center" style="background: rgba(99,102,241,0.08);">เช้า (Morning)</th>
                            <th colspan="2" class="text-center" style="background: rgba(56,189,248,0.05);">บ่าย (Afternoon)</th>
                            <th colspan="2" class="text-center" style="background: rgba(251,191,36,0.05);">โอที (OT)</th>
                            <th rowspan="2" style="width: 12%;">สถานะ</th>
                            <th rowspan="2" style="width: 12%;">หมายเหตุ</th>
                            <th rowspan="2" style="width: 28%;">จัดการด่วน (1 คลิก)</th>
                        </tr>
                        <tr>
                            <th class="text-center" style="background: rgba(99,102,241,0.05); width: 5%;">เข้า</th>
                            <th class="text-center" style="background: rgba(99,102,241,0.05); width: 5%;">ออก</th>
                            <th class="text-center" style="background: rgba(56,189,248,0.05); width: 5%;">เข้า</th>
                            <th class="text-center" style="background: rgba(56,189,248,0.05); width: 5%;">ออก</th>
                            <th class="text-center" style="background: rgba(251,191,36,0.05); width: 5%;">เข้า</th>
                            <th class="text-center" style="background: rgba(251,191,36,0.05); width: 5%;">ออก</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dates as $date)
                            @php
                                $record = $existingRecords[$date] ?? null;
                                $isLocked = $record && $record->is_locked;

                                $morning = $record ? $record->details->where('period_type', 'morning')->first() : null;
                                $afternoon = $record ? $record->details->where('period_type', 'afternoon')->first() : null;
                                $overtime = $record ? $record->details->where('period_type', 'overtime')->first() : null;
                            @endphp
                            <tr style="{{ $isLocked ? 'background: rgba(255,255,255,0.03);' : '' }}" data-emp-id="{{ $employee->id }}" data-date="{{ $date }}">
                                <td class="text-center fw-semibold {{ $isLocked ? '' : '' }}" style="{{ $isLocked ? 'color: var(--text-muted);' : 'color: var(--text-primary);' }}">
                                    @if($isLocked) <i class="fas fa-lock" style="color: #f87171; margin-right: 4px;"></i> @endif
                                    {{ formatThaiDate($date) }}
                                </td>

                                <td class="bg-morning">
                                    <input type="text" inputmode="numeric" maxlength="5"
                                        name="records[{{ $employee->id }}][{{ $date }}][morning_in]"
                                        class="erp-input check-in-m time-format-input" placeholder="--:--"
                                        value="{{ $morning && $morning->check_in_time ? \Carbon\Carbon::parse($morning->check_in_time)->format('H:i') : '' }}" {{ $isLocked ? 'readonly' : '' }}>
                                </td>
                                <td class="bg-morning">
                                    <input type="text" inputmode="numeric" maxlength="5"
                                        name="records[{{ $employee->id }}][{{ $date }}][morning_out]"
                                        class="erp-input check-out-m time-format-input" placeholder="--:--"
                                        value="{{ $morning && $morning->check_out_time ? \Carbon\Carbon::parse($morning->check_out_time)->format('H:i') : '' }}" {{ $isLocked ? 'readonly' : '' }}>
                                </td>

                                <td class="bg-afternoon">
                                    <input type="text" inputmode="numeric" maxlength="5"
                                        name="records[{{ $employee->id }}][{{ $date }}][afternoon_in]"
                                        class="erp-input check-in-a time-format-input" placeholder="--:--"
                                        value="{{ $afternoon && $afternoon->check_in_time ? \Carbon\Carbon::parse($afternoon->check_in_time)->format('H:i') : '' }}" {{ $isLocked ? 'readonly' : '' }}>
                                </td>
                                <td class="bg-afternoon">
                                    <input type="text" inputmode="numeric" maxlength="5"
                                        name="records[{{ $employee->id }}][{{ $date }}][afternoon_out]"
                                        class="erp-input check-out-a time-format-input" placeholder="--:--"
                                        value="{{ $afternoon && $afternoon->check_out_time ? \Carbon\Carbon::parse($afternoon->check_out_time)->format('H:i') : '' }}" {{ $isLocked ? 'readonly' : '' }}>
                                </td>

                                <td class="bg-ot">
                                    <input type="text" inputmode="numeric" maxlength="5"
                                        name="records[{{ $employee->id }}][{{ $date }}][ot_in]"
                                        class="erp-input check-in-o time-format-input" placeholder="--:--"
                                        value="{{ $overtime && $overtime->check_in_time ? \Carbon\Carbon::parse($overtime->check_in_time)->format('H:i') : '' }}" {{ $isLocked ? 'readonly' : '' }}>
                                </td>
                                <td class="bg-ot">
                                    <input type="text" inputmode="numeric" maxlength="5"
                                        name="records[{{ $employee->id }}][{{ $date }}][ot_out]"
                                        class="erp-input check-out-o time-format-input" placeholder="--:--"
                                        value="{{ $overtime && $overtime->check_out_time ? \Carbon\Carbon::parse($overtime->check_out_time)->format('H:i') : '' }}" {{ $isLocked ? 'readonly' : '' }}>
                                </td>

                                <td>
                                    @if($isLocked)
                                        <input type="hidden" name="records[{{ $employee->id }}][{{ $date }}][status]" value="{{ $record->status }}">
                                        @if($record->status == 'present')
                                            <span class="erp-badge" style="background: rgba(52,211,153,0.12); color: #34d399; width: 100%; text-align: center; padding: 8px 4px;">ปกติ</span>
                                        @elseif($record->status == 'late')
                                            <span class="erp-badge" style="background: rgba(251,191,36,0.12); color: #fbbf24; width: 100%; text-align: center; padding: 8px 4px;">สาย</span>
                                        @elseif($record->status == 'leave')
                                            <span class="erp-badge" style="background: rgba(56,189,248,0.12); color: #38bdf8; width: 100%; text-align: center; padding: 8px 4px;">ลา</span>
                                        @else
                                            <span class="erp-badge" style="background: rgba(239,68,68,0.12); color: #f87171; width: 100%; text-align: center; padding: 8px 4px;">ขาด</span>
                                        @endif
                                    @else
                                        <select name="records[{{ $employee->id }}][{{ $date }}][status]" class="erp-select status-select" onchange="window.handleStatusChange('{{ $employee->id }}', '{{ $date }}')">
                                            <option value="present" {{ ($record->status ?? '') == 'present' ? 'selected' : '' }}>ปกติ</option>
                                            <option value="late" {{ ($record->status ?? '') == 'late' ? 'selected' : '' }}>สาย</option>
                                            <option value="leave" {{ ($record->status ?? '') == 'leave' ? 'selected' : '' }}>ลา</option>
                                            <option value="absent" {{ ($record->status ?? '') == 'absent' ? 'selected' : '' }}>ขาด</option>
                                        </select>
                                    @endif
                                </td>

                                <td>
                                    <input type="text" name="records[{{ $employee->id }}][{{ $date }}][remark]" class="erp-input remark-input" placeholder="-" value="{{ $record->remark ?? '' }}" {{ $isLocked ? 'readonly' : '' }}>
                                </td>

                                <td class="text-center">
                                    @if(!$isLocked)
                                    <div class="btn-group w-100" role="group">
                                        <button type="button" class="erp-btn-secondary" style="background: rgba(52,211,153,0.12); color: #34d399; border: 1px solid rgba(52,211,153,0.2); font-size: 11px; padding: 4px 6px;" onclick="window.quickAction('{{ $employee->id }}', '{{ $date }}', 'present')">ปกติ</button>
                                        <button type="button" class="erp-btn-secondary" style="background: rgba(99,102,241,0.12); color: #818cf8; border: 1px solid rgba(99,102,241,0.2); font-size: 11px; padding: 4px 6px;" onclick="window.quickAction('{{ $employee->id }}', '{{ $date }}', 'ot')">+OT</button>
                                        <button type="button" class="erp-btn-secondary" style="background: rgba(251,191,36,0.12); color: #fbbf24; border: 1px solid rgba(251,191,36,0.2); font-size: 11px; padding: 4px 6px;" onclick="window.quickAction('{{ $employee->id }}', '{{ $date }}', 'late')">สาย</button>
                                        <button type="button" class="erp-btn-secondary" style="background: rgba(56,189,248,0.12); color: #38bdf8; border: 1px solid rgba(56,189,248,0.2); font-size: 11px; padding: 4px 6px;" onclick="window.quickAction('{{ $employee->id }}', '{{ $date }}', 'leave')">ลา</button>
                                        <button type="button" class="erp-btn-danger" style="font-size: 11px; padding: 4px 6px;" onclick="window.quickAction('{{ $employee->id }}', '{{ $date }}', 'absent')">ขาด</button>
                                    </div>
                                    @else
                                        <small style="color: #f87171;"><i class="fas fa-lock"></i> ล็อกแล้ว</small>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="text-center py-4" style="background: var(--bg-surface); border-top: 1px solid var(--border);">
                <button type="submit" class="erp-btn-primary btn-lg shadow fw-bold px-5">
                    <i class="fas fa-save me-2"></i>บันทึกข้อมูลเข้าสู่ระบบ
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    // ----------------------------------------------------------------
    // 1. ระบบ Smart Typing
    // ----------------------------------------------------------------
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.time-format-input:not([readonly])').forEach(input => {
            input.addEventListener('input', function (e) { this.value = this.value.replace(/[^0-9]/g, ''); });
            input.addEventListener('blur', function (e) {
                let val = this.value;
                if (!val) return;
                if (val.length === 1 || val.length === 2) val = val.padStart(2, '0') + '00';
                else if (val.length === 3) val = '0' + val;

                if (val.length === 4) {
                    let h = val.substring(0, 2); let m = val.substring(2, 4);
                    if (parseInt(h) <= 23 && parseInt(m) <= 59) this.value = h + ':' + m;
                    else { alert('รูปแบบเวลาไม่ถูกต้อง'); this.value = ''; }
                } else if (val.length > 4) { this.value = ''; }
            });
        });
    });

    // ----------------------------------------------------------------
    // 2. จัดการเมื่อเปลี่ยนสถานะ
    // ----------------------------------------------------------------
    window.handleStatusChange = function(empId, date) {
        let row = document.querySelector(`tr[data-date="${date}"]`);
        if(!row) return;

        let status = row.querySelector('.status-select').value;
        let remarkInput = row.querySelector('.remark-input');

        if (status === 'leave' || status === 'absent') {
            row.querySelectorAll('.time-format-input').forEach(i => i.value = '');
            remarkInput.focus();
        } else if (status === 'present') {
            if (!row.querySelector('.check-in-m').value) row.querySelector('.check-in-m').value = '08:00';
            if (!row.querySelector('.check-out-m').value) row.querySelector('.check-out-m').value = '12:00';
            if (!row.querySelector('.check-in-a').value) row.querySelector('.check-in-a').value = '13:00';
            if (!row.querySelector('.check-out-a').value) row.querySelector('.check-out-a').value = '17:00';
        }
    };

    // ----------------------------------------------------------------
    // 3. ฟังก์ชัน Quick Action ทั้ง 5 ปุ่ม (ปกติ, +OT, สาย, ลา, ขาด)
    // ----------------------------------------------------------------
    window.quickAction = function(empId, date, status) {
        console.log('quickAction called:', { empId, date, status });

        let row = document.querySelector(`tr[data-date="${date}"]`);
        console.log('Found row:', row);

        if(!row) {
            console.error('Row not found for date:', date);
            alert('ไม่พบข้อมูลแถวนี้');
            return;
        }

        let statusSel = row.querySelector('.status-select');
        let remarkInp = row.querySelector('.remark-input');

        console.log('Found elements:', { statusSel, remarkInp });

        if (status === 'present') {
            statusSel.value = 'present';
            if(row.querySelector('.check-in-m')) row.querySelector('.check-in-m').value = '08:00';
            if(row.querySelector('.check-out-m')) row.querySelector('.check-out-m').value = '12:00';
            if(row.querySelector('.check-in-a')) row.querySelector('.check-in-a').value = '13:00';
            if(row.querySelector('.check-out-a')) row.querySelector('.check-out-a').value = '17:00';
            if(row.querySelector('.check-in-o')) row.querySelector('.check-in-o').value = '';
            if(row.querySelector('.check-out-o')) row.querySelector('.check-out-o').value = '';
            remarkInp.value = '';
            console.log('Set present');
        }
        else if (status === 'ot') {
            statusSel.value = 'present'; // ทำ OT ถือว่ามาทำงานปกติ
            if(row.querySelector('.check-in-m')) row.querySelector('.check-in-m').value = '08:00';
            if(row.querySelector('.check-out-m')) row.querySelector('.check-out-m').value = '12:00';
            if(row.querySelector('.check-in-a')) row.querySelector('.check-in-a').value = '13:00';
            if(row.querySelector('.check-out-a')) row.querySelector('.check-out-a').value = '17:00';
            if(row.querySelector('.check-in-o')) row.querySelector('.check-in-o').value = '17:00'; // เริ่ม OT อัตโนมัติ (แก้เป็น 17:30 ได้ครับ)
            remarkInp.value = '';

            // เด้งเมาส์ไปให้พิมพ์เวลา "เลิก OT"
            if(row.querySelector('.check-out-o')) {
                row.querySelector('.check-out-o').value = '';
                row.querySelector('.check-out-o').focus();
            }
            console.log('Set OT');
        }
        else if (status === 'late') {
            statusSel.value = 'late';
            if(row.querySelector('.check-in-m')) row.querySelector('.check-in-m').value = '';
            if(row.querySelector('.check-out-m')) row.querySelector('.check-out-m').value = '12:00';
            if(row.querySelector('.check-in-a')) row.querySelector('.check-in-a').value = '13:00';
            if(row.querySelector('.check-out-a')) row.querySelector('.check-out-a').value = '17:00';
            if(row.querySelector('.check-in-m')) row.querySelector('.check-in-m').focus();
            console.log('Set late');
        }
        else if (status === 'leave' || status === 'absent') {
            statusSel.value = status;
            row.querySelectorAll('.time-format-input').forEach(i => i.value = '');
            let actionText = status === 'leave' ? 'ลา' : 'ขาดงาน';
            let reason = prompt(`ระบุเหตุผลการ ${actionText} :`, remarkInp.value);
            if (reason !== null) remarkInp.value = reason;
            console.log('Set', status);
        }
    };

    // ----------------------------------------------------------------
    // 4. เติมข้อมูลลงช่องว่างทั้งหมด (เช้า-บ่าย)
    // ----------------------------------------------------------------
    window.fillEmpNormal = function(empId) {
        if(confirm('ต้องการเติมเวลา 08:00-12:00 และ 13:00-17:00 ให้ช่องว่างทั้งหมดหรือไม่?')) {
            document.querySelectorAll('tr[data-date]').forEach(row => {
                let statusSelect = row.querySelector('.status-select');
                if(!statusSelect) return;

                let inM = row.querySelector('.check-in-m');
                let outM = row.querySelector('.check-out-m');
                let inA = row.querySelector('.check-in-a');
                let outA = row.querySelector('.check-out-a');

                if(inM.value === '') inM.value = '08:00';
                if(outM.value === '') outM.value = '12:00';
                if(inA.value === '') inA.value = '13:00';
                if(outA.value === '') outA.value = '17:00';

                statusSelect.value = 'present';
            });
        }
    };

    // ----------------------------------------------------------------
    // 5. ล้างข้อมูลบนจอ
    // ----------------------------------------------------------------
    window.clearAll = function() {
        if(confirm('ยืนยันการล้างข้อมูลทั้งหมดบนหน้าจอนี้?')) {
            document.querySelectorAll('.time-format-input:not([readonly]), .remark-input:not([readonly])').forEach(input => input.value = '');
            document.querySelectorAll('.status-select').forEach(select => select.value = 'present');
        }
    };
</script>
@endsection
