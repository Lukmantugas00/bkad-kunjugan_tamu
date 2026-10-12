<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koreksi Data Kunjungan - SIKUTA BKAD Kabupaten Tapin</title>

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
            max-width: 900px;
        }

        /* BUTTONS */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 20px;
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

        /* NOTICE ALERT */
        .alert-warning {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            background: var(--color-warning-light);
            border: 1px solid #fde68a;
            color: #92400e;
            padding: 16px;
            border-radius: var(--radius-md);
            font-size: 13px;
            line-height: 1.5;
            margin-bottom: 24px;
        }

        .alert-warning i {
            font-size: 18px;
            color: var(--color-warning);
            margin-top: 2px;
        }

        /* CARD FORM */
        .card {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            padding: 30px;
        }

        .form-section-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--color-primary-dark);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--color-border);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        label {
            font-size: 13px;
            font-weight: 700;
            color: var(--color-text);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .req {
            color: var(--color-danger);
        }

        input[type="text"],
        select,
        textarea {
            width: 100%;
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
            font-size: 13px;
            color: var(--color-text);
            background: #ffffff;
            font-family: inherit;
            transition: all 0.2s;
        }

        input[type="text"],
        select {
            height: 44px;
            padding: 0 14px;
        }

        textarea {
            padding: 12px 14px;
            min-height: 90px;
            resize: vertical;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(7, 133, 119, 0.15);
        }

        .invalid-feedback {
            font-size: 12px;
            color: var(--color-danger);
            font-weight: 600;
        }

        .form-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 32px;
            padding-top: 20px;
            border-top: 1px solid var(--color-border);
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
            .form-grid { grid-template-columns: 1fr; }
            .form-actions { flex-direction: column-reverse; }
            .form-actions .btn { width: 100%; }
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
                    <h1>Koreksi Data Kunjungan</h1>
                    <p>Perbaiki kesalahan penulisan identitas tamu, bidang tujuan, atau keperluan kunjungan</p>
                </div>
            </div>

            <div class="topbar-right">
                <a href="{{ route('admin.kunjungan.show', $kunjungan) }}" class="btn btn-secondary">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Kembali</span>
                </a>
            </div>
        </header>

        {{-- CONTENT BODY --}}
        <main class="content">

            <div class="alert-warning">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <div>
                    <strong>Perhatian Hak Akses:</strong> Halaman ini digunakan khusus oleh Administrator untuk mengoreksi kesalahan ketik atau keliru input data dasar kunjungan. Status proses penanganan, waktu penerimaan, waktu penyelesaian, dan jawaban bidang tidak dapat dimanipulasi melalui formulir ini.
                </div>
            </div>

            <div class="card">
                <form method="POST" action="{{ route('admin.kunjungan.update', $kunjungan) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-section-title">
                        <i class="fa-solid fa-user-pen"></i>
                        <span>Koreksi Identitas Tamu</span>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="nama_pengunjung">Nama Pengunjung <span class="req">*</span></label>
                            <input
                                type="text"
                                id="nama_pengunjung"
                                name="nama_pengunjung"
                                value="{{ old('nama_pengunjung', $kunjungan->nama_pengunjung) }}"
                                required
                            >
                            @error('nama_pengunjung')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="nip">NIP (Nomor Induk Pegawai)</label>
                            <input
                                type="text"
                                id="nip"
                                name="nip"
                                value="{{ old('nip', $kunjungan->nip) }}"
                                maxlength="18"
                            >
                            @error('nip')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="jabatan">Jabatan <span class="req">*</span></label>
                            <input
                                type="text"
                                id="jabatan"
                                name="jabatan"
                                value="{{ old('jabatan', $kunjungan->jabatan) }}"
                                required
                            >
                            @error('jabatan')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="instansi">Instansi / Unit Kerja <span class="req">*</span></label>
                            <input
                                type="text"
                                id="instansi"
                                name="instansi"
                                value="{{ old('instansi', $kunjungan->instansi) }}"
                                required
                            >
                            @error('instansi')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group full-width">
                            <label for="bidang_tujuan_id">Bidang Tujuan <span class="req">*</span></label>
                            <select id="bidang_tujuan_id" name="bidang_tujuan_id" required>
                                @foreach ($bidangs as $bidang)
                                    <option value="{{ $bidang->id }}" {{ old('bidang_tujuan_id', $kunjungan->bidang_tujuan_id) == $bidang->id ? 'selected' : '' }}>
                                        {{ $bidang->nama }} ({{ $bidang->kode }})
                                    </option>
                                @endforeach
                            </select>
                            @error('bidang_tujuan_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group full-width">
                            <label for="keperluan">Maksud &amp; Keperluan Kunjungan <span class="req">*</span></label>
                            <textarea
                                id="keperluan"
                                name="keperluan"
                                required
                            >{{ old('keperluan', $kunjungan->keperluan) }}</textarea>
                            @error('keperluan')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group full-width">
                            <label for="tanda_tangan">Data Tanda Tangan (Base64 / Catatan)</label>
                            <textarea
                                id="tanda_tangan"
                                name="tanda_tangan"
                                style="font-family: monospace; font-size: 11px;"
                            >{{ old('tanda_tangan', $kunjungan->tanda_tangan) }}</textarea>
                            @error('tanda_tangan')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('admin.kunjungan.show', $kunjungan) }}" class="btn btn-secondary">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-floppy-disk"></i>
                            <span>Simpan Koreksi Data</span>
                        </button>
                    </div>

                </form>
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
