@extends('layouts.app')

@section('title', 'เปลี่ยนรหัสผ่าน - JST ERP')

@section('content')

{{-- 1. Page Header --}}
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            <i class="fas fa-key me-2" style="color: #818cf8;"></i>เปลี่ยนรหัสผ่าน
        </h4>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">จัดการและเปลี่ยนรหัสผ่านบัญชีของคุณ</p>
    </div>
    <a href="{{ url()->previous() }}" class="erp-btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>กลับ
    </a>
</div>

{{-- Flash messages --}}
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

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="erp-card">
            <div class="erp-card-header">
                <span class="erp-card-title">
                    <i class="fas fa-shield-alt me-2" style="color: #818cf8;"></i>ฟอร์มเปลี่ยนรหัสผ่าน
                </span>
            </div>
            <div class="erp-card-body">
                <form action="{{ route('profile.update-password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="current_password" class="erp-label">รหัสผ่านปัจจุบัน</label>
                        <div class="d-flex align-items-center" style="gap: 0;">
                            <input type="password" name="current_password" id="current_password"
                                   class="erp-input @error('current_password') is-invalid @enderror"
                                   required
                                   style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                            <button class="erp-btn-secondary toggle-password" type="button" data-target="current_password"
                                    style="border-top-left-radius: 0; border-bottom-left-radius: 0; padding: 0.5rem 0.75rem;">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('current_password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <div style="font-size: 11px; color: var(--text-muted); margin-top: 4px;">กรอกรหัสผ่านปัจจุบันของคุณ</div>
                    </div>

                    <div class="mb-4">
                        <label for="new_password" class="erp-label">รหัสผ่านใหม่</label>
                        <div class="d-flex align-items-center" style="gap: 0;">
                            <input type="password" name="new_password" id="new_password"
                                   class="erp-input @error('new_password') is-invalid @enderror"
                                   required minlength="6"
                                   style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                            <button class="erp-btn-secondary toggle-password" type="button" data-target="new_password"
                                    style="border-top-left-radius: 0; border-bottom-left-radius: 0; padding: 0.5rem 0.75rem;">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('new_password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <div style="font-size: 11px; color: var(--text-muted); margin-top: 4px;">รหัสผ่านต้องมีอย่างน้อย 6 ตัวอักษร</div>
                    </div>

                    <div class="mb-4">
                        <label for="new_password_confirmation" class="erp-label">ยืนยันรหัสผ่านใหม่</label>
                        <div class="d-flex align-items-center" style="gap: 0;">
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                   class="erp-input"
                                   required minlength="6"
                                   style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                            <button class="erp-btn-secondary toggle-password" type="button" data-target="new_password_confirmation"
                                    style="border-top-left-radius: 0; border-bottom-left-radius: 0; padding: 0.5rem 0.75rem;">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="erp-alert erp-alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>คำแนะนำ:</strong>
                        <ul class="mb-0 mt-2">
                            <li>รหัสผ่านใหม่ต้องไม่ซ้ำกับรหัสผ่านปัจจุบัน</li>
                            <li>รหัสผ่านใหม่ต้องตรงกับช่องยืนยันรหัสผ่าน</li>
                            <li>ควรใช้รหัสผ่านที่มีทั้งตัวอักษรและตัวเลขผสมกัน</li>
                        </ul>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <a href="{{ route('profile.edit') }}" class="erp-btn-secondary">
                            <i class="fas fa-times me-2"></i>ยกเลิก
                        </a>
                        <button type="submit" class="erp-btn-primary">
                            <i class="fas fa-check-circle me-2"></i>เปลี่ยนรหัสผ่าน
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Password Tips Card --}}
        <div class="erp-card mt-3">
            <div class="erp-card-header">
                <span class="erp-card-title">
                    <i class="fas fa-lightbulb me-2" style="color: #818cf8;"></i>เคล็ดลับความปลอดภัย
                </span>
            </div>
            <div class="erp-card-body">
                <ul class="mb-0" style="color: var(--text-secondary);">
                    <li>ไม่ใช้รหัสผ่านซ้ำกับบัญชีอื่น</li>
                    <li>เปลี่ยนรหัสผ่านทุก 3 เดือน</li>
                    <li>ไม่แชร์รหัสผ่านให้ผู้อื่นทราบ</li>
                    <li>ออกจากระบบทุกครั้งเมื่อเลิกใช้งาน</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.querySelectorAll('.toggle-password').forEach(button => {
    button.addEventListener('click', function() {
        const targetId = this.dataset.target;
        const input = document.getElementById(targetId);
        const icon = this.querySelector('i');

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
});
</script>
@endpush
@endsection
