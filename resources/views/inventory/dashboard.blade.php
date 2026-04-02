@extends('layouts.app')
@section('title', 'Inventory Dashboard')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 text-dark"><i class="bi bi-speedometer2"></i> ภาพรวมระบบคลังสินค้า</h2>
        <a href="{{ route('inventory.items.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg"></i> เพิ่มสินค้าใหม่
        </a>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 bg-warning bg-opacity-10 border-start border-warning border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-warning fw-bold text-uppercase mb-1" style="font-size: 0.85rem;">
                                รายการรออนุมัติเบิก</div>
                            <div class="h3 mb-0 fw-bold text-dark">{{ number_format($pendingRequisitions) }} <span class="fs-6 fw-normal text-muted">รายการ</span></div>
                        </div>
                        <div>
                            <i class="bi bi-clipboard-data fs-1 text-warning opacity-75"></i>
                        </div>
                    </div>
                    <a href="#" class="text-warning text-decoration-none small mt-3 d-block fw-semibold">
                        ตรวจสอบใบเบิก <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 bg-primary bg-opacity-10 border-start border-primary border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-primary fw-bold text-uppercase mb-1" style="font-size: 0.85rem;">
                                สินค้าในระบบทั้งหมด</div>
                            <div class="h3 mb-0 fw-bold text-dark">{{ number_format($totalItems) }} <span class="fs-6 fw-normal text-muted">รายการ</span></div>
                        </div>
                        <div>
                            <i class="bi bi-box-seam fs-1 text-primary opacity-75"></i>
                        </div>
                    </div>
                    <a href="{{ route('inventory.items.index') }}" class="text-primary text-decoration-none small mt-3 d-block fw-semibold">
                        จัดการรายการสินค้า <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 bg-danger bg-opacity-10 border-start border-danger border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-danger fw-bold text-uppercase mb-1" style="font-size: 0.85rem;">
                                สินค้าใกล้หมด (Low Stock)</div>
                            <div class="h3 mb-0 fw-bold text-dark">{{ number_format($lowStockCount) }} <span class="fs-6 fw-normal text-muted">รายการ</span></div>
                        </div>
                        <div>
                            <i class="bi bi-exclamation-triangle fs-1 text-danger opacity-75"></i>
                        </div>
                    </div>
                    <a href="#low-stock-table" class="text-danger text-decoration-none small mt-3 d-block fw-semibold">
                        ดูรายการที่ต้องสั่งซื้อ <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 bg-secondary bg-opacity-10 border-start border-secondary border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary fw-bold text-uppercase mb-1" style="font-size: 0.85rem;">
                                อุปกรณ์ซ่อมบำรุง</div>
                            <div class="h3 mb-0 fw-bold text-dark">{{ number_format($maintenanceCount) }} <span class="fs-6 fw-normal text-muted">รายการ</span></div>
                        </div>
                        <div>
                            <i class="bi bi-tools fs-1 text-secondary opacity-75"></i>
                        </div>
                    </div>
                    <a href="{{ route('inventory.items.index') }}" class="text-secondary text-decoration-none small mt-3 d-block fw-semibold">
                        ตรวจสอบสถานะ <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="low-stock-table">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-danger"><i class="bi bi-bell-fill"></i> แจ้งเตือน: สินค้าต่ำกว่าเกณฑ์ (Min Stock)</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">รหัสสินค้า</th>
                                    <th>ชื่อสินค้า</th>
                                    <th class="text-end">คงเหลือ</th>
                                    <th class="text-end">จุดสั่งซื้อ (Min)</th>
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
    </div>
</div>
@endsection