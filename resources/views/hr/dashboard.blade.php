@extends('layouts.app')
@section('title', 'HR Dashboard')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">ระบบจัดการบุคคล (HR Dashboard)</h2>
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-info text-white mb-3">
                <div class="card-body">
                    <h5 class="card-title">พนักงานทั้งหมด</h5>
                    <p class="card-text display-6">42 คน</p>
                    <a href="#" class="text-white text-decoration-none">จัดการพนักงาน ➔</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection