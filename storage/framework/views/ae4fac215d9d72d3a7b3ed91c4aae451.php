<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kepala Badan - SIKUTA BKAD Kabupaten Tapin</title>

    
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

        /* CONTENT */
        .content {
            padding: 28px 32px 60px;
            flex: 1;
            max-width: 1400px;
            width: 100%;
            margin: 0 auto;
        }

        /* HERO CARD */
        .hero-card {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-left: 4px solid var(--color-primary);
            border-radius: var(--radius-xl);
            padding: 22px 28px;
            margin-bottom: 24px;
            box-shadow: var(--shadow-sm);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .hero-info h2 {
            font-size: 20px;
            font-weight: 800;
            color: var(--color-primary-dark);
            margin-bottom: 5px;
        }

        .hero-info p {
            font-size: 13px;
            color: var(--color-text-secondary);
            line-height: 1.5;
        }

        .period-form {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--color-bg);
            border: 1px solid var(--color-border);
            padding: 6px 12px;
            border-radius: var(--radius-md);
        }

        .period-form label {
            font-size: 12px;
            font-weight: 700;
            color: var(--color-text-secondary);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .period-select {
            height: 36px;
            padding: 0 12px;
            border: 1px solid var(--color-border);
            border-radius: var(--radius-sm);
            background: #ffffff;
            font-size: 13px;
            font-weight: 600;
            color: var(--color-primary-dark);
            cursor: pointer;
            outline: none;
            font-family: inherit;
        }

        .period-select:focus {
            border-color: var(--color-primary);
        }

        /* STATS GRID */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            padding: 20px;
            box-shadow: var(--shadow-sm);
            display: flex;
            align-items: center;
            gap: 16px;
            transition: all 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            border-color: #cbdad7;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .stat-icon-total { background: var(--color-primary-light); color: var(--color-primary); }
        .stat-icon-menunggu { background: var(--color-warning-light); color: var(--color-warning); }
        .stat-icon-selesai { background: var(--color-success-light); color: var(--color-success); }
        .stat-icon-diterima { background: var(--color-info-light); color: var(--color-info); }

        .stat-content {
            flex: 1;
            min-width: 0;
        }

        .stat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--color-text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .stat-pill {
            font-size: 11px;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 999px;
        }

        .stat-pill-info { background: #e0f2fe; color: #0284c7; }
        .stat-pill-warn { background: #fef3c7; color: #b45309; }
        .stat-pill-success { background: #dcfce7; color: #166534; }

        .stat-value {
            font-size: 26px;
            font-weight: 800;
            color: var(--color-primary-dark);
            line-height: 1.1;
        }

        .stat-sub {
            font-size: 11px;
            color: var(--color-text-secondary);
            margin-top: 4px;
        }

        /* TWO-COLUMN GRID */
        .analytics-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 22px;
            margin-bottom: 24px;
        }

        .card-panel {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            padding: 22px 24px;
            box-shadow: var(--shadow-sm);
            display: flex;
            flex-direction: column;
        }

        .panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--color-border);
        }

        .panel-header h3 {
            font-size: 15px;
            font-weight: 700;
            color: var(--color-primary-dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .panel-header-note {
            font-size: 12px;
            color: var(--color-text-secondary);
        }

        /* BIDANG BARS */
        .bidang-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
            flex: 1;
        }

        .bidang-row {
            display: grid;
            grid-template-columns: 180px 1fr 60px;
            align-items: center;
            gap: 12px;
        }

        .bidang-name {
            font-size: 12px;
            font-weight: 600;
            color: var(--color-text);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .bar-bg {
            height: 14px;
            background: #eef4f2;
            border-radius: 999px;
            overflow: hidden;
        }

        .bar-fill {
            height: 100%;
            background: var(--color-primary);
            border-radius: 999px;
            transition: width 0.4s ease;
        }

        .bidang-number {
            text-align: right;
            font-size: 12px;
            font-weight: 800;
            color: var(--color-primary-dark);
        }

        .panel-insight {
            margin-top: 18px;
            padding: 10px 14px;
            background: var(--color-primary-light);
            border-radius: var(--radius-md);
            font-size: 12px;
            color: var(--color-primary-dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* TREND CHART */
        .trend-chart {
            height: 220px;
            display: flex;
            align-items: flex-end;
            gap: 12px;
            padding: 10px 0 0;
            flex: 1;
        }

        .trend-column {
            flex: 1;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            align-items: center;
        }

        .trend-value {
            font-size: 11px;
            font-weight: 700;
            color: var(--color-primary-dark);
            margin-bottom: 6px;
        }

        .trend-bar-wrap {
            width: 100%;
            max-width: 42px;
            height: 150px;
            display: flex;
            align-items: flex-end;
        }

        .trend-bar {
            width: 100%;
            min-height: 4px;
            border-radius: 6px 6px 0 0;
            background: #c3e5df;
            transition: height 0.4s ease;
        }

        .trend-bar.trend-bar-highest {
            background: var(--color-primary);
        }

        .trend-label {
            margin-top: 8px;
            font-size: 11px;
            font-weight: 600;
            color: var(--color-text-secondary);
        }

        .trend-day {
            font-size: 10px;
            color: var(--color-text-secondary);
            margin-top: 1px;
        }

        /* BOTTOM SECTION: ATTENTION & RECENT */
        .bottom-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 22px;
        }

        .attention-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 14px;
            background: #fffdf5;
            border: 1px solid #fed7aa;
            border-radius: var(--radius-md);
            margin-bottom: 10px;
        }

        .attention-item:last-child {
            margin-bottom: 0;
        }

        .attention-item-left {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .attention-name {
            font-size: 13px;
            font-weight: 700;
            color: var(--color-text);
        }

        .attention-bidang {
            font-size: 11px;
            color: var(--color-text-secondary);
        }

        .attention-badge {
            background: var(--color-warning-light);
            color: #b45309;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            white-space: nowrap;
        }

        /* RECENT LIST */
        .recent-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #edf2f0;
        }

        .recent-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .recent-info {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .recent-name {
            font-size: 13px;
            font-weight: 700;
            color: var(--color-text);
        }

        .recent-meta {
            font-size: 11px;
            color: var(--color-text-secondary);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* BADGES */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 8px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
        }

        .badge-baru { background: var(--color-warning-light); color: var(--color-warning); }
        .badge-diterima { background: var(--color-info-light); color: var(--color-info); }
        .badge-selesai { background: var(--color-success-light); color: var(--color-success); }
        .badge-default { background: #f1f5f9; color: #475569; }

        .empty-state {
            text-align: center;
            padding: 36px 16px;
            color: var(--color-text-secondary);
            font-size: 12px;
        }

        .empty-state i {
            font-size: 32px;
            color: #cbd5e1;
            margin-bottom: 10px;
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

        @media (max-width: 1100px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .analytics-grid { grid-template-columns: 1fr; }
            .bottom-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
            .btn-menu-mobile { display: flex; }
            .topbar { padding: 0 16px; }
            .content { padding: 20px 16px; }
            .hero-card { flex-direction: column; align-items: flex-start; }
            .period-form { width: 100%; justify-content: space-between; }
            .stats-grid { grid-template-columns: 1fr; }
            .bidang-row { grid-template-columns: 120px 1fr 50px; }
        }

        @media (prefers-reduced-motion: reduce) {
            * { transition: none !important; animation: none !important; transform: none !important; }
        }
    </style>
</head>
<body>

    
    <aside class="sidebar" id="sidebar">
        <div class="brand-header">
            <div class="brand-logo">
                <img src="<?php echo e(asset('images/logo.jpg')); ?>" alt="Logo BKAD Kabupaten Tapin" style="width: 100%; height: 100%; object-fit: contain; border-radius: var(--radius-md);">
            </div>
            <div>
                <div class="brand-title">SIKUTA</div>
                <div class="brand-sub">BKAD KABUPATEN TAPIN</div>
            </div>
        </div>

        <nav class="menu-list">
            <a href="<?php echo e(route('pimpinan.dashboard')); ?>" class="menu-link active">
                <i class="fa-solid fa-gauge-high"></i>
                <span>Dashboard Kepala Badan</span>
            </a>

            <a href="<?php echo e(route('pimpinan.laporan')); ?>" class="menu-link">
                <i class="fa-solid fa-chart-pie"></i>
                <span>Laporan Kunjungan Tamu</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="sidebar-user-avatar">
                    <i class="fa-solid fa-user-tie"></i>
                </div>
                <div>
                    <div class="sidebar-user-name"><?php echo e(auth()->user()->name); ?></div>
                    <div class="sidebar-user-role">Kepala Badan</div>
                </div>
            </div>

            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn-sidebar-logout">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    <span>Keluar Sistem</span>
                </button>
            </form>
        </div>
    </aside>

    
    <div class="main-wrapper">

        
        <header class="topbar">
            <div class="topbar-left">
                <button type="button" class="btn-menu-mobile" id="mobileMenuToggle" aria-label="Menu navigasi">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div class="topbar-title">
                    <h1>Dashboard Kepala Badan</h1>
                    <p>Ringkasan dan pemantauan kinerja pelayanan tamu BKAD Kabupaten Tapin</p>
                </div>
            </div>

            <div class="topbar-badge">
                <i class="fa-solid fa-crown"></i>
                <span>Mode Eksekutif</span>
            </div>
        </header>

        
        <main class="content">

            
            <div class="hero-card">
                <div class="hero-info">
                    <h2>Selamat datang, <?php echo e(auth()->user()->name); ?></h2>
                    <p>
                        Pantau kinerja pelayanan kunjungan dinas per
                        <strong><?php echo e($sekarang->locale('id')->isoFormat('dddd, D MMMM YYYY')); ?></strong>
                        pukul <strong><?php echo e($sekarang->format('H:i')); ?> WITA</strong>.
                    </p>
                </div>

                <div class="period-form">
                    <label for="periode">
                        <i class="fa-regular fa-calendar-check"></i>
                        <span>Periode:</span>
                    </label>
                    <form method="GET" action="<?php echo e(route('pimpinan.dashboard')); ?>" id="periodForm">
                        <select name="periode" id="periode" class="period-select" onchange="document.getElementById('periodForm').submit()">
                            <option value="hari_ini" <?php if($periode === 'hari_ini'): echo 'selected'; endif; ?>>Hari ini</option>
                            <option value="7_hari" <?php if($periode === '7_hari'): echo 'selected'; endif; ?>>7 hari terakhir</option>
                            <option value="30_hari" <?php if($periode === '30_hari'): echo 'selected'; endif; ?>>30 hari terakhir</option>
                            <option value="bulan_ini" <?php if($periode === 'bulan_ini'): echo 'selected'; endif; ?>>Bulan ini</option>
                            <option value="tahun_ini" <?php if($periode === 'tahun_ini'): echo 'selected'; endif; ?>>Tahun ini</option>
                        </select>
                    </form>
                </div>
            </div>

            
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon stat-icon-total">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-header">
                            <span class="stat-label">Total Tamu</span>
                            <span class="stat-pill stat-pill-info"><?php echo e($labelPeriode); ?></span>
                        </div>
                        <div class="stat-value"><?php echo e(number_format($totalKunjungan)); ?></div>
                        <div class="stat-sub">Tamu berkunjung</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon stat-icon-menunggu">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-header">
                            <span class="stat-label">Belum Diterima</span>
                            <span class="stat-pill stat-pill-warn">Perlu respon</span>
                        </div>
                        <div class="stat-value"><?php echo e(number_format($menunggu)); ?></div>
                        <div class="stat-sub">Menunggu konfirmasi bidang</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon stat-icon-diterima">
                        <i class="fa-solid fa-hourglass-half"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-header">
                            <span class="stat-label">Sedang Diproses</span>
                            <span class="stat-pill stat-pill-info">Aktif</span>
                        </div>
                        <div class="stat-value"><?php echo e(number_format($diterima)); ?></div>
                        <div class="stat-sub">Tamu sedang dilayani</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon stat-icon-selesai">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-header">
                            <span class="stat-label">Selesai Dilayani</span>
                            <span class="stat-pill stat-pill-success"><?php echo e($tingkatSelesai); ?>% rasio</span>
                        </div>
                        <div class="stat-value"><?php echo e(number_format($selesai)); ?></div>
                        <div class="stat-sub">Kunjungan tuntas</div>
                    </div>
                </div>
            </div>

            
            <div class="analytics-grid">

                
                <div class="card-panel">
                    <div class="panel-header">
                        <h3>
                            <i class="fa-solid fa-chart-column"></i>
                            <span>Distribusi Kunjungan per Bidang</span>
                        </h3>
                        <span class="panel-header-note"><?php echo e($labelPeriode); ?></span>
                    </div>

                    <div class="bidang-list">
                        <?php $__empty_1 = true; $__currentLoopData = $statistikBidang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bidang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $persenBar = $maksimumBidang > 0
                                    ? ($bidang->jumlah_kunjungan / $maksimumBidang) * 100
                                    : 0;
                            ?>
                            <div class="bidang-row">
                                <div class="bidang-name" title="<?php echo e($bidang->nama); ?>">
                                    <?php echo e($bidang->nama); ?>

                                </div>
                                <div class="bar-bg">
                                    <div class="bar-fill" style="width: <?php echo e(min(100, $persenBar)); ?>%;"></div>
                                </div>
                                <div class="bidang-number">
                                    <?php echo e(number_format($bidang->jumlah_kunjungan)); ?>

                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="empty-state">
                                <i class="fa-regular fa-folder-open"></i>
                                <p>Belum ada data kunjungan pada periode ini.</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if($bidangTeratas && $totalKunjungan > 0): ?>
                        <div class="panel-insight">
                            <i class="fa-solid fa-arrow-trend-up"></i>
                            <span>
                                <strong><?php echo e($bidangTeratas->nama); ?></strong> menerima intensitas tertinggi sekitar <strong><?php echo e($persentaseBidangTeratas); ?>%</strong> dari total kunjungan.
                            </span>
                        </div>
                    <?php endif; ?>
                </div>

                
                <div class="card-panel">
                    <div class="panel-header">
                        <h3>
                            <i class="fa-solid fa-chart-line"></i>
                            <span>Tren Kunjungan 7 Hari Terakhir</span>
                        </h3>
                        <span class="panel-header-note">Jumlah tamu harian</span>
                    </div>

                    <div class="trend-chart">
                        <?php $__empty_1 = true; $__currentLoopData = $trendKunjungan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trend): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $tinggi = $maksimumTrend > 0
                                    ? ($trend['jumlah'] / $maksimumTrend) * 100
                                    : 0;
                                $isHighest = $trend['jumlah'] > 0 && $trend['jumlah'] === $maksimumTrend;
                            ?>
                            <div class="trend-column">
                                <div class="trend-value">
                                    <?php echo e(number_format($trend['jumlah'])); ?>

                                </div>
                                <div class="trend-bar-wrap">
                                    <div
                                        class="trend-bar <?php echo e($isHighest ? 'trend-bar-highest' : ''); ?>"
                                        style="height: <?php echo e(max(4, min(100, $tinggi))); ?>%;"
                                        title="<?php echo e($trend['tanggal']); ?>: <?php echo e($trend['jumlah']); ?> kunjungan"
                                    ></div>
                                </div>
                                <div class="trend-label">
                                    <?php echo e($trend['tanggal']); ?>

                                </div>
                                <div class="trend-day">
                                    <?php echo e($trend['label']); ?>

                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="empty-state">
                                <i class="fa-regular fa-chart-bar"></i>
                                <p>Belum ada data tren kunjungan.</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="panel-insight" style="background: #f1f8f7;">
                        <i class="fa-regular fa-clock"></i>
                        <span>Grafik menghitung seluruh data kunjungan yang tercatat dalam 7 hari terakhir (WITA).</span>
                    </div>
                </div>

            </div>

            
            <div class="bottom-grid">

                
                <div class="card-panel">
                    <div class="panel-header">
                        <h3>
                            <i class="fa-solid fa-triangle-exclamation" style="color: var(--color-warning);"></i>
                            <span>Perlu Perhatian Kepala Badan
                        </h3>
                        <span class="panel-header-note">
                            <?php echo e($totalPerluPerhatian > 0
                                ? "{$totalPerluPerhatian} item (menampilkan 5 teratas)"
                                : "Tidak ada"); ?>

                        </span>
                    </div>

                    <div>
                        <?php $__empty_1 = true; $__currentLoopData = $perluPerhatian; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kunjungan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $lamaMenit = $kunjungan->lama_menunggu ?? 0;
                                if ($lamaMenit >= 1440) {
                                    $waktuText = floor($lamaMenit / 1440) . ' hari';
                                } elseif ($lamaMenit >= 60) {
                                    $waktuText = floor($lamaMenit / 60) . ' jam';
                                } else {
                                    $waktuText = max(1, $lamaMenit) . ' menit';
                                }
                                $badgeClass = $kunjungan->kategori === 'baru' ? 'badge-baru' : 'badge-diterima';
                                $badgeIcon = $kunjungan->kategori === 'baru' ? 'fa-regular fa-clock' : 'fa-solid fa-hourglass-half';
                                $badgeLabel = $kunjungan->kategori === 'baru' ? 'Baru' : 'Diterima';
                            ?>
                            <div class="attention-item">
                                <div class="attention-item-left">
                                    <span class="attention-name"><?php echo e($kunjungan->nama_pengunjung); ?> (<?php echo e($kunjungan->instansi); ?>)</span>
                                    <span class="attention-bidang">
                                        Tujuan: <strong><?php echo e($kunjungan->bidangTujuan?->nama ?? '-'); ?></strong> &bull; <?php echo e($kunjungan->keperluan); ?>

                                    </span>
                                </div>
                                <div class="attention-badge <?php echo e($badgeClass); ?>">
                                    <i class="<?php echo e($badgeIcon); ?>"></i>
                                    <span><?php echo e($badgeLabel); ?> &bull; <?php echo e($waktuText); ?></span>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="empty-state">
                                <i class="fa-solid fa-circle-check" style="color: var(--color-success); font-size: 32px;"></i>
                                <p style="color: var(--color-success); font-weight: 700; margin-top: 8px;">Pelayanan Berjalan Lancar</p>
                                <span>Tidak ada antrean kunjungan yang tertahan (Baru >10 menit atau Diterima >24 jam).</span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if($totalPerluPerhatian > 5): ?>
                    <div style="margin-top: 12px; text-align: right;">
                        <a href="<?php echo e(route('pimpinan.laporan')); ?>" style="font-size: 12px; font-weight: 700; color: var(--color-primary);">
                            Lihat Semua (<?php echo e($totalPerluPerhatian); ?>) &rarr;
                        </a>
                    </div>
                    <?php endif; ?>
                </div>

                
                <div class="card-panel">
                    <div class="panel-header">
                        <h3>
                            <i class="fa-solid fa-clock-rotate-left"></i>
                            <span>Kunjungan Tamu Terbaru</span>
                        </h3>
                        <a href="<?php echo e(route('pimpinan.laporan')); ?>" style="font-size: 12px; font-weight: 700; color: var(--color-primary);">
                            Lihat Semua &rarr;
                        </a>
                    </div>

                    <div>
                        <?php $__empty_1 = true; $__currentLoopData = $kunjunganTerbaru->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kunjungan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="recent-item">
                                <div class="recent-info">
                                    <span class="recent-name"><?php echo e($kunjungan->nama_pengunjung); ?></span>
                                    <div class="recent-meta">
                                        <span><?php echo e($kunjungan->instansi); ?></span>
                                        &bull;
                                        <span><?php echo e($kunjungan->bidangTujuan?->kode ?? '-'); ?></span>
                                        &bull;
                                        <span><?php echo e($kunjungan->created_at ? $kunjungan->created_at->timezone('Asia/Makassar')->format('H:i') . ' WITA' : '-'); ?></span>
                                    </div>
                                </div>
                                <div>
                                    <?php if($kunjungan->status === 'baru' || $kunjungan->status === 'menunggu'): ?>
                                        <span class="badge badge-baru">
                                            <i class="fa-regular fa-clock"></i> Baru
                                        </span>
                                    <?php elseif($kunjungan->status === 'diterima'): ?>
                                        <span class="badge badge-diterima">
                                            <i class="fa-solid fa-hourglass-half"></i> Diterima
                                        </span>
                                    <?php elseif($kunjungan->status === 'selesai'): ?>
                                        <span class="badge badge-selesai">
                                            <i class="fa-solid fa-check"></i> Selesai
                                        </span>
                                    <?php else: ?>
                                        <span class="badge badge-default">
                                            <?php echo e(strtoupper($kunjungan->status)); ?>

                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="empty-state">
                                <i class="fa-regular fa-folder-open"></i>
                                <p>Belum ada data kunjungan terbaru.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>

        </main>

        
        <footer class="footer">
            <div>&copy; <?php echo e(date('Y')); ?> BKAD Kabupaten Tapin &bull; SIKUTA (Sistem Informasi Kunjungan Tamu)</div>
        </footer>

    </div>

    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
        });
    </script>
</body>
</html>
<?php /**PATH C:\laragon\www\bkad-kunjungan_tamu\resources\views/pimpinan/dashboard.blade.php ENDPATH**/ ?>