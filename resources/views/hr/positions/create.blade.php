@extends('layouts.app')
@section('title', 'เพิ่มตำแหน่งใหม่')

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
                <i class="fas fa-briefcase me-2" style="color: #818cf8;"></i>เพิ่มตำแหน่งใหม่
            </h4>
            <p style="font-size: 13px; color: var(--text-muted); margin: 0;">สร้างตำแหน่งงานใหม่</p>
        </div>
        <a href="{{ route('hr.positions.index') }}" class="erp-btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>ย้อนกลับ
        </a>
    </div>

    @if ($errors->any())
        <div class="erp-alert erp-alert-danger">
            <ul class="mb-0">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
    @endif

    <div class="erp-card">
        <div class="erp-card-body">
            <form action="{{ route('hr.positions.store') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="erp-label">สังกัดแผนก <span style="color: #f87171;">*</span></label>
                        <select name="department_id" class="erp-select" required>
                            <option value="">-- เลือกแผนก --</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="erp-label">ชื่อตำแหน่ง <span style="color: #f87171;">*</span></label>
                        <input type="text" name="name" class="erp-input" value="{{ old('name') }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="erp-label">หน้าที่รับผิดชอบ (Job Description)</label>
                    <textarea name="job_description" class="erp-textarea" rows="3">{{ old('job_description') }}</textarea>
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
