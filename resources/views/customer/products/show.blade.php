@extends('customer.layouts.app')

@section('title', $product->name)

@section('css')
    <style>
        .main-image-container .img-fluid {
            width: 100%;
            aspect-ratio: 1/1;
            object-fit: cover;
        }

        .thumbnail-item {
            width: 80px;
        }

        .product-thumbnail {
            width: 100%;
            aspect-ratio: 1/1;
            object-fit: cover;
            border-radius: 0.375rem;
            cursor: pointer;
            border: 2px solid transparent;
            transition: border-color 0.3s ease;
        }

        .product-thumbnail:hover {
            border-color: #ccc;
        }

        .product-thumbnail.active {
            border-color: var(--primary-color);
        }

        .product-category-detail {
            font-size: 0.9em;
            font-family: var(--font-body);
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #999;
            text-decoration: none;
            font-weight: 700;
        }

        .product-title-main {
            font-family: var(--font-heading);
            color: var(--text-dark);
        }

        .product-price-main {
            color: var(--primary-color);
        }

        .product-price-main .original-price {
            text-decoration: line-through;
            color: #aaa;
        }

        .option-title {
            font-family: var(--font-body);
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
        }

        .variant-label {
            border: 1px solid #ddd;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            font-weight: 600;
            min-width: 50px;
            text-align: center;
        }

        .variant-label:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .btn-check:checked+.variant-label {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .btn-check:disabled+.variant-label {
            border-color: #eee;
            background-color: #f8f9fa;
            color: #ccc;
            cursor: not-allowed;
            text-decoration: line-through;
        }

        .btn-check:disabled+.variant-label:hover {
            border-color: #eee;
            color: #ccc;
        }

        .quantity-selector {
            display: flex;
            border: 1px solid #ddd;
            border-radius: 25px;
            overflow: hidden;
            width: 130px;
        }

        .quantity-selector .btn-quantity {
            background-color: transparent;
            border: none;
            font-weight: 700;
            color: var(--primary-color);
            flex-basis: 30%;
        }

        .quantity-selector .form-control {
            border: none;
            box-shadow: none;
            padding: 0;
            flex-basis: 40%;
        }

        .product-details-tabs .nav-tabs {
            border-bottom: 2px solid #dee2e6;
        }

        .product-details-tabs .nav-link {
            font-family: var(--font-body);
            font-weight: 600;
            color: #999;
            border: none;
            border-bottom: 2px solid transparent;
            border-radius: 0;
            margin-bottom: -2px;
            padding: 1rem 1.5rem;
        }

        .product-details-tabs .nav-link:hover {
            border-color: transparent;
            color: var(--primary-color);
        }

        .product-details-tabs .nav-link.active {
            color: var(--primary-color);
            background-color: transparent;
            border-color: var(--primary-color);
        }

        .product-details-tabs .tab-content {
            border: 1px solid #dee2e6;
            border-top: none;
            border-radius: 0 0 0.375rem 0.375rem;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .review-author {
            font-family: var(--font-heading);
            font-weight: 700;
        }

        .section-title {
            font-family: var(--font-heading);
            text-align: center;
            position: relative;
            padding-bottom: 15px;
            margin-bottom: 2rem !important;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background-color: var(--primary-color);
        }
    </style>
@endsection

@section('content')
    <div class="container py-5 product-detail-container">
        <div class="row">
            <div class="col-lg-6">
                <div class="product-gallery">
                    <div class="main-image-container mb-3">
                        <img id="main-product-image"
                            src="{{ $product->images->first() ? asset('storage/products/' . $product->images->first()->path) : 'https://via.placeholder.com/600' }}"
                            alt="{{ $product->name }}" class="img-fluid rounded">
                    </div>
                    <div class="thumbnail-list d-flex">
                        @foreach ($product->images as $image)
                            <div class="thumbnail-item me-2">
                                <img src="{{ asset('storage/products/' . $image->path) }}" alt="Thumbnail"
                                    class="product-thumbnail {{ $loop->first ? 'active' : '' }}">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="product-info ps-lg-4">
                    <a href="{{ route('customer.products.index', ['kategori' => $product->category->slug]) }}"
                        class="product-category-detail">{{ $product->category->name }}</a>
                    <h1 class="product-title-main mt-1">{{ $product->name }}</h1>

                    <div class="my-3 product-price-main">
                        @if ($product->discount_price > 0)
                            <span class="fs-2 fw-bold">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                            <span class="fs-5 original-price ms-2">Rp
                                {{ number_format($product->price, 0, ',', '.') }}</span>
                        @else
                            <span class="fs-2 fw-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        @endif
                    </div>

                    <p class="text-muted product-short-description">{{ Str::limit($product->description, 200) }}</p>

                    <form id="add-to-cart-form">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="mt-4">
                            <h5 class="option-title">Pilih Varian (Ukuran)</h5>
                            <div class="d-flex flex-wrap gap-2" id="variant-options">
                                @foreach ($product->variants as $variant)
                                    <div class="form-check ps-0">
                                        <input type="radio" class="btn-check" name="variant_id"
                                            id="variant-{{ $variant->id }}" value="{{ $variant->id }}"
                                            data-stock="{{ $variant->stock }}" autocomplete="off"
                                            {{ $variant->stock == 0 ? 'disabled' : '' }}>
                                        <label class="variant-label"
                                            for="variant-{{ $variant->id }}">{{ $variant->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="row align-items-center mt-4">
                            <div class="col-auto">
                                <h5 class="option-title mb-2">Jumlah</h5>
                                <div class="quantity-selector">
                                    <button class="btn btn-quantity" type="button" id="button-minus">-</button>
                                    <input type="text" id="quantity-input" name="quantity"
                                        class="form-control text-center" value="1" readonly>
                                    <button class="btn btn-quantity" type="button" id="button-plus">+</button>
                                </div>
                            </div>
                            <div class="col">
                                <div id="stock-info" class="text-muted small mt-4">
                                    Pilih varian untuk melihat stok.
                                </div>
                            </div>
                        </div>

                        <div class="d-grid mt-4 pt-3 border-top">
                            @auth
                                <button id="add-to-cart-btn" class="btn btn-primary btn-lg" type="submit" disabled>
                                    <i class="bi bi-cart-plus-fill me-2"></i> Tambah ke Keranjang
                                </button>
                            @else
                                <a href="{{ route('customer.login.form') }}" class="btn btn-primary btn-lg">
                                    <i class="bi bi-box-arrow-in-right me-2"></i> Masuk untuk Membeli
                                </a>
                            @endauth
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <div class="product-details-tabs">
                    <ul class="nav nav-tabs" id="productTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                                data-bs-target="#description-content" type="button" role="tab">Deskripsi
                                Lengkap</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews-content"
                                type="button" role="tab">Ulasan Pelanggan</button>
                        </li>
                    </ul>
                    <div class="tab-content p-4" id="productTabContent">
                        <div class="tab-pane fade show active" id="description-content" role="tabpanel">
                            <p>{!! nl2br(e($product->description)) !!}</p>
                        </div>
                        <div class="tab-pane fade" id="reviews-content" role="tabpanel">
                            @forelse($product->reviews as $review)
                                <div class="d-flex mb-4 review-item">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="user-avatar">
                                            @php
                                                $nameParts = explode(' ', $review->user->name);
                                                $initials = strtoupper(
                                                    substr($nameParts[0], 0, 1) .
                                                        (count($nameParts) > 1 ? substr(end($nameParts), 0, 1) : ''),
                                                );
                                            @endphp
                                            {{ $initials }}
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="mt-0 review-author">{{ $review->user->name }}</h5>
                                        <div class="text-accent mb-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i
                                                    class="bi {{ $i <= $review->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                            @endfor
                                        </div>
                                        <p>{{ $review->review }}</p>
                                        <small class="text-muted">Diulas pada
                                            {{ $review->created_at->translatedFormat('d F Y') }}</small>
                                    </div>
                                </div>
                                @if (!$loop->last)
                                    <hr class="my-4">
                                @endif
                            @empty
                                <p>Jadilah yang pertama mengulas produk ini.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($relatedProducts->count() > 0)
            <div class="row mt-5">
                <div class="col-12">
                    <h2 class="section-title mb-4">Anda Mungkin Juga Suka</h2>
                    <div class="row">
                        @foreach ($relatedProducts as $related)
                            <div class="col-md-4 col-lg-3 mb-4">
                                @include('customer.components.product-card', ['product' => $related])
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            const qtyInput = $('#quantity-input');
            const stockInfo = $('#stock-info');
            const addToCartBtn = $('#add-to-cart-btn');

            let maxStock = 0;

            $('.product-thumbnail').on('click', function() {
                $('#main-product-image').attr('src', $(this).attr('src'));
                $('.product-thumbnail').removeClass('active');
                $(this).addClass('active');
            });

            $('#button-plus').on('click', function() {
                let currentVal = parseInt(qtyInput.val());
                if (maxStock > 0 && currentVal < maxStock) {
                    qtyInput.val(currentVal + 1);
                }
            });

            $('#button-minus').on('click', function() {
                let currentVal = parseInt(qtyInput.val());
                if (currentVal > 1) {
                    qtyInput.val(currentVal - 1);
                }
            });

            $('input[name="variant_id"]').on('change', function() {
                maxStock = parseInt($(this).data('stock'));

                qtyInput.val(1);

                if (maxStock > 0) {
                    stockInfo.html(
                        `<i class="bi bi-check-circle-fill text-success"></i> Stok Tersedia: <strong>${maxStock}</strong>`
                    );
                    addToCartBtn.prop('disabled', false);
                } else {
                    stockInfo.html('<i class="bi bi-x-circle-fill text-danger"></i> Stok Habis');
                    addToCartBtn.prop('disabled', true);
                }
            });

            $('#add-to-cart-form').on('submit', function(e) {
                e.preventDefault();

                let selectedVariant = $('input[name="variant_id"]:checked');
                if (selectedVariant.length === 0) {
                    showAppToast('Silakan pilih varian terlebih dahulu.', 'error');
                    return;
                }

                let quantity = parseInt(qtyInput.val());
                if (quantity > maxStock) {
                    showAppToast(`Kuantitas melebihi stok yang tersedia (${maxStock}).`, 'error');
                    return;
                }

                let formData = $(this).serialize();
                let url = "{{ route('customer.cart.store') }}";

                addToCartBtn.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menambahkan...'
                );

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    success: function(response) {
                        $('#cart-count-badge').text(response.cartCount).removeClass('d-none');
                        showAppToast(response.success, 'success');
                    },
                    error: function(xhr) {
                        let errorMsg = xhr.responseJSON ? xhr.responseJSON.error :
                            'Gagal menambahkan produk.';
                        showAppToast(errorMsg, 'error');
                    },
                    complete: function() {
                        let currentStock = parseInt($('input[name="variant_id"]:checked').data(
                            'stock'));
                        if (currentStock > 0) {
                            addToCartBtn.prop('disabled', false).html(
                                '<i class="bi bi-cart-plus-fill me-2"></i> Tambah ke Keranjang'
                            );
                        } else {
                            addToCartBtn.prop('disabled', true).html(
                                '<i class="bi bi-cart-plus-fill me-2"></i> Tambah ke Keranjang'
                            );
                        }
                    }
                });
            });
        });
    </script>
@endpush
