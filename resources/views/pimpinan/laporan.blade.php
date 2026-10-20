<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kepala Badan - SIKUTA BKAD Kabupaten Tapin</title>

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

        /* PAGE BANNER */
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

        .periode-pill {
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

        .periode-pill i {
            color: var(--color-primary);
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
        .stat-icon-diterima { background: var(--color-info-light); color: var(--color-info); }
        .stat-icon-selesai { background: var(--color-success-light); color: var(--color-success); }

        .stat-content {
            flex: 1;
            min-width: 0;
        }

        .stat-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--color-text-secondary);
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 800;
            color: var(--color-primary-dark);
            line-height: 1.1;
        }

        .stat-desc {
            font-size: 11px;
            color: var(--color-text-secondary);
            margin-top: 4px;
        }

        /* CARD FILTER */
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

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr) auto;
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

        .btn-pdf {
            background: #ffffff;
            color: var(--color-danger);
            border: 1px solid #fca5a5;
        }

        .btn-pdf:hover {
            background: var(--color-danger-light);
            border-color: var(--color-danger);
        }

        .btn-csv,
        .btn-excel,
        .btn-success {
            background: #ffffff;
            color: var(--color-success);
            border: 1px solid #86efac;
        }

        .btn-csv:hover,
        .btn-excel:hover,
        .btn-success:hover {
            background: var(--color-success-light);
            border-color: var(--color-success);
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

        .table-actions {
            display: flex;
            align-items: center;
            gap: 8px;
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

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .badge-menunggu { background: var(--color-warning-light); color: var(--color-warning); }
        .badge-diterima { background: var(--color-info-light); color: var(--color-info); }
        .badge-dialihkan { background: #f3e8ff; color: #7e22ce; }
        .badge-selesai { background: var(--color-success-light); color: var(--color-success); }
        .badge-default { background: #f1f5f9; color: #475569; }

        .badge-kode {
            background: var(--color-primary-light);
            color: var(--color-primary-dark);
            font-family: monospace;
            font-size: 11px;
            padding: 3px 8px;
            border-radius: var(--radius-sm);
            font-weight: 700;
            border: 1px solid #c2e9de;
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

        @media (max-width: 1100px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .filter-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
            .btn-menu-mobile { display: flex; }
            .topbar { padding: 0 16px; }
            .content { padding: 20px 16px; }
            .page-banner { flex-direction: column; align-items: flex-start; }
            .stats-grid { grid-template-columns: 1fr; }
            .filter-grid { grid-template-columns: 1fr; }
            .filter-grid button { width: 100%; }
            .table-header { flex-direction: column; align-items: flex-start; }
            .table-actions { width: 100%; flex-direction: column; }
            .table-actions .btn { width: 100%; }
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
            <div class="brand-logo">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo BKAD Kabupaten Tapin" style="width: 100%; height: 100%; object-fit: contain; border-radius: var(--radius-md);">
            </div>
            <div>
                <div class="brand-title">SIKUTA</div>
                <div class="brand-sub">BKAD KABUPATEN TAPIN</div>
            </div>
        </div>

        <nav class="menu-list">
            <a href="{{ route('pimpinan.dashboard') }}" class="menu-link">
                <i class="fa-solid fa-gauge-high"></i>
                <span>Dashboard Kepala Badan</span>
            </a>

            <a href="{{ route('pimpinan.laporan') }}" class="menu-link active">
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
                    <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
                    <div class="sidebar-user-role">Kepala Badan</div>
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
                    <h1>Laporan Kunjungan Tamu</h1>
                    <p>Rekapitulasi berkas kunjungan tamu dan ekspor dokumen dinas pimpinan</p>
                </div>
            </div>

            <div class="topbar-badge">
                <i class="fa-solid fa-file-shield"></i>
                <span>Laporan Kepala Badan</span>
            </div>
        </header>

        {{-- CONTENT --}}
        <main class="content">

            {{-- PAGE BANNER --}}
            <div class="page-banner">
                <div class="page-banner-info">
                    <h2>Laporan Kunjungan Tamu</h2>
                    <p>Rekapitulasi data kunjungan tamu dinas di lingkungan BKAD Kabupaten Tapin beserta opsi unduh PDF dan spreadsheet CSV.</p>
                </div>
                <div class="periode-pill">
                    <i class="fa-regular fa-calendar-days"></i>
                    <span>
                        Periode: <strong>{{ \Carbon\Carbon::parse($tanggalMulai)->format('d/m/Y') }}</strong> s.d. <strong>{{ \Carbon\Carbon::parse($tanggalAkhir)->format('d/m/Y') }}</strong>
                    </span>
                </div>
            </div>

            {{-- STATS GRID --}}
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon stat-icon-total">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-label">Total Kunjungan</div>
                        <div class="stat-value">{{ number_format($total) }}</div>
                        <div class="stat-desc">Sesuai filter terpilih</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon stat-icon-menunggu">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-label">Menunggu</div>
                        <div class="stat-value">{{ number_format($menunggu) }}</div>
                        <div class="stat-desc">Belum diterima bidang</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon stat-icon-diterima">
                        <i class="fa-solid fa-hourglass-half"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-label">Diterima</div>
                        <div class="stat-value">{{ number_format($diterima) }}</div>
                        <div class="stat-desc">Sedang proses konsultasi</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon stat-icon-selesai">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-label">Selesai</div>
                        <div class="stat-value">{{ number_format($selesai) }}</div>
                        <div class="stat-desc">Kunjungan selesai tuntas</div>
                    </div>
                </div>
            </div>

            {{-- FILTER CARD --}}
            <div class="card-filter">
                <div class="filter-header">
                    <h3>
                        <i class="fa-solid fa-sliders"></i>
                        <span>Filter &amp; Parameter Laporan</span>
                    </h3>
                </div>

                <form method="GET" action="{{ route('pimpinan.laporan') }}">
                    <div class="filter-grid">
                        <div class="form-group">
                            <label for="tanggal_mulai">Tanggal Mulai</label>
                            <input
                                type="date"
                                id="tanggal_mulai"
                                name="tanggal_mulai"
                                value="{{ $tanggalMulai }}"
                                class="form-control"
                            >
                        </div>

                        <div class="form-group">
                            <label for="tanggal_akhir">Tanggal Akhir</label>
                            <input
                                type="date"
                                id="tanggal_akhir"
                                name="tanggal_akhir"
                                value="{{ $tanggalAkhir }}"
                                class="form-control"
                            >
                        </div>

                        <div class="form-group">
                            <label for="bidang_id">Bidang Tujuan</label>
                            <select id="bidang_id" name="bidang_id" class="form-control">
                                <option value="">Semua Bidang</option>
                                @foreach ($bidangs as $bidang)
                                    <option value="{{ $bidang->id }}" @selected($bidangId == $bidang->id)>
                                        {{ $bidang->kode }} - {{ $bidang->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="status">Status Kunjungan</label>
                            <select id="status" name="status" class="form-control">
                                <option value="">Semua Status</option>
                                <option value="menunggu" @selected($status === 'menunggu')>Menunggu</option>
                                <option value="diterima" @selected($status === 'diterima')>Diterima</option>
                                <option value="dialihkan" @selected($status === 'dialihkan')>Dialihkan</option>
                                <option value="selesai" @selected($status === 'selesai')>Selesai</option>
                            </select>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                <span>Tampilkan</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- TABLE CARD --}}
            <div class="card-table">
                <div class="table-header">
                    <div class="table-header-title">
                        <h3>
                            <i class="fa-solid fa-table-list"></i>
                            <span>Daftar Kunjungan</span>
                        </h3>
                        <span class="badge-count">{{ number_format($kunjungans->total()) }} Data</span>
                    </div>

                    <div class="table-actions">
                        <a href="{{ route('pimpinan.laporan.pdf', request()->query()) }}" class="btn btn-pdf">
                            <i class="fa-solid fa-file-pdf"></i>
                            <span>Unduh PDF</span>
                        </a>

                        <a href="{{ route('pimpinan.laporan.excel', request()->query()) }}" class="btn btn-success">
                            <i class="fa-solid fa-file-excel"></i>
                            <span>Unduh Excel</span>
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    @if ($kunjungans->count())
                        <table>
                            <thead>
                                <tr>
                                    <th style="width: 60px; text-align: center;">No</th>
                                    <th style="width: 150px;">Waktu Kunjungan</th>
                                    <th style="width: 220px;">Nama Pengunjung</th>
                                    <th style="width: 180px;">Instansi Asal</th>
                                    <th style="width: 190px;">Bidang Tujuan</th>
                                    <th>Keperluan Kunjungan</th>
                                    <th style="width: 130px; text-align: center;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kunjungans as $index => $kunjungan)
                                    <tr>
                                        <td style="text-align: center; color: var(--color-text-secondary); font-weight: 600;">
                                            {{ $kunjungans->firstItem() + $index }}
                                        </td>
                                        <td>
                                            <div style="font-weight: 700;">
                                                {{ $kunjungan->created_at ? $kunjungan->created_at->timezone('Asia/Makassar')->format('d/m/Y') : '-' }}
                                            </div>
                                            <div style="font-size: 11px; color: var(--color-text-secondary); margin-top: 2px;">
                                                <i class="fa-regular fa-clock"></i>
                                                {{ $kunjungan->created_at ? $kunjungan->created_at->timezone('Asia/Makassar')->format('H:i') . ' WITA' : '-' }}
                                            </div>
                                        </td>
                                        <td>
                                            <div style="font-weight: 700; color: var(--color-primary-dark);">
                                                {{ $kunjungan->nama_pengunjung }}
                                            </div>
                                            @if ($kunjungan->nip)
                                                <div style="font-size: 11px; color: var(--color-text-secondary); margin-top: 2px;">
                                                    NIP: {{ $kunjungan->nip }}
                                                </div>
                                            @endif
                                            @if ($kunjungan->jabatan)
                                                <div style="font-size: 11px; color: var(--color-text-secondary);">
                                                    {{ $kunjungan->jabatan }}
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $kunjungan->instansi }}
                                        </td>
                                        <td>
                                            <span class="badge-kode">
                                                {{ $kunjungan->bidangTujuan?->kode ?? '-' }}
                                            </span>
                                            <div style="font-size: 12px; margin-top: 4px; font-weight: 600;">
                                                {{ $kunjungan->bidangTujuan?->nama ?? '-' }}
                                            </div>
                                        </td>
                                        <td>
                                            <div style="line-height: 1.45;">
                                                {{ $kunjungan->keperluan }}
                                            </div>
                                            @if ($kunjungan->jawaban_bidang)
                                                <div style="font-size: 11px; color: var(--color-primary); margin-top: 4px; background: #eaf7f4; padding: 4px 8px; border-radius: 4px;">
                                                    <i class="fa-regular fa-comment-dots"></i> Respon: {{ $kunjungan->jawaban_bidang }}
                                                </div>
                                            @endif
                                        </td>
                                        <td style="text-align: center;">
                                            @if ($kunjungan->status === 'menunggu' || $kunjungan->status === 'baru')
                                                <span class="badge badge-menunggu">
                                                    <i class="fa-regular fa-clock"></i> Menunggu
                                                </span>
                                            @elseif ($kunjungan->status === 'diterima')
                                                <span class="badge badge-diterima">
                                                    <i class="fa-solid fa-hourglass-half"></i> Diterima
                                                </span>
                                            @elseif ($kunjungan->status === 'dialihkan')
                                                <span class="badge badge-dialihkan">
                                                    <i class="fa-solid fa-share-nodes"></i> Dialihkan
                                                </span>
                                            @elseif ($kunjungan->status === 'selesai')
                                                <span class="badge badge-selesai">
                                                    <i class="fa-solid fa-check"></i> Selesai
                                                </span>
                                            @else
                                                <span class="badge badge-default">
                                                    {{ strtoupper($kunjungan->status) }}
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-state">
                            <i class="fa-regular fa-folder-open"></i>
                            <p>Tidak ada data kunjungan</p>
                            <span>Tidak ditemukan data kunjungan pada rentang filter tanggal atau status ini.</span>
                        </div>
                    @endif
                </div>

                @if ($kunjungans->hasPages())
                    <div class="pagination-wrapper">
                        {{ $kunjungans->links() }}
                    </div>
                @endif
            </div>

        </main>

        {{-- FOOTER --}}
        <footer class="footer">
            <div>&copy; {{ date('Y') }} BKAD Kabupaten Tapin &bull; SIKUTA (Sistem Informasi Kunjungan Tamu)</div>
        </footer>

    </div>

    {{-- Script Mobile Sidebar --}}
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
