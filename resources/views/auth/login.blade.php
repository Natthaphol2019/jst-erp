<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ - JST Industry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; }
        .login-box { max-width: 400px; margin: 80px auto; }
    </style>
</head>
<body>

<div class="container login-box">
    <div class="card shadow-sm">
        <div class="card-body p-4">
            <h3 class="text-center mb-4">JST ERP System</h3>
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ url('/login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="username" class="form-label">ชื่อผู้ใช้งาน (Username)</label>
                    <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">รหัสผ่าน (Password)</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">เข้าสู่ระบบ</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    
    form.addEventListener('submit', function(e) {
        console.log('=== Form Submit Started ===');
        console.log('Form action:', form.action);
        console.log('Form method:', form.method);
        
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;
        
        console.log('Username:', username);
        console.log('Password:', password ? '***' : '(empty)');
        console.log('CSRF Token:', document.querySelector('input[name="_token"]').value);
    });
    
    // Check for existing errors on page load
    const errors = @json($errors->any() ? $errors->all() : []);
    if (errors.length > 0) {
        console.log('=== Validation Errors ===');
        console.log(errors);
    }
    
    // Check old input
    const oldUsername = @json(old('username'));
    if (oldUsername) {
        console.log('Old username:', oldUsername);
    }
});
</script>
</body>
</html>