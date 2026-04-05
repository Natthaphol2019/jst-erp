@extends('layouts.app')
@section('title', 'แก้ไขข้อมูลแผนก')

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
                <i class="fas fa-sitemap me-2" style="color: #818cf8;"></i>แก้ไขแผนก: {{ $department->name }}
            </h4>
            <p style="font-size: 13px; color: var(--text-muted); margin: 0;">แก้ไขข้อมูลแผนก</p>
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
            <form action="{{ route('hr.departments.update', $department->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="erp-label">ชื่อแผนก <span style="color: #f87171;">*</span></label>
                    <input type="text" name="name" class="erp-input" value="{{ $department->name }}" required>
                </div>

                <div class="mb-3">
                    <label class="erp-label">รายละเอียด / หน้าที่ของแผนก</label>
                    <textarea name="description" class="erp-textarea" rows="3">{{ $department->description }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="erp-label">ส่งต่องานไปแผนกใด? (Workflow)</label>
                    <select name="next_department_id" class="erp-select">
                        <option value="">-- ไม่ระบุ (สิ้นสุดกระบวนการ) --</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ $department->next_department_id == $dept->id ? 'selected' : '' }}>
                                {{ $dept->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <hr style="border-color: var(--border);">
                <div class="d-flex gap-2 justify-content-end mt-4">
                    <button type="submit" class="erp-btn-primary" style="background: rgba(251,191,36,0.12); color: #fbbf24; border: 1px solid rgba(251,191,36,0.2);">
                        <i class="fas fa-save me-2"></i>อัปเดตข้อมูล
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
