@extends('customer.layouts.app')

@section('title', 'Detail Pesanan ' . $order->order_number)

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold">Detail Pesanan</h3>
                <p class="text-muted">Nomor Pesanan: {{ $order->order_number }}</p>
            </div>
            <a href="{{ route('customer.profile.orders.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali ke Riwayat
            </a>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-3">Item yang Dipesan</h5>
                        @foreach ($order->items as $item)
                            <div class="row mb-3">
                                <div class="col-2">
                                    <img src="{{ $item->product->images->first() ? asset('storage/products/' . $item->product->images->first()->path) : 'https://via.placeholder.com/150' }}"
                                        class="img-fluid rounded">
                                </div>
                                <div class="col-7">
                                    <div>{{ $item->product->name }}</div>
                                    <div class="small text-muted">Varian: {{ $item->variant->name }}</div>
                                    <div class="small text-muted">{{ $item->qty }} x Rp
                                        {{ number_format($item->price, 0, ',', '.') }}</div>
                                </div>
                                <div class="col-3 text-end fw-bold">
                                    Rp {{ number_format($item->qty * $item->price, 0, ',', '.') }}
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
@endsection
