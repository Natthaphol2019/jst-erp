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
<form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-3">
        {{-- Left Column - Personal Info --}}
        <div class="col-md-6">
            {{-- Profile Image Upload --}}
            <div class="erp-card mb-3">
                <div class="erp-card-header" style="border-bottom: 2px solid rgba(99,102,241,0.2);">
                    <span class="erp-card-title">
                        <i class="fas fa-camera me-1" style="color: #818cf8;"></i>รูปโปรไฟล์
                    </span>
                </div>
                <div class="erp-card-body text-center">
                    <div class="position-relative d-inline-block">
                        <div id="profileImagePreview" 
                             style="width: 120px; height: 120px; border-radius: 50%; overflow: hidden; margin: 0 auto 16px; border: 3px solid var(--accent); background: linear-gradient(135deg, var(--accent), #a78bfa); display: flex; align-items: center; justify-content: center; color: white; font-size: 48px;">
                            @if($employee->profile_image)
                                <img src="{{ asset('storage/' . $employee->profile_image) }}" 
                                     alt="Profile" 
                                     style="width: 100%; height: 100%; object-fit: cover;"
                                     onerror="this.style.display='none'; this.parentElement.innerHTML='<i class=\'fas fa-user\'></i>';">
                            @else
                                <i class="fas fa-user"></i>
                            @endif
                        </div>
                        <label for="profileImageInput" 
                               style="position: absolute; bottom: 8px; right: 8px; width: 36px; height: 36px; border-radius: 50%; background: var(--accent); color: white; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.2);">
                            <i class="fas fa-camera" style="font-size: 14px;"></i>
                        </label>
                        <input type="file" 
                               name="profile_image" 
                               id="profileImageInput" 
                               accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                               style="display: none;"
                               onchange="previewProfileImage(this)">
                    </div>
                    <div style="font-size: 12px; color: var(--text-muted); margin-bottom: 12px;">
                        <i class="fas fa-info-circle me-1"></i>JPG, PNG, GIF, WebP (สูงสุด 2MB)
                    </div>
                    @if($employee->profile_image)
                        <div class="form-check d-inline-block">
                            <input type="checkbox" name="remove_image" id="removeImage" value="1" class="form-check-input">
                            <label for="removeImage" style="color: #f87171; font-size: 13px; cursor: pointer;">
                                <i class="fas fa-trash me-1"></i>ลบรูปโปรไฟล์
                            </label>
                        </div>
                    @endif
                </div>
            </div>

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

@push('scripts')
<script>
function previewProfileImage(input) {
    const preview = document.getElementById('profileImagePreview');
    const file = input.files[0];

    if (file) {
        // Check file size (2MB max)
        if (file.size > 2 * 1024 * 1024) {
            alert('ไฟล์มีขนาดเกิน 2MB');
            input.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = '<img src="' + e.target.result + '" style="width: 100%; height: 100%; object-fit: cover;">';
            preview.style.background = 'none';
        };
        reader.readAsDataURL(file);

        // Uncheck remove image checkbox when new file is selected
        const removeCheckbox = document.getElementById('removeImage');
        if (removeCheckbox) {
            removeCheckbox.checked = false;
        }
    }
}
</script>
@endpush

@endsection
