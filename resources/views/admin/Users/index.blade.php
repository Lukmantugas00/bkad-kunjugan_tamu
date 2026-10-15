<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Akun Pengguna - SIKUTA BKAD Kabupaten Tapin</title>

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

        .btn-secondary {
            background: #ffffff;
            color: var(--color-text);
            border: 1px solid var(--color-border);
        }

        .btn-secondary:hover {
            background: var(--color-bg);
            border-color: #cbd5e1;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
            border-radius: var(--radius-sm);
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
            border: 1px solid transparent;
        }

        .alert-success {
            background: var(--color-success-light);
            color: var(--color-success);
            border-color: #bbf7d0;
        }

        .alert-danger {
            background: var(--color-danger-light);
            color: var(--color-danger);
            border-color: #fecaca;
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
            white-space: nowrap;
        }

        .badge-admin { background: #EEF2FF; color: #4338CA; }
        .badge-petugas { background: #E0E7FF; color: #3730A3; }
        .badge-penerima { background: var(--color-primary-light); color: var(--color-primary-dark); }
        .badge-pimpinan { background: #FEF3C7; color: #92400E; }
        .badge-default { background: #F1F5F9; color: #475569; }

        .badge-aktif { background: #D1FAE5; color: #065F46; }
        .badge-nonaktif { background: #FEE2E2; color: #991B1B; }

        .user-name-cell {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .user-name {
            font-weight: 700;
            color: var(--color-text);
        }

        .badge-self {
            display: inline-block;
            font-size: 10px;
            background: #E0F2FE;
            color: #0369A1;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: 600;
            width: fit-content;
        }

        .actions-cell {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 8px;
            flex-wrap: nowrap;
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

        .btn-action-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: var(--radius-sm);
            border: 1px solid transparent;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-toggle-deactivate {
            background: #fff;
            color: var(--color-danger);
            border-color: var(--color-danger);
        }

        .btn-toggle-deactivate:hover {
            background: var(--color-danger-light);
        }

        .btn-toggle-activate {
            background: #fff;
            color: var(--color-success);
            border-color: var(--color-success);
        }

        .btn-toggle-activate:hover {
            background: var(--color-success-light);
        }

        .btn-delete {
            background: #fff;
            color: var(--color-danger);
            border-color: var(--color-danger);
        }

        .btn-delete:hover {
            background: var(--color-danger-light);
        }

        /* MODAL */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(16, 63, 60, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            padding: 20px;
        }

        .modal-overlay.open {
            display: flex;
        }

        .modal {
            background: var(--color-surface);
            border-radius: var(--radius-lg);
            box-shadow: 0 20px 40px rgba(16, 63, 60, 0.2);
            max-width: 440px;
            width: 100%;
            overflow: hidden;
            animation: modalIn 0.2s ease;
        }

        @keyframes modalIn {
            from { opacity: 0; transform: translateY(-10px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .modal-header {
            padding: 18px 24px;
            border-bottom: 1px solid var(--color-border);
            background: var(--color-danger-light);
        }

        .modal-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--color-danger);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .modal-body {
            padding: 24px;
        }

        .modal-user-info {
            background: var(--color-bg);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
            padding: 16px;
            margin-bottom: 16px;
        }

        .modal-user-info-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            font-size: 13px;
        }

        .modal-user-info-row:not(:last-child) {
            border-bottom: 1px solid var(--color-border);
        }

        .modal-user-info-label {
            color: var(--color-text-secondary);
            font-weight: 500;
        }

        .modal-user-info-value {
            color: var(--color-text);
            font-weight: 600;
            text-align: right;
            max-width: 65%;
            word-break: break-word;
        }

        .modal-warning {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 12px 14px;
            background: var(--color-warning-light);
            border: 1px solid #fcd34d;
            border-radius: var(--radius-md);
            font-size: 12px;
            color: #92400e;
            line-height: 1.5;
        }

        .modal-warning i {
            flex-shrink: 0;
            margin-top: 2px;
        }

        .modal-footer {
            padding: 16px 24px;
            border-top: 1px solid var(--color-border);
            background: #fafcfb;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        /* FILTER CARD (matches Laporan page) */
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
            grid-template-columns: 2fr 1fr 1fr auto;
            gap: 16px;
            align-items: end;
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
            height: 48px;
            padding: 0 16px;
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
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        /* BUTTONS */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 9px 16px;
            border-radius: var(--radius-md);
            font-size: 12px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            white-space: nowrap;
            text-decoration: none;
            height: 48px;
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

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
            border-radius: var(--radius-sm);
            height: auto;
        }

        .select-wrapper {
            position: relative;
        }

        .select-wrapper select.form-control {
            appearance: none;
            padding-right: 44px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23718784' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
        }

        .select-wrapper .select-icon {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--color-text-secondary);
            font-size: 14px;
            pointer-events: none;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--color-text-secondary);
            font-size: 14px;
            pointer-events: none;
        }

        .input-wrapper input.form-control {
            padding-left: 44px;
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

        @media (max-width: 1024px) {
            .filter-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 640px) {
            .filter-grid {
                grid-template-columns: 1fr;
            }
            .filter-actions {
                flex-direction: column;
                width: 100%;
            }
            .filter-actions .btn {
                width: 100%;
            }
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
    @include('partials.sidebar', ['active' => 'users'])

    {{-- MAIN CONTENT --}}
    <div class="main-wrapper">

        {{-- TOPBAR --}}
        <header class="topbar">
            <div class="topbar-left">
                <button type="button" class="btn-menu-mobile" id="mobileMenuToggle" aria-label="Menu navigasi">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div class="topbar-title">
                    <h1>Kelola Akun Pengguna</h1>
                    <p>Manajemen hak akses, role petugas piket, penerima bidang, dan pimpinan</p>
                </div>
            </div>

            <div class="topbar-right">
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                    <i class="fa-solid fa-user-plus"></i>
                    <span>Tambah Akun</span>
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

            @if (session('error'))
                <div class="alert alert-danger">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fa-solid fa-users-gear" style="color: var(--color-primary);"></i>
                        <span>Daftar Pengguna Sistem ({{ $users->total() }})</span>
                    </div>
                </div>

                {{-- FILTER CARD (matches Laporan page) --}}
                <div class="card-filter">
                    <div class="filter-header">
                        <h3>
                            <i class="fa-solid fa-sliders"></i>
                            <span>Filter Pengguna</span>
                        </h3>
                        <span>Cari dan saring daftar pengguna</span>
                    </div>

                    <form method="GET" action="{{ route('admin.users.index') }}">
                        <div class="filter-grid">
                            <div class="form-group">
                                <label for="search">Cari Pengguna (NIP, Nama, atau Role)</label>
                                <div class="input-wrapper">
                                    <input
                                        type="text"
                                        id="search"
                                        name="search"
                                        class="form-control"
                                        placeholder="Cari NIP, Nama, atau Role..."
                                        value="{{ request('search') }}"
                                    >
                                    <span class="input-icon"><i class="fa-solid fa-magnifying-glass"></i></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="role">Role</label>
                                <div class="select-wrapper">
                                    <select id="role" name="role" class="form-control">
                                        <option value="">Semua Role</option>
                                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="petugas_piket" {{ request('role') === 'petugas_piket' ? 'selected' : '' }}>Petugas Piket</option>
                                        <option value="penerima_bidang" {{ request('role') === 'penerima_bidang' ? 'selected' : '' }}>Penerima Bidang</option>
                                        <option value="pimpinan" {{ request('role') === 'pimpinan' ? 'selected' : '' }}>Pimpinan</option>
                                    </select>
                                    <span class="select-icon"><i class="fa-solid fa-user-tag"></i></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="bidang_id">Bidang</label>
                                <div class="select-wrapper">
                                    <select id="bidang_id" name="bidang_id" class="form-control">
                                        <option value="">Semua Bidang</option>
                                        @foreach ($bidangs as $bidang)
                                            <option value="{{ $bidang->id }}" {{ request('bidang_id') == $bidang->id ? 'selected' : '' }}>
                                                {{ $bidang->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="select-icon"><i class="fa-solid fa-building"></i></span>
                                </div>
                            </div>

                            <div class="filter-actions">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa-solid fa-filter"></i>
                                    <span>Terapkan</span>
                                </button>

                                @if (request()->hasAny(['search', 'role', 'bidang_id']))
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                        <i class="fa-solid fa-rotate-left"></i>
                                        <span>Reset</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>NIP</th>
                                <th>Nama Lengkap</th>
                                <th style="min-width: 170px;">Hak Akses / Role</th>
                                <th>Unit / Bidang</th>
                                <th>Status</th>
                                <th style="width: 140px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><code style="font-family: inherit; font-weight: 600; color: #334155;">{{ $user->nip }}</code></td>
                                    <td>
                                        <div class="user-name-cell">
                                            <span class="user-name">{{ $user->name }}</span>
                                            @if ($user->id === auth()->id())
                                                <span class="badge-self">
                                                    <i class="fa-solid fa-user-check"></i> Akun Anda
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @switch($user->role)
                                            @case('admin')
                                                <span class="badge badge-admin">
                                                    <i class="fa-solid fa-shield-halved"></i> Admin
                                                </span>
                                                @break
                                            @case('petugas_piket')
                                                <span class="badge badge-petugas">
                                                    <i class="fa-solid fa-desktop"></i> Petugas Piket
                                                </span>
                                                @break
                                            @case('penerima_bidang')
                                                <span class="badge badge-penerima">
                                                    <i class="fa-solid fa-briefcase"></i> Penerima Bidang
                                                </span>
                                                @break
                                            @case('pimpinan')
                                                <span class="badge badge-pimpinan">
                                                    <i class="fa-solid fa-user-tie"></i> Pimpinan
                                                </span>
                                                @break
                                            @default
                                                <span class="badge badge-default">{{ $user->role }}</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        @if ($user->bidang)
                                            <span style="font-weight: 500;">{{ $user->bidang->nama }}</span>
                                        @else
                                            <span style="color: var(--color-text-secondary);">&mdash;</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($user->aktif)
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
                                             <a href="{{ route('admin.users.edit', $user) }}" class="btn-edit" title="Edit Akun">
                                                 <i class="fa-solid fa-pen-to-square"></i>
                                                 <span>Edit</span>
                                             </a>

                                             @if ($user->id !== auth()->id())
                                                 <form method="POST" action="{{ route('admin.users.toggleAktif', $user) }}" onsubmit="return confirm('{{ $user->aktif ? 'Apakah Anda yakin ingin menonaktifkan akun ini?' : 'Aktifkan kembali akun ini?' }}');">
                                                     @csrf
                                                     @method('PATCH')

                                                     @if ($user->aktif)
                                                         <button type="submit" class="btn-action-icon btn-toggle-deactivate" title="Nonaktifkan akun" aria-label="Nonaktifkan akun">
                                                             <i class="fa-solid fa-ban"></i>
                                                         </button>
                                                     @else
                                                         <button type="submit" class="btn-action-icon btn-toggle-activate" title="Aktifkan akun" aria-label="Aktifkan akun">
                                                             <i class="fa-solid fa-check"></i>
                                                         </button>
                                                     @endif
                                                  </form>

                                                  <button type="button" class="btn-action-icon btn-delete" title="Hapus akun permanen" aria-label="Hapus akun permanen" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}" data-user-nip="{{ $user->nip }}" data-user-role="{{ $user->role }}" data-delete-url="{{ route('admin.users.destroy', $user) }}">
                                                      <i class="fa-solid fa-trash"></i>
                                                  </button>



                                             @endif
                                         </div>
                                     </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="empty-state">
                                            <i class="fa-solid fa-user-slash"></i>
                                            @if (request()->hasAny(['search', 'role', 'bidang_id']))
                                                <p>Akun pengguna tidak ditemukan.</p>
                                            @else
                                                <p>Belum ada data pengguna yang terdaftar.</p>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION --}}
                @if ($users->hasPages())
                    <div class="pagination-wrapper" style="justify-content: flex-end;">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>

        </main>

        {{-- FOOTER --}}
        <footer class="footer">
            <div>&copy; {{ date('Y') }} BKAD Kabupaten Tapin &bull; SIKUTA (Sistem Informasi Kunjungan Tamu)</div>
        </footer>

    </div>

     {{-- MODAL KONFIRMASI HAPUS AKUN --}}
     <div class="modal-overlay" id="deleteModal" role="dialog" aria-modal="true" aria-labelledby="deleteModalTitle">
         <div class="modal">
             <div class="modal-header">
                 <div class="modal-title" id="deleteModalTitle">
                     <i class="fa-solid fa-triangle-exclamation"></i>
                     <span>Konfirmasi Hapus Akun</span>
                 </div>
             </div>
             <div class="modal-body">
                 <p style="margin-bottom: 16px; font-size: 13px; color: var(--color-text);">
                     Apakah Anda yakin ingin menghapus akun ini secara permanen? Tindakan ini <strong>tidak dapat dibatalkan</strong>.
                 </p>

                 <div class="modal-user-info" id="deleteUserInfo">
                     <div class="modal-user-info-row">
                         <span class="modal-user-info-label">Nama Lengkap</span>
                         <span class="modal-user-info-value" id="deleteUserName">-</span>
                     </div>
                     <div class="modal-user-info-row">
                         <span class="modal-user-info-label">NIP</span>
                         <span class="modal-user-info-value" id="deleteUserNip">-</span>
                     </div>
                     <div class="modal-user-info-row">
                         <span class="modal-user-info-label">Role / Hak Akses</span>
                         <span class="modal-user-info-value" id="deleteUserRole">-</span>
                     </div>
                 </div>

                 <div class="modal-warning">
                     <i class="fa-solid fa-circle-exclamation"></i>
                     <span>
                         <strong>Perhatian:</strong> Penghapusan akan menghapus akun login pengguna.
                         Log aktivitas yang terkait akan tetap tersimpan (dengan identitas pengguna dikosongkan).
                         Data kunjungan dan laporan tidak terhapus karena tidak terikat langsung pada akun pengguna.
                     </span>
                 </div>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" id="deleteModalCancel">
                     <i class="fa-solid fa-xmark"></i>
                     <span>Batal</span>
                 </button>
                 <form id="deleteForm" method="POST" style="display: inline;">
                     @csrf
                     @method('DELETE')
                     <button type="submit" class="btn" style="background: var(--color-danger); color: #fff; box-shadow: 0 2px 6px rgba(220, 38, 38, 0.2);" id="deleteModalConfirm">
                         <i class="fa-solid fa-trash"></i>
                         <span>Hapus Permanen</span>
                     </button>
                 </form>
             </div>
         </div>
     </div>

      {{-- MODAL KONFIRMASI RESET PASSWORD --}}
      <div class="modal-overlay" id="resetPasswordModal" role="dialog" aria-modal="true" aria-labelledby="resetPasswordModalTitle">
          <div class="modal">
              <div class="modal-header">
                  <div class="modal-title" id="resetPasswordModalTitle">
                      <i class="fa-solid fa-triangle-exclamation"></i>
                      <span>Konfirmasi Reset Password</span>
                  </div>
              </div>
              <div class="modal-body">
                  <p style="margin-bottom: 16px; font-size: 13px; color: var(--color-text);">
                      Apakah Anda yakin ingin mereset password akun ini? Password akan diganti dengan password sementara.
                      Pengguna harus mengganti password saat login berikutnya.
                  </p>

                  <div class="modal-user-info" id="resetPasswordUserInfo">
                      <div class="modal-user-info-row">
                          <span class="modal-user-info-label">Nama Lengkap</span>
                          <span class="modal-user-info-value" id="resetPasswordUserName">-</span>
                      </div>
                      <div class="modal-user-info-row">
                          <span class="modal-user-info-label">NIP</span>
                          <span class="modal-user-info-value" id="resetPasswordUserNip">-</span>
                      </div>
                      <div class="modal-user-info-row">
                          <span class="modal-user-info-label">Role / Hak Akses</span>
                          <span class="modal-user-info-value" id="resetPasswordUserRole">-</span>
                      </div>
                  </div>

                  <div class="modal-warning">
                      <i class="fa-solid fa-circle-exclamation"></i>
                      <span>
                          <strong>Perhatian:</strong> Password sementara akan ditampilkan sekali setelah reset.
                          Catat sekarang, karena tidak akan ditampilkan lagi.
                      </span>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" id="resetPasswordModalCancel">
                      <i class="fa-solid fa-xmark"></i>
                      <span>Batal</span>
                  </button>
                  <form id="resetPasswordForm" method="POST" style="display: inline;">
                      @csrf
                      @method('PUT')
                      <button type="submit" class="btn" style="background: var(--color-primary); color: #fff; box-shadow: 0 2px 6px rgba(7, 133, 119, 0.2);" id="resetPasswordModalConfirm">
                          <i class="fa-solid fa-key"></i>
                          <span>Reset Password</span>
                      </button>
                  </form>
              </div>
          </div>
      </div>

      {{-- MODAL TAMPILKAN PASSWORD Sementara --}}
      <div class="modal-overlay" id="tempPasswordModal" role="dialog" aria-modal="true" aria-labelledby="tempPasswordModalTitle">
          <div class="modal">
              <div class="modal-header">
                  <div class="modal-title" id="tempPasswordModalTitle">
                      <i class="fa-solid fa-key"></i>
                      <span>Password Sementara</span>
                  </div>
              </div>
              <div class="modal-body">
                  <p style="margin-bottom: 16px; font-size: 13px; color: var(--color-text);">
                      Password sementara untuk akun <strong id="tempPasswordUserName"></strong> (NIP <strong id="tempPasswordUserNip"></strong>) adalah:
                  </p>

                  <div class="input-group" style="margin-bottom: 16px;">
                      <input type="text" id="tempPasswordValue" class="form-control" readonly>
                      <button type="button" class="btn btn-sm btn-primary" id="copyTempPassword">
                          <i class="fa-solid fa-copy"></i> Salin
                      </button>
                  </div>

                  <div class="modal-warning">
                      <i class="fa-solid fa-circle-exclamation"></i>
                      <span>
                          <strong>Catat sekarang, password tidak akan ditampilkan lagi.</strong>
                      </span>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" id="tempPasswordModalClose">
                      <i class="fa-solid fa-check"></i>
                      <span>Tutup</span>
                  </button>
              </div>
          </div>
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

              // Modal Hapus Akun
              const deleteModal = document.getElementById('deleteModal');
              const deleteForm = document.getElementById('deleteForm');
              const deleteModalCancel = document.getElementById('deleteModalCancel');
              const deleteUserName = document.getElementById('deleteUserName');
              const deleteUserNip = document.getElementById('deleteUserNip');
              const deleteUserRole = document.getElementById('deleteUserRole');

              // Buka modal saat tombol Hapus diklik
              document.querySelectorAll('.btn-delete').forEach(button => {
                  button.addEventListener('click', function () {
                      const userId = this.dataset.userId;
                      const userName = this.dataset.userName;
                      const userNip = this.dataset.userNip;
                      const userRole = this.dataset.userRole;
                      const deleteUrl = this.dataset.deleteUrl;

                      // Isi informasi user
                      deleteUserName.textContent = userName;
                      deleteUserNip.textContent = userNip;

                      // Format role untuk tampilan
                      const roleLabels = {
                          'admin': 'Admin',
                          'petugas_piket': 'Petugas Piket',
                          'penerima_bidang': 'Penerima Bidang',
                          'pimpinan': 'Pimpinan'
                      };
                      deleteUserRole.textContent = roleLabels[userRole] || userRole;

                      // Set action form
                      deleteForm.action = deleteUrl;

                      // Tampilkan modal
                      deleteModal.classList.add('open');
                  });
              });

              // Tutup modal
              function closeDeleteModal() {
                  deleteModal.classList.remove('open');
              }

              deleteModalCancel.addEventListener('click', closeDeleteModal);
              deleteModal.addEventListener('click', function (e) {
                  if (e.target === deleteModal) {
                      closeDeleteModal();
                  }
              });

              // Tutup modal dengan Escape
              document.addEventListener('keydown', function (e) {
                  if (e.key === 'Escape' && deleteModal.classList.contains('open')) {
                      closeDeleteModal();
                  }
              });

              // Modal Reset Password
              const resetPasswordModal = document.getElementById('resetPasswordModal');
              const resetPasswordForm = document.getElementById('resetPasswordForm');
              const resetPasswordModalCancel = document.getElementById('resetPasswordModalCancel');
              const resetPasswordUserName = document.getElementById('resetPasswordUserName');
              const resetPasswordUserNip = document.getElementById('resetPasswordUserNip');
              const resetPasswordUserRole = document.getElementById('resetPasswordUserRole');

              // Buka modal saat tombol Reset Password diklik
              document.querySelectorAll('.btn-reset-password').forEach(button => {
                  button.addEventListener('click', function () {
                      const userId = this.dataset.userId;
                      const userName = this.dataset.userName;
                      const userNip = this.dataset.userNip;
                      const userRole = this.dataset.userRole;
                      const resetUrl = this.dataset.resetUrl;

                      // Isi informasi user
                      resetPasswordUserName.textContent = userName;
                      resetPasswordUserNip.textContent = userNip;


                      // Format role untuk tampilan
                      const roleLabels = {
                          'admin': 'Admin',
                          'petugas_piket': 'Petugas Piket',
                          'penerima_bidang': 'Penerima Bidang',
                          'pimpinan': 'Pimpinan'
                      };
                      resetPasswordUserRole.textContent = roleLabels[userRole] || userRole;

                      // Set action form
                      resetPasswordForm.action = resetUrl;

                      // Tampilkan modal
                      resetPasswordModal.classList.add('open');
                  });
              });

              // Tutup modal
              function closeResetPasswordModal() {
                  resetPasswordModal.classList.remove('open');
              }

              resetPasswordModalCancel.addEventListener('click', closeResetPasswordModal);
              resetPasswordModal.addEventListener('click', function (e) {
                  if (e.target === resetPasswordModal) {
                      closeResetPasswordModal();
                  }
              });

              document.addEventListener('keydown', function (e) {
                  if (e.key === 'Escape' && resetPasswordModal.classList.contains('open')) {
                      closeResetPasswordModal();
                  }
              });

              // Modal Password Sementara
              const tempPasswordModal = document.getElementById('tempPasswordModal');
              const tempPasswordModalClose = document.getElementById('tempPasswordModalClose');
              const copyTempPassword = document.getElementById('copyTempPassword');
              const tempPasswordUserName = document.getElementById('tempPasswordUserName');
              const tempPasswordUserNip = document.getElementById('tempPasswordUserNip');
              const tempPasswordValue = document.getElementById('tempPasswordValue');

              // Tampilkan modal password sementara jika ada flash session
              @if (session('temp_password'))
                  tempPasswordUserName.textContent = "{{ session('temp_user_name') }}";
                  tempPasswordUserNip.textContent = "{{ session('temp_user_nip') }}";
                  tempPasswordValue.value = "{{ session('temp_password') }}";
                  tempPasswordModal.classList.add('open');
              @endif

              // Salin password ke clipboard
              copyTempPassword.addEventListener('click', function () {
                  tempPasswordValue.select();
                  document.execCommand('copy');
                  // Berikan feedback visual
                  const originalText = this.innerHTML;
                  this.innerHTML = '<i class="fa-solid fa-check"></i> Disalin';
                  setTimeout(() => {
                      this.innerHTML = originalText;
                  }, 2000);
              });

              // Tutup modal
              function closeTempPasswordModal() {
                  tempPasswordModal.classList.remove('open');
              }

              tempPasswordModalClose.addEventListener('click', closeTempPasswordModal);
              tempPasswordModal.addEventListener('click', function (e) {
                  if (e.target === tempPasswordModal) {
                      closeTempPasswordModal();
                  }
              });

              document.addEventListener('keydown', function (e) {
                  if (e.key === 'Escape' && tempPasswordModal.classList.contains('open')) {
                      closeTempPasswordModal();
                  }
              });
          });
      </script>
  </body>
</html>
