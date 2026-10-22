<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Akun Pengguna - SIKUTA BKAD Kabupaten Tapin</title>

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

        /* CONTENT */
        .content {
            padding: 28px 32px;
            flex: 1;
            max-width: 920px;
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

        /* ALERT */
        .alert-danger {
            background: var(--color-danger-light);
            color: var(--color-danger);
            border: 1px solid #fecaca;
            padding: 14px 18px;
            border-radius: var(--radius-md);
            font-size: 13px;
            margin-bottom: 24px;
        }

        .alert-danger ul {
            margin: 8px 0 0 20px;
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
            margin-bottom: 18px;
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

        .form-grid.single {
            grid-template-columns: 1fr;
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
        input[type="password"],
        select {
            width: 100%;
            height: 44px;
            padding: 0 14px;
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
            font-size: 13px;
            color: var(--color-text);
            background: #ffffff;
            font-family: inherit;
            transition: all 0.2s;
        }

        input:focus,
        select:focus {
            outline: none;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(7, 133, 119, 0.15);
        }

        .help-text {
            font-size: 11px;
            color: var(--color-text-secondary);
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            padding: 12px 14px;
            background: #fafcfb;
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
        }

        .checkbox-container input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: var(--color-primary);
            cursor: pointer;
        }

        .checkbox-container span {
            font-size: 13px;
            font-weight: 600;
            color: var(--color-text);
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
                    <h1>Tambah Akun Pengguna</h1>
                    <p>Buat kredensial dan tetapkan hak akses pengguna baru ke sistem</p>
                </div>
            </div>

            <div class="topbar-right">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Kembali</span>
                </a>
            </div>
        </header>

        {{-- CONTENT BODY --}}
        <main class="content">

            @if ($errors->any())
                <div class="alert-danger">
                    <div style="font-weight: 700; display: flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>Pemeriksaan Formulir Gagal</span>
                    </div>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card">
                <form method="POST" action="{{ route('admin.users.store') }}">
                    @csrf

                    <div class="form-section-title">
                        <i class="fa-solid fa-id-badge"></i>
                        <span>Informasi Identitas &amp; Hak Akses</span>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="nip">NIP <span class="req">*</span></label>
                            <input
                                type="text"
                                id="nip"
                                name="nip"
                                maxlength="18"
                                value="{{ old('nip') }}"
                                placeholder="Contoh: 198501012010011001"
                                required
                            >
                            <span class="help-text">Nomor Induk Pegawai maksimal 18 karakter</span>
                        </div>

                        <div class="form-group">
                            <label for="name">Nama Lengkap <span class="req">*</span></label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="Masukkan nama lengkap beserta gelar"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label for="role">Role / Hak Akses <span class="req">*</span></label>
                            <select id="role" name="role" required>
                                <option value="">-- Pilih Hak Akses --</option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin (Administrator Penuh)</option>
                                <option value="petugas_piket" {{ old('role') === 'petugas_piket' ? 'selected' : '' }}>Petugas Piket (Meja Resepsionis)</option>
                                <option value="penerima_bidang" {{ old('role') === 'penerima_bidang' ? 'selected' : '' }}>Penerima Bidang (Staff / Pengurus Bidang)</option>
                                <option value="pimpinan" {{ old('role') === 'pimpinan' ? 'selected' : '' }}>Pimpinan (Kepala Badan)</option>
                            </select>
                        </div>

                        <div class="form-group" id="bidang-group">
                            <label for="bidang_id">Unit Bidang Tujuan</label>
                            <select id="bidang_id" name="bidang_id">
                                <option value="">-- Pilih Bidang --</option>
                                @foreach ($bidangs as $bidang)
                                    <option value="{{ $bidang->id }}" {{ old('bidang_id') == $bidang->id ? 'selected' : '' }}>
                                        {{ $bidang->nama }} ({{ $bidang->kode }})
                                    </option>
                                @endforeach
                            </select>
                            <span class="help-text">Wajib dipilih jika role adalah Penerima Bidang</span>
                        </div>
                    </div>

                    <div class="form-section-title" style="margin-top: 30px;">
                        <i class="fa-solid fa-lock"></i>
                        <span>Keamanan &amp; Kredensial Akun</span>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="password">Kata Sandi <span class="req">*</span></label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Minimal 6 karakter"
                                required
                            >
                            <span class="help-text">Gunakan kombinasi yang aman</span>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Kata Sandi <span class="req">*</span></label>
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                placeholder="Ulangi kata sandi"
                                required
                            >
                        </div>

                        <div class="form-group full-width">
                            <label>Status Akun</label>
                            <label class="checkbox-container">
                                <input
                                    type="checkbox"
                                    id="aktif"
                                    name="aktif"
                                    value="1"
                                    {{ old('aktif', '1') ? 'checked' : '' }}
                                >
                                <span>Akun Aktif (Dapat langsung digunakan untuk login ke sistem)</span>
                            </label>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-floppy-disk"></i>
                            <span>Simpan Akun Pengguna</span>
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

    {{-- Script Dynamic Bidang & Mobile Sidebar --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Sidebar Mobile Toggle
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

            // Bidang Selector Visibility
            const roleSelect = document.getElementById('role');
            const bidangGroup = document.getElementById('bidang-group');
            const bidangSelect = document.getElementById('bidang_id');

            function updateBidang() {
                if (roleSelect.value === 'penerima_bidang') {
                    bidangGroup.style.display = 'flex';
                    bidangSelect.required = true;
                } else {
                    bidangGroup.style.display = 'none';
                    bidangSelect.required = false;
                    bidangSelect.value = '';
                }
            }

            roleSelect.addEventListener('change', updateBidang);
            updateBidang();
        });
    </script>
</body>
</html>

