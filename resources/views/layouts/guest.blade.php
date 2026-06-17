<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Masuk') - PengingatKuliah</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script>
        /* Apply saved/system theme before paint to avoid flash */
        (function() {
            var saved = localStorage.getItem('pk-theme');
            var prefer = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', saved || prefer);
        })();
    </script>

    <style>
        /* ── Light theme ───────────────────────────── */
        :root,
        [data-theme="light"] {
            --primary:        #2563EB;
            --primary-light:  #60A5FA;
            --orange:         #F97316;
            --orange-light:   #FB923C;
            --bg:             #F8FAFC;
            --card-bg:        #FFFFFF;
            --border:         #E2E8F0;
            --text:           #1E293B;
            --text-muted:     #64748B;
            --success:        #22C55E;
            --danger:         #EF4444;
            --input-bg:       #F8FAFC;
            --input-focus:    #FFFFFF;
            --brand-panel-from: #1D4ED8;
            --brand-panel-to:   #60A5FA;
        }

        /* ── Dark theme ────────────────────────────── */
        [data-theme="dark"] {
            --primary:        #60A5FA;
            --primary-light:  #93C5FD;
            --orange:         #FB923C;
            --orange-light:   #FDBA74;
            --bg:             #0F172A;
            --card-bg:        #1E293B;
            --border:         #334155;
            --text:           #F1F5F9;
            --text-muted:     #94A3B8;
            --success:        #4ADE80;
            --danger:         #F87171;
            --input-bg:       #0F172A;
            --input-focus:    #1E293B;
            --brand-panel-from: #1E3A8A;
            --brand-panel-to:   #1D4ED8;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* ── Split layout ─────────────────────────── */
        .auth-wrapper { display: flex; min-height: 100vh; }

        /* Left branding panel */
        .auth-brand {
            flex: 0 0 46%;
            background: linear-gradient(145deg, var(--brand-panel-from) 0%, #2563EB 40%, var(--brand-panel-to) 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 48px 44px;
            position: relative;
            overflow: hidden;
        }

        .auth-brand::before {
            content: '';
            position: absolute;
            top: -80px; right: -80px;
            width: 340px; height: 340px;
            background: radial-gradient(circle, rgba(255,255,255,0.1), transparent 70%);
            border-radius: 50%;
        }

        .auth-brand::after {
            content: '';
            position: absolute;
            bottom: -100px; left: -60px;
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(249,115,22,0.2), transparent 70%);
            border-radius: 50%;
        }

        .brand-content {
            position: relative;
            z-index: 2;
            text-align: center;
            max-width: 360px;
        }

        .brand-logo {
            width: 72px; height: 72px;
            background: rgba(255,255,255,0.18);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            display: flex; align-items: center; justify-content: center;
            font-size: 32px; color: #fff;
            margin: 0 auto 22px;
            box-shadow: 0 8px 28px rgba(0,0,0,0.15);
            border: 1px solid rgba(255,255,255,0.25);
        }

        .brand-title {
            font-size: 26px; font-weight: 800;
            color: #fff; letter-spacing: -0.5px;
            margin-bottom: 10px;
        }

        .brand-subtitle {
            color: rgba(255,255,255,0.82);
            font-size: 14px; line-height: 1.7;
            margin-bottom: 36px;
        }

        .brand-features {
            list-style: none; text-align: left;
            display: flex; flex-direction: column; gap: 14px;
        }

        .brand-features li {
            display: flex; align-items: center; gap: 12px;
            color: rgba(255,255,255,0.9);
            font-size: 13.5px; font-weight: 500;
        }

        .feature-dot {
            width: 28px; height: 28px;
            background: rgba(255,255,255,0.18);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; color: #fff; flex-shrink: 0;
        }

        .brand-stats {
            display: flex; gap: 12px;
            margin-top: 36px; justify-content: center;
        }

        .brand-stat-pill {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 30px;
            padding: 8px 16px; text-align: center;
        }
        .brand-stat-pill .num { font-size: 18px; font-weight: 800; color: #fff; display: block; }
        .brand-stat-pill .lbl { font-size: 10px; color: rgba(255,255,255,0.75); font-weight: 500; }

        /* Right form panel */
        .auth-form-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 36px;
            background: var(--card-bg);
            overflow-y: auto;
            transition: background-color 0.3s ease;
            position: relative;
        }

        /* Theme toggle on form panel */
        .auth-theme-btn {
            position: absolute;
            top: 20px; right: 20px;
            background: var(--bg);
            border: 1px solid var(--border);
            color: var(--text-muted);
            border-radius: 8px;
            padding: 7px 9px;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.2s ease;
            line-height: 1;
        }
        .auth-theme-btn:hover {
            color: var(--orange);
            border-color: var(--orange);
            background: rgba(249,115,22,0.06);
        }

        .auth-card { width: 100%; max-width: 420px; }

        .auth-card h2 {
            font-size: 24px; font-weight: 800;
            letter-spacing: -0.4px;
            color: var(--text); margin-bottom: 4px;
        }

        .auth-subtitle { color: var(--text-muted); font-size: 14px; margin-bottom: 28px; }

        /* Form elements */
        .auth-form .form-label {
            font-size: 12px; font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 5px;
            text-transform: uppercase; letter-spacing: 0.3px;
        }

        .auth-form .input-wrap { position: relative; }

        .auth-form .input-icon {
            position: absolute;
            left: 13px; top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted); font-size: 15px;
            z-index: 5; pointer-events: none;
        }

        .auth-form .form-control {
            background: var(--input-bg);
            border: 1.5px solid var(--border);
            color: var(--text);
            border-radius: 10px;
            padding: 11px 14px 11px 40px;
            font-size: 14px; font-family: inherit;
            transition: all 0.2s ease;
            width: 100%;
        }

        .auth-form .form-control:focus {
            background: var(--input-focus);
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(96,165,250,0.15);
            outline: none; color: var(--text);
        }

        .auth-form .form-control::placeholder { color: var(--text-muted); opacity: 0.5; }

        .auth-form .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .auth-form .form-check-label { color: var(--text-muted); font-size: 13px; }

        /* Submit button */
        .btn-auth {
            background: linear-gradient(135deg, var(--orange), var(--orange-light));
            border: none; color: #fff;
            padding: 13px 24px; border-radius: 10px;
            font-size: 15px; font-weight: 700; width: 100%;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            font-family: inherit;
            box-shadow: 0 3px 12px rgba(249,115,22,0.3);
        }
        .btn-auth:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(249,115,22,0.4);
            color: #fff;
        }
        .btn-auth:active { transform: translateY(0); }

        /* Links */
        .auth-link {
            color: var(--primary);
            font-size: 13px; text-decoration: none;
            font-weight: 600; transition: color 0.2s;
        }
        .auth-link:hover { color: var(--orange); text-decoration: underline; }

        /* Alerts */
        .auth-alert {
            border-radius: 10px; font-size: 13px;
            padding: 10px 14px; margin-bottom: 16px;
        }
        .auth-alert-danger {
            background: rgba(248,113,113,0.1);
            border: 1px solid rgba(248,113,113,0.25);
            color: var(--danger);
        }
        .auth-alert-success {
            background: rgba(74,222,128,0.1);
            border: 1px solid rgba(74,222,128,0.25);
            color: var(--success);
        }

        .auth-divider { border-color: var(--border); margin: 20px 0; }

        .toggle-password {
            position: absolute; right: 12px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none;
            color: var(--text-muted); cursor: pointer;
            z-index: 5; padding: 0; font-size: 15px;
            transition: color 0.2s;
        }
        .toggle-password:hover { color: var(--text); }

        .text-danger { color: var(--danger) !important; font-size: 12px; margin-top: 4px; }

        /* Responsive */
        @media (max-width: 991px) { .auth-brand { display: none; } }
        @media (max-width: 480px) { .auth-form-panel { padding: 24px 20px; } }
    </style>
