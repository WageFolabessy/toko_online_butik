<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('customer.home') }}">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Butik Disel" height="40">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('customer.home') }}">Beranda</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is('koleksi*') ? 'active' : '' }}" href="#"
                        id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Koleksi
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @isset($footerCategories)
                            @foreach ($footerCategories as $category)
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('customer.products.index', ['kategori' => $category->slug]) }}">{{ $category->name }}</a>
                                </li>
                            @endforeach
                        @endisset
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('customer.products.index') }}">Lihat Semua
                                Koleksi</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Kontak Kami</a>
                </li>
            </ul>
            <div class="d-flex align-items-center gap-2">
                <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#searchModal"
                    aria-label="Cari Produk">
                    <i class="bi bi-search fs-5"></i>
                </a>
                <a href="{{ route('customer.cart.index') }}" class="nav-link position-relative"
                    aria-label="Keranjang Belanja">
                    <i class="bi bi-cart-fill fs-5"></i>
                    <span id="cart-count-badge"
                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger {{-- Tampilkan badge hanya jika ada item --}} {{ isset($cartItemCount) && $cartItemCount > 0 ? '' : 'd-none' }}">
                        {{ $cartItemCount ?? 0 }}
                    </span>
                </a>

                @guest
                    <a href="{{ route('customer.login.form') }}" class="btn btn-primary btn-sm ms-2">Masuk</a>
                @else
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarUserDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle fs-5 me-2"></i>
                            <span class="d-none d-lg-inline">{{ Str::limit(Auth::user()->name, 10) }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarUserDropdown">
                            <li>
                                <div class="px-3 py-2">
                                    <div class="fw-bold">{{ Auth::user()->name }}</div>
                                    <div class="text-muted small">{{ Auth::user()->email }}</div>
                                </div>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="{{ route('customer.profile.edit') }}">Profil Saya</a></li>
                            <li><a class="dropdown-item" href="#">Pesanan Saya</a></li>
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
