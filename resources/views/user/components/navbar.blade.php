<nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
    <div class="container py-2">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            {{-- <img src="{{ asset('assets/images/logo.png') }}" alt="Logo Butik Disel" height="30"> --}}
            BUTIK DISEL
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main-navbar"
            aria-controls="main-navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="main-navbar">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-5" href="#">
                        <i class="bi bi-cart"></i>
                        {{-- Nanti bisa ditambahkan badge untuk jumlah item --}}
                        {{-- <span class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle">3</span> --}}
                    </a>
                </li>

                @guest
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-outline-dark" href="#">Login</a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-dark" href="#">Register</a>
                    </li>
                @endguest

                @auth
                    <li class="nav-item dropdown ms-lg-3">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Halo, {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">
                                    <i class="bi bi-person-circle me-2"></i>Akun Saya
                                </a></li>
                            <li><a class="dropdown-item" href="#">
                                    <i class="bi bi-clock-history me-2"></i>Riwayat Pesanan
                                </a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </a>
                                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
