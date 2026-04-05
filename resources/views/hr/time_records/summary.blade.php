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
    .card { border: 1px solid #dee2e6 !important; box-shadow: none !important; margin-bottom: 1rem !important; }
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
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold m-0 text-primary">📊 รายงานสรุปเวลาทำงาน (รายเดือน)</h2>
            <small class="text-muted">สรุปยอดวันมาทำงาน สาย ลา ขาด พร้อมคำนวณชั่วโมงทำงานและ OT อัตโนมัติ</small>
        </div>
        <div class="d-print-none">
            <a href="{{ route('exports.time-records', ['month_year' => $selectedMonth]) }}" class="btn btn-success shadow-sm fw-bold px-4 me-2">
                <i class="bi bi-file-earmark-excel me-1"></i> Export Excel
            </a>
            <button class="btn btn-outline-success shadow-sm fw-bold px-4" onclick="window.print()">
                🖨️ พิมพ์ภาพรวม
            </button>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4 bg-white d-print-none">
        <div class="card-body p-4">
            <form action="{{ route('hr.time-records.summary') }}" method="GET" class="d-flex align-items-center">
                <label class="fw-bold me-3 text-dark">📅 เลือกเดือน/ปี ที่ต้องการดูสรุป :</label>
                <input type="month" name="month_year" class="form-control w-25 me-3 shadow-sm" value="{{ $selectedMonth }}" onchange="this.form.submit()">
            </form>
        </div>
    </div>

    <div class="card shadow border-0 rounded-3 mb-5">
        <div class="card-header bg-white py-3 border-bottom border-2 border-primary">
            <h5 class="m-0 fw-bold text-dark">
                สรุปข้อมูลเดือน: <span class="text-primary">{{ \Carbon\Carbon::parse($selectedMonth . '-01')->translatedFormat('F Y') }}</span>
            </h5>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 table-bordered text-center">
                    <thead class="table-dark align-middle">
                        <tr>
                            <th rowspan="2" class="ps-4 text-start" width="10%">รหัส</th>
                            <th rowspan="2" class="text-start" width="20%">ชื่อ - นามสกุล</th>
                            <th colspan="4" class="bg-secondary text-white border-bottom-0">สถานะมาทำงาน (วัน)</th>
                            <th colspan="2" class="bg-primary text-white border-bottom-0">ชั่วโมงทำงานรวม</th>
                            <th rowspan="2" width="10%">ตรวจสอบ</th>
                        </tr>
                        <tr>
                            <th class="bg-success text-white" width="8%">🟢 ปกติ</th>
                            <th class="bg-warning text-dark" width="8%">🟡 สาย</th>
                            <th class="bg-info text-dark" width="8%">🔵 ลา</th>
                            <th class="bg-danger text-white" width="8%">🔴 ขาด</th>
                            <th class="bg-dark text-white" width="12%">⏱️ ชม. ปกติ</th>
                            <th class="bg-dark text-white" width="12%">🔥 ชม. OT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reportData as $data)
                            <tr>
                                <td class="ps-4 text-start text-muted fw-semibold">{{ $data['emp']->employee_code }}</td>
                                <td class="text-start fw-bold text-dark">
                                    <i class="bi bi-person-circle text-secondary me-1"></i> {{ $data['emp']->prefix }}{{ $data['emp']->firstname }} {{ $data['emp']->lastname }}<br>
                                    <span class="badge bg-light text-dark border mt-1">{{ $data['emp']->department->name ?? '-' }}</span>
                                </td>
                                
                                <td class="fw-bold text-success fs-5">{{ $data['present'] ?: '-' }}</td>
                                <td class="fw-bold text-warning fs-5">{{ $data['late'] ?: '-' }}</td>
                                <td class="fw-bold text-info fs-5">{{ $data['leave'] ?: '-' }}</td>
                                <td class="fw-bold text-danger fs-5">{{ $data['absent'] ?: '-' }}</td>
                                
                                <td class="fw-bold text-success">{{ formatHours($data['totalNormalMins']) }}</td>
                                <td class="fw-bold text-primary">{{ formatHours($data['totalOtMins']) }}</td>
                                
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm fw-bold d-print-none" data-bs-toggle="modal" data-bs-target="#detailModal{{ $data['emp']->id }}">
                                        🔍 ดูรายละเอียด
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">
                                    <h5>📭 ไม่พบข้อมูลการลงเวลาของพนักงานในเดือนนี้</h5>
                                    <p class="mb-0">กรุณาไปที่เมนู "บันทึกเวลาจากบัตรตอก" เพื่อคีย์ข้อมูลก่อนครับ</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@foreach($reportData as $data)
