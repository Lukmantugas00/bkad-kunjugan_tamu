<aside class="sidebar" id="sidebar">
    <div class="brand-header">
        <div class="brand-logo" style="width: 44px; height: 44px;">
            <img src="<?php echo e(asset('images/logo.jpg')); ?>" alt="Logo BKAD Kabupaten Tapin" style="width: 100%; height: 100%; object-fit: contain; border-radius: var(--radius-md);">
        </div>
        <div>
            <div class="brand-title">SIKUTA</div>
            <div class="brand-sub">BKAD KABUPATEN TAPIN</div>
        </div>
    </div>

    <nav class="menu-list">
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="menu-link <?php echo e($active === 'dashboard' ? 'active' : ''); ?>">
            <i class="fa-solid fa-gauge-high"></i>
            <span>Dashboard</span>
        </a>

        <a href="<?php echo e(route('admin.users.index')); ?>" class="menu-link <?php echo e($active === 'users' ? 'active' : ''); ?>">
            <i class="fa-solid fa-users"></i>
            <span>Kelola Akun</span>
        </a>

        <a href="<?php echo e(route('admin.bidangs.index')); ?>" class="menu-link <?php echo e($active === 'bidangs' ? 'active' : ''); ?>">
            <i class="fa-solid fa-building"></i>
            <span>Master Bidang</span>
        </a>

        <a href="<?php echo e(route('admin.kunjungan.index')); ?>" class="menu-link <?php echo e($active === 'kunjungan' ? 'active' : ''); ?>">
            <i class="fa-solid fa-clipboard-list"></i>
            <span>Data Kunjungan</span>
        </a>

        <a href="<?php echo e(route('admin.laporan.index')); ?>" class="menu-link <?php echo e($active === 'laporan' ? 'active' : ''); ?>">
            <i class="fa-solid fa-chart-bar"></i>
            <span>Laporan & Rekap</span>
        </a>

        <a href="<?php echo e(route('admin.activity_logs.index')); ?>" class="menu-link <?php echo e($active === 'activity_logs' ? 'active' : ''); ?>">
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
                <div class="sidebar-user-name"><?php echo e(auth()->user()->name); ?></div>
                <div class="sidebar-user-role">Administrator</div>
            </div>
        </div>

        <form method="POST" action="<?php echo e(route('logout')); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn-sidebar-logout">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                <span>Keluar Sistem</span>
            </button>
        </form>
    </div>
</aside>
<?php /**PATH C:\laragon\www\bkad-kunjungan_tamu\resources\views/partials/sidebar.blade.php ENDPATH**/ ?>