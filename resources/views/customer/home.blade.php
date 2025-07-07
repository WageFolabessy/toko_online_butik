@extends('customer.layouts.app')

@section('title', 'Selamat Datang')

@section('css')
    <style>
        .hero-section .carousel-item {
            height: 85vh;
            min-height: 500px;
        }

        .hero-section .carousel-item img {
            height: 100%;
            object-fit: cover;
            filter: brightness(0.6);
        }

        .hero-section .carousel-caption {
            bottom: 50%;
            transform: translateY(50%);
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        }

        .hero-section .carousel-caption h2 {
            font-family: var(--font-heading);
            font-weight: 700;
        }

        .hero-section .carousel-control-prev,
        .hero-section .carousel-control-next {
            width: 5%;
        }

        .hero-section .carousel-control-prev-icon,
        .hero-section .carousel-control-next-icon {
            background-color: rgba(0, 0, 0, 0.3);
            border-radius: 50%;
            width: 50px;
            height: 50px;
            background-size: 50% 50%;
        }

        .hero-section .carousel-indicators [data-bs-target] {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin: 0 8px;
            background-color: #fff;
            opacity: 0.7;
        }

        .hero-section .carousel-indicators .active {
            opacity: 1;
            background-color: var(--accent-color);
        }

        .bg-secondary-soft {
            background-color: var(--secondary-color);
        }

        .feature-item .feature-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            transition: all 0.3s ease;
        }

        .feature-item:hover .feature-icon {
            transform: translateY(-10px) scale(1.1);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .feature-item h4 {
            font-family: var(--font-heading);
        }

        .review-card-home {
            border: 1px solid #eee;
            border-radius: 0.5rem;
            text-align: center;
            padding: 1rem;
            transition: all 0.3s ease;
            background-color: #fff;
        }

        .review-card-home:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
        }

        .review-quote-icon {
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 3.5rem;
            color: #f1f1f1;
            z-index: 1;
        }

        .review-card-home .card-body {
            position: relative;
            z-index: 2;
        }

        .review-text {
            font-style: italic;
            font-size: 1.1rem;
            min-height: 100px;
            margin-bottom: 1.5rem;
        }

        .review-author-info {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .user-avatar-small {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        .review-author {
            font-family: var(--font-heading);
            font-weight: 700;
        }

        .text-accent {
            color: var(--accent-color) !important;
        }

        @media (max-width: 767.98px) {

            .hero-section .carousel-item {
                height: 65vh;
                min-height: 400px;
            }

            .hero-section .carousel-caption {
                width: 85%;
                bottom: 50%;
                transform: translateY(50%);
            }

            .hero-section .carousel-caption h2 {
                font-size: 1.8rem;
            }

            .hero-section .carousel-caption p {
                font-size: 0.9rem;
                display: none;
            }

            .hero-section .carousel-caption .btn {
                font-size: 0.9rem;
                padding: 0.6rem 1.2rem;
            }

            .review-card-home {
                text-align: left;
            }

            .review-quote-icon {
                display: none;
            }

            .review-text {
                min-height: auto;
                margin-bottom: 1rem;
            }

            .review-author-info {
                justify-content: flex-start;
            }

            .section-title {
                font-size: 1.8rem;
            }
        }
    </style>
@endsection

@section('content')
    <section class="hero-section">
        <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                @foreach ($banners as $key => $banner)
                    <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="{{ $key }}"
                        class="{{ $key == 0 ? 'active' : '' }}" aria-current="{{ $key == 0 ? 'true' : 'false' }}"
                        aria-label="Slide {{ $key + 1 }}"></button>
                @endforeach
            </div>
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
            <div class="row mb-5">
                <div class="col-12">
                    <h2 class="section-title">Produk Terbaru</h2>
                </div>
            </div>
            <div class="row">
                @forelse($products as $product)
                    <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                        @include('customer.components.product-card', ['product' => $product])
                    </div>
                @empty
                    <div class="col text-center">
                        <p>Belum ada produk yang tersedia saat ini.</p>
                    </div>
                @endforelse
            </div>
            <div class="row mt-4">
                <div class="col text-center">
                    <a href="{{ route('customer.products.index') }}" class="btn btn-primary btn-lg">Lihat Semua Produk <i
                            class="bi bi-arrow-right ms-2"></i></a>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12">
                    <h2 class="section-title text-center">Apa Kata Pelanggan?</h2>
                </div>
            </div>
            <div class="row">
                @forelse($reviews as $review)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 review-card-home">
                            <div class="card-body">
                                <i class="bi bi-quote review-quote-icon"></i>
                                <div class="text-accent mb-3">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="bi {{ $i <= $review->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                    @endfor
                                </div>
                                <p class="review-text">"{{ Str::limit($review->review, 120) }}"</p>
                                <div class="review-author-info">
                                    <div class="user-avatar-small">{{ strtoupper(substr($review->user->name, 0, 1)) }}
                                    </div>
                                    <span class="review-author">{{ $review->user->name }}</span>
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
