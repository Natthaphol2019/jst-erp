@extends('layouts.app')

@section('title', 'ยืมอุปกรณ์ - JST ERP')

@push('styles')
<style>
/* Item Selection Grid - Responsive */
.item-selection-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 16px;
    max-height: 600px;
    overflow-y: auto;
    padding: 8px;
}

@media (max-width: 768px) {
    .item-selection-grid {
        grid-template-columns: 1fr;
        max-height: 400px;
        gap: 12px;
    }
}

@media (min-width: 769px) and (max-width: 1024px) {
    .item-selection-grid {
        grid-template-columns: repeat(2, 1fr);
        max-height: 500px;
    }
}

/* Item Card - Large touch targets */
.item-card {
    border: 2px solid var(--border);
    border-radius: 12px;
    padding: 16px;
    background: var(--bg-surface);
    cursor: pointer;
    transition: all 0.2s ease;
    position: relative;
    user-select: none;
}

.item-card:hover {
    border-color: var(--accent-light);
    box-shadow: 0 4px 12px rgba(129, 140, 248, 0.15);
    transform: translateY(-2px);
}

.item-card.selected {
    border-color: var(--accent-light);
    background: rgba(99, 102, 241, 0.08);
    box-shadow: 0 4px 16px rgba(129, 140, 248, 0.25);
}

.item-card.selected::after {
    content: '\f058';
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    position: absolute;
    top: 12px;
    right: 12px;
    font-size: 24px;
    color: var(--accent-light);
}

.item-card .item-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    background: linear-gradient(135deg, #818cf8 0%, #6366f1 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 12px;
    font-size: 28px;
    color: white;
    overflow: hidden;
    flex-shrink: 0;
}

.item-card .item-icon img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.item-card .item-icon .icon-placeholder {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
}

.item-card .item-image-wrapper {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 12px;
    flex-shrink: 0;
    border: 2px solid var(--border);
    background: var(--input-bg);
    display: flex;
    align-items: center;
    justify-content: center;
}

.item-card .item-image-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.item-card .item-image-wrapper .icon-fallback {
    display: none;
    color: var(--text-muted);
    font-size: 24px;
}

.item-card .item-image-wrapper img:not([src]) + .icon-fallback,
.item-card .item-image-wrapper img[src=""] + .icon-fallback {
    display: flex;
}

.item-card .item-name {
    font-size: 15px;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 8px;
    line-height: 1.4;
    padding-right: 30px;
}

.item-card .item-stock {
    font-size: 13px;
    color: var(--text-secondary);
    display: flex;
    align-items: center;
    gap: 6px;
}

.item-card .item-stock strong {
    color: #10b981;
    font-size: 14px;
}

.item-card.out-of-stock {
    opacity: 0.5;
    cursor: not-allowed;
    pointer-events: none;
}

.item-card.out-of-stock .item-icon,
.item-card.out-of-stock .item-image-wrapper {
    background: linear-gradient(135deg, #9ca3af 0%, #6b7280 100%);
}

/* Selected Items List */
.selected-items-container {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.selected-item-card {
    border: 2px solid var(--border);
    border-radius: 10px;
    padding: 12px 16px;
    background: var(--bg-surface);
    display: flex;
    align-items: center;
    gap: 12px;
    transition: all 0.2s ease;
}

.selected-item-card:hover {
    border-color: var(--accent-light);
    box-shadow: 0 2px 8px rgba(129, 140, 248, 0.1);
}

.selected-item-card .item-image {
    width: 50px;
    height: 50px;
    border-radius: 8px;
    overflow: hidden;
    flex-shrink: 0;
    border: 2px solid var(--border);
    background: var(--input-bg);
    display: flex;
    align-items: center;
    justify-content: center;
}

.selected-item-card .item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.selected-item-card .item-image .icon-fallback {
    display: none;
    color: var(--text-muted);
    font-size: 20px;
}

.selected-item-card .item-info {
    flex: 1;
}

.selected-item-card .item-name {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 4px;
}

.selected-item-card .item-stock-info {
    font-size: 12px;
    color: var(--text-muted);
}

.quantity-control {
    display: flex;
    align-items: center;
    gap: 8px;
}

.quantity-btn {
    width: 36px;
    height: 36px;
    border: 2px solid var(--border);
    border-radius: 8px;
    background: var(--bg-surface);
    color: var(--text-primary);
    font-size: 18px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.quantity-btn:hover {
    border-color: var(--accent-light);
    background: rgba(99, 102, 241, 0.08);
    color: var(--accent);
}

.quantity-btn:active {
    transform: scale(0.95);
}

.quantity-display {
    min-width: 60px;
    text-align: center;
    font-size: 18px;
    font-weight: 700;
    color: var(--accent);
    padding: 6px 12px;
    background: var(--input-bg);
    border-radius: 8px;
    border: 2px solid var(--border);
}

.remove-item-btn {
    width: 36px;
    height: 36px;
    border: 2px solid rgba(239, 68, 68, 0.2);
    border-radius: 8px;
    background: rgba(239, 68, 68, 0.1);
    color: #ef4444;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.remove-item-btn:hover {
    background: rgba(239, 68, 68, 0.2);
    border-color: #ef4444;
}

/* Search Input */
.item-search-input {
    width: 100%;
    padding: 12px 16px 12px 44px;
    border: 2px solid var(--border);
    border-radius: 10px;
    font-size: 15px;
    background: var(--input-bg);
    color: var(--text-primary);
    transition: all 0.2s ease;
}

.item-search-input:focus {
    outline: none;
    border-color: var(--accent-light);
    box-shadow: 0 0 0 3px rgba(129, 140, 248, 0.1);
}

.search-wrapper {
    position: relative;
}

.search-wrapper .search-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted);
    font-size: 16px;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 40px 20px;
    color: var(--text-muted);
}

.empty-state i {
    font-size: 48px;
    margin-bottom: 16px;
    opacity: 0.5;
}

/* Summary Badge */
.summary-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    background: rgba(99, 102, 241, 0.08);
    border: 2px solid var(--accent-light);
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
    color: var(--accent);
    margin-bottom: 16px;
}

