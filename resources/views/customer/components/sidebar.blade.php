<div class="col-lg-3">
    <div class="profile-sidebar">
        <div class="list-group">
            <a href="{{ route('customer.profile.edit') }}"
                class="list-group-item list-group-item-action {{ request()->routeIs('customer.profile.edit') ? 'active' : '' }}">
                <i class="bi bi-person-circle me-2"></i> Profil Saya
            </a>
            <a href="{{ route('customer.profile.alamat.index') }}"
                class="list-group-item list-group-item-action {{ request()->routeIs('customer.profile.alamat.*') ? 'active' : '' }}">
                <i class="bi bi-geo-alt-fill me-2"></i> Alamat Saya
            </a>
            <a href="{{ route('customer.profile.orders.index') }}"
                class="list-group-item list-group-item-action {{ request()->routeIs('customer.profile.orders.*') ? 'active' : '' }}">
                <i class="bi bi-receipt me-2"></i> Riwayat Pesanan
            </a>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-profile').submit();"
                class="list-group-item list-group-item-action logout-link">
                <i class="bi bi-box-arrow-right me-2"></i> Keluar
            </a>
            <form id="logout-form-profile" action="{{ route('customer.logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
</div>
