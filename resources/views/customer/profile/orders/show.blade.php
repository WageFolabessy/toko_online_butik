@extends('customer.layouts.app')

@section('title', 'Detail Pesanan ' . $order->order_number)

@section('css')
    <style>
        .page-header h3 {
            font-family: var(--font-heading);
            font-size: 2rem;
        }

        .detail-card {
            background-color: #fff;
            border: 1px solid #e5e5e5;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .detail-card .card-header,
        .detail-card .card-body {
            padding: 1.25rem;
        }

        .detail-card .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e5e5e5;
            font-family: var(--font-heading);
            font-weight: 600;
            font-size: 1.2rem;
        }

        .order-item {
            display: flex;
            align-items: center;
            padding: 1rem 0;
        }

        .order-item:not(:last-child) {
            border-bottom: 1px dashed #eee;
        }

        .order-item img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 0.375rem;
        }

        .item-details .item-name {
            font-weight: 600;
            color: var(--text-dark);
        }

        .item-details .item-meta {
            font-size: 0.85rem;
            color: #777;
        }

        .info-block p {
            display: grid;
            grid-template-columns: 120px 1fr;
            gap: 1rem;
            margin-bottom: 0.5rem;
        }

        .info-block strong {
            color: #555;
        }

        .badge {
            padding: 0.4em 0.8em;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .rating-stars {
            display: inline-block;
            direction: rtl;
        }

        .rating-stars input[type="radio"] {
            display: none;
        }

        .rating-stars label {
            color: #ddd;
            font-size: 2rem;
            cursor: pointer;
            transition: color 0.2s;
        }

        .rating-stars input[type="radio"]:checked~label,
        .rating-stars label:hover,
        .rating-stars label:hover~label {
            color: var(--primary-color);
            opacity: 0.8;
        }

        .modal-header {
            border-bottom: 1px solid #eee;
        }

        .modal-title {
            font-family: var(--font-heading);
        }

        .modal-footer {
            border-top: 1px solid #eee;
        }
    </style>
@endsection

@section('content')
    <div class="container py-5">
        <div class="page-header d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold">Detail Pesanan</h3>
                <p class="text-muted mb-0">Nomor Pesanan: <span class="fw-semibold">#{{ $order->order_number }}</span></p>
            </div>
            <div class="d-flex gap-2">
                @if (in_array($order->status, ['shipped', 'ready_for_pickup']))
                    <form action="{{ route('customer.profile.orders.confirm', $order) }}" method="POST"
                        onsubmit="return confirm('Apakah Anda yakin sudah menerima pesanan ini?');">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle-fill me-2"></i> Pesanan Diterima
                        </button>
                    </form>
                @endif
                <a href="{{ route('customer.profile.orders.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i> Kembali
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row">
            <div class="col-lg-8">
                <div class="card detail-card">
                    <div class="card-header">Item Pesanan</div>
                    <div class="card-body">
                        @foreach ($order->items as $item)
                            <div class="order-item">
                                <img src="{{ $item->product->images->first() ? asset('storage/products/' . $item->product->images->first()->path) : 'https://via.placeholder.com/150' }}"
                                    alt="{{ $item->product->name }}">
                                <div class="ms-3 flex-grow-1 item-details">
                                    <div class="item-name">{{ $item->product->name }}</div>
                                    <div class="item-meta">Varian: {{ $item->variant->name }}</div>
                                    <div class="item-meta">{{ $item->qty }} x Rp
                                        {{ number_format($item->price, 0, ',', '.') }}</div>
                                </div>
                                <div class="ms-3 text-end">
                                    @if ($order->status === 'completed')
                                        @if ($item->review)
                                            <div class="text-warning small mb-1">
                                                @for ($i = 0; $i < 5; $i++)
                                                    <i
                                                        class="bi {{ $i < $item->review->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                                @endfor
                                            </div>
                                            <button class="btn btn-sm btn-outline-secondary edit-review-btn"
                                                data-bs-toggle="modal" data-bs-target="#reviewModal"
                                                data-review-id="{{ $item->review->id }}"
                                                data-rating="{{ $item->review->rating }}"
                                                data-review-text="{{ $item->review->review }}">
                                                <i class="bi bi-pencil-fill"></i> Ubah Ulasan
                                            </button>
                                        @else
                                            <button class="btn btn-sm btn-primary write-review-btn" data-bs-toggle="modal"
                                                data-bs-target="#reviewModal" data-product-id="{{ $item->product_id }}"
                                                data-order-item-id="{{ $item->id }}">
                                                <i class="bi bi-chat-square-text-fill me-1"></i> Tulis Ulasan
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="card detail-card">
                    <div class="card-header">Detail Pengiriman</div>
                    <div class="card-body info-block">
                        <p><strong>Metode</strong>
                            <span>{{ Str::title(str_replace('_', ' ', $order->delivery_method)) }}</span>
                        </p>
                        @if ($order->delivery_method == 'delivery' && $order->address)
                            <p><strong>Penerima</strong> <span>{{ $order->address->recipient_name }}</span></p>
                            <p><strong>Telepon</strong> <span>{{ $order->address->phone_number }}</span></p>
                            <p><strong>Alamat</strong> <span>{{ $order->address->full_address }},
                                    {{ $order->address->postal_code }}</span></p>
                            @if ($order->shipment)
                                <p><strong>Kurir</strong> <span>{{ $order->shipment->courier }}
                                        ({{ $order->shipment->service }})</span></p>
                                <p><strong>No. Resi</strong>
                                    <span>{{ $order->shipment->tracking_number ?? 'Belum tersedia' }}</span>
                                </p>
                            @endif
                        @else
                            <p><strong>Lokasi</strong> <span>Diambil di toko</span></p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card detail-card">
                    <div class="card-header">Rincian Pembayaran</div>
                    <div class="card-body info-block">
                        <p><strong>Status Pesanan</strong> <span
                                class="badge {{ $order->status_badge_class }}">{{ $order->status_text }}</span></p>
                        @if ($order->payment)
                            <p><strong>Status Bayar</strong> <span
                                    class="badge {{ $order->payment->status_badge_class }}">{{ $order->payment->status_text }}</span>
                            </p>
                            <p><strong>Metode Bayar</strong>
                                <span>{{ Str::title(str_replace('_', ' ', $order->payment->payment_type)) }}</span>
                            </p>
                        @endif
                        <hr class="my-3">
                        <p><strong>Subtotal</strong> <span>Rp
                                {{ number_format($order->total_amount - $order->shipping_cost, 0, ',', '.') }}</span></p>
                        <p><strong>Ongkos Kirim</strong> <span>Rp
                                {{ number_format($order->shipping_cost, 0, ',', '.') }}</span></p>
                        <hr class="my-2">
                        <p class="fs-5"><strong>Total</strong> <span class="fw-bold">Rp
                                {{ number_format($order->total_amount, 0, ',', '.') }}</span></p>

                        @if ($order->status == 'awaiting_payment' && $order->payment && $order->payment->payment_url)
                            <div class="d-grid mt-3">
                                <a href="{{ $order->payment->payment_url }}" class="btn btn-primary" target="_blank">Bayar
                                    Sekarang</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewModalLabel">Berikan Ulasan Anda</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="reviewForm" action="" method="POST">
                    @csrf
                    <div class="modal-body text-center">
                        <input type="hidden" name="product_id" id="review-product-id">
                        <input type="hidden" name="order_item_id" id="review-order-item-id">
                        <div class="mb-3">
                            <label class="form-label d-block">Rating Anda</label>
                            <div class="rating-stars">
                                <input type="radio" name="rating" id="rating-5" value="5" required><label
                                    for="rating-5">★</label>
                                <input type="radio" name="rating" id="rating-4" value="4" required><label
                                    for="rating-4">★</label>
                                <input type="radio" name="rating" id="rating-3" value="3" required><label
                                    for="rating-3">★</label>
                                <input type="radio" name="rating" id="rating-2" value="2" required><label
                                    for="rating-2">★</label>
                                <input type="radio" name="rating" id="rating-1" value="1" required><label
                                    for="rating-1">★</label>
                            </div>
                        </div>
                        <div class="mb-3 text-start">
                            <label for="review-text" class="form-label">Ulasan Anda (Opsional)</label>
                            <textarea class="form-control" name="review" id="review-text" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Kirim Ulasan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            const reviewModal = new bootstrap.Modal(document.getElementById('reviewModal'));
            const reviewForm = $('#reviewForm');

            const reviewUpdateUrlTemplate = "{{ route('customer.profile.ulasan.update', ['review' => ':id']) }}";
            const reviewDestroyUrlTemplate = "{{ route('customer.profile.ulasan.destroy', ['review' => ':id']) }}";

            $('.write-review-btn').on('click', function() {
                let productId = $(this).data('productId');
                let orderItemId = $(this).data('orderItemId');
                reviewForm.attr('action', "{{ route('customer.profile.ulasan.store') }}");
                reviewForm.find('input[name="_method"]').remove();
                $('#review-product-id').val(productId);
                $('#review-order-item-id').val(orderItemId);
                reviewForm.trigger('reset');
                $('input[name="rating"]').prop('checked', false);
                $('#review-text').val('');
            });

            $('.edit-review-btn').on('click', function() {
                let reviewId = $(this).data('reviewId');
                let rating = $(this).data('rating');
                let reviewText = $(this).data('reviewText');
                let updateUrl = reviewUpdateUrlTemplate.replace(':id', reviewId);
                reviewForm.attr('action', updateUrl);
                if (!reviewForm.find('input[name="_method"]').length) {
                    reviewForm.prepend('<input type="hidden" name="_method" value="PUT">');
                }
                $(`#rating-${rating}`).prop('checked', true);
                $('#review-text').val(reviewText);
            });

            $('.order-item').on('submit', '.delete-review-form', function(e) {
                e.preventDefault();
                if (!confirm('Anda yakin ingin menghapus ulasan ini?')) return;

                let form = $(this);
                let reviewId = form.data('reviewId');
                let destroyUrl = reviewDestroyUrlTemplate.replace(':id', reviewId);

                $.ajax({
                    url: destroyUrl,
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        window.location.reload();
                    },
                    error: function(xhr) {
                        alert('Gagal menghapus ulasan. Silakan coba lagi.');
                    }
                });
            });
        });
    </script>
@endpush
