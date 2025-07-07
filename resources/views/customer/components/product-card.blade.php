<div class="card product-card h-100">
    <div class="product-image-container">
        <a href="{{ route('customer.products.show', $product) }}">
            <img src="{{ $product->images->first() ? asset('storage/products/' . $product->images->first()->path) : 'https://via.placeholder.com/400' }}"
                class="card-img-top" alt="{{ $product->name }}">
        </a>

        @if ($product->discount_price > 0)
            <span class="sale-badge">Diskon</span>
        @endif

        <div class="product-actions">
            <a href="{{ route('customer.products.show', $product) }}" class="action-btn" title="Lihat Cepat (Quick View)"><i
                    class="bi bi-eye"></i></a>
        </div>
    </div>
    <div class="card-body d-flex flex-column">
        <div class="text-center">
            <a href="#" class="product-category">{{ $product->category->name }}</a>
            <h5 class="card-title product-title mt-1">
                <a href="{{ route('customer.products.show', $product) }}" class="text-decoration-none">
                    {{ Str::limit($product->name, 25) }}
                </a>
            </h5>
            <p class="product-price">
                @if ($product->discount_price > 0)
                    Rp {{ number_format($product->discount_price, 0, ',', '.') }}
                    <span class="original-price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                @else
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                @endif
            </p>
        </div>
        <div class="mt-auto">
            <a href="{{ route('customer.products.show', $product) }}" class="text-decoration-none">
                <button class="btn btn-primary w-100 btn-add-to-cart">

                    <i class="bi bi-eye me-2"></i>Lihat
                </button>
            </a>
        </div>
    </div>
</div>
