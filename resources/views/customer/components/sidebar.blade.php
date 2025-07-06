<div class="col-lg-3">
    <div class="list-group">
        <a href="{{ route('customer.profile.edit') }}"
            class="list-group-item list-group-item-action {{ request()->routeIs('customer.profile.edit') ? 'active' : '' }}">
            Profil Saya
        </a>
        <a href="{{ route('customer.profile.alamat.index') }}"
            class="list-group-item list-group-item-action {{ request()->routeIs('customer.profile.alamat.*') ? 'active' : '' }}">
            Alamat Saya
        </a>
        <a href="#" class="list-group-item list-group-item-action">Riwayat Pesanan</a>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-profile').submit();"
            class="list-group-item list-group-item-action text-danger">
            Keluar
        </a>
        <form id="logout-form-profile" action="{{ route('customer.logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</div>
