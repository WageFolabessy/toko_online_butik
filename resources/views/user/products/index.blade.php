@extends('user.components.app')

@section('title', $pageTitle)

@push('style')
    <style>
        .filter-form .form-control,
        .filter-form .form-select {
            font-size: 0.9rem;
        }
    </style>
@endpush

@section('content')
    <div class="container my-5">
        <form action="{{ url()->current() }}" method="GET" class="filter-form">
            <div class="row">
                <div class="col-lg-3">
                    <div class="card shadow-sm sticky-top" style="top: 100px;">
                        <div class="card-header bg-light">
                            <h5 class="fw-bold mb-0"><i class="bi bi-funnel-fill me-2"></i>Filter</h5>
                        </div>
                        <div class="card-body">
                            <h6 class="fw-bold">Kategori</h6>
                            <ul class="list-group list-group-flush mb-4">
                                <a href="{{ route('products.index') }}"
                                    class="list-group-item list-group-item-action {{ request()->routeIs('products.index') ? 'active' : '' }}">
                                    Semua Kategori
                                </a>
                                @foreach ($categories as $category)
                                    <a href="{{ route('products.category', $category->slug) }}"
                                        class="list-group-item list-group-item-action {{ isset($selectedCategory) && $selectedCategory->id == $category->id ? 'active' : '' }}">
                                        {{ $category->name }}
                                    </a>
                                @endforeach
                            </ul>

                            <h6 class="fw-bold mt-4">Rentang Harga</h6>
                            <div class="d-flex align-items-center">
                                <input type="number" class="form-control" name="min_price" placeholder="Min"
                                    value="{{ request('min_price') }}">
                                <span class="mx-2">-</span>
                                <input type="number" class="form-control" name="max_price" placeholder="Max"
                                    value="{{ request('max_price') }}">
                            </div>
                            <div class="d-grid mt-2">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
                        <div>
                            <h3 class="fw-bold">{{ $pageTitle }}</h3>
                            <p class="text-muted mb-2 mb-md-0">Menampilkan
                                {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} dari
                                {{ $products->total() }} produk</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <label for="sort" class="form-label me-2 text-nowrap mb-0">Urutkan:</label>
                            <select class="form-select" name="sort" id="sort" onchange="this.form.submit()">
                                <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>
                                    Terbaru</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga
                                    Terendah</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga
                                    Tertinggi</option>
                            </select>
                            <button type="submit" class="btn btn-primary ms-2">Filter</button>
                        </div>
                    </div>

                    <div class="row g-4">
                        @forelse ($products as $product)
                            <div class="col-md-6 col-lg-4">
                                @include('user.components.product-card', ['product' => $product])
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="text-center py-5 border rounded bg-light">
                                    <i class="bi bi-search-heart fs-1 text-muted"></i>
                                    <h4 class="mt-3">Produk Tidak Ditemukan</h4>
                                    <p class="text-muted">Coba ubah filter atau kata kunci pencarian Anda.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-5 d-flex justify-content-center">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
