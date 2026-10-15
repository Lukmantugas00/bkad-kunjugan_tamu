<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kunjungan Tamu - SIKUTA BKAD Kabupaten Tapin</title>

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
            --color-warning-light: #FFF0D8;
            --color-success: #065F46;
            --color-success-light: #D1FAE5;
            --color-info: #1E40AF;
            --color-info-light: #DBEAFE;
            --color-purple: #6B21A8;
            --color-purple-light: #F0E8FB;
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
            padding: 9px 16px;
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

        /* ALERT */
        .alert-success {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            border-radius: var(--radius-md);
            font-size: 13px;
            margin-bottom: 20px;
            background: var(--color-success-light);
            color: var(--color-success);
            border: 1px solid #bbf7d0;
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
            gap: 8px;
            font-size: 14px;
            font-weight: 700;
            color: var(--color-primary-dark);
            margin-bottom: 16px;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: 2fr 1.2fr 1fr 1fr 1fr;
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

        .form-group input,
        .form-group select {
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

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(7, 133, 119, 0.15);
        }

        .filter-actions {
            display: flex;
            gap: 10px;
            margin-top: 16px;
            justify-content: flex-end;
        }

        /* TABLE CARD */
        .card-table {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .table-header {
            padding: 16px 24px;
            background: #fafcfb;
            border-bottom: 1px solid var(--color-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 13px;
            color: var(--color-text-secondary);
        }

        .table-header strong {
            color: var(--color-text);
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 1000px;
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
            padding: 14px 18px;
            border-bottom: 1px solid var(--color-border);
            white-space: nowrap;
        }

        td {
            padding: 14px 18px;
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
            gap: 5px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .badge-baru { background: var(--color-info-light); color: var(--color-info); }
        .badge-diterima { background: var(--color-warning-light); color: #92400E; }
        .badge-dialihkan { background: var(--color-purple-light); color: var(--color-purple); }
        .badge-selesai { background: var(--color-success-light); color: var(--color-success); }
        .badge-default { background: #f1f5f9; color: #475569; }

        .btn-action-detail {
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

        .btn-action-detail:hover {
            background: var(--color-primary-light);
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

        @media (max-width: 992px) {
            .filter-grid { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
            .btn-menu-mobile { display: flex; }
            .topbar { padding: 0 16px; }
            .content { padding: 20px 16px; }
            .filter-grid { grid-template-columns: 1fr; }
            .filter-actions { flex-direction: column-reverse; }
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

            <a href="{{ route('admin.kunjungan.index') }}" class="menu-link active">
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

    {{-- MAIN CONTENT --}}
    <div class="main-wrapper">

        {{-- TOPBAR --}}
        <header class="topbar">
            <div class="topbar-left">
                <button type="button" class="btn-menu-mobile" id="mobileMenuToggle" aria-label="Menu navigasi">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div class="topbar-title">
                    <h1>Data Riwayat Kunjungan Tamu</h1>
                    <p>Monitoring dan rekapitulasi seluruh catatan kunjungan tamu ke BKAD Kabupaten Tapin</p>
                </div>
            </div>
        </header>

        {{-- CONTENT BODY --}}
        <main class="content">

            @if (session('success'))
                <div class="alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            {{-- FILTER CARD --}}
            <div class="card-filter">
                <div class="filter-header">
                    <i class="fa-solid fa-filter" style="color: var(--color-primary);"></i>
                    <span>Filter &amp; Pencarian Kunjungan</span>
                </div>

                <form method="GET" action="{{ route('admin.kunjungan.index') }}">
                    <div class="filter-grid">
                        <div class="form-group">
                            <label for="q">Pencarian Cepat</label>
                            <input
                                type="text"
                                id="q"
                                name="q"
                                value="{{ request('q') }}"
                                placeholder="Nama pengunjung, NIP, atau instansi..."
                            >
                        </div>

                        <div class="form-group">
                            <label for="bidang_id">Bidang Tujuan</label>
                            <select id="bidang_id" name="bidang_id">
                                <option value="">Semua Bidang</option>
                                @foreach ($bidangs as $bidang)
                                    <option value="{{ $bidang->id }}" {{ request('bidang_id') == $bidang->id ? 'selected' : '' }}>
                                        {{ $bidang->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select id="status" name="status">
                                <option value="">Semua Status</option>
                                <option value="baru" {{ request('status') === 'baru' ? 'selected' : '' }}>Baru</option>
                                <option value="diterima" {{ request('status') === 'diterima' ? 'selected' : '' }}>Diterima</option>
                                <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="tanggal_mulai">Dari Tanggal</label>
                            <input
                                type="date"
                                id="tanggal_mulai"
                                name="tanggal_mulai"
                                value="{{ request('tanggal_mulai') }}"
                            >
                        </div>

                        <div class="form-group">
                            <label for="tanggal_akhir">Sampai Tanggal</label>
                            <input
                                type="date"
                                id="tanggal_akhir"
                                name="tanggal_akhir"
                                value="{{ request('tanggal_akhir') }}"
                            >
                        </div>
                    </div>

                    <div class="filter-actions">
                        <a href="{{ route('admin.kunjungan.index') }}" class="btn btn-secondary">
                            <i class="fa-solid fa-rotate-left"></i>
                            <span>Reset Filter</span>
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <span>Terapkan Filter</span>
                        </button>
                    </div>
                </form>
            </div>

            {{-- TABLE CARD --}}
            <div class="card-table">
                <div class="table-header">
                    <div>
                        Menampilkan <strong>{{ $kunjungans->count() }}</strong> data pada halaman ini &bull; Total hasil: <strong>{{ $kunjungans->total() }}</strong> kunjungan.
                    </div>
                </div>

                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 40px;">No</th>
                                <th style="width: 140px;">Waktu Kunjungan</th>
                                <th>Nama Pengunjung</th>
                                <th>NIP</th>
                                <th>Instansi Asal</th>
                                <th>Bidang Tujuan</th>
                                <th>Keperluan</th>
                                <th style="width: 110px;">Status</th>
                                <th style="width: 90px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kunjungans as $kunjungan)
                                <tr>
                                    <td>{{ $kunjungans->firstItem() + $loop->index }}</td>
                                    <td>
                                        @if ($kunjungan->created_at)
                                            <span style="font-weight: 600; font-size: 12px; color: var(--color-text);">
                                                {{ $kunjungan->created_at->timezone('Asia/Makassar')->format('d/m/Y') }}
                                            </span>
                                            <div style="font-size: 11px; color: var(--color-text-secondary);">
                                                {{ $kunjungan->created_at->timezone('Asia/Makassar')->format('H:i') }} WITA
                                            </div>
                                        @else
                                            <span style="color: var(--color-text-secondary);">&mdash;</span>
                                        @endif
                                    </td>
                                    <td>
                                        <strong style="color: var(--color-text);">{{ $kunjungan->nama_pengunjung }}</strong>
                                        @if ($kunjungan->jabatan)
                                            <div style="font-size: 11px; color: var(--color-text-secondary);">{{ $kunjungan->jabatan }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        <code style="font-family: inherit; font-size: 12px; color: #475569;">{{ $kunjungan->nip ?: '-' }}</code>
                                    </td>
                                    <td>{{ $kunjungan->instansi }}</td>
                                    <td>
                                        <span style="font-weight: 600; color: var(--color-primary-dark);">
                                            {{ $kunjungan->bidangTujuan?->nama ?? '-' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span title="{{ $kunjungan->keperluan }}" style="color: #334155;">
                                            {{ \Illuminate\Support\Str::limit($kunjungan->keperluan, 50) }}
                                        </span>
                                    </td>
                                    <td>
                                        @switch($kunjungan->status)
                                            @case('baru')
                                                <span class="badge badge-baru">
                                                    <i class="fa-solid fa-clock"></i> Baru
                                                </span>
                                                @break
                                            @case('diterima')
                                                <span class="badge badge-diterima">
                                                    <i class="fa-solid fa-handshake"></i> Diterima
                                                </span>
                                                @break
                                            @case('dialihkan')
                                                <span class="badge badge-dialihkan">
                                                    <i class="fa-solid fa-share-nodes"></i> Dialihkan
                                                </span>
                                                @break
                                            @case('selesai')
                                                <span class="badge badge-selesai">
                                                    <i class="fa-solid fa-circle-check"></i> Selesai
                                                </span>
                                                @break
                                            @default
                                                <span class="badge badge-default">{{ $kunjungan->status }}</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.kunjungan.show', $kunjungan) }}" class="btn-action-detail" title="Lihat detail kunjungan">
                                            <i class="fa-solid fa-eye"></i>
                                            <span>Detail</span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9">
                                        <div class="empty-state">
                                            <i class="fa-solid fa-folder-open"></i>
                                            <p>Tidak ditemukan data kunjungan tamu yang sesuai kriteria.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
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

