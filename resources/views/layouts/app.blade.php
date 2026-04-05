<!DOCTYPE html>
<html lang="th" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'JST ERP System')</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Font Awesome 6 --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- Google Fonts: IBM Plex Sans + Noto Sans Thai --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600&family=Noto+Sans+Thai:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        /* ═══════════════════════════════════════════════
           THEME TOKENS — Light (default) & Dark
           ═══════════════════════════════════════════════ */

        /* ── Light Mode (Default) ── */
        :root,
        [data-theme="light"] {
            /* Backgrounds */
            --bg-base:    #f0f2f7;
            --bg-surface: #ffffff;
            --bg-raised:  #f7f8fc;

            /* Borders */
            --border:     rgba(0, 0, 0, 0.07);

            /* Text */
            --text-primary:   #1a1d2e;
            --text-secondary: rgba(0, 0, 0, 0.5);
            --text-muted:     rgba(0, 0, 0, 0.28);

            /* Accent — Indigo (unchanged) */
            --accent:       #6366f1;
            --accent-light: #818cf8;

            /* Component tokens */
            --sidebar-bg:     #ffffff;
            --sidebar-border: rgba(0,0,0,0.07);
            --topbar-bg:      #ffffff;
            --topbar-border:  rgba(0,0,0,0.07);

            --input-bg:       rgba(0,0,0,0.04);
            --input-border:   rgba(0,0,0,0.12);
            --input-focus-bg: rgba(99,102,241,0.05);

            --table-th-bg:    rgba(0,0,0,0.02);
            --table-td-bd:    rgba(0,0,0,0.05);
            --table-hover-bg: rgba(0,0,0,0.02);

            --dropdown-bg:    #ffffff;
            --modal-bg:       #f7f8fc;

            --scrollbar-thumb: rgba(0,0,0,0.14);
            --scrollbar-hover: rgba(0,0,0,0.24);

            /* Sidebar active/hover */
            --sb-hover-bg:      rgba(99,102,241,0.06);
            --sb-hover-color:   #1a1d2e;
            --sb-active-bg:     rgba(99,102,241,0.12);
            --sb-section-color: rgba(0,0,0,0.3);
            --sb-link-color:    rgba(0,0,0,0.5);
            --sb-text-color:    #1a1d2e;
        }

        /* ── Dark Mode ── */
        [data-theme="dark"] {
            --bg-base:    #0f1117;
            --bg-surface: #12151f;
            --bg-raised:  #1a1e2e;
            --border:     rgba(255, 255, 255, 0.06);

            --text-primary:   #e2e8f0;
            --text-secondary: rgba(255,255,255,0.5);
            --text-muted:     rgba(255,255,255,0.25);

            --accent:       #6366f1;
            --accent-light: #818cf8;

            --sidebar-bg:     #12151f;
            --sidebar-border: rgba(255,255,255,0.06);
            --topbar-bg:      #12151f;
            --topbar-border:  rgba(255,255,255,0.06);

            --input-bg:       rgba(255,255,255,0.05);
            --input-border:   rgba(255,255,255,0.1);
            --input-focus-bg: rgba(99,102,241,0.05);

            --table-th-bg:    rgba(255,255,255,0.02);
            --table-td-bd:    rgba(255,255,255,0.04);
            --table-hover-bg: rgba(255,255,255,0.02);

            --dropdown-bg:    #1a1e2e;
            --modal-bg:       #1a1e2e;

            --scrollbar-thumb: rgba(255,255,255,0.1);
            --scrollbar-hover: rgba(255,255,255,0.2);

            --sb-hover-bg:      rgba(255,255,255,0.05);
            --sb-hover-color:   rgba(255,255,255,0.85);
            --sb-active-bg:     rgba(99,102,241,0.15);
            --sb-section-color: rgba(255,255,255,0.22);
            --sb-link-color:    rgba(255,255,255,0.5);
            --sb-text-color:    #e2e8f0;
        }

        /* ── Smooth theme transition ── */
        *, *::before, *::after {
            box-sizing: border-box;
            transition: background-color 0.22s ease, border-color 0.22s ease, color 0.18s ease;
        }

        html, body { height: 100%; margin: 0; }

        body {
            font-family: 'IBM Plex Sans', 'Noto Sans Thai', sans-serif;
            font-size: 14px;
            background-color: var(--bg-base);
            color: var(--text-primary);
            -webkit-font-smoothing: antialiased;
        }

        /* ── Layout ── */
        .erp-layout { display: flex; min-height: 100vh; }
        .erp-main   { flex: 1; display: flex; flex-direction: column; min-width: 0; overflow-x: hidden; }
        .erp-content { flex: 1; padding: 24px 28px; overflow-y: auto; }

        /* ═══════════════════════════════════════════════
           BOOTSTRAP OVERRIDES — use CSS vars
           ═══════════════════════════════════════════════ */

        .card {
            background: var(--bg-surface) !important;
            border-color: var(--border) !important;
            border-radius: 12px !important;
            color: var(--text-primary) !important;
        }

        .table { color: var(--text-primary) !important; border-color: var(--border) !important; }
        .table th {
            font-size: 11px; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase;
            color: var(--text-secondary) !important;
            background: var(--table-th-bg) !important;
            border-color: var(--border) !important;
        }
        .table td { border-color: var(--border) !important; color: var(--text-primary) !important; }
        .table-hover tbody tr:hover td { background: var(--table-hover-bg) !important; }
        .table-striped tbody tr:nth-child(odd) td { background: var(--table-th-bg) !important; }

        .form-control, .form-select {
            background-color: var(--input-bg) !important;
            border-color: var(--input-border) !important;
            color: var(--text-primary) !important;
            border-radius: 8px !important;
        }
        .form-control::placeholder { color: var(--text-muted) !important; }
        .form-control:focus, .form-select:focus {
            background-color: var(--input-focus-bg) !important;
            border-color: rgba(99,102,241,0.4) !important;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.12) !important;
            color: var(--text-primary) !important;
        }
        .form-label { color: var(--text-secondary) !important; font-size: 13px; font-weight: 500; }

        .btn-primary { background: var(--accent) !important; border-color: var(--accent) !important; border-radius: 8px !important; }
        .btn-primary:hover { background: #4f46e5 !important; border-color: #4f46e5 !important; }

        .btn-secondary {
            background: var(--input-bg) !important;
            border-color: var(--input-border) !important;
            color: var(--text-primary) !important;
            border-radius: 8px !important;
        }
        .btn-secondary:hover { background: var(--table-hover-bg) !important; }

        .btn-outline-primary { color: var(--accent-light) !important; border-color: rgba(99,102,241,0.4) !important; border-radius: 8px !important; }
        .btn-outline-primary:hover { background: rgba(99,102,241,0.15) !important; color: var(--accent-light) !important; }

        .btn-outline-secondary { color: var(--text-secondary) !important; border-color: var(--input-border) !important; border-radius: 8px !important; }
        .btn-outline-secondary:hover { background: var(--table-hover-bg) !important; color: var(--text-primary) !important; }

        .btn-danger, .btn-success, .btn-warning { border-radius: 8px !important; }

        .badge { font-weight: 600; font-size: 10px; letter-spacing: 0.03em; border-radius: 6px !important; }

        .alert { border-radius: 10px !important; border: none !important; }
        .alert-success { background: rgba(52,211,153,0.1) !important; color: #34d399 !important; }
        .alert-danger  { background: rgba(239,68,68,0.1)  !important; color: #f87171 !important; }
        .alert-warning { background: rgba(251,191,36,0.1) !important; color: #fbbf24 !important; }
        .alert-info    { background: rgba(56,189,248,0.1) !important; color: #38bdf8 !important; }

        .modal-content {
            background: var(--modal-bg) !important;
            border: 1px solid var(--border) !important;
            border-radius: 14px !important;
            color: var(--text-primary) !important;
        }
        .modal-header { border-bottom: 1px solid var(--border) !important; }
        .modal-footer { border-top: 1px solid var(--border) !important; }
        .btn-close { filter: var(--btn-close-filter, none) !important; }
        [data-theme="dark"] .btn-close { filter: invert(1) !important; }

        .pagination { gap: 4px; font-size: 13px; }
        .pagination .page-link {
            background: var(--bg-surface) !important;
            border: 1px solid var(--input-border) !important;
            color: var(--text-primary) !important;
            border-radius: 8px !important;
            padding: 6px 12px !important;
            font-size: 13px !important;
            font-weight: 500 !important;
            margin: 0 !important;
            transition: all 0.15s !important;
        }
        .pagination .page-link:hover {
            background: rgba(99,102,241,0.1) !important;
            border-color: rgba(99,102,241,0.3) !important;
            color: var(--accent) !important;
        }
        .pagination .page-item.active .page-link {
            background: var(--accent) !important;
            border-color: var(--accent) !important;
            color: white !important;
            font-weight: 600 !important;
        }
        .pagination .page-item.disabled .page-link {
            opacity: 0.4 !important;
            color: var(--text-muted) !important;
        }
        .pagination .page-item:first-child .page-link,
        .pagination .page-item:last-child .page-link {
            border-radius: 8px !important;
            padding: 6px 14px !important;
        }

        /* Pagination Info Text */
        .pagination-info {
            font-size: 13px !important;
            color: var(--text-secondary) !important;
            padding: 12px 0 !important;
        }
        .pagination-info strong {
            color: var(--text-primary) !important;
            font-weight: 600 !important;
        }

        .dropdown-menu {
            background: var(--dropdown-bg) !important;
            border: 1px solid var(--border) !important;
            border-radius: 12px !important;
        }
        .dropdown-item { color: var(--text-secondary) !important; border-radius: 8px !important; }
        .dropdown-item:hover, .dropdown-item:focus { background: var(--table-hover-bg) !important; color: var(--text-primary) !important; }
        .dropdown-divider { border-color: var(--border) !important; }

        .page-header { margin-bottom: 20px; }
        .page-header h4, .page-header h5 { font-size: 18px; font-weight: 600; color: var(--text-primary); margin: 0 0 4px; }
        .page-header .breadcrumb { font-size: 12px; color: var(--text-muted); }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--scrollbar-thumb); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--scrollbar-hover); }

        /* ═══════════════════════════════════════════════
           ERP COMPONENT CLASSES
           ═══════════════════════════════════════════════ */

        /* Stat Card */
        .erp-stat-card {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 16px 18px;
            display: flex; align-items: center; gap: 14px;
            transition: border-color 0.15s;
            height: 100%; flex-wrap: wrap;
        }
        .erp-stat-card:hover { border-color: rgba(99,102,241,0.25); }
        .erp-stat-icon { width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
        .erp-stat-body { flex: 1; min-width: 0; }
        .erp-stat-label { font-size: 11px; color: var(--text-muted); margin-bottom: 4px; }
        .erp-stat-value { font-size: 24px; font-weight: 600; color: var(--text-primary); line-height: 1.2; }
        .erp-stat-link {
            width: 100%; font-size: 11px; font-weight: 500; text-decoration: none;
            padding-top: 10px;
            border-top: 1px solid var(--border);
            margin-top: 4px; transition: opacity 0.15s; display: block;
        }
        .erp-stat-link:hover { opacity: 0.75; }

        /* Card */
        .erp-card { background: var(--bg-surface); border: 1px solid var(--border); border-radius: 12px; overflow: hidden; }
        .erp-card-header { display: flex; justify-content: space-between; align-items: center; padding: 14px 18px; border-bottom: 1px solid var(--border); }
        .erp-card-title { font-size: 13px; font-weight: 500; color: var(--text-secondary); }
        .erp-card-action {
            font-size: 11px; font-weight: 500; text-decoration: none;
            color: #818cf8; padding: 4px 10px; border-radius: 8px;
            border: 1px solid rgba(99,102,241,0.25);
            transition: all 0.15s;
        }
        .erp-card-action:hover { background: rgba(99,102,241,0.1); color: #818cf8; }
        .erp-card-body { padding: 16px 18px; }

        /* Table */
        .erp-table-wrap { overflow-x: auto; }
        .erp-table { width: 100%; border-collapse: collapse; font-size: 13px; }
        .erp-table th {
            padding: 12px 16px; text-align: left;
            font-size: 11px; font-weight: 600; letter-spacing: 0.5px;
            color: var(--text-secondary);
            background: var(--table-th-bg);
            border-bottom: 2px solid var(--border);
            white-space: nowrap;
        }
        .erp-table td {
            padding: 12px 16px;
            border-bottom: 1px solid var(--table-td-bd);
            color: var(--text-primary);
            vertical-align: middle;
            line-height: 1.5;
        }
        .erp-table tbody tr:last-child td { border-bottom: none; }
        .erp-table tbody tr:hover td { background: var(--table-hover-bg); }

        /* Badge */
        .erp-badge { display: inline-flex; align-items: center; font-size: 11px; font-weight: 600; padding: 3px 9px; border-radius: 6px; letter-spacing: 0.02em; white-space: nowrap; }

        /* Buttons */
        .erp-btn-primary, .erp-btn-secondary, .erp-btn-danger {
            display: inline-flex; align-items: center;
            font-size: 13px; font-weight: 500;
            padding: 7px 16px; border-radius: 8px;
            border: 1px solid transparent;
            text-decoration: none; cursor: pointer;
            transition: all 0.15s; font-family: inherit;
        }
        .erp-btn-primary { background: #6366f1; color: white !important; border-color: #6366f1; }
        .erp-btn-primary:hover { background: #4f46e5; border-color: #4f46e5; color: white !important; }
        .erp-btn-secondary { background: var(--input-bg); color: var(--text-secondary) !important; border-color: var(--input-border); }
        .erp-btn-secondary:hover { background: var(--table-hover-bg); color: var(--text-primary) !important; }
        .erp-btn-danger { background: rgba(239,68,68,0.12); color: #f87171 !important; border-color: rgba(239,68,68,0.25); }
        .erp-btn-danger:hover { background: rgba(239,68,68,0.2); color: #fca5a5 !important; }

        /* Form */
        .erp-label { display: block; font-size: 12px; font-weight: 500; color: var(--text-muted); margin-bottom: 6px; }
        .erp-input, .erp-select, .erp-textarea {
            width: 100%;
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 8px; padding: 8px 12px;
            font-size: 13px; color: var(--text-primary);
            font-family: inherit; outline: none;
            transition: border-color 0.15s, background 0.15s;
            -webkit-appearance: none; appearance: none;
        }
        .erp-input::placeholder { color: var(--text-muted); }
        /* Fix select dropdown appearance in dark mode */
        .erp-select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%238b8fa3' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 36px;
            cursor: pointer;
        }
        /* Style options for light mode */
        .erp-select option {
            background: #ffffff;
            color: #1a1d2e;
            padding: 8px;
        }
        /* Dark mode overrides for select and options */
        [data-theme="dark"] .erp-select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2394a3b8' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        }
        [data-theme="dark"] .erp-select option {
            background: #1a1e2e;
            color: #e2e8f0;
        }
        .erp-input:focus, .erp-select:focus, .erp-textarea:focus {
            border-color: rgba(99,102,241,0.5);
            background: var(--input-focus-bg);
            box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
        }
        .erp-textarea { resize: vertical; min-height: 90px; }

        /* Alert */
        .erp-alert { display: flex; align-items: center; padding: 12px 16px; border-radius: 10px; font-size: 13px; font-weight: 500; margin-bottom: 16px; }
        .erp-alert-success { background: rgba(52,211,153,0.1); color: #34d399; }
        .erp-alert-danger  { background: rgba(239,68,68,0.1);  color: #f87171; }
        .erp-alert-warning { background: rgba(251,191,36,0.1); color: #fbbf24; }
        .erp-alert-info    { background: rgba(56,189,248,0.1); color: #38bdf8; }

        /* Empty State */
        .erp-empty { display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 48px 24px; color: var(--text-muted); text-align: center; font-size: 13px; }
        .erp-empty i { font-size: 32px; margin-bottom: 10px; }

        /* ── Theme Toggle Button ── */
        .theme-toggle-btn {
            display: flex; align-items: center; justify-content: center;
            width: 36px; height: 36px;
            border-radius: 10px;
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.15s;
            font-size: 15px;
            flex-shrink: 0;
        }
        .theme-toggle-btn:hover {
            background: rgba(99,102,241,0.12);
            border-color: rgba(99,102,241,0.3);
            color: var(--accent-light);
        }

        /* ── Light mode shadow adjustments ── */
        [data-theme="light"] .erp-stat-card { box-shadow: 0 1px 4px rgba(0,0,0,0.06); }
        [data-theme="light"] .erp-card       { box-shadow: 0 1px 4px rgba(0,0,0,0.06); }
        [data-theme="light"] .erp-stat-card:hover { box-shadow: 0 4px 16px rgba(99,102,241,0.1); }
    </style>

    @stack('styles')
</head>

{{-- Apply theme class on <html> before paint to avoid flash --}}
<script>
    (function () {
        var saved = localStorage.getItem('erpTheme') || 'light';
        document.documentElement.setAttribute('data-theme', saved);
    })();
</script>

<body>

<div class="erp-layout">
    @include('layouts.partials.sidebar')

    <div class="erp-main">
        @include('layouts.partials.topbar')

        <div class="erp-content">
            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

{{-- ── Global Theme Toggle Script ── --}}
<script>
(function () {
    var html = document.documentElement;

    function applyTheme(theme) {
        html.setAttribute('data-theme', theme);
        localStorage.setItem('erpTheme', theme);

        // Update ALL toggle buttons on page
        document.querySelectorAll('[data-theme-toggle]').forEach(function (btn) {
            var icon = btn.querySelector('i');
            if (!icon) return;
            if (theme === 'dark') {
                icon.className = 'fas fa-sun';
                btn.title = 'สลับ Light Mode';
            } else {
                icon.className = 'fas fa-moon';
                btn.title = 'สลับ Dark Mode';
            }
        });
    }

    window.toggleTheme = function () {
        var current = html.getAttribute('data-theme') || 'light';
        applyTheme(current === 'light' ? 'dark' : 'light');
    };

    // Init icons after DOM ready
    document.addEventListener('DOMContentLoaded', function () {
        var current = html.getAttribute('data-theme') || 'light';
        applyTheme(current);
    });
})();
</script>

@stack('scripts')
</body>
</html>