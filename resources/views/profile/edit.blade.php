@extends('layouts.app')

@section('title', 'แก้ไขข้อมูลส่วนตัว - JST ERP')

@section('content')

{{-- Page Header --}}
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            <i class="fas fa-user-edit me-2" style="color: #818cf8;"></i>แก้ไขข้อมูลส่วนตัว
        </h4>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">อัปเดตข้อมูลส่วนบุคคลของคุณ</p>
    </div>
    <a href="{{ url()->previous() }}" class="erp-btn-secondary">
        <i class="fas fa-arrow-left me-1"></i>กลับ
    </a>
</div>

{{-- Success/Error Messages --}}
@if(session('success'))
    <div class="erp-alert erp-alert-success mb-4">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="erp-alert erp-alert-danger mb-4">
        <i class="fas fa-exclamation-triangle me-2"></i>{{ $errors->first() }}
    </div>
@endif

@if($employee)
<form action="{{ route('profile.update') }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row g-3">
        {{-- Left Column - Personal Info --}}
        <div class="col-md-6">
            <div class="erp-card mb-3">
                <div class="erp-card-header" style="border-bottom: 2px solid rgba(99,102,241,0.2);">
                    <span class="erp-card-title">
                        <i class="fas fa-user me-1" style="color: #818cf8;"></i>ข้อมูลส่วนตัว
                    </span>
                </div>
                <div class="erp-card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="prefix" class="erp-label">คำนำหน้า</label>
                            <select name="prefix" id="prefix" class="erp-select @error('prefix') is-invalid @enderror">
                                <option value="">-- เลือก --</option>
                                <option value="นาย" {{ old('prefix', $employee->prefix) == 'นาย' ? 'selected' : '' }}>นาย</option>
                                <option value="นาง" {{ old('prefix', $employee->prefix) == 'นาง' ? 'selected' : '' }}>นาง</option>
                                <option value="นางสาว" {{ old('prefix', $employee->prefix) == 'นางสาว' ? 'selected' : '' }}>นางสาว</option>
                            </select>
                            @error('prefix')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-8 mb-3">
                            <label for="firstname" class="erp-label">ชื่อ <span style="color: #f87171;">*</span></label>
                            <input type="text" name="firstname" id="firstname"
                                   class="erp-input @error('firstname') is-invalid @enderror"
                                   value="{{ old('firstname', $employee->firstname) }}" required>
                            @error('firstname')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="lastname" class="erp-label">นามสกุล <span style="color: #f87171;">*</span></label>
                        <input type="text" name="lastname" id="lastname"
                               class="erp-input @error('lastname') is-invalid @enderror"
                               value="{{ old('lastname', $employee->lastname) }}" required>
                        @error('lastname')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="erp-label">เพศ <span style="color: #f87171;">*</span></label>
                        <div class="d-flex gap-3">
                            <div>
                                <input type="radio" name="gender" id="gender_male"
                                       value="male" {{ old('gender', $employee->gender) == 'male' ? 'checked' : '' }} required>
                                <label for="gender_male" style="color: var(--text-secondary);">ชาย</label>
                            </div>
                            <div>
                                <input type="radio" name="gender" id="gender_female"
                                       value="female" {{ old('gender', $employee->gender) == 'female' ? 'checked' : '' }}>
                                <label for="gender_female" style="color: var(--text-secondary);">หญิง</label>
                            </div>
                            <div>
                                <input type="radio" name="gender" id="gender_other"
                                       value="other" {{ old('gender', $employee->gender) == 'other' ? 'checked' : '' }}>
                                <label for="gender_other" style="color: var(--text-secondary);">อื่นๆ</label>
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
            <div class="erp-card mb-3">
                <div class="erp-card-header" style="border-bottom: 2px solid rgba(56,189,248,0.2);">
                    <span class="erp-card-title">
                        <i class="fas fa-phone me-1" style="color: #38bdf8;"></i>ข้อมูลการติดต่อ
                    </span>
                </div>
                <div class="erp-card-body">
                    <div class="mb-3">
                        <label for="email" class="erp-label">อีเมล</label>
                        <input type="email" name="email" id="email"
                               class="erp-input @error('email') is-invalid @enderror"
                               value="{{ old('email', auth()->user()->email) }}"
                               placeholder="example@email.com">
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="erp-label">เบอร์โทรศัพท์</label>
                        <input type="text" name="phone" id="phone"
                               class="erp-input @error('phone') is-invalid @enderror"
                               value="{{ old('phone', $employee->phone ?? '') }}"
                               placeholder="081-234-5678"
                               maxlength="20">
                        @error('phone')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address" class="erp-label">ที่อยู่</label>
                        <textarea name="address" id="address" rows="3"
                                  class="erp-textarea @error('address') is-invalid @enderror"
                                  placeholder="กรอกที่อยู่ของคุณ">{{ old('address', $employee->address ?? '') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Work Info (Read-only) --}}
            <div class="erp-card">
                <div class="erp-card-header" style="border-bottom: 2px solid rgba(255,255,255,0.1);">
                    <span class="erp-card-title">
                        <i class="fas fa-briefcase me-1" style="color: var(--text-secondary);"></i>ข้อมูลการทำงาน
                    </span>
                </div>
                <div class="erp-card-body">
                    <table class="erp-table" style="border: none;">
                        <tr>
                            <td style="width: 120px; font-weight: 500; color: var(--text-secondary);">รหัสพนักงาน</td>
                            <td style="color: var(--text-primary);">{{ $employee->employee_code }}</td>
                        </tr>
                        @if($employee->department)
                        <tr>
                            <td style="font-weight: 500; color: var(--text-secondary);">แผนก</td>
                            <td style="color: var(--text-primary);">{{ $employee->department->name }}</td>
                        </tr>
                        @endif
                        @if($employee->position)
                        <tr>
                            <td style="font-weight: 500; color: var(--text-secondary);">ตำแหน่ง</td>
                            <td style="color: var(--text-primary);">{{ $employee->position->name }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td style="font-weight: 500; color: var(--text-secondary);">วันที่เริ่มต้น</td>
                            <td style="color: var(--text-primary);">{{ \Carbon\Carbon::parse($employee->start_date)->format('d/m/Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Submit Button --}}
    <div class="erp-card mt-3">
        <div class="erp-card-body">
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('profile.change-password') }}" class="erp-btn-secondary" style="background: rgba(251,191,36,0.12); color: #fbbf24; border-color: rgba(251,191,36,0.3);">
                    <i class="fas fa-key me-1"></i>เปลี่ยนรหัสผ่าน
                </a>
                <button type="submit" class="erp-btn-primary">
                    <i class="fas fa-check me-1"></i>บันทึกการแก้ไข
                </button>
            </div>
        </div>
    </div>
</form>
@else
<div class="erp-alert erp-alert-warning">
    <i class="fas fa-exclamation-triangle me-2"></i>ไม่พบข้อมูลพนักงาน
</div>
@endif

@endsection
