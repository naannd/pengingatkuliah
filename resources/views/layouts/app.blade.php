<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - PengingatKuliah</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script>
        /* Apply theme before paint to avoid flash */
        (function() {
            var saved = localStorage.getItem('pk-theme');
            var prefer = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', saved || prefer);
        })();
    </script>

    <style>
        /* ═══════════════════════ LIGHT THEME ═══════════════════════ */
        :root,
        [data-theme="light"] {
            --primary:        #2563EB;
            --primary-light:  #60A5FA;
            --orange:         #F97316;
            --orange-light:   #FB923C;
            --bg:             #F8FAFC;
            --sidebar-bg:     #FFFFFF;
            --card-bg:        #FFFFFF;
            --border:         #E2E8F0;
            --text:           #1E293B;
            --text-muted:     #64748B;
            --success:        #22C55E;
            --warning:        #F59E0B;
            --danger:         #EF4444;
            --shadow-sm:      0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
            --shadow-md:      0 4px 12px rgba(0,0,0,0.08), 0 2px 4px rgba(0,0,0,0.04);
            --shadow-lg:      0 10px 28px rgba(0,0,0,0.1), 0 4px 8px rgba(0,0,0,0.04);
            --input-bg:       #F8FAFC;
            --input-focus-bg: #FFFFFF;
        }

        /* ═══════════════════════ DARK THEME ═══════════════════════ */
        [data-theme="dark"] {
            --primary:        #3B82F6;
            --primary-light:  #60A5FA;
            --orange:         #F97316;
            --orange-light:   #FB923C;
            --bg:             #111827;
            --sidebar-bg:     #1F2937;
            --card-bg:        #374151;
            --border:         #4B5563;
            --text:           #F9FAFB;
            --text-muted:     #D1D5DB;
            --muted:          #9CA3AF;
            --success:        #4ADE80;
            --warning:        #FBBF24;
            --danger:         #F87171;
            --shadow-sm:      0 1px 2px rgba(0,0,0,0.18), 0 1px 3px rgba(0,0,0,0.12);
            --shadow-md:      0 4px 6px rgba(0,0,0,0.2), 0 2px 4px rgba(0,0,0,0.12);
            --shadow-lg:      0 10px 15px rgba(0,0,0,0.25), 0 4px 6px rgba(0,0,0,0.12);
            --input-bg:       #1F2937;
            --input-focus-bg: #283344;
        }

        /* ═══════════════════════ BASE ═══════════════════════ */
        :root {
            --radius:    14px;
            --radius-sm: 8px;
            --sidebar-w: 268px;
            --navbar-h:  64px;
            --transition: 0.3s ease;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--bg);
            color: var(--text);
            height: 100%;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* ═══════════════════════ SIDEBAR ═══════════════════════ */
        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: var(--sidebar-w);
            background: var(--sidebar-bg);
            border-right: 1px solid var(--border);
            z-index: 1050;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            overflow-x: hidden;
            transition: transform var(--transition), background-color 0.3s ease, border-color 0.3s ease;
        }

        .sidebar-header {
            padding: 20px 18px 16px;
            border-bottom: 1px solid var(--border);
            flex-shrink: 0;
            position: relative;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .sidebar-brand .brand-icon {
            width: 34px; height: 34px;
            background: linear-gradient(135deg, #2563EB, #60A5FA);
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px; color: #fff; flex-shrink: 0;
            box-shadow: 0 3px 10px rgba(37,99,235,0.35);
        }

        .sidebar-brand .brand-name {
            font-weight: 800;
            font-size: 17px;
            letter-spacing: -0.4px;
            background: linear-gradient(135deg, var(--primary), var(--orange));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .sidebar-close-btn {
            display: none;
            position: absolute;
            top: 18px; right: 14px;
            background: none; border: none;
            color: var(--text-muted); font-size: 20px; cursor: pointer;
        }

        .sidebar-body {
            flex: 1;
            padding: 12px 0 20px;
            overflow-y: auto;
        }

        .nav-section-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            color: var(--text-muted);
            padding: 14px 18px 6px;
            opacity: 0.6;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 11px;
            margin: 2px 10px;
            padding: 9px 12px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            border-radius: 9px;
            transition: all var(--transition);
        }

        .sidebar-nav a .nav-icon {
            width: 32px; height: 32px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 8px;
            font-size: 16px;
            flex-shrink: 0;
            background: transparent;
            transition: all var(--transition);
        }

        .sidebar-nav a:hover {
            background: rgba(96,165,250,0.08);
            color: var(--primary);
        }

        .sidebar-nav a:hover .nav-icon {
            background: rgba(96,165,250,0.1);
            color: var(--primary);
        }

        .sidebar-nav a.active {
            background: linear-gradient(135deg, #2563EB, #60A5FA);
            color: #fff;
            font-weight: 600;
            box-shadow: 0 3px 12px rgba(37,99,235,0.35);
        }

        [data-theme="dark"] .sidebar-nav a.active {
            background: linear-gradient(135deg, #1D4ED8, #3B82F6);
            box-shadow: 0 3px 12px rgba(59,130,246,0.4);
        }

        .sidebar-nav a.active .nav-icon {
            background: rgba(255,255,255,0.2);
            color: #fff;
        }

        .sidebar-footer {
            padding: 14px 16px;
            border-top: 1px solid var(--border);
            flex-shrink: 0;
        }

        .motivasi-card {
            background: linear-gradient(135deg, #2563EB, #60A5FA);
            color: white;
            border-radius: var(--radius);
            padding: 14px;
            text-align: center;
            box-shadow: 0 4px 14px rgba(37,99,235,0.3);
        }

        .motivasi-card h6 { font-weight: 700; margin-bottom: 4px; font-size: 12px; }
        .motivasi-card p  { font-size: 11px; margin-bottom: 10px; opacity: 0.88; line-height: 1.5; }
        .motivasi-card .btn-mo {
            background: rgba(255,255,255,0.95);
            color: #2563EB;
            border: none; font-size: 11px; border-radius: 7px;
            font-weight: 600; padding: 5px 14px; cursor: pointer;
            transition: background var(--transition);
        }
        .motivasi-card .btn-mo:hover { background: #fff; }

        /* ═══════════════════════ OVERLAY ═══════════════════════ */
        .sidebar-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(15,23,42,0.5);
            z-index: 1040;
            backdrop-filter: blur(3px);
        }
        .sidebar-overlay.active { display: block; }

        /* ═══════════════════════ NAVBAR ═══════════════════════ */
        .top-navbar {
            position: fixed;
            top: 0; right: 0;
            left: var(--sidebar-w);
            background: var(--sidebar-bg);
            border-bottom: 1px solid var(--border);
            height: var(--navbar-h);
            z-index: 999;
            display: flex;
            align-items: center;
            padding: 0 24px;
            gap: 14px;
            box-shadow: var(--shadow-sm);
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .hamburger-btn {
            display: none;
            background: none; border: none;
            color: var(--text); font-size: 20px;
            cursor: pointer; padding: 6px;
            border-radius: 8px;
            transition: all var(--transition);
            flex-shrink: 0;
        }
        .hamburger-btn:hover { background: rgba(96,165,250,0.08); color: var(--primary); }

        .navbar-page-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--text);
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .search-bar { flex: 1; max-width: 340px; }

        .search-wrapper { position: relative; }

        .search-wrapper .bi-search {
            position: absolute; left: 11px; top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted); font-size: 13px;
            pointer-events: none;
        }

        .search-bar input {
            width: 100%;
            padding: 8px 14px 8px 38px;
            border: 1px solid var(--border);
            border-radius: 9px;
            background: var(--input-bg);
            color: var(--text);
            font-size: 13px;
            outline: none;
            transition: all var(--transition);
            font-family: inherit;
        }

        .search-bar input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(96,165,250,0.15);
            background: var(--input-focus-bg);
        }

        .search-bar input::placeholder { color: var(--text-muted); }

        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-left: auto;
            flex-shrink: 0;
        }

        .icon-btn {
            background: none; border: none;
            cursor: pointer; color: var(--text-muted);
            font-size: 18px;
            transition: all var(--transition);
            position: relative; padding: 7px;
            border-radius: 8px;
            line-height: 1;
        }
        .icon-btn:hover { color: var(--primary); background: rgba(96,165,250,0.08); }

        .notif-wrapper { position: relative; }

        .notif-badge {
            position: absolute; top: 1px; right: 0;
            min-width: 17px; height: 17px;
            background: var(--danger); color: #fff;
            border-radius: 50%;
            font-size: 10px; font-weight: 700;
            display: none; align-items: center; justify-content: center;
            border: 2px solid var(--sidebar-bg);
            padding: 0 4px; line-height: 1;
            pointer-events: none;
        }
        .notif-badge.show { display: flex; }

        .notif-panel {
            display: none;
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            width: 400px;
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            z-index: 1100;
            overflow: hidden;
            animation: notifSlide 0.22s ease;
        }
        .notif-panel.open { display: block; }

        @keyframes notifSlide {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .notif-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 14px 16px;
            border-bottom: 1px solid var(--border);
        }
        .notif-header h6 {
            font-size: 14px; font-weight: 700; color: var(--text); margin: 0;
        }
        .notif-count-label {
            font-size: 11px; font-weight: 600; color: var(--text-muted);
            background: var(--bg); padding: 3px 10px; border-radius: 20px;
        }

        .notif-body {
            max-height: 420px;
            overflow-y: auto;
        }
        .notif-body::-webkit-scrollbar { width: 4px; }
        .notif-body::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }

        .notif-item {
            display: flex; align-items: flex-start; gap: 12px;
            padding: 12px 16px;
            border-bottom: 1px solid var(--border);
            text-decoration: none; color: inherit;
            transition: background var(--transition);
            border-left: 3px solid transparent;
        }
        .notif-item:last-child { border-bottom: none; }
        .notif-item:hover { background: rgba(96,165,250,0.04); }
        .notif-item[data-p="urgent"]  { border-left-color: #EF4444; }
        .notif-item[data-p="warning"] { border-left-color: #F97316; }
        .notif-item[data-p="info"]    { border-left-color: #3B82F6; }
        .notif-item[data-type="reminder"] { border-left-color: #8B5CF6; }
        .notif-item[data-type="jadwal"]   { border-left-color: #3B82F6; }

        .notif-icon-wrap {
            width: 36px; height: 36px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px; flex-shrink: 0;
        }
        .notif-item-body { flex: 1; min-width: 0; }
        .notif-item-label {
            font-size: 11px; font-weight: 600; margin-bottom: 2px;
            text-transform: uppercase; letter-spacing: 0.3px;
        }
        .notif-item-title {
            font-size: 13px; font-weight: 600; color: var(--text);
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .notif-item-time {
            font-size: 11px; color: var(--text-muted); margin-top: 2px;
        }

        .notif-footer {
            padding: 10px 16px;
            border-top: 1px solid var(--border);
            text-align: center;
        }
        .notif-footer a {
            font-size: 13px; font-weight: 600; color: var(--primary);
            text-decoration: none; transition: color var(--transition);
        }
        .notif-footer a:hover { color: var(--primary-light); }

        .notif-loading {
            padding: 40px 16px; text-align: center;
            color: var(--text-muted); font-size: 13px;
        }

        .notif-empty {
            padding: 40px 16px; text-align: center; color: var(--text-muted);
        }
        .notif-empty i { font-size: 32px; display: block; margin-bottom: 8px; opacity: 0.5; }
        .notif-empty p { font-size: 13px; margin: 0; }

        /* Theme toggle button */
        .theme-toggle {
            background: none; border: 1px solid var(--border);
            cursor: pointer; color: var(--text-muted);
            font-size: 15px;
            transition: all var(--transition);
            padding: 6px 8px;
            border-radius: 8px;
            line-height: 1;
            display: flex; align-items: center; justify-content: center;
        }
        .theme-toggle:hover {
            color: var(--orange);
            border-color: var(--orange);
            background: rgba(249,115,22,0.06);
        }

        .user-chip {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 4px 12px 4px 4px;
            border-radius: 30px;
            border: 1px solid var(--border);
            cursor: pointer;
            transition: all var(--transition);
            background: transparent;
            text-decoration: none;
        }
        .user-chip:hover { background: var(--bg); border-color: var(--primary); }

        .user-avatar {
            width: 32px; height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2563EB, #F97316);
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 12px;
            flex-shrink: 0;
        }

        .user-name { font-size: 13px; font-weight: 600; color: var(--text); }

        /* ═══════════════════════ MAIN ═══════════════════════ */
        main {
            margin-left: var(--sidebar-w);
            margin-top: var(--navbar-h);
            padding: 28px 30px;
            min-height: calc(100vh - var(--navbar-h));
            transition: background-color 0.3s ease;
        }

        .page-header { margin-bottom: 24px; }

        .page-header h2 {
            font-size: clamp(18px, 2.5vw, 24px);
            font-weight: 800;
            letter-spacing: -0.4px;
            color: var(--text);
            margin-bottom: 4px;
        }

        .page-header p { font-size: 14px; color: var(--text-muted); margin: 0; }

        /* ═══════════════════════ CARDS ═══════════════════════ */
        .dashboard-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 20px;
            box-shadow: var(--shadow-sm);
            transition: all var(--transition);
        }

        .dashboard-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            border-color: rgba(96,165,250,0.2);
        }

        .card-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* ═══════════════════════ STAT CARDS ═══════════════════════ */
        .stat-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 20px 18px;
            box-shadow: var(--shadow-sm);
            transition: all var(--transition);
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-md); }

        .stat-card-inner {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .stat-card-info { flex: 1; }
        .stat-label { font-size: 12px; font-weight: 600; color: var(--text-muted); margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.4px; }
        .stat-value { font-size: 28px; font-weight: 800; color: var(--text); letter-spacing: -0.5px; line-height: 1; }
        .stat-sub   { font-size: 12px; color: var(--text-muted); margin-top: 4px; }

        .stat-icon-wrap {
            width: 46px; height: 46px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px; flex-shrink: 0;
        }

        .stat-blue   { background: rgba(96,165,250,0.12);  color: var(--primary); }
        .stat-orange { background: rgba(251,146,60,0.12);  color: var(--orange); }
        .stat-purple { background: rgba(167,139,250,0.12); color: #A78BFA; }
        .stat-red    { background: rgba(248,113,113,0.12); color: var(--danger); }
        .stat-green  { background: rgba(74,222,128,0.12);  color: var(--success); }
        .stat-yellow { background: rgba(251,191,36,0.12);  color: var(--warning); }

        .stat-accent-line {
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 3px;
            border-radius: 0 0 var(--radius) var(--radius);
        }

        /* ═══════════════════════ BUTTONS ═══════════════════════ */
        .btn-primary {
            background: linear-gradient(135deg, var(--orange), var(--orange-light)) !important;
            border-color: transparent !important;
            color: #fff !important;
            font-weight: 600; font-size: 13px;
            border-radius: 9px !important;
            box-shadow: 0 2px 8px rgba(249,115,22,0.25) !important;
            transition: all var(--transition) !important;
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 16px rgba(249,115,22,0.35) !important;
        }

        .btn-outline-primary {
            color: var(--primary) !important;
            border-color: var(--primary) !important;
            font-weight: 500; font-size: 13px;
            border-radius: 8px !important;
            transition: all var(--transition) !important;
            background: transparent !important;
        }
        .btn-outline-primary:hover {
            background: var(--primary) !important;
            color: #fff !important;
        }

        .btn-outline-secondary {
            color: var(--text-muted) !important;
            border-color: var(--border) !important;
            font-weight: 500; font-size: 13px;
            border-radius: 8px !important;
            transition: all var(--transition) !important;
            background: transparent !important;
        }
        .btn-outline-secondary:hover {
            background: var(--bg) !important;
            color: var(--text) !important;
            border-color: var(--text-muted) !important;
        }

        .btn-outline-danger {
            color: var(--danger) !important;
            border-color: rgba(239,68,68,0.4) !important;
            font-weight: 500; font-size: 13px;
            border-radius: 8px !important;
            transition: all var(--transition) !important;
            background: transparent !important;
        }
        .btn-outline-danger:hover {
            background: var(--danger) !important;
            color: #fff !important;
        }

        .btn-outline-success {
            color: var(--success) !important;
            border-color: rgba(34,197,94,0.4) !important;
            font-weight: 500; font-size: 13px;
            border-radius: 8px !important;
            transition: all var(--transition) !important;
            background: transparent !important;
        }
        .btn-outline-success:hover {
            background: var(--success) !important;
            color: #fff !important;
        }

        .btn-success {
            background: var(--success) !important;
            border-color: var(--success) !important;
            color: #fff !important;
            font-weight: 600; font-size: 13px;
            border-radius: 8px !important;
            transition: all var(--transition) !important;
        }

        .btn-danger {
            background: var(--danger) !important;
            border-color: var(--danger) !important;
            color: #fff !important;
            font-weight: 600; font-size: 13px;
            border-radius: 8px !important;
            transition: all var(--transition) !important;
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--warning), #FBBF24) !important;
            border-color: transparent !important;
            color: #fff !important;
            font-weight: 600; font-size: 13px;
            border-radius: 8px !important;
            transition: all var(--transition) !important;
        }

        .btn-secondary-grad {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: #fff; border: none;
            padding: 9px 20px; border-radius: 9px;
            font-size: 13.5px; font-weight: 600;
            cursor: pointer; display: inline-flex; align-items: center; gap: 6px;
            transition: all var(--transition);
            text-decoration: none;
        }
        .btn-secondary-grad:hover { transform: translateY(-1px); color: #fff; }

        /* ═══════════════════════ LIST ITEMS ═══════════════════════ */
        .class-item { padding: 14px 0; border-bottom: 1px solid var(--border); }
        .class-item:last-child { border-bottom: none; }
        .class-item-header { display: flex; justify-content: space-between; margin-bottom: 5px; flex-wrap: wrap; gap: 4px; }
        .class-item-subject { font-weight: 600; color: var(--text); font-size: 14px; }
        .class-item-time { font-size: 12px; color: var(--text-muted); font-weight: 500; }
        .class-item-details { font-size: 12px; color: var(--text-muted); display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }

        .deadline-item {
            padding: 14px 0;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
        }
        .deadline-item:last-child { border-bottom: none; }
        .deadline-text { flex: 1; min-width: 0; }

        .reminder-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 0;
            border-bottom: 1px solid var(--border);
        }
        .reminder-item:last-child { border-bottom: none; }

        .checklist-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid var(--border);
        }
        .checklist-item:last-child { border-bottom: none; }

        /* ═══════════════════════ BADGES ═══════════════════════ */
        .tag-badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }
        .tag-blue   { background: rgba(96,165,250,0.15);  color: var(--primary); }
        .tag-orange { background: rgba(251,146,60,0.15);  color: var(--orange); }
        .tag-green  { background: rgba(74,222,128,0.15);  color: var(--success); }
        .tag-red    { background: rgba(248,113,113,0.15); color: var(--danger); }
        .tag-yellow { background: rgba(251,191,36,0.15);  color: var(--warning); }
        .tag-purple { background: rgba(167,139,250,0.15); color: #A78BFA; }

        /* ═══════════════════════ PROGRESS ═══════════════════════ */
        .progress-track {
            height: 7px;
            background: rgba(251,146,60,0.12);
            border-radius: 10px;
            overflow: hidden;
        }
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--orange), var(--orange-light));
            border-radius: 10px;
            transition: width 0.6s ease;
        }

        /* ═══════════════════════ FILTER BAR ═══════════════════════ */
        .filter-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 20px;
            padding: 14px 16px;
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
        }

        .filter-bar .search-group { position: relative; flex: 1; min-width: 180px; }

        .filter-bar .search-icon {
            position: absolute; left: 11px; top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted); font-size: 13px; pointer-events: none;
        }

        .filter-bar input {
            width: 100%;
            padding: 8px 12px 8px 34px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: var(--input-bg);
            color: var(--text);
            font-size: 13px;
            outline: none;
            font-family: inherit;
            transition: all var(--transition);
        }

        .filter-bar input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(96,165,250,0.15);
            background: var(--input-focus-bg);
        }

        .filter-bar select {
            padding: 8px 32px 8px 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: var(--input-bg);
            color: var(--text);
            font-size: 13px;
            outline: none;
            font-family: inherit;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394A3B8' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            transition: all var(--transition);
        }

        .filter-bar select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(96,165,250,0.15);
        }

        .btn-reset {
            padding: 8px 14px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: transparent;
            color: var(--text-muted);
            font-size: 13px; font-weight: 500;
            cursor: pointer; display: inline-flex; align-items: center; gap: 6px;
            text-decoration: none;
            transition: all var(--transition);
            font-family: inherit;
        }
        .btn-reset:hover { background: var(--bg); color: var(--text); border-color: var(--primary); }

        /* ═══════════════════════ ALERTS ═══════════════════════ */
        .alert { border-radius: 10px !important; font-size: 13px; padding: 11px 16px !important; }
        .alert-success {
            background: rgba(74,222,128,0.1) !important;
            border: 1px solid rgba(74,222,128,0.25) !important;
            color: var(--success) !important;
        }
        .alert-danger {
            background: rgba(248,113,113,0.1) !important;
            border: 1px solid rgba(248,113,113,0.25) !important;
            color: var(--danger) !important;
        }
        .btn-close { filter: var(--bs-btn-close-filter, none); }
        [data-theme="dark"] .btn-close { filter: invert(1) grayscale(100%) brightness(200%); }

        /* ═══════════════════════ EMPTY STATE ═══════════════════════ */
        .empty-state { text-align: center; padding: 48px 24px; color: var(--text-muted); }
        .empty-state-icon {
            width: 64px; height: 64px;
            background: var(--bg);
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 28px; color: var(--text-muted);
            margin: 0 auto 16px;
            border: 1px solid var(--border);
        }
        .empty-state h5 { font-size: 15px; font-weight: 700; color: var(--text); margin-bottom: 6px; }
        .empty-state p  { font-size: 13px; }

        /* ═══════════════════════ PAGINATION ═══════════════════════ */
        .pagination .page-link {
            border-radius: 7px !important;
            font-size: 13px;
            color: var(--text-muted);
            border-color: var(--border);
            background: var(--card-bg);
            margin: 0 2px;
            transition: all var(--transition);
        }
        .pagination .page-link:hover { color: var(--primary); border-color: var(--primary); background: rgba(96,165,250,0.08); }
        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #2563EB, #60A5FA) !important;
            border-color: transparent !important;
            color: #fff !important;
        }

        /* ═══════════════════════ FORM STYLED ═══════════════════════ */
        .form-styled label {
            font-size: 12px; font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase; letter-spacing: 0.3px;
            margin-bottom: 5px; display: block;
        }
        .form-styled .form-control,
        .form-styled .form-select {
            background: var(--input-bg);
            border: 1.5px solid var(--border);
            color: var(--text);
            border-radius: 9px;
            padding: 10px 13px;
            font-size: 14px; font-family: inherit;
            transition: all 0.2s; width: 100%; resize: vertical;
        }
        .form-styled .form-control:focus,
        .form-styled .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(96,165,250,0.15);
            background: var(--input-focus-bg); outline: none;
        }
        .form-styled .form-control::placeholder { color: var(--text-muted); opacity: 0.6; }
        .form-styled .is-invalid { border-color: var(--danger) !important; }
        .form-styled .invalid-feedback { font-size: 12px; color: var(--danger); margin-top: 4px; display: block; }

        /* ═══════════════════════ RESPONSIVE ═══════════════════════ */
        @media (max-width: 991px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .sidebar-close-btn { display: block; }
            .top-navbar { left: 0; }
            .hamburger-btn { display: flex; }
            main { margin-left: 0; padding: 20px 16px; }
            .notif-panel {
                position: fixed;
                top: var(--navbar-h);
                left: 0; right: 0;
                width: 100%; max-width: 100%;
                border-radius: 0 0 var(--radius) var(--radius);
            }
            .notif-backdrop {
                display: block; position: fixed; inset: 0;
                background: rgba(0,0,0,0.3);
                z-index: 1099; backdrop-filter: blur(2px);
            }
        }

        @media (max-width: 576px) {
            main { padding: 16px 12px; }
            .top-navbar { padding: 0 14px; gap: 8px; }
            .search-bar { display: none; }
            .user-name { display: none; }
        }

        @yield('page-styles')
    </style>

    @yield('styles')
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<!-- ═══ SIDEBAR ═══ -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('dashboard') }}" class="sidebar-brand">
            <div class="brand-icon"><i class="bi bi-mortarboard-fill"></i></div>
            <span class="brand-name">PengingatKuliah</span>
        </a>
        <button class="sidebar-close-btn" onclick="closeSidebar()">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <div class="sidebar-body">
        <div class="nav-section-label">Menu Utama</div>
        <nav class="sidebar-nav">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-grid-1x2"></i></span>
                Dashboard
            </a>
            <a href="{{ route('jadwal.index') }}" class="{{ request()->routeIs('jadwal.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-calendar-week"></i></span>
                Jadwal Kuliah
            </a>
            <a href="{{ route('tugas.index') }}" class="{{ request()->routeIs('tugas.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-journal-check"></i></span>
                Tugas
            </a>
            <a href="{{ route('catatan.index') }}" class="{{ request()->routeIs('catatan.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-sticky"></i></span>
                Catatan
            </a>
            <a href="{{ route('reminder.index') }}" class="{{ request()->routeIs('reminder.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-bell"></i></span>
                Reminder
            </a>
            <a href="{{ route('calendar.index') }}" class="{{ request()->routeIs('calendar.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-calendar3"></i></span>
                Kalender
            </a>
        </nav>

        <div class="nav-section-label">Akun</div>
        <nav class="sidebar-nav">
            <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-person-circle"></i></span>
                Profil Saya
            </a>
        </nav>
    </div>

    <div class="sidebar-footer">
        <div class="motivasi-card">
            <h6>Tetap Semangat!</h6>
            <p>Sedikit kemajuan setiap hari berarti banyak di akhir semester.</p>
            <button class="btn-mo" onclick="newMotivasi(this)">Motivasi Lain</button>
        </div>
    </div>
