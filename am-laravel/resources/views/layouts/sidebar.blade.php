<aside class="sidebar">
    <div class="sidebar-header">
        <div class="brand-title">
            <img src="{{ asset('images/ibsw.png') }}" alt="IBS Logo" style="height: 30px; width: auto;" class="me-1">
            <span style="font-weight: 800; color: #ffffff; letter-spacing: -0.3px;">AM ONLINE</span>
        </div>
        <div class="brand-sub">PT Infrastruktur Bisnis Sejahtera</div>
    </div>

    <div class="sidebar-user">
        <div class="user-avatar" style="background-color: #e61037;">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </div>
        <div style="overflow: hidden;">
            <div class="user-name">{{ Auth::user()->name }}</div>
            <div class="user-role">NIK: {{ Auth::user()->nik }}</div>
        </div>
    </div>

    <div class="sidebar-menu-wrapper">
        <div class="menu-heading">Menu Utama</div>
        <ul class="sidebar-nav">
            <li>
                <a href="{{ route('dashboard') }}" class="nav-item-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('budget-request.index') }}" class="nav-item-link {{ request()->routeIs('budget-request.*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Pengajuan AM</span>
                </a>
            </li>
            <li>
                <a href="{{ route('all-documents.index') }}" class="nav-item-link {{ request()->routeIs('all-documents.*') ? 'active' : '' }}">
                    <i class="bi bi-folder2-open"></i>
                    <span>Semua Dokumen</span>
                </a>
            </li>
        </ul>

        <div class="menu-heading">Lainnya</div>
        <ul class="sidebar-nav">
            <li>
                <a href="javascript:void(0)" class="nav-item-link" onclick="alert('Jika ada kendala sistem, hubungi bagian IT Helpdesk IBSW.')">
                    <i class="bi bi-question-circle"></i>
                    <span>Bantuan</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="sidebar-bottom">
        <form action="{{ route('logout') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="btn btn-outline-danger w-100 btn-sm py-1 d-flex align-items-center justify-content-center gap-1" style="font-size: 11.5px;">
                <i class="bi bi-box-arrow-right"></i> Keluar
            </button>
        </form>
    </div>
</aside>
