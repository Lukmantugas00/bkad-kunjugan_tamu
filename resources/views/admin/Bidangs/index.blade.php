<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Bidang - SIKUTA BKAD Kabupaten Tapin</title>

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
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 14px;
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
            width: 76px;
            height: 76px;
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

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* CONTENT */
        .content {
            padding: 28px 32px;
            flex: 1;
        }

        /* BUTTONS */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: var(--radius-md);
            font-size: 13px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: var(--color-primary);
            color: #ffffff;
            box-shadow: 0 2px 6px rgba(7, 133, 119, 0.2);
        }

        .btn-primary:hover {
            background: var(--color-primary-hover);
        }

        /* ALERTS */
        .alert {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            border-radius: var(--radius-md);
            font-size: 13px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: var(--color-success-light);
            color: var(--color-success);
            border: 1px solid #bbf7d0;
        }

        .alert-danger {
            background: var(--color-danger-light);
            color: var(--color-danger);
            border: 1px solid #fecaca;
        }

        /* CARD & TABLE */
        .card {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .card-header {
            padding: 18px 24px;
            border-bottom: 1px solid var(--color-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            background: #fafcfb;
        }

        .card-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--color-text);
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
            padding: 14px 20px;
            border-bottom: 1px solid var(--color-border);
        }

        td {
            padding: 14px 20px;
            font-size: 13px;
            color: var(--color-text);
            border-bottom: 1px solid #edf2f0;
            vertical-align: middle;
        }

        tr:hover td {
            background: #fbfdfc;
        }

        /* BADGES */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
        }

        .badge-kode {
            background: var(--color-primary-light);
            color: var(--color-primary-dark);
            font-family: monospace;
            font-size: 12px;
            padding: 4px 8px;
            border-radius: var(--radius-sm);
            font-weight: 700;
            border: 1px solid #c2e9de;
        }

        .badge-aktif { background: #D1FAE5; color: #065F46; }
        .badge-nonaktif { background: #FEE2E2; color: #991B1B; }

        .actions-cell {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-edit {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #ffffff;
            color: var(--color-primary);
            border: 1px solid var(--color-primary);
            padding: 6px 12px;
            border-radius: var(--radius-sm);
            font-size: 12px;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-edit:hover {
            background: var(--color-primary-light);
        }

        .btn-toggle-deactivate {
            background: #fff;
            color: var(--color-danger);
            border: 1px solid var(--color-danger);
            padding: 6px 12px;
            border-radius: var(--radius-sm);
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-toggle-deactivate:hover {
            background: var(--color-danger-light);
        }

        .btn-toggle-activate {
            background: #fff;
            color: var(--color-success);
            border: 1px solid var(--color-success);
            padding: 6px 12px;
            border-radius: var(--radius-sm);
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-toggle-activate:hover {
            background: var(--color-success-light);
        }

        .empty-state {
            text-align: center;
            padding: 48px 20px;
            color: var(--color-text-secondary);
        }

        .empty-state i {
            font-size: 40px;
            color: #cbd5e1;
            margin-bottom: 12px;
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

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
            .btn-menu-mobile { display: flex; }
            .topbar { padding: 0 16px; }
            .content { padding: 20px 16px; }
            .card-header { flex-direction: column; align-items: flex-start; }
            .actions-cell { flex-direction: column; align-items: flex-start; }
        }

        @media (prefers-reduced-motion: reduce) {
            * { transition: none !important; animation: none !important; transform: none !important; }
        }
</style>
</head>
<body>

    {{-- SIDEBAR --}}
    @include('partials.sidebar', ['active' => 'bidangs'])

    {{-- MAIN CONTENT --}}
    <div class="main-wrapper">

        {{-- TOPBAR --}}
        <header class="topbar">
            <div class="topbar-left">
                <button type="button" class="btn-menu-mobile" id="mobileMenuToggle" aria-label="Menu navigasi">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div class="topbar-title">
                    <h1>Master Bidang BKAD</h1>
                    <p>Kelola data bagian, bidang, dan unit tujuan layanan di BKAD Kabupaten Tapin</p>
                </div>
            </div>

            <div class="topbar-right">
                <a href="{{ route('admin.bidangs.create') }}" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i>
                    <span>Tambah Bidang</span>
                </a>
            </div>
        </header>

        {{-- CONTENT BODY --}}
        <main class="content">

            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <div>
                        <div style="font-weight: 700; margin-bottom: 4px;">Terjadi kesalahan:</div>
                        <ul style="margin-left: 20px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fa-solid fa-sitemap" style="color: var(--color-primary);"></i>
                        <span>Daftar Unit Bidang ({{ $bidangs->count() }})</span>
                    </div>
                </div>

                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th style="width: 140px;">Kode Bidang</th>
                                <th>Nama Bidang / Unit</th>
                                <th style="width: 130px;">Status</th>
                                <th style="width: 180px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($bidangs as $bidang)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="badge-kode">{{ $bidang->kode }}</span>
                                    </td>
                                    <td>
                                        <strong style="color: var(--color-text); font-size: 14px;">{{ $bidang->nama }}</strong>
                                    </td>
                                    <td>
                                        @if ($bidang->aktif)
                                            <span class="badge badge-aktif">
                                                <i class="fa-solid fa-circle-check"></i> Aktif
                                            </span>
                                        @else
                                            <span class="badge badge-nonaktif">
                                                <i class="fa-solid fa-circle-xmark"></i> Nonaktif
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="actions-cell">
                                            <a href="{{ route('admin.bidangs.edit', $bidang) }}" class="btn-edit" title="Edit Bidang">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                                <span>Edit</span>
                                            </a>

                                            <form method="POST" action="{{ route('admin.bidangs.toggleAktif', $bidang) }}" onsubmit="return confirm('{{ $bidang->aktif ? 'Apakah Anda yakin ingin menonaktifkan bidang ini?' : 'Aktifkan kembali bidang ini?' }}');">
                                                @csrf
                                                @method('PATCH')

                                                @if ($bidang->aktif)
                                                    <button type="submit" class="btn-toggle-deactivate" title="Nonaktifkan bidang">
                                                        <i class="fa-solid fa-ban"></i>
                                                        <span>Nonaktif</span>
                                                    </button>
                                                @else
                                                    <button type="submit" class="btn-toggle-activate" title="Aktifkan bidang">
                                                        <i class="fa-solid fa-check"></i>
                                                        <span>Aktifkan</span>
                                                    </button>
                                                @endif
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <div class="empty-state">
                                            <i class="fa-solid fa-building-circle-exclamation"></i>
                                            <p>Belum ada data bidang layanan yang terdaftar.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
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