</aside>

<!-- ═══ TOP NAVBAR ═══ -->
<nav class="top-navbar">
    <button class="hamburger-btn" onclick="openSidebar()">
        <i class="bi bi-list"></i>
    </button>

    <span class="navbar-page-title d-none d-md-block">@yield('title', 'Dashboard')</span>

    <div class="search-wrapper search-bar">
        <i class="bi bi-search"></i>
        <input type="text" placeholder="Cari jadwal, tugas, catatan...">
    </div>

    <div class="navbar-actions">
        <div class="notif-wrapper" id="notifWrapper">
            <button class="icon-btn" id="notifToggle" title="Notifikasi">
                <i class="bi bi-bell"></i>
                <span class="notif-badge" id="notifBadge">0</span>
            </button>
            <div class="notif-panel" id="notifPanel">
                <div class="notif-header">
                    <h6>Notifikasi Akademik</h6>
                    <span class="notif-count-label" id="notifCountLabel">0 notifikasi</span>
                </div>
                <div class="notif-body" id="notifBody">
                    <div class="notif-loading">
                        <div class="spinner-border spinner-border-sm text-primary mb-2"></div>
                        <div>Memuat notifikasi...</div>
                    </div>
                </div>
                <div class="notif-footer">
                    <a href="{{ route('dashboard') }}" id="notifSeeAll">Lihat Semua</a>
                </div>
            </div>
        </div>

        {{-- Theme toggle --}}
        <button class="theme-toggle" id="themeToggle" title="Ganti tema" onclick="toggleTheme()">
            <i class="bi bi-moon-fill" id="themeIcon"></i>
        </button>

        <a href="{{ route('profile.edit') }}" class="user-chip">
            <div class="user-avatar">
                {{ strtoupper(substr(auth()->user()->nama ?? 'U', 0, 2)) }}
            </div>
            <span class="user-name">{{ auth()->user()->nama ?? 'User' }}</span>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="icon-btn" title="Keluar">
                <i class="bi bi-box-arrow-right"></i>
            </button>
        </form>
    </div>
</nav>

<!-- ═══ MAIN CONTENT ═══ -->
<main>
    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    /* ── Sidebar ── */
    function openSidebar() {
        document.getElementById('sidebar').classList.add('open');
        document.getElementById('sidebarOverlay').classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('sidebarOverlay').classList.remove('active');
        document.body.style.overflow = '';
    }

    /* ── Theme toggle ── */
    function applyTheme(theme) {
        document.documentElement.setAttribute('data-theme', theme);
        localStorage.setItem('pk-theme', theme);
        const icon = document.getElementById('themeIcon');
        if (icon) {
            icon.className = theme === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
        }
    }

    function toggleTheme() {
        const current = document.documentElement.getAttribute('data-theme') || 'light';
        applyTheme(current === 'dark' ? 'light' : 'dark');
    }

    /* Set correct icon on load */
    (function() {
        const t = document.documentElement.getAttribute('data-theme') || 'light';
        const icon = document.getElementById('themeIcon');
        if (icon) icon.className = t === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
    })();

    /* ── Motivasi ── */
    const quotes = [
        'Sedikit kemajuan setiap hari berarti banyak di akhir semester.',
        'Belajar bukan tentang sempurna, tapi tentang konsisten.',
        'Tugas hari ini, prestasi hari esok.',
        'Fokus pada prosesnya, hasil akan mengikuti.',
        'Setiap catatan kecil adalah langkah besar.',
        'Mulai sekarang, sempurnakan nanti.',
    ];
    function newMotivasi(btn) {
        const p = btn.closest('.motivasi-card').querySelector('p');
        const others = quotes.filter(q => q !== p.textContent);
        p.textContent = others[Math.floor(Math.random() * others.length)];
    }

    /* ── Notification System ── */
    (function() {
        const toggle   = document.getElementById('notifToggle');
        const panel    = document.getElementById('notifPanel');
        const body     = document.getElementById('notifBody');
        const badge    = document.getElementById('notifBadge');
        const cLabel   = document.getElementById('notifCountLabel');
        const wrapper  = document.getElementById('notifWrapper');
        const apiUrl   = '{{ route("notifications.index") }}';
        let open = false;
        let backdrop = null;

        function togglePanel() {
            open = !open;
            panel.classList.toggle('open', open);
            if (open) {
                loadNotifs();
                if (window.innerWidth <= 991) {
                    backdrop = document.createElement('div');
                    backdrop.className = 'notif-backdrop';
                    backdrop.onclick = togglePanel;
                    document.body.appendChild(backdrop);
                }
            } else {
                if (backdrop) { backdrop.remove(); backdrop = null; }
            }
        }

        toggle.addEventListener('click', function(e) { e.stopPropagation(); togglePanel(); });

        document.addEventListener('click', function(e) {
            if (open && !wrapper.contains(e.target)) {
                open = false;
                panel.classList.remove('open');
                if (backdrop) { backdrop.remove(); backdrop = null; }
            }
        });

        function loadNotifs() {
            body.innerHTML = '<div class="notif-loading"><div class="spinner-border spinner-border-sm text-primary mb-2"></div><div>Memuat notifikasi...</div></div>';
            fetch(apiUrl)
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    updateBadge(data.count);
                    renderNotifs(data.notifications);
                })
                .catch(function() {
                    body.innerHTML = '<div class="notif-empty"><i class="bi bi-exclamation-triangle"></i><p>Gagal memuat notifikasi.</p></div>';
                });
        }

        function updateBadge(count) {
            badge.textContent = count > 99 ? '99+' : count;
            badge.classList.toggle('show', count > 0);
            cLabel.textContent = count + ' notifikasi';
        }

        function renderNotifs(items) {
            if (!items || !items.length) {
                body.innerHTML = '<div class="notif-empty"><i class="bi bi-bell-slash"></i><p>Tidak ada notifikasi saat ini.</p></div>';
                return;
            }
            body.innerHTML = items.map(function(n) {
                return '<a href="' + n.url + '" class="notif-item" data-p="' + n.priority + '" data-type="' + n.type + '">' +
                    '<div class="notif-icon-wrap" style="background:' + n.color + '18;color:' + n.color + '">' +
                        '<i class="bi ' + n.icon + '"></i>' +
                    '</div>' +
                    '<div class="notif-item-body">' +
                        '<div class="notif-item-label" style="color:' + n.color + '">' + n.label + '</div>' +
                        '<div class="notif-item-title">' + n.title + '</div>' +
                        '<div class="notif-item-time">' + n.time_ago + '</div>' +
                    '</div>' +
                '</a>';
            }).join('');
        }

        /* Load badge count on page load */
        fetch(apiUrl)
            .then(function(r) { return r.json(); })
            .then(function(data) { updateBadge(data.count); })
            .catch(function() {});
    })();
</script>

@yield('scripts')
</body>
</html>
