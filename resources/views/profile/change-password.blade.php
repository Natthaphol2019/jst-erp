@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h2>
                <i class="bi bi-key me-2"></i>เปลี่ยนรหัสผ่าน
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

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <i class="bi bi-shield-lock me-1"></i>ฟอร์มเปลี่ยนรหัสผ่าน
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update-password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="current_password" class="form-label required">รหัสผ่านปัจจุบัน</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input type="password" name="current_password" id="current_password" 
                                       class="form-control @error('current_password') is-invalid @enderror" 
                                       required>
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="current_password">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">กรอกรหัสผ่านปัจจุบันของคุณ</div>
                        </div>

                        <div class="mb-4">
                            <label for="new_password" class="form-label required">รหัสผ่านใหม่</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock-fill"></i>
                                </span>
                                <input type="password" name="new_password" id="new_password" 
                                       class="form-control @error('new_password') is-invalid @enderror" 
                                       required minlength="6">
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="new_password">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">รหัสผ่านต้องมีอย่างน้อย 6 ตัวอักษร</div>
                        </div>

                        <div class="mb-4">
                            <label for="new_password_confirmation" class="form-label required">ยืนยันรหัสผ่านใหม่</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock-fill"></i>
                                </span>
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation" 
                                       class="form-control" 
                                       required minlength="6">
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="new_password_confirmation">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-1"></i>
                            <strong>คำแนะนำ:</strong>
                            <ul class="mb-0 mt-2">
                                <li>รหัสผ่านใหม่ต้องไม่ซ้ำกับรหัสผ่านปัจจุบัน</li>
                                <li>รหัสผ่านใหม่ต้องตรงกับช่องยืนยันรหัสผ่าน</li>
                                <li>ควรใช้รหัสผ่านที่มีทั้งตัวอักษรและตัวเลขผสมกัน</li>
                            </ul>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('profile.edit') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-1"></i>ยกเลิก
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-check-circle me-1"></i>เปลี่ยนรหัสผ่าน
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Password Tips Card --}}
            <div class="card mt-3">
                <div class="card-header bg-info text-white">
                    <i class="bi bi-lightbulb me-1"></i>เคล็ดลับความปลอดภัย
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li>ไม่ใช้รหัสผ่านซ้ำกับบัญชีอื่น</li>
                        <li>เปลี่ยนรหัสผ่านทุก 3 เดือน</li>
                        <li>ไม่แชร์รหัสผ่านให้ผู้อื่นทราบ</li>
                        <li>ออกจากระบบทุกครั้งเมื่อเลิกใช้งาน</li>
                    </ul>
                </div>
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
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    });
});
</script>
@endpush
@endsection