.summary-badge i {
    font-size: 16px;
}
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            <i class="fas fa-hand-holding me-2" style="color: #818cf8;"></i>ยืมอุปกรณ์
        </h4>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">ยื่นคำขอยืมอุปกรณ์จากคลัง</p>
    </div>
    <a href="{{ route('employee.borrowings') }}" class="erp-btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>กลับ
    </a>
</div>

@if($errors->any())
    <div class="erp-alert erp-alert-danger mb-4" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>{{ $errors->first() }}
    </div>
@endif

<form action="{{ route('employee.borrowing.store') }}" method="POST" id="borrowingForm">
    @csrf
    <div class="row g-3">
        {{-- Left Column - Main Info --}}
        <div class="col-lg-5 col-md-6">
            <div class="erp-card mb-3">
                <div class="erp-card-header">
                    <span class="erp-card-title">
                        <i class="fas fa-info-circle me-2" style="color: #818cf8;"></i>ข้อมูลใบยืม
                    </span>
                </div>
                <div class="erp-card-body">
                    <div class="mb-3">
                        <label for="employee_id" class="erp-label">ผู้ยืม <span style="color: #f87171;">*</span></label>
                        <input type="text" class="erp-input" value="{{ $employees->first()->employee_code }} - {{ $employees->first()->firstname }} {{ $employees->first()->lastname }}" readonly>
                        <input type="hidden" name="employee_id" value="{{ $employees->first()->id }}">
                    </div>

                    <div class="row g-3">
                        <div class="col-6 mb-3">
                            <label for="borrow_date" class="erp-label">วันที่ยืม <span style="color: #f87171;">*</span></label>
                            <input type="date" name="borrow_date" id="borrow_date"
                                   class="erp-input @error('borrow_date') is-invalid @enderror"
                                   value="{{ old('borrow_date', date('Y-m-d')) }}" required>
                            @error('borrow_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label for="expected_return_date" class="erp-label">กำหนดคืน <span style="color: #f87171;">*</span></label>
                            <input type="date" name="expected_return_date" id="expected_return_date"
                                   class="erp-input @error('expected_return_date') is-invalid @enderror"
                                   value="{{ old('expected_return_date') }}" required>
                            @error('expected_return_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="note" class="erp-label">หมายเหตุ</label>
                        <textarea name="note" id="note" rows="3"
                                  class="erp-input @error('note') is-invalid @enderror"
                                  placeholder="เหตุผลในการยืม">{{ old('note') }}</textarea>
                        @error('note')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column - Items Selection --}}
        <div class="col-lg-7 col-md-6">
            <div class="erp-card">
                <div class="erp-card-header">
                    <span class="erp-card-title">
                        <i class="fas fa-box me-2" style="color: #818cf8;"></i>เลือกรายการสินค้ายืม
                    </span>
                </div>
                <div class="erp-card-body">
                    {{-- Search & Filter --}}
                    <div class="mb-3">
                        <div class="search-wrapper">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" id="itemSearch" class="item-search-input" placeholder="ค้นหาสินค้า...">
                        </div>
                    </div>

                    {{-- Selected Items Summary --}}
                    <div id="selectedItemsSummary" style="display: none;">
                        <div class="summary-badge">
                            <i class="fas fa-shopping-cart"></i>
                            <span id="selectedCount">0</span> รายการที่เลือก
                        </div>
                    </div>

                    {{-- Items Grid --}}
                    <div class="item-selection-grid" id="itemsGrid">
                        @forelse($items as $item)
                            <div class="item-card"
                                 data-item-id="{{ $item->id }}"
                                 data-item-name="{{ $item->name }}"
                                 data-item-stock="{{ $item->current_stock }}"
                                 data-item-type="{{ $item->type }}"
                                 data-item-image="{{ $item->image_url ?? '' }}"
                                 @if($item->current_stock == 0) style="pointer-events: none; opacity: 0.5;" @endif>
                                @if($item->image_url)
                                    <div class="item-image-wrapper">
                                        <img src="{{ asset('storage/' . $item->image_url) }}" 
                                             alt="{{ $item->name }}"
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="icon-fallback" style="display: none;">
                                            <i class="fas fa-box-open"></i>
                                        </div>
                                    </div>
                                @else
                                    <div class="item-icon">
                                        <i class="fas fa-box-open"></i>
                                    </div>
                                @endif
                                <div class="item-name">{{ $item->name }}</div>
                                <div class="item-stock">
                                    <i class="fas fa-warehouse"></i>
                                    คงเหลือ: <strong>{{ $item->current_stock }}</strong> {{ $item->unit }}
                                </div>
                                @if($item->current_stock == 0)
                                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: rgba(0,0,0,0.7); color: white; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600;">
                                        สินค้าหมด
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="empty-state" style="grid-column: 1/-1;">
                                <i class="fas fa-inbox"></i>
                                <p>ไม่มีสินค้าให้เลือก</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Selected Items List --}}
                    <div id="selectedItemsContainer" style="margin-top: 20px; display: none;">
                        <h6 style="font-weight: 600; color: var(--text-primary); margin-bottom: 12px;">
                            <i class="fas fa-check-circle me-2" style="color: #818cf8;"></i>รายการที่เลือก
                        </h6>
                        <div class="selected-items-container" id="selectedItemsList"></div>
                    </div>

                    {{-- Hidden inputs for form submission --}}
                    <div id="hiddenInputs" style="display: none;"></div>

                    <div class="erp-alert erp-alert-info mt-3">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>หมายเหตุ:</strong> ใบยืมต้องได้รับการอนุมัติจากแอดมิน/คลังสินค้า
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Submit Button --}}
    <div class="row mt-3">
        <div class="col-12">
            <div class="erp-card">
                <div class="erp-card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted" style="font-size: 14px;">
                            <i class="fas fa-lightbulb me-2"></i>เลือกสินค้า: <strong id="totalItems">0</strong> รายการ | รวม: <strong id="totalQuantity">0</strong> {{ $items->first()?->unit ?? 'ชิ้น' }}
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('employee.borrowings') }}" class="erp-btn-secondary">
                                <i class="fas fa-times me-2"></i>ยกเลิก
                            </a>
                            <button type="submit" class="erp-btn-primary" id="submitBtn" disabled>
                                <i class="fas fa-check me-2"></i>ยื่นคำขอยืม
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
// Store selected items
const selectedItems = new Map();

