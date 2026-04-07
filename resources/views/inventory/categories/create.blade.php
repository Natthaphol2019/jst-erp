@extends('layouts.app')

@section('title', 'เพิ่มหมวดหมู่สินค้า - JST ERP')

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            <i class="fas fa-plus me-2" style="color: #818cf8;"></i>เพิ่มหมวดหมู่สินค้าใหม่
        </h4>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">สร้างหมวดหมู่สำหรับจัดกลุ่มสินค้า</p>
    </div>
    <a href="{{ route('inventory.categories.index') }}" class="erp-btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>กลับ
    </a>
</div>

@if($errors->any())
    <div class="erp-alert erp-alert-danger mb-4">
        <i class="fas fa-exclamation-triangle me-2"></i>{{ $errors->first() }}
    </div>
@endif

<div class="erp-card">
    <div class="erp-card-body">
        <form action="{{ route('inventory.categories.store') }}" method="POST">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="erp-label">ชื่อหมวดหมู่ <span style="color: #f87171;">*</span></label>
                    <input type="text" name="name" id="categoryName" class="erp-input @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" required placeholder="เช่น อุปกรณ์สำนักงาน">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="erp-label">รหัสย่อ (Code Prefix)</label>
                    <div class="input-group">
                        <input type="text" name="code_prefix" id="codePrefix" class="erp-input @error('code_prefix') is-invalid @enderror"
                               value="{{ old('code_prefix') }}" maxlength="10" placeholder="เช่น SUP, TL, IT">
                        <button type="button" class="erp-btn-secondary" id="autoPrefixBtn" style="white-space: nowrap;">
                            <i class="fas fa-magic me-1"></i>สร้างอัตโนมัติ
                        </button>
                    </div>
                    <div style="font-size: 11px; color: var(--text-muted); margin-top: 4px;">
                        <i class="fas fa-info-circle me-1"></i>รหัสย่อจะใช้สร้างรหัสสินค้าอัตโนมัติ (ตัวพิมพ์ใหญ่ A-Z เท่านั้น)
                    </div>
                    @error('code_prefix')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="erp-label">รายละเอียด</label>
                    <textarea name="description" class="erp-textarea @error('description') is-invalid @enderror" rows="3" placeholder="อธิบายเกี่ยวกับหมวดหมู่นี้">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex gap-2 mt-4 pt-3" style="border-top: 1px solid var(--border);">
                <button type="submit" class="erp-btn-primary"><i class="fas fa-check me-2"></i>บันทึก</button>
                <a href="{{ route('inventory.categories.index') }}" class="erp-btn-secondary"><i class="fas fa-times me-2"></i>ยกเลิก</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Auto-generate code prefix from category name
document.getElementById('autoPrefixBtn').addEventListener('click', function() {
    const name = document.getElementById('categoryName').value.trim();
    const prefixInput = document.getElementById('codePrefix');
    
    if (!name) {
        alert('กรุณากรอกชื่อหมวดหมู่ก่อนสร้างรหัสย่อ');
        return;
    }
    
    // Remove Thai vowels and tone marks, keep only consonants and English letters
    const consonants = name.replace(/[ก-๙\s]/g, '').substring(0, 3).toUpperCase();
    
    // If we have Thai consonants, use them; otherwise use first 3 English letters
    let prefix = '';
    const thaiConsonants = name.match(/[ก-ฮ]/g);
    if (thaiConsonants) {
        // Map Thai consonants to English (first letter of each consonant's name)
        const thaiToEng = {
            'ก': 'K', 'ข': 'KH', 'ค': 'K', 'ง': 'NG', 'จ': 'CH', 'ฉ': 'CH',
            'ช': 'CH', 'ซ': 'S', 'ด': 'D', 'ต': 'T', 'ถ': 'TH', 'ท': 'TH',
            'ธ': 'TH', 'น': 'N', 'บ': 'B', 'ป': 'P', 'ผ': 'PH', 'ฝ': 'PH',
            'พ': 'PH', 'ฟ': 'F', 'ม': 'M', 'ย': 'Y', 'ร': 'R', 'ล': 'L',
            'ว': 'W', 'ศ': 'S', 'ษ': 'S', 'ส': 'S', 'ห': 'H', 'อ': 'O', 'ฮ': 'H'
        };
        prefix = thaiConsonants.slice(0, 3).map(c => thaiToEng[c] || c).join('').substring(0, 5);
    } else {
        // Use English letters from the name
        prefix = name.replace(/[^a-zA-Z]/g, '').substring(0, 3).toUpperCase();
    }
    
    if (prefix) {
        prefixInput.value = prefix;
        this.innerHTML = '<i class="fas fa-check me-1"></i>สร้างแล้ว!';
        setTimeout(() => {
            this.innerHTML = '<i class="fas fa-magic me-1"></i>สร้างอัตโนมัติ';
        }, 2000);
    }
});

// Force uppercase only
document.getElementById('codePrefix').addEventListener('input', function(e) {
    this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
});
</script>
@endpush
