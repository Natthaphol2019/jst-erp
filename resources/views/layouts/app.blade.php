<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'JST ERP System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; }
        .sidebar a:hover { background-color: #494e53; }
        .content { padding: 20px; width: 100%; overflow-y: auto; height: 100vh; }
    </style>
</head>
<body>

<div class="d-flex">
    @include('layouts.partials.sidebar')

    <div class="content">
        @include('layouts.partials.topbar')

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>