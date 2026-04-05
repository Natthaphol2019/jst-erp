@extends('layouts.app')

@section('content')
<style>
@media print {
    .no-print, .no-print * { display: none !important; }
    .sidebar, .navbar, .btn, .alert, .card-body form { display: none !important; }
    .content { padding: 0 !important; margin: 0 !important; }
    .card { border: 1px solid #dee2e6 !important; box-shadow: none !important; margin-bottom: 1rem !important; }
    .card-header { background-color: #f8f9fa !important; color: #000 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    table { font-size: 10pt !important; }
    th, td { border: 1px solid #dee2e6 !important; }
    .badge { border: 1px solid #6c757d !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    body { background-color: #fff !important; }
    .container-fluid { width: 100% !important; max-width: 100% !important; }
    .row { page-break-inside: avoid; }
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
    <h2>สรุปยอดคงเหลือสต๊อก</h2>
    <p>พิมพ์เมื่อ {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
</div>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h2 class="no-print">
                <i class="bi bi-bar-chart me-2"></i>สรุปยอดคงเหลือสต๊อก
            </h2>
            <h2 class="d-print-block" style="display:none;">สรุปยอดคงเหลือสต๊อก</h2>
        </div>
        <div class="col text-end no-print">
            <button onclick="window.print()" class="btn btn-outline-dark me-2">
                <i class="bi bi-printer me-1"></i>พิมพ์
            </button>
            <a href="{{ route('inventory.transactions.index') }}" class="btn btn-secondary">
                <i class="bi bi-clock-history me-1"></i>ประวัติเคลื่อนไหว
            </a>
        </div>
    </div>

    {{-- Overview Cards --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">สินค้าทั้งหมด</h6>
                            <h2 class="mb-0">{{ $overview['total_items'] }}</h2>
                        </div>
                        <i class="bi bi-box" style="font-size: 3rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">สินค้ามีสต๊อก</h6>
                            <h2 class="mb-0">{{ $overview['total_items'] - $overview['zero_stock_count'] }}</h2>
                        </div>
                        <i class="bi bi-check-circle" style="font-size: 3rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">สต๊อกต่ำกว่าขั้นต่ำ</h6>
                            <h2 class="mb-0">{{ $overview['low_stock_count'] }}</h2>
                        </div>
                        <i class="bi bi-exclamation-triangle" style="font-size: 3rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">สินค้าหมดสต๊อก</h6>
                            <h2 class="mb-0">{{ $overview['zero_stock_count'] }}</h2>
                        </div>
                        <i class="bi bi-x-circle" style="font-size: 3rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Form --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('inventory.transactions.summary') }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">ค้นหา</label>
                    <input type="text" name="search" class="form-control" 
                           value="{{ request('search') }}" 
                           placeholder="ชื่อสินค้า, รหัสสินค้า">
                </div>
                <div class="col-md-3">
                    <label class="form-label">หมวดหมู่</label>
                    <select name="category_id" class="form-select">
                        <option value="">-- ทั้งหมด --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">สถานะ</label>
                    <select name="status" class="form-select">
                        <option value="">-- ทั้งหมด --</option>
                        <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>มีสต๊อก</option>
                        <option value="low_stock" {{ request('status') == 'low_stock' ? 'selected' : '' }}>ต่ำกว่าขั้นต่ำ</option>
                        <option value="zero" {{ request('status') == 'zero' ? 'selected' : '' }}>หมดสต๊อก</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2 w-100">
                        <i class="bi bi-search me-1"></i>ค้นหา
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Stock Summary Table --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="100">รหัสสินค้า</th>
                            <th>ชื่อสินค้า</th>
                            <th width="100">หมวดหมู่</th>
                            <th width="80" class="text-center">หน่วย</th>
                            <th width="120" class="text-center">สต๊อกปัจจุบัน</th>
                            <th width="120" class="text-center">ขั้นต่ำ</th>
                            <th width="100" class="text-center">สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                            @php
                                $isLowStock = $item->current_stock <= $item->min_stock;
                                $isZero = $item->current_stock == 0;
                                
                                $statusBadge = match(true) {
                                    $isZero => 'bg-danger',
                                    $isLowStock => 'bg-warning text-dark',
                                    default => 'bg-success'
                                };
                                $statusText = match(true) {
                                    $isZero => 'หมดสต๊อก',
                                    $isLowStock => 'ต่ำกว่าขั้นต่ำ',
                                    default => 'ปกติ'
                                };
                            @endphp
                            <tr>
                                <td><code>{{ $item->item_code }}</code></td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->category->name ?? '-' }}</td>
                                <td class="text-center">{{ $item->unit }}</td>
                                <td class="text-center">
                                    <strong style="font-size: 1.2rem;" class="{{ $isZero ? 'text-danger' : ($isLowStock ? 'text-warning' : 'text-success') }}">
                                        {{ $item->current_stock }}
                                    </strong>
                                </td>
                                <td class="text-center">{{ $item->min_stock }}</td>
                                <td class="text-center">
                                    <span class="badge {{ $statusBadge }}">
                                        {{ $statusText }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                    <p class="mt-2">ไม่พบข้อมูลสินค้า</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $items->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
