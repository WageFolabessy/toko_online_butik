@extends('admin.layouts.app')

@section('title', 'Detail Pelanggan')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">Detail Pelanggan</h3>
            <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar Pelanggan
            </a>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Informasi Pelanggan</h5>
                        <hr>
                        <p><strong>Nama:</strong><br>{{ $customer->name }}</p>
                        <p><strong>Email:</strong><br>{{ $customer->email }}</p>
                        <p class="mb-0"><strong>Tanggal
                                Bergabung:</strong><br>{{ $customer->created_at->translatedFormat('d F Y') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Riwayat Pesanan ({{ $customer->orders->count() }})</h5>
                        <hr>
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
                                    @forelse ($customer->orders as $order)
                                        <tr>
                                            <td>{{ $order->order_number }}</td>
                                            <td>{{ $order->created_at->translatedFormat('d M Y') }}</td>
                                            <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                            <td><span
                                                    class="badge {{ $order->status_badge_class }}">{{ $order->status_text }}</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                                    class="btn btn-info btn-sm text-white">Detail</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Pelanggan ini belum memiliki riwayat
                                                pesanan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
