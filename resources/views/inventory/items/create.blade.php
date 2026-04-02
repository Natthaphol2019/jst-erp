@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">ลงทะเบียนสินค้าใหม่</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('inventory.items.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">รหัสสินค้า</label>
                                <input type="text" name="item_code" class="form-control" placeholder="เช่น ITEM-001" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">ชื่อสินค้า</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">หมวดหมู่</label>
                                <select name="category_id" class="form-select" required>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">ประเภท</label>
                                <select name="type" class="form-select">
                                    <option value="equipment">อุปกรณ์ (ยืม-คืน)</option>
                                    <option value="consumable">วัสดุสิ้นเปลือง</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">จำนวนตั้งต้น</label>
                                <input type="number" name="current_stock" class="form-control" value="0">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">หน่วยนับ</label>
                                <input type="text" name="unit" class="form-control" placeholder="เช่น ชิ้น, ตัว" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Min Stock</label>
                                <input type="number" name="min_stock" class="form-control" value="0">
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-top d-flex justify-content-between">
                            <a href="{{ route('inventory.items.index') }}" class="btn btn-light">ยกเลิก</a>
                            <button type="submit" class="btn btn-primary px-4">บันทึกข้อมูล</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection