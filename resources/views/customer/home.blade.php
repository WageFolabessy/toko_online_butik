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
                    <a href="{{ route('customer.products.index') }}" class="btn btn-outline-primary">Lihat Semua Produk</a>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <div class="row text-center mb-4">
                <div class="col">
                    <h2 class="fw-bold">Apa Kata Mereka?</h2>
                    <p class="text-muted">Ulasan tulus dari pelanggan setia kami.</p>
                </div>
            </div>
            <div class="row">
                @forelse($reviews as $review)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <div class="text-warning mb-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="bi {{ $i <= $review->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                    @endfor
                                </div>
                                <blockquote class="blockquote">
                                    <p class="mb-2 fst-italic">"{{ Str::limit($review->review, 100) }}"</p>
                                </blockquote>
                                <figcaption class="blockquote-footer mt-2">
                                    {{ $review->user->name }}
                                </figcaption>
                                <hr>
                                <div class="d-flex align-items-center justify-content-center">
                                    <a href="{{ route('customer.products.show', $review->product) }}">
                                        <img src="{{ $review->product->images->first() ? asset('storage/products/' . $review->product->images->first()->path) : 'https://via.placeholder.com/50' }}"
                                            alt="{{ $review->product->name }}" class="rounded me-2" width="40">
                                    </a>
                                    <a href="{{ route('customer.products.show', $review->product) }}"
                                        class="text-decoration-none text-dark small">
                                        {{ Str::limit($review->product->name, 25) }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col text-center">
                        <p>Belum ada ulasan yang tersedia.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
