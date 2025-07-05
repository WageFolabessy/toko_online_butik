<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('home') }}">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo Butik Disel" class="me-2" style="height: 40px;">
            <span class="brand-text">BUTIK DISEL</span>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#main-navbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="main-navbar">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link fw-500 {{ request()->routeIs('home') ? 'active text-primary' : '' }}"
                        href="{{ route('home') }}">Home
                    </a>
                </li>

                @if ($categories->count() > 0)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-500" href="#" id="navbarDropdownCategories"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">Koleksi
                        </a>
                        <ul class="dropdown-menu shadow border-0 mt-2" aria-labelledby="navbarDropdownCategories">
                            @foreach ($categories as $category)
                                <li>
                                    <a class="dropdown-item py-2"
                                        href="{{ route('products.category', $category->slug) }}">
                                        <i class="bi bi-tag me-2 text-primary"></i>{{ $category->name }}
                                    </a>
                                </li>
                            @endforeach
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item py-2 fw-500" href="{{ route('products.index') }}">
                                    <i class="bi bi-collection me-2 text-primary"></i>Lihat Semua Produk
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link fw-500" href="#">Tentang
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item me-2">
                    <button class="btn btn-outline-secondary rounded-circle p-2" data-bs-toggle="modal"
                        data-bs-target="#searchModal">
                        <i class="bi bi-search"></i>
                    </button>
                </li>

                <li class="nav-item me-2">
                    <a class="btn btn-outline-primary rounded-circle p-2 position-relative" href="#">
                        <i class="bi bi-bag"></i>
                        <span
                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger small">
                            0
                        </span>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <button class="btn btn-outline-dark rounded-circle p-2" id="navbarDropdownAccount"
                        data-bs-toggle="dropdown">
                        <i class="bi bi-person"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                        @guest
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('login') }}">
                                    <i class="bi bi-box-arrow-in-right me-2 text-primary"></i>Login
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('register') }}">
                                    <i class="bi bi-person-plus me-2 text-success"></i>Daftar
                                </a>
                            </li>
                        @endguest

                        @auth
                            <li class="dropdown-header">
                                <i class="bi bi-person-circle me-2"></i>{{ Auth::user()->name }}
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item py-2" href="#">
                                    <i class="bi bi-person-gear me-2 text-primary"></i>Profil Saya
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2" href="#">
                                    <i class="bi bi-clock-history me-2 text-info"></i>Riwayat Pesanan
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        @endauth
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="modal fade" id="searchModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-600">
                    <i class="bi bi-search me-2 text-primary"></i>Cari Produk
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-0">
                <form action="#" method="GET">
                    <div class="input-group input-group-lg">
                        <input type="text" class="form-control border-2"
                            placeholder="Cari dress, blouse, celana..." name="search" required>
                        <button class="btn btn-primary px-4" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
