@extends('layouts.app')
@section('title', 'แก้ไขตำแหน่ง')

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
                <i class="fas fa-briefcase me-2" style="color: #818cf8;"></i>แก้ไขตำแหน่ง: {{ $position->name }}
            </h4>
            <p style="font-size: 13px; color: var(--text-muted); margin: 0;">แก้ไขข้อมูลตำแหน่งงาน</p>
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
            <form action="{{ route('hr.positions.update', $position->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="erp-label">สังกัดแผนก <span style="color: #f87171;">*</span></label>
                        <select name="department_id" class="erp-select" required>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ $position->department_id == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="erp-label">ชื่อตำแหน่ง <span style="color: #f87171;">*</span></label>
                        <input type="text" name="name" class="erp-input" value="{{ $position->name }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="erp-label">หน้าที่รับผิดชอบ (Job Description)</label>
                    <textarea name="job_description" class="erp-textarea" rows="3">{{ $position->job_description }}</textarea>
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
