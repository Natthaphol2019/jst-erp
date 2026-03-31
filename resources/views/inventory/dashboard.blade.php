@extends('layouts.app')
@section('title', 'Inventory Dashboard')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">ระบบคลังสินค้า (Inventory Dashboard)</h2>
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-warning text-dark mb-3">
                <div class="card-body">
                    <h5 class="card-title">รายการรออนุมัติเบิก</h5>
                    <p class="card-text display-6">5 รายการ</p>
                    <a href="#" class="text-dark text-decoration-none">ตรวจสอบใบเบิก ➔</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection