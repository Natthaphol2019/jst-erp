@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col">
            <h2>📊 รายงานสต๊อกตามหมวดหมู่</h2>
        </div>
        <div class="col text-end">
            <a href="{{ route('inventory.transactions.summary') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> กลับ
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>หมวดหมู่</th>
                        <th class="text-center">จำนวนสินค้า</th>
                        <th class="text-center">ยอดรวมสต๊อก</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categoryStats as $cat)
                    <tr>
                        <td>{{ $cat->name }}</td>
                        <td class="text-center">{{ $cat->items_count }}</td>
                        <td class="text-center">{{ $cat->total_stock ?? 0 }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center">ไม่มีข้อมูล</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
