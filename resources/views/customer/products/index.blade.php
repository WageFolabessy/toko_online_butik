@extends('customer.layouts.app')

@section('title', 'Koleksi Kami')

@section('css')
    <style>
        .collection-header {
            padding: 4rem 0;
            background-color: var(--primary-color);
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://images.unsplash.com/photo-1574291814202-b4280e8156e7?&auto=format&fit=crop&w=1500&q=80');
            background-size: cover;
            background-position: center 30%;
        }

        .collection-header h1 {
            font-family: var(--font-heading);
            color: #fff;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .collection-header .lead {
            color: rgba(255, 255, 255, 0.85);
            max-width: 600px;
            margin: 1rem auto 0;
        }

        .sidebar-widget {
            background-color: #fff;
            padding: 1.5rem;
            border-radius: 0.5rem;
            border: 1px solid #eee;
        }

        .sidebar-title {
            font-family: var(--font-heading);
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid var(--primary-color);
            display: inline-block;
        }

        .category-list .category-link {
            display: block;
            padding: 0.75rem 1rem;
            margin-bottom: 0.5rem;
            color: var(--text-dark);
            text-decoration: none;
            border-radius: 0.375rem;
            transition: all 0.2s ease-in-out;
            border-left: 3px solid transparent;
        }

        .category-list .category-link:hover {
            background-color: var(--secondary-color);
            color: var(--primary-color);
            border-left: 3px solid var(--primary-color);
        }

        .category-list .category-link.active {
            background-color: var(--primary-color);
            color: var(--text-light);
            font-weight: 700;
            border-left: 3px solid var(--primary-color);
        }

        .form-select,
        .form-control {
            border-radius: 25px;
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .form-select:focus,
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(139, 115, 85, 0.25);
        }

        .pagination .page-link {
            font-family: var(--font-body);
            color: var(--primary-color);
            margin: 0 5px;
            border: 1px solid #ddd;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: all 0.2s ease-in-out;
            box-shadow: none !important;

            border-radius: 50% !important;
            width: 40px;
            height: 40px;
            padding: 0;
        }

        .pagination .page-item:first-child .page-link,
        .pagination .page-item:last-child .page-link {
            width: auto;
            border-radius: 25px !important;
            padding: 0 1.5rem;
        }

        .pagination .page-link:hover {
            background-color: var(--secondary-color);
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .pagination .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: #fff;
            font-weight: 700;
        }

        .pagination .page-item.disabled .page-link {
            color: #ccc;
            background-color: #f8f9fa;
            border-color: #eee;
        }

        .empty-collection-container {
            background-color: #fff;
            padding: 3rem;
            border-radius: 0.5rem;
            border: 1px solid #eee;
        }
    </style>

@endsection

@section('content')
    <div class="collection-header">
        <div class="container text-center">
            <h1 class="display-4">
                {{ request('kategori') ? Str::title(str_replace('-', ' ', request('kategori'))) : 'Semua Koleksi' }}</h1>
            <p class="lead">Temukan gaya yang merepresentasikan diri Anda dari koleksi pilihan kami.</p>
        </div>
    </div>

    <div class="container py-5">
        <div class="row">
            <div class="col-lg-3">
                <div class="sidebar-widget">
                    <h4 class="sidebar-title">Kategori</h4>
                    <div class="category-list">
                        <a href="{{ route('customer.products.index') }}"
                            class="category-link {{ !request('kategori') ? 'active' : '' }}">
                            Semua Kategori
                        </a>
                        @foreach ($categories as $category)
                            <a href="{{ route('customer.products.index', ['kategori' => $category->slug]) }}"
                                class="category-link {{ request('kategori') == $category->slug ? 'active' : '' }}">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
                    <h3 class="mb-3 mb-md-0 mt-3 mt-md-0">
                        Menampilkan {{ $products->firstItem() }}-{{ $products->lastItem() }} dari {{ $products->total() }}
                        produk
                    </h3>

                    <form id="filter-form" action="{{ route('customer.products.index') }}" method="GET"
                        class="d-flex gap-2 align-items-center">

                        @if (request('kategori'))
                            <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                        @endif

                        <input type="text" name="search" class="form-control" placeholder="Cari produk..."
                            value="{{ request('search') }}">

                        <select name="sort" class="form-select" style="min-width: 180px;"
                            onchange="document.getElementById('filter-form').submit();">
                            <option value="terbaru" {{ request('sort', 'terbaru') == 'terbaru' ? 'selected' : '' }}>
                                Urutkan: Terbaru
                            </option>
                            <option value="harga-terendah" {{ request('sort') == 'harga-terendah' ? 'selected' : '' }}>
                                Urutkan: Harga Terendah</option>
                            <option value="harga-tertinggi" {{ request('sort') == 'harga-tertinggi' ? 'selected' : '' }}>
                                Urutkan: Harga Tertinggi</option>
                        </select>

                        @if (request('kategori') || request('search') || (request('sort') && request('sort') !== 'terbaru'))
                            <a href="{{ route('customer.products.index') }}" class="btn btn-outline-secondary"
                                title="Reset Filter">
                                <i class="bi bi-x-lg"></i>
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
                        <div class="col-12 text-center py-5">
                            <div class="empty-collection-container">
                                <i class="bi bi-dropbox display-1 text-muted"></i>
                                <h4 class="mt-4">Oops! Koleksi Kosong</h4>
                                <p class="fs-5 text-muted">Produk yang Anda cari tidak ditemukan.</p>
                                <a href="{{ route('customer.products.index') }}" class="btn btn-primary mt-3">Lihat Semua
                                    Koleksi</a>
                            </div>
                        </div>
                    @endforelse
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $products->onEachSide(1)->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