// Initialize with old input if exists
@if(old('items'))
    @foreach(old('items') as $oldItem)
        @php
            $item = $items->firstWhere('id', $oldItem['item_id']);
        @endphp
        @if($item)
            selectedItems.set({{ $item->id }}, {
                id: {{ $item->id }},
                name: '{{ $item->name }}',
                stock: {{ $item->current_stock }},
                unit: '{{ $item->unit }}',
                quantity: {{ $oldItem['quantity'] }},
                image: '{{ $item->image_url ? url("storage/" . $item->image_url) : "" }}'
            });
        @endif
    @endforeach
@endif

// Handle item card click
document.querySelectorAll('.item-card').forEach(card => {
    card.addEventListener('click', function() {
        const itemId = parseInt(this.dataset.itemId);
        const stock = parseInt(this.dataset.itemStock);
        const imageUrl = this.dataset.itemImage || '';
        
        if (stock === 0) return;

        if (selectedItems.has(itemId)) {
            // Deselect
            selectedItems.delete(itemId);
            this.classList.remove('selected');
        } else {
            // Select
            selectedItems.set(itemId, {
                id: itemId,
                name: this.dataset.itemName,
                stock: stock,
                unit: '{{ $items->first()?->unit ?? "ชิ้น" }}',
                quantity: 1,
                image: imageUrl ? '{{ url("storage") }}/' + imageUrl : ''
            });
            this.classList.add('selected');
        }

        updateSelectedItems();
    });
});

