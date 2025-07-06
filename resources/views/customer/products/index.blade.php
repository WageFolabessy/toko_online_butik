@extends('customer.layouts.app')

@section('title', 'Koleksi Kami')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-3">
                <h4 class="mb-4">Kategori</h4>
                <div class="list-group">
                    <a href="{{ route('customer.products.index') }}"
                        class="list-group-item list-group-item-action {{ !request('kategori') ? 'active' : '' }}">
                        Semua Kategori
                    </a>
                    @foreach ($categories as $category)
                        <a href="{{ route('customer.products.index', ['kategori' => $category->slug]) }}"
                            class="list-group-item list-group-item-action {{ request('kategori') == $category->slug ? 'active' : '' }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-9">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
                    <h2 class="fw-bold mb-3 mb-md-0 mt-4 mt-sm-0">
                        {{ request('kategori') ? 'Koleksi: ' . Str::title(str_replace('-', ' ', request('kategori'))) : 'Semua Koleksi' }}
                    </h2>

                    <form id="filter-form" action="{{ route('customer.products.index') }}" method="GET"
                        class="d-flex gap-2 align-items-center">

                        @if (request('kategori'))
                            <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                        @endif

                        <input type="text" name="search" class="form-control" placeholder="Cari produk..."
                            value="{{ request('search') }}">

                        <select name="sort" class="form-select" style="min-width: 180px;"
                            onchange="document.getElementById('filter-form').submit();">
                            <option value="terbaru" {{ request('sort', 'terbaru') == 'terbaru' ? 'selected' : '' }}>Terbaru
                            </option>
                            <option value="harga-terendah" {{ request('sort') == 'harga-terendah' ? 'selected' : '' }}>
                                Harga Terendah</option>
                            <option value="harga-tertinggi" {{ request('sort') == 'harga-tertinggi' ? 'selected' : '' }}>
                                Harga Tertinggi</option>
                        </select>

                        @if (request('kategori') || request('search') || (request('sort') && request('sort') !== 'terbaru'))
                            <a href="{{ route('customer.products.index') }}" class="btn btn-outline-danger">
                                <i class="bi bi-x"></i>
                            </a>
                        @endif
                    </form>
                </div>
                <div class="row">
                    @forelse($products as $product)
                        <div class="col-md-6 col-lg-4 mb-4">
                            @include('customer.components.product-card', ['product' => $product])
                        </div>
                    @empty
                        <div class="col text-center">
                            <p class="fs-5 text-muted">Produk tidak ditemukan.</p>
                            <a href="{{ route('customer.products.index') }}" class="btn btn-primary">Lihat Semua Koleksi</a>
                        </div>
                    @endforelse
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $products->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
