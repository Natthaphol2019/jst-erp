@extends('layouts.app')

@section('content')
<style>
@media print {
    .no-print, .no-print * { display: none !important; }
    .sidebar, .navbar, .btn, .alert, .card-body form { display: none !important; }
    .content { padding: 0 !important; margin: 0 !important; }
    .card { border: 1px solid #dee2e6 !important; box-shadow: none !important; margin-bottom: 1rem !important; }
    table { font-size: 10pt !important; }
    th, td { border: 1px solid #dee2e6 !important; }
    .badge { border: 1px solid #6c757d !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    body { background-color: #fff !important; }
    .container-fluid { width: 100% !important; max-width: 100% !important; }
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
    <h2>ประวัติเคลื่อนไหวสต๊อก</h2>
    <p>พิมพ์เมื่อ {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
</div>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h2 class="no-print">
                <i class="bi bi-clock-history me-2"></i>ประวัติเคลื่อนไหวสต๊อก
            </h2>
            <h2 class="d-print-block" style="display:none;">ประวัติเคลื่อนไหวสต๊อก</h2>
        </div>
        <div class="col text-end no-print">
            <button onclick="window.print()" class="btn btn-outline-dark me-2">
                <i class="bi bi-printer me-1"></i>พิมพ์
            </button>
            <a href="{{ route('exports.stock-transactions', request()->query()) }}" class="btn btn-success me-2">
                <i class="bi bi-file-earmark-excel"></i> Export Excel
            </a>
            <a href="{{ route('inventory.transactions.summary') }}" class="btn btn-info">
                <i class="bi bi-bar-chart me-1"></i>สรุปยอดคงเหลือ
            </a>
        </div>
    </div>

    {{-- Filter Form --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('inventory.transactions.index') }}" class="row g-3">
                <div class="col-md-2">
                    <label class="form-label">วันที่เริ่มต้น</label>
                    <input type="date" name="date_from" class="form-control" 
                           value="{{ request('date_from') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">วันที่สิ้นสุด</label>
                    <input type="date" name="date_to" class="form-control" 
                           value="{{ request('date_to') }}">
                </div>
                <div class="col-md-2">
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
                <div class="col-md-2">
                    <label class="form-label">สินค้า</label>
                    <select name="item_id" class="form-select">
                        <option value="">-- ทั้งหมด --</option>
                        @foreach($items as $item)
                            <option value="{{ $item->id }}" {{ request('item_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">ประเภท</label>
                    <select name="transaction_type" class="form-select">
                        <option value="">-- ทั้งหมด --</option>
                        <option value="borrow_out" {{ request('transaction_type') == 'borrow_out' ? 'selected' : '' }}>ยืมออก</option>
                        <option value="borrow_return" {{ request('transaction_type') == 'borrow_return' ? 'selected' : '' }}>คืนยืม</option>
                        <option value="consume_out" {{ request('transaction_type') == 'consume_out' ? 'selected' : '' }}>เบิกใช้</option>
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

    {{-- Transactions Table --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="80">ID</th>
                            <th width="120">วันที่-เวลา</th>
                            <th width="120">รหัสสินค้า</th>
                            <th>ชื่อสินค้า</th>
                            <th width="120">ประเภท</th>
                            <th width="100" class="text-center">จำนวน</th>
                            <th width="100" class="text-center">คงเหลือ</th>
                            <th width="100">ผู้ทำรายการ</th>
                            <th width="100">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $txn)
                            @php
                                $typeBadge = match($txn->transaction_type) {
                                    'borrow_out' => 'bg-warning text-dark',
                                    'borrow_return' => 'bg-info',
                                    'consume_out' => 'bg-danger',
                                    'in' => 'bg-success',
                                    'out' => 'bg-secondary',
                                    default => 'bg-secondary'
                                };
                                $typeText = match($txn->transaction_type) {
                                    'borrow_out' => 'ยืมออก',
                                    'borrow_return' => 'คืนยืม',
                                    'consume_out' => 'เบิกใช้',
                                    'in' => 'เข้า',
                                    'out' => 'ออก',
                                    default => $txn->transaction_type
                                };
                                $qtyClass = in_array($txn->transaction_type, ['borrow_return', 'in']) ? 'text-success' : 'text-danger';
                                $qtySign = in_array($txn->transaction_type, ['borrow_return', 'in']) ? '+' : '-';
                            @endphp
                            <tr>
                                <td><strong>{{ $txn->id }}</strong></td>
                                <td>{{ \Carbon\Carbon::parse($txn->created_at)->format('d/m/Y H:i') }}</td>
                                <td><code>{{ $txn->item->item_code }}</code></td>
                                <td>{{ $txn->item->name }}</td>
                                <td>
                                    <span class="badge {{ $typeBadge }}">
                                        {{ $typeText }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <strong class="{{ $qtyClass }}">{{ $qtySign }}{{ $txn->quantity }}</strong>
                                </td>
                                <td class="text-center"><strong>{{ $txn->balance }}</strong></td>
                                <td>{{ $txn->creator->name }}</td>
                                <td>
                                    <a href="{{ route('inventory.transactions.show', $txn->id) }}" 
                                       class="btn btn-sm btn-outline-primary" title="ดูรายละเอียด">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                    <p class="mt-2">ไม่พบข้อมูลเคลื่อนไหวสต๊อก</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $transactions->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
