@extends('customer.layouts.app')

@section('title', 'Keranjang Belanja')

@section('css')
    <style>
        .page-title {
            font-family: var(--font-heading);
            color: var(--text-dark);
            text-align: center;
            margin-bottom: 2.5rem !important;
            font-size: 2.5rem;
        }

        .cart-item-card {
            background-color: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 0.5rem;
            padding: 1.5rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .cart-item-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            border-color: var(--primary-color);
        }

        .cart-item-card .card-body {
            padding: 0;
        }

        .cart-item-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 0.375rem;
        }

        .cart-item-details {
            margin-left: 1.5rem;
        }

        .cart-item-title {
            font-family: var(--font-heading);
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-dark);
            text-decoration: none;
            transition: color 0.3s;
        }

        .cart-item-title:hover {
            color: var(--primary-color);
        }

        .cart-item-variant {
            color: #888;
            font-size: 0.9rem;
        }

        .cart-item-price {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-top: 0.5rem;
        }

        .quantity-selector-cart .btn {
            background-color: #f5f5f5;
            border-color: #ddd;
            color: var(--primary-color);
            font-weight: 700;
            width: 38px;
        }

        .quantity-selector-cart .btn:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .quantity-selector-cart .form-control {
            border-color: #ddd;
            box-shadow: none;
        }

        .remove-item-btn {
            font-size: 1.2rem;
            color: #aaa;
            transition: all 0.3s ease;
            padding: 0.5rem;
            line-height: 1;
        }

        .remove-item-btn:hover {
            color: #e74c3c;
            transform: scale(1.2);
        }

        .summary-card {
            background-color: #fff;
            border-radius: 0.5rem;
            padding: 1.5rem;
            border: 1px solid #e0e0e0;
            position: sticky;
            top: 20px;
        }

        .summary-title {
            font-family: var(--font-heading);
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .summary-item,
        .summary-total {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.75rem;
        }

        .summary-item span:first-child {
            color: #666;
        }

        .summary-total {
            font-size: 1.2rem;
            font-weight: 700;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 2px dashed #eee;
        }

        .cart-empty-state {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.5), rgba(245, 245, 220, 0.5));
            border: 1px solid rgba(0, 0, 0, 0.05);
            padding: 4rem;
            border-radius: 0.75rem;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
        }

        .cart-empty-state .icon-wrapper {
            width: 100px;
            height: 100px;
            background-color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem auto;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .cart-empty-state .icon-wrapper i {
            font-size: 3.5rem;
            color: var(--primary-color);
        }
    </style>
@endsection

@section('content')
    <div class="container py-5">
        <h1 class="page-title">Keranjang Belanja</h1>

        <div id="cart-content">
            @if ($cart && $cart->items->isNotEmpty())
                <div class="row">
                    <div class="col-lg-8" id="cart-items-container">
                        @foreach ($cart->items as $item)
                            <div class="card mb-3 cart-item-card" data-id="{{ $item->id }}">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $item->product->images->first() ? asset('storage/products/' . $item->product->images->first()->path) : 'https://via.placeholder.com/150' }}"
                                            class="cart-item-img" alt="{{ $item->product->name }}">

                                        <div class="flex-grow-1 cart-item-details">
                                            <a href="{{ route('customer.products.show', $item->product) }}"
                                                class="cart-item-title">{{ $item->product->name }}</a>
                                            <p class="cart-item-variant mb-0">Varian: {{ $item->variant->name }}</p>
                                            <p class="cart-item-price mb-0">
                                                Rp
                                                {{ number_format($item->product->discount_price > 0 ? $item->product->discount_price : $item->product->price, 0, ',', '.') }}
                                            </p>
                                        </div>

                                        <div class="input-group quantity-selector-cart" style="width: 130px;"
                                            data-stock="{{ $item->variant->stock }}">
                                            <button class="btn quantity-btn" type="button" data-action="minus"
                                                data-id="{{ $item->id }}">-</button>
                                            <input type="text" class="form-control text-center quantity-input"
                                                value="{{ $item->qty }}" readonly data-id="{{ $item->id }}">
                                            <button class="btn quantity-btn" type="button" data-action="plus"
                                                data-id="{{ $item->id }}">+</button>
                                        </div>

                                        <div class="ms-4">
                                            <button class="btn btn-link text-decoration-none remove-item-btn"
                                                data-id="{{ $item->id }}" title="Hapus item">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="col-lg-4">
                        <div class="summary-card">
                            <h5 class="summary-title">Ringkasan Belanja</h5>
                            <div class="summary-item">
                                <span>Subtotal</span>
                                <span id="subtotal-amount">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="summary-item">
                                <span>Ongkos Kirim</span>
                                <span>Rp 0</span>
                            </div>
                            <div class="summary-total">
                                <span>Total</span>
                                <span id="total-amount">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-grid mt-4">
                                <a href="{{ route('customer.checkout.index') }}" class="btn btn-primary btn-lg">
                                    Lanjut ke Checkout <i class="bi bi-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div class="text-center cart-empty-state">
                            <div class="icon-wrapper">
                                <i class="bi bi-bag-heart"></i>
                            </div>
                            <h4 class="mt-4" style="font-family: var(--font-heading);">Keranjang Anda Masih Kosong</h4>
                            <p class="text-muted">Temukan produk favorit Anda dan tambahkan ke sini!</p>
                            <a href="{{ route('customer.products.index') }}" class="btn btn-primary mt-3">
                                <i class="bi bi-search me-2"></i> Telusuri Produk
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#cart-content').on('click', '.quantity-btn', function() {
                let action = $(this).data('action');
                let itemId = $(this).data('id');
                let inputGroup = $(this).closest('.quantity-selector-cart');
                let maxStock = parseInt(inputGroup.data('stock'));
                let qtyInput = $(`.quantity-input[data-id="${itemId}"]`);
                let currentQty = parseInt(qtyInput.val());
                let newQty = currentQty;

                if (action === 'plus') {
                    if (currentQty >= maxStock) {
                        showAppToast(`Stok tidak mencukupi. Stok yang tersedia hanya ${maxStock}.`,
                            'error');
                        return;
                    }
                    newQty = currentQty + 1;
                } else {
                    if (currentQty <= 1) {
                        return;
                    }
                    newQty = currentQty - 1;
                }
                qtyInput.val(newQty);
                updateCart(itemId, newQty, currentQty);
            });

            $('#cart-content').on('click', '.remove-item-btn', function() {
                let itemId = $(this).data('id');
                if (confirm('Anda yakin ingin menghapus item ini dari keranjang?')) {
                    $.ajax({
                        url: `{{ url('/keranjang/hapus') }}/${itemId}`,
                        type: 'DELETE',
                        success: function(response) {
                            if (response.success) {
                                $(`.cart-item-card[data-id="${itemId}"]`).fadeOut(300,
                                    function() {
                                        $(this).remove();
                                    });
                                updateTotals(response);
                                showAppToast('Item berhasil dihapus.', 'success');
                                if (response.cartCount === 0) {
                                    $('#cart-content').html(`
                                    <div class="row">
                                        <div class="col-md-8 offset-md-2">
                                            <div class="text-center cart-empty-state">
                                                <div class="icon-wrapper">
                                                    <i class="bi bi-bag-heart"></i>
                                                </div>
                                                <h4 class="mt-4" style="font-family: var(--font-heading);">Keranjang Anda Masih Kosong</h4>
                                                <p class="text-muted">Temukan produk favorit Anda dan tambahkan ke sini!</p>
                                                <a href="{{ route('customer.products.index') }}" class="btn btn-primary mt-3">
                                                    <i class="bi bi-search me-2"></i> Telusuri Produk
                                                </a>
                                            </div>
                                        </div>
                                    </div>`);
                                }
                            }
                        },
                        error: function(xhr) {
                            let errorMsg = xhr.responseJSON ? (xhr.responseJSON.error || xhr
                                .responseJSON.message) : 'Gagal menghapus item.';
                            showAppToast(errorMsg, 'error');
                        }
                    });
                }
            });

            function updateCart(itemId, quantity, oldQty) {
                let itemCard = $(`.cart-item-card[data-id="${itemId}"]`);
                itemCard.css('opacity', 0.5);

                $.ajax({
                    url: `{{ url('/keranjang/update') }}/${itemId}`,
                    type: 'PATCH',
                    data: {
                        quantity: quantity
                    },
                    success: function(response) {
                        if (response.success) {
                            updateTotals(response);
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = xhr.responseJSON ? (xhr.responseJSON.error || xhr.responseJSON
                            .message) : 'Gagal memperbarui keranjang.';
                        showAppToast(errorMsg, 'error');
                        $(`.quantity-input[data-id="${itemId}"]`).val(oldQty);
                    },
                    complete: function() {
                        itemCard.css('opacity', 1);
                    }
                });
            }

            function updateTotals(response) {
                $('#subtotal-amount').text(response.newSubtotal);
                $('#total-amount').text(response.newSubtotal);
                $('#cart-count-badge').text(response.cartCount).toggleClass('d-none', response.cartCount == 0);
            }
        });
    </script>
@endpush
