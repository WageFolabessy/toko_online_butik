@extends('user.components.app')

@section('title', 'Selamat Datang di Butik Disel')

@section('content')

    <section id="banner-section" class="mb-5">
        <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                @foreach ($banners as $index => $banner)
                    <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="{{ $index }}"
                        class="{{ $index == 0 ? 'active' : '' }}" aria-current="{{ $index == 0 ? 'true' : 'false' }}"
                        aria-label="Slide {{ $index + 1 }}"></button>
                @endforeach
            </div>
            <div class="carousel-inner">
                @forelse ($banners as $index => $banner)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <img src="{{ asset('storage/' . $banner->image_path) }}" class="d-block w-100"
                            alt="Banner Promosi {{ $index + 1 }}">
                    </div>
                @empty
                    <div class="carousel-item active">
                        <img src="https://placehold.co/1920x780/E1E1E1/424242?text=Selamat+Datang" class="d-block w-100"
                            alt="Default Banner">
                    </div>
                @endforelse
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    <div class="container my-5">
        <section id="new-products-section" class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold">Produk Terbaru</h3>
                <a href="#" class="btn btn-outline-dark">Lihat Semua <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="row g-4">
                @forelse ($newProducts as $product)
                    <div class="col-md-4 col-lg-3">
                        @include('user.components.product-card', ['product' => $product])
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center text-muted">Belum ada produk terbaru.</p>
                    </div>
                @endforelse
            </div>
        </section>

        <section id="featured-products-section">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold">Produk Unggulan</h3>
                <a href="#" class="btn btn-outline-dark">Lihat Semua <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="row g-4">
                @forelse ($featuredProducts as $product)
                    <div class="col-md-4 col-lg-3">
                        @include('user.components.product-card', ['product' => $product])
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center text-muted">Belum ada produk unggulan.</p>
                    </div>
                @endforelse
            </div>
        </section>
    </div>
@endsection
