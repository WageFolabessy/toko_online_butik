<aside id="sidebar" class="js-sidebar">
    <div class="h-100">
        <div class="sidebar-logo">
            <a href="{{ route('admin.dashboard') }}">Butik Disel</a>
        </div>
        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Menu Utama
            </li>
            <li class="sidebar-item {{ request()->is('admin/dashboard*') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>

            <li class="sidebar-header">
                Manajemen Toko
            </li>
            <li class="sidebar-item {{ request()->is('admin/kategori*') ? 'active' : '' }}">
                <a href="{{ route('admin.categories.index') }}" class="sidebar-link">
                    <i class="bi bi-tag-fill"></i> Kategori
                </a>
            </li>
            <li class="sidebar-item {{ request()->is('admin/produk*') ? 'active' : '' }}">
                <a href="{{ route('admin.products.index') }}" class="sidebar-link">
                    <i class="bi bi-box-seam-fill"></i> Produk
                </a>
            </li>
            <li class="sidebar-item {{ request()->is('admin/pesanan*') ? 'active' : '' }}">
                <a href="{{ route('admin.orders.index') }}" class="sidebar-link">
                    <i class="bi bi-receipt-cutoff"></i> Pesanan
                </a>
            </li>
            <li class="sidebar-item {{ request()->is('admin/pelanggan*') ? 'active' : '' }}">
                <a href="{{ route('admin.customers.index') }}" class="sidebar-link">
                    <i class="bi bi-people-fill"></i> Pelanggan
                </a>
            </li>
            <li class="sidebar-item {{ request()->is('admin/ulasan-produk*') ? 'active' : '' }}">
                <a href="{{ route('admin.reviews.index') }}" class="sidebar-link">
                    <i class="bi bi-star-fill"></i> Ulasan Produk
                </a>
            </li>

            <li class="sidebar-header">
                Sistem
            </li>
            <li class="sidebar-item {{ request()->is('admin/banner*') ? 'active' : '' }}">
                <a href="{{ route('admin.banners.index') }}" class="sidebar-link">
                    <i class="bi bi-sliders"></i> Banner
                </a>
            </li>
            <li class="sidebar-item {{ request()->is('admin/pengguna-admin*') ? 'active' : '' }}">
                <a href="{{ route('admin.admins.index') }}" class="sidebar-link">
                    <i class="bi bi-person-fill-gear"></i> Admin
                </a>
            </li>
            <li class="sidebar-item {{ request()->is('admin/laporan*') ? 'active' : '' }}">
                <a href="{{ route('admin.reports.index') }}" class="sidebar-link">
                    <i class="bi bi-file-earmark-bar-graph-fill"></i> Laporan
                </a>
            </li>
        </ul>
    </div>
</aside>
