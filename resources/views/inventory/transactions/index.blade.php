@extends('layouts.app')

@section('title', 'ประวัติเคลื่อนไหวสต๊อก - JST ERP')

@section('content')
<style>
@media print {
    .no-print, .no-print * { display: none !important; }
    .sidebar, .navbar, .btn, .alert, .erp-card-body form { display: none !important; }
    .content { padding: 0 !important; margin: 0 !important; }
    .erp-card { border: 1px solid #dee2e6 !important; box-shadow: none !important; margin-bottom: 1rem !important; }
    table { font-size: 10pt !important; }
    th, td { border: 1px solid #dee2e6 !important; }
    .erp-badge { border: 1px solid #6c757d !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
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

<div class="d-flex justify-content-between align-items-start mb-4 no-print">
    <div>
        <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            <i class="fas fa-clock me-2" style="color: #818cf8;"></i>ประวัติเคลื่อนไหวสต๊อก
        </h4>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">ติดตามการเปลี่ยนแปลงสต๊อกสินค้า</p>
    </div>
    <div class="d-flex gap-2 no-print">
        <button onclick="window.print()" class="erp-btn-secondary">
            <i class="fas fa-print me-2"></i>พิมพ์
        </button>
        <a href="{{ route('exports.stock-transactions', request()->query()) }}" class="erp-btn-primary" style="background: #22c55e; border-color: #22c55e;">
            <i class="fas fa-file-excel me-2"></i>Export Excel
        </a>
        <a href="{{ route('inventory.transactions.summary') }}" class="erp-btn-primary" style="background: #38bdf8; border-color: #38bdf8;">
            <i class="fas fa-chart-bar me-2"></i>สรุปยอดคงเหลือ
        </a>
    </div>
</div>

{{-- Filter Form --}}
<div class="erp-card mb-4 no-print">
    <div class="erp-card-body">
        <form method="GET" action="{{ route('inventory.transactions.index') }}" class="row g-3">
            <div class="col-md-2">
                <label class="erp-label">วันที่เริ่มต้น</label>
                <input type="date" name="date_from" class="erp-input"
                       value="{{ request('date_from') }}">
            </div>
            <div class="col-md-2">
                <label class="erp-label">วันที่สิ้นสุด</label>
                <input type="date" name="date_to" class="erp-input"
                       value="{{ request('date_to') }}">
            </div>
            <div class="col-md-2">
                <label class="erp-label">หมวดหมู่</label>
                <select name="category_id" class="erp-select">
                    <option value="">-- ทั้งหมด --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="erp-label">สินค้า</label>
                <select name="item_id" class="erp-select">
                    <option value="">-- ทั้งหมด --</option>
                    @foreach($items as $item)
                        <option value="{{ $item->id }}" {{ request('item_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="erp-label">ประเภท</label>
                <select name="transaction_type" class="erp-select">
                    <option value="">-- ทั้งหมด --</option>
                    <option value="borrow_out" {{ request('transaction_type') == 'borrow_out' ? 'selected' : '' }}>ยืมออก</option>
                    <option value="borrow_return" {{ request('transaction_type') == 'borrow_return' ? 'selected' : '' }}>คืนยืม</option>
                    <option value="consume_out" {{ request('transaction_type') == 'consume_out' ? 'selected' : '' }}>เบิกใช้</option>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="erp-btn-primary w-100">
                    <i class="fas fa-search me-1"></i>ค้นหา
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Transactions Table --}}
<div class="erp-card no-print">
    <div class="erp-table-wrap">
        <table class="erp-table">
            <thead>
                <tr>
                    <th width="80">ID</th>
                    <th width="120">วันที่-เวลา</th>
                    <th width="120">รหัสสินค้า</th>
                    <th>ชื่อสินค้า</th>
                    <th width="120">ประเภท</th>
                    <th width="100" style="text-align: center;">จำนวน</th>
                    <th width="100" style="text-align: center;">คงเหลือ</th>
                    <th width="100">ผู้ทำรายการ</th>
                    <th width="100" style="text-align: center;">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $txn)
                    @php
                        $typeBadge = match($txn->transaction_type) {
                            'borrow_out' => ['bg' => 'rgba(251,191,36,0.12)', 'color' => '#fbbf24', 'text' => 'ยืมออก'],
                            'borrow_return' => ['bg' => 'rgba(56,189,248,0.12)', 'color' => '#38bdf8', 'text' => 'คืนยืม'],
                            'consume_out' => ['bg' => 'rgba(239,68,68,0.12)', 'color' => '#f87171', 'text' => 'เบิกใช้'],
                            'in' => ['bg' => 'rgba(52,211,153,0.12)', 'color' => '#34d399', 'text' => 'เข้า'],
                            'out' => ['bg' => 'rgba(107,114,128,0.12)', 'color' => '#9ca3af', 'text' => 'ออก'],
                            default => ['bg' => 'rgba(107,114,128,0.12)', 'color' => '#9ca3af', 'text' => $txn->transaction_type]
                        };
                        $qtyClass = in_array($txn->transaction_type, ['borrow_return', 'in']) ? 'text-success' : 'text-danger';
                        $qtySign = in_array($txn->transaction_type, ['borrow_return', 'in']) ? '+' : '-';
                    @endphp
                    <tr>
                        <td style="color: var(--text-primary);"><strong>{{ $txn->id }}</strong></td>
                        <td style="color: var(--text-secondary);">{{ \Carbon\Carbon::parse($txn->created_at)->format('d/m/Y H:i') }}</td>
                        <td><code style="color: var(--text-secondary);">{{ $txn->item->item_code }}</code></td>
                        <td style="color: var(--text-secondary);">{{ $txn->item->name }}</td>
                        <td>
                            <span class="erp-badge" style="background: {{ $typeBadge['bg'] }}; color: {{ $typeBadge['color'] }};">
                                {{ $typeBadge['text'] }}
                            </span>
                        </td>
                        <td style="text-align: center;">
                            <strong class="{{ $qtyClass }}">{{ $qtySign }}{{ $txn->quantity }}</strong>
                        </td>
                        <td style="text-align: center; color: var(--text-primary);"><strong>{{ $txn->balance }}</strong></td>
                        <td style="color: var(--text-secondary);">{{ $txn->creator->name }}</td>
                        <td style="text-align: center;">
                            <a href="{{ route('inventory.transactions.show', $txn->id) }}"
                               class="erp-btn-secondary" title="ดูรายละเอียด" style="padding: 4px 8px; font-size: 12px;">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center" style="padding: 3rem;">
                            <div class="erp-empty" style="padding: 1rem;">
                                <i class="fas fa-inbox" style="font-size: 2rem; color: var(--text-muted);"></i>
                                <div style="color: var(--text-muted); margin-top: 8px;">ไม่พบข้อมูลเคลื่อนไหวสต๊อก</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Pagination --}}
@if($transactions->hasPages())
    <div style="padding: 16px; border-top: 1px solid var(--border);">
        <div class="d-flex justify-content-between align-items-center">
            <div style="font-size: 13px; color: var(--text-secondary);">
                แสดง <strong style="color: var(--text-primary);">{{ $transactions->firstItem() }}</strong> ถึง <strong style="color: var(--text-primary);">{{ $transactions->lastItem() }}</strong> จาก <strong style="color: var(--text-primary);">{{ $transactions->total() }}</strong> รายการ
            </div>
            {{ $transactions->links() }}
        </div>
    </div>
@endif
@endsection
