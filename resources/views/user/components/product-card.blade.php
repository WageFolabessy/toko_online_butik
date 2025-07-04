<div class="card product-card h-100 shadow-sm">
    <a href="#">
        <img src="{{ $product->images->first() ? asset('storage/' . $product->images->first()->path) : 'https://placehold.co/600x800/E1E1E1/424242?text=Butik+Disel' }}"
            class="card-img-top" alt="{{ $product->name }}">
    </a>
    <div class="card-body d-flex flex-column">
        <h5 class="card-title fs-6">
            <a href="#" class="text-decoration-none text-dark stretched-link">{{ $product->name }}</a>
        </h5>

        <div class="mt-auto">
            @if ($product->discount_price > 0 && $product->discount_price < $product->price)
                @php
                    $discountPercentage = round((($product->price - $product->discount_price) / $product->price) * 100);
                @endphp
                <div>
                    <span class="fw-bold text-primary fs-5">Rp
                        {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                </div>
                <div>
                    <del class="text-muted small">Rp {{ number_format($product->price, 0, ',', '.') }}</del>
                    <span class="badge bg-danger ms-2">{{ $discountPercentage }}%</span>
                </div>
            @else
                <p class="fw-bold text-primary fs-5 mb-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            @endif

            <div class="d-grid mt-2">
                <button class="btn btn-dark">
                    <i class="bi bi-cart-plus-fill me-2"></i> Tambah
                </button>
            </div>
        </div>
    </div>
</div>
