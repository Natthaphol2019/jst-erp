@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h2>
                <i class="bi bi-eye me-2"></i>รายละเอียด Transaction
            </h2>
        </div>
        <div class="col text-end">
            <a href="{{ route('inventory.transactions.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i>กลับ
            </a>
        </div>
    </div>

    <div class="row">
        {{-- Left Column - Transaction Info --}}
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-info-circle me-1"></i>ข้อมูล Transaction
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="150">ID</th>
                            <td><strong>#{{ $transaction->id }}</strong></td>
                        </tr>
                        <tr>
                            <th>วันที่-เวลา</th>
                            <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>ประเภท</th>
                            <td>
                                @php
                                    $typeBadge = match($transaction->transaction_type) {
                                        'borrow_out' => 'bg-warning text-dark',
                                        'borrow_return' => 'bg-info',
                                        'consume_out' => 'bg-danger',
                                        'in' => 'bg-success',
                                        'out' => 'bg-secondary',
                                        default => 'bg-secondary'
                                    };
                                    $typeText = match($transaction->transaction_type) {
                                        'borrow_out' => 'ยืมออก',
                                        'borrow_return' => 'คืนยืม',
                                        'consume_out' => 'เบิกใช้',
                                        'in' => 'เข้า',
                                        'out' => 'ออก',
                                        default => $transaction->transaction_type
                                    };
                                @endphp
                                <span class="badge {{ $typeBadge }}">{{ $typeText }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th>จำนวน</th>
                            <td>
                                @php
                                    $qtyClass = in_array($transaction->transaction_type, ['borrow_return', 'in']) ? 'text-success' : 'text-danger';
                                    $qtySign = in_array($transaction->transaction_type, ['borrow_return', 'in']) ? '+' : '-';
                                @endphp
                                <strong class="{{ $qtyClass }}" style="font-size: 1.5rem;">
                                    {{ $qtySign }}{{ $transaction->quantity }}
                                </strong>
                            </td>
                        </tr>
                        <tr>
                            <th>ยอดคงเหลือหลังทำรายการ</th>
                            <td><strong style="font-size: 1.5rem;">{{ $transaction->balance }}</strong></td>
                        </tr>
                        @if($transaction->remark)
                        <tr>
                            <th>หมายเหตุ</th>
                            <td>{{ $transaction->remark }}</td>
                        </tr>
                        @endif
                        <tr>
                            <th>ผู้ทำรายการ</th>
                            <td>{{ $transaction->creator->name }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        {{-- Right Column - Item Info --}}
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header bg-info text-white">
                    <i class="bi bi-box me-1"></i>ข้อมูลสินค้า
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="150">รหัสสินค้า</th>
                            <td><code>{{ $transaction->item->item_code }}</code></td>
                        </tr>
                        <tr>
                            <th>ชื่อสินค้า</th>
                            <td><strong>{{ $transaction->item->name }}</strong></td>
                        </tr>
                        <tr>
                            <th>หมวดหมู่</th>
                            <td>{{ $transaction->item->category->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>หน่วย</th>
                            <td>{{ $transaction->item->unit }}</td>
                        </tr>
                        <tr>
                            <th>ยอดคงเหลือปัจจุบัน</th>
                            <td><strong class="text-primary" style="font-size: 1.5rem;">{{ $transaction->item->current_stock }}</strong></td>
                        </tr>
                        @if($transaction->item->location)
                        <tr>
                            <th>สถานที่เก็บ</th>
                            <td>{{ $transaction->item->location }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>

            {{-- Requisition Info (if exists) --}}
            @if($transaction->requisition)
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <i class="bi bi-file-text me-1"></i>ใบเบิกที่เกี่ยวข้อง
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="150">เลขที่</th>
                            <td>
                                <a href="{{ route('inventory.borrowing.show', $transaction->requisition->id) }}" 
                                   class="text-decoration-none">
                                    <strong>#{{ str_pad($transaction->requisition->id, 4, '0', STR_PAD_LEFT) }}</strong>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th>ประเภท</th>
                            <td>
                                @if($transaction->requisition->req_type === 'borrow')
                                    <span class="badge bg-warning text-dark">ยืม</span>
                                @else
                                    <span class="badge bg-danger">เบิกใช้</span>
                                @endif
                            </td>
                        </tr>
                        @if($transaction->requisition->employee)
                        <tr>
                            <th>ผู้เบิก</th>
                            <td>{{ $transaction->requisition->employee->firstname }} {{ $transaction->requisition->employee->lastname }}</td>
                        </tr>
                        @endif
                        <tr>
                            <th>วันที่</th>
                            <td>{{ \Carbon\Carbon::parse($transaction->requisition->req_date)->format('d/m/Y') }}</td>
                        </tr>
                    </table>

                    @if($transaction->requisition->items->count() > 0)
                    <hr>
                    <strong>รายการทั้งหมดในใบเบิก:</strong>
                    <ul class="list-group mt-2">
                        @foreach($transaction->requisition->items as $item)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ $item->item->name }}</span>
                            <span class="badge bg-primary rounded-pill">{{ $item->quantity_requested }}</span>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('inventory.transactions.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i>กลับ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
