<nav class="navbar navbar-expand px-3 border-bottom">
    <button class="btn" id="sidebar-toggle" type="button">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
            @php
                $nameParts = explode(' ', Auth::user()->name);
                $firstNameInitial = strtoupper(substr($nameParts[0], 0, 1));
                $lastNameInitial = count($nameParts) > 1 ? strtoupper(substr(end($nameParts), 0, 1)) : '';
                $initials = $firstNameInitial . $lastNameInitial;
            @endphp

            <a href="#" data-bs-toggle="dropdown" class="nav-link dropdown-toggle d-flex align-items-center gap-2">
                <div class="avatar-initials">
                    {{ $initials }}
                </div>
                <span class="d-none d-md-inline">
                    {{ Auth::user()->name }}
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-end">
                <a href="{{ route('admin.profile.edit') }}" class="dropdown-item">
                    <i class="bi bi-person-fill me-2"></i> Profil
                </a>
                <div class="dropdown-divider"></div>
                <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="dropdown-item">
                        <i class="bi bi-box-arrow-right me-2"></i> Keluar
                    </button>
                </form>
            </div>
        </li>
    </ul>
</nav>