// Update selected items display
function updateSelectedItems() {
    const container = document.getElementById('selectedItemsContainer');
    const list = document.getElementById('selectedItemsList');
    const hiddenInputs = document.getElementById('hiddenInputs');
    const summary = document.getElementById('selectedItemsSummary');
    const count = document.getElementById('selectedCount');
    const totalItems = document.getElementById('totalItems');
    const totalQuantity = document.getElementById('totalQuantity');
    const submitBtn = document.getElementById('submitBtn');

    // Clear
    list.innerHTML = '';
    hiddenInputs.innerHTML = '';

    if (selectedItems.size === 0) {
        container.style.display = 'none';
        summary.style.display = 'none';
        submitBtn.disabled = true;
        totalItems.textContent = '0';
        totalQuantity.textContent = '0';
        return;
    }

    container.style.display = 'block';
    summary.style.display = 'block';
    submitBtn.disabled = false;
    count.textContent = selectedItems.size;
    totalItems.textContent = selectedItems.size;

    let totalQty = 0;

    selectedItems.forEach((item, index) => {
        totalQty += item.quantity;

        // Create selected item card
        const card = document.createElement('div');
        card.className = 'selected-item-card';
        
        const imageHtml = item.image 
            ? `<div class="item-image">
                   <img src="${item.image}" alt="${item.name}" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                   <div class="icon-fallback" style="display:none;"><i class="fas fa-box-open"></i></div>
               </div>`
            : `<div class="item-image" style="background: linear-gradient(135deg, #818cf8 0%, #6366f1 100%);">
                   <i class="fas fa-box-open" style="color: white; font-size: 20px;"></i>
               </div>`;
        
        card.innerHTML = `
            ${imageHtml}
            <div class="item-info">
                <div class="item-name">${item.name}</div>
                <div class="item-stock-info">คงเหลือ: ${item.stock} ${item.unit}</div>
            </div>
            <div class="quantity-control">
                <button type="button" class="quantity-btn" onclick="updateQuantity(${item.id}, -1)">−</button>
                <div class="quantity-display" id="qty-${item.id}">${item.quantity}</div>
                <button type="button" class="quantity-btn" onclick="updateQuantity(${item.id}, 1)">+</button>
            </div>
            <button type="button" class="remove-item-btn" onclick="removeItem(${item.id})">
                <i class="fas fa-times"></i>
            </button>
        `;
        list.appendChild(card);

        // Create hidden input
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = `items[${index}][item_id]`;
        input.value = item.id;
        hiddenInputs.appendChild(input);

        const qtyInput = document.createElement('input');
        qtyInput.type = 'hidden';
        qtyInput.name = `items[${index}][quantity]`;
        qtyInput.value = item.quantity;
        qtyInput.id = `qty-input-${item.id}`;
        hiddenInputs.appendChild(qtyInput);
    });

    totalQuantity.textContent = totalQty;
}

// Update quantity
function updateQuantity(itemId, change) {
    const item = selectedItems.get(itemId);
    if (!item) return;

    const newQty = item.quantity + change;
    if (newQty < 1 || newQty > item.stock) {
        if (newQty > item.stock) {
            alert(`จำนวนที่ระบุเกินคงเหลือ (คงเหลือ: ${item.stock})`);
        }
        return;
    }

    item.quantity = newQty;
    document.getElementById(`qty-${itemId}`).textContent = newQty;
    document.getElementById(`qty-input-${itemId}`).value = newQty;

    // Update total
    let totalQty = 0;
    selectedItems.forEach(i => totalQty += i.quantity);
    document.getElementById('totalQuantity').textContent = totalQty;
}

// Remove item
function removeItem(itemId) {
    selectedItems.delete(itemId);
    const card = document.querySelector(`.item-card[data-item-id="${itemId}"]`);
    if (card) card.classList.remove('selected');
    updateSelectedItems();
}

// Search functionality
document.getElementById('itemSearch').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    document.querySelectorAll('.item-card').forEach(card => {
        const name = card.dataset.itemName.toLowerCase();
        if (name.includes(searchTerm)) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
});

// Form validation
document.getElementById('borrowingForm').addEventListener('submit', function(e) {
    if (selectedItems.size === 0) {
        e.preventDefault();
        alert('กรุณาเลือกสินค้าอย่างน้อย 1 รายการ');
        return false;
    }
});
</script>
@endpush
@endsection
