@extends('layouts.app')
@section('title', 'รายงานสรุปเวลาทำงานรายเดือน')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">📊 รายงานสรุปเวลาทำงาน (รายเดือน)</h2>
        <button class="btn btn-outline-success shadow-sm" onclick="window.print()">
            🖨️ พิมพ์รายงาน
        </button>
    </div>

    <div class="card shadow-sm border-0 mb-4 bg-light d-print-none">
        <div class="card-body">
            <form action="{{ route('hr.time-records.summary') }}" method="GET" class="d-flex align-items-center">
                <label class="fw-bold me-3">เลือกเดือน/ปี ที่ต้องการดูสรุป :</label>
                <input type="month" name="month_year" class="form-control w-25 me-3" value="{{ $selectedMonth }}" onchange="this.form.submit()">
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white py-3">
            <h5 class="m-0 fw-bold text-primary">
                สรุปข้อมูลเดือน: {{ \Carbon\Carbon::parse($selectedMonth . '-01')->translatedFormat('F Y') }}
            </h5>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 table-bordered">
                    <thead class="table-dark text-center align-middle">
                        <tr>
                            <th rowspan="2" class="ps-4 text-start">รหัสพนักงาน</th>
                            <th rowspan="2" class="text-start">ชื่อ - นามสกุล</th>
                            <th rowspan="2">แผนก</th>
                            <th colspan="4" class="bg-secondary">สรุปการมาทำงาน (วัน)</th>
                        </tr>
                        <tr>
                            <th class="bg-success text-white">🟢 มาปกติ</th>
                            <th class="bg-warning text-dark">🟡 มาสาย</th>
                            <th class="bg-info text-dark">🔵 ลา</th>
                            <th class="bg-danger text-white">🔴 ขาดงาน</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse($employees as $emp)
                            @php
                                // คำนวณจำนวนวันตามสถานะ จาก record ของพนักงานคนนี้
                                $present = $emp->timeRecords->where('status', 'present')->count();
                                $late = $emp->timeRecords->where('status', 'late')->count();
                                $leave = $emp->timeRecords->where('status', 'leave')->count();
                                $absent = $emp->timeRecords->where('status', 'absent')->count();
                                $totalRecords = $emp->timeRecords->count();
                            @endphp
                            
                            @if($totalRecords > 0)
                            <tr>
                                <td class="ps-4 text-start text-muted">{{ $emp->employee_code }}</td>
                                <td class="text-start fw-bold">{{ $emp->firstname }} {{ $emp->lastname }}</td>
                                <td>{{ $emp->department->name ?? '-' }}</td>
                                
                                <td class="fw-bold text-success fs-5">{{ $present ?: '-' }}</td>
                                <td class="fw-bold text-warning fs-5">{{ $late ?: '-' }}</td>
                                <td class="fw-bold text-info fs-5">{{ $leave ?: '-' }}</td>
                                <td class="fw-bold text-danger fs-5">{{ $absent ?: '-' }}</td>
                            </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">ไม่พบข้อมูลพนักงาน</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .sidebar, .navbar, .btn { display: none !important; }
        .container-fluid { padding: 0 !important; }
        .card { border: none !important; box-shadow: none !important; }
    }
</style>
@endsection