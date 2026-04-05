@extends('layouts.app')
@section('title', 'เพิ่มแผนกใหม่')

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
                <i class="fas fa-sitemap me-2" style="color: #818cf8;"></i>เพิ่มแผนกใหม่
            </h4>
            <p style="font-size: 13px; color: var(--text-muted); margin: 0;">สร้างแผนกใหม่เข้าสู่ระบบ</p>
        </div>
        <a href="{{ route('hr.departments.index') }}" class="erp-btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>ย้อนกลับ
        </a>
    </div>

    @if ($errors->any())
        <div class="erp-alert erp-alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="erp-card">
        <div class="erp-card-body">
            <form action="{{ route('hr.departments.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="erp-label">ชื่อแผนก <span style="color: #f87171;">*</span></label>
                    <input type="text" name="name" class="erp-input" value="{{ old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label class="erp-label">รายละเอียด / หน้าที่ของแผนก</label>
                    <textarea name="description" class="erp-textarea" rows="3">{{ old('description') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="erp-label">ส่งต่องานไปแผนกใด? (Workflow)</label>
                    <select name="next_department_id" class="erp-select">
                        <option value="">-- ไม่ระบุ (สิ้นสุดกระบวนการ) --</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ old('next_department_id') == $dept->id ? 'selected' : '' }}>
                                {{ $dept->name }}
                            </option>
                        @endforeach
                    </select>
                    <small style="color: var(--text-muted);">เช่น ฝ่ายขาย รับออเดอร์แล้วส่งต่อให้ วิศวกรรม</small>
                </div>

                <hr style="border-color: var(--border);">
                <div class="d-flex gap-2 justify-content-end mt-4">
                    <button type="submit" class="erp-btn-primary">
                        <i class="fas fa-save me-2"></i>บันทึกข้อมูล
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
