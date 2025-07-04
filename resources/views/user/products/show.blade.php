@extends('user.components.app')

@section('title', $product->name)

@push('style')
    <style>
        .carousel-item img {
            aspect-ratio: 1 / 1;
            object-fit: cover;
        }

        .variant-option label {
            width: 100%;
        }
    </style>
@endpush

@section('content')
    <div class="bg-light py-3">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('products.category', $product->category->slug) }}">{{ $product->category->name }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container my-5">
        <div class="row">
            <div class="col-lg-5">
                <div id="productImageCarousel" class="carousel slide carousel-fade shadow-sm rounded"
                    data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        @foreach ($product->images as $index => $image)
                            <button type="button" data-bs-target="#productImageCarousel"
                                data-bs-slide-to="{{ $index }}" class="{{ $loop->first ? 'active' : '' }}"
                                aria-current="{{ $loop->first ? 'true' : 'false' }}"></button>
                        @endforeach
                    </div>
                    <div class="carousel-inner rounded">
                        @forelse ($product->images as $image)
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $image->path) }}" class="d-block w-100"
                                    alt="Gambar produk {{ $product->name }} - {{ $loop->iteration }}">
                            </div>
                        @empty
                            <div class="carousel-item active">
                                <img src="https://placehold.co/600x600/E1E1E1/424242?text=Butik+Disel" class="d-block w-100"
                                    alt="Gambar tidak tersedia">
                            </div>
                        @endforelse
                    </div>
                    @if ($product->images->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#productImageCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#productImageCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    @endif
                </div>
            </div>

            <div class="col-lg-7 mt-4 mt-lg-0">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h3 class="fw-bold">{{ $product->name }}</h3>
                        <hr>
                        <div class="mb-3">
                            @if ($product->discount_price > 0 && $product->discount_price < $product->price)
                                @php
                                    $discountPercentage = round(
                                        (($product->price - $product->discount_price) / $product->price) * 100,
                                    );
                                @endphp
                                <span class="fw-bold text-primary fs-3">Rp
                                    {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                                <div class="mt-1">
                                    <del class="text-muted">Rp {{ number_format($product->price, 0, ',', '.') }}</del>
                                    <span class="badge bg-danger ms-2">{{ $discountPercentage }}% OFF</span>
                                </div>
                            @else
                                <span class="fw-bold text-primary fs-3">Rp
                                    {{ number_format($product->price, 0, ',', '.') }}</span>
                            @endif
                        </div>

                        <form action="#" method="POST">
                            @csrf
                            <div class="mb-3 variant-option">
                                <label class="form-label fw-bold">Pilih Varian:</label>
                                <div id="variant-container" class="btn-group w-100" role="group">
                                    @foreach ($product->variants as $variant)
                                        <input type="radio" class="btn-check" name="variant_id"
                                            id="variant-{{ $variant->id }}" value="{{ $variant->id }}"
                                            autocomplete="off" data-stock="{{ $variant->stock }}">
                                        <label class="btn btn-outline-dark"
                                            for="variant-{{ $variant->id }}">{{ $variant->name }}</label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="row align-items-center mb-4">
                                <div class="col-md-5">
                                    <label for="quantity" class="form-label fw-bold">Jumlah:</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity" value="1"
                                        min="1" style="max-width: 120px;">
                                </div>
                                <div class="col-md-7">
                                    <label class="form-label fw-bold">Stok:</label>
                                    <p id="stock-info" class="mb-0 text-muted">Pilih varian untuk melihat stok</p>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button class="btn btn-primary btn-lg" type="submit"><i
                                        class="bi bi-cart-plus-fill me-2"></i>Tambah ke Keranjang</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="fw-bold mb-0">Deskripsi Lengkap</h5>
                    </div>
                    <div class="card-body">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                </div>

                @if ($relatedProducts->isNotEmpty())
                    <div class="mt-5">
                        <h3 class="fw-bold mb-4">Mungkin Anda Juga Suka</h3>
                        <div class="row g-4">
                            @foreach ($relatedProducts as $related)
                                <div class="col-6 col-md-4 col-lg-3">
                                    @include('user.components.product-card', ['product' => $related])
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stockInfo = document.getElementById('stock-info');
            const variantContainer = document.getElementById('variant-container');

            variantContainer.addEventListener('change', function(event) {
                if (event.target.name === 'variant_id') {
                    const selectedRadio = event.target;
                    const stock = selectedRadio.dataset.stock;

                    stockInfo.classList.remove('text-muted', 'text-success', 'text-danger');

                    if (parseInt(stock) > 0) {
                        stockInfo.textContent = `${stock} pcs tersedia`;
                        stockInfo.classList.add('text-success');
                    } else {
                        stockInfo.textContent = 'Stok Habis';
                        stockInfo.classList.add('text-danger');
                    }
                }
            });
        });
    </script>
@endpush
