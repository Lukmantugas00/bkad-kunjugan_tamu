<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SIKUTA BKAD Kabupaten Tapin</title>

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

        .admin-pill {
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
            max-width: 1300px;
            width: 100%;
            margin: 0 auto;
        }

        /* Welcome Banner */
        .welcome-card {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-left: 4px solid var(--color-primary);
            border-radius: var(--radius-xl);
            padding: 24px 28px;
            margin-bottom: 28px;
            box-shadow: var(--shadow-sm);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .welcome-info h2 {
            font-size: 20px;
            font-weight: 800;
            color: var(--color-primary-dark);
            margin-bottom: 4px;
        }

        .welcome-info p {
            font-size: 13px;
            color: var(--color-text-secondary);
            line-height: 1.5;
        }

        /* Menu Grid */
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 22px;
        }

        .menu-card {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-xl);
            padding: 26px;
            display: flex;
            flex-direction: column;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: var(--shadow-sm);
            position: relative;
            overflow: hidden;
        }

        .menu-card::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: var(--color-primary);
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .menu-card:hover {
            transform: translateY(-4px);
            border-color: var(--color-primary);
            box-shadow: var(--shadow-md);
        }

        .menu-card:hover::before {
            opacity: 1;
        }

        .menu-card-icon {
            width: 52px;
            height: 52px;
            border-radius: var(--radius-md);
            background: var(--color-primary-light);
            color: var(--color-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-bottom: 18px;
        }

        .menu-card h3 {
            font-size: 17px;
            font-weight: 800;
            color: var(--color-primary-dark);
            margin-bottom: 8px;
        }

        .menu-card p {
            font-size: 13px;
            color: var(--color-text-secondary);
            line-height: 1.5;
            margin-bottom: 20px;
            flex: 1;
        }

        .menu-card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 14px;
            border-top: 1px solid var(--color-border);
            font-size: 13px;
            font-weight: 700;
            color: var(--color-primary);
        }

        .menu-card:hover .menu-card-footer i {
            transform: translateX(4px);
        }

        .menu-card-footer i {
            transition: transform 0.2s ease;
        }

        /* Footer */
        .footer {
            margin-top: auto;
            border-top: 1px solid var(--color-border);
            background: var(--color-surface);
            padding: 18px 32px;
            text-align: center;
            font-size: 12px;
            color: var(--color-text-secondary);
        }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
            .btn-menu-mobile { display: flex; }
            .topbar { padding: 0 16px; }
            .content { padding: 20px 16px; }
            .welcome-card { flex-direction: column; align-items: flex-start; }
            .menu-grid { grid-template-columns: 1fr; }
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
                <i class="fa-solid fa-building-columns"></i>
            </div>
            <div>
                <div class="brand-title">SIKUTA</div>
                <div class="brand-sub">BKAD KABUPATEN TAPIN</div>
            </div>
        </div>

        <nav class="menu-list">
            <a href="{{ route('admin.dashboard') }}" class="menu-link active">
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

            <a href="{{ route('admin.activity_logs.index') }}" class="menu-link">
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
                    <h1>Dashboard Administrator</h1>
                    <p>Pusat kendali dan pengelolaan sistem informasi kunjungan tamu</p>
                </div>
            </div>

            <div class="admin-pill">
                <i class="fa-solid fa-shield-halved"></i>
                <span>Mode Administrator</span>
            </div>
        </header>

        {{-- CONTENT --}}
        <main class="content">

            {{-- Welcome Card --}}
            <div class="welcome-card">
                <div class="welcome-info">
                    <h2>Selamat datang, {{ auth()->user()->name }}!</h2>
                    <p>Anda memiliki hak akses penuh untuk mengelola pengguna, memelihara master bidang, mengoreksi data kunjungan, dan mencetak laporan rekapitulasi.</p>
                </div>
            </div>

            {{-- Navigation Cards Grid --}}
            <div class="menu-grid">

                <a href="{{ route('admin.users.index') }}" class="menu-card">
                    <div class="menu-card-icon">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <h3>Kelola Akun Pengguna</h3>
                    <p>Manajemen akun pegawai, penugasan hak akses role (Petugas Piket, Penerima Bidang, Pimpinan), dan status aktifasi akun.</p>
                    <div class="menu-card-footer">
                        <span>Buka Kelola Akun</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </a>

                <a href="{{ route('admin.bidangs.index') }}" class="menu-card">
                    <div class="menu-card-icon">
                        <i class="fa-solid fa-building"></i>
                    </div>
                    <h3>Master Bidang BKAD</h3>
                    <p>Kelola daftar bidang atau unit kerja di lingkungan BKAD Kabupaten Tapin beserta kode dan status keaktifan layanan.</p>
                    <div class="menu-card-footer">
                        <span>Buka Master Bidang</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </a>

                <a href="{{ route('admin.kunjungan.index') }}" class="menu-card">
                    <div class="menu-card-icon">
                        <i class="fa-solid fa-clipboard-list"></i>
                    </div>
                    <h3>Data Kunjungan Tamu</h3>
                    <p>Monitoring menyeluruh, koreksi data, pencarian multi-parameter, dan audit riwayat seluruh kunjungan tamu dinas.</p>
                    <div class="menu-card-footer">
                        <span>Buka Data Kunjungan</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </a>

                <a href="{{ route('admin.laporan.index') }}" class="menu-card">
                    <div class="menu-card-icon">
                        <i class="fa-solid fa-chart-pie"></i>
                    </div>
                    <h3>Laporan &amp; Rekapitulasi</h3>
                    <p>Rekapitulasi statistik kunjungan berdasarkan rentang tanggal dan bidang, serta ekspor dokumen format PDF dan CSV.</p>
                    <div class="menu-card-footer">
                        <span>Buka Laporan</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </a>

                <a href="{{ route('admin.activity_logs.index') }}" class="menu-card">
                    <div class="menu-card-icon">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                    <h3>Log Aktivitas Sistem</h3>
                    <p>Audit trail dan riwayat aksi pengguna mulai dari pendaftaran kunjungan, penerimaan, penyelesaian, hingga pengalihan.</p>
                    <div class="menu-card-footer">
                        <span>Buka Log Aktivitas</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </a>

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
