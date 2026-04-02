@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3><i class="bi bi-box-seam"></i> รายการสินค้าในคลัง</h3>
            <a href="{{ route('inventory.items.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> เพิ่มสินค้า
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>รหัส</th>
                                <th>ชื่อสินค้า</th>
                                <th>ประเภท</th>
                                <th class="text-end">คงเหลือ</th>
                                <th>หน่วย</th>
                                <th>สถานะ</th>
                                <th class="text-center">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td><strong>{{ $item->item_code }}</strong></td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        <span class="badge {{ $item->type == 'equipment' ? 'bg-info' : 'bg-secondary' }}">
                                            {{ $item->type == 'equipment' ? 'อุปกรณ์' : 'วัสดุสิ้นเปลือง' }}
                                        </span>
                                    </td>
                                    <td class="text-end">{{ number_format($item->current_stock) }}</td>
                                    <td>{{ $item->unit }}</td>
                                    <td>
                                        @if ($item->status == 'available')
                                            <span class="text-success"><i class="bi bi-check-circle-fill"></i> พร้อม</span>
                                        @else
                                            <span class="text-danger">ไม่พร้อม</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('inventory.items.edit', $item->id) }}"
                                            class="btn btn-sm btn-outline-warning">แก้ไข</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
