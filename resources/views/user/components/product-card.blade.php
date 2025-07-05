<div class="product-card-wrapper">
    <div class="card product-card h-100 shadow-sm border-0">
        @if ($product->created_at->diffInDays() < 7)
            <div class="position-absolute top-0 start-0 m-2 z-3">
                <span class="badge bg-success">Baru</span>
            </div>
        @endif

        @if ($product->discount_price > 0 && $product->discount_price < $product->price)
            @php $discountPercentage = round((($product->price - $product->discount_price) / $product->price) * 100); @endphp
            <div class="position-absolute top-0 end-0 m-2 z-3">
                <span class="badge bg-danger">-{{ $discountPercentage }}%</span>
            </div>
        @endif

        <div class="product-image-wrapper position-relative overflow-hidden">
            <a href="{{ route('products.show', $product->slug) }}">
                <img src="{{ $product->images->first() ? asset('storage/' . $product->images->first()->path) : 'https://placehold.co/600x800/E1E1E1/424242?text=Butik+Disel' }}"
                    class="card-img-top product-image" alt="{{ $product->name }}">
            </a>

            <div class="product-actions position-absolute bottom-0 start-0 end-0 p-3 bg-gradient-dark">
                <div class="d-grid gap-2">
                    <button class="btn btn-primary btn-sm fw-500 quick-add-btn">
                        <i class="bi bi-cart-plus me-2"></i>Tambah ke Keranjang
                    </button>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-light btn-sm flex-fill">
                            <i class="bi bi-eye"></i> Lihat
                        </button>
                        <button class="btn btn-outline-light btn-sm">
                            <i class="bi bi-heart"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body d-flex flex-column p-3">
            <div class="mb-1">
                <small class="text-muted text-uppercase fw-500 letter-spacing">
                    {{ $product->category->name ?? 'Fashion' }}
                </small>
            </div>

            <h5 class="card-title mb-2 lh-sm">
                <a href="{{ route('products.show', $product->slug) }}"
                    class="text-decoration-none text-dark fw-600 stretched-link">
                    {{ $product->name }}
                </a>
            </h5>

            <div class="mt-auto">
                @if ($product->discount_price > 0 && $product->discount_price < $product->price)
                    <div class="price-section">
                        <div class="current-price fw-bold text-primary fs-5 mb-1">
                            Rp {{ number_format($product->discount_price, 0, ',', '.') }}
                        </div>
                        <div class="original-price">
                            <del class="text-muted small">Rp {{ number_format($product->price, 0, ',', '.') }}</del>
                        </div>
                    </div>
                @else
                    <div class="price-section">
                        <div class="current-price fw-bold text-dark fs-5">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
