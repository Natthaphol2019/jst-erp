@extends('layouts.app')

@section('content')
<style>
@media print {
    .no-print, .no-print * { display: none !important; }
    .sidebar, .navbar, .btn { display: none !important; }
    .content { padding: 0 !important; margin: 0 !important; }
    .card { border: 1px solid #dee2e6 !important; box-shadow: none !important; margin-bottom: 1rem !important; }
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

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="no-print"><i class="bi bi-box-seam"></i> รายการสินค้าในคลัง</h3>
            <h3 class="d-print-block" style="display:none;">รายการสินค้าในคลัง</h3>
            <div>
                <button onclick="window.print()" class="btn btn-outline-dark me-2 no-print">
                    <i class="bi bi-printer"></i> พิมพ์
                </button>
                <a href="{{ route('exports.items') }}" class="btn btn-success me-2 no-print">
                    <i class="bi bi-file-earmark-excel"></i> Export Excel
                </a>
                <a href="{{ route('inventory.items.create') }}" class="btn btn-primary no-print">
                    <i class="bi bi-plus-lg"></i> เพิ่มสินค้า
                </a>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>บาร์โค้ด</th>
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
                                    <td class="text-center">
                                        <img src="{{ route('inventory.items.barcode', $item->id) }}"
                                             alt="barcode"
                                             style="height: 30px; max-width: 100px;"
                                             loading="lazy"
                                             title="{{ $item->item_code }}">
                                    </td>
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
                                            class="btn btn-sm btn-outline-warning" title="แก้ไข">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="{{ route('inventory.items.print-barcode', $item->id) }}"
                                            class="btn btn-sm btn-outline-info" title="พิมพ์บาร์โค้ด"
                                            target="_blank">
                                            <i class="bi bi-upc-scan"></i>
                                        </a>
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
