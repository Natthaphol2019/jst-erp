{{-- 
    Image Upload Component
    Usage: @include('components.image-upload', ['entity' => $employee, 'type' => 'employee', 'route' => route('uploads.employee', $employee->id)])
--}}

@php
    $hasImage = $entity && ($type === 'employee' ? $entity->profile_image : $entity->image_url);
    $imageUrl = $hasImage ? asset('storage/' . ($type === 'employee' ? $entity->profile_image : $entity->image_url)) : null;
    $placeholderImage = $type === 'employee' 
        ? asset('images/placeholder-employee.svg') 
        : asset('images/placeholder-product.svg');
@endphp

<div class="card mb-3">
    <div class="card-header bg-info text-white">
        <i class="bi bi-image me-1"></i>รูปภาพ{{ $type === 'employee' ? 'พนักงาน' : 'สินค้า' }}
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 text-center">
                {{-- Display Image --}}
                <div class="mb-3">
                    <img id="{{ $type }}-image-preview" 
                         src="{{ $hasImage ? $imageUrl : $placeholderImage }}" 
                         alt="{{ $type === 'employee' ? 'รูปพนักงาน' : 'รูปสินค้า' }}"
                         class="img-thumbnail"
                         style="max-width: 200px; max-height: 200px; object-fit: cover;">
                </div>
                
                @if($hasImage)
                <form action="{{ $type === 'employee' ? route('uploads.employee.delete', $entity->id) : route('uploads.item.delete', $entity->id) }}" 
                      method="POST" 
                      class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" 
                            onclick="return confirm('คุณแน่ใจหรือว่าจะลบรูปนี้?')">
                        <i class="bi bi-trash me-1"></i>ลบรูป
                    </button>
                </form>
                @endif
            </div>
            
            <div class="col-md-8">
                {{-- Upload Form --}}
                <form action="{{ $route }}" 
                      method="POST" 
                      enctype="multipart/form-data"
                      id="{{ $type }}-upload-form">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="{{ $type }}-image-input" class="form-label">เลือกรูปภาพ</label>
                        <input type="file" 
                               class="form-control @error($type === 'employee' ? 'profile_image' : 'image') is-invalid @enderror" 
                               id="{{ $type }}-image-input" 
                               name="{{ $type === 'employee' ? 'profile_image' : 'image' }}"
                               accept="image/jpeg,image/png,image/jpg,image/gif"
                               onchange="previewImage(this, '{{ $type }}-image-preview')">
                        
                        @error($type === 'employee' ? 'profile_image' : 'image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                        <div class="form-text">
                            รองรับไฟล์: JPG, PNG, GIF (ขนาดสูงสุด 2MB)
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-upload me-1"></i>อัปโหลดรูป
                    </button>
                </form>
                
                <div class="alert alert-info mt-3">
                    <i class="bi bi-info-circle me-1"></i>
                    <strong>คำแนะนำ:</strong>
                    <ul class="mb-0 mt-2 small">
                        <li>ใช้รูปภาพสี่เหลี่ยมจัตุรัสเพื่อผลลัพธ์ที่ดีที่สุด</li>
                        <li>ขนาดแนะนำ: 400x400 พิกเซลขึ้นไป</li>
                        <li>อัปโหลดรูปใหม่จะแทนที่รูปเก่าอัตโนมัติ</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    const file = input.files[0];
    
    if (file) {
        // ตรวจสอบขนาดไฟล์
        if (file.size > 2 * 1024 * 1024) {
            alert('ไฟล์มีขนาดเกิน 2MB');
            input.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}
</script>
@endpush
