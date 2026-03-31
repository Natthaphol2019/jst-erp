@extends('layouts.app')
@section('title', 'แก้ไขตำแหน่ง')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>✏️ แก้ไขตำแหน่ง: {{ $position->name }}</h2>
        <a href="{{ route('hr.positions.index') }}" class="btn btn-secondary">ย้อนกลับ</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form action="{{ route('hr.positions.update', $position->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">สังกัดแผนก <span class="text-danger">*</span></label>
                        <select name="department_id" class="form-select" required>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ $position->department_id == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">ชื่อตำแหน่ง <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ $position->name }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">หน้าที่รับผิดชอบ (Job Description)</label>
                    <textarea name="job_description" class="form-control" rows="3">{{ $position->job_description }}</textarea>
                </div>

                <hr>
                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-warning">💾 อัปเดตข้อมูล</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection