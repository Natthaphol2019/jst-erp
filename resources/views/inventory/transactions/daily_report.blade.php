@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col">
            <h2>📊 รายงานสต๊อกเข้า-ออก รายวัน</h2>
        </div>
        <div class="col text-end">
            <a href="{{ route('inventory.transactions.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> กลับ
            </a>
        </div>
    </div>

    {{-- Date Picker --}}
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">เลือกวันที่</label>
                    <input type="date" name="date" class="form-control" value="{{ $date }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> ค้นหา
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="row mb-3">
        @foreach($dailyStats as $stat)
        <div class="col-md-3">
            <div class="card bg-{{ $stat->transaction_type === 'borrow_return' ? 'success' : ($stat->transaction_type === 'consume_out' ? 'danger' : 'warning') }} text-white">
                <div class="card-body">
                    <h6 class="card-title">{{ $stat->transaction_type }}</h6>
                    <h3 class="mb-0">{{ $stat->total_quantity }} ชิ้น</h3>
                    <small>{{ $stat->count }} รายการ</small>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Transactions Table --}}
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">รายการทั้งหมดวันที่ {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>เวลา</th>
                        <th>สินค้า</th>
                        <th>ประเภท</th>
                        <th>จำนวน</th>
                        <th>คงเหลือ</th>
                        <th>ผู้ทำรายการ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $txn)
                    <tr>
                        <td>{{ $txn->created_at->format('H:i') }}</td>
                        <td>{{ $txn->item->name }}</td>
                        <td>{{ $txn->transaction_type }}</td>
                        <td>{{ $txn->quantity }}</td>
                        <td>{{ $txn->balance }}</td>
                        <td>{{ $txn->creator->name }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center">ไม่มีรายการ</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
