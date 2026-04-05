@extends('layouts.app')
@section('title', 'รายงานสรุปเวลาทำงานรายเดือน')

@php
    // ---------------------------------------------------------
    // ฟังก์ชันจัดการวันที่และคำนวณชั่วโมง
    // ---------------------------------------------------------
    function formatThaiDate($date, $showDayOfWeek = false) {
        if (!$date) return '-';
        $months = ['', 'ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
        $days = ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'];
        $time = strtotime($date);
        $d = date('j', $time);
        $m = $months[date('n', $time)];
        $y = date('Y', $time) + 543;
        if ($showDayOfWeek) {
            $dayOfWeek = $days[date('w', $time)];
            return "$d $m $y ($dayOfWeek)";
        }
        return "$d $m $y";
    }

    function calculateMinutes($in, $out) {
        if (!$in || !$out) return 0;
        $inTime = \Carbon\Carbon::parse($in);
        $outTime = \Carbon\Carbon::parse($out);
        if ($outTime->lessThan($inTime)) $outTime->addDay(); // กรณีทำข้ามคืน
        return $inTime->diffInMinutes($outTime);
    }

    function formatHours($minutes) {
        if ($minutes <= 0) return '-';
        $h = floor($minutes / 60);
        $m = $minutes % 60;
        if ($h > 0 && $m > 0) return sprintf("%d ชม. %d นาที", $h, $m);
        if ($h > 0) return sprintf("%d ชม.", $h);
        return sprintf("%d นาที", $m);
    }
@endphp

@section('content')
<style>
@media print {
    .no-print, .no-print *, .d-print-none { display: none !important; }
    .sidebar, .navbar, .btn, .alert { display: none !important; }
    .content { padding: 0 !important; margin: 0 !important; }
    .erp-card { border: 1px solid #dee2e6 !important; box-shadow: none !important; margin-bottom: 1rem !important; }
    table { font-size: 10pt !important; }
    th, td { border: 1px solid #dee2e6 !important; }
    body { background-color: #fff !important; }
    .container-fluid { width: 100% !important; max-width: 100% !important; }
    @page { margin: 1.5cm; }
}
</style>

@php
    // =========================================================
    // คำนวณข้อมูลทั้งหมดไว้ล่วงหน้า (เพื่อไม่ให้ตารางรก)
    // =========================================================
    $monthStart = \Carbon\Carbon::parse($selectedMonth . '-01');
    $daysInMonth = \Carbon\CarbonPeriod::create($monthStart->copy()->startOfMonth(), $monthStart->copy()->endOfMonth());

    $reportData = []; // เก็บข้อมูลที่คำนวณเสร็จแล้วของแต่ละคน

    foreach($employees as $emp) {
        $totalRecords = $emp->timeRecords->count();
        if($totalRecords == 0) continue; // ข้ามคนที่ไม่มีข้อมูลเลย

        $present = 0; $late = 0; $leave = 0; $absent = 0;
        $totalNormalMins = 0; $totalOtMins = 0;
        $recordsByDate = [];

        foreach($emp->timeRecords as $tr) {
            if($tr->status == 'present') $present++;
            elseif($tr->status == 'late') $late++;
            elseif($tr->status == 'leave') $leave++;
            elseif($tr->status == 'absent') $absent++;

            // ดึงข้อมูล 3 ช่วง (รองรับทั้งการตั้งชื่อ period และ period_type ป้องกันบัค)
            $morning = $tr->details->where('period', 'morning')->first() ?? $tr->details->where('period_type', 'morning')->first();
            $afternoon = $tr->details->where('period', 'afternoon')->first() ?? $tr->details->where('period_type', 'afternoon')->first();
            $overtime = $tr->details->where('period', 'overtime')->first() ?? $tr->details->where('period_type', 'overtime')->first();

            $mIn = $morning?->check_in_time; $mOut = $morning?->check_out_time;
            $aIn = $afternoon?->check_in_time; $aOut = $afternoon?->check_out_time;
            $oIn = $overtime?->check_in_time; $oOut = $overtime?->check_out_time;

            // คำนวณเป็นนาที
            $dayNormalMins = calculateMinutes($mIn, $mOut) + calculateMinutes($aIn, $aOut);
            $dayOtMins = calculateMinutes($oIn, $oOut);

            $totalNormalMins += $dayNormalMins;
            $totalOtMins += $dayOtMins;

            $dateKey = \Carbon\Carbon::parse($tr->work_date)->format('Y-m-d');

            // เก็บลง Array เพื่อเอาไปแสดงใน Modal
            $recordsByDate[$dateKey] = [
                'record' => $tr,
                'mIn' => $mIn, 'mOut' => $mOut, 'aIn' => $aIn, 'aOut' => $aOut, 'oIn' => $oIn, 'oOut' => $oOut,
                'dayNormalMins' => $dayNormalMins, 'dayOtMins' => $dayOtMins
            ];
        }

        $reportData[] = [
            'emp' => $emp,
            'present' => $present,
            'late' => $late,
            'leave' => $leave,
            'absent' => $absent,
            'totalNormalMins' => $totalNormalMins,
            'totalOtMins' => $totalOtMins,
            'recordsByDate' => $recordsByDate
        ];
    }
@endphp

<div class="container-fluid">
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
                <i class="fas fa-chart-line me-2" style="color: #818cf8;"></i>รายงานสรุปเวลาทำงาน (รายเดือน)
            </h4>
            <p style="font-size: 13px; color: var(--text-muted); margin: 0;">สรุปยอดวันมาทำงาน สาย ลา ขาด พร้อมคำนวณชั่วโมงทำงานและ OT อัตโนมัติ</p>
        </div>
        <div class="d-flex gap-2 d-print-none">
            <a href="{{ route('exports.time-records', ['month_year' => $selectedMonth]) }}" class="erp-btn-primary" style="background: rgba(52,211,153,0.12); color: #34d399; border: 1px solid rgba(52,211,153,0.2);">
                <i class="fas fa-file-excel me-2"></i>Export Excel
            </a>
            <button class="erp-btn-secondary" onclick="window.print()">
                <i class="fas fa-print me-2"></i>พิมพ์ภาพรวม
            </button>
        </div>
    </div>

    {{-- Month Selector --}}
    <div class="erp-card mb-4 d-print-none">
        <div class="erp-card-body">
            <form action="{{ route('hr.time-records.summary') }}" method="GET" class="d-flex align-items-center">
                <label class="erp-label me-3" style="white-space: nowrap;"><i class="fas fa-calendar me-1"></i>เลือกเดือน/ปี ที่ต้องการดูสรุป :</label>
                <input type="month" name="month_year" class="erp-input w-25 me-3" value="{{ $selectedMonth }}" onchange="this.form.submit()">
            </form>
        </div>
    </div>

    {{-- Summary Table --}}
    <div class="erp-card rounded-3 mb-5">
        <div class="erp-card-header">
            <span class="erp-card-title">
                <i class="fas fa-table me-2" style="color: #818cf8;"></i>สรุปข้อมูลเดือน: <span style="color: #818cf8;">{{ \Carbon\Carbon::parse($selectedMonth . '-01')->translatedFormat('F Y') }}</span>
            </span>
        </div>
        <div class="erp-table-wrap">
            <table class="erp-table">
                <thead>
                    <tr>
                        <th rowspan="2" class="text-start" style="width: 10%;">รหัส</th>
                        <th rowspan="2" class="text-start" style="width: 20%;">ชื่อ - นามสกุล</th>
                        <th colspan="4" class="text-center" style="background: rgba(255,255,255,0.03);">สถานะมาทำงาน (วัน)</th>
                        <th colspan="2" class="text-center" style="background: rgba(99,102,241,0.05);">ชั่วโมงทำงานรวม</th>
                        <th rowspan="2" style="width: 10%;">ตรวจสอบ</th>
                    </tr>
                    <tr>
                        <th class="text-center" style="width: 8%;"><span class="erp-badge" style="background: rgba(52,211,153,0.12); color: #34d399;">ปกติ</span></th>
                        <th class="text-center" style="width: 8%;"><span class="erp-badge" style="background: rgba(251,191,36,0.12); color: #fbbf24;">สาย</span></th>
                        <th class="text-center" style="width: 8%;"><span class="erp-badge" style="background: rgba(56,189,248,0.12); color: #38bdf8;">ลา</span></th>
                        <th class="text-center" style="width: 8%;"><span class="erp-badge" style="background: rgba(239,68,68,0.12); color: #f87171;">ขาด</span></th>
                        <th class="text-center" style="width: 12%;">ชม. ปกติ</th>
                        <th class="text-center" style="width: 12%;">ชม. OT</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reportData as $data)
                        <tr>
                            <td class="text-start fw-semibold" style="color: var(--text-muted);">{{ $data['emp']->employee_code }}</td>
                            <td class="text-start" style="color: var(--text-primary);">
                                <i class="fas fa-user-circle me-1" style="color: var(--text-secondary);"></i> {{ $data['emp']->prefix }}{{ $data['emp']->firstname }} {{ $data['emp']->lastname }}<br>
                                <span class="erp-badge" style="background: rgba(255,255,255,0.05); color: var(--text-secondary); margin-top: 4px;">{{ $data['emp']->department->name ?? '-' }}</span>
                            </td>

                            <td class="text-center fw-bold" style="color: #34d399;">{{ $data['present'] ?: '-' }}</td>
                            <td class="text-center fw-bold" style="color: #fbbf24;">{{ $data['late'] ?: '-' }}</td>
                            <td class="text-center fw-bold" style="color: #38bdf8;">{{ $data['leave'] ?: '-' }}</td>
                            <td class="text-center fw-bold" style="color: #f87171;">{{ $data['absent'] ?: '-' }}</td>

                            <td class="text-center fw-bold" style="color: #34d399;">{{ formatHours($data['totalNormalMins']) }}</td>
                            <td class="text-center fw-bold" style="color: #818cf8;">{{ formatHours($data['totalOtMins']) }}</td>

                            <td>
                                <button type="button" class="erp-btn-primary rounded-pill px-3 d-print-none" data-bs-toggle="modal" data-bs-target="#detailModal{{ $data['emp']->id }}">
                                    <i class="fas fa-search me-1"></i>ดูรายละเอียด
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <div class="erp-empty">
                                    <i class="fas fa-inbox"></i>
                                    <div>ไม่พบข้อมูลการลงเวลาของพนักงานในเดือนนี้</div>
                                    <p style="color: var(--text-muted); font-size: 13px;">กรุณาไปที่เมนู "บันทึกเวลาจากบัตรตอก" เพื่อคีย์ข้อมูลก่อนครับ</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@foreach($reportData as $data)
<div class="modal fade text-start" id="detailModal{{ $data['emp']->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content" style="background: var(--bg-raised); border: 1px solid var(--border);">
            <div class="modal-header" style="background: var(--bg-surface); border-bottom: 1px solid var(--border);">
                <h5 class="modal-title" style="font-weight: 600; color: var(--text-primary);">
                    <i class="fas fa-calendar-alt me-2" style="color: #818cf8;"></i>บันทึกเวลาทำงานรายเดือน: {{ $data['emp']->firstname }} {{ $data['emp']->lastname }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0" style="background: var(--bg-base);">
                <div class="erp-table-wrap">
                    <table class="erp-table" style="font-size: 0.9rem;">
                        <thead>
                            <tr>
                                <th rowspan="2" style="width: 15%;">วันที่</th>
                                <th colspan="2" class="text-center">เช้า</th>
                                <th colspan="2" class="text-center">บ่าย</th>
                                <th colspan="2" class="text-center">OT</th>
                                <th rowspan="2" style="width: 10%;">สถานะ</th>
                                <th rowspan="2" style="width: 12%;">ชม. ทำงาน</th>
                                <th rowspan="2" style="width: 12%;">ชม. OT</th>
                            </tr>
                            <tr>
                                <th style="width: 6%;">เข้า</th><th style="width: 6%;">ออก</th>
                                <th style="width: 6%;">เข้า</th><th style="width: 6%;">ออก</th>
                                <th style="width: 6%;">เข้า</th><th style="width: 6%;">ออก</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($daysInMonth as $dt)
                                @php
                                    $dateStr = $dt->format('Y-m-d');
                                    $recordData = $data['recordsByDate'][$dateStr] ?? null;
                                    $isWeekend = $dt->isWeekend();
                                @endphp
                                <tr style="{{ $isWeekend ? 'background: rgba(255,255,255,0.03);' : '' }}">
                                    <td class="text-start ps-3 fw-semibold {{ $isWeekend ? '' : '' }}" style="{{ $isWeekend ? 'color: #f87171;' : 'color: var(--text-primary);' }}">
                                        {{ formatThaiDate($dateStr, true) }}
                                    </td>

                                    @if($recordData)
                                        <td>{{ $recordData['mIn'] ? \Carbon\Carbon::parse($recordData['mIn'])->format('H:i') : '-' }}</td>
                                        <td>{{ $recordData['mOut'] ? \Carbon\Carbon::parse($recordData['mOut'])->format('H:i') : '-' }}</td>
                                        <td>{{ $recordData['aIn'] ? \Carbon\Carbon::parse($recordData['aIn'])->format('H:i') : '-' }}</td>
                                        <td>{{ $recordData['aOut'] ? \Carbon\Carbon::parse($recordData['aOut'])->format('H:i') : '-' }}</td>
                                        <td style="background: rgba(251,191,36,0.05);">{{ $recordData['oIn'] ? \Carbon\Carbon::parse($recordData['oIn'])->format('H:i') : '-' }}</td>
                                        <td style="background: rgba(251,191,36,0.05);">{{ $recordData['oOut'] ? \Carbon\Carbon::parse($recordData['oOut'])->format('H:i') : '-' }}</td>
                                        <td>
                                            @if($recordData['record']->status == 'present')
                                                <span class="erp-badge" style="background: rgba(52,211,153,0.12); color: #34d399; width: 100%; text-align: center;">มาปกติ</span>
                                            @elseif($recordData['record']->status == 'late')
                                                <span class="erp-badge" style="background: rgba(251,191,36,0.12); color: #fbbf24; width: 100%; text-align: center;">สาย</span>
                                            @elseif($recordData['record']->status == 'leave')
                                                <span class="erp-badge" style="background: rgba(56,189,248,0.12); color: #38bdf8; width: 100%; text-align: center;">ลา</span>
                                            @else
                                                <span class="erp-badge" style="background: rgba(239,68,68,0.12); color: #f87171; width: 100%; text-align: center;">ขาด</span>
                                            @endif
                                        </td>
                                        <td class="fw-bold" style="color: #34d399;">{{ formatHours($recordData['dayNormalMins']) }}</td>
                                        <td class="fw-bold" style="color: #818cf8; background: rgba(251,191,36,0.05);">{{ formatHours($recordData['dayOtMins']) }}</td>
                                    @else
                                        <td colspan="9" style="color: var(--text-muted);">ยังไม่ได้บันทึกเวลา</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="8" class="text-end pe-3 fw-bold" style="color: var(--text-primary);">รวมเวลาทำงานทั้งเดือน ({{ \Carbon\Carbon::parse($selectedMonth . '-01')->translatedFormat('M Y') }}) :</td>
                                <td class="fw-bold" style="color: #34d399;">{{ formatHours($data['totalNormalMins']) }}</td>
                                <td class="fw-bold" style="color: #fbbf24;">{{ formatHours($data['totalOtMins']) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer" style="background: var(--bg-surface); border-top: 1px solid var(--border);">
                <button type="button" class="erp-btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>ปิดหน้าต่าง
                </button>
            </div>
        </div>
    </div>
</div>
@endforeach

<style>
    .modal-content { overflow: hidden; }
    @media print {
        .sidebar, .navbar, .btn, form, .modal { display: none !important; }
        .container-fluid { padding: 0 !important; }
        .erp-card { border: none !important; box-shadow: none !important; }
        .erp-card-header { padding-left: 0 !important; }
        body { background-color: #fff !important; }
    }
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush

@endsection
