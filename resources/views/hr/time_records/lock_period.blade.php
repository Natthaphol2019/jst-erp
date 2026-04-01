@extends('layouts.app')
@section('title', 'ปิดงวดเวลาทำงาน')

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
    <div class="mb-4">
        <h2 class="fw-bold text-danger m-0">🔒 ปิดงวดเวลาทำงาน (Lock Period)</h2>
        <small class="text-muted">ระบบสำหรับปิดงวดบัญชี ป้องกันการแก้ไขเวลาทำงานย้อนหลัง</small>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-md-5">
            <div class="card shadow-sm border-0 bg-white">
                <div class="card-header bg-dark text-white py-3">
                    <h5 class="m-0 fw-bold"><i class="bi bi-calendar-check"></i> เลือกรอบที่ต้องการจัดการ</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('hr.time-records.lock') }}" method="GET" id="filterForm">
                        <div class="mb-3">
                            <label class="form-label fw-bold">📅 เลือกเดือน / ปี</label>
                            <input type="month" name="month" class="form-control form-control-lg" value="{{ $month }}" onchange="document.getElementById('filterForm').submit()">
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">📆 เลือกรอบ (งวดเงินเดือน)</label>
                            <select name="period" class="form-select form-select-lg" onchange="document.getElementById('filterForm').submit()">
                                <option value="1" {{ $period == 1 ? 'selected' : '' }}>งวดที่ 1 (วันที่ 1 - 15)</option>
                                <option value="2" {{ $period == 2 ? 'selected' : '' }}>งวดที่ 2 (วันที่ 16 - สิ้นเดือน)</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card shadow-sm border-0 bg-white h-100">
                <div class="card-body p-4 text-center d-flex flex-column justify-content-center align-items-center">
                    <h4 class="fw-bold text-primary mb-2">{{ $periodLabel }}</h4>
                    <p class="text-muted mb-4 fs-5">
                        ตั้งแต่ <strong>{{ formatThaiDate($startDate) }}</strong> ถึง <strong>{{ formatThaiDate($endDate) }}</strong>
                    </p>

                    <div class="row w-100 mb-4">
                        <div class="col-6">
                            <div class="p-3 bg-light rounded-3 border">
                                <h2 class="text-success fw-bold m-0">{{ $unlockedCount }}</h2>
                                <small class="text-muted">รายการที่ยังไม่ล็อก (แก้ไขได้)</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 bg-light rounded-3 border">
                                <h2 class="text-danger fw-bold m-0">{{ $lockedCount }}</h2>
                                <small class="text-muted">รายการที่ล็อกแล้ว (แก้ไขไม่ได้)</small>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('hr.time-records.lock.store') }}" method="POST" class="w-100">
                        @csrf
                        <input type="hidden" name="start_date" value="{{ $startDate }}">
                        <input type="hidden" name="end_date" value="{{ $endDate }}">

                        @if($unlockedCount > 0)
                            <div class="alert alert-warning text-start border-0 shadow-sm">
                                <i class="bi bi-exclamation-triangle-fill text-warning"></i> 
                                <strong>คำเตือน:</strong> หากกดยืนยันปิดงวด ข้อมูลการตอกบัตรในช่วงเวลานี้ทั้งหมดจะถูกล็อก ไม่สามารถแก้ไขได้อีก (จนกว่าจะปลดล็อก)
                            </div>
                            <button type="submit" name="action" value="lock" class="btn btn-danger btn-lg w-100 fw-bold shadow-sm" onclick="return confirm('ยืนยันการปิดงวดและล็อกข้อมูลทั้งหมดในงวดนี้ใช่หรือไม่?')">
                                🔒 ยืนยันปิดงวดเวลา (Lock Period)
                            </button>
                        @elseif($lockedCount > 0)
                            <div class="alert alert-success text-start border-0 shadow-sm">
                                <i class="bi bi-check-circle-fill text-success"></i> 
                                งวดเวลานี้ถูกปิดและล็อกข้อมูลเรียบร้อยแล้ว
                            </div>
                            <button type="submit" name="action" value="unlock" class="btn btn-outline-secondary btn-lg w-100 fw-bold" onclick="return confirm('ยืนยันการปลดล็อก? ข้อมูลจะกลับมาแก้ไขได้อีกครั้ง')">
                                🔓 ปลดล็อกงวดเวลานี้ (Unlock)
                            </button>
                        @else
                            <div class="alert alert-secondary text-start border-0">
                                📭 ไม่พบข้อมูลการตอกบัตรในช่วงเวลานี้
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection