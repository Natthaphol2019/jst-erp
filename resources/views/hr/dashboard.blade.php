@extends('layouts.app')
@section('title', 'หน้าแรก')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center mt-5">
        <div class="col-md-8 text-center">
            <h1 class="display-4 fw-bold text-primary mb-3">ยินดีต้อนรับสู่ระบบ JST ERP</h1>
            <p class="lead text-muted mb-4">สวัสดีคุณ {{ auth()->user()->name }} (สิทธิ์การใช้งาน: {{ auth()->user()->role }})</p>
            
            <div class="card shadow-sm border-0 bg-white">
                <div class="card-body p-5">
                    <i class="bi bi-person-badge display-1 text-secondary mb-3"></i>
                    <h3 class="fw-bold">ยินดีต้อนรับเข้าสู่ระบบจัดการข้อมูล</h3>
                    <p class="text-muted fs-5 mt-3">กรุณาเลือกเมนูที่ต้องการใช้งานจาก <strong class="text-dark">แถบเมนูด้านซ้ายมือ</strong> ครับ ⬅️</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection