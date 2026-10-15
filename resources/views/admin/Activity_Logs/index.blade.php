<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Aktivitas - SIKUTA BKAD Kabupaten Tapin</title>

    {{-- Fonts & Icons --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --color-primary-dark: #103F3C;
            --color-primary-active: #17534E;
            --color-primary: #078577;
            --color-primary-hover: #066b60;
            --color-primary-light: #E0F5EF;
            --color-bg: #F3F7F6;
            --color-surface: #FFFFFF;
            --color-text: #183532;
            --color-text-secondary: #718784;
            --color-border: #D8E4E1;
            --color-danger: #DC2626;
            --color-danger-light: #FEE2E2;
            --color-warning: #D97706;
            --color-warning-light: #FEF3C7;
            --color-success: #166534;
            --color-success-light: #DCFCE7;
            --color-info: #1E40AF;
            --color-info-light: #DBEAFE;
            --color-purple: #6B21A8;
            --color-purple-light: #F0E8FB;
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 14px;
            --radius-xl: 18px;
            --shadow-sm: 0 1px 3px rgba(16, 63, 60, 0.05);
            --shadow-md: 0 4px 14px rgba(16, 63, 60, 0.08);
            --font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            --sidebar-width: 266px;
            --topbar-height: 70px;
        }

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--font-family);
            background: var(--color-bg);
            color: var(--color-text);
            min-height: 100vh;
            display: flex;
            -webkit-font-smoothing: antialiased;
        }

        a { text-decoration: none; color: inherit; }

        /* SIDEBAR */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--color-primary-dark);
            color: #ffffff;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            padding: 24px 18px;
            z-index: 100;
            display: flex;
            flex-direction: column;
            transition: transform 0.25s ease;
            overflow-y: auto;
        }

        .brand-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-bottom: 22px;
            margin-bottom: 22px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
        }

        .brand-logo {
            width: 44px;
            height: 44px;
            background: #ffffff;
            color: var(--color-primary-dark);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 800;
            flex-shrink: 0;
        }

        .brand-title {
            font-size: 19px;
            font-weight: 800;
            letter-spacing: 0.5px;
            line-height: 1.1;
        }

        .brand-sub {
            font-size: 10px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.7);
            letter-spacing: 0.3px;
            margin-top: 3px;
        }

        .menu-list {
            display: flex;
            flex-direction: column;
            gap: 6px;
            flex: 1;
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: var(--radius-md);
            color: rgba(255, 255, 255, 0.85);
            font-size: 13px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .menu-link i {
            width: 20px;
            text-align: center;
            font-size: 15px;
        }

        .menu-link:hover, .menu-link.active {
            background: var(--color-primary-active);
            color: #ffffff;
        }

        .menu-link.active {
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .sidebar-footer {
            margin-top: auto;
            padding-top: 18px;
            border-top: 1px solid rgba(255, 255, 255, 0.12);
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
            padding: 8px 10px;
            background: rgba(255, 255, 255, 0.06);
            border-radius: var(--radius-md);
        }

        .sidebar-user-avatar {
            width: 34px;
            height: 34px;
            background: var(--color-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        .sidebar-user-name {
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-user-role {
            font-size: 10px;
            color: rgba(255, 255, 255, 0.65);
        }

        .btn-sidebar-logout {
            width: 100%;
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #ffffff;
            padding: 9px;
            border-radius: var(--radius-sm);
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-sidebar-logout:hover {
            background: rgba(220, 38, 38, 0.25);
            border-color: #ef4444;
            color: #fca5a5;
        }

        /* MAIN WRAPPER */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* TOPBAR */
        .topbar {
            height: var(--topbar-height);
            background: var(--color-surface);
            border-bottom: 1px solid var(--color-border);
            padding: 0 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 40;
            box-shadow: 0 2px 8px rgba(16, 63, 60, 0.04);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .btn-menu-mobile {
            display: none;
            background: transparent;
            border: 1px solid var(--color-border);
            border-radius: var(--radius-sm);
            width: 38px;
            height: 38px;
            color: var(--color-text);
            font-size: 18px;
            cursor: pointer;
            align-items: center;
            justify-content: center;
        }

        .topbar-title h1 {
            font-size: 18px;
            font-weight: 800;
            color: var(--color-text);
        }

        .topbar-title p {
            font-size: 12px;
            color: var(--color-text-secondary);
        }

        .topbar-badge {
            background: var(--color-primary-light);
            color: var(--color-primary);
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .live-indicator {
            display: inline-block;
            width: 8px;
            height: 8px;
            background-color: #10b981;
            border-radius: 50%;
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            animation: pulse-green 2s infinite;
        }

        @keyframes pulse-green {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            }
            70% {
                transform: scale(1);
                box-shadow: 0 0 0 6px rgba(16, 185, 129, 0);
            }
            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
            }
        }

        /* CONTENT */
        .content {
            padding: 28px 32px 60px;
            flex: 1;
            max-width: 1400px;
            width: 100%;
            margin: 0 auto;
        }

        /* HEADER BANNER */
        .page-banner {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-left: 4px solid var(--color-primary);
            border-radius: var(--radius-xl);
            padding: 20px 24px;
            margin-bottom: 24px;
            box-shadow: var(--shadow-sm);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .page-banner-info h2 {
            font-size: 19px;
            font-weight: 800;
            color: var(--color-primary-dark);
            margin-bottom: 4px;
        }

        .page-banner-info p {
            font-size: 13px;
            color: var(--color-text-secondary);
            line-height: 1.5;
        }

        .page-banner-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--color-bg);
            border: 1px solid var(--color-border);
            padding: 8px 14px;
            border-radius: var(--radius-md);
            font-size: 12px;
            font-weight: 600;
            color: var(--color-text);
            white-space: nowrap;
        }

        /* FILTER CARD */
        .card-filter {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            padding: 22px 24px;
            margin-bottom: 24px;
            box-shadow: var(--shadow-sm);
        }

        .filter-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--color-border);
        }

        .filter-header h3 {
            font-size: 15px;
            font-weight: 700;
            color: var(--color-primary-dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filter-header span {
            font-size: 12px;
            color: var(--color-text-secondary);
        }

        .filter-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr 1fr auto;
            gap: 14px;
            align-items: flex-end;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-group label {
            font-size: 12px;
            font-weight: 700;
            color: var(--color-text);
        }

        .form-control {
            width: 100%;
            height: 40px;
            padding: 0 12px;
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
            background: #ffffff;
            font-size: 13px;
            color: var(--color-text);
            font-family: inherit;
            transition: all 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(7, 133, 119, 0.15);
        }

        .filter-actions {
            display: flex;
            gap: 8px;
        }

        /* BUTTONS */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            height: 40px;
            padding: 0 16px;
            border-radius: var(--radius-md);
            font-size: 12px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            white-space: nowrap;
            text-decoration: none;
        }

        .btn-primary {
            background: var(--color-primary);
            color: #ffffff;
            box-shadow: 0 2px 6px rgba(7, 133, 119, 0.2);
        }

        .btn-primary:hover {
            background: var(--color-primary-hover);
        }

        .btn-secondary {
            background: #ffffff;
            color: var(--color-text);
            border: 1px solid var(--color-border);
        }

        .btn-secondary:hover {
            background: #f1f5f4;
            border-color: #cbdad7;
        }

        /* CARD TABLE */
        .card-table {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .table-header {
            padding: 18px 24px;
            background: #fafcfb;
            border-bottom: 1px solid var(--color-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .table-header-title {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .table-header-title h3 {
            font-size: 15px;
            font-weight: 700;
            color: var(--color-primary-dark);
        }

        .badge-count {
            background: var(--color-primary-light);
            color: var(--color-primary);
            padding: 3px 9px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 980px;
            border-collapse: collapse;
            text-align: left;
        }

        th {
            background: #f8faf9;
            color: var(--color-text-secondary);
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 13px 18px;
            border-bottom: 1px solid var(--color-border);
            white-space: nowrap;
        }

        td {
            padding: 13px 18px;
            font-size: 13px;
            color: var(--color-text);
            border-bottom: 1px solid #edf2f0;
            vertical-align: middle;
        }

        tr:hover td {
            background: #fbfdfc;
        }

        /* BADGES & TYPOGRAPHY */
        .user-block {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .user-name {
            font-weight: 700;
            color: var(--color-primary-dark);
        }

        .user-meta {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            color: var(--color-text-secondary);
        }

        .user-role-badge {
            display: inline-block;
            padding: 1px 7px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 700;
            text-transform: capitalize;
            background: #e2e8f0;
            color: #334155;
        }

        .user-role-admin { background: #ede9fe; color: #5b21b6; }
        .user-role-petugas { background: #e0f2fe; color: #0369a1; }
        .user-role-penerima { background: #dcfce7; color: #15803d; }
        .user-role-pimpinan { background: #fef3c7; color: #92400e; }

        .activity-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .activity-login { background: #e0f2fe; color: #0284c7; }
        .activity-logout { background: #f1f5f9; color: #475569; }
        .activity-kunjungan { background: #dcfce7; color: #166534; }
        .activity-terima { background: #fef3c7; color: #b45309; }
        .activity-selesai { background: #d1fae5; color: #065f46; }
        .activity-alihkan { background: #f3e8ff; color: #7e22ce; }
        .activity-akun { background: #ede9fe; color: #6d28d9; }
        .activity-bidang { background: #ccfbf1; color: #0f766e; }
        .activity-danger { background: #fee2e2; color: #b91c1c; }
        .activity-default { background: #f1f5f9; color: #334155; }

        .ip-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #f1f5f4;
            color: var(--color-text);
            font-family: monospace;
            font-size: 11px;
            padding: 3px 8px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--color-border);
            white-space: nowrap;
        }

        .empty-state {
            text-align: center;
            padding: 48px 20px;
            color: var(--color-text-secondary);
        }

        .empty-state i {
            font-size: 38px;
            color: #cbd5e1;
            margin-bottom: 12px;
        }

        .empty-state p {
            font-size: 13px;
            margin-bottom: 4px;
            font-weight: 600;
        }

        .empty-state span {
            font-size: 12px;
            color: #94a3b8;
        }

        /* PAGINATION */
        .pagination-wrapper {
            padding: 16px 24px;
            border-top: 1px solid var(--color-border);
            background: #fafcfb;
            display: flex;
            justify-content: flex-end;
        }

        /* FOOTER */
        .footer {
            margin-top: auto;
            border-top: 1px solid var(--color-border);
            background: var(--color-surface);
            padding: 18px 32px;
            text-align: center;
            font-size: 12px;
            color: var(--color-text-secondary);
        }

        @media (max-width: 1200px) {
            .filter-grid {
                grid-template-columns: repeat(3, 1fr);
            }
            .filter-actions {
                grid-column: span 3;
                justify-content: flex-end;
            }
        }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
            .btn-menu-mobile { display: flex; }
            .topbar { padding: 0 16px; }
            .content { padding: 20px 16px; }
            .page-banner { flex-direction: column; align-items: flex-start; }
            .filter-grid { grid-template-columns: 1fr; }
            .filter-actions { grid-column: span 1; flex-direction: column; }
            .filter-actions .btn { width: 100%; }
        }

        @media (prefers-reduced-motion: reduce) {
            * { transition: none !important; animation: none !important; transform: none !important; }
        }
    </style>
</head>
<body>

    {{-- SIDEBAR --}}
    <aside class="sidebar" id="sidebar">
        <div class="brand-header">
            <div class="brand-logo"><img src="{{ asset('images/logo.jpg') }}" alt="Logo BKAD Kabupaten Tapin" style="width:100%;height:100%;object-fit:contain;border-radius:var(--radius-md);"></div>
            <div>
                <div class="brand-title">SIKUTA</div>
                <div class="brand-sub">BKAD KABUPATEN TAPIN</div>
            </div>
        </div>

        <nav class="menu-list">
            <a href="{{ route('admin.dashboard') }}" class="menu-link">
                <i class="fa-solid fa-gauge-high"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.users.index') }}" class="menu-link">
                <i class="fa-solid fa-users"></i>
                <span>Kelola Akun</span>
            </a>

            <a href="{{ route('admin.bidangs.index') }}" class="menu-link">
                <i class="fa-solid fa-building"></i>
                <span>Master Bidang</span>
            </a>

            <a href="{{ route('admin.kunjungan.index') }}" class="menu-link">
                <i class="fa-solid fa-clipboard-list"></i>
                <span>Data Kunjungan</span>
            </a>

            <a href="{{ route('admin.laporan.index') }}" class="menu-link">
                <i class="fa-solid fa-chart-bar"></i>
                <span>Laporan &amp; Rekap</span>
            </a>

            <a href="{{ route('admin.activity_logs.index') }}" class="menu-link active">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <span>Log Aktivitas</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="sidebar-user-avatar">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
                <div>
                    <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
                    <div class="sidebar-user-role">Administrator</div>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-sidebar-logout">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    <span>Keluar Sistem</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN WRAPPER --}}
    <div class="main-wrapper">

        {{-- TOPBAR --}}
        <header class="topbar">
            <div class="topbar-left">
                <button type="button" class="btn-menu-mobile" id="mobileMenuToggle" aria-label="Menu navigasi">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div class="topbar-title">
                    <h1>Log Aktivitas</h1>
                    <p>Riwayat aktivitas pengguna dalam sistem SIKUTA</p>
                </div>
            </div>

            <div class="topbar-badge">
                <span class="live-indicator"></span>
                <span>Audit Trail Sistem</span>
            </div>
        </header>

        {{-- CONTENT --}}
        <main class="content">


            {{-- Filter Card --}}
            <div class="card-filter">
                <div class="filter-header">
                    <h3>
                        <i class="fa-solid fa-filter"></i>
                        <span>Filter Log Aktivitas</span>
                    </h3>
                    <span>Saring riwayat berdasarkan pengguna, aktivitas, atau rentang tanggal</span>
                </div>

                <form method="GET" action="{{ route('admin.activity_logs.index') }}">
                    <div class="filter-grid">
                        <div class="form-group">
                            <label for="q">Pencarian</label>
                            <input
                                type="text"
                                id="q"
                                name="q"
                                class="form-control"
                                value="{{ request('q') }}"
                                placeholder="Aktivitas, keterangan, nama, NIP..."
                            >
                        </div>

                        <div class="form-group">
                            <label for="user_id">Pengguna</label>
                            <select id="user_id" name="user_id" class="form-control">
                                <option value="">Semua Pengguna</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" @selected(request('user_id') == $user->id)>
                                        {{ $user->name }} ({{ ucfirst(str_replace('_', ' ', $user->role)) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="aktivitas">Jenis Aktivitas</label>
                            <select id="aktivitas" name="aktivitas" class="form-control">
                                <option value="">Semua Aktivitas</option>
                                @foreach ($aktivitas as $item)
                                    <option value="{{ $item }}" @selected(request('aktivitas') == $item)>
                                        {{ $item }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="tanggal_mulai">Tanggal Mulai</label>
                            <input
                                type="date"
                                id="tanggal_mulai"
                                name="tanggal_mulai"
                                class="form-control"
                                value="{{ request('tanggal_mulai') }}"
                            >
                        </div>

                        <div class="form-group">
                            <label for="tanggal_akhir">Tanggal Akhir</label>
                            <input
                                type="date"
                                id="tanggal_akhir"
                                name="tanggal_akhir"
                                class="form-control"
                                value="{{ request('tanggal_akhir') }}"
                            >
                        </div>

                        <div class="filter-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                <span>Filter</span>
                            </button>

                            <a href="{{ route('admin.activity_logs.index') }}" class="btn btn-secondary">
                                <i class="fa-solid fa-rotate-left"></i>
                                <span>Reset</span>
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Activity Logs Table --}}
            <div class="card-table">
                <div class="table-header">
                    <div class="table-header-title">
                        <h3>
                            <i class="fa-solid fa-list-check"></i>
                            <span>Daftar Riwayat Aktivitas</span>
                        </h3>
                        <span class="badge-count">{{ number_format($logs->total()) }} Log Terdata</span>
                    </div>
                </div>

                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 60px; text-align: center;">No</th>
                                <th style="width: 170px;">Waktu Kejadian</th>
                                <th style="width: 220px;">Pengguna &amp; Role</th>
                                <th style="width: 200px;">Jenis Aktivitas</th>
                                <th>Keterangan / Deskripsi</th>
                                <th style="width: 150px;">IP Address</th>
                            </tr>
                        </thead>
                        <tbody id="activityLogBody">
                            @forelse ($logs as $index => $log)
                                @php
                                    $actLower = strtolower($log->aktivitas ?? '');
                                    $actClass = 'activity-default';
                                    $actIcon = 'fa-solid fa-circle-dot';

                                    if (str_contains($actLower, 'login')) {
                                        $actClass = 'activity-login';
                                        $actIcon = 'fa-solid fa-right-to-bracket';
                                    } elseif (str_contains($actLower, 'logout')) {
                                        $actClass = 'activity-logout';
                                        $actIcon = 'fa-solid fa-right-from-bracket';
                                    } elseif (str_contains($actLower, 'tambah kunjungan')) {
                                        $actClass = 'activity-kunjungan';
                                        $actIcon = 'fa-solid fa-user-plus';
                                    } elseif (str_contains($actLower, 'terima')) {
                                        $actClass = 'activity-terima';
                                        $actIcon = 'fa-solid fa-clock';
                                    } elseif (str_contains($actLower, 'selesai')) {
                                        $actClass = 'activity-selesai';
                                        $actIcon = 'fa-solid fa-circle-check';
                                    } elseif (str_contains($actLower, 'alih')) {
                                        $actClass = 'activity-alihkan';
                                        $actIcon = 'fa-solid fa-shuffle';
                                    } elseif (str_contains($actLower, 'akun')) {
                                        $actClass = 'activity-akun';
                                        $actIcon = 'fa-solid fa-user-gear';
                                    } elseif (str_contains($actLower, 'bidang')) {
                                        $actClass = 'activity-bidang';
                                        $actIcon = 'fa-solid fa-building';
                                    } elseif (str_contains($actLower, 'nonaktif') || str_contains($actLower, 'hapus')) {
                                        $actClass = 'activity-danger';
                                        $actIcon = 'fa-solid fa-triangle-exclamation';
                                    }

                                    $userRole = $log->user?->role ?? '';
                                    $roleBadgeClass = 'user-role-admin';
                                    if ($userRole === 'petugas_piket') {
                                        $roleBadgeClass = 'user-role-petugas';
                                    } elseif ($userRole === 'penerima_bidang') {
                                        $roleBadgeClass = 'user-role-penerima';
                                    } elseif ($userRole === 'pimpinan') {
                                        $roleBadgeClass = 'user-role-pimpinan';
                                    }
                                @endphp
                                <tr>
                                    <td style="text-align: center; color: var(--color-text-secondary); font-weight: 600;">
                                        {{ $logs->firstItem() + $index }}
                                    </td>
                                    <td>
                                        <div style="font-weight: 700;">
                                            {{ $log->created_at ? $log->created_at->timezone('Asia/Makassar')->format('d/m/Y') : '-' }}
                                        </div>
                                        <div style="font-size: 11px; color: var(--color-text-secondary); margin-top: 2px;">
                                            <i class="fa-regular fa-clock"></i>
                                            {{ $log->created_at ? $log->created_at->timezone('Asia/Makassar')->format('H:i:s') . ' WITA' : '-' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="user-block">
                                            @if ($log->user)
                                                <span class="user-name">{{ $log->user->name }}</span>
                                                <div class="user-meta">
                                                    <span class="user-role-badge {{ $roleBadgeClass }}">
                                                        {{ str_replace('_', ' ', $log->user->role) }}
                                                    </span>
                                                    <span>NIP: {{ $log->user->nip ?: '-' }}</span>
                                                </div>
                                            @else
                                                <span class="user-name">Sistem</span>
                                                <div class="user-meta">
                                                    <span class="user-role-badge">Automated</span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="activity-badge {{ $actClass }}">
                                            <i class="{{ $actIcon }}"></i>
                                            <span>{{ $log->aktivitas }}</span>
                                        </span>
                                    </td>
                                    <td>
                                        <div style="line-height: 1.45;">
                                            {{ $log->keterangan ?? '-' }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="ip-badge">
                                            <i class="fa-solid fa-network-wired"></i>
                                            <span>{{ $log->ip_address ?? '-' }}</span>
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="empty-state">
                                        <i class="fa-regular fa-folder-open"></i>
                                        <p>Belum ada aktivitas yang tercatat</p>
                                        <span>Log riwayat tindakan pengguna sistem akan otomatis ditampilkan di sini.</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($logs->hasPages())
                    <div class="pagination-wrapper">
                        {{ $logs->links() }}
                    </div>
                @endif
            </div>

        </main>

        {{-- FOOTER --}}
        <footer class="footer">
            <div>&copy; {{ date('Y') }} BKAD Kabupaten Tapin &bull; SIKUTA (Sistem Informasi Kunjungan Tamu)</div>
        </footer>

    </div>

    {{-- Realtime Auto-refresh & Helpers --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Mobile Sidebar Toggle
            const mobileMenuToggle = document.getElementById('mobileMenuToggle');
            const sidebar = document.getElementById('sidebar');

            if (mobileMenuToggle && sidebar) {
                mobileMenuToggle.addEventListener('click', function () {
                    sidebar.classList.toggle('open');
                });

                document.addEventListener('click', function (e) {
                    if (window.innerWidth <= 768 && sidebar.classList.contains('open')) {
                        if (!sidebar.contains(e.target) && !mobileMenuToggle.contains(e.target)) {
                            sidebar.classList.remove('open');
                        }
                    }
                });
            }

            // Realtime Auto-refresh Activity Logs
            const logBody = document.getElementById('activityLogBody');
            if (!logBody) return;

            // Only run live auto-refresh when on first page (no ?page=2 etc)
            const urlParams = new URLSearchParams(window.location.search);
            const currentPage = urlParams.get('page');
            if (currentPage && currentPage !== '1') {
                return;
            }

            function getActivityConfig(activity) {
                const act = (activity || '').toLowerCase();
                if (act.includes('login')) return { class: 'activity-login', icon: 'fa-solid fa-right-to-bracket' };
                if (act.includes('logout')) return { class: 'activity-logout', icon: 'fa-solid fa-right-from-bracket' };
                if (act.includes('tambah kunjungan')) return { class: 'activity-kunjungan', icon: 'fa-solid fa-user-plus' };
                if (act.includes('terima')) return { class: 'activity-terima', icon: 'fa-solid fa-clock' };
                if (act.includes('selesai')) return { class: 'activity-selesai', icon: 'fa-solid fa-circle-check' };
                if (act.includes('alih')) return { class: 'activity-alihkan', icon: 'fa-solid fa-shuffle' };
                if (act.includes('akun')) return { class: 'activity-akun', icon: 'fa-solid fa-user-gear' };
                if (act.includes('bidang')) return { class: 'activity-bidang', icon: 'fa-solid fa-building' };
                if (act.includes('nonaktif') || act.includes('hapus')) return { class: 'activity-danger', icon: 'fa-solid fa-triangle-exclamation' };
                return { class: 'activity-default', icon: 'fa-solid fa-circle-dot' };
            }

            function getRoleBadgeClass(role) {
                if (role === 'petugas_piket') return 'user-role-petugas';
                if (role === 'penerima_bidang') return 'user-role-penerima';
                if (role === 'pimpinan') return 'user-role-pimpinan';
                return 'user-role-admin';
            }

            async function refreshActivityLogs() {
                try {
                    const params = new URLSearchParams(window.location.search);
                    const response = await fetch("{{ route('admin.activity_logs.latest') }}?" + params.toString(), {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        cache: 'no-store'
                    });

                    if (!response.ok) throw new Error('HTTP ' + response.status);

                    const result = await response.json();
                    if (!result.success) throw new Error('Response error');

                    if (!result.data || result.data.length === 0) {
                        logBody.innerHTML = `
                            <tr>
                                <td colspan="6" class="empty-state">
                                    <i class="fa-regular fa-folder-open"></i>
                                    <p>Belum ada aktivitas yang tercatat</p>
                                    <span>Log riwayat tindakan pengguna sistem akan otomatis ditampilkan di sini.</span>
                                </td>
                            </tr>
                        `;
                        return;
                    }

                    let rowsHtml = '';
                    result.data.forEach((log, index) => {
                        const actConfig = getActivityConfig(log.aktivitas);
                        const roleClass = getRoleBadgeClass(log.role);
                        const roleLabel = log.role ? log.role.replace('_', ' ') : 'Sistem';

                        rowsHtml += `
                            <tr>
                                <td style="text-align: center; color: var(--color-text-secondary); font-weight: 600;">
                                    ${index + 1}
                                </td>
                                <td>
                                    <div style="font-weight: 700;">
                                        ${log.waktu ? log.waktu.split(' ')[0] : '-'}
                                    </div>
                                    <div style="font-size: 11px; color: var(--color-text-secondary); margin-top: 2px;">
                                        <i class="fa-regular fa-clock"></i>
                                        ${log.waktu && log.waktu.split(' ')[1] ? log.waktu.split(' ')[1] + ' WITA' : '-'}
                                    </div>
                                </td>
                                <td>
                                    <div class="user-block">
                                        <span class="user-name">${log.pengguna || 'Sistem'}</span>
                                        <div class="user-meta">
                                            <span class="user-role-badge ${roleClass}">${roleLabel}</span>
                                            <span>NIP: ${log.nip || '-'}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="activity-badge ${actConfig.class}">
                                        <i class="${actConfig.icon}"></i>
                                        <span>${log.aktivitas || '-'}</span>
                                    </span>
                                </td>
                                <td>
                                    <div style="line-height: 1.45;">
                                        ${log.keterangan || '-'}
                                    </div>
                                </td>
                                <td>
                                    <span class="ip-badge">
                                        <i class="fa-solid fa-network-wired"></i>
                                        <span>${log.ip_address || '-'}</span>
                                    </span>
                                </td>
                            </tr>
                        `;
                    });

                    logBody.innerHTML = rowsHtml;
                } catch (error) {
                    console.warn('Auto refresh activity logs skipped:', error);
                }
            }

            // Run interval refresh every 5 seconds
            setInterval(refreshActivityLogs, 5000);
        });
    </script>
</body>
</html>

