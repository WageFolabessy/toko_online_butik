<div class="card product-card h-100 border-0 shadow-sm">
    <a href="{{ route('customer.products.show', $product) }}">
        <img src="{{ $product->images->first() ? asset('storage/products/' . $product->images->first()->path) : 'https://via.placeholder.com/300' }}"
            class="card-img-top" alt="{{ $product->name }}">
    </a>
    <div class="card-body">
        <a href="#" class="text-muted text-decoration-none small">{{ $product->category->name }}</a>
        <h5 class="card-title mt-1">
            <a href="{{ route('customer.products.show', $product) }}" class="text-dark text-decoration-none">{{ Str::limit($product->name, 25) }}</a>
        </h5>
        <p class="card-text fw-bold text-primary">
            @if ($product->discount_price > 0)
                Rp {{ number_format($product->discount_price, 0, ',', '.') }}
                <span class="text-muted text-decoration-line-through small ms-1">Rp
                    {{ number_format($product->price, 0, ',', '.') }}</span>
            @else
                Rp {{ number_format($product->price, 0, ',', '.') }}
            @endif
        </p>
    </div>
</div>
