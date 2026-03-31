@extends('layouts.app')

@section('title', 'Admin Dashboard - JST ERP')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <h4>ยินดีต้อนรับ, {{ auth()->user()->name }}</h4>
                    <p class="text-muted">คุณเข้าสู่ระบบด้วยบทบาท: <strong>Admin</strong></p>
                    <hr>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h5>พนักงาน</h5>
                                    <h3>0</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h5>ผู้ใช้ระบบ</h5>
                                    <h3>0</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <h5>แผนก</h5>
                                    <h3>0</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
