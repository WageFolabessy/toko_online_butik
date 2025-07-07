<nav class="navbar navbar-expand-lg navbar-dark sticky-top navbar-custom">
    <div class="container-fluid px-lg-5">
        <a class="navbar-brand me-4" href="{{ route('customer.home') }}">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Butik Disel" height="45">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
            aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('customer.home') ? 'active' : '' }}"
                        href="{{ route('customer.home') }}">Beranda</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is('koleksi*') ? 'active' : '' }} {{ request()->is('produk*') ? 'active' : '' }}" href="#"
                        id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Koleksi
                    </a>
                    <ul class="dropdown-menu w-100 border-0" aria-labelledby="navbarDropdown">
                        @isset($footerCategories)
                            @foreach ($footerCategories as $category)
                                <li>
                                    <a class="dropdown-item px-3"
                                        href="{{ route('customer.products.index', ['kategori' => $category->slug]) }}">
                                        {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach
                        @endisset
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item px-3" href="{{ route('customer.products.index') }}">Lihat Semua
                                Koleksi</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('customer.contact') ? 'active' : '' }}" href="{{ route('customer.contact') }}">Kontak Kami</a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-3 mt-3 mt-lg-0">
                <a href="#" class="nav-link icon-link" data-bs-toggle="modal" data-bs-target="#searchModal"
                    aria-label="Cari Produk">
                    <i class="bi bi-search fs-5"></i>
                </a>

                <a href="{{ route('customer.cart.index') }}" class="nav-link icon-link position-relative"
                    aria-label="Keranjang Belanja">
                    <i class="bi bi-cart-fill fs-5"></i>
                    <span id="cart-count-badge"
                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-accent
                       {{ isset($cartItemCount) && $cartItemCount > 0 ? '' : 'd-none' }}">
                        {{ $cartItemCount ?? 0 }}
                    </span>
                </a>

                @guest
                    <a href="{{ route('customer.login.form') }}" class="btn btn-sm btn-accent">Masuk</a>
                @else
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle fs-4"></i>
                            <span class="ms-2 d-none d-lg-inline">
                                {{ Str::limit(Auth::user()->name, 10) }}
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li class="px-3 py-2 d-none d-sm-block">
                                <div class="fw-bold">{{ Auth::user()->name }}</div>
                                <div class="text-muted small">{{ Auth::user()->email }}</div>
                            </li>
                            <li class="d-none d-sm-block">
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="{{ route('customer.profile.edit') }}">Profil Saya</a></li>
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('customer.profile.orders.*') ? 'active' : '' }}"
                                    href="{{ route('customer.profile.orders.index') }}">Riwayat Pesanan</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('customer.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">Keluar</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>

<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="searchModalLabel">Cari Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('customer.products.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control form-control-lg"
                            placeholder="Ketik nama produk..." required autofocus>
                        <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
