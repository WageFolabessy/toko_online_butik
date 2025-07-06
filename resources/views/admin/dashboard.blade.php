@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <div class="mb-3">
            <h3 class="fw-bold">Dashboard</h3>
            <p class="text-muted">Ringkasan informasi toko Anda hari ini</p>
        </div>

        <div class="row">
            <div class="col-12 col-md-6 col-xl-3 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="fs-1 text-primary me-3">
                            <i class="bi bi-receipt-cutoff"></i>
                        </div>
                        <div>
                            <h5 class="card-title text-muted">Pesanan Hari Ini</h5>
                            <p class="card-text fs-4 fw-bold">{{ $newOrdersCount }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-3 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="fs-1 text-success me-3">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                        <div>
                            <h5 class="card-title text-muted">Pendapatan Hari Ini</h5>
                            <p class="card-text fs-4 fw-bold">Rp {{ number_format($todaysRevenue, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-3 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="fs-1 text-warning me-3">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div>
                            <h5 class="card-title text-muted">Pelanggan Baru</h5>
                            <p class="card-text fs-4 fw-bold">{{ $newCustomersCount }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-3 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="fs-1 text-danger me-3">
                            <i class="bi bi-box-seam-fill"></i>
                        </div>
                        <div>
                            <h5 class="card-title text-muted">Total Produk</h5>
                            <p class="card-text fs-4 fw-bold">{{ $totalProducts }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header">
                Pesanan Terbaru
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No. Pesanan</th>
                                <th>Pelanggan</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentOrders as $order)
                                <tr>
                                    <td>{{ $order->order_number }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                    <td>
                                        <span
                                            class="badge {{ $order->status_badge_class }}">{{ $order->status_text }}</span>
                                    </td>
                                    <td>{{ $order->created_at->translatedFormat('d M Y, H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order->id) }}"
                                            class="btn btn-sm btn-info text-white">Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada pesanan hari ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
