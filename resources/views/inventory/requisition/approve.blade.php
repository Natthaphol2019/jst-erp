@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h2>
                <i class="bi bi-check-circle me-2"></i>อนุมัติ/ปฏิเสธ ใบเบิก #{{ str_pad($requisition->id, 4, '0', STR_PAD_LEFT) }}
            </h2>
        </div>
        <div class="col text-end">
            <a href="{{ route('inventory.requisition.show', $requisition->id) }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i>กลับ
            </a>
        </div>
    </div>

    {{-- Error Messages --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-1"></i>{{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        {{-- Left Column - Requisition Summary --}}
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header bg-info text-white">
                    <i class="bi bi-person me-1"></i>ข้อมูลผู้เบิก
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <th width="120">ผู้เบิก</th>
                            <td>{{ $requisition->employee->firstname }} {{ $requisition->employee->lastname }}</td>
                        </tr>
                        <tr>
                            <th>วันที่เบิก</th>
                            <td>{{ \Carbon\Carbon::parse($requisition->req_date)->format('d/m/Y') }}</td>
                        </tr>
                        @if($requisition->note)
                        <tr>
                            <th>หมายเหตุ</th>
                            <td>{{ $requisition->note }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <i class="bi bi-exclamation-triangle me-1"></i>คำเตือน
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li>อนุมัติ: สินค้าจะถูกหักจากสต๊อกทันที</li>
                        <li>ปฏิเสธ: ใบเบิกจะถูกยกเลิก ไม่มีการหักสต๊อก</li>
                        <li>การดำเนินการไม่สามารถย้อนกลับได้</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Right Column - Items --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-box me-1"></i>รายการสินค้าเบิก
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>สินค้า</th>
                                    <th width="100" class="text-center">จำนวน</th>
                                    <th width="100" class="text-center">คงเหลือในสต๊อก</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($requisition->items as $item)
                                    <tr>
                                        <td>{{ $item->item->name }}</td>
                                        <td class="text-center"><strong>{{ $item->quantity_requested }}</strong></td>
                                        <td class="text-center">
                                            @if($item->item->current_stock >= $item->quantity_requested)
                                                <span class="text-success">{{ $item->item->current_stock }}</span>
                                            @else
                                                <span class="text-danger">{{ $item->item->current_stock }} (ไม่พอ)</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Approve/Reject Form --}}
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-pencil me-1"></i>ดำเนินการใบเบิก
                </div>
                <div class="card-body">
                    <form action="{{ route('inventory.requisition.approve.store', $requisition->id) }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="approve_note" class="form-label">หมายเหตุผู้อนุมัติ</label>
                            <textarea name="approve_note" id="approve_note" rows="3" 
                                      class="form-control" 
                                      placeholder="บันทึกเพิ่มเติม (ถ้ามี)">{{ old('approve_note') }}</textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('inventory.requisition.show', $requisition->id) }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-1"></i>ยกเลิก
                            </a>
                            <button type="submit" name="action" value="rejected" class="btn btn-danger" 
                                    onclick="return confirm('คุณแน่ใจหรือว่าจะปฏิเสธใบเบิกนี้?')">
                                <i class="bi bi-x-circle me-1"></i>ปฏิเสธ
                            </button>
                            <button type="submit" name="action" value="approved" class="btn btn-success" 
                                    onclick="return confirm('คุณแน่ใจหรือว่าจะอนุมัติใบเบิกนี้?')">
                                <i class="bi bi-check-circle me-1"></i>อนุมัติ
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
