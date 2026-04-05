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
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
                <i class="fas fa-lock me-2" style="color: #f87171;"></i>ปิดงวดเวลาทำงาน (Lock Period)
            </h4>
            <p style="font-size: 13px; color: var(--text-muted); margin: 0;">ระบบสำหรับปิดงวดบัญชี ป้องกันการแก้ไขเวลาทำงานย้อนหลัง</p>
        </div>
    </div>

    @if(session('success'))
        <div class="erp-alert erp-alert-success mb-4">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-5">
            <div class="erp-card">
                <div class="erp-card-header">
                    <span class="erp-card-title">
                        <i class="fas fa-calendar-check me-2" style="color: #818cf8;"></i>เลือกรอบที่ต้องการจัดการ
                    </span>
                </div>
                <div class="erp-card-body">
                    <form action="{{ route('hr.time-records.lock') }}" method="GET" id="filterForm">
                        <div class="mb-3">
                            <label class="erp-label"><i class="fas fa-calendar me-1"></i>เลือกเดือน / ปี</label>
                            <input type="month" name="month" class="erp-input" value="{{ $month }}" onchange="document.getElementById('filterForm').submit()">
                        </div>
                        <div class="mb-4">
                            <label class="erp-label"><i class="fas fa-calendar-day me-1"></i>เลือกรอบ (งวดเงินเดือน)</label>
                            <select name="period" class="erp-select" onchange="document.getElementById('filterForm').submit()">
                                <option value="1" {{ $period == 1 ? 'selected' : '' }}>งวดที่ 1 (วันที่ 1 - 15)</option>
                                <option value="2" {{ $period == 2 ? 'selected' : '' }}>งวดที่ 2 (วันที่ 16 - สิ้นเดือน)</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="erp-card h-100">
                <div class="erp-card-body text-center d-flex flex-column justify-content-center align-items-center">
                    <h4 class="fw-bold mb-2" style="color: #818cf8;">{{ $periodLabel }}</h4>
                    <p class="mb-4" style="color: var(--text-secondary); font-size: 15px;">
                        ตั้งแต่ <strong style="color: var(--text-primary);">{{ formatThaiDate($startDate) }}</strong> ถึง <strong style="color: var(--text-primary);">{{ formatThaiDate($endDate) }}</strong>
                    </p>

                    <div class="row w-100 mb-4">
                        <div class="col-6">
                            <div class="p-3" style="background: var(--bg-surface); border: 1px solid var(--border); border-radius: 10px;">
                                <h2 class="fw-bold m-0" style="color: #34d399;">{{ $unlockedCount }}</h2>
                                <small style="color: var(--text-muted);">รายการที่ยังไม่ล็อก (แก้ไขได้)</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3" style="background: var(--bg-surface); border: 1px solid var(--border); border-radius: 10px;">
                                <h2 class="fw-bold m-0" style="color: #f87171;">{{ $lockedCount }}</h2>
                                <small style="color: var(--text-muted);">รายการที่ล็อกแล้ว (แก้ไขไม่ได้)</small>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('hr.time-records.lock.store') }}" method="POST" class="w-100">
                        @csrf
                        <input type="hidden" name="start_date" value="{{ $startDate }}">
                        <input type="hidden" name="end_date" value="{{ $endDate }}">

                        @if($unlockedCount > 0)
                            <div class="erp-alert erp-alert-warning text-start mb-3">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>คำเตือน:</strong> หากกดยืนยันปิดงวด ข้อมูลการตอกบัตรในช่วงเวลานี้ทั้งหมดจะถูกล็อก ไม่สามารถแก้ไขได้อีก (จนกว่าจะปลดล็อก)
                            </div>
                            <button type="submit" name="action" value="lock" class="erp-btn-danger w-100 fw-bold" onclick="return confirm('ยืนยันการปิดงวดและล็อกข้อมูลทั้งหมดในงวดนี้ใช่หรือไม่?')">
                                <i class="fas fa-lock me-2"></i>ยืนยันปิดงวดเวลา (Lock Period)
                            </button>
                        @elseif($lockedCount > 0)
                            <div class="erp-alert erp-alert-success text-start mb-3">
                                <i class="fas fa-check-circle me-2"></i>
                                งวดเวลานี้ถูกปิดและล็อกข้อมูลเรียบร้อยแล้ว
                            </div>
                            <button type="submit" name="action" value="unlock" class="erp-btn-secondary w-100 fw-bold" onclick="return confirm('ยืนยันการปลดล็อก? ข้อมูลจะกลับมาแก้ไขได้อีกครั้ง')">
                                <i class="fas fa-unlock me-2"></i>ปลดล็อกงวดเวลานี้ (Unlock)
                            </button>
                        @else
                            <div class="erp-alert erp-alert-info text-start">
                                <i class="fas fa-inbox me-2"></i>ไม่พบข้อมูลการตอกบัตรในช่วงเวลานี้
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
