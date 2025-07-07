@extends('customer.layouts.app')

@section('title', 'Checkout')

@section('css')
    <style>
        .page-header h2 {
            font-family: var(--font-heading);
            font-size: 2.5rem;
        }

        .checkout-card {
            background-color: #fff;
            border: 1px solid #e5e5e5;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .checkout-card .card-header {
            background-color: transparent;
            border-bottom: 1px solid #eee;
            padding: 1rem 1.25rem;
            font-family: var(--font-heading);
            font-weight: 600;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
        }

        .checkout-card .card-header .step-number {
            background-color: var(--primary-color);
            color: white;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.75rem;
            font-size: 1rem;
        }

        .checkout-card .card-body {
            padding: 1.25rem;
        }

        .custom-radio-card {
            position: relative;
        }

        .custom-radio-card input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            cursor: pointer;
        }

        .custom-radio-card .card-body {
            border: 2px solid #eee;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
            padding: 1rem;
        }

        .custom-radio-card input[type="radio"]:checked+.card-body {
            border-color: var(--primary-color);
            background-color: var(--secondary-color);
            box-shadow: 0 0 0 2px var(--primary-color);
        }

        .custom-radio-card .card-body .icon {
            font-size: 2rem;
            color: var(--primary-color);
        }

        .summary-card {
            background-color: #fcfcfc;
            border: 1px solid #e5e5e5;
            border-radius: 0.5rem;
            position: sticky;
            top: 20px;
        }

        .summary-card .card-header {
            font-size: 1.3rem;
            background-color: transparent;
            border-bottom: none;
            padding-bottom: 0;
        }

        .summary-card .card-body {
            padding: 1.25rem;
        }

        #summary-items {
            max-height: 250px;
            overflow-y: auto;
            padding-right: 10px;
        }

        .summary-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .summary-item img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 0.375rem;
            border: 1px solid #eee;
        }

        .summary-item .item-info {
            flex-grow: 1;
            margin-left: 0.75rem;
        }

        .summary-item .item-name {
            font-weight: 600;
            font-size: 0.9rem;
            line-height: 1.3;
        }

        .summary-item .item-qty {
            font-size: 0.8rem;
            color: #888;
        }

        .summary-details {
            padding: 1rem 0;
            border-top: 1px solid #eee;
        }

        .summary-details .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
            color: #555;
        }

        .summary-total-block {
            background-color: var(--secondary-color);
            border-radius: 0.375rem;
            padding: 1rem;
            margin-top: 1rem;
        }

        .summary-total-block .d-flex {
            align-items: center;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .summary-total-block span:first-child {
            font-family: var(--font-heading);
        }
    </style>
@endsection

@section('content')
    <div class="container py-5">
        <div class="page-header mb-4">
            <h2 class="fw-bold">Checkout</h2>
        </div>
        <form id="checkout-form">
            <div class="row">
                <div class="col-lg-7">
                    <div class="card checkout-card">
                        <div class="card-header"><span class="step-number">1</span>Metode Pengiriman</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="custom-radio-card">
                                        <input class="form-check-input" type="radio" name="delivery_method" id="delivery"
                                            value="delivery" checked>
                                        <div class="card-body text-center">
                                            <div class="icon mb-2"><i class="bi bi-truck"></i></div>
                                            <h6 class="mb-0">Diantar (Delivery)</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="custom-radio-card">
                                        <input class="form-check-input" type="radio" name="delivery_method" id="pickup"
                                            value="pickup">
                                        <div class="card-body text-center">
                                            <div class="icon mb-2"><i class="bi bi-shop"></i></div>
                                            <h6 class="mb-0">Ambil di Toko</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="delivery-section">
                        <div class="card checkout-card">
                            <div class="card-header"><span class="step-number">2</span>Alamat & Kurir</div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="address-id" class="form-label fw-bold">Pilih Alamat Pengiriman</label>
                                    <select name="address_id" id="address-id" class="form-select">
                                        <option value="">-- Pilih Alamat Tersimpan --</option>
                                        @foreach ($addresses as $address)
                                            <option value="{{ $address->id }}">{{ $address->label }} -
                                                {{ $address->recipient_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <hr>
                                <div>
                                    <label class="form-label fw-bold">Pilih Layanan Pengiriman</label>
                                    <div id="shipping-options-container">
                                        <div class="alert alert-secondary text-center">Pilih alamat terlebih dahulu untuk
                                            melihat pilihan kurir.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="summary-card p-4">
                        <div class="card-header">Ringkasan Pesanan</div>
                        <div class="card-body">
                            <div id="summary-items">
                                @foreach ($cart->items as $item)
                                    <div class="summary-item">
                                        <img src="{{ $item->product->images->first() ? asset('storage/products/' . $item->product->images->first()->path) : 'https://via.placeholder.com/60' }}"
                                            alt="{{ $item->product->name }}">
                                        <div class="item-info">
                                            <div class="item-name">{{ $item->product->name }}</div>
                                            <div class="item-qty">{{ $item->qty }} item</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="summary-details">
                                <div class="detail-row">
                                    <span>Subtotal</span>
                                    <span id="subtotal" class="fw-semibold">Rp
                                        {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="detail-row">
                                    <span>Ongkos Kirim</span>
                                    <span id="shipping-cost-display" class="fw-semibold">Rp 0</span>
                                </div>
                            </div>

                            <div class="summary-total-block">
                                <div class="d-flex justify-content-between">
                                    <span>Total</span>
                                    <span id="total-amount">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" id="pay-button" class="btn btn-primary btn-lg">
                                    <i class="bi bi-shield-lock-fill me-2"></i> Bayar Sekarang
                                </button>
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

            function updateTotals() {
                $('#shipping-cost-display').text('Rp ' + new Intl.NumberFormat('id-ID').format(shippingCost));
                $('#total-amount').text('Rp ' + new Intl.NumberFormat('id-ID').format(subtotal + shippingCost));
            }

            $('input[name="delivery_method"]').on('change', function() {
                if ($(this).val() === 'delivery') {
                    $('#delivery-section').slideDown();
                    $('#address-id').trigger('change');
                } else {
                    $('#delivery-section').slideUp();
                    shippingCost = 0;
                    $('input[name="shipping_service"]').prop('checked', false);
                    updateTotals();
                    $('#shipping-options-container').html(
                        '<div class="alert alert-secondary text-center">Ambil di toko tidak dikenakan ongkos kirim.</div>'
                    );
                }
            });

            $('#address-id').on('change', function() {
                let addressId = $(this).val();
                shippingCost = 0;
                updateTotals();

                if (!addressId) {
                    $('#shipping-options-container').html(
                        '<div class="alert alert-secondary text-center">Pilih alamat terlebih dahulu.</div>'
                    );
                    return;
                }

                $('#shipping-options-container').html(
                    '<div class="text-center p-3"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menghitung ongkos kirim...</div>'
                );

                $.ajax({
                    url: "{{ route('customer.checkout.shipping_cost') }}",
                    type: 'POST',
                    data: {
                        address_id: addressId
                    },
                    success: function(services) {
                        let html =
                            '<div class="alert alert-danger text-center">Tidak ada layanan pengiriman tersedia.</div>';
                        if (services && services.length > 0) {
                            html = '<div class="d-flex flex-column gap-2">';
                            services.forEach(function(service) {
                                if (service && service.code && service.cost) {
                                    let courierName = service.code.toUpperCase();
                                    let serviceDesc = service.service;
                                    let formattedCost = new Intl.NumberFormat('id-ID')
                                        .format(service.cost);
                                    let etd = service.etd ? `Estimasi ${service.etd}`
                                        .replace(' HARI', ' hari') : '';
                                    let serviceValue =
                                        `${courierName} (${serviceDesc})|${service.cost}`;

                                    html += `
                                    <div class="custom-radio-card">
                                        <input class="form-check-input" type="radio" name="shipping_service" id="ship-${courierName}-${serviceDesc}" value="${serviceValue}">
                                        <div class="card-body d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-0">${courierName} - ${serviceDesc}</h6>
                                                <small class="text-muted">${etd}</small>
                                            </div>
                                            <strong class="ms-3">Rp ${formattedCost}</strong>
                                        </div>
                                    </div>`;
                                }
                            });
                            html += '</div>';
                        }
                        $('#shipping-options-container').html(html);
                    },
                    error: function(xhr) {
                        $('#shipping-options-container').html(
                            `<div class="alert alert-danger text-center">Gagal mengambil data ongkir.</div>`
                        );
                    }
                });
            });

            $(document).on('change', 'input[name="shipping_service"]', function() {
                shippingCost = parseInt($(this).val().split('|')[1]);
                updateTotals();
            });

            $('#checkout-form').on('submit', function(e) {
                e.preventDefault();
                let payButton = $('#pay-button');
                payButton.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...'
                );

                $.ajax({
                    url: "{{ route('customer.checkout.place_order') }}",
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.payment_url) {
                            window.location.href = response.redirect_url;
                        } else if (response.snap_token) {
                            snap.pay(response.snap_token, {
                                onSuccess: function(result) {
                                    window.location.href = result
                                        .finish_redirect_url;
                                },
                                onPending: function(result) {
                                    window.location.href = result
                                        .finish_redirect_url;
                                },
                                onError: function(result) {
                                    showAppToast('Pembayaran gagal!', 'error');
                                    payButton.prop('disabled', false).html(
                                        '<i class="bi bi-shield-lock-fill me-2"></i> Bayar Sekarang'
                                    );
                                },
                                onClose: function() {
                                    showAppToast(
                                        'Anda menutup popup tanpa menyelesaikan pembayaran.',
                                        'warning');
                                    payButton.prop('disabled', false).html(
                                        '<i class="bi bi-shield-lock-fill me-2"></i> Bayar Sekarang'
                                    );
                                }
                            });
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = xhr.responseJSON ? xhr.responseJSON.message :
                            'Terjadi kesalahan. Silakan coba lagi.';
                        showAppToast(errorMsg, 'error');
                        payButton.prop('disabled', false).html(
                            '<i class="bi bi-shield-lock-fill me-2"></i> Bayar Sekarang');
                    }
                });
            });
        });
    </script>
@endpush