<div class="modal fade text-start" id="detailModal{{ $data['emp']->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white border-0">
                <h5 class="modal-title fw-bold">
                    📅 บันทึกเวลาทำงานรายเดือน: {{ $data['emp']->firstname }} {{ $data['emp']->lastname }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 bg-light">
                <table class="table table-hover table-bordered align-middle mb-0 text-center" style="font-size: 0.9rem;">
                    <thead class="table-dark align-middle">
                        <tr>
                            <th rowspan="2" width="15%">วันที่</th>
                            <th colspan="2">เช้า</th>
                            <th colspan="2">บ่าย</th>
                            <th colspan="2">OT</th>
                            <th rowspan="2" width="10%">สถานะ</th>
                            <th rowspan="2" width="12%">ชม. ทำงาน</th>
                            <th rowspan="2" width="12%">ชม. OT</th>
                        </tr>
                        <tr>
                            <th width="6%">เข้า</th><th width="6%">ออก</th>
                            <th width="6%">เข้า</th><th width="6%">ออก</th>
                            <th width="6%">เข้า</th><th width="6%">ออก</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach($daysInMonth as $dt)
                            @php
                                $dateStr = $dt->format('Y-m-d');
                                $recordData = $data['recordsByDate'][$dateStr] ?? null;
                                $isWeekend = $dt->isWeekend();
                            @endphp
                            <tr class="{{ $isWeekend ? 'bg-secondary bg-opacity-10' : '' }}">
                                <td class="text-start ps-3 fw-semibold {{ $isWeekend ? 'text-danger' : 'text-dark' }}">
                                    {{ formatThaiDate($dateStr, true) }}
                                </td>
                                
                                @if($recordData)
                                    <td>{{ $recordData['mIn'] ? \Carbon\Carbon::parse($recordData['mIn'])->format('H:i') : '-' }}</td>
                                    <td>{{ $recordData['mOut'] ? \Carbon\Carbon::parse($recordData['mOut'])->format('H:i') : '-' }}</td>
                                    <td>{{ $recordData['aIn'] ? \Carbon\Carbon::parse($recordData['aIn'])->format('H:i') : '-' }}</td>
                                    <td>{{ $recordData['aOut'] ? \Carbon\Carbon::parse($recordData['aOut'])->format('H:i') : '-' }}</td>
                                    <td class="bg-warning bg-opacity-10">{{ $recordData['oIn'] ? \Carbon\Carbon::parse($recordData['oIn'])->format('H:i') : '-' }}</td>
                                    <td class="bg-warning bg-opacity-10">{{ $recordData['oOut'] ? \Carbon\Carbon::parse($recordData['oOut'])->format('H:i') : '-' }}</td>
                                    <td>
                                        <span class="badge w-100 {{ $recordData['record']->status == 'present' ? 'bg-success' : ($recordData['record']->status == 'late' ? 'bg-warning text-dark' : ($recordData['record']->status == 'leave' ? 'bg-info text-dark' : 'bg-danger')) }}">
                                            {{ $recordData['record']->status == 'present' ? 'มาปกติ' : ($recordData['record']->status == 'late' ? 'สาย' : ($recordData['record']->status == 'leave' ? 'ลา' : 'ขาด')) }}
                                        </span>
                                    </td>
                                    <td class="fw-bold text-success">{{ formatHours($recordData['dayNormalMins']) }}</td>
                                    <td class="fw-bold text-primary bg-warning bg-opacity-10">{{ formatHours($recordData['dayOtMins']) }}</td>
                                @else
                                    <td colspan="9" class="text-muted">ยังไม่ได้บันทึกเวลา</td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-dark">
                        <tr>
                            <td colspan="8" class="text-end pe-3 fw-bold fs-6">รวมเวลาทำงานทั้งเดือน ({{ \Carbon\Carbon::parse($selectedMonth . '-01')->translatedFormat('M Y') }}) :</td>
                            <td class="fw-bold text-success fs-6">{{ formatHours($data['totalNormalMins']) }}</td>
                            <td class="fw-bold text-warning fs-6">{{ formatHours($data['totalOtMins']) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="modal-footer bg-light border-0">
                <button type="button" class="btn btn-secondary shadow-sm rounded-pill px-4" data-bs-dismiss="modal">ปิดหน้าต่าง</button>
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
        .card { border: none !important; box-shadow: none !important; }
        .card-header { padding-left: 0 !important; }
        body { background-color: #fff !important; }
    }
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush

@endsection