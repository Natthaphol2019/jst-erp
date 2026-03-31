<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Dashboard - JST ERP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">JST ERP - Manager</a>
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
                    <a href="#" class="list-group-item list-group-item-action">รายงาน</a>
                    <a href="#" class="list-group-item list-group-item-action">อนุมัติคำขอ</a>
                    <a href="#" class="list-group-item list-group-item-action">ติดตามงาน</a>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <h4>ยินดีต้อนรับ, {{ auth()->user()->name }}</h4>
                        <p class="text-muted">คุณเข้าสู่ระบบด้วยบทบาท: <strong>Manager</strong></p>
                        <hr>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="card bg-warning text-dark">
                                    <div class="card-body text-center">
                                        <h5>งานรออนุมัติ</h5>
                                        <h3>0</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card bg-info text-white">
                                    <div class="card-body text-center">
                                        <h5>งานที่กำลังทำ</h5>
                                        <h3>0</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card bg-success text-white">
                                    <div class="card-body text-center">
                                        <h5>งานที่เสร็จแล้ว</h5>
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
