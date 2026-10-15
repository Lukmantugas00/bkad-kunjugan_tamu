<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SIKUTA BKAD Kabupaten Tapin</title>

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        /* CSS from dashboard's <?php $__env->startPush('styles'); ?> but replace .admin-pill with .topbar-badge */
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

        .topbar-badge {
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

        /* Stats Grid & Tables */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        .stat-card {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            padding: 20px;
            text-align: center;
        }
        .stat-card:hover {
            box-shadow: var(--shadow-md);
        }
        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 10px;
            display: inline-block;
        }
        .stat-icon i {
            /* color will be set via utility classes */
        }
        .stat-content {
            /* nothing */
        }
        .stat-label {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--color-text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin-bottom: 4px;
        }
        .stat-value {
            font-size: 2rem;
            font-weight: 800;
            color: var(--color-primary-dark);
            line-height: 1.2;
        }
        .stat-desc {
            font-size: 0.85rem;
            color: var(--color-text-secondary);
            margin-top: 4px;
        }
        .trend-indicator {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-top: 6px;
        }
        .trend-up {
            background: var(--color-success-light);
            color: var(--color-success);
        }
        .trend-down {
            background: var(--color-danger-light);
            color: var(--color-danger);
        }
        .trend-stable {
            background: var(--color-info-light);
            color: var(--color-info);
        }
        .tables-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 24px;
        }
        .table-card {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }
        .table-header {
            background: #fafcfb;
            border-bottom: 1px solid var(--color-border);
            padding: 16px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .table-header h3 {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--color-primary-dark);
            margin: 0;
        }
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        .table-recent {
            width: 100%;
            border-collapse: collapse;
        }
        .table-recent th,
        .table-recent td {
            padding: 12px 14px;
            text-align: left;
            font-size: 0.9rem;
        }
        .table-recent th {
            background: #f8faf9;
            color: var(--color-text-secondary);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            border-bottom: 1px solid var(--color-border);
        }
        .table-recent tbody tr {
            border-bottom: 1px solid #edf2f0;
        }
        .table-recent tbody tr:hover {
            background: #fbfdfc;
        }
        .user-info {
            display: flex;
            flex-direction: column;
        }
        .user-name {
            font-weight: 600;
            color: var(--color-text);
        }
        .text-muted {
            color: var(--color-text-secondary);
            font-size: 0.85rem;
        }
        .btn-link {
            color: var(--color-primary);
            text-decoration: none;
        }
        .btn-link:hover {
            text-decoration: underline;
            color: var(--color-primary-hover);
        }
        .text-center {
            text-align: center;
        }
        .py-4 {
            padding-top: 1rem !important;
            padding-bottom: 1rem !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .tables-row {
                grid-template-columns: 1fr;
            }
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    
    <?php echo $__env->make('partials.sidebar', ['active' => 'dashboard'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <div class="main-wrapper">

        
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

            <div class="topbar-badge">
                <i class="fa-solid fa-shield-halved"></i>
                <span>Mode Administrator</span>
            </div>
        </header>

        
        <main class="content">

            <?php if(session('success')): ?>
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <span><?php echo e(session('success')); ?></span>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span><?php echo e(session('error')); ?></span>
                </div>
            <?php endif; ?>

            <!-- Welcome Card -->
            <div class="welcome-card">
                <div class="welcome-info">
                    <h2>Selamat datang, <?php echo e(auth()->user()->name); ?>!</h2>
                    <p>Anda memiliki hak akses penuh untuk mengelola pengguna, memelihara master bidang, mengoreksi data kunjungan, dan mencetak laporan rekapitulasi.</p>
                </div>
            </div>

            <!-- Statistics Grid -->
            <div class="stats-grid">
                <!-- Stat 1: Kunjungan Hari Ini -->
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fa-solid fa-calendar-day"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-label">Kunjungan Hari Ini</div>
                        <div class="stat-value"><?php echo e($kunjunganHariIni); ?></div>
                        <div class="stat-desc">Jumlah kunjungan tamu hari ini</div>
                    </div>
                </div>

                <!-- Stat 2: Kunjungan Bulan Ini -->
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-label">Kunjungan Bulan Ini</div>
                        <div class="stat-value"><?php echo e($kunjunganBulanIni); ?></div>
                        <div class="stat-desc">
                            <?php if($trendDirection === 'naik'): ?>
                                <span class="trend-indicator trend-up"><?php echo e($trendBulanIni); ?>% naik</span>
                            <?php elseif($trendDirection === 'turun'): ?>
                                <span class="trend-indicator trend-down"><?php echo e($trendBulanIni); ?>% turun</span>
                            <?php else: ?>
                                <span class="trend-indicator trend-stable">Stabil</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Stat 3: Menunggu Diproses -->
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fa-solid fa-hourglass-half"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-label">Menunggu Diproses</div>
                        <div class="stat-value"><?php echo e($menungguDiproses); ?></div>
                        <div class="stat-desc">Status baru atau diterima</div>
                    </div>
                </div>

                <!-- Stat 4: Akun Aktif -->
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fa-solid fa-user-check"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-label">Akun Aktif</div>
                        <div class="stat-value"><?php echo e($akunAktif); ?></div>
                        <div class="stat-desc">Pengguna dengan status aktif</div>
                    </div>
                </div>
            </div>

            <!-- Tables Row -->
            <div class="tables-row">
                <!-- Recent Kunjungan -->
                <div class="table-card">
                    <div class="table-header">
                        <h3>Kunjungan Terbaru</h3>
                        <a href="<?php echo e(route('admin.kunjungan.index')); ?>" class="btn-link">Lihat semua</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table-recent">
                            <thead>
                                <tr>
                                    <th>Nama Tamu</th>
                                    <th>Bidang</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($kunjunganTerbaru->isEmpty()): ?>
                                    <tr>
                                        <td colspan="4" class="text-center">Belum ada data kunjungan</td>
                                    </tr>
                                <?php else: ?>
                                    <?php $__currentLoopData = $kunjunganTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kunjungan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <div class="user-info">
                                                    <div class="user-name"><?php echo e($kunjungan->nama_pengunjung); ?></div>
                                                    <div class="text-muted"><?php echo e($kunjungan->nip); ?></div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php if($kunjungan->bidangTujuan): ?>
                                                    <span class="badge badge-default"><?php echo e($kunjungan->bidangTujuan->nama); ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php switch($kunjungan->status):
                                                    case ('baru'): ?>
                                                        <span class="badge badge-warning">Baru</span>
                                                    <?php break; ?>
                                                    <?php case ('diterima'): ?>
                                                        <span class="badge badge-info">Diterima</span>
                                                    <?php break; ?>
                                                    <?php case ('selesai'): ?>
                                                        <span class="badge badge-success">Selesai</span>
                                                    <?php break; ?>
                                                    <?php default: ?>
                                                        <span class="badge badge-secondary"><?php echo e(ucfirst($kunjungan->status)); ?></span>
                                                <?php endswitch; ?>
                                            </td>
                                            <td>
                                                <a href="<?php echo e(route('admin.kunjungan.show', $kunjungan)); ?>" class="btn btn-sm btn-outline-primary">
                                                    <i class="fa-solid fa-eye"></i> Detail
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Recent Aktivitas -->
                <div class="table-card">
                    <div class="table-header">
                        <h3>Aktivitas Terakhir</h3>
                        <a href="<?php echo e(route('admin.activity_logs.index')); ?>" class="btn-link">Lihat semua</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table-recent">
                            <thead>
                                <tr>
                                    <th>Waktu</th>
                                    <th>Pengguna</th>
                                    <th>aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($aktivitasTerakhir->isEmpty()): ?>
                                    <tr>
                                        <td colspan="3" class="text-center">Belum ada aktivitas</td>
                                    </tr>
                                <?php else: ?>
                                    <?php $__currentLoopData = $aktivitasTerakhir; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aktivitas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <?php echo e($aktivitas->created_at->timezone('Asia/Makassar')->format('d/m/Y H:i')); ?>

                                            </td>
                                            <td>
                                                <div class="user-info">
                                                    <div class="user-name"><?php echo e($aktivitas->user?->name ?? 'Pengguna dihapus'); ?></div>
                                                    <div class="text-muted"><?php echo e($aktivitas->user?->role ?? ''); ?></div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php echo e($aktivitas->aktivitas); ?>

                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </main>

        
        <footer class="footer">
            <div>&copy; <?php echo e(date('Y')); ?> BKAD Kabupaten Tapin &bull; SIKUTA (Sistem Informasi Kunjungan Tamu)</div>
        </footer>

    </div>

    
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
</html><?php /**PATH C:\laragon\www\bkad-kunjungan_tamu\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>