<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Bidang - SIKUTA BKAD Kabupaten Tapin</title>

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
            --shadow-lg: 0 10px 28px rgba(16, 63, 60, 0.12);
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
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
        }

        /* Top Navigation Header */
        .header {
            background: var(--color-primary-dark);
            color: #ffffff;
            padding: 16px 32px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
        }

        .header-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .brand-group {
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
            color: #ffffff;
        }

        .brand-logo {
            width: 44px;
            height: 44px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #ffffff;
        }

        .brand-title {
            font-size: 20px;
            font-weight: 800;
            letter-spacing: 0.5px;
            line-height: 1.2;
        }

        .brand-subtitle {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.75);
            font-weight: 500;
            letter-spacing: 0.2px;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .user-pill {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 14px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 999px;
            font-size: 13px;
        }

        .user-role-badge {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            padding: 3px 8px;
            background: var(--color-primary);
            color: #ffffff;
            border-radius: 999px;
            letter-spacing: 0.5px;
        }

        .btn-logout {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: #ffffff;
            padding: 8px 14px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
        }

        .btn-logout:hover {
            background: rgba(220, 38, 38, 0.2);
            border-color: #ef4444;
            color: #fca5a5;
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: 36px auto;
            padding: 0 24px;
            width: 100%;
            flex: 1;
        }

        /* Banner Shortcuts for specific roles */
        .role-banner {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-left: 4px solid var(--color-primary);
            border-radius: var(--radius-lg);
            padding: 20px 24px;
            margin-bottom: 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            box-shadow: var(--shadow-sm);
        }

        .role-banner-info h3 {
            font-size: 16px;
            font-weight: 700;
            color: var(--color-text);
            margin-bottom: 4px;
        }

        .role-banner-info p {
            font-size: 13px;
            color: var(--color-text-secondary);
        }

        .btn-primary {
            background: var(--color-primary);
            color: #ffffff;
            padding: 10px 18px;
            border-radius: var(--radius-md);
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background 0.2s ease, transform 0.1s ease;
            white-space: nowrap;
        }

        .btn-primary:hover {
            background: var(--color-primary-hover);
            transform: translateY(-1px);
        }

        /* Page Head */
        .page-head {
            margin-bottom: 28px;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
        }

        .page-head h1 {
            font-size: 26px;
            font-weight: 800;
            color: var(--color-text);
            margin-bottom: 6px;
        }

        .page-head p {
            font-size: 14px;
            color: var(--color-text-secondary);
        }

        .search-wrapper {
            position: relative;
            width: 100%;
            max-width: 320px;
        }

        .search-wrapper i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--color-text-secondary);
            font-size: 14px;
        }

        .search-input {
            width: 100%;
            padding: 11px 16px 11px 40px;
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
            font-size: 13px;
            font-family: inherit;
            color: var(--color-text);
            background: var(--color-surface);
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .search-input:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(7, 133, 119, 0.15);
        }

        /* Grid Cards */
        .bidang-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(270px, 1fr));
            gap: 22px;
        }

        .bidang-card {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            padding: 24px;
            text-decoration: none;
            color: var(--color-text);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .bidang-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--color-primary);
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .bidang-card:hover {
            transform: translateY(-4px);
            border-color: var(--color-primary);
            box-shadow: var(--shadow-md);
        }

        .bidang-card:hover::before {
            opacity: 1;
        }

        .bidang-card-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
        }

        .bidang-icon {
            width: 48px;
            height: 48px;
            background: var(--color-primary-light);
            color: var(--color-primary);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 800;
        }

        .bidang-badge {
            font-size: 11px;
            font-weight: 700;
            color: var(--color-primary);
            background: var(--color-primary-light);
            padding: 4px 10px;
            border-radius: 999px;
            letter-spacing: 0.5px;
        }

        .bidang-name {
            font-size: 17px;
            font-weight: 700;
            color: var(--color-text);
            margin-bottom: 8px;
            line-height: 1.35;
        }

        .bidang-desc {
            font-size: 12px;
            color: var(--color-text-secondary);
            margin-bottom: 20px;
            flex: 1;
            line-height: 1.5;
        }

        .bidang-action {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 14px;
            border-top: 1px solid var(--color-border);
            font-size: 13px;
            font-weight: 700;
            color: var(--color-primary);
            transition: gap 0.2s;
        }

        .bidang-card:hover .bidang-action i {
            transform: translateX(4px);
        }

        .bidang-action i {
            transition: transform 0.2s ease;
        }

        /* Empty State */
        .empty-state {
            grid-column: 1 / -1;
            background: var(--color-surface);
            border: 1px dashed var(--color-border);
            border-radius: var(--radius-lg);
            padding: 48px 24px;
            text-align: center;
        }

        .empty-icon {
            font-size: 44px;
            color: var(--color-text-secondary);
            margin-bottom: 14px;
            opacity: 0.6;
        }

        .empty-state h3 {
            font-size: 17px;
            color: var(--color-text);
            margin-bottom: 6px;
        }

        .empty-state p {
            font-size: 13px;
            color: var(--color-text-secondary);
        }

        /* Footer */
        .footer {
            margin-top: auto;
            border-top: 1px solid var(--color-border);
            background: var(--color-surface);
            padding: 18px 24px;
            text-align: center;
            font-size: 12px;
            color: var(--color-text-secondary);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header {
                padding: 14px 20px;
            }

            .header-inner {
                flex-direction: column;
                align-items: flex-start;
                gap: 14px;
            }

            .header-actions {
                width: 100%;
                justify-content: space-between;
            }

            .container {
                padding: 0 16px;
                margin: 24px auto;
            }

            .page-head {
                flex-direction: column;
                align-items: flex-start;
            }

            .search-wrapper {
                max-width: 100%;
            }

            .role-banner {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            * {
                transition: none !important;
                animation: none !important;
                transform: none !important;
            }
        }
    </style>
</head>
<body>

    {{-- HEADER --}}
    <header class="header">
        <div class="header-inner">
            <a href="{{ url('/') }}" class="brand-group">
                <div class="brand-logo">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Logo BKAD Kabupaten Tapin" style="width: 100%; height: 100%; object-fit: contain; border-radius: var(--radius-md);">
                </div>
                <div>
                    <div class="brand-title">SIKUTA</div>
                    <div class="brand-subtitle">BKAD Kabupaten Tapin &bull; Sistem Kunjungan Tamu</div>
                </div>
            </a>

            <div class="header-actions">
                @auth
                    <div class="user-pill">
                        <i class="fa-solid fa-user-circle" style="color: #6ee7b7;"></i>
                        <span>{{ auth()->user()->name }}</span>
                        <span class="user-role-badge">
                            {{ str_replace('_', ' ', auth()->user()->role ?? 'user') }}
                        </span>
                    </div>

                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-logout" title="Keluar dari sistem">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            <span>Keluar</span>
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </header>

    {{-- MAIN CONTENT --}}
    <main class="container">

        {{-- Role-specific Shortcuts --}}
        @auth
            @if (auth()->user()->role === 'petugas_piket')
                <div class="role-banner">
                    <div class="role-banner-info">
                        <h3><i class="fa-solid fa-clipboard-user" style="color: var(--color-primary); margin-right: 8px;"></i> Meja Piket & Kunjungan Tamu</h3>
                        <p>Anda masuk sebagai Petugas Piket. Buka formulir untuk mencatat pengunjung atau melihat status hari ini.</p>
                    </div>
                    <a href="{{ route('kunjungan.create') }}" class="btn-primary">
                        <i class="fa-solid fa-pen-to-square"></i> Buka Meja Piket
                    </a>
                </div>
            @elseif (auth()->user()->role === 'admin')
                <div class="role-banner">
                    <div class="role-banner-info">
                        <h3><i class="fa-solid fa-shield-halved" style="color: var(--color-primary); margin-right: 8px;"></i> Panel Administrator</h3>
                        <p>Kelola pengguna, master bidang, rekap kunjungan, laporan, dan log aktivitas sistem.</p>
                    </div>
                    <a href="{{ route('admin.dashboard') }}" class="btn-primary">
                        <i class="fa-solid fa-gauge-high"></i> Dashboard Admin
                    </a>
                </div>
            @elseif (auth()->user()->role === 'pimpinan')
                <div class="role-banner">
                    <div class="role-banner-info">
                        <h3><i class="fa-solid fa-chart-line" style="color: var(--color-primary); margin-right: 8px;"></i> Dashboard Pimpinan</h3>
                        <p>Pantau statistik kunjungan dan unduh laporan berkala BKAD Kabupaten Tapin.</p>
                    </div>
                    <a href="{{ route('pimpinan.dashboard') }}" class="btn-primary">
                        <i class="fa-solid fa-chart-pie"></i> Dashboard Pimpinan
                    </a>
                </div>
            @endif
        @endauth

        {{-- Section Header --}}
        <div class="page-head">
            <div>
                <h1>Pilih Bidang Pelayanan</h1>
                <p>Pilih bidang tujuan untuk membuka kotak masuk dan memproses kunjungan tamu yang masuk.</p>
            </div>

            <div class="search-wrapper">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input
                    type="text"
                    id="searchBidang"
                    class="search-input"
                    placeholder="Cari nama atau kode bidang..."
                    autocomplete="off"
                >
            </div>
        </div>

        {{-- Grid of Bidangs --}}
        <div class="bidang-grid" id="bidangGrid">
            @forelse ($bidangs as $bidang)
                <a
                    href="{{ route('kunjungan.inbox', $bidang->kode) }}"
                    class="bidang-card"
                    data-name="{{ strtolower($bidang->nama) }}"
                    data-code="{{ strtolower($bidang->kode) }}"
                >
                    <div class="bidang-card-top">
                        <div class="bidang-icon">
                            <i class="fa-solid fa-building"></i>
                        </div>
                        <span class="bidang-badge">{{ $bidang->kode }}</span>
                    </div>

                    <h3 class="bidang-name">{{ $bidang->nama }}</h3>
                    <p class="bidang-desc">
                        Lihat tamu menunggu, terima kunjungan, alihkan, atau selesaikan proses konsultasi tamu.
                    </p>

                    <div class="bidang-action">
                        <span>Buka Kotak Masuk</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </a>
            @empty
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fa-solid fa-folder-open"></i>
                    </div>
                    <h3>Belum Ada Bidang Aktif</h3>
                    <p>Silakan hubungi Administrator untuk mengaktifkan master bidang.</p>
                </div>
            @endforelse
        </div>

    </main>

    {{-- FOOTER --}}
    <footer class="footer">
        <div>&copy; {{ date('Y') }} BKAD Kabupaten Tapin &bull; SIKUTA (Sistem Informasi Kunjungan Tamu)</div>
    </footer>

    {{-- Search filter script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchBidang');
            const cards = document.querySelectorAll('.bidang-card');

            if (searchInput && cards.length) {
                searchInput.addEventListener('input', function (e) {
                    const query = e.target.value.toLowerCase().trim();

                    cards.forEach(function (card) {
                        const name = card.getAttribute('data-name') || '';
                        const code = card.getAttribute('data-code') || '';

                        if (name.includes(query) || code.includes(query)) {
                            card.style.display = 'flex';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            }
        });
    </script>
</body>
</html>
