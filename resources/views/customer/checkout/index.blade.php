@extends('customer.layouts.app')

@section('title', 'Checkout')

@section('content')
    <div class="container py-5">
        <h2 class="fw-bold mb-4">Checkout</h2>
        <form id="checkout-form">
            <div class="row">
                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">Metode Pengiriman</h5>
                            <hr>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="delivery_method" id="delivery"
                                    value="delivery" checked>
                                <label class="form-check-label" for="delivery">Diantar (Delivery)</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="delivery_method" id="pickup"
                                    value="pickup">
                                <label class="form-check-label" for="pickup">Ambil di Toko</label>
                            </div>
                        </div>
                    </div>

                    <div id="delivery-section">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Alamat Pengiriman</h5>
                                <hr>
                                <select name="address_id" id="address-id" class="form-select">
                                    <option value="">Pilih Alamat</option>
                                    @foreach ($addresses as $address)
                                        <option value="{{ $address->id }}">{{ $address->label }} -
                                            {{ $address->recipient_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Pilih Kurir & Layanan</h5>
                                <hr>
                                <div id="shipping-options-container">
                                    <p class="text-muted">Pilih alamat terlebih dahulu untuk melihat pilihan kurir.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">Ringkasan Pesanan</h5>
                            <hr>
                            @foreach ($cart->items as $item)
                                <div class="d-flex justify-content-between small mb-2">
                                    <span>{{ Str::limit($item->product->name, 25) }} ({{ $item->qty }}x)</span>
                                    <span>Rp
                                        {{ number_format(($item->product->discount_price > 0 ? $item->product->discount_price : $item->product->price) * $item->qty, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                            <hr>
                            <div class="d-flex justify-content-between">
                                <span>Subtotal</span>
                                <span id="subtotal">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Ongkos Kirim</span>
                                <span id="shipping-cost-display">Rp 0</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between fw-bold fs-5">
                                <span>Total</span>
                                <span id="total-amount">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-grid mt-4">
                                <button type="submit" id="pay-button" class="btn btn-primary">Bayar Sekarang</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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

            const subtotal = {{ $subtotal }};
            let shippingCost = 0;

            $('input[name="delivery_method"]').on('change', function() {
                if ($(this).val() === 'delivery') {
                    $('#delivery-section').slideDown();
                } else {
                    $('#delivery-section').slideUp();
                    shippingCost = 0;
                    $('input[name="shipping_service"]').prop('checked', false);
                    updateTotals();
                    $('#shipping-options-container').html(
                        '<p class="text-muted">Ambil di toko tidak dikenakan ongkos kirim.</p>');
                }
            });

            $('#address-id').on('change', function() {
                let addressId = $(this).val();
                if (!addressId) {
                    $('#shipping-options-container').html(
                        '<p class="text-muted">Pilih alamat terlebih dahulu untuk melihat pilihan kurir.</p>'
                        );
                    return;
                };

                $('#shipping-options-container').html(
                    '<p class="text-muted">Menghitung ongkos kirim...</p>');
                $.ajax({
                    url: "{{ route('customer.checkout.shipping_cost') }}",
                    type: 'POST',
                    data: {
                        address_id: addressId
                    },
                    success: function(services) {
                        let html =
                            '<p class="text-danger">Tidak ada layanan pengiriman tersedia untuk alamat ini.</p>';
                        if (services && services.length > 0) {
                            html = '';
                            services.forEach(function(service) {
                                if (service && service.code && service.description &&
                                    service.cost) {
                                    let courierName = service.code.toUpperCase();
                                    let serviceDesc = service.service;
                                    let formattedCost = new Intl.NumberFormat('id-ID')
                                        .format(service.cost);
                                    let serviceValue =
                                        `${courierName} (${serviceDesc})|${service.cost}`;

                                    html += `
                                <div class="form-check border-bottom py-2">
                                    <input class="form-check-input" type="radio" name="shipping_service" id="ship-${courierName}-${service.service}" value="${serviceValue}">
                                    <label class="form-check-label d-flex justify-content-between" for="ship-${courierName}-${service.service}">
                                        <div>
                                            <strong>${courierName} - ${serviceDesc}</strong>
                                            <div class="text-muted small">Estimasi ${service.etd}</div>
                                        </div>
                                        <div class="fw-bold">Rp ${formattedCost}</div>
                                    </label>
                                </div>
                            `;
                                }
                            });
                        }
                        $('#shipping-options-container').html(html);
                    },
                    error: function(xhr) {
                        let errorMsg = xhr.responseJSON ? xhr.responseJSON.message :
                            "Gagal mengambil data ongkir.";
                        $('#shipping-options-container').html(
                            `<p class="text-danger">${errorMsg}</p>`);
                    }
                });
            });

            $(document).on('change', 'input[name="shipping_service"]', function() {
                shippingCost = parseInt($(this).val().split('|')[1]);
                updateTotals();
            });

            function updateTotals() {
                $('#shipping-cost-display').text('Rp ' + new Intl.NumberFormat('id-ID').format(shippingCost));
                $('#total-amount').text('Rp ' + new Intl.NumberFormat('id-ID').format(subtotal + shippingCost));
            }

            $('#checkout-form').on('submit', function(e) {
                e.preventDefault();
                $('#pay-button').prop('disabled', true).text('Memproses...');
                $.ajax({
                    url: "{{ route('customer.checkout.place_order') }}",
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.snap_token) {
                            snap.pay(response.snap_token, {
                                onSuccess: function(result) {
                                    window.location.href = '/';
                                },
                                onPending: function(result) {
                                    window.location.href = '/';
                                },
                                onError: function(result) {
                                    showAppToast('Pembayaran gagal!', 'error');
                                    $('#pay-button').prop('disabled', false).text(
                                        'Bayar Sekarang');
                                },
                                onClose: function() {
                                    showAppToast(
                                        'Anda menutup popup tanpa menyelesaikan pembayaran.',
                                        'error');
                                    $('#pay-button').prop('disabled', false).text(
                                        'Bayar Sekarang');
                                }
                            });
                        }
                    },
                    error: function(xhr) {
                        showAppToast('Terjadi kesalahan. Silakan coba lagi.', 'error');
                        $('#pay-button').prop('disabled', false).text('Bayar Sekarang');
                    }
                })
            });
        });
    </script>
@endpush
