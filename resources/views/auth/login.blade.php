<!DOCTYPE html>
<html lang="th" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="theme-color" content="#6366f1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="mobile-web-app-capable" content="yes">
    <title>เข้าสู่ระบบ - JST ERP</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Font Awesome 6 --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@300;400;500;600;700&family=Noto+Sans+Thai:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* ═══════════════════════════════════════════════
           THEME TOKENS
           ═══════════════════════════════════════════════ */
        :root,
        [data-theme="light"] {
            --bg-base:      #f0f2f7;
            --bg-surface:   #ffffff;
            --bg-raised:    #f7f8fc;
            --border:       rgba(0, 0, 0, 0.07);
            --text-primary:   #1a1d2e;
            --text-secondary: rgba(0, 0, 0, 0.5);
            --text-muted:     rgba(0, 0, 0, 0.28);
            --accent:         #6366f1;
            --accent-light:   #818cf8;
            --input-bg:       rgba(0,0,0,0.04);
            --input-border:   rgba(0,0,0,0.12);
            --input-focus-bg: rgba(99,102,241,0.05);
        }

        [data-theme="dark"] {
            --bg-base:      #0f1117;
            --bg-surface:   #12151f;
            --bg-raised:    #1a1e2e;
            --border:       rgba(255, 255, 255, 0.06);
            --text-primary:   #e2e8f0;
            --text-secondary: rgba(255,255,255,0.5);
            --text-muted:     rgba(255,255,255,0.25);
            --accent:         #6366f1;
            --accent-light:   #818cf8;
            --input-bg:       rgba(255,255,255,0.05);
            --input-border:   rgba(255,255,255,0.1);
            --input-focus-bg: rgba(99,102,241,0.05);
        }

        *, *::before, *::after {
            box-sizing: border-box;
            transition: background-color 0.22s ease, border-color 0.22s ease, color 0.18s ease, box-shadow 0.22s ease;
        }

        html, body {
            height: 100%;
            margin: 0;
            overflow: hidden;
        }

        body {
            font-family: 'IBM Plex Sans', 'Noto Sans Thai', sans-serif;
            background-color: var(--bg-base);
            color: var(--text-primary);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ═══════════════════════════════════════════════
           ANIMATED BACKGROUND
           ═══════════════════════════════════════════════ */
        .login-bg {
            position: fixed;
            inset: 0;
            z-index: 0;
            overflow: hidden;
        }

        [data-theme="light"] .login-bg {
            background: linear-gradient(135deg, #e0e7ff 0%, #f0f2f7 30%, #ede9fe 60%, #dbeafe 100%);
        }

        [data-theme="dark"] .login-bg {
            background: linear-gradient(135deg, #0f1117 0%, #1a1e2e 40%, #0f1117 70%, #12151f 100%);
        }

        /* Floating orbs */
        .login-bg .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.5;
            animation: orbFloat 20s ease-in-out infinite;
        }

        [data-theme="light"] .login-bg .orb { opacity: 0.35; }
        [data-theme="dark"] .login-bg .orb { opacity: 0.18; }

        .login-bg .orb-1 {
            width: 500px; height: 500px;
            background: #6366f1;
            top: -10%; left: -5%;
            animation-delay: 0s;
            animation-duration: 22s;
        }

        .login-bg .orb-2 {
            width: 400px; height: 400px;
            background: #818cf8;
            bottom: -15%; right: -5%;
            animation-delay: -5s;
            animation-duration: 25s;
        }

        .login-bg .orb-3 {
            width: 300px; height: 300px;
            background: #a78bfa;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            animation-delay: -10s;
            animation-duration: 18s;
        }

        .login-bg .orb-4 {
            width: 250px; height: 250px;
            background: #38bdf8;
            top: 20%; right: 15%;
            animation-delay: -7s;
            animation-duration: 20s;
        }

        @keyframes orbFloat {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25%      { transform: translate(40px, -30px) scale(1.05); }
            50%      { transform: translate(-20px, 50px) scale(0.95); }
            75%      { transform: translate(30px, 20px) scale(1.02); }
        }

        /* Grid pattern overlay */
        .login-bg .grid-overlay {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(99,102,241,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(99,102,241,0.03) 1px, transparent 1px);
            background-size: 60px 60px;
            animation: gridMove 30s linear infinite;
        }

        @keyframes gridMove {
            0%   { transform: translate(0, 0); }
            100% { transform: translate(60px, 60px); }
        }

        /* Floating particles */
        .login-bg .particles {
            position: absolute;
            inset: 0;
        }

        .login-bg .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: var(--accent-light);
            border-radius: 50%;
            opacity: 0;
            animation: particleFloat 8s ease-in-out infinite;
        }

        .login-bg .particle:nth-child(1)  { left: 10%; top: 20%; animation-delay: 0s; animation-duration: 7s; }
        .login-bg .particle:nth-child(2)  { left: 25%; top: 60%; animation-delay: -1.5s; animation-duration: 9s; }
        .login-bg .particle:nth-child(3)  { left: 45%; top: 30%; animation-delay: -3s; animation-duration: 6s; }
        .login-bg .particle:nth-child(4)  { left: 65%; top: 70%; animation-delay: -4.5s; animation-duration: 8s; }
        .login-bg .particle:nth-child(5)  { left: 80%; top: 15%; animation-delay: -6s; animation-duration: 10s; }
        .login-bg .particle:nth-child(6)  { left: 90%; top: 50%; animation-delay: -2s; animation-duration: 7.5s; }
        .login-bg .particle:nth-child(7)  { left: 35%; top: 85%; animation-delay: -5s; animation-duration: 8.5s; }
        .login-bg .particle:nth-child(8)  { left: 55%; top: 45%; animation-delay: -3.5s; animation-duration: 6.5s; }

        @keyframes particleFloat {
            0%, 100% { opacity: 0; transform: translateY(0) scale(0.5); }
            10%      { opacity: 0.6; }
            50%      { opacity: 0.4; transform: translateY(-120px) scale(1); }
            90%      { opacity: 0.6; }
        }

        /* ═══════════════════════════════════════════════
           LOGIN CONTAINER
           ═══════════════════════════════════════════════ */
        .login-wrapper {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            min-height: 100vh;
            padding: 24px;
        }

        .login-container {
            display: flex;
            width: 100%;
            max-width: 960px;
            min-height: 540px;
            border-radius: 24px;
            overflow: hidden;
            animation: loginAppear 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(30px) scale(0.96);
        }

        @keyframes loginAppear {
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        [data-theme="light"] .login-container {
            background: var(--bg-surface);
            box-shadow:
                0 4px 6px rgba(0,0,0,0.02),
                0 12px 24px rgba(0,0,0,0.04),
                0 24px 48px rgba(99,102,241,0.08);
        }

        [data-theme="dark"] .login-container {
            background: var(--bg-surface);
            box-shadow:
                0 4px 6px rgba(0,0,0,0.2),
                0 12px 24px rgba(0,0,0,0.3),
                0 24px 48px rgba(0,0,0,0.4);
            border: 1px solid var(--border);
        }

        /* ═══════════════════════════════════════════════
           LEFT PANEL — BRANDING
           ═══════════════════════════════════════════════ */
        .login-brand {
            flex: 1;
            padding: 48px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        [data-theme="light"] .login-brand {
            background: linear-gradient(135deg, #6366f1 0%, #818cf8 50%, #a78bfa 100%);
            color: white;
        }

        [data-theme="dark"] .login-brand {
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #3730a3 100%);
            color: #e2e8f0;
        }

        .login-brand::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 20% 80%, rgba(255,255,255,0.12) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255,255,255,0.08) 0%, transparent 50%);
        }

        .login-brand-content {
            position: relative;
            z-index: 1;
        }

        .brand-icon {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 28px;
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            animation: iconPulse 3s ease-in-out infinite;
        }

        @keyframes iconPulse {
            0%, 100% { transform: scale(1); }
            50%      { transform: scale(1.05); }
        }

        .brand-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: -0.02em;
        }

        .brand-subtitle {
            font-size: 14px;
            opacity: 0.85;
            margin-bottom: 32px;
            line-height: 1.6;
        }

        .brand-features {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .brand-features li {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 13px;
            padding: 8px 0;
            opacity: 0.9;
        }

        .brand-features li i {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            background: rgba(255,255,255,0.12);
            flex-shrink: 0;
        }

        /* Decorative circles on brand panel */
        .brand-decor {
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.08);
        }

        .brand-decor-1 {
            width: 200px; height: 200px;
            bottom: -60px; right: -40px;
        }

        .brand-decor-2 {
            width: 120px; height: 120px;
            top: -30px; right: 40px;
        }

        /* ═══════════════════════════════════════════════
           RIGHT PANEL — FORM
           ═══════════════════════════════════════════════ */
        .login-form-panel {
            flex: 1;
            padding: 48px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-header {
            margin-bottom: 32px;
        }

        .login-header h2 {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 6px;
        }

        .login-header p {
            font-size: 13px;
            color: var(--text-muted);
            margin: 0;
        }

        /* ═══════════════════════════════════════════════
           FORM ELEMENTS
           ═══════════════════════════════════════════════ */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label-custom {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 8px;
            letter-spacing: 0.02em;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i.input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 14px;
            color: var(--text-muted);
            transition: color 0.2s;
            z-index: 1;
        }

        .input-wrapper input {
            width: 100%;
            padding: 12px 14px 12px 42px;
            background: var(--input-bg);
            border: 1.5px solid var(--input-border);
            border-radius: 12px;
            font-size: 14px;
            color: var(--text-primary);
            font-family: inherit;
            outline: none;
            transition: all 0.2s;
        }

        .input-wrapper input::placeholder {
            color: var(--text-muted);
        }

        .input-wrapper input:focus {
            border-color: var(--accent);
            background: var(--input-focus-bg);
            box-shadow: 0 0 0 4px rgba(99,102,241,0.1);
        }

        .input-wrapper input:focus + i.input-icon,
        .input-wrapper input:focus ~ i.input-icon {
            color: var(--accent);
        }

        .password-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 4px;
            font-size: 14px;
            transition: color 0.2s;
        }

        .password-toggle:hover {
            color: var(--accent);
        }

        /* Remember me & forgot */
        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            font-size: 13px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            color: var(--text-secondary);
        }

        .remember-me input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: var(--accent);
            cursor: pointer;
        }

        .forgot-link {
            color: var(--accent);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .forgot-link:hover {
            color: var(--accent-light);
            text-decoration: underline;
        }

        /* Submit button */
        .btn-login {
            width: 100%;
            padding: 13px 24px;
            background: linear-gradient(135deg, #6366f1 0%, #818cf8 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.25s;
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
            opacity: 0;
            transition: opacity 0.25s;
        }

        .btn-login:hover::before {
            opacity: 1;
        }

        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(99,102,241,0.35);
        }

        .btn-login:active {
            transform: translateY(0);
            box-shadow: 0 4px 12px rgba(99,102,241,0.25);
        }

        .btn-login span,
        .btn-login i {
            position: relative;
            z-index: 1;
        }

        /* Loading state */
        .btn-login.loading {
            pointer-events: none;
        }

        .btn-login.loading span {
            opacity: 0;
        }

        .btn-login.loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
            z-index: 1;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* ═══════════════════════════════════════════════
           ALERT / ERROR
           ═══════════════════════════════════════════════ */
        .login-alert {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 20px;
            animation: alertSlide 0.4s ease-out;
        }

        @keyframes alertSlide {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .login-alert-error {
            background: rgba(239,68,68,0.1);
            color: #f87171;
            border: 1px solid rgba(239,68,68,0.15);
        }

        .login-alert ul {
            margin: 0;
            padding-left: 16px;
        }

        .login-alert li {
            margin-bottom: 2px;
        }

        /* ═══════════════════════════════════════════════
           THEME TOGGLE
           ═══════════════════════════════════════════════ */
        .theme-toggle-absolute {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: var(--bg-surface);
            border: 1px solid var(--border);
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.2s;
            font-size: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        [data-theme="light"] .theme-toggle-absolute {
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        [data-theme="dark"] .theme-toggle-absolute {
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        }

        .theme-toggle-absolute:hover {
            background: rgba(99,102,241,0.12);
            border-color: rgba(99,102,241,0.3);
            color: var(--accent-light);
            transform: rotate(15deg);
        }

        /* ═══════════════════════════════════════════════
           FOOTER
           ═══════════════════════════════════════════════ */
        .login-footer {
            text-align: center;
            margin-top: 24px;
            font-size: 11px;
            color: var(--text-muted);
        }

        /* ═══════════════════════════════════════════════
           RESPONSIVE
           ═══════════════════════════════════════════════ */
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                max-width: 440px;
                min-height: auto;
            }

            .login-brand {
                padding: 32px 28px;
                min-height: auto;
            }

            .brand-features {
                display: none;
            }

            .brand-title {
                font-size: 22px;
            }

            .login-form-panel {
                padding: 32px 28px;
            }

            .brand-icon {
                width: 48px;
                height: 48px;
                font-size: 22px;
                margin-bottom: 20px;
            }

            .brand-subtitle {
                margin-bottom: 0;
            }
        }

        @media (max-width: 480px) {
            .login-wrapper {
                padding: 16px;
            }

            .login-container {
                border-radius: 20px;
            }

            .login-brand {
                padding: 24px 20px;
            }

            .login-form-panel {
                padding: 24px 20px;
            }
        }
    </style>
</head>

<body>
    {{-- Animated Background --}}
    <div class="login-bg">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
        <div class="orb orb-4"></div>
        <div class="grid-overlay"></div>
        <div class="particles">
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
        </div>
    </div>

    {{-- Theme Toggle --}}
    <button class="theme-toggle-absolute" data-theme-toggle onclick="toggleTheme()" title="สลับ Dark Mode">
        <i class="fas fa-moon"></i>
    </button>

    {{-- Login Container --}}
    <div class="login-wrapper">
        <div class="login-container">
            {{-- Left: Branding --}}
            <div class="login-brand">
                <div class="brand-decor brand-decor-1"></div>
                <div class="brand-decor brand-decor-2"></div>
                <div class="login-brand-content">
                    <div class="brand-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <h1 class="brand-title">JST ERP System</h1>
                    <p class="brand-subtitle">ระบบจัดการทรัพยากรองค์กรแบบครบวงจร<br>จัดการธุรกิจของคุณได้อย่างมีประสิทธิภาพ</p>
                    <ul class="brand-features">
                        <li>
                            <i class="fas fa-users"></i>
                            <span>จัดการพนักงานและแผนก</span>
                        </li>
                        <li>
                            <i class="fas fa-box-open"></i>
                            <span>ระบบคลังสินค้าและเบิกจ่าย</span>
                        </li>
                        <li>
                            <i class="fas fa-chart-line"></i>
                            <span>รายงานและวิเคราะห์ข้อมูล</span>
                        </li>
                        <li>
                            <i class="fas fa-clock"></i>
                            <span>บันทึกเวลาทำงาน</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Right: Login Form --}}
            <div class="login-form-panel">
                <div class="login-header">
                    <h2>เข้าสู่ระบบ</h2>
                    <p>กรุณากรอกข้อมูลเพื่อเข้าสู่ระบบ</p>
                </div>

                @if ($errors->any())
                    <div class="login-alert login-alert-error">
                        <i class="fas fa-exclamation-circle" style="margin-top: 2px;"></i>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ url('/login') }}" method="POST" id="loginForm">
                    @csrf

                    <div class="form-group">
                        <label for="username" class="form-label-custom">ชื่อผู้ใช้งาน</label>
                        <div class="input-wrapper">
                            <input
                                type="text"
                                id="username"
                                name="username"
                                value="{{ old('username') }}"
                                placeholder="กรอกชื่อผู้ใช้งาน"
                                required
                                autofocus
                                autocomplete="username"
                            >
                            <i class="fas fa-user input-icon"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label-custom">รหัสผ่าน</label>
                        <div class="input-wrapper">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="กรอกรหัสผ่าน"
                                required
                                autocomplete="current-password"
                            >
                            <i class="fas fa-lock input-icon"></i>
                            <button type="button" class="password-toggle" onclick="togglePassword()" aria-label="แสดงรหัสผ่าน">
                                <i class="fas fa-eye" id="passwordToggleIcon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-options">
                        <label class="remember-me">
                            <input type="checkbox" name="remember">
                            <span>จดจำฉัน</span>
                        </label>
                        <a href="#" class="forgot-link">ลืมรหัสผ่าน?</a>
                    </div>

                    <button type="submit" class="btn-login" id="loginBtn">
                        <i class="fas fa-right-to-bracket"></i>
                        <span>เข้าสู่ระบบ</span>
                    </button>
                </form>

                <div class="login-footer">
                    &copy; {{ date('Y') }} JST ERP System. All rights reserved.
                </div>
            </div>
        </div>
    </div>

    <script>
        (function () {
            var saved = localStorage.getItem('erpTheme') || 'light';
            document.documentElement.setAttribute('data-theme', saved);
        })();

        window.toggleTheme = function () {
            var html = document.documentElement;
            var current = html.getAttribute('data-theme') || 'light';
            var next = current === 'light' ? 'dark' : 'light';
            html.setAttribute('data-theme', next);
            localStorage.setItem('erpTheme', next);

            document.querySelectorAll('[data-theme-toggle]').forEach(function (btn) {
                var icon = btn.querySelector('i');
                if (!icon) return;
                icon.className = next === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
                btn.title = next === 'dark' ? 'สลับ Light Mode' : 'สลับ Dark Mode';
            });
        };

        function togglePassword() {
            var pwd = document.getElementById('password');
            var icon = document.getElementById('passwordToggleIcon');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                icon.className = 'fas fa-eye-slash';
            } else {
                pwd.type = 'password';
                icon.className = 'fas fa-eye';
            }
        }

        document.getElementById('loginForm').addEventListener('submit', function () {
            var btn = document.getElementById('loginBtn');
            btn.classList.add('loading');
        });
    </script>
</body>
</html>
