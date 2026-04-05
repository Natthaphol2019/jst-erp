@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-3xl">
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-2xl font-bold mb-0">แก้ไขข้อมูลสินค้า: {{ $item->item_code }}</h2>
            <div>
                <a href="{{ route('inventory.items.print-barcode', $item->id) }}"
                   class="btn btn-outline-primary btn-sm" target="_blank">
                    <i class="bi bi-upc-scan me-1"></i>พิมพ์บาร์โค้ด
                </a>
            </div>
        </div>

        {{-- Barcode / QR Code Preview --}}
        <div class="card mb-4">
            <div class="card-header bg-light">
                <strong><i class="bi bi-upc-scan me-1"></i> บาร์โค้ด / QR Code</strong>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-6">
                        <h6 class="text-muted">บาร์โค้ด ({{ $item->item_code }})</h6>
                        <img src="{{ route('inventory.items.barcode', $item->id) }}"
                             alt="Barcode for {{ $item->item_code }}"
                             class="img-fluid border rounded p-2"
                             style="max-height: 80px;"
                             loading="lazy">
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">QR Code</h6>
                        <img src="{{ route('inventory.items.qrcode', $item->id) }}"
                             alt="QR Code for {{ $item->name }}"
                             class="img-fluid border rounded p-2"
                             style="max-height: 120px; max-width: 120px;"
                             loading="lazy">
                    </div>
                </div>
            </div>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4">
                <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Image Upload Section --}}
        @include('components.image-upload', [
            'entity' => $item,
            'type' => 'item',
            'route' => route('uploads.item', $item->id)
        ])

        <form action="{{ route('inventory.items.update', $item->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">รหัสสินค้า *</label>
                    <input type="text" name="item_code" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" value="{{ old('item_code', $item->item_code) }}" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">ชื่อสินค้า *</label>
                    <input type="text" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" value="{{ old('name', $item->name) }}" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">หมวดหมู่ *</label>
                    <select name="category_id" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ (old('category_id', $item->category_id) == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">ประเภท *</label>
                    <select name="type" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                        <option value="equipment" {{ (old('type', $item->type) == 'equipment') ? 'selected' : '' }}>อุปกรณ์ (ยืม-คืนได้)</option>
                        <option value="consumable" {{ (old('type', $item->type) == 'consumable') ? 'selected' : '' }}>วัสดุสิ้นเปลือง (ใช้แล้วหมดไป)</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">หน่วยนับ *</label>
                    <input type="text" name="unit" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" value="{{ old('unit', $item->unit) }}" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">สถานะการใช้งาน *</label>
                    <select name="status" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                        <option value="available" {{ (old('status', $item->status) == 'available') ? 'selected' : '' }}>พร้อมใช้งาน</option>
                        <option value="maintenance" {{ (old('status', $item->status) == 'maintenance') ? 'selected' : '' }}>อยู่ระหว่างซ่อมบำรุง</option>
                        <option value="unavailable" {{ (old('status', $item->status) == 'unavailable') ? 'selected' : '' }}>ไม่พร้อมใช้งาน / ชำรุด</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">จุดจัดเก็บ (Location)</label>
                    <input type="text" name="location" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" value="{{ old('location', $item->location) }}">
                </div>

                <div class="mb-4 flex space-x-4">
                    <div class="w-1/2">
                        <label class="block text-gray-700 text-sm font-bold mb-2">จำนวนคงเหลือ</label>
                        <input type="number" name="current_stock" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" value="{{ old('current_stock', $item->current_stock) }}" min="0">
                    </div>
                    <div class="w-1/2">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Min Stock</label>
                        <input type="number" name="min_stock" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" value="{{ old('min_stock', $item->min_stock) }}" min="0">
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-200">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    อัปเดตข้อมูล
                </button>
                <a href="{{ route('inventory.items.index') }}" class="text-gray-500 hover:text-gray-800">ยกเลิก</a>
            </div>
        </form>
    </div>
</div>
@endsection