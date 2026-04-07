@extends('layouts.app')

@section('title', 'สร้างใบยืมใหม่ - JST ERP')

@push('styles')
<style>
/* Item Selection Grid - Responsive */
.item-selection-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 16px;
    max-height: 650px;
    overflow-y: auto;
    padding: 8px;
}

@media (max-width: 768px) {
    .item-selection-grid {
        grid-template-columns: 1fr;
        max-height: 450px;
        gap: 12px;
    }
}

@media (min-width: 769px) and (max-width: 1024px) {
    .item-selection-grid {
        grid-template-columns: repeat(2, 1fr);
        max-height: 550px;
    }
}

/* Item Card - Large touch targets */
.item-card {
    border: 2px solid var(--border, #e5e7eb);
    border-radius: 12px;
    padding: 14px;
    background: var(--input-bg, #f9fafb);
    cursor: pointer;
    transition: all 0.2s ease;
    position: relative;
    user-select: none;
    display: flex;
    gap: 14px;
    align-items: flex-start;
}

.item-card:hover {
    border-color: var(--accent, #818cf8);
    background: rgba(129, 140, 248, 0.08);
    box-shadow: 0 4px 12px rgba(129, 140, 248, 0.15);
    transform: translateY(-2px);
}

.item-card.selected {
    border-color: var(--accent, #818cf8);
    background: linear-gradient(135deg, rgba(99,102,241,0.08) 0%, rgba(129,140,248,0.12) 100%);
    box-shadow: 0 4px 16px rgba(129, 140, 248, 0.25);
}

.item-card.selected::after {
    content: '\f058';
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 20px;
    color: var(--accent, #818cf8);
}

.item-card .item-image {
    width: 70px;
    height: 70px;
    border-radius: 10px;
    background: linear-gradient(135deg, rgba(224,231,255,0.8) 0%, rgba(199,210,254,0.8) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    flex-shrink: 0;
    border: 2px solid rgba(129,140,248,0.15);
}

.item-card .item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.item-card .item-image i {
    font-size: 32px;
    color: var(--accent, #818cf8);
}

.item-card .item-info {
    flex: 1;
    min-width: 0;
}

.item-card .item-name {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-primary, #1f2937);
    margin-bottom: 6px;
    line-height: 1.4;
    padding-right: 25px;
    word-wrap: break-word;
}

.item-card .item-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-bottom: 6px;
}

.item-card .item-badge {
    display: inline-block;
    padding: 3px 8px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 600;
    background: var(--input-bg, #f3f4f6);
    color: var(--text-secondary, #6b7280);
    border: 1px solid var(--border, #e5e7eb);
}

.item-card .item-badge.type-returnable {
    background: rgba(167, 139, 250, 0.15);
    color: #a78bfa;
}

.item-card .item-badge.type-equipment {
    background: rgba(96, 165, 250, 0.15);
    color: #60a5fa;
}

.item-card .item-stock {
    font-size: 13px;
    color: var(--text-secondary, #6b7280);
    display: flex;
    align-items: center;
    gap: 5px;
}

.item-card .item-stock strong {
    color: #059669;
    font-size: 14px;
}

.item-card.out-of-stock {
    opacity: 0.5;
    cursor: not-allowed;
    pointer-events: none;
}

.item-card.out-of-stock .item-image {
    background: linear-gradient(135deg, #d1d5db 0%, #9ca3af 100%);
}

.item-card.out-of-stock .item-image i {
    color: #6b7280;
}

/* Filter Section */
.filter-section {
    background: var(--bg-raised, #f9fafb);
    border: 2px solid var(--border, #e5e7eb);
    border-radius: 10px;
    padding: 14px;
    margin-bottom: 16px;
    transition: all 0.2s ease;
}

.filter-group {
    margin-bottom: 12px;
}

.filter-group:last-child {
    margin-bottom: 0;
}

.filter-label {
    font-size: 12px;
    font-weight: 600;
    color: var(--text-muted, #6b7280);
    margin-bottom: 8px;
    display: block;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.filter-tabs {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.filter-tab {
    padding: 7px 14px;
    border: 2px solid var(--border, #e5e7eb);
    border-radius: 8px;
    background: var(--bg-surface, white);
    color: var(--text-primary, #1f2937);
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    white-space: nowrap;
}

.filter-tab:hover {
    border-color: #818cf8;
    color: #818cf8;
    background: rgba(129, 140, 248, 0.05);
}

.filter-tab.active {
    background: #818cf8;
    border-color: #818cf8;
    color: white;
}

/* Search Input */
.item-search-input {
    width: 100%;
    padding: 11px 14px 11px 42px;
    border: 2px solid var(--border, #e5e7eb);
    border-radius: 10px;
    font-size: 14px;
    transition: all 0.2s ease;
}

.item-search-input:focus {
    outline: none;
    border-color: #818cf8;
    box-shadow: 0 0 0 3px rgba(129, 140, 248, 0.1);
}

.search-wrapper {
    position: relative;
    margin-bottom: 14px;
}

.search-wrapper .search-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted, #9ca3af);
    font-size: 15px;
}

/* Selected Items List */
.selected-items-container {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.selected-item-card {
    border: 2px solid var(--border, #e5e7eb);
    border-radius: 10px;
    padding: 12px 14px;
    background: var(--bg-surface, white);
    display: flex;
    align-items: center;
    gap: 12px;
    transition: all 0.2s ease;
}

.selected-item-card:hover {
    border-color: #818cf8;
    box-shadow: 0 2px 8px rgba(129, 140, 248, 0.1);
}

.selected-item-card .item-info {
    flex: 1;
    min-width: 0;
}

.selected-item-card .item-name {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-primary, #1f2937);
    margin-bottom: 4px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.selected-item-card .item-stock-info {
    font-size: 12px;
    color: var(--text-muted, #6b7280);
}

.quantity-control {
    display: flex;
    align-items: center;
    gap: 6px;
    flex-shrink: 0;
}

.quantity-btn {
    width: 34px;
    height: 34px;
    border: 2px solid var(--border, #e5e7eb);
    border-radius: 8px;
    background: var(--bg-surface, white);
    color: var(--text-primary, #1f2937);
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.quantity-btn:hover {
    border-color: #818cf8;
    background: rgba(129,140,248,0.08);
    color: #818cf8;
}

.quantity-btn:active {
    transform: scale(0.95);
}

.quantity-display {
    min-width: 55px;
    text-align: center;
    font-size: 16px;
    font-weight: 700;
    color: #818cf8;
    padding: 5px 10px;
    background: rgba(129,140,248,0.08);
    border-radius: 8px;
    border: 2px solid rgba(129,140,248,0.2);
}

.remove-item-btn {
    width: 34px;
    height: 34px;
    border: 2px solid rgba(239,68,68,0.2);
    border-radius: 8px;
    background: rgba(239,68,68,0.08);
    color: #ef4444;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    flex-shrink: 0;
}

.remove-item-btn:hover {
    background: #fee2e2;
    border-color: #ef4444;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 40px 20px;
    color: var(--text-muted, #6b7280);
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
    padding: 8px 14px;
    background: linear-gradient(135deg, #f0f9ff 0%, #e0e7ff 100%);
    border: 2px solid #818cf8;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    color: #6366f1;
    margin-bottom: 14px;
}

.summary-badge i {
    font-size: 14px;
}

/* Scrollbar Styling */
.item-selection-grid::-webkit-scrollbar {
    width: 8px;
}

.item-selection-grid::-webkit-scrollbar-track {
    background: #f3f4f6;
    border-radius: 10px;
}

.item-selection-grid::-webkit-scrollbar-thumb {
    background: #d1d5db;
    border-radius: 10px;
}

.item-selection-grid::-webkit-scrollbar-thumb:hover {
    background: #9ca3af;
}
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            <i class="fas fa-plus me-2" style="color: #818cf8;"></i>สร้างใบยืมใหม่
        </h4>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">สร้างใบยืมอุปกรณ์ใหม่</p>
    </div>
    <a href="{{ route('inventory.borrowing.index') }}" class="erp-btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>กลับ
    </a>
</div>

@if($errors->any())
    <div class="erp-alert erp-alert-danger mb-4" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>{{ $errors->first() }}
    </div>
@endif

<form action="{{ route('inventory.borrowing.store') }}" method="POST" id="borrowingForm">
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
                        <select name="employee_id" id="employee_id" class="erp-select @error('employee_id') is-invalid @enderror" required>
                            <option value="">-- เลือกพนักงาน --</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->employee_code }} - {{ $employee->firstname }} {{ $employee->lastname }}
                                </option>
                            @endforeach
                        </select>
                        @error('employee_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
                                  placeholder="บันทึกเพิ่มเติม (ถ้ามี)">{{ old('note') }}</textarea>
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
                    <div class="search-wrapper">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" id="itemSearch" class="item-search-input" placeholder="ค้นหาสินค้า...">
                    </div>

                    {{-- Filter Section --}}
                    <div class="filter-section">
                        {{-- Category Filter --}}
                        @if($items->pluck('category_id')->unique()->count() > 1)
                        <div class="filter-group">
                            <label class="filter-label"><i class="fas fa-folder me-1"></i>หมวดหมู่</label>
                            <div class="filter-tabs" id="categoryFilters">
                                <button type="button" class="filter-tab active" data-filter="all" data-type="category">ทั้งหมด</button>
                                @foreach($items->unique('category_id')->pluck('category.name', 'category_id')->filter() as $catName)
                                    <button type="button" class="filter-tab" data-filter="{{ $catName }}" data-type="category">{{ $catName }}</button>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        {{-- Unit Filter --}}
                        @if($items->pluck('unit')->unique()->count() > 1)
                        <div class="filter-group">
                            <label class="filter-label"><i class="fas fa-balance-scale me-1"></i>หน่วยนับ</label>
                            <div class="filter-tabs" id="unitFilters">
                                <button type="button" class="filter-tab active" data-filter="all" data-type="unit">ทั้งหมด</button>
                                @foreach($items->unique('unit')->pluck('unit') as $unit)
                                    <button type="button" class="filter-tab" data-filter="{{ $unit }}" data-type="unit">{{ $unit }}</button>
                                @endforeach
                            </div>
                        </div>
                        @endif
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
                                 data-item-category="{{ $item->category->name ?? '' }}"
                                 data-item-unit="{{ $item->unit }}"
                                 @if($item->current_stock == 0) style="pointer-events: none; opacity: 0.5;" @endif>
                                <div class="item-image">
                                    @if($item->image_url)
                                        <img src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->name }}" onerror="this.style.display='none'; this.parentElement.innerHTML='<i class=\'fas fa-box-open\'></i>';">
                                    @else
                                        <i class="fas fa-box-open"></i>
                                    @endif
                                </div>
                                <div class="item-info">
                                    <div class="item-name">{{ $item->name }}</div>
                                    <div class="item-meta">
                                        @if($item->category)
                                            <span class="item-badge">{{ $item->category->name }}</span>
                                        @endif
                                        <span class="item-badge type-{{ $item->type }}">{{ $item->getTypeLabel() }}</span>
                                    </div>
                                    <div class="item-stock">
                                        <i class="fas fa-warehouse"></i>
                                        คงเหลือ: <strong>{{ $item->current_stock }}</strong> {{ $item->unit }}
                                    </div>
                                </div>
                                @if($item->current_stock == 0)
                                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: rgba(0,0,0,0.7); color: white; padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; white-space: nowrap;">
                                        <i class="fas fa-ban me-1"></i>สินค้าหมด
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
                        <strong>คำแนะนำ:</strong> คลิกที่สินค้าเพื่อเลือก และปรับจำนวนที่ต้องการยืม
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
                            <a href="{{ route('inventory.borrowing.index') }}" class="erp-btn-secondary">
                                <i class="fas fa-times me-2"></i>ยกเลิก
                            </a>
                            <button type="submit" class="erp-btn-primary" id="submitBtn" disabled>
                                <i class="fas fa-check me-2"></i>สร้างใบยืม
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
                quantity: {{ $oldItem['quantity'] }}
            });
        @endif
    @endforeach
@endif

// Handle item card click
document.querySelectorAll('.item-card').forEach(card => {
    card.addEventListener('click', function() {
        const itemId = parseInt(this.dataset.itemId);
        const stock = parseInt(this.dataset.itemStock);
        
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
                quantity: 1
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
        card.innerHTML = `
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
    if (newQty < 1 || newQty > item.stock) return;

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
document.getElementById('itemSearch').addEventListener('input', applyFilters);

// Filter tab clicks
document.querySelectorAll('.filter-tab').forEach(tab => {
    tab.addEventListener('click', function() {
        const filterType = this.dataset.type;
        const filterValue = this.dataset.filter;

        // Update active state for this filter type
        document.querySelectorAll(`.filter-tab[data-type="${filterType}"]`).forEach(t => {
            t.classList.remove('active');
        });
        this.classList.add('active');

        applyFilters();
    });
});

// Apply all filters
function applyFilters() {
    const searchTerm = document.getElementById('itemSearch').value.toLowerCase();
    const activeCategory = document.querySelector('.filter-tab[data-type="category"].active')?.dataset.filter || 'all';
    const activeUnit = document.querySelector('.filter-tab[data-type="unit"].active')?.dataset.filter || 'all';

    document.querySelectorAll('.item-card').forEach(card => {
        const name = card.dataset.itemName.toLowerCase();
        const category = card.dataset.itemCategory || '';
        const unit = card.dataset.itemUnit || '';

        let show = true;

        // Search filter
        if (searchTerm && !name.includes(searchTerm)) {
            show = false;
        }

        // Category filter
        if (activeCategory !== 'all' && category !== activeCategory) {
            show = false;
        }

        // Unit filter
        if (activeUnit !== 'all' && unit !== activeUnit) {
            show = false;
        }

        card.style.display = show ? '' : 'none';
    });
}

// Form validation
let formSubmitted = false;
document.getElementById('borrowingForm').addEventListener('submit', function(e) {
    if (formSubmitted) {
        e.preventDefault();
        return false;
    }
    
    if (selectedItems.size === 0) {
        e.preventDefault();
        alert('กรุณาเลือกสินค้าอย่างน้อย 1 รายการ');
        return false;
    }
    
    // Prevent double submission
    formSubmitted = true;
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>กำลังบันทึกข้อมูล...';
});
</script>
@endpush
@endsection
