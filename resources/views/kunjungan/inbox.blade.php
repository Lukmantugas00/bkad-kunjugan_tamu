@php
    $user = auth()->user();
    $kode = request()->route('kode') ?? $user?->bidang?->kode ?? '';
    $namaBidang = $bidang->nama ?? $user?->bidang?->nama ?? 'Bidang';

    $dataKunjungan = $kunjungans instanceof \Illuminate\Pagination\AbstractPaginator
        ? $kunjungans->getCollection()
        : collect($kunjungans);

    $jumlahKunjungan = $kunjungans instanceof \Illuminate\Pagination\AbstractPaginator
        ? $kunjungans->total()
        : $dataKunjungan->count();

    $hitungStatus = function ($status) use ($dataKunjungan) {
        return $dataKunjungan->filter(function ($item) use ($status) {
            $statusItem = strtolower(trim((string) $item->status));
            $statusDicari = strtolower(trim((string) $status));

            if ($statusDicari === 'baru') {
                return in_array($statusItem, ['baru', 'menunggu'], true);
            }
            if ($statusDicari === 'diterima') {
                return in_array($statusItem, ['diterima', 'diproses'], true);
            }
            return $statusItem === $statusDicari;
        })->count();
    };

    $jumlahBaru = $hitungStatus('baru');
    $jumlahDiterima = $hitungStatus('diterima');
    $jumlahDialihkan = $hitungStatus('dialihkan');
    $jumlahSelesai = $hitungStatus('selesai');

    $statusLabel = function ($status) {
        $status = strtolower(trim((string) $status));
        return match ($status) {
            'baru', 'menunggu' => 'Baru',
            'diterima', 'diproses' => 'Diterima',
            'dialihkan' => 'Dialihkan',
            'selesai' => 'Selesai',
            default => ucfirst(str_replace('_', ' ', $status ?: 'Baru')),
        };
    };

    $statusClass = function ($status) {
        $status = strtolower(trim((string) $status));
        return match ($status) {
            'baru', 'menunggu' => 'status-baru',
            'diterima', 'diproses' => 'status-diterima',
            'dialihkan' => 'status-dialihkan',
            'selesai' => 'status-selesai',
            default => 'status-baru',
        };
    };
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kotak Masuk {{ $namaBidang }} - SIKUTA BKAD Kabupaten Tapin</title>

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
        button, input, select { font-family: inherit; }

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

        .menu-link:hover {
            background: var(--color-primary-active);
            color: #ffffff;
        }

        .menu-link.active {
            background: var(--color-primary-active);
            color: #ffffff;
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .menu-badge {
            margin-left: auto;
            background: var(--color-status-baru-bg);
            color: var(--color-status-baru-text);
            padding: 3px 8px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 800;
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

        /* MAIN CONTENT AREA */
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

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .bidang-pill {
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

        /* NOTIFICATION BELL & PANEL */
        .bell-wrapper {
            position: relative;
        }

        .bell-btn {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #ffffff;
            border: 1px solid var(--color-border);
            color: var(--color-text-secondary);
            font-size: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            transition: all 0.2s ease;
        }

        .bell-btn:hover {
            color: var(--color-primary);
            border-color: var(--color-primary);
            background: var(--color-primary-light);
        }

        .bell-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            min-width: 18px;
            height: 18px;
            padding: 0 4px;
            border-radius: 999px;
            background: var(--color-danger);
            color: #ffffff;
            font-size: 10px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #ffffff;
        }

        .bell-badge[hidden] { display: none !important; }

        .notification-panel {
            position: absolute;
            top: 52px;
            right: 0;
            width: 380px;
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
            z-index: 500;
            overflow: hidden;
            animation: fadeInPanel 0.2s ease;
        }

        .notification-panel[hidden] { display: none !important; }

        @keyframes fadeInPanel {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .panel-header {
            padding: 14px 16px;
            border-bottom: 1px solid var(--color-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fbfdfc;
        }

        .panel-header h3 {
            font-size: 14px;
            font-weight: 800;
            color: var(--color-primary-dark);
        }

        .panel-header p {
            font-size: 11px;
            color: var(--color-text-secondary);
        }

        .btn-close-panel {
            background: transparent;
            border: none;
            color: var(--color-text-secondary);
            font-size: 16px;
            cursor: pointer;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-close-panel:hover {
            background: var(--color-bg);
            color: var(--color-text);
        }

        .notification-list {
            max-height: 320px;
            overflow-y: auto;
        }

        .notification-item {
            display: flex;
            gap: 12px;
            padding: 12px 16px;
            border-bottom: 1px solid #f0f4f3;
            transition: background 0.15s ease;
        }

        .notification-item:hover {
            background: var(--color-primary-light);
        }

        .notification-item-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--color-primary-light);
            color: var(--color-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 13px;
        }

        .notification-item-content strong {
            font-size: 13px;
            color: var(--color-text);
            display: block;
        }

        .notification-item-content p {
            font-size: 11px;
            color: var(--color-text-secondary);
            margin: 2px 0 4px;
        }

        .notification-item-content a {
            font-size: 12px;
            font-weight: 700;
            color: var(--color-primary);
        }

        .notification-empty {
            padding: 32px 16px;
            text-align: center;
            color: var(--color-text-secondary);
            font-size: 13px;
        }

        .notification-empty i {
            font-size: 28px;
            color: var(--color-border);
            margin-bottom: 8px;
            display: block;
        }

        .panel-footer {
            padding: 10px 16px;
            background: #fbfdfc;
            border-top: 1px solid var(--color-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .btn-sound-settings {
            background: transparent;
            border: 1px solid var(--color-border);
            color: var(--color-primary);
            padding: 6px 12px;
            border-radius: var(--radius-sm);
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }

        .btn-sound-settings:hover {
            background: var(--color-primary-light);
        }

        /* Sound Settings Floating Modal/Panel */
        .sound-modal {
            position: absolute;
            top: 52px;
            right: 0;
            width: 340px;
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            padding: 18px;
            box-shadow: var(--shadow-lg);
            z-index: 550;
        }

        .sound-modal[hidden] { display: none !important; }

        .sound-modal h4 {
            font-size: 14px;
            font-weight: 800;
            color: var(--color-primary-dark);
            margin-bottom: 4px;
        }

        .sound-modal p {
            font-size: 12px;
            color: var(--color-text-secondary);
            margin-bottom: 14px;
        }

        .sound-controls {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .sound-btn-row {
            display: flex;
            gap: 8px;
        }

        .btn-sound-action {
            flex: 1;
            padding: 8px 12px;
            border: 1px solid var(--color-border);
            border-radius: var(--radius-sm);
            background: var(--color-bg);
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            color: var(--color-text);
            transition: all 0.2s;
        }

        .btn-sound-action:hover {
            background: var(--color-primary-light);
            color: var(--color-primary);
            border-color: var(--color-primary);
        }

        /* CONTENT */
        .content {
            padding: 28px 32px 48px;
            flex: 1;
            max-width: 1400px;
            width: 100%;
            margin: 0 auto;
        }

        /* Alerts */
        .alert-box {
            padding: 12px 18px;
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

        /* Page Head */
        .content-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 26px;
            flex-wrap: wrap;
        }

        .content-header-title h2 {
            font-size: 24px;
            font-weight: 800;
            color: var(--color-primary-dark);
            letter-spacing: -0.3px;
            margin-bottom: 4px;
        }

        .content-header-title p {
            font-size: 13px;
            color: var(--color-text-secondary);
        }

        .btn-refresh {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            color: var(--color-text);
            padding: 9px 16px;
            border-radius: var(--radius-md);
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            box-shadow: var(--shadow-sm);
        }

        .btn-refresh:hover {
            border-color: var(--color-primary);
            color: var(--color-primary);
            background: var(--color-primary-light);
        }

        /* STATS CARDS */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 26px;
        }

        .stat-card {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: var(--shadow-sm);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
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

        .stat-icon.total { background: var(--color-primary-light); color: var(--color-primary); }
        .stat-icon.baru { background: var(--color-status-baru-bg); color: var(--color-status-baru-text); }
        .stat-icon.proses { background: var(--color-status-diterima-bg); color: var(--color-status-diterima-text); }
        .stat-icon.selesai { background: var(--color-status-selesai-bg); color: var(--color-status-selesai-text); }

        .stat-value {
            font-size: 26px;
            font-weight: 800;
            color: var(--color-primary-dark);
            line-height: 1.1;
        }

        .stat-label {
            font-size: 12px;
            color: var(--color-text-secondary);
            font-weight: 600;
            margin-top: 2px;
        }

        /* MAIN PANEL: FILTERS & TABLE */
        .panel {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        /* Filter Form */
        .filters-form {
            padding: 20px 24px;
            border-bottom: 1px solid var(--color-border);
            display: flex;
            align-items: flex-end;
            gap: 14px;
            flex-wrap: wrap;
            background: #fafcfb;
        }

        .filter-field {
            display: flex;
            flex-direction: column;
            gap: 6px;
            flex: 1 1 200px;
        }

        .filter-field label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--color-text-secondary);
        }

        .search-input-wrap {
            position: relative;
        }

        .search-input-wrap i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--color-text-secondary);
            font-size: 13px;
        }

        .search-input-wrap input {
            padding-left: 36px;
        }

        .form-control {
            width: 100%;
            height: 40px;
            padding: 8px 14px;
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
            font-size: 13px;
            color: var(--color-text);
            background: #ffffff;
            outline: none;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(7, 133, 119, 0.15);
        }

        .filter-actions {
            display: flex;
            gap: 8px;
        }

        .btn-filter {
            height: 40px;
            padding: 0 18px;
            background: var(--color-primary);
            color: #ffffff;
            border: none;
            border-radius: var(--radius-md);
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background 0.2s;
        }

        .btn-filter:hover { background: var(--color-primary-hover); }

        .btn-reset-filter {
            height: 40px;
            padding: 0 14px;
            background: #ffffff;
            border: 1px solid var(--color-border);
            color: var(--color-text-secondary);
            border-radius: var(--radius-md);
            font-size: 13px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .btn-reset-filter:hover {
            color: var(--color-text);
            background: var(--color-bg);
        }

        /* Filter Tabs */
        .status-tabs {
            padding: 12px 24px;
            border-bottom: 1px solid var(--color-border);
            display: flex;
            gap: 8px;
            overflow-x: auto;
            background: var(--color-surface);
        }

        .tab-pill {
            padding: 7px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            color: var(--color-text-secondary);
            background: #f1f5f4;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .tab-pill:hover {
            background: var(--color-primary-light);
            color: var(--color-primary);
        }

        .tab-pill.active {
            background: var(--color-primary);
            color: #ffffff;
        }

        .tab-count {
            background: rgba(0, 0, 0, 0.08);
            padding: 2px 6px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 800;
        }

        .tab-pill.active .tab-count {
            background: rgba(255, 255, 255, 0.25);
            color: #ffffff;
        }

        /* TABLE */
        .table-responsive {
            overflow-x: auto;
            width: 100%;
        }

        .inbox-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            text-align: left;
        }

        .inbox-table th {
            background: #fafcfb;
            color: var(--color-text-secondary);
            font-weight: 700;
            padding: 14px 20px;
            border-bottom: 1px solid var(--color-border);
            white-space: nowrap;
        }

        .inbox-table td {
            padding: 16px 20px;
            border-bottom: 1px solid var(--color-border);
            vertical-align: middle;
            color: var(--color-text);
        }

        .inbox-table tbody tr:last-child td { border-bottom: none; }
        .inbox-table tbody tr:hover { background: #fbfdfc; }

        .time-badge {
            font-weight: 800;
            color: var(--color-primary-dark);
            font-size: 13px;
            white-space: nowrap;
        }

        .visitor-cell strong {
            font-size: 13px;
            color: var(--color-primary-dark);
            display: block;
            margin-bottom: 2px;
        }

        .visitor-cell span {
            font-size: 11px;
            color: var(--color-text-secondary);
        }

        .purpose-cell {
            max-width: 280px;
            line-height: 1.45;
            color: var(--color-text);
        }

        /* STATUS BADGES */
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

        .btn-detail {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            background: var(--color-bg);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
            font-size: 12px;
            font-weight: 700;
            color: var(--color-primary);
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .btn-detail:hover {
            background: var(--color-primary);
            color: #ffffff;
            border-color: var(--color-primary);
        }

        .empty-row {
            text-align: center;
            padding: 48px 20px !important;
            color: var(--color-text-secondary);
        }

        .empty-row i {
            font-size: 36px;
            color: var(--color-border);
            margin-bottom: 10px;
            display: block;
        }

        .pagination-box {
            padding: 16px 24px;
            border-top: 1px solid var(--color-border);
        }

        /* TOAST NOTIFICATION POPUP */
        .notification-toast {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 1000;
            width: 360px;
            background: #ffffff;
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            padding: 16px;
            box-shadow: var(--shadow-lg);
            display: none;
            animation: slideUp 0.3s ease;
        }

        .notification-toast.show { display: block; }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .toast-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .toast-title {
            font-size: 13px;
            font-weight: 800;
            color: var(--color-primary);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .toast-close {
            background: transparent;
            border: none;
            color: var(--color-text-secondary);
            font-size: 16px;
            cursor: pointer;
        }

        .toast-body {
            font-size: 12px;
            color: var(--color-text);
            margin-bottom: 10px;
            line-height: 1.4;
        }

        .toast-action {
            font-size: 12px;
            font-weight: 700;
            color: var(--color-primary);
            text-decoration: underline;
        }

        /* RESPONSIVE */
        @media (max-width: 1024px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-wrapper {
                margin-left: 0;
            }

            .btn-menu-mobile {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .topbar {
                padding: 0 16px;
            }

            .content {
                padding: 20px 16px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .filters-form {
                padding: 16px;
            }

            .filter-field {
                flex: 1 1 100%;
            }

            .notification-panel, .sound-modal {
                width: calc(100vw - 32px);
                right: -8px;
            }

            .notification-toast {
                width: calc(100vw - 32px);
                right: 16px;
                bottom: 16px;
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
            <a href="{{ route('kunjungan.inbox', ['kode' => $kode]) }}" class="menu-link active">
                <i class="fa-solid fa-inbox"></i>
                <span>Kotak Masuk</span>
                @if($jumlahBaru > 0)
                    <span class="menu-badge">{{ $jumlahBaru }}</span>
                @endif
            </a>

            @if(Route::has('pengaturan-bidang.notifikasi'))
                <a href="{{ route('pengaturan-bidang.notifikasi') }}" class="menu-link">
                    <i class="fa-solid fa-sliders"></i>
                    <span>Pengaturan Suara</span>
                </a>
            @endif
        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="sidebar-user-avatar">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div>
                    <div class="sidebar-user-name">{{ $user->name ?? 'Petugas Bidang' }}</div>
                    <div class="sidebar-user-role">{{ $namaBidang }}</div>
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
                    <h1>Kotak Masuk Kunjungan</h1>
                    <p>{{ $namaBidang }} &bull; BKAD Kabupaten Tapin</p>
                </div>
            </div>

            <div class="topbar-actions">
                <div class="bidang-pill">
                    <i class="fa-solid fa-shield-halved"></i>
                    <span>{{ $kode }}</span>
                </div>

                {{-- Notification Bell --}}
                <div class="bell-wrapper">
                    <button type="button" class="bell-btn" id="notificationBell"
                        aria-label="Notifikasi kunjungan baru" aria-expanded="false">
                        <i class="fa-regular fa-bell"></i>
                        <span class="bell-badge" id="notificationCount" hidden>0</span>
                    </button>

                    {{-- Notification List Panel --}}
                    <section class="notification-panel" id="notificationPanel" hidden>
                        <div class="panel-header">
                            <div>
                                <h3>Notifikasi Kunjungan Baru</h3>
                                <p id="notificationPanelSubtitle">Memeriksa kunjungan baru...</p>
                            </div>
                            <button type="button" class="btn-close-panel" id="closeNotificationPanel">&times;</button>
                        </div>

                        <div class="notification-list" id="notificationList">
                            <div class="notification-empty">
                                <i class="fa-regular fa-bell"></i>
                                <span>Belum ada kunjungan baru.</span>
                            </div>
                        </div>

                        <div class="panel-footer">
                            <button type="button" class="btn-sound-settings" id="openSoundSettings">
                                <i class="fa-solid fa-volume-high"></i>
                                <span>Pengaturan Audio</span>
                            </button>
                        </div>
                    </section>

                    {{-- Audio Sound Settings Panel --}}
                    <section class="sound-modal" id="notificationSettings" hidden>
                        <h4><i class="fa-solid fa-volume-high"></i> Pengaturan Audio</h4>
                        <p>Atur suara peringatan ketika ada tamu baru masuk ke bidang ini.</p>

                        <div class="sound-controls">
                            <input type="file" id="notificationSoundFile" accept="audio/*" style="font-size: 11px;">

                            <div class="sound-btn-row">
                                <button type="button" class="btn-sound-action" id="testNotificationSound">
                                    <i class="fa-solid fa-play"></i> Tes
                                </button>
                                <button type="button" class="btn-sound-action" id="toggleNotificationSound">
                                    <i class="fa-solid fa-volume-high"></i> Suara Aktif
                                </button>
                            </div>

                            <button type="button" class="btn-sound-action" id="closeSoundSettings" style="margin-top: 4px;">
                                Tutup Pengaturan
                            </button>

                            <p id="soundMessage" style="margin: 6px 0 0; font-size: 11px; color: var(--color-primary);"></p>
                        </div>
                    </section>
                </div>
            </div>
        </header>

        {{-- CONTENT --}}
        <main class="content">

            {{-- Alerts --}}
            @if(session('success'))
                <div class="alert-box success">
                    <i class="fa-solid fa-circle-check"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if(session('error'))
                <div class="alert-box error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            {{-- Content Head --}}
            <div class="content-header">
                <div class="content-header-title">
                    <h2>Daftar Kunjungan Masuk</h2>
                     <p>{{ now()->locale('id')->dayName }}, {{ now()->locale('id')->day }} {{ now()->locale('id')->monthName }} {{ now()->locale('id')->year }} &bull; Layanan tamu Bidang {{ $namaBidang }}</p>
                </div>

                <button type="button" class="btn-refresh" onclick="window.location.reload()">
                    <i class="fa-solid fa-rotate"></i>
                    <span>Segarkan Data</span>
                </button>
            </div>

            {{-- STATS CARDS --}}
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon total">
                        <i class="fa-solid fa-clipboard-list"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $jumlahKunjungan }}</div>
                        <div class="stat-label">Total Kunjungan</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon baru">
                        <i class="fa-solid fa-bell"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $jumlahBaru }}</div>
                        <div class="stat-label">Tamu Baru Menunggu</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon proses">
                        <i class="fa-solid fa-user-clock"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $jumlahDiterima }}</div>
                        <div class="stat-label">Sedang Diproses</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon selesai">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $jumlahSelesai }}</div>
                        <div class="stat-label">Tamu Selesai</div>
                    </div>
                </div>
            </div>

            {{-- PANEL: FILTERS & TABLE --}}
            <div class="panel">

                {{-- Filters Form --}}
                <form method="GET" action="{{ route('kunjungan.inbox', $kode) }}" class="filters-form">
                    <div class="filter-field">
                        <label for="searchQuery">Pencarian Tamu</label>
                        <div class="search-input-wrap">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input
                                type="text"
                                id="searchQuery"
                                name="q"
                                class="form-control"
                                placeholder="Nama, instansi, atau keperluan..."
                                value="{{ request('q') }}"
                            >
                        </div>
                    </div>

                    <div class="filter-field" style="max-width: 200px;">
                        <label for="filterTanggal">Tanggal</label>
                        <input
                            type="date"
                            id="filterTanggal"
                            name="tanggal"
                            class="form-control"
                            value="{{ request('tanggal') }}"
                        >
                    </div>

                    <div class="filter-field" style="max-width: 200px;">
                        <label for="filterStatus">Status</label>
                        <select id="filterStatus" name="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="baru" @selected(request('status') === 'baru')>Baru</option>
                            <option value="diterima" @selected(request('status') === 'diterima')>Diterima</option>
                            <option value="dialihkan" @selected(request('status') === 'dialihkan')>Dialihkan</option>
                            <option value="selesai" @selected(request('status') === 'selesai')>Selesai</option>
                        </select>
                    </div>

                    <div class="filter-actions">
                        <button type="submit" class="btn-filter">
                            <i class="fa-solid fa-filter"></i>
                            <span>Terapkan</span>
                        </button>

                        @if(request('q') || request('tanggal') || request('status'))
                            <a href="{{ route('kunjungan.inbox', $kode) }}" class="btn-reset-filter" title="Reset filter">
                                <i class="fa-solid fa-rotate-left"></i>
                            </a>
                        @endif
                    </div>
                </form>

                {{-- Quick Status Tabs --}}
                <div class="status-tabs">
                    <a href="{{ route('kunjungan.inbox', array_filter(['kode' => $kode, 'q' => request('q'), 'tanggal' => request('tanggal')], fn ($v) => $v !== null && $v !== '')) }}"
                       class="tab-pill {{ !request('status') ? 'active' : '' }}">
                        <span>Semua</span>
                        <span class="tab-count">{{ $jumlahKunjungan }}</span>
                    </a>

                    <a href="{{ route('kunjungan.inbox', array_filter(['kode' => $kode, 'q' => request('q'), 'tanggal' => request('tanggal'), 'status' => 'baru'], fn ($v) => $v !== null && $v !== '')) }}"
                       class="tab-pill {{ request('status') === 'baru' ? 'active' : '' }}">
                        <span>Baru</span>
                        <span class="tab-count">{{ $jumlahBaru }}</span>
                    </a>

                    <a href="{{ route('kunjungan.inbox', array_filter(['kode' => $kode, 'q' => request('q'), 'tanggal' => request('tanggal'), 'status' => 'diterima'], fn ($v) => $v !== null && $v !== '')) }}"
                       class="tab-pill {{ request('status') === 'diterima' ? 'active' : '' }}">
                        <span>Diterima</span>
                        <span class="tab-count">{{ $jumlahDiterima }}</span>
                    </a>

                    <a href="{{ route('kunjungan.inbox', array_filter(['kode' => $kode, 'q' => request('q'), 'tanggal' => request('tanggal'), 'status' => 'dialihkan'], fn ($v) => $v !== null && $v !== '')) }}"
                       class="tab-pill {{ request('status') === 'dialihkan' ? 'active' : '' }}">
                        <span>Dialihkan</span>
                        <span class="tab-count">{{ $jumlahDialihkan }}</span>
                    </a>

                    <a href="{{ route('kunjungan.inbox', array_filter(['kode' => $kode, 'q' => request('q'), 'tanggal' => request('tanggal'), 'status' => 'selesai'], fn ($v) => $v !== null && $v !== '')) }}"
                       class="tab-pill {{ request('status') === 'selesai' ? 'active' : '' }}">
                        <span>Selesai</span>
                        <span class="tab-count">{{ $jumlahSelesai }}</span>
                    </a>
                </div>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="inbox-table">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Pengunjung</th>
                                <th>Keperluan</th>
                                <th>Bidang Tujuan</th>
                                <th>Status</th>
                                <th style="text-align: right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kunjungans as $kunjungan)
                                <tr>
                                    <td>
                                        <div class="time-badge">
                                            {{ $kunjungan->created_at?->timezone('Asia/Makassar')->format('H:i') ?? '-' }} WITA
                                        </div>
                                    </td>
                                    <td>
                                        <div class="visitor-cell">
                                            <strong>{{ $kunjungan->nama_pengunjung }}</strong>
                                            <span>{{ $kunjungan->instansi ?: 'Instansi tidak dicantumkan' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="purpose-cell">
                                            {{ \Illuminate\Support\Str::limit($kunjungan->keperluan, 85) }}
                                        </div>
                                    </td>
                                    <td>
                                        <span style="font-weight: 600; font-size: 12px; color: var(--color-primary-dark);">
                                            {{ $kunjungan->bidangTujuan?->nama ?? $namaBidang }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="status-badge {{ $statusClass($kunjungan->status) }}">
                                            @if(in_array(strtolower($kunjungan->status), ['baru', 'menunggu']))
                                                <i class="fa-solid fa-circle-dot"></i>
                                            @elseif(in_array(strtolower($kunjungan->status), ['diterima', 'diproses']))
                                                <i class="fa-solid fa-spinner"></i>
                                            @elseif(strtolower($kunjungan->status) === 'dialihkan')
                                                <i class="fa-solid fa-share"></i>
                                            @elseif(strtolower($kunjungan->status) === 'selesai')
                                                <i class="fa-solid fa-circle-check"></i>
                                            @endif
                                            <span>{{ $statusLabel($kunjungan->status) }}</span>
                                        </span>
                                    </td>
                                    <td style="text-align: right;">
                                        <a href="{{ route('kunjungan.show', $kunjungan->id) }}" class="btn-detail">
                                            <span>Lihat Detail</span>
                                            <i class="fa-solid fa-arrow-right"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="empty-row">
                                        <i class="fa-regular fa-folder-open"></i>
                                        <strong style="display: block; margin-bottom: 4px; color: var(--color-text);">Belum Ada Kunjungan</strong>
                                        <span>Tidak ada data tamu yang cocok dengan filter atau kata kunci pencarian.</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($kunjungans instanceof \Illuminate\Pagination\AbstractPaginator)
                    <div class="pagination-box">
                        {{ $kunjungans->withQueryString()->links() }}
                    </div>
                @endif

            </div>

        </main>

    </div>

    {{-- TOAST NOTIFICATION POPUP --}}
    <div class="notification-toast" id="notificationToast" role="status" aria-live="polite">
        <div class="toast-header">
            <div class="toast-title">
                <i class="fa-solid fa-bell"></i>
                <span>Kunjungan Baru Masuk!</span>
            </div>
            <button type="button" class="toast-close" id="closeNotificationToast">&times;</button>
        </div>
        <p class="toast-body" id="notificationToastText">Ada tamu dinas baru menunggu di meja lobi.</p>
        <a href="#" class="toast-action" id="notificationToastLink">Lihat detail kunjungan &rarr;</a>
    </div>

    <audio id="notificationAudio" preload="auto"></audio>

    {{-- SCRIPTS: RESPONSIVE SIDEBAR & NOTIFICATION POLLING --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            /* 1. MOBILE SIDEBAR TOGGLE */
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

            /* 2. NOTIFICATION SYSTEM & POLLING */
            const badge = document.getElementById('notificationCount');
            const bell = document.getElementById('notificationBell');
            const fileInput = document.getElementById('notificationSoundFile');
            const audio = document.getElementById('notificationAudio');
            const testButton = document.getElementById('testNotificationSound');
            const toggleButton = document.getElementById('toggleNotificationSound');
            const soundMessage = document.getElementById('soundMessage');
            const toast = document.getElementById('notificationToast');
            const toastText = document.getElementById('notificationToastText');
            const toastLink = document.getElementById('notificationToastLink');
            const closeToast = document.getElementById('closeNotificationToast');
            const panel = document.getElementById('notificationPanel');
            const closePanel = document.getElementById('closeNotificationPanel');
            const notificationList = document.getElementById('notificationList');
            const panelSubtitle = document.getElementById('notificationPanelSubtitle');
            const openSoundSettings = document.getElementById('openSoundSettings');
            const settingsPanel = document.getElementById('notificationSettings');
            const closeSoundSettings = document.getElementById('closeSoundSettings');

            if (!badge || !bell) return;

            const notificationUrl = @json(route('kunjungan.notifikasi-baru'));
            let soundEnabled = true;
            try {
                soundEnabled = localStorage.getItem('sikutaNotificationSoundEnabled') !== 'false';
            } catch (err) {}

            let customSoundUrl = null;
            let audioContext = null;
            let checking = false;
            let initialized = false;
            let previousIds = new Set();
            let toastTimeout = null;

            function updateSoundButton() {
                if (!toggleButton) return;
                toggleButton.innerHTML = soundEnabled
                    ? '<i class="fa-solid fa-volume-high"></i> Suara Aktif'
                    : '<i class="fa-solid fa-volume-xmark"></i> Suara Mati';
            }
            updateSoundButton();

            function closePanelView() {
                if (!panel) return;
                panel.hidden = true;
                bell.setAttribute('aria-expanded', 'false');
                if (settingsPanel) settingsPanel.hidden = true;
            }

            bell.addEventListener('click', function () {
                if (!panel) return;
                if (panel.hidden) {
                    panel.hidden = false;
                    bell.setAttribute('aria-expanded', 'true');
                    updateNotificationCount(true);
                } else {
                    closePanelView();
                }
            });

            if (closePanel) closePanel.addEventListener('click', closePanelView);

            if (openSoundSettings) {
                openSoundSettings.addEventListener('click', function () {
                    if (settingsPanel) settingsPanel.hidden = !settingsPanel.hidden;
                });
            }

            if (closeSoundSettings) {
                closeSoundSettings.addEventListener('click', function () {
                    if (settingsPanel) settingsPanel.hidden = true;
                });
            }

            document.addEventListener('click', function (event) {
                if (panel && !panel.hidden && !panel.contains(event.target) && !bell.contains(event.target)) {
                    closePanelView();
                }
            });

            function renderNotificationList(items) {
                if (!notificationList) return;
                notificationList.replaceChildren();

                if (!items.length) {
                    const empty = document.createElement('div');
                    empty.className = 'notification-empty';
                    empty.innerHTML = '<i class="fa-regular fa-bell"></i><div>Belum ada kunjungan baru.</div>';
                    notificationList.appendChild(empty);
                    return;
                }

                items.forEach(function (item) {
                    const row = document.createElement('div');
                    row.className = 'notification-item';

                    const icon = document.createElement('div');
                    icon.className = 'notification-item-icon';
                    icon.innerHTML = '<i class="fa-solid fa-user"></i>';

                    const content = document.createElement('div');
                    content.className = 'notification-item-content';

                    const name = document.createElement('strong');
                    name.textContent = item.nama || 'Pengunjung';

                    const instansi = document.createElement('p');
                    instansi.textContent = item.instansi || 'Instansi tidak dicantumkan';

                    const link = document.createElement('a');
                    link.href = item.url || '#';
                    link.textContent = 'Lihat detail kunjungan →';

                    content.append(name, instansi, link);
                    row.append(icon, content);
                    notificationList.appendChild(row);
                });
            }

            function showToast(item) {
                if (!toast || !item) return;
                const nama = item.nama || 'Pengunjung';
                const instansi = item.instansi || 'Instansi tidak dicantumkan';
                toastText.textContent = nama + ' • ' + instansi;
                toastLink.href = item.url || '#';
                toast.classList.add('show');
                window.clearTimeout(toastTimeout);
                toastTimeout = window.setTimeout(function () {
                    toast.classList.remove('show');
                }, 10000);
            }

            if (closeToast) {
                closeToast.addEventListener('click', function () {
                    toast.classList.remove('show');
                    window.clearTimeout(toastTimeout);
                });
            }

            async function playDefaultSound() {
                const AudioContextClass = window.AudioContext || window.webkitAudioContext;
                if (!AudioContextClass) return;
                if (!audioContext || audioContext.state === 'closed') audioContext = new AudioContextClass();
                if (audioContext.state === 'suspended') await audioContext.resume();

                const startAt = audioContext.currentTime;
                const oscillator = audioContext.createOscillator();
                const gain = audioContext.createGain();
                oscillator.type = 'sine';
                oscillator.frequency.setValueAtTime(880, startAt);
                oscillator.frequency.setValueAtTime(660, startAt + 0.16);
                gain.gain.setValueAtTime(0.0001, startAt);
                gain.gain.exponentialRampToValueAtTime(0.14, startAt + 0.025);
                gain.gain.setValueAtTime(0.0001, startAt + 0.42);
                oscillator.connect(gain);
                gain.connect(audioContext.destination);
                oscillator.start(startAt);
                oscillator.stop(startAt + 0.43);
            }

            async function playNotificationSound() {
                if (!soundEnabled) return;
                try {
                    if (customSoundUrl) {
                        audio.pause();
                        audio.currentTime = 0;
                        audio.src = customSoundUrl;
                        await audio.play();
                    } else {
                        await playDefaultSound();
                    }
                    if (soundMessage) soundMessage.textContent = 'Suara berhasil diputar.';
                } catch (error) {
                    if (soundMessage) soundMessage.textContent = 'Klik Tes Suara untuk memberi izin pemutaran audio browser.';
                }
            }

            if (fileInput) {
                fileInput.addEventListener('change', function () {
                    const file = fileInput.files && fileInput.files[0];
                    if (!file) return;
                    if (!file.type.startsWith('audio/')) {
                        if (soundMessage) soundMessage.textContent = 'File harus berformat audio.';
                        fileInput.value = '';
                        return;
                    }
                    if (customSoundUrl) URL.revokeObjectURL(customSoundUrl);
                    customSoundUrl = URL.createObjectURL(file);
                    audio.src = customSoundUrl;
                    if (soundMessage) soundMessage.textContent = 'Suara khusus dipilih: ' + file.name;
                });
            }

            if (testButton) {
                testButton.addEventListener('click', function () {
                    playNotificationSound();
                });
            }

            if (toggleButton) {
                toggleButton.addEventListener('click', function () {
                    soundEnabled = !soundEnabled;
                    try { localStorage.setItem('sikutaNotificationSoundEnabled', String(soundEnabled)); } catch (err) {}
                    updateSoundButton();
                    if (soundMessage) soundMessage.textContent = soundEnabled
                        ? 'Suara notifikasi diaktifkan.' : 'Suara notifikasi dinonaktifkan.';
                });
            }

            async function updateNotificationCount(forceRender = false) {
                if (checking || (document.hidden && !forceRender)) return;
                checking = true;

                try {
                    const response = await fetch(notificationUrl, {
                        method: 'GET',
                        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                        credentials: 'same-origin',
                        cache: 'no-store'
                    });
                    if (!response.ok) throw new Error('HTTP ' + response.status);

                    const data = await response.json();
                    const count = Math.max(0, Number(data.count) || 0);
                    const items = Array.isArray(data.items) ? data.items : [];

                    badge.textContent = count > 99 ? '99+' : String(count);
                    badge.hidden = count === 0;
                    bell.setAttribute('aria-label', count > 0 ? count + ' kunjungan baru' : 'Tidak ada kunjungan baru');

                    if (panelSubtitle) {
                        panelSubtitle.textContent = count > 0
                            ? count + ' kunjungan menunggu respon'
                            : 'Tidak ada kunjungan baru';
                    }

                    renderNotificationList(items);

                    const currentIds = new Set(items.map(function (item) { return String(item.id); }));
                    if (!initialized) {
                        previousIds = currentIds;
                        initialized = true;
                        return;
                    }

                    const newItems = items.filter(function (item) { return !previousIds.has(String(item.id)); });
                    if (newItems.length > 0) {
                        showToast(newItems[0]);
                        await playNotificationSound();
                    }
                    previousIds = currentIds;
                } catch (error) {
                    console.error('Notifikasi SIKUTA:', error);
                } finally {
                    checking = false;
                }
            }

            updateNotificationCount();
            window.setInterval(updateNotificationCount, 5000);
            document.addEventListener('visibilitychange', function () {
                if (!document.hidden) updateNotificationCount();
            });

        });
    </script>
</body>
</html>
