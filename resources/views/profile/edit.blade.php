@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h2>
                <i class="bi bi-person me-2"></i>แก้ไขข้อมูลส่วนตัว
            </h2>
        </div>
        <div class="col text-end">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i>กลับ
            </a>
        </div>
    </div>

    {{-- Success/Error Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-1"></i>{{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($employee)
    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row">
            {{-- Left Column - Personal Info --}}
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                        <i class="bi bi-person-badge me-1"></i>ข้อมูลส่วนตัว
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="prefix" class="form-label">คำนำหน้า</label>
                                <select name="prefix" id="prefix" class="form-select @error('prefix') is-invalid @enderror">
                                    <option value="">-- เลือก --</option>
                                    <option value="นาย" {{ old('prefix', $employee->prefix) == 'นาย' ? 'selected' : '' }}>นาย</option>
                                    <option value="นาง" {{ old('prefix', $employee->prefix) == 'นาง' ? 'selected' : '' }}>นาง</option>
                                    <option value="นางสาว" {{ old('prefix', $employee->prefix) == 'นางสาว' ? 'selected' : '' }}>นางสาว</option>
                                </select>
                                @error('prefix')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-8 mb-3">
                                <label for="firstname" class="form-label required">ชื่อ</label>
                                <input type="text" name="firstname" id="firstname" 
                                       class="form-control @error('firstname') is-invalid @enderror" 
                                       value="{{ old('firstname', $employee->firstname) }}" required>
                                @error('firstname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="lastname" class="form-label required">นามสกุล</label>
                            <input type="text" name="lastname" id="lastname" 
                                   class="form-control @error('lastname') is-invalid @enderror" 
                                   value="{{ old('lastname', $employee->lastname) }}" required>
                            @error('lastname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label required">เพศ</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="gender_male" 
                                           value="male" {{ old('gender', $employee->gender) == 'male' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="gender_male">
                                        ชาย
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="gender_female" 
                                           value="female" {{ old('gender', $employee->gender) == 'female' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="gender_female">
                                        หญิง
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="gender_other" 
                                           value="other" {{ old('gender', $employee->gender) == 'other' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="gender_other">
                                        อื่นๆ
                                    </label>
                                </div>
                            </div>
                            @error('gender')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column - Contact Info --}}
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header bg-info text-white">
                        <i class="bi bi-telephone me-1"></i>ข้อมูลการติดต่อ
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="email" class="form-label">อีเมล</label>
                            <input type="email" name="email" id="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email', auth()->user()->email) }}"
                                   placeholder="example@email.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">เบอร์โทรศัพท์</label>
                            <input type="text" name="phone" id="phone" 
                                   class="form-control @error('phone') is-invalid @enderror" 
                                   value="{{ old('phone', $employee->phone ?? '') }}"
                                   placeholder="081-234-5678"
                                   maxlength="20">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">ที่อยู่</label>
                            <textarea name="address" id="address" rows="3" 
                                      class="form-control @error('address') is-invalid @enderror" 
                                      placeholder="กรอกที่อยู่ของคุณ">{{ old('address', $employee->address ?? '') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Work Info (Read-only) --}}
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <i class="bi bi-briefcase me-1"></i>ข้อมูลการทำงาน
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <th width="120">รหัสพนักงาน</th>
                                <td>{{ $employee->employee_code }}</td>
                            </tr>
                            @if($employee->department)
                            <tr>
                                <th>แผนก</th>
                                <td>{{ $employee->department->name }}</td>
                            </tr>
                            @endif
                            @if($employee->position)
                            <tr>
                                <th>ตำแหน่ง</th>
                                <td>{{ $employee->position->name }}</td>
                            </tr>
                            @endif
                            <tr>
                                <th>วันที่เริ่มต้น</th>
                                <td>{{ \Carbon\Carbon::parse($employee->start_date)->format('d/m/Y') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Submit Button --}}
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('profile.change-password') }}" class="btn btn-warning">
                                <i class="bi bi-key me-1"></i>เปลี่ยนรหัสผ่าน
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-1"></i>บันทึกการแก้ไข
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @else
    <div class="alert alert-warning">
        <i class="bi bi-exclamation-triangle me-1"></i>ไม่พบข้อมูลพนักงาน
    </div>
    @endif
</div>
@endsection
