<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            <i class="bi bi-gem me-2"></i>
            <span>BUTIK DISEL</span>
        </a>
    </div>

    <ul class="sidebar-nav">
        <li class="sidebar-item">
            <a href="{{ route('admin.dashboard') }}"
                class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="sidebar-header-title">Manajemen Toko</li>

        <li class="sidebar-item">
            <a href="{{ route('admin.kategori.index') }}" class="sidebar-link {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                <i class="bi bi-tags"></i>
                <span>Kategori</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{ route('admin.produk.index') }}" class="sidebar-link {{ request()->routeIs('admin.produk.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i>
                <span>Produk</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="#" class="sidebar-link {{ request()->routeIs('admin.pesanan.*') ? 'active' : '' }}">
                <i class="bi bi-cart-check"></i>
                <span>Pesanan</span>
            </a>
        </li>

        <li class="sidebar-header-title">Manajemen Konten & Pengguna</li>

        <li class="sidebar-item">
            <a href="{{ route('admin.pelanggan.index') }}" class="sidebar-link {{ request()->routeIs('admin.pelanggan.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                <span>Pelanggan</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{ route('admin.admin.index') }}" class="sidebar-link {{ request()->routeIs('admin.admin.*') ? 'active' : '' }}">
                <i class="bi bi-person-lock"></i>
                <span>Admin</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{ route('admin.banner.index') }}" class="sidebar-link {{ request()->routeIs('admin.banner.*') ? 'active' : '' }}">
                <i class="bi bi-images"></i>
                <span>Banner</span>
            </a>
        </li>

        <li class="sidebar-header-title">Laporan</li>

        <li class="sidebar-item">
            <a href="#" class="sidebar-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-bar-graph"></i>
                <span>Laporan Penjualan</span>
            </a>
        </li>
    </ul>
</aside>
