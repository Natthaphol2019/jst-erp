<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - JST ERP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger">
        <div class="container">
            <a class="navbar-brand" href="#">JST ERP - Admin</a>
            <div class="navbar-nav ms-auto">
                <span class="nav-item nav-link text-white">{{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">ออกจากระบบ</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-3">
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action active">Dashboard</a>
                    <a href="#" class="list-group-item list-group-item-action">จัดการผู้ใช้</a>
                    <a href="#" class="list-group-item list-group-item-action">จัดการพนักงาน</a>
                    <a href="#" class="list-group-item list-group-item-action">ตั้งค่าระบบ</a>
                </div>
            </div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
