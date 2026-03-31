<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - JST ERP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
        <div class="container">
            <a class="navbar-brand" href="#">JST ERP</a>
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
        <div class="card">
            <div class="card-body text-center">
                <h4>ยินดีต้อนรับ, {{ auth()->user()->name }}</h4>
                <p class="text-muted">คุณเข้าสู่ระบบด้วยบทบาท: <strong>{{ auth()->user()->role }}</strong></p>
                <hr>
                <p>ไม่มีสิทธิ์เข้าถึง Dashboard นี้</p>
                <a href="#" class="btn btn-primary">กลับหน้าหลัก</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
