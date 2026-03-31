@extends('layouts.app')
@section('title', 'บันทึกเวลาทำงานแบบกลุ่ม')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">⏱️ บันทึกเวลาทำงานรายวัน</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0 mb-4 bg-light">
        <div class="card-body">
            <form action="{{ route('hr.time-records.batch') }}" method="GET" class="d-flex align-items-center">
                <label class="fw-bold me-3">เลือกวันที่ต้องการบันทึก :</label>
                <input type="date" name="date" class="form-control w-25 me-3" value="{{ $selectedDate }}" onchange="this.form.submit()">
                <span class="text-muted small">ระบบจะโหลดรายชื่อและข้อมูลของวันที่เลือกมาแสดงอัตโนมัติ</span>
            </form>
        </div>
    </div>

    <form action="{{ route('hr.time-records.batch.store') }}" method="POST">
        @csrf
        <input type="hidden" name="work_date" value="{{ $selectedDate }}">

        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="m-0 fw-bold text-primary">ตารางลงเวลา ({{ \Carbon\Carbon::parse($selectedDate)->format('d/m/Y') }})</h5>
                
                <button type="button" class="btn btn-warning fw-bold shadow-sm" onclick="autoFillTime()">
                    ⚡ เติมเวลา 08:00 - 17:00 ให้ทุกคน
                </button>
            </div>
            
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark text-nowrap">
                            <tr>
                                <th class="ps-4">รหัส</th>
                                <th>ชื่อ - นามสกุล</th>
                                <th>เวลาเข้างาน</th>
                                <th>เวลาออกงาน</th>
                                <th>สถานะ</th>
                                <th>หมายเหตุ (เช่น ลากิจ, สาย)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employees as $emp)
                                @php
                                    $record = $existingRecords->get($emp->id);
                                @endphp
                                <tr>
                                    <td class="ps-4 text-muted">{{ $emp->employee_code }}</td>
                                    <td class="fw-bold">
                                        {{ $emp->firstname }} {{ $emp->lastname }}<br>
                                        <span class="badge bg-light text-secondary">
                                            {{ $emp->department->name ?? 'ไม่ระบุ' }} 
                                            ({{ $emp->position->name ?? '-' }})
                                        </span>
                                    </td>
                                    <td>
                                        <input type="time" name="records[{{ $emp->id }}][check_in_time]" class="form-control check-in-input" value="{{ $record ? \Carbon\Carbon::parse($record->check_in_time)->format('H:i') : '' }}">
                                    </td>
                                    <td>
                                        <input type="time" name="records[{{ $emp->id }}][check_out_time]" class="form-control check-out-input" value="{{ $record && $record->check_out_time ? \Carbon\Carbon::parse($record->check_out_time)->format('H:i') : '' }}">
                                    </td>
                                    <td>
                                        <select name="records[{{ $emp->id }}][status]" class="form-select status-select">
                                            <option value="present" {{ ($record->status ?? '') == 'present' ? 'selected' : '' }}>🟢 มาปกติ</option>
                                            <option value="late" {{ ($record->status ?? '') == 'late' ? 'selected' : '' }}>🟡 มาสาย</option>
                                            <option value="leave" {{ ($record->status ?? '') == 'leave' ? 'selected' : '' }}>🔵 ลา</option>
                                            <option value="absent" {{ ($record->status ?? '') == 'absent' ? 'selected' : '' }}>🔴 ขาดงาน</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="records[{{ $emp->id }}][remark]" class="form-control" placeholder="..." value="{{ $record->remark ?? '' }}">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white border-0 py-3 text-end">
                <button type="submit" class="btn btn-primary btn-lg shadow-sm">💾 บันทึกข้อมูลเวลาทำงาน</button>
            </div>
        </div>
    </form>
</div>

<script>
    function autoFillTime() {
        if(confirm('ต้องการเติมเวลาเข้า 08:00 และออก 17:00 ให้กับพนักงานที่ช่องเวลายังว่างอยู่ ใช่หรือไม่?')) {
            let checkInInputs = document.querySelectorAll('.check-in-input');
            let checkOutInputs = document.querySelectorAll('.check-out-input');
            let statusSelects = document.querySelectorAll('.status-select');

            checkInInputs.forEach((input, index) => {
                if(input.value === '') {
                    input.value = '08:00';
                }
                if(checkOutInputs[index].value === '') {
                    checkOutInputs[index].value = '17:00';
                }
                statusSelects[index].value = 'present';
            });
        }
    }
</script>
@endsection