@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col">
            <h2>➕ เพิ่มหมวดหมู่สินค้าใหม่</h2>
        </div>
        <div class="col text-end">
            <a href="{{ route('inventory.categories.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> กลับ
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle"></i> {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('inventory.categories.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">ชื่อหมวดหมู่ <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">รายละเอียด</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> บันทึก
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