</head>
<body>
<div class="auth-wrapper">

    <!-- Left branding panel -->
    <div class="auth-brand">
        <div class="brand-content">
            <div class="brand-logo">
                <i class="bi bi-mortarboard-fill"></i>
            </div>
            <h1 class="brand-title">PengingatKuliah</h1>
            <p class="brand-subtitle">Platform produktivitas akademik untuk mahasiswa. Kelola jadwal, tugas, dan catatan dalam satu tempat.</p>

            <ul class="brand-features">
                <li>
                    <span class="feature-dot"><i class="bi bi-calendar-check"></i></span>
                    Jadwal kuliah &amp; kalender akademik
                </li>
                <li>
                    <span class="feature-dot"><i class="bi bi-journal-check"></i></span>
                    Tracking tugas &amp; deadline otomatis
                </li>
                <li>
                    <span class="feature-dot"><i class="bi bi-sticky"></i></span>
                    Catatan perkuliahan terorganisir
                </li>
                <li>
                    <span class="feature-dot"><i class="bi bi-bell-fill"></i></span>
                    Reminder &amp; notifikasi deadline
                </li>
            </ul>

            <div class="brand-stats">
                <div class="brand-stat-pill">
                    <span class="num">100%</span>
                    <span class="lbl">Gratis</span>
                </div>
                <div class="brand-stat-pill">
                    <span class="num">∞</span>
                    <span class="lbl">Catatan</span>
                </div>
                <div class="brand-stat-pill">
                    <span class="num">PDF</span>
                    <span class="lbl">Export</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right form panel -->
    <div class="auth-form-panel">
        <!-- Theme toggle -->
        <button class="auth-theme-btn" id="authThemeToggle" onclick="toggleTheme()" title="Ganti tema">
            <i class="bi bi-moon-fill" id="authThemeIcon"></i>
        </button>

        <div class="auth-card">
            {{ $slot }}
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    /* ── Theme ── */
    function applyTheme(theme) {
        document.documentElement.setAttribute('data-theme', theme);
        localStorage.setItem('pk-theme', theme);
        const icon = document.getElementById('authThemeIcon');
        if (icon) icon.className = theme === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
    }

    function toggleTheme() {
        const current = document.documentElement.getAttribute('data-theme') || 'light';
        applyTheme(current === 'dark' ? 'light' : 'dark');
    }

    /* Set correct icon on load */
    (function() {
        const t = document.documentElement.getAttribute('data-theme') || 'light';
        const icon = document.getElementById('authThemeIcon');
        if (icon) icon.className = t === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
    })();

    /* ── Password visibility toggle ── */
    document.querySelectorAll('.toggle-password').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const wrap = this.closest('.input-wrap');
            const input = wrap ? wrap.querySelector('input') : this.previousElementSibling;
            if (!input) return;
            const isPass = input.type === 'password';
            input.type = isPass ? 'text' : 'password';
            this.querySelector('i').classList.toggle('bi-eye');
            this.querySelector('i').classList.toggle('bi-eye-slash');
        });
    });
</script>
</body>
</html>
