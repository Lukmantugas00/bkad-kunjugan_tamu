<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Kunjungan Tamu - SIKUTA BKAD Kabupaten Tapin</title>

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
            --color-danger-border: #FECACA;
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 14px;
            --radius-xl: 18px;
            --shadow-sm: 0 1px 3px rgba(16, 63, 60, 0.05);
            --shadow-md: 0 4px 14px rgba(16, 63, 60, 0.08);
            --shadow-lg: 0 10px 30px rgba(16, 63, 60, 0.10);
            --font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
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
            -webkit-font-smoothing: antialiased;
        }

        /* Header */
        .header {
            background: var(--color-surface);
            border-bottom: 1px solid var(--color-border);
            padding: 14px 32px;
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 0 2px 8px rgba(16, 63, 60, 0.04);
        }

        .header-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .brand-link {
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
            color: inherit;
        }

        .brand-logo {
            width: 44px;
            height: 44px;
            background: var(--color-primary-dark);
            color: #ffffff;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .brand-title {
            font-size: 17px;
            font-weight: 800;
            color: var(--color-primary-dark);
            line-height: 1.2;
        }

        .brand-sub {
            font-size: 11px;
            font-weight: 600;
            color: var(--color-text-secondary);
            letter-spacing: 0.3px;
        }

        .header-meta {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .piket-badge {
            background: var(--color-primary-light);
            color: var(--color-primary);
            padding: 7px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .pulse-dot {
            width: 8px;
            height: 8px;
            background: var(--color-primary);
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 0 0 rgba(7, 133, 119, 0.5);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(7, 133, 119, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(7, 133, 119, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(7, 133, 119, 0); }
        }

        .header-back {
            color: var(--color-text-secondary);
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 12px;
            border-radius: var(--radius-sm);
            transition: all 0.2s;
        }

        .header-back:hover {
            color: var(--color-primary);
            background: var(--color-primary-light);
        }

        /* Container */
        .main-container {
            max-width: 1040px;
            margin: 32px auto 60px;
            padding: 0 20px;
        }

        .page-intro {
            text-align: center;
            margin-bottom: 28px;
        }

        .page-eyebrow {
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--color-primary);
            margin-bottom: 6px;
        }

        .page-intro h1 {
            font-size: 30px;
            font-weight: 800;
            color: var(--color-primary-dark);
            margin-bottom: 8px;
        }

        .page-intro p {
            font-size: 14px;
            color: var(--color-text-secondary);
            max-width: 600px;
            margin: 0 auto;
        }

        /* Tabs Navigation */
        .tabs-nav {
            display: flex;
            gap: 8px;
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            padding: 6px;
            border-radius: var(--radius-lg);
            max-width: 640px;
            margin: 0 auto 30px;
            box-shadow: var(--shadow-sm);
        }

        .tab-btn {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 12px 18px;
            background: transparent;
            border: none;
            border-radius: var(--radius-md);
            font-family: inherit;
            font-size: 14px;
            font-weight: 700;
            color: var(--color-text-secondary);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .tab-btn:hover {
            color: var(--color-primary);
            background: var(--color-primary-light);
        }

        .tab-btn.active {
            background: var(--color-primary);
            color: #ffffff;
            box-shadow: 0 2px 8px rgba(7, 133, 119, 0.25);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
            animation: fadeIn 0.25s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Form Card */
        .form-card {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-xl);
            padding: 36px;
            box-shadow: var(--shadow-md);
        }

        /* Date Time Box */
        .live-datetime {
            background: var(--color-primary-light);
            border: 1px solid rgba(7, 133, 119, 0.2);
            border-radius: var(--radius-md);
            padding: 14px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 32px;
        }

        .live-date-label {
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--color-primary);
            margin-bottom: 2px;
        }

        .live-date-val {
            font-size: 15px;
            font-weight: 700;
            color: var(--color-primary-dark);
        }

        .live-time-val {
            font-size: 18px;
            font-weight: 800;
            color: var(--color-primary);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Form Sections */
        .form-section {
            margin-bottom: 36px;
            padding-bottom: 32px;
            border-bottom: 1px solid var(--color-border);
        }

        .form-section:last-of-type {
            margin-bottom: 24px;
            padding-bottom: 0;
            border-bottom: none;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 22px;
        }

        .section-badge {
            width: 32px;
            height: 32px;
            background: var(--color-primary-light);
            color: var(--color-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 800;
            flex-shrink: 0;
        }

        .section-title {
            font-size: 17px;
            font-weight: 800;
            color: var(--color-primary-dark);
        }

        .section-desc {
            font-size: 12px;
            color: var(--color-text-secondary);
            margin-top: 2px;
        }

        /* Inputs & Grid */
        .form-grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-field {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-field label {
            font-size: 13px;
            font-weight: 700;
            color: var(--color-text);
        }

        .req-star {
            color: var(--color-danger);
            margin-left: 2px;
        }

        .input-text, .input-textarea {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
            font-family: inherit;
            font-size: 14px;
            color: var(--color-text);
            background: #ffffff;
            outline: none;
            transition: all 0.2s ease;
        }

        .input-text:focus, .input-textarea:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(7, 133, 119, 0.15);
        }

        .input-textarea {
            min-height: 120px;
            resize: vertical;
            line-height: 1.5;
        }

        .field-error {
            font-size: 12px;
            color: var(--color-danger);
            display: flex;
            align-items: center;
            gap: 4px;
            margin-top: 4px;
        }

        /* Bidang Radio Grid */
        .bidang-selector-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 14px;
        }

        .bidang-radio-item {
            position: relative;
        }

        .bidang-radio-item input[type="radio"] {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .bidang-radio-label {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px 18px;
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
            background: #ffffff;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 14px;
            font-weight: 600;
            color: var(--color-text);
            min-height: 58px;
        }

        .bidang-radio-label:hover {
            border-color: var(--color-primary);
            background: #fbfdfd;
        }

        .bidang-radio-indicator {
            width: 20px;
            height: 20px;
            border: 2px solid var(--color-border);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all 0.2s ease;
        }

        .bidang-radio-item input[type="radio"]:checked + .bidang-radio-label {
            border-color: var(--color-primary);
            background: var(--color-primary-light);
            color: var(--color-primary-dark);
            box-shadow: 0 2px 6px rgba(7, 133, 119, 0.12);
        }

        .bidang-radio-item input[type="radio"]:checked + .bidang-radio-label .bidang-radio-indicator {
            border-color: var(--color-primary);
            background: var(--color-primary);
        }

        .bidang-radio-item input[type="radio"]:checked + .bidang-radio-label .bidang-radio-indicator::after {
            content: "";
            width: 8px;
            height: 8px;
            background: #ffffff;
            border-radius: 50%;
        }

        /* Signature Canvas Pad */
        .signature-box {
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
            background: #fafcfb;
            padding: 12px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .sig-canvas-wrapper {
            background: #ffffff;
            border: 1px dashed var(--color-border);
            border-radius: var(--radius-sm);
            position: relative;
            touch-action: none;
            overflow: hidden;
        }

        #sigCanvas {
            width: 100%;
            height: 160px;
            cursor: crosshair;
            display: block;
        }

        .sig-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 12px;
            color: var(--color-text-secondary);
        }

        .btn-clear-sig {
            background: transparent;
            border: 1px solid var(--color-border);
            color: var(--color-text);
            padding: 6px 12px;
            border-radius: var(--radius-sm);
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
        }

        .btn-clear-sig:hover {
            background: var(--color-danger-bg);
            border-color: var(--color-danger-border);
            color: var(--color-danger);
        }

        /* Form Actions Footer */
        .form-footer {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid var(--color-border);
        }

        .btn-reset {
            background: transparent;
            border: 1px solid var(--color-border);
            color: var(--color-text-secondary);
            padding: 12px 20px;
            border-radius: var(--radius-md);
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-reset:hover {
            background: #f1f5f4;
            color: var(--color-text);
        }

        .btn-submit {
            background: var(--color-primary);
            color: #ffffff;
            border: none;
            padding: 13px 28px;
            border-radius: var(--radius-md);
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(7, 133, 119, 0.25);
            transition: all 0.2s ease;
        }

        .btn-submit:hover {
            background: var(--color-primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(7, 133, 119, 0.35);
        }

        /* Alerts */
        .alert-box {
            padding: 14px 18px;
            border-radius: var(--radius-md);
            font-size: 13px;
            margin-bottom: 24px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            line-height: 1.5;
        }

        .alert-box.success {
            background: var(--color-status-selesai-bg);
            border: 1px solid #a7f3d0;
            color: var(--color-status-selesai-text);
        }

        .alert-box.danger {
            background: var(--color-danger-bg);
            border: 1px solid var(--color-danger-border);
            color: var(--color-danger);
        }

        /* Status Tab Table */
        .status-card {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-xl);
            padding: 32px;
            box-shadow: var(--shadow-md);
        }

        .status-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .status-title-group h2 {
            font-size: 20px;
            font-weight: 800;
            color: var(--color-primary-dark);
            margin-bottom: 4px;
        }

        .status-title-group p {
            font-size: 13px;
            color: var(--color-text-secondary);
        }

        .live-refresh-badge {
            font-size: 12px;
            font-weight: 600;
            color: var(--color-primary);
            background: var(--color-primary-light);
            padding: 6px 12px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .table-responsive {
            overflow-x: auto;
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            text-align: left;
        }

        .custom-table th {
            background: #f8faf9;
            color: var(--color-text-secondary);
            font-weight: 700;
            padding: 14px 16px;
            border-bottom: 1px solid var(--color-border);
            white-space: nowrap;
        }

        .custom-table td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--color-border);
            color: var(--color-text);
            vertical-align: middle;
        }

        .custom-table tbody tr:last-child td {
            border-bottom: none;
        }

        .custom-table tbody tr:hover {
            background: #fbfdfc;
        }

        /* Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        .status-baru {
            background: var(--color-status-baru-bg);
            color: var(--color-status-baru-text);
        }

        .status-diterima {
            background: var(--color-status-diterima-bg);
            color: var(--color-status-diterima-text);
        }

        .status-dialihkan {
            background: var(--color-status-dialihkan-bg);
            color: var(--color-status-dialihkan-text);
        }

        .status-selesai {
            background: var(--color-status-selesai-bg);
            color: var(--color-status-selesai-text);
        }

        .empty-row-text {
            text-align: center;
            padding: 40px 16px !important;
            color: var(--color-text-secondary);
            font-size: 14px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header {
                padding: 12px 16px;
            }

            .main-container {
                padding: 0 16px;
                margin: 20px auto 40px;
            }

            .form-card, .status-card {
                padding: 20px;
                border-radius: var(--radius-lg);
            }

            .form-grid-2 {
                grid-template-columns: 1fr;
            }

            .bidang-selector-grid {
                grid-template-columns: 1fr;
            }

            .live-datetime {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .tabs-nav {
                width: 100%;
            }

            .tab-btn {
                font-size: 13px;
                padding: 10px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            * {
                transition: none !important;
                animation: none !important;
            }
        }
    </style>
</head>
<body>

    {{-- HEADER --}}
    <header class="header">
        <div class="header-inner">
            <div class="brand-link">
                <div class="brand-logo">
                    <i class="fa-solid fa-building-columns"></i>
                </div>
                <div>
                    <div class="brand-title">SIKUTA BKAD</div>
                    <div class="brand-sub">Sistem Kunjungan Tamu &bull; Meja Piket</div>
                </div>
            </div>

            <div class="header-meta">
                <div class="piket-badge">
                    <span class="pulse-dot"></span>
                    <span>Lobi Pelayanan Aktif</span>
                </div>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="header-back" style="background: transparent; border: 1px solid var(--color-border); cursor: pointer;" title="Keluar Sistem">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </div>
    </header>

    {{-- MAIN CONTENT --}}
    <main class="main-container">

        {{-- Intro --}}
        <div class="page-intro">
            <div class="page-eyebrow">Pencatatan Tamu Dinas</div>
            <h1>Buku Tamu Kunjungan</h1>
            <p>Silakan isi data pengunjung dengan lengkap dan jelas untuk keperluan tertib administrasi dan disposisi pelayanan bidang.</p>
        </div>

        {{-- TABS NAVIGATION --}}
        <div class="tabs-nav">
            <button type="button" class="tab-btn active" data-tab="formulir">
                <i class="fa-solid fa-pen-to-square"></i>
                <span>Formulir Kunjungan</span>
            </button>
            <button type="button" class="tab-btn" data-tab="status">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <span>Status Kunjungan Hari Ini</span>
            </button>
        </div>

        {{-- TAB 1: FORMULIR KUNJUNGAN --}}
        <div id="tab-formulir" class="tab-content active">
            <div class="form-card">

                {{-- Feedback Alerts --}}
                @if (session('success'))
                    <div class="alert-box success">
                        <i class="fa-solid fa-circle-check" style="font-size: 18px;"></i>
                        <div>
                            <strong>Pendaftaran Berhasil!</strong>
                            <div>{{ session('success') }}</div>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert-box danger">
                        <i class="fa-solid fa-triangle-exclamation" style="font-size: 18px;"></i>
                        <div>
                            <strong>Terdapat kesalahan pengisian data:</strong>
                            <ul style="margin: 6px 0 0 18px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                {{-- Live Date & Time Box --}}
                <div class="live-datetime">
                    <div>
                        <div class="live-date-label">Waktu Sistem (WITA)</div>
                        <div class="live-date-val" id="tanggal">Memuat tanggal...</div>
                    </div>
                    <div class="live-time-val" id="waktu">
                        <i class="fa-regular fa-clock"></i>
                        <span>--:-- WITA</span>
                    </div>
                </div>

                {{-- FORM --}}
                <form method="POST" action="{{ route('kunjungan.store') }}" id="kunjunganForm">
                    @csrf

                    {{-- SECTION 1: Identitas Tamu --}}
                    <div class="form-section">
                        <div class="section-header">
                            <div class="section-badge">1</div>
                            <div>
                                <h3 class="section-title">Identitas Pengunjung</h3>
                                <p class="section-desc">Masukkan informasi lengkap pengunjung atau perwakilan tamu dinas.</p>
                            </div>
                        </div>

                        <div class="form-grid-2">
                            <div class="form-field">
                                <label for="nama_pengunjung">Nama Lengkap <span class="req-star">*</span></label>
                                <input
                                    type="text"
                                    id="nama_pengunjung"
                                    name="nama_pengunjung"
                                    class="input-text"
                                    placeholder="Contoh: Muhammad Ramadhani, S.STP"
                                    value="{{ old('nama_pengunjung') }}"
                                    required
                                >
                                @error('nama_pengunjung')
                                    <div class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-field">
                                <label for="nip">NIP (18 Digit) <span class="req-star">*</span></label>
                                <input
                                    type="text"
                                    id="nip"
                                    name="nip"
                                    class="input-text"
                                    placeholder="Contoh: 198501012010011001"
                                    maxlength="18"
                                    inputmode="numeric"
                                    value="{{ old('nip') }}"
                                    required
                                >
                                @error('nip')
                                    <div class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-field">
                                <label for="jabatan">Jabatan <span class="req-star">*</span></label>
                                <input
                                    type="text"
                                    id="jabatan"
                                    name="jabatan"
                                    class="input-text"
                                    placeholder="Contoh: Kepala Sub Bagian Keuangan"
                                    value="{{ old('jabatan') }}"
                                    required
                                >
                                @error('jabatan')
                                    <div class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-field">
                                <label for="instansi">SKPD / Instansi Asal <span class="req-star">*</span></label>
                                <input
                                    type="text"
                                    id="instansi"
                                    name="instansi"
                                    class="input-text"
                                    placeholder="Contoh: Dinas Pendidikan Kabupaten Tapin"
                                    value="{{ old('instansi') }}"
                                    required
                                >
                                @error('instansi')
                                    <div class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- SECTION 2: Bidang Tujuan --}}
                    <div class="form-section">
                        <div class="section-header">
                            <div class="section-badge">2</div>
                            <div>
                                <h3 class="section-title">Bidang Tujuan BKAD</h3>
                                <p class="section-desc">Pilih bidang di lingkungan BKAD Kabupaten Tapin yang akan dikunjungi.</p>
                            </div>
                        </div>

                        <div class="bidang-selector-grid">
                            @foreach ($bidangs as $bidang)
                                <div class="bidang-radio-item">
                                    <input
                                        type="radio"
                                        id="bidang_{{ $bidang->id }}"
                                        name="bidang_tujuan_id"
                                        value="{{ $bidang->id }}"
                                        {{ old('bidang_tujuan_id') == $bidang->id ? 'checked' : '' }}
                                        required
                                    >
                                    <label for="bidang_{{ $bidang->id }}" class="bidang-radio-label">
                                        <span class="bidang-radio-indicator"></span>
                                        <span>{{ $bidang->nama }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @error('bidang_tujuan_id')
                            <div class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- SECTION 3: Keperluan Kunjungan --}}
                    <div class="form-section">
                        <div class="section-header">
                            <div class="section-badge">3</div>
                            <div>
                                <h3 class="section-title">Keperluan Kunjungan</h3>
                                <p class="section-desc">Uraikan maksud dan tujuan kunjungan secara ringkas dan spesifik.</p>
                            </div>
                        </div>

                        <div class="form-field">
                            <label for="keperluan">Uraian Keperluan <span class="req-star">*</span></label>
                            <textarea
                                id="keperluan"
                                name="keperluan"
                                class="input-textarea"
                                placeholder="Jelaskan keperluan kunjungan tamu (misal: Konsultasi Rekonsiliasi Belanja Modal TA 2026)..."
                                required
                            >{{ old('keperluan') }}</textarea>
                            @error('keperluan')
                                <div class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- SECTION 4: Tanda Tangan Digital --}}
                    <div class="form-section">
                        <div class="section-header">
                            <div class="section-badge">4</div>
                            <div>
                                <h3 class="section-title">Tanda Tangan Pengunjung</h3>
                                <p class="section-desc">Goreskan tanda tangan digital langsung pada bidang gambar atau masukkan catatan tanda tangan.</p>
                            </div>
                        </div>

                        <div class="signature-box">
                            <div class="sig-canvas-wrapper">
                                <canvas id="sigCanvas"></canvas>
                            </div>
                            <div class="sig-actions">
                                <span><i class="fa-solid fa-pen"></i> Tanda tangani pada area kotak di atas</span>
                                <button type="button" class="btn-clear-sig" id="btnClearSig">
                                    <i class="fa-solid fa-rotate-left"></i> Bersihkan Tanda Tangan
                                </button>
                            </div>

                            {{-- Hidden / fallback textarea for compatibility --}}
                            <textarea
                                id="tanda_tangan"
                                name="tanda_tangan"
                                style="display: none;"
                            >{{ old('tanda_tangan') }}</textarea>
                            @error('tanda_tangan')
                                <div class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- FORM ACTIONS --}}
                    <div class="form-footer">
                        <button type="reset" class="btn-reset" id="btnResetForm">
                            <i class="fa-solid fa-arrows-rotate"></i> Reset Formulir
                        </button>
                        <button type="submit" class="btn-submit">
                            <i class="fa-solid fa-paper-plane"></i>
                            <span>Daftarkan Kunjungan</span>
                        </button>
                    </div>

                </form>
            </div>
        </div>

        {{-- TAB 2: STATUS KUNJUNGAN HARI INI --}}
        <div id="tab-status" class="tab-content">
            <div class="status-card">
                <div class="status-card-header">
                    <div class="status-title-group">
                        <h2>Daftar Kunjungan Hari Ini</h2>
                        <p>Daftar tamu yang telah terdaftar di Meja Piket beserta status penanganan oleh bidang tujuan.</p>
                    </div>
                    <div class="live-refresh-badge" id="status-refresh">
                        <i class="fa-solid fa-rotate fa-spin"></i>
                        <span>Memuat data...</span>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Waktu Masuk</th>
                                <th>Nama Tamu</th>
                                <th>Bidang Tujuan</th>
                                <th>Keperluan</th>
                                <th>Status Pelayanan</th>
                            </tr>
                        </thead>
                        <tbody id="status-body">
                            @forelse ($kunjungansHariIni as $kunjungan)
                                <tr>
                                    <td>
                                        <strong>
                                            {{ $kunjungan->created_at ? $kunjungan->created_at->timezone('Asia/Makassar')->format('H:i') . ' WITA' : '-' }}
                                        </strong>
                                    </td>
                                    <td>
                                        <div><strong>{{ $kunjungan->nama_pengunjung }}</strong></div>
                                        <div style="font-size: 11px; color: var(--color-text-secondary);">{{ $kunjungan->instansi }}</div>
                                    </td>
                                    <td>
                                        <span style="font-weight: 600;">{{ $kunjungan->bidangTujuan?->nama ?? '-' }}</span>
                                    </td>
                                    <td style="max-width: 280px;">
                                        {{ $kunjungan->keperluan }}
                                    </td>
                                    <td>
                                        @if ($kunjungan->status === 'baru')
                                            <span class="status-badge status-baru">
                                                <i class="fa-solid fa-circle-dot"></i> Baru
                                            </span>
                                        @elseif ($kunjungan->status === 'diterima')
                                            <span class="status-badge status-diterima">
                                                <i class="fa-solid fa-spinner"></i> Diterima
                                            </span>
                                        @elseif ($kunjungan->status === 'dialihkan')
                                            <span class="status-badge status-dialihkan">
                                                <i class="fa-solid fa-share"></i> Dialihkan
                                            </span>
                                        @elseif ($kunjungan->status === 'selesai')
                                            <span class="status-badge status-selesai">
                                                <i class="fa-solid fa-circle-check"></i> Selesai
                                            </span>
                                        @else
                                            <span class="status-badge status-baru">
                                                {{ ucfirst($kunjungan->status) }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="empty-row-text">
                                        <i class="fa-solid fa-inbox" style="font-size: 32px; display: block; margin-bottom: 8px; opacity: 0.4;"></i>
                                        Belum ada data kunjungan tamu hari ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </main>

    {{-- SCRIPT: TABS, LIVE CLOCK, SIGNATURE PAD, AUTO-REFRESH --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            /* 1. TAB SWITCHING */
            const tabButtons = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const target = this.dataset.tab;

                    tabButtons.forEach(item => item.classList.remove('active'));
                    tabContents.forEach(item => item.classList.remove('active'));

                    this.classList.add('active');

                    const targetTab = document.getElementById('tab-' + target);
                    if (targetTab) {
                        targetTab.classList.add('active');
                    }

                    if (target === 'status') {
                        updateStatusKunjungan();
                    }
                });
            });

            /* 2. LIVE CLOCK (WITA) */
            function updateDateTime() {
                const now = new Date();
                const options = {
                    weekday: 'long',
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric',
                    timeZone: 'Asia/Makassar'
                };

                const tanggal = new Intl.DateTimeFormat('id-ID', options).format(now);
                const waktu = new Intl.DateTimeFormat('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: false,
                    timeZone: 'Asia/Makassar'
                }).format(now);

                const tanggalElement = document.getElementById('tanggal');
                const waktuElement = document.getElementById('waktu');

                if (tanggalElement) tanggalElement.textContent = tanggal;
                if (waktuElement) waktuElement.innerHTML = `<i class="fa-regular fa-clock"></i> <span>${waktu} WITA</span>`;
            }

            updateDateTime();
            setInterval(updateDateTime, 1000);

            /* 3. SIGNATURE PAD ON HTML5 CANVAS */
            const canvas = document.getElementById('sigCanvas');
            const hiddenSigInput = document.getElementById('tanda_tangan');
            const btnClear = document.getElementById('btnClearSig');

            if (canvas) {
                const ctx = canvas.getContext('2d');
                let isDrawing = false;
                let hasDrawn = false;

                function resizeCanvas() {
                    const rect = canvas.getBoundingClientRect();
                    const dpr = window.devicePixelRatio || 1;
                    canvas.width = rect.width * dpr;
                    canvas.height = rect.height * dpr;
                    ctx.scale(dpr, dpr);
                    ctx.lineWidth = 2.5;
                    ctx.lineCap = 'round';
                    ctx.lineJoin = 'round';
                    ctx.strokeStyle = '#103F3C';
                }

                resizeCanvas();
                window.addEventListener('resize', resizeCanvas);

                function getCoords(e) {
                    const rect = canvas.getBoundingClientRect();
                    const clientX = e.touches ? e.touches[0].clientX : e.clientX;
                    const clientY = e.touches ? e.touches[0].clientY : e.clientY;
                    return {
                        x: clientX - rect.left,
                        y: clientY - rect.top
                    };
                }

                function startDrawing(e) {
                    isDrawing = true;
                    const coords = getCoords(e);
                    ctx.beginPath();
                    ctx.moveTo(coords.x, coords.y);
                    if (e.type === 'touchstart') e.preventDefault();
                }

                function draw(e) {
                    if (!isDrawing) return;
                    const coords = getCoords(e);
                    ctx.lineTo(coords.x, coords.y);
                    ctx.stroke();
                    hasDrawn = true;
                    if (e.type === 'touchmove') e.preventDefault();
                }

                function stopDrawing() {
                    if (isDrawing) {
                        isDrawing = false;
                        if (hasDrawn && hiddenSigInput) {
                            hiddenSigInput.value = canvas.toDataURL('image/png');
                        }
                    }
                }

                canvas.addEventListener('mousedown', startDrawing);
                canvas.addEventListener('mousemove', draw);
                canvas.addEventListener('mouseup', stopDrawing);
                canvas.addEventListener('mouseleave', stopDrawing);

                canvas.addEventListener('touchstart', startDrawing, { passive: false });
                canvas.addEventListener('touchmove', draw, { passive: false });
                canvas.addEventListener('touchend', stopDrawing);

                if (btnClear) {
                    btnClear.addEventListener('click', function () {
                        ctx.clearRect(0, 0, canvas.width, canvas.height);
                        hasDrawn = false;
                        if (hiddenSigInput) hiddenSigInput.value = '';
                    });
                }
            }

            /* 4. SECURITY ESCAPING */
            function escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text ?? '';
                return div.innerHTML;
            }

            /* 5. STATUS BADGE GENERATOR */
            function statusBadge(status) {
                const s = (status || '').toLowerCase();
                if (s === 'baru' || s === 'menunggu') {
                    return `<span class="status-badge status-baru"><i class="fa-solid fa-circle-dot"></i> Baru</span>`;
                }
                if (s === 'diterima' || s === 'diproses') {
                    return `<span class="status-badge status-diterima"><i class="fa-solid fa-spinner"></i> Diterima</span>`;
                }
                if (s === 'dialihkan') {
                    return `<span class="status-badge status-dialihkan"><i class="fa-solid fa-share"></i> Dialihkan</span>`;
                }
                if (s === 'selesai') {
                    return `<span class="status-badge status-selesai"><i class="fa-solid fa-circle-check"></i> Selesai</span>`;
                }
                return `<span class="status-badge status-baru">${escapeHtml(status)}</span>`;
            }

            /* 6. AUTO-REFRESH STATUS TABLE */
            function updateStatusKunjungan() {
                fetch('{{ route('kunjungan.statusHariIni') }}', {
                    headers: { 'Accept': 'application/json' }
                })
                .then(response => {
                    if (!response.ok) throw new Error('Gagal mengambil status kunjungan.');
                    return response.json();
                })
                .then(result => {
                    const tbody = document.getElementById('status-body');
                    const refreshText = document.getElementById('status-refresh');

                    if (!tbody) return;

                    if (!result.data || result.data.length === 0) {
                        tbody.innerHTML = `
                            <tr>
                                <td colspan="5" class="empty-row-text">
                                    <i class="fa-solid fa-inbox" style="font-size: 32px; display: block; margin-bottom: 8px; opacity: 0.4;"></i>
                                    Belum ada data kunjungan tamu hari ini.
                                </td>
                            </tr>
                        `;
                    } else {
                        tbody.innerHTML = result.data.map(item => `
                            <tr>
                                <td><strong>${escapeHtml(item.waktu)} WITA</strong></td>
                                <td>
                                    <div><strong>${escapeHtml(item.nama)}</strong></div>
                                </td>
                                <td><span style="font-weight: 600;">${escapeHtml(item.bidang)}</span></td>
                                <td style="max-width: 280px;">${escapeHtml(item.keperluan)}</td>
                                <td>${statusBadge(item.status)}</td>
                            </tr>
                        `).join('');
                    }

                    if (refreshText) {
                        const now = new Date();
                        const timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
                        refreshText.innerHTML = `<i class="fa-solid fa-circle-check"></i> Diperbarui ${timeStr} WITA`;
                    }
                })
                .catch(error => {
                    console.error('Gagal memperbarui status kunjungan:', error);
                    const refreshText = document.getElementById('status-refresh');
                    if (refreshText) {
                        refreshText.innerHTML = `<i class="fa-solid fa-circle-exclamation" style="color: var(--color-danger);"></i> Gagal memperbarui`;
                    }
                });
            }

            // Periodic polling every 5s when tab is active
            setInterval(function () {
                const statusTab = document.getElementById('tab-status');
                if (statusTab && statusTab.classList.contains('active')) {
                    updateStatusKunjungan();
                }
            }, 5000);

        });
    </script>
</body>
</html>
