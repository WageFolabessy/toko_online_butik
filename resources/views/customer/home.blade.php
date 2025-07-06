@extends('customer.layouts.app')

@section('title', 'Selamat Datang')

@section('content')
    <section class="hero-section">
        <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach ($banners as $key => $banner)
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        <img src="{{ asset('storage/banners/' . $banner->image) }}" class="d-block w-100"
                            alt="Banner {{ $key + 1 }}">
                    </div>
                @endforeach
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

    <section class="py-5">
        <div class="container">
            <div class="row text-center mb-4">
                <div class="col">
                    <h2 class="fw-bold">Produk Terbaru</h2>
                    <p class="text-muted">Temukan koleksi fashion terbaru dari kami.</p>
                </div>
            </div>
            <div class="row">
                @forelse($products as $product)
                    <div class="col-md-4 col-lg-3 mb-4">
                        @include('customer.components.product-card', ['product' => $product])
                    </div>
                @empty
                    <div class="col text-center">
                        <p>Belum ada produk yang tersedia saat ini.</p>
                    </div>
                @endforelse
            </div>
            <div class="row mt-3">
                <div class="col text-center">
                    <a href="#" class="btn btn-outline-primary">Lihat Semua Produk</a>
                </div>
            </div>
        </div>
    </section>
@endsection
