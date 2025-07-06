@extends('customer.layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
    <div class="container py-5">
        <h2 class="fw-bold mb-4">Keranjang Belanja Saya</h2>

        <div id="cart-content">
            @if ($cart && $cart->items->isNotEmpty())
                <div class="row">
                    <div class="col-lg-8" id="cart-items-container">
                        @foreach ($cart->items as $item)
                            <div class="card mb-3 border-0 shadow-sm cart-item-card" data-id="{{ $item->id }}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <img src="{{ $item->product->images->first() ? asset('storage/products/' . $item->product->images->first()->path) : 'https://via.placeholder.com/150' }}"
                                                class="img-fluid rounded" alt="{{ $item->product->name }}">
                                        </div>
                                        <div class="col-md-5">
                                            <h5 class="mb-1">
                                                <a href="{{ route('customer.products.show', $item->product) }}"
                                                    class="text-dark text-decoration-none">
                                                    {{ $item->product->name }}
                                                </a>
                                            </h5>
                                            <p class="text-muted small mb-1">Varian: {{ $item->variant->name }}</p>
                                            <p class="fw-bold product-price">
                                                Rp
                                                {{ number_format($item->product->discount_price > 0 ? $item->product->discount_price : $item->product->price, 0, ',', '.') }}
                                            </p>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-center">
                                            <div class="input-group" style="width: 120px;">
                                                <button class="btn btn-outline-secondary btn-sm quantity-btn" type="button"
                                                    data-action="minus" data-id="{{ $item->id }}">-</button>
                                                <input type="text"
                                                    class="form-control form-control-sm text-center quantity-input"
                                                    value="{{ $item->qty }}" readonly data-id="{{ $item->id }}">
                                                <button class="btn btn-outline-secondary btn-sm quantity-btn" type="button"
                                                    data-action="plus" data-id="{{ $item->id }}">+</button>
                                            </div>
                                        </div>
                                        <div class="col-md-3 d-flex align-items-center justify-content-end">
                                            <button class="btn btn-link text-danger remove-item-btn"
                                                data-id="{{ $item->id }}">Hapus</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Ringkasan Belanja</h5>
                                <hr>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal</span>
                                    <span id="subtotal-amount">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Ongkos Kirim</span>
                                    <span>Rp 0</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between fw-bold fs-5">
                                    <span>Total</span>
                                    <span id="total-amount">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-grid mt-4">
                                    <a href="{{ route('customer.checkout.index') }}" class="btn btn-primary">Lanjut ke Checkout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-cart-x" style="font-size: 5rem;"></i>
                    <h4 class="mt-3">Keranjang belanja Anda kosong.</h4>
                    <p class="text-muted">Ayo isi dengan produk-produk terbaik kami!</p>
                    <a href="{{ route('customer.products.index') }}" class="btn btn-primary mt-2">Mulai Belanja</a>
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

            $('.quantity-btn').on('click', function() {
                let action = $(this).data('action');
                let itemId = $(this).data('id');
                let qtyInput = $(`.quantity-input[data-id="${itemId}"]`);
                let currentQty = parseInt(qtyInput.val());
                let newQty = action === 'plus' ? currentQty + 1 : currentQty - 1;

                if (newQty < 1) return;

                updateCart(itemId, newQty);
            });

            $('.remove-item-btn').on('click', function() {
                let itemId = $(this).data('id');
                if (confirm('Anda yakin ingin menghapus item ini dari keranjang?')) {
                    $.ajax({
                        url: `/keranjang/hapus/${itemId}`,
                        type: 'DELETE',
                        success: function(response) {
                            if (response.success) {
                                $(`.cart-item-card[data-id="${itemId}"]`).remove();
                                updateTotals(response);
                                if (response.cartCount === 0) {
                                    $('#cart-content').html(`
                                <div class="text-center py-5">
                                    <i class="bi bi-cart-x" style="font-size: 5rem;"></i>
                                    <h4 class="mt-3">Keranjang belanja Anda kosong.</h4>
                                    <p class="text-muted">Ayo isi dengan produk-produk terbaik kami!</p>
                                    <a href="{{ route('customer.products.index') }}" class="btn btn-primary mt-2">Mulai Belanja</a>
                                </div>
                            `);
                                }
                            }
                        },
                        error: function(xhr) {
                            showAppToast(xhr.responseJSON.error, 'error');
                        }
                    });
                }
            });

            function updateCart(itemId, quantity) {
                $.ajax({
                    url: `/keranjang/update/${itemId}`,
                    type: 'PATCH',
                    data: {
                        quantity: quantity
                    },
                    success: function(response) {
                        if (response.success) {
                            $(`.quantity-input[data-id="${itemId}"]`).val(quantity);
                            updateTotals(response);
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = xhr.responseJSON ? xhr.responseJSON.error :
                            'Gagal memperbarui keranjang.';
                        showAppToast(errorMsg, 'error');
                        let currentQty = parseInt($(`.quantity-input[data-id="${itemId}"]`).val());
                        if (quantity > currentQty) {
                            $(`.quantity-input[data-id="${itemId}"]`).val(currentQty);
                        }
                    }
                });
            }

            function updateTotals(response) {
                $('#subtotal-amount').text(response.newSubtotal);
                $('#total-amount').text(response.newSubtotal);
                $('#cart-count-badge').text(response.cartCount).toggleClass('d-none', response.cartCount === 0);
            }
        });
    </script>
@endpush
