@extends('customer.layouts.app')

@section('title', $product->name)

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <img id="main-product-image"
                        src="{{ $product->images->first() ? asset('storage/products/' . $product->images->first()->path) : 'https://via.placeholder.com/600' }}"
                        alt="{{ $product->name }}" class="img-fluid rounded"
                        style="width: 100%; aspect-ratio: 1/1; object-fit: cover;">
                </div>
                <div class="d-flex">
                    @foreach ($product->images as $image)
                        <div class="me-2" style="width: 80px;">
                            <img src="{{ asset('storage/products/' . $image->path) }}" alt="Thumbnail"
                                class="img-thumbnail thumbnail-image"
                                style="cursor: pointer; width: 100%; aspect-ratio: 1/1; object-fit: cover;">
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-6">
                <a href="{{ route('customer.products.index', ['kategori' => $product->category->slug]) }}"
                    class="text-muted text-decoration-none small">{{ $product->category->name }}</a>
                <h1 class="fw-bold mt-1">{{ $product->name }}</h1>

                <div class="my-3">
                    @if ($product->discount_price > 0)
                        <span class="fs-3 fw-bold text-primary">Rp
                            {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                        <span class="fs-5 text-muted text-decoration-line-through ms-2">Rp
                            {{ number_format($product->price, 0, ',', '.') }}</span>
                    @else
                        <span class="fs-3 fw-bold text-primary">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    @endif
                </div>

                <p class="text-muted">{{ Str::limit($product->description, 150) }}</p>

                {{-- Form untuk menambah ke keranjang --}}
                <form id="add-to-cart-form">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div class="mt-4">
                        <h5 class="fw-bold">Pilih Varian (Ukuran)</h5>
                        <div class="d-flex flex-wrap gap-2" id="variant-options">
                            @foreach ($product->variants as $variant)
                                <div class="form-check ps-0 gap-2">
                                    <input type="radio" class="btn-check" name="variant_id"
                                        id="variant-{{ $variant->id }}" value="{{ $variant->id }}"
                                        data-stock="{{ $variant->stock }}" autocomplete="off"
                                        {{ $variant->stock == 0 ? 'disabled' : '' }}>
                                    <label class="btn btn-outline-primary"
                                        for="variant-{{ $variant->id }}">{{ $variant->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="row align-items-end mt-4">
                        <div class="col-md-5 col-lg-4">
                            <h5 class="fw-bold">Jumlah</h5>
                            <div class="input-group" style="width: 130px;">
                                <button class="btn btn-outline-secondary" type="button" id="button-minus">-</button>
                                <input type="text" id="quantity-input" name="quantity" class="form-control text-center"
                                    value="1" readonly>
                                <button class="btn btn-outline-secondary" type="button" id="button-plus">+</button>
                            </div>
                        </div>
                        <div class="col-md-7 col-lg-8">
                            <div id="stock-info" class="text-muted small mt-2 mt-md-0">
                                Pilih varian untuk melihat stok.
                            </div>
                        </div>
                    </div>

                    <div class="d-grid mt-4">
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

        <div class="row mt-5">
            <div class="col-12">
                <ul class="nav nav-tabs" id="productTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                            data-bs-target="#description-content" type="button" role="tab">Deskripsi Lengkap</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews-content"
                            type="button" role="tab">Ulasan</button>
                    </li>
                </ul>
                <div class="tab-content p-4 border border-top-0 rounded-bottom" id="productTabContent">
                    <div class="tab-pane fade show active" id="description-content" role="tabpanel">
                        <p>{!! nl2br(e($product->description)) !!}</p>
                    </div>
                    <div class="tab-pane fade" id="reviews-content" role="tabpanel">
                        <p>Ulasan untuk produk ini belum tersedia.</p>
                    </div>
                </div>
            </div>
        </div>

        @if ($relatedProducts->count() > 0)
            <div class="row mt-5">
                <div class="col-12">
                    <h2 class="fw-bold mb-4">Anda Mungkin Juga Suka</h2>
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

            $('.thumbnail-image').on('click', function() {
                $('#main-product-image').attr('src', $(this).attr('src'));
            });

            $('#button-plus').on('click', function() {
                let currentVal = parseInt(qtyInput.val());
                qtyInput.val(currentVal + 1);
            });

            $('#button-minus').on('click', function() {
                let currentVal = parseInt(qtyInput.val());
                if (currentVal > 1) {
                    qtyInput.val(currentVal - 1);
                }
            });

            $('input[name="variant_id"]').on('change', function() {
                let stock = $(this).data('stock');
                if (stock > 0) {
                    stockInfo.html(`<span class="text-success fw-bold">Stok Tersedia: ${stock}</span>`);
                    addToCartBtn.prop('disabled', false);
                } else {
                    stockInfo.html('<span class="text-danger fw-bold">Stok Habis</span>');
                    addToCartBtn.prop('disabled', true);
                }
            });

            $('#add-to-cart-form').on('submit', function(e) {
                e.preventDefault();
                let formData = $(this).serialize();
                let url = "{{ route('customer.cart.store') }}";

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
                    }
                });
            });
        });
    </script>
@endpush
