@extends('layouts.app')

@section('title', 'รายการสินค้า - JST ERP')

@section('content')
<style>
/* Filter & Sort Buttons */
.erp-filter-btn {
    display: inline-flex;
    align-items: center;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 500;
    text-decoration: none;
    background: var(--input-bg);
    border: 1px solid var(--input-border);
    color: var(--text-secondary);
    transition: all 0.15s;
    cursor: pointer;
    white-space: nowrap;
}
.erp-filter-btn:hover {
    background: rgba(99,102,241,0.12);
    border-color: rgba(99,102,241,0.3);
    color: var(--accent);
    text-decoration: none;
}
.erp-filter-btn.active {
    background: var(--accent);
    border-color: var(--accent);
    color: white;
    font-weight: 600;
}
.erp-filter-btn.active i {
    color: white;
}

@media print {
    .no-print, .no-print * { display: none !important; }
    .sidebar, .navbar, .btn { display: none !important; }
    .content { padding: 0 !important; margin: 0 !important; }
    .erp-card { border: 1px solid #dee2e6 !important; box-shadow: none !important; margin-bottom: 1rem !important; }
    table { font-size: 10pt !important; }
    th, td { border: 1px solid #dee2e6 !important; }
    body { background-color: #fff !important; }
    .container { width: 100% !important; max-width: 100% !important; }
    @page { margin: 1.5cm; }
}
.print-header { display: none; }
@media print {
    .print-header { display: block !important; text-align: center; margin-bottom: 20px; }
    .print-header h2 { margin: 0; font-size: 18pt; }
    .print-header p { margin: 5px 0 0; font-size: 10pt; color: #666; }
}
</style>

<div class="print-header">
    <h2>รายการสินค้าในคลัง</h2>
    <p>พิมพ์เมื่อ {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
</div>

<div class="d-flex justify-content-between align-items-start mb-4 no-print">
    <div>
        <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            <i class="fas fa-box-open me-2" style="color: #818cf8;"></i>รายการสินค้าในคลัง
        </h4>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">จัดการสินค้าและวัสดุในคลังสินค้า</p>
    </div>
    <div class="d-flex gap-2 no-print">
        <button onclick="window.print()" class="erp-btn-secondary">
            <i class="fas fa-print me-2"></i>พิมพ์
        </button>
        <a href="{{ route('exports.items') }}" class="erp-btn-primary" style="background: #22c55e; border-color: #22c55e;">
            <i class="fas fa-file-excel me-2"></i>Export Excel
        </a>
        <a href="{{ route('inventory.items.create') }}" class="erp-btn-primary">
            <i class="fas fa-plus me-2"></i>เพิ่มสินค้า
        </a>
    </div>
</div>

@if(session('success'))
    <div class="erp-alert erp-alert-success mb-4">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    </div>
@endif

{{-- Filter & Sort Bar --}}
<div class="erp-card mb-3 no-print">
    <div class="erp-card-body" style="padding: 12px 18px;">
        {{-- Search Bar - Instant Search --}}
        <div class="mb-3">
            <div class="input-group">
                <span class="input-group-text" style="border: 2px solid var(--border, #e5e7eb); border-right: none; background: var(--bg-surface, white);">
                    <i class="fas fa-search" style="color: var(--text-muted);"></i>
                </span>
                <input type="text" id="instantSearch" class="form-control"
                       value="{{ request('search') }}"
                       placeholder="พิมพ์เพื่อค้นหาชื่อสินค้า, รหัสสินค้า, หรือตำแหน่ง... (ค้นหาทันที)"
                       style="border: 2px solid var(--border, #e5e7eb); border-left: none; background: var(--bg-surface, white); color: var(--text-primary); border-radius: 0 8px 8px 0;">
                @if(request('search'))
                    <a href="{{ route('inventory.items.index', array_filter(request()->query(), fn($k, $v) => $k !== 'search', ARRAY_FILTER_USE_BOTH)) }}"
                       class="erp-btn-secondary" style="border-radius: 0 8px 8px 0; padding: 8px 16px;">
                        <i class="fas fa-times"></i> ล้าง
                    </a>
                @endif
            </div>
            <div id="searchStatus" style="font-size: 11px; color: var(--text-muted); margin-top: 4px; display: none;">
                <i class="fas fa-spinner fa-spin me-1"></i>กำลังค้นหา...
            </div>
        </div>

        <div class="row g-2 align-items-center">
            <div class="col-auto">
                <span style="font-size: 12px; color: var(--text-muted); font-weight: 500;">
                    <i class="fas fa-filter me-1"></i>สถานะ:
                </span>
            </div>
            <div class="col-auto">
                <a href="{{ route('inventory.items.index', array_merge(request()->query(), ['status' => 'available'])) }}"
                   class="erp-filter-btn {{ request('status', 'available') == 'available' ? 'active' : '' }}">
                    <i class="fas fa-check-circle me-1"></i>พร้อมใช้งาน
                </a>
            </div>
            <div class="col-auto">
                <a href="{{ route('inventory.items.index', array_merge(request()->query(), ['status' => 'maintenance'])) }}"
                   class="erp-filter-btn {{ request('status') == 'maintenance' ? 'active' : '' }}">
                    <i class="fas fa-wrench me-1"></i>ซ่อมบำรุง
                </a>
            </div>
            <div class="col-auto">
                <a href="{{ route('inventory.items.index', array_merge(request()->query(), ['status' => 'unavailable'])) }}"
                   class="erp-filter-btn {{ request('status') == 'unavailable' ? 'active' : '' }}">
                    <i class="fas fa-times-circle me-1"></i>ไม่พร้อมใช้งาน
                </a>
            </div>
            <div class="col-auto">
                <a href="{{ route('inventory.items.index', array_filter(request()->query(), fn($k, $v) => $k !== 'status', ARRAY_FILTER_USE_BOTH)) }}"
                   class="erp-filter-btn {{ !request('status') ? 'active' : '' }}">
                    <i class="fas fa-layer-group me-1"></i>ทั้งหมด
                </a>
            </div>
            
            @if($categories->count() > 0)
            <div class="col-auto" style="border-left: 2px solid var(--border); padding-left: 12px;">
                <span style="font-size: 12px; color: var(--text-muted); font-weight: 500;">
                    <i class="fas fa-folder me-1"></i>หมวดหมู่:
                </span>
            </div>
            <div class="col-auto">
                <a href="{{ route('inventory.items.index', array_filter(request()->query(), fn($k, $v) => $k !== 'category', ARRAY_FILTER_USE_BOTH)) }}"
                   class="erp-filter-btn {{ !request('category') ? 'active' : '' }}" style="font-size: 11px;">
                    ทั้งหมด
                </a>
            </div>
            @foreach($categories as $cat)
            <div class="col-auto">
                <a href="{{ route('inventory.items.index', array_merge(request()->query(), ['category' => $cat])) }}"
                   class="erp-filter-btn {{ request('category') == $cat ? 'active' : '' }}" style="font-size: 11px;">
                    {{ $cat }}
                </a>
            </div>
            @endforeach
            @endif

            @if($types->count() > 1)
            <div class="col-auto" style="border-left: 2px solid var(--border); padding-left: 12px;">
                <span style="font-size: 12px; color: var(--text-muted); font-weight: 500;">
                    <i class="fas fa-tag me-1"></i>ประเภท:
                </span>
            </div>
            <div class="col-auto">
                <a href="{{ route('inventory.items.index', array_filter(request()->query(), fn($k, $v) => $k !== 'type', ARRAY_FILTER_USE_BOTH)) }}"
                   class="erp-filter-btn {{ !request('type') ? 'active' : '' }}" style="font-size: 11px;">
                    ทั้งหมด
                </a>
            </div>
            @foreach($types as $type)
            <div class="col-auto">
                @php
                    $typeLabel = match($type) {
                        'returnable' => 'ยืม-คืน',
                        'disposable' => 'ใช้แล้วหมดไป',
                        'equipment' => 'อุปกรณ์',
                        'consumable' => 'สิ้นเปลือง',
                        default => $type
                    };
                @endphp
                <a href="{{ route('inventory.items.index', array_merge(request()->query(), ['type' => $type])) }}"
                   class="erp-filter-btn {{ request('type') == $type ? 'active' : '' }}" style="font-size: 11px;">
                    {{ $typeLabel }}
                </a>
            </div>
            @endforeach
            @endif

            @if($units->count() > 1)
            <div class="col-auto" style="border-left: 2px solid var(--border); padding-left: 12px;">
                <span style="font-size: 12px; color: var(--text-muted); font-weight: 500;">
                    <i class="fas fa-balance-scale me-1"></i>หน่วยนับ:
                </span>
            </div>
            <div class="col-auto">
                <a href="{{ route('inventory.items.index', array_filter(request()->query(), fn($k, $v) => $k !== 'unit', ARRAY_FILTER_USE_BOTH)) }}"
                   class="erp-filter-btn {{ !request('unit') ? 'active' : '' }}" style="font-size: 11px;">
                    ทั้งหมด
                </a>
            </div>
            @foreach($units as $unit)
            <div class="col-auto">
                <a href="{{ route('inventory.items.index', array_merge(request()->query(), ['unit' => $unit])) }}"
                   class="erp-filter-btn {{ request('unit') == $unit ? 'active' : '' }}" style="font-size: 11px;">
                    {{ $unit }}
                </a>
            </div>
            @endforeach
            @endif

            <div class="col"></div>
            <div class="col-auto">
                <span style="font-size: 12px; color: var(--text-muted); font-weight: 500;">
                    <i class="fas fa-sort me-1"></i>เรียง:
                </span>
            </div>
            <div class="col-auto">
                <a href="{{ route('inventory.items.index', array_merge(request()->query(), ['sort' => 'latest'])) }}"
                   class="erp-filter-btn {{ request('sort', 'latest') == 'latest' ? 'active' : '' }}" style="font-size: 11px;">
                    <i class="fas fa-clock me-1"></i>ใหม่สุด
                </a>
            </div>
            <div class="col-auto">
                <a href="{{ route('inventory.items.index', array_merge(request()->query(), ['sort' => 'oldest'])) }}"
                   class="erp-filter-btn {{ request('sort') == 'oldest' ? 'active' : '' }}" style="font-size: 11px;">
                    <i class="fas fa-history me-1"></i>เก่าสุด
                </a>
            </div>
            <div class="col-auto">
                <a href="{{ route('inventory.items.index', array_merge(request()->query(), ['sort' => 'name'])) }}"
                   class="erp-filter-btn {{ request('sort') == 'name' ? 'active' : '' }}" style="font-size: 11px;">
                    <i class="fas fa-sort-alpha-down me-1"></i>ชื่อ A-Z
                </a>
            </div>
            <div class="col-auto">
                <a href="{{ route('inventory.items.index', array_merge(request()->query(), ['sort' => 'stock'])) }}"
                   class="erp-filter-btn {{ request('sort') == 'stock' ? 'active' : '' }}" style="font-size: 11px;">
                    <i class="fas fa-sort-amount-down me-1"></i>สต๊อกมากสุด
                </a>
            </div>
        </div>
        
        @if(request()->hasAny(['category', 'type', 'unit', 'status', 'search']))
        <div style="margin-top: 10px; padding-top: 10px; border-top: 1px solid var(--border);">
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <span style="font-size: 11px; color: var(--text-muted); font-weight: 500;">
                    <i class="fas fa-info-circle me-1"></i>กำลังกรอง:
                </span>
                @if(request('search'))
                    <span class="erp-badge" style="background: rgba(99,102,241,0.1); color: #6366f1; font-size: 11px;">
                        <i class="fas fa-search me-1"></i>ค้นหา: "{{ request('search') }}"
                        <a href="{{ route('inventory.items.index', array_filter(request()->query(), fn($k, $v) => $k !== 'search', ARRAY_FILTER_USE_BOTH)) }}" style="color: inherit; margin-left: 4px;">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                @endif
                @if(request('status'))
                    <span class="erp-badge" style="background: rgba(99,102,241,0.1); color: #6366f1; font-size: 11px;">
                        สถานะ: {{ request('status') }}
                        <a href="{{ route('inventory.items.index', array_filter(request()->query(), fn($k, $v) => $k !== 'status', ARRAY_FILTER_USE_BOTH)) }}" style="color: inherit; margin-left: 4px;">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                @endif
                @if(request('category'))
                    <span class="erp-badge" style="background: rgba(16,185,129,0.1); color: #10b981; font-size: 11px;">
                        หมวดหมู่: {{ request('category') }}
                        <a href="{{ route('inventory.items.index', array_filter(request()->query(), fn($k, $v) => $k !== 'category', ARRAY_FILTER_USE_BOTH)) }}" style="color: inherit; margin-left: 4px;">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                @endif
                @if(request('type'))
                    <span class="erp-badge" style="background: rgba(59,130,246,0.1); color: #3b82f6; font-size: 11px;">
                        ประเภท: {{ request('type') }}
                        <a href="{{ route('inventory.items.index', array_filter(request()->query(), fn($k, $v) => $k !== 'type', ARRAY_FILTER_USE_BOTH)) }}" style="color: inherit; margin-left: 4px;">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                @endif
                @if(request('unit'))
                    <span class="erp-badge" style="background: rgba(245,158,11,0.1); color: #f59e0b; font-size: 11px;">
                        หน่วยนับ: {{ request('unit') }}
                        <a href="{{ route('inventory.items.index', array_filter(request()->query(), fn($k, $v) => $k !== 'unit', ARRAY_FILTER_USE_BOTH)) }}" style="color: inherit; margin-left: 4px;">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                @endif
                <a href="{{ route('inventory.items.index') }}" style="font-size: 11px; color: #ef4444; text-decoration: underline;">
                    <i class="fas fa-redo me-1"></i>ล้างตัวกรองทั้งหมด
                </a>
            </div>
        </div>
        @endif
    </div>
</div>

<div class="erp-card">
    <div class="erp-table-wrap">
        <table class="erp-table">
            <thead>
                <tr>
                    <th style="width: 80px;">รูปภาพ</th>
                    <th>รหัส</th>
                    <th>ชื่อสินค้า</th>
                    <th>หมวดหมู่</th>
                    <th>ประเภท</th>
                    <th style="text-align: right;">คงเหลือ</th>
                    <th>หน่วย</th>
                    <th>สถานะ</th>
                    <th style="text-align: center;">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td style="text-align: center;">
                            @if(!empty($item->image_url))
                                <img src="{{ asset('storage/' . $item->image_url) }}"
                                     alt="{{ $item->name }}"
                                     style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; border: 2px solid var(--border); cursor: pointer; display: block;"
                                     loading="lazy"
                                     title="คลิกเพื่อดูภาพใหญ่: {{ $item->name }}"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                     onclick="showImageModal(this.src, '{{ addslashes($item->name) }}')">
                                <div style="display: none; width: 60px; height: 60px; border-radius: 8px; background: var(--input-bg); align-items: center; justify-content: center; border: 2px dashed var(--border);">
                                    <i class="fas fa-image" style="color: var(--text-muted); font-size: 18px;"></i>
                                </div>
                            @else
                                <div style="width: 60px; height: 60px; border-radius: 8px; background: var(--input-bg); display: inline-flex; align-items: center; justify-content: center; border: 2px dashed var(--border);">
                                    <i class="fas fa-box" style="color: var(--text-muted); font-size: 18px;"></i>
                                </div>
                            @endif
                        </td>
                        <td><strong style="color: var(--text-primary);">{{ $item->item_code }}</strong></td>
                        <td style="color: var(--text-secondary);">{{ $item->name }}</td>
                        <td>
                            @if($item->category)
                                <span class="erp-badge" style="background: rgba(16,185,129,0.12); color: #10b981;">
                                    <i class="fas fa-folder me-1"></i>{{ $item->category->name }}
                                </span>
                            @else
                                <span style="color: var(--text-muted); font-size: 11px;">-</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $typeBadge = match($item->type) {
                                    'returnable' => ['bg' => 'rgba(56,189,248,0.12)', 'color' => '#38bdf8', 'text' => '🔧 ยืม-คืน'],
                                    'disposable' => ['bg' => 'rgba(107,114,128,0.12)', 'color' => '#9ca3af', 'text' => '📦 ใช้แล้วหมดไป'],
                                    'equipment' => ['bg' => 'rgba(167,139,250,0.12)', 'color' => '#a78bfa', 'text' => '🔧 อุปกรณ์'],
                                    'consumable' => ['bg' => 'rgba(251,191,36,0.12)', 'color' => '#fbbf24', 'text' => '🧴 สิ้นเปลือง'],
                                    default => ['bg' => 'rgba(107,114,128,0.12)', 'color' => '#6b7280', 'text' => $item->type]
                                };
                            @endphp
                            <span class="erp-badge" style="background: {{ $typeBadge['bg'] }}; color: {{ $typeBadge['color'] }};">
                                {{ $typeBadge['text'] }}
                            </span>
                        </td>
                        <td style="text-align: right; color: var(--text-secondary);">{{ number_format($item->current_stock) }}</td>
                        <td style="color: var(--text-secondary);">{{ $item->unit }}</td>
                        <td>
                            @if ($item->status == 'available')
                                <span class="erp-badge" style="background: rgba(52,211,153,0.12); color: #34d399;">
                                    <i class="fas fa-check me-1"></i>พร้อมใช้งาน
                                </span>
                            @elseif ($item->status == 'maintenance')
                                <span class="erp-badge" style="background: rgba(251,191,36,0.12); color: #fbbf24;">
                                    <i class="fas fa-wrench me-1"></i>ซ่อมบำรุง
                                </span>
                            @else
                                <span class="erp-badge" style="background: rgba(239,68,68,0.12); color: #f87171;">
                                    <i class="fas fa-times me-1"></i>ไม่พร้อมใช้งาน
                                </span>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            <div class="d-flex gap-1 justify-content-center">
                                <a href="{{ route('inventory.items.show', $item->id) }}"
                                    class="erp-btn-secondary" title="ดูรายละเอียด" style="padding: 4px 8px; font-size: 12px;">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('inventory.items.edit', $item->id) }}"
                                    class="erp-btn-secondary" title="แก้ไข" style="padding: 4px 8px; font-size: 12px;">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@if($items->hasPages())
    <div style="padding: 16px; border-top: 1px solid var(--border);">
        <div class="d-flex justify-content-between align-items-center">
            <div style="font-size: 13px; color: var(--text-secondary);">
                แสดง <strong style="color: var(--text-primary);">{{ $items->firstItem() }}</strong> ถึง <strong style="color: var(--text-primary);">{{ $items->lastItem() }}</strong> จาก <strong style="color: var(--text-primary);">{{ $items->total() }}</strong> รายการ
            </div>
            {{ $items->links() }}
        </div>
    </div>
@endif

{{-- Image Modal --}}
<div id="imageModal" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(0,0,0,0.85); align-items: center; justify-content: center;" onclick="closeImageModal()">
    <div style="position: relative; max-width: 90vw; max-height: 90vh;" onclick="event.stopPropagation()">
        <button onclick="closeImageModal()" style="position: absolute; top: -40px; right: 0; background: none; border: none; color: white; font-size: 24px; cursor: pointer;">
            <i class="fas fa-times"></i>
        </button>
        <img id="modalImage" src="" alt="" style="max-width: 100%; max-height: 85vh; border-radius: 12px; box-shadow: 0 8px 32px rgba(0,0,0,0.5);">
        <div id="modalTitle" style="text-align: center; color: white; margin-top: 12px; font-size: 14px;"></div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Image Modal
function showImageModal(src, title) {
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImage');
    const modalTitle = document.getElementById('modalTitle');
    modal.style.display = 'flex';
    modalImg.src = src;
    modalTitle.textContent = title;
}

function closeImageModal() {
    document.getElementById('imageModal').style.display = 'none';
}

// ปิดด้วย ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});

// Instant Search with Debounce
let searchTimeout;
const searchInput = document.getElementById('instantSearch');
const searchStatus = document.getElementById('searchStatus');

if (searchInput) {
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.trim();
        const currentUrl = new URL(window.location.href);
        
        // Clear previous timeout
        clearTimeout(searchTimeout);
        
        // Show searching status
        if (searchTerm.length > 0) {
            searchStatus.style.display = 'block';
        } else {
            searchStatus.style.display = 'none';
        }
        
        // Debounce: wait 500ms before submitting
        searchTimeout = setTimeout(function() {
            if (searchTerm.length > 0) {
                // Build URL with current query params
                currentUrl.searchParams.set('search', searchTerm);
                window.location.href = currentUrl.toString();
            } else if (currentUrl.searchParams.get('search')) {
                // Clear search if empty
                currentUrl.searchParams.delete('search');
                window.location.href = currentUrl.toString();
            }
        }, 500);
    });
    
    // Focus on load if has search term
    if (searchInput.value.length > 0) {
        searchInput.select();
    }
}
</script>
@endpush
