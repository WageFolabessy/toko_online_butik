@extends('customer.layouts.app')

@section('title', 'Riwayat Pesanan')

@section('content')
    <div class="container py-5">
        <div class="row">
            @include('customer.components.sidebar')

            <div class="col-lg-9">
                <h4 class="fw-bold mb-4">Riwayat Pesanan Saya</h4>

                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No. Pesanan</th>
                                        <th>Tanggal</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($orders as $order)
                                        <tr>
                                            <td>{{ $order->order_number }}</td>
                                            <td>{{ $order->created_at->translatedFormat('d F Y') }}</td>
                                            <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                            <td><span class="badge {{ $order->status_badge_class }}">{{ $order->status_text }}</span></td>
                                            <td>
                                                <a href="{{ route('customer.profile.orders.show', $order) }}"
                                                    class="btn btn-sm btn-info text-white">Detail</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Anda belum memiliki riwayat pesanan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
