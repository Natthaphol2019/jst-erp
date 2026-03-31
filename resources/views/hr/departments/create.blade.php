@extends('layouts.app')
@section('title', 'เพิ่มแผนกใหม่')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>➕ เพิ่มแผนกใหม่</h2>
        <a href="{{ route('hr.departments.index') }}" class="btn btn-secondary">ย้อนกลับ</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form action="{{ route('hr.departments.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">ชื่อแผนก <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">รายละเอียด / หน้าที่ของแผนก</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label">ส่งต่องานไปแผนกใด? (Workflow)</label>
                    <select name="next_department_id" class="form-select">
                        <option value="">-- ไม่ระบุ (สิ้นสุดกระบวนการ) --</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ old('next_department_id') == $dept->id ? 'selected' : '' }}>
                                {{ $dept->name }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">เช่น ฝ่ายขาย รับออเดอร์แล้วส่งต่อให้ วิศวกรรม</small>
                </div>

                <hr>
                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-primary">💾 บันทึกข้อมูล</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection