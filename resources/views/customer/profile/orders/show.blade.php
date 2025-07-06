@extends('customer.layouts.app')

@section('title', 'Detail Pesanan ' . $order->order_number)

@section('css')
    <style>
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
        }

        .rating-stars input[type="radio"]:checked~label,
        .rating-stars label:hover,
        .rating-stars label:hover~label {
            color: #ffc107;
        }
    </style>
@endsection

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold">Detail Pesanan</h3>
                <p class="text-muted">Nomor Pesanan: {{ $order->order_number }}</p>
            </div>
            <div class="d-flex gap-2">
                @if(in_array($order->status, ['shipped', 'ready_for_pickup']))
                    <form action="{{ route('customer.profile.orders.confirm', $order) }}" method="POST"
                        onsubmit="return confirm('Apakah Anda yakin sudah menerima pesanan ini?');">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle-fill"></i> Pesanan Diterima
                        </button>
                    </form>
                @endif

                <a href="{{ route('customer.profile.orders.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali ke Riwayat
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
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-3">Item yang Dipesan</h5>
                        @foreach ($order->items as $item)
                            <div class="row py-3 border-bottom">
                                <div class="col-2 col-md-1">
                                    <img src="{{ $item->product->images->first() ? asset('storage/products/' . $item->product->images->first()->path) : 'https://via.placeholder.com/150' }}"
                                        class="img-fluid rounded">
                                </div>
                                <div class="col-10 col-md-11">
                                    <div>{{ $item->product->name }}</div>
                                    <div class="small text-muted">Varian: {{ $item->variant->name }}</div>
                                    <div class="small text-muted">{{ $item->qty }} x Rp
                                        {{ number_format($item->price, 0, ',', '.') }}</div>

                                    @if ($order->status === 'completed')
                                        @if ($item->review)
                                            <div class="mt-2 text-warning small">
                                                @for ($i = 0; $i < 5; $i++)
                                                    <i
                                                        class="bi {{ $i < $item->review->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                                @endfor
                                            </div>
                                            <p class="small fst-italic mt-1">"{{ $item->review->review }}"</p>
                                            <div>
                                                <button class="btn btn-sm btn-outline-secondary edit-review-btn"
                                                    data-bs-toggle="modal" data-bs-target="#reviewModal"
                                                    data-review-id="{{ $item->review->id }}"
                                                    data-rating="{{ $item->review->rating }}"
                                                    data-review-text="{{ $item->review->review }}">Ubah</button>
                                                <form method="POST" class="d-inline delete-review-form"
                                                    data-review-id="{{ $item->review->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-outline-danger">Hapus</button>
                                                </form>
                                            </div>
                                        @else
                                            <button class="btn btn-sm btn-primary mt-2 write-review-btn"
                                                data-bs-toggle="modal" data-bs-target="#reviewModal"
                                                data-product-id="{{ $item->product_id }}"
                                                data-order-item-id="{{ $item->id }}">
                                                Tulis Ulasan
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-3">Detail Pengiriman</h5>
                        <strong>Metode:</strong> {{ Str::title($order->delivery_method) }} <br>
                        @if ($order->delivery_method == 'delivery' && $order->address)
                            <strong>Penerima:</strong> {{ $order->address->recipient_name }} <br>
                            <strong>Telepon:</strong> {{ $order->address->phone_number }} <br>
                            <strong>Alamat:</strong> {{ $order->address->full_address }},
                            {{ $order->address->postal_code }} <br>
                            @if ($order->shipment)
                                <strong>Kurir:</strong> {{ $order->shipment->courier }} ({{ $order->shipment->service }})
                                <br>
                                <strong>No. Resi:</strong> {{ $order->shipment->tracking_number ?? 'Belum tersedia' }}
                            @endif
                        @else
                            <strong>Lokasi:</strong> Diambil di toko.
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-3">Rincian Pembayaran</h5>
                        <div class="d-flex justify-content-between">
                            <span>Status Pesanan</span>
                            <span class="badge {{ $order->status_badge_class }}">{{ $order->status_text }}</span>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <span>Status Pembayaran</span>
                            @if ($order->payment)
                                <span
                                    class="badge {{ $order->payment->status_badge_class }}">{{ $order->payment->status_text }}</span>
                            @else
                                <span class="badge bg-secondary">Belum Ada</span>
                            @endif
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($order->total_amount - $order->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Ongkos Kirim</span>
                            <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold fs-5">
                            <span>Total</span>
                            <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>

                        @if ($order->payment)
                            <hr>
                            <div class="text-center text-muted small">
                                Dibayar via {{ Str::title(str_replace('_', ' ', $order->payment->payment_type)) }}
                            </div>
                        @endif

                        @if ($order->status == 'awaiting_payment')
                            <div class="d-grid mt-3">
                                <button class="btn btn-primary">Bayar Sekarang</button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewModalLabel">Tulis Ulasan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="reviewForm" action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="product_id" id="review-product-id">
                        <input type="hidden" name="order_item_id" id="review-order-item-id">

                        <div class="mb-3">
                            <label class="form-label">Rating Anda</label>
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
                        <div class="mb-3">
                            <label for="review-text" class="form-label">Ulasan Anda (Opsional)</label>
                            <textarea class="form-control" name="review" id="review-text" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
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

            $('.delete-review-form').on('submit', function() {
                let reviewId = $(this).data('reviewId');
                let destroyUrl = reviewDestroyUrlTemplate.replace(':id', reviewId);
                $(this).attr('action', destroyUrl);
                return confirm('Anda yakin ingin menghapus ulasan ini?');
            });
        });
    </script>
@endpush
