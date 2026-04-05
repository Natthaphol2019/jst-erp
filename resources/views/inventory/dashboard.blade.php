@extends('layouts.app')
@section('title', 'Inventory Dashboard')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-1 text-dark"><i class="bi bi-speedometer2 me-2"></i>ภาพรวมระบบคลังสินค้า</h2>
            <p class="text-muted mb-0">ยินดีต้อนรับ, <strong>{{ auth()->user()->name }}</strong></p>
        </div>
        <a href="{{ route('inventory.items.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> เพิ่มสินค้าใหม่
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <!-- Pending Requisitions -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 rounded-3 p-3">
                                <i class="bi bi-clipboard-data text-warning fs-3"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1" style="font-size: 0.85rem;">รออนุมัติเบิก</h6>
                            <h3 class="mb-0 fw-bold">{{ number_format($pendingRequisitions) }}</h3>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('inventory.requisition.index') }}" class="text-warning text-decoration-none small fw-semibold">
                        ตรวจสอบรายการ <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Total Items -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                                <i class="bi bi-box-seam text-primary fs-3"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1" style="font-size: 0.85rem;">สินค้าทั้งหมด</h6>
                            <h3 class="mb-0 fw-bold">{{ number_format($totalItems) }}</h3>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('inventory.items.index') }}" class="text-primary text-decoration-none small fw-semibold">
                        จัดการสินค้า <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Low Stock -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-danger bg-opacity-10 rounded-3 p-3">
                                <i class="bi bi-exclamation-triangle text-danger fs-3"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1" style="font-size: 0.85rem;">ใกล้หมด (Low Stock)</h6>
                            <h3 class="mb-0 fw-bold text-danger">{{ number_format($lowStockCount) }}</h3>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="#low-stock-table" class="text-danger text-decoration-none small fw-semibold">
                        ดูรายการที่ต้องสั่งซื้อ <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Active Borrowings -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-opacity-10 rounded-3 p-3">
                                <i class="bi bi-box-arrow-right text-info fs-3"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1" style="font-size: 0.85rem;">กำลังยืม</h6>
                            <h3 class="mb-0 fw-bold">{{ number_format($activeBorrowings) }}</h3>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('inventory.borrowing.index') }}" class="text-info text-decoration-none small fw-semibold">
                        ดูรายการยืม <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Low Stock Alert Table -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm" id="low-stock-table">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold text-danger"><i class="bi bi-bell-fill me-2"></i>แจ้งเตือน: สินค้าต่ำกว่าเกณฑ์ (Min Stock)</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">รหัสสินค้า</th>
                                    <th>ชื่อสินค้า</th>
                                    <th class="text-end">คงเหลือ</th>
                                    <th class="text-end">จุดสั่งซื้อ</th>
                                    <th class="text-center">สถานะ</th>
                                    <th class="text-center pe-4">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lowStockItems as $item)
                                <tr>
                                    <td class="ps-4"><strong>{{ $item->item_code }}</strong></td>
                                    <td>{{ $item->name }}</td>
                                    <td class="text-end text-danger fw-bold">{{ number_format($item->current_stock) }} {{ $item->unit }}</td>
                                    <td class="text-end text-muted">{{ number_format($item->min_stock) }}</td>
                                    <td class="text-center">
                                        @if($item->current_stock == 0)
                                            <span class="badge bg-danger">ของหมด</span>
                                        @else
                                            <span class="badge bg-warning text-dark">ใกล้หมด</span>
                                        @endif
                                    </td>
                                    <td class="text-center pe-4">
                                        <a href="{{ route('inventory.items.edit', $item->id) }}" class="btn btn-sm btn-outline-primary">ตรวจสอบ</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-success">
                                        <i class="bi bi-check-circle fs-4 d-block mb-2"></i>
                                        ยอดเยี่ยม! ไม่มีสินค้าต่ำกว่าเกณฑ์การสั่งซื้อ
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories Overview -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-dark"><i class="bi bi-grid-3x3-gap-fill me-2"></i>หมวดหมู่สินค้า</h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($categories as $category)
                        <div class="list-group-item border-0 px-3 py-2">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="fw-semibold small">{{ $category->name }}</span>
                                <span class="badge bg-light text-dark">{{ $category->items_count }} รายการ</span>
                            </div>
                            @php
                                $percentage = $totalItems > 0 ? ($category->items_count / $totalItems) * 100 : 0;
                            @endphp
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $percentage }}%;"></div>
                            </div>
                            @if($category->description)
                                <small class="text-muted d-block mt-1">{{ Str::limit($category->description, 50) }}</small>
                            @endif
                        </div>
                        @empty
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                            ยังไม่มีหมวดหมู่สินค้า
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Stock Transactions -->
    <div class="row g-4 mt-2">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold text-dark"><i class="bi bi-clock-history me-2"></i>รายการเคลื่อนไหวล่าสุด</h6>
                    <a href="{{ route('inventory.transactions.index') }}" class="btn btn-sm btn-outline-secondary">
                        ดูทั้งหมด <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">วันที่</th>
                                    <th>สินค้า</th>
                                    <th>ประเภท</th>
                                    <th class="text-end">จำนวน</th>
                                    <th class="text-end">คงเหลือ</th>
                                    <th>หมายเหตุ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentTransactions as $transaction)
                                <tr>
                                    <td class="ps-4 small">{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <strong>{{ $transaction->item->name ?? '-' }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $transaction->item->item_code ?? '' }}</small>
                                    </td>
                                    <td>
                                        @if($transaction->transaction_type === 'in')
                                            <span class="badge bg-success">รับเข้า</span>
                                        @elseif($transaction->transaction_type === 'out')
                                            <span class="badge bg-danger">จ่ายออก</span>
                                        @elseif($transaction->transaction_type === 'borrow_out')
                                            <span class="badge bg-warning text-dark">ยืมออก</span>
                                        @elseif($transaction->transaction_type === 'borrow_return')
                                            <span class="badge bg-info">คืนยืม</span>
                                        @elseif($transaction->transaction_type === 'adjust')
                                            <span class="badge bg-secondary">ปรับยอด</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $transaction->transaction_type }}</span>
                                        @endif
                                    </td>
                                    <td class="text-end fw-bold {{ $transaction->transaction_type === 'in' || $transaction->transaction_type === 'borrow_return' ? 'text-success' : 'text-danger' }}">
                                        {{ $transaction->transaction_type === 'in' || $transaction->transaction_type === 'borrow_return' ? '+' : '-' }}{{ number_format($transaction->quantity) }}
                                    </td>
                                    <td class="text-end">{{ number_format($transaction->balance) }}</td>
                                    <td><small class="text-muted">{{ Str::limit($transaction->remark, 40) }}</small></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                                        ยังไม่มีรายการเคลื่อนไหว
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
