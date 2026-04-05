@extends('layouts.app')

@section('title', 'รายละเอียด Transaction - JST ERP')

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            <i class="fas fa-eye me-2" style="color: #818cf8;"></i>รายละเอียด Transaction
        </h4>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">ดูข้อมูลรายการเคลื่อนไหวสต๊อก</p>
    </div>
    <a href="{{ route('inventory.transactions.index') }}" class="erp-btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>กลับ
    </a>
</div>

<div class="row g-3">
    {{-- Left Column - Transaction Info --}}
    <div class="col-md-6">
        <div class="erp-card mb-3">
            <div class="erp-card-header">
                <span class="erp-card-title">
                    <i class="fas fa-info-circle me-2" style="color: #818cf8;"></i>ข้อมูล Transaction
                </span>
            </div>
            <div class="erp-card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="150" style="color: var(--text-muted); font-size: 12px;">ID</th>
                        <td><strong style="color: var(--text-primary);">#{{ $transaction->id }}</strong></td>
                    </tr>
                    <tr>
                        <th style="color: var(--text-muted); font-size: 12px;">วันที่-เวลา</th>
                        <td style="color: var(--text-secondary);">{{ \Carbon\Carbon::parse($transaction->created_at)->format('d/m/Y H:i:s') }}</td>
                    </tr>
                    <tr>
                        <th style="color: var(--text-muted); font-size: 12px;">ประเภท</th>
                        <td>
                            @php
                                $typeBadge = match($transaction->transaction_type) {
                                    'borrow_out' => ['bg' => 'rgba(251,191,36,0.12)', 'color' => '#fbbf24', 'text' => 'ยืมออก'],
                                    'borrow_return' => ['bg' => 'rgba(56,189,248,0.12)', 'color' => '#38bdf8', 'text' => 'คืนยืม'],
                                    'consume_out' => ['bg' => 'rgba(239,68,68,0.12)', 'color' => '#f87171', 'text' => 'เบิกใช้'],
                                    'in' => ['bg' => 'rgba(52,211,153,0.12)', 'color' => '#34d399', 'text' => 'เข้า'],
                                    'out' => ['bg' => 'rgba(107,114,128,0.12)', 'color' => '#9ca3af', 'text' => 'ออก'],
                                    default => ['bg' => 'rgba(107,114,128,0.12)', 'color' => '#9ca3af', 'text' => $transaction->transaction_type]
                                };
                            @endphp
                            <span class="erp-badge" style="background: {{ $typeBadge['bg'] }}; color: {{ $typeBadge['color'] }};">{{ $typeBadge['text'] }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th style="color: var(--text-muted); font-size: 12px;">จำนวน</th>
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
                        <th style="color: var(--text-muted); font-size: 12px;">ยอดคงเหลือหลังทำรายการ</th>
                        <td><strong style="font-size: 1.5rem; color: var(--text-primary);">{{ $transaction->balance }}</strong></td>
                    </tr>
                    @if($transaction->remark)
                    <tr>
                        <th style="color: var(--text-muted); font-size: 12px;">หมายเหตุ</th>
                        <td style="color: var(--text-secondary);">{{ $transaction->remark }}</td>
                    </tr>
                    @endif
                    <tr>
                        <th style="color: var(--text-muted); font-size: 12px;">ผู้ทำรายการ</th>
                        <td style="color: var(--text-secondary);">{{ $transaction->creator->name }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    {{-- Right Column - Item Info --}}
    <div class="col-md-6">
        <div class="erp-card mb-3">
            <div class="erp-card-header">
                <span class="erp-card-title">
                    <i class="fas fa-box me-2" style="color: #818cf8;"></i>ข้อมูลสินค้า
                </span>
            </div>
            <div class="erp-card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="150" style="color: var(--text-muted); font-size: 12px;">รหัสสินค้า</th>
                        <td><code style="color: var(--text-secondary);">{{ $transaction->item->item_code }}</code></td>
                    </tr>
                    <tr>
                        <th style="color: var(--text-muted); font-size: 12px;">ชื่อสินค้า</th>
                        <td><strong style="color: var(--text-primary);">{{ $transaction->item->name }}</strong></td>
                    </tr>
                    <tr>
                        <th style="color: var(--text-muted); font-size: 12px;">หมวดหมู่</th>
                        <td style="color: var(--text-secondary);">{{ $transaction->item->category->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th style="color: var(--text-muted); font-size: 12px;">หน่วย</th>
                        <td style="color: var(--text-secondary);">{{ $transaction->item->unit }}</td>
                    </tr>
                    <tr>
                        <th style="color: var(--text-muted); font-size: 12px;">ยอดคงเหลือปัจจุบัน</th>
                        <td><strong style="font-size: 1.5rem; color: #818cf8;">{{ $transaction->item->current_stock }}</strong></td>
                    </tr>
                    @if($transaction->item->location)
                    <tr>
                        <th style="color: var(--text-muted); font-size: 12px;">สถานที่เก็บ</th>
                        <td style="color: var(--text-secondary);">{{ $transaction->item->location }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>

        {{-- Requisition Info (if exists) --}}
        @if($transaction->requisition)
        <div class="erp-card">
            <div class="erp-card-header">
                <span class="erp-card-title">
                    <i class="fas fa-file-alt me-2" style="color: #fbbf24;"></i>ใบเบิกที่เกี่ยวข้อง
                </span>
            </div>
            <div class="erp-card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="150" style="color: var(--text-muted); font-size: 12px;">เลขที่</th>
                        <td>
                            <a href="{{ route('inventory.borrowing.show', $transaction->requisition->id) }}"
                               class="text-decoration-none" style="color: #818cf8;">
                                <strong>#{{ str_pad($transaction->requisition->id, 4, '0', STR_PAD_LEFT) }}</strong>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <th style="color: var(--text-muted); font-size: 12px;">ประเภท</th>
                        <td>
                            @if($transaction->requisition->req_type === 'borrow')
                                <span class="erp-badge" style="background: rgba(251,191,36,0.12); color: #fbbf24;">ยืม</span>
                            @else
                                <span class="erp-badge" style="background: rgba(239,68,68,0.12); color: #f87171;">เบิกใช้</span>
                            @endif
                        </td>
                    </tr>
                    @if($transaction->requisition->employee)
                    <tr>
                        <th style="color: var(--text-muted); font-size: 12px;">ผู้เบิก</th>
                        <td style="color: var(--text-secondary);">{{ $transaction->requisition->employee->firstname }} {{ $transaction->requisition->employee->lastname }}</td>
                    </tr>
                    @endif
                    <tr>
                        <th style="color: var(--text-muted); font-size: 12px;">วันที่</th>
                        <td style="color: var(--text-secondary);">{{ \Carbon\Carbon::parse($transaction->requisition->req_date)->format('d/m/Y') }}</td>
                    </tr>
                </table>

                @if($transaction->requisition->items->count() > 0)
                <hr style="border-color: var(--border);">
                <strong style="color: var(--text-primary); font-size: 13px;">รายการทั้งหมดในใบเบิก:</strong>
                <ul class="list-group mt-2">
                    @foreach($transaction->requisition->items as $item)
                    <li class="list-group-item d-flex justify-content-between align-items-center" style="background: var(--bg-surface); border-color: var(--border); color: var(--text-secondary);">
                        <span>{{ $item->item->name }}</span>
                        <span class="erp-badge" style="background: rgba(99,102,241,0.12); color: #818cf8;">{{ $item->quantity_requested }}</span>
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
        <div class="erp-card">
            <div class="erp-card-body">
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('inventory.transactions.index') }}" class="erp-btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>กลับ
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
