@php
    $user = auth()->user();

    $bidangTujuan = $kunjungan->bidangTujuan ?? null;
    $kodeBidang = $bidangTujuan?->kode ?? $user?->bidang?->kode ?? '';

    $status = strtolower(trim((string) ($kunjungan->status ?? 'baru')));

    $statusLabel = match ($status) {
        'baru', 'menunggu' => 'Baru',
        'diterima', 'diproses' => 'Diterima',
        'dialihkan' => 'Dialihkan',
        'selesai' => 'Selesai',
        default => ucfirst($status),
    };

    $statusClass = match ($status) {
        'baru', 'menunggu' => 'status-baru',
        'diterima', 'diproses' => 'status-diterima',
        'dialihkan' => 'status-dialihkan',
        'selesai' => 'status-selesai',
        default => 'status-baru',
    };

    $waktuDaftar = $kunjungan->created_at;
    $waktuDiterima = $kunjungan->diterima_at ?? null;
    $waktuSelesai = $kunjungan->selesai_at ?? null;

    $isPetugasBidang = $user?->role === 'penerima_bidang';
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kunjungan #{{ $kunjungan->id }} - SIKUTA BKAD Kabupaten Tapin</title>

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
            --color-status-baru-bg: #DBEAFE;
            --color-status-baru-text: #1E40AF;
            --color-status-diterima-bg: #FFF0D8;
            --color-status-diterima-text: #92400E;
            --color-status-dialihkan-bg: #F0E8FB;
            --color-status-dialihkan-text: #6B21A8;
            --color-status-selesai-bg: #D1FAE5;
            --color-status-selesai-text: #065F46;
            --color-danger: #DC2626;
            --color-danger-bg: #FEF2F2;
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 14px;
            --radius-xl: 18px;
            --shadow-sm: 0 1px 3px rgba(16, 63, 60, 0.05);
            --shadow-md: 0 4px 14px rgba(16, 63, 60, 0.08);
            --shadow-lg: 0 10px 30px rgba(16, 63, 60, 0.12);
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
        button, input, textarea, select { font-family: inherit; }

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
        }

        .topbar-title h1 {
            font-size: 18px;
            font-weight: 800;
            color: var(--color-primary-dark);
            line-height: 1.2;
        }

        .topbar-title p {
            font-size: 12px;
            color: var(--color-text-secondary);
        }

        .topbar-meta {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .pill-meta {
            background: var(--color-primary-light);
            color: var(--color-primary);
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        /* CONTENT */
        .content {
            padding: 28px 32px 60px;
            flex: 1;
            max-width: 1300px;
            width: 100%;
            margin: 0 auto;
        }

        .back-nav {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
            font-size: 13px;
            font-weight: 600;
            color: var(--color-text);
            transition: all 0.2s ease;
        }

        .btn-back:hover {
            border-color: var(--color-primary);
            color: var(--color-primary);
            background: var(--color-primary-light);
        }

        /* Alert */
        .alert-box {
            padding: 14px 18px;
            border-radius: var(--radius-md);
            font-size: 13px;
            margin-bottom: 22px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-box.success {
            background: var(--color-status-selesai-bg);
            color: var(--color-status-selesai-text);
            border: 1px solid #a7f3d0;
        }

        .alert-box.error {
            background: var(--color-danger-bg);
            color: var(--color-danger);
            border: 1px solid #fecaca;
        }

        /* Detail Grid Layout */
        .detail-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 340px;
            gap: 24px;
            align-items: start;
        }

        /* Cards */
        .card {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-xl);
            padding: 26px;
            margin-bottom: 24px;
            box-shadow: var(--shadow-sm);
        }

        .card:last-child {
            margin-bottom: 0;
        }

        .card-header-styled {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 22px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--color-border);
        }

        .card-header-icon {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-md);
            background: var(--color-primary-light);
            color: var(--color-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            flex-shrink: 0;
        }

        .card-header-styled h2 {
            font-size: 16px;
            font-weight: 800;
            color: var(--color-primary-dark);
        }

        .card-header-styled p {
            font-size: 12px;
            color: var(--color-text-secondary);
            margin-top: 2px;
        }

        /* Visitor Info Grid */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px 24px;
        }

        .info-cell-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--color-text-secondary);
            margin-bottom: 4px;
        }

        .info-cell-value {
            font-size: 14px;
            font-weight: 700;
            color: var(--color-text);
            line-height: 1.4;
        }

        /* Timeline Box */
        .timeline-box {
            background: #fafcfb;
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            padding: 16px 20px;
            margin-top: 22px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        .timeline-step {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .timeline-step-label {
            font-size: 11px;
            font-weight: 700;
            color: var(--color-text-secondary);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .timeline-step-val {
            font-size: 13px;
            font-weight: 700;
            color: var(--color-primary-dark);
        }

        /* Keperluan Box */
        .purpose-content {
            background: #fafcfb;
            border-left: 3px solid var(--color-primary);
            padding: 16px 20px;
            border-radius: 0 var(--radius-md) var(--radius-md) 0;
            font-size: 14px;
            line-height: 1.6;
            color: var(--color-text);
        }

        /* Signature Display */
        .sig-preview-box {
            background: #fafcfb;
            border: 1px dashed var(--color-border);
            border-radius: var(--radius-md);
            padding: 16px;
            margin-top: 16px;
            display: inline-block;
        }

        .sig-preview-img {
            max-height: 90px;
            display: block;
        }

        /* Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        .status-baru { background: var(--color-status-baru-bg); color: var(--color-status-baru-text); }
        .status-diterima { background: var(--color-status-diterima-bg); color: var(--color-status-diterima-text); }
        .status-dialihkan { background: var(--color-status-dialihkan-bg); color: var(--color-status-dialihkan-text); }
        .status-selesai { background: var(--color-status-selesai-bg); color: var(--color-status-selesai-text); }

        /* Form Textarea & Controls */
        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: var(--color-text);
            margin-bottom: 6px;
        }

        .form-control {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
            font-size: 13px;
            color: var(--color-text);
            background: #ffffff;
            outline: none;
            transition: all 0.2s ease;
            line-height: 1.5;
        }

        .form-control:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(7, 133, 119, 0.15);
        }

        /* Buttons */
        .btn-action-primary {
            width: 100%;
            padding: 13px 20px;
            background: var(--color-primary);
            color: #ffffff;
            border: none;
            border-radius: var(--radius-md);
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(7, 133, 119, 0.25);
            transition: all 0.2s ease;
        }

        .btn-action-primary:hover {
            background: var(--color-primary-hover);
            transform: translateY(-1px);
        }

        .btn-action-outline {
            width: 100%;
            padding: 11px 18px;
            background: transparent;
            border: 1px solid var(--color-border);
            color: var(--color-text);
            border-radius: var(--radius-md);
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-action-outline:hover {
            background: var(--color-bg);
            border-color: var(--color-text-secondary);
        }

        .btn-action-purple {
            width: 100%;
            padding: 12px 18px;
            background: var(--color-status-dialihkan-bg);
            border: 1px solid rgba(107, 33, 168, 0.25);
            color: var(--color-status-dialihkan-text);
            border-radius: var(--radius-md);
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-action-purple:hover {
            background: #e6d8f7;
        }

        /* Info Alert Boxes */
        .info-notice {
            background: var(--color-primary-light);
            border: 1px solid rgba(7, 133, 119, 0.25);
            border-radius: var(--radius-md);
            padding: 14px 16px;
            font-size: 13px;
            color: var(--color-primary-dark);
            display: flex;
            align-items: flex-start;
            gap: 10px;
            line-height: 1.5;
        }

        .action-card-desc {
            font-size: 13px;
            color: var(--color-text-secondary);
            margin-bottom: 14px;
            line-height: 1.5;
        }

        /* Footer */
        .footer-note {
            margin-top: 36px;
            text-align: center;
            font-size: 12px;
            color: var(--color-text-secondary);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .detail-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
            .btn-menu-mobile { display: flex; }
            .topbar { padding: 0 16px; }
            .content { padding: 20px 16px; }
            .info-grid { grid-template-columns: 1fr; }
            .timeline-box { grid-template-columns: 1fr; }
        }

        @media (prefers-reduced-motion: reduce) {
            * { transition: none !important; animation: none !important; }
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
            @if ($isPetugasBidang && $kodeBidang)
                <a href="{{ route('kunjungan.inbox', ['kode' => $kodeBidang]) }}" class="menu-link active">
                    <i class="fa-solid fa-inbox"></i>
                    <span>Kotak Masuk</span>
                </a>
            @else
                <a href="{{ url('/') }}" class="menu-link active">
                    <i class="fa-solid fa-house"></i>
                    <span>Beranda Pelayanan</span>
                </a>
            @endif

            @if(auth()->user()->role === 'petugas_piket')
                <a href="{{ route('kunjungan.create') }}" class="menu-link">
                    <i class="fa-solid fa-pen-to-square"></i>
                    <span>Form Meja Piket</span>
                </a>
            @endif

            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="menu-link">
                    <i class="fa-solid fa-gauge-high"></i>
                    <span>Dashboard Admin</span>
                </a>
            @endif

            @if(auth()->user()->role === 'pimpinan')
                <a href="{{ route('pimpinan.dashboard') }}" class="menu-link">
                    <i class="fa-solid fa-chart-line"></i>
                    <span>Dashboard Pimpinan</span>
                </a>
            @endif
        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="sidebar-user-avatar">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div>
                    <div class="sidebar-user-name">{{ $user->name ?? 'Pengguna' }}</div>
                    <div class="sidebar-user-role">{{ str_replace('_', ' ', $user->role ?? 'user') }}</div>
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

    {{-- MAIN CONTENT --}}
    <div class="main-wrapper">

        {{-- TOPBAR --}}
        <header class="topbar">
            <div class="topbar-left">
                <button type="button" class="btn-menu-mobile" id="mobileMenuToggle" aria-label="Menu navigasi">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div class="topbar-title">
                    <h1>Detail Kunjungan Tamu</h1>
                    <p>ID: #{{ $kunjungan->id }} &bull; Bidang: {{ $bidangTujuan?->nama ?? '-' }}</p>
                </div>
            </div>

            <div class="topbar-meta">
                <div class="pill-meta">
                    <i class="fa-solid fa-shield-halved"></i>
                    <span>{{ $kodeBidang }}</span>
                </div>
            </div>
        </header>

        {{-- CONTENT --}}
        <main class="content">

            {{-- Back row navigation --}}
            <div class="back-nav">
                @if ($isPetugasBidang && $kodeBidang)
                    <a href="{{ route('kunjungan.inbox', ['kode' => $kodeBidang]) }}" class="btn-back">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Kembali ke Kotak Masuk</span>
                    </a>
                @elseif (auth()->user()->role === 'petugas_piket')
                    <a href="{{ route('kunjungan.create') }}" class="btn-back">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Kembali ke Meja Piket</span>
                    </a>
                @elseif (auth()->user()->role === 'admin')
                    <a href="{{ route('admin.kunjungan.index') }}" class="btn-back">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Kembali ke Data Kunjungan</span>
                    </a>
                @else
                    <a href="{{ url()->previous() }}" class="btn-back">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Kembali</span>
                    </a>
                @endif

                <div style="display: flex; align-items: center; gap: 10px;">
                    <span class="status-badge {{ $statusClass }}">
                        @if(in_array($status, ['baru', 'menunggu']))
                            <i class="fa-solid fa-circle-dot"></i>
                        @elseif(in_array($status, ['diterima', 'diproses']))
                            <i class="fa-solid fa-spinner"></i>
                        @elseif($status === 'dialihkan')
                            <i class="fa-solid fa-share"></i>
                        @elseif($status === 'selesai')
                            <i class="fa-solid fa-circle-check"></i>
                        @endif
                        <span>Status: {{ $statusLabel }}</span>
                    </span>

                    @if ($waktuDaftar)
                        <span style="font-size: 12px; color: var(--color-text-secondary);">
                            <i class="fa-regular fa-clock"></i> {{ $waktuDaftar->locale('id')->diffForHumans() }}
                        </span>
                    @endif
                </div>
            </div>

            {{-- Session Messages --}}
            @if (session('success'))
                <div class="alert-box success">
                    <i class="fa-solid fa-circle-check"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if (session('error'))
                <div class="alert-box error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert-box error">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <div>
                        <strong>Periksa kembali data yang dimasukkan:</strong>
                        <ul style="margin: 4px 0 0 16px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- GRID DETAIL --}}
            <div class="detail-grid">

                {{-- KOLOM KIRI --}}
                <div class="left-col">

                    {{-- CARD 1: Data Pengunjung --}}
                    <section class="card">
                        <div class="card-header-styled">
                            <div class="card-header-icon">
                                <i class="fa-solid fa-user-tie"></i>
                            </div>
                            <div>
                                <h2>Informasi Pengunjung</h2>
                                <p>Identitas tamu dinas dan instansi asal.</p>
                            </div>
                        </div>

                        <div class="info-grid">
                            <div>
                                <div class="info-cell-label">Nama Pengunjung</div>
                                <div class="info-cell-value">{{ $kunjungan->nama_pengunjung ?? '-' }}</div>
                            </div>

                            <div>
                                <div class="info-cell-label">NIP</div>
                                <div class="info-cell-value">{{ $kunjungan->nip ?: '-' }}</div>
                            </div>

                            <div>
                                <div class="info-cell-label">Jabatan</div>
                                <div class="info-cell-value">{{ $kunjungan->jabatan ?: '-' }}</div>
                            </div>

                            <div>
                                <div class="info-cell-label">SKPD / Instansi Asal</div>
                                <div class="info-cell-value">{{ $kunjungan->instansi ?: '-' }}</div>
                            </div>

                            <div>
                                <div class="info-cell-label">Bidang yang Dituju</div>
                                <div class="info-cell-value" style="color: var(--color-primary);">
                                    {{ $bidangTujuan?->nama ?? '-' }}
                                </div>
                            </div>

                            <div>
                                <div class="info-cell-label">Status Pelayanan</div>
                                <div>
                                    <span class="status-badge {{ $statusClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Tanda tangan jika ada --}}
                        @if ($kunjungan->tanda_tangan)
                            <div style="margin-top: 20px; padding-top: 16px; border-top: 1px solid var(--color-border);">
                                <div class="info-cell-label">Tanda Tangan Pengunjung</div>
                                <div class="sig-preview-box">
                                    @if(str_starts_with($kunjungan->tanda_tangan, 'data:image'))
                                        <img src="{{ $kunjungan->tanda_tangan }}" alt="Tanda tangan pengunjung" class="sig-preview-img">
                                    @else
                                        <div style="font-size: 13px; font-style: italic; color: var(--color-text-secondary);">
                                            {{ $kunjungan->tanda_tangan }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        {{-- Timeline --}}
                        <div class="timeline-box">
                            <div class="timeline-step">
                                <span class="timeline-step-label"><i class="fa-regular fa-calendar-check"></i> Pendaftaran</span>
                                <span class="timeline-step-val">
                                    {{ $waktuDaftar ? $waktuDaftar->timezone('Asia/Makassar')->format('d/m/Y H:i') . ' WITA' : '-' }}
                                </span>
                            </div>

                            <div class="timeline-step">
                                <span class="timeline-step-label"><i class="fa-solid fa-handshake"></i> Diterima</span>
                                <span class="timeline-step-val">
                                    {{ $waktuDiterima ? \Illuminate\Support\Carbon::parse($waktuDiterima)->timezone('Asia/Makassar')->format('d/m/Y H:i') . ' WITA' : '-' }}
                                </span>
                            </div>

                            <div class="timeline-step">
                                <span class="timeline-step-label"><i class="fa-regular fa-circle-check"></i> Selesai</span>
                                <span class="timeline-step-val">
                                    {{ $waktuSelesai ? \Illuminate\Support\Carbon::parse($waktuSelesai)->timezone('Asia/Makassar')->format('d/m/Y H:i') . ' WITA' : '-' }}
                                </span>
                            </div>
                        </div>
                    </section>

                    {{-- CARD 2: Maksud & Keperluan --}}
                    <section class="card">
                        <div class="card-header-styled">
                            <div class="card-header-icon">
                                <i class="fa-solid fa-file-lines"></i>
                            </div>
                            <div>
                                <h2>Keperluan Kunjungan</h2>
                                <p>Maksud dan uraian konsultasi atau koordinasi tamu.</p>
                            </div>
                        </div>

                        <div class="purpose-content">
                            {{ $kunjungan->keperluan ?: 'Tidak ada uraian keperluan.' }}
                        </div>

                        @if($kunjungan->catatan_pengalihan)
                            <div style="margin-top: 16px;">
                                <div class="info-cell-label" style="color: var(--color-status-dialihkan-text);">
                                    <i class="fa-solid fa-share"></i> Catatan Pengalihan Bidang
                                </div>
                                <div style="background: var(--color-status-dialihkan-bg); border-left: 3px solid #8b5cf6; padding: 12px 16px; border-radius: 0 var(--radius-md) var(--radius-md) 0; font-size: 13px; color: var(--color-status-dialihkan-text);">
                                    {{ $kunjungan->catatan_pengalihan }}
                                </div>
                            </div>
                        @endif
                    </section>

                    {{-- CARD 3: Jawaban / Tindak Lanjut Bidang --}}
                    <section class="card" id="cardJawaban">
                        <div class="card-header-styled">
                            <div class="card-header-icon">
                                <i class="fa-solid fa-comment-dots"></i>
                            </div>
                            <div>
                                <h2>Jawaban &amp; Hasil Pelayanan Bidang</h2>
                                <p>Catatan rekomendasi atau hasil konsultasi yang diberikan oleh petugas bidang.</p>
                            </div>
                        </div>

                        @if ($isPetugasBidang && in_array($status, ['baru', 'menunggu', 'diterima', 'diproses']))
                            <form action="{{ route('kunjungan.selesai', $kunjungan->id) }}" method="POST">
                                @csrf

                                <div style="margin-bottom: 16px;">
                                    <label for="jawaban_bidang" class="form-label">
                                        Jawaban / Tindak Lanjut Pelayanan <span style="color: var(--color-danger);">*</span>
                                    </label>
                                    <textarea
                                        name="jawaban_bidang"
                                        id="jawaban_bidang"
                                        class="form-control"
                                        rows="5"
                                        placeholder="Tuliskan hasil koordinasi, konsultasi, berkas yang diterima/diserahkan, atau arahan untuk tamu..."
                                        required
                                    >{{ old('jawaban_bidang', $kunjungan->jawaban_bidang) }}</textarea>
                                </div>

                                @if (in_array($status, ['baru', 'menunggu']))
                                    <div class="info-notice">
                                        <i class="fa-solid fa-circle-info" style="font-size: 16px;"></i>
                                        <span>Kunjungan masih berstatus baru. Silakan klik tombol <strong>Terima Kunjungan</strong> di panel sebelah kanan terlebih dahulu sebelum menyelesaikannya.</span>
                                    </div>
                                @else
                                    <button type="submit" class="btn-action-primary">
                                        <i class="fa-solid fa-circle-check"></i>
                                        <span>Simpan Jawaban &amp; Selesaikan Pelayanan</span>
                                    </button>
                                @endif
                            </form>
                        @else
                            @if (!empty($kunjungan->jawaban_bidang))
                                <div style="background: var(--color-status-selesai-bg); border-left: 3px solid #10b981; padding: 16px 20px; border-radius: 0 var(--radius-md) var(--radius-md) 0; font-size: 14px; line-height: 1.6; color: var(--color-status-selesai-text);">
                                    {{ $kunjungan->jawaban_bidang }}
                                </div>
                            @else
                                <div style="background: #fafcfb; border: 1px dashed var(--color-border); padding: 24px; text-align: center; color: var(--color-text-secondary); border-radius: var(--radius-md); font-size: 13px;">
                                    <i class="fa-regular fa-comment-slash" style="font-size: 24px; display: block; margin-bottom: 6px; opacity: 0.5;"></i>
                                    Belum ada catatan jawaban yang diinput oleh bidang terkait.
                                </div>
                            @endif
                        @endif
                    </section>

                </div>

                {{-- KOLOM KANAN: AKSI & ALIH BIDANG --}}
                <div class="right-col">

                    {{-- KOTAK AKSI UTAMA --}}
                    <section class="card">
                        <div class="card-header-styled" style="margin-bottom: 16px; padding-bottom: 12px;">
                            <div class="card-header-icon">
                                <i class="fa-solid fa-bolt"></i>
                            </div>
                            <div>
                                <h2>Tindakan Petugas</h2>
                                <p>Proses status pelayanan tamu.</p>
                            </div>
                        </div>

                        @if ($isPetugasBidang && in_array($status, ['baru', 'menunggu']))
                            <p class="action-card-desc">
                                Tamu telah mendaftar di meja lobi dan sedang menunggu. Klik tombol berikut untuk menerima kunjungan:
                            </p>

                            <form action="{{ route('kunjungan.terima', $kunjungan->id) }}" method="POST" style="margin-bottom: 14px;">
                                @csrf
                                <button type="submit" class="btn-action-primary">
                                    <i class="fa-solid fa-handshake"></i>
                                    <span>Terima Kunjungan Tamu</span>
                                </button>
                            </form>

                            <button type="button" class="btn-action-outline"
                                onclick="document.getElementById('jawaban_bidang')?.focus(); document.getElementById('cardJawaban')?.scrollIntoView({behavior:'smooth'});">
                                <i class="fa-regular fa-pen-to-square"></i>
                                <span>Lihat Form Jawaban</span>
                            </button>

                        @elseif ($isPetugasBidang && in_array($status, ['diterima', 'diproses']))
                            <p class="action-card-desc">
                                Kunjungan sedang Anda tangani. Silakan isi jawaban hasil pelayanan di kolom sebelah kiri, lalu simpan untuk menyelesaikan:
                            </p>

                            <button type="button" class="btn-action-primary"
                                onclick="document.getElementById('jawaban_bidang')?.focus(); document.getElementById('cardJawaban')?.scrollIntoView({behavior:'smooth'});">
                                <i class="fa-regular fa-circle-check"></i>
                                <span>Isi Jawaban &amp; Selesaikan</span>
                            </button>

                        @elseif ($status === 'selesai')
                            <div class="info-notice" style="background: var(--color-status-selesai-bg); border-color: #a7f3d0; color: var(--color-status-selesai-text);">
                                <i class="fa-solid fa-circle-check" style="font-size: 18px;"></i>
                                <div>
                                    <strong>Pelayanan Selesai</strong>
                                    <div>Kunjungan ini telah selesai diproses oleh bidang terkait.</div>
                                </div>
                            </div>

                        @elseif ($status === 'dialihkan')
                            <div class="info-notice" style="background: var(--color-status-dialihkan-bg); border-color: #e9d5ff; color: var(--color-status-dialihkan-text);">
                                <i class="fa-solid fa-share" style="font-size: 18px;"></i>
                                <div>
                                    <strong>Kunjungan Dialihkan</strong>
                                    <div>Kunjungan ini telah diteruskan ke bidang BKAD yang lain.</div>
                                </div>
                            </div>
                        @else
                            <div class="info-notice">
                                <i class="fa-solid fa-circle-info"></i>
                                <span>Anda memiliki hak akses untuk memantau detail kunjungan ini.</span>
                            </div>
                        @endif
                    </section>

                    {{-- ALIH BIDANG --}}
                    @if ($isPetugasBidang && !in_array($status, ['selesai', 'dialihkan']))
                        <section class="card">
                            <div class="card-header-styled" style="margin-bottom: 14px; padding-bottom: 12px;">
                                <div class="card-header-icon" style="background: var(--color-status-dialihkan-bg); color: var(--color-status-dialihkan-text);">
                                    <i class="fa-solid fa-arrow-right-arrow-left"></i>
                                </div>
                                <div>
                                    <h2>Alihkan ke Bidang Lain</h2>
                                    <p>Disposisikan tamu ke bidang yang sesuai.</p>
                                </div>
                            </div>

                            <p class="action-card-desc">
                                Jika konsultasi tamu lebih tepat ditangani oleh bidang lain, alihkan data ini:
                            </p>

                            @if (\Illuminate\Support\Facades\Route::has('kunjungan.alihkan'))
                                <form action="{{ route('kunjungan.alihkan', $kunjungan->id) }}" method="POST">
                                    @csrf

                                    <div style="margin-bottom: 12px;">
                                        <label for="bidang_tujuan_baru" class="form-label">Bidang Tujuan Baru <span style="color: var(--color-danger);">*</span></label>
                                        <select name="bidang_tujuan_id" id="bidang_tujuan_baru" class="form-control" required>
                                            <option value="">Pilih Bidang Tujuan...</option>
                                            @foreach (($bidangs ?? collect()) as $b)
                                                @if ($b->id != ($kunjungan->bidang_tujuan_id ?? null))
                                                    <option value="{{ $b->id }}" @selected(old('bidang_tujuan_id') == $b->id)>
                                                        {{ $b->nama }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <div style="margin-bottom: 16px;">
                                        <label for="catatan_pengalihan" class="form-label">Catatan Alasan Pengalihan</label>
                                        <textarea
                                            name="catatan_pengalihan"
                                            id="catatan_pengalihan"
                                            class="form-control"
                                            rows="3"
                                            placeholder="Tuliskan alasan pengalihan berkas/konsultasi..."
                                        >{{ old('catatan_pengalihan') }}</textarea>
                                    </div>

                                    <button
                                        type="submit"
                                        class="btn-action-purple"
                                        onclick="return confirm('Apakah Anda yakin ingin mengalihkan kunjungan ini ke bidang terpilih?')"
                                    >
                                        <i class="fa-solid fa-share"></i>
                                        <span>Konfirmasi Alihkan Bidang</span>
                                    </button>
                                </form>
                            @endif
                        </section>
                    @endif

                </div>

            </div>

            <div class="footer-note">
                &copy; {{ date('Y') }} BKAD Kabupaten Tapin &bull; SIKUTA (Sistem Informasi Kunjungan Tamu)
            </div>

        </main>
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
