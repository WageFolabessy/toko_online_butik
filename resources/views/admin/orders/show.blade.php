@extends('admin.layouts.app')

@section('title', 'Detail Pesanan ' . $order->order_number)

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">Detail Pesanan #{{ $order->order_number }}</h3>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar Pesanan
            </a>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Item yang Dipesan</h5>
                        <hr>
                        @foreach ($order->items as $item)
                            <div class="row mb-3">
                                <div class="col-2 col-md-1">
                                    <img src="{{ $item->product->images->first() ? asset('storage/products/' . $item->product->images->first()->path) : 'https://via.placeholder.com/150' }}"
                                        class="img-fluid rounded">
                                </div>
                                <div class="col-7 col-md-8">
                                    <div>{{ $item->product->name }}</div>
                                    <div class="small text-muted">Varian: {{ $item->variant->name }}</div>
                                    <div class="small text-muted">{{ $item->qty }} x Rp
                                        {{ number_format($item->price, 0, ',', '.') }}</div>
                                </div>
                                <div class="col-3 col-md-3 text-end fw-bold">
                                    Rp {{ number_format($item->qty * $item->price, 0, ',', '.') }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Detail Pengiriman</h5>
                        <hr>
                        @if ($order->delivery_method == 'delivery' && $order->address)
                            <p><strong>Penerima:</strong> {{ $order->address->recipient_name }}
                                ({{ $order->address->phone_number }})</p>
                            <p><strong>Alamat:</strong> {{ $order->address->full_address }},
                                {{ $order->address->postal_code }}</p>
                            @if ($order->shipment)
                                <p><strong>Kurir:</strong> {{ $order->shipment->courier }}
                                    ({{ $order->shipment->service }})</p>
                                <p><strong>No. Resi:</strong> <span
                                        class="fw-bold text-primary">{{ $order->shipment->tracking_number ?? 'Belum ada' }}</span>
                                </p>
                            @endif
                        @else
                            <p><strong>Metode:</strong> Diambil di toko.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Aksi Admin</h5>
                        <hr>
                        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="status" class="form-label">Ubah Status Pesanan</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pesanan
                                        Diproses</option>
                                    <option value="processed" {{ $order->status == 'processed' ? 'selected' : '' }}>Siap
                                        Dikirim</option>
                                    <option value="ready_for_pickup"
                                        {{ $order->status == 'ready_for_pickup' ? 'selected' : '' }}>Siap Diambil</option>
                                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Telah
                                        Dikirim</option>
                                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai
                                    </option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                        Dibatalkan</option>
                                </select>
                            </div>
                            <div class="mb-3" id="tracking-number-field" style="display: none;">
                                <label for="tracking_number" class="form-label">Nomor Resi</label>
                                <input type="text" name="tracking_number" class="form-control"
                                    value="{{ $order->shipment->tracking_number ?? '' }}">
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Update Status</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Rincian Pembayaran</h5>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span>Status Pesanan</span>
                            <span class="badge {{ $order->status_badge_class }}">{{ $order->status_text }}</span>
                        </div>
                        @if ($order->payment)
                            <div class="d-flex justify-content-between mt-2">
                                <span>Status Pembayaran</span>
                                <span
                                    class="badge {{ $order->payment->status_badge_class }}">{{ $order->payment->status_text }}</span>
                            </div>
                        @endif
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            function toggleTrackingField() {
                if ($('#status').val() === 'shipped') {
                    $('#tracking-number-field').slideDown();
                } else {
                    $('#tracking-number-field').slideUp();
                }
            }
            toggleTrackingField();
            $('#status').on('change', toggleTrackingField);
        });
    </script>
@endpush
