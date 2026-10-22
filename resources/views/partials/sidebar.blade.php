<aside class="sidebar" id="sidebar">
    <div class="brand-header">
        <div class="brand-logo" style="width: 76px; height: 76px;">
            <img src="{{ asset('images/logo.png') }}" alt="Logo BKAD Kabupaten Tapin" style="width: 100%; height: 100%; object-fit: contain; border-radius: var(--radius-md);">
        </div>
        <div>
            <div class="brand-title">SIKUTA</div>
            <div class="brand-sub">BKAD KABUPATEN TAPIN</div>
        </div>
    </div>

    <nav class="menu-list">
        <a href="{{ route('admin.dashboard') }}" class="menu-link {{ $active === 'dashboard' ? 'active' : '' }}">
            <i class="fa-solid fa-gauge-high"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('admin.users.index') }}" class="menu-link {{ $active === 'users' ? 'active' : '' }}">
            <i class="fa-solid fa-users"></i>
            <span>Kelola Akun</span>
        </a>

        <a href="{{ route('admin.bidangs.index') }}" class="menu-link {{ $active === 'bidangs' ? 'active' : '' }}">
            <i class="fa-solid fa-building"></i>
            <span>Master Bidang</span>
        </a>

        <a href="{{ route('admin.kunjungan.index') }}" class="menu-link {{ $active === 'kunjungan' ? 'active' : '' }}">
            <i class="fa-solid fa-clipboard-list"></i>
            <span>Data Kunjungan</span>
        </a>

        <a href="{{ route('admin.laporan.index') }}" class="menu-link {{ $active === 'laporan' ? 'active' : '' }}">
            <i class="fa-solid fa-chart-bar"></i>
            <span>Laporan & Rekap</span>
        </a>

        <a href="{{ route('admin.activity_logs.index') }}" class="menu-link {{ $active === 'activity_logs' ? 'active' : '' }}">
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


