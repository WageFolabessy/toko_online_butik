@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <div class="mb-3">
            <h3 class="fw-bold">Dashboard</h3>
            <p class="text-muted">Ringkasan informasi toko Anda</p>
        </div>

        <div class="row">
            <div class="col-12 col-md-6 col-xl-3 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="fs-1 text-primary me-3">
                            <i class="bi bi-receipt-cutoff"></i>
                        </div>
                        <div>
                            <h5 class="card-title text-muted">Pesanan Baru</h5>
                            <p class="card-text fs-4 fw-bold">12</p>
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
                            <p class="card-text fs-4 fw-bold">Rp 1.250.000</p>
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
                            <p class="card-text fs-4 fw-bold">5</p>
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
                            <p class="card-text fs-4 fw-bold">78</p>
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
                                <th scope="col">ID Pesanan</th>
                                <th scope="col">Pelanggan</th>
                                <th scope="col">Total</th>
                                <th scope="col">Status</th>
                                <th scope="col">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#ORD-123</td>
                                <td>Ahmad</td>
                                <td>Rp 350.000</td>
                                <td><span class="badge bg-success">Selesai</span></td>
                                <td>04 Juli 2025</td>
                            </tr>
                            <tr>
                                <td>#ORD-122</td>
                                <td>Budi</td>
                                <td>Rp 150.000</td>
                                <td><span class="badge bg-warning text-dark">Pending</span></td>
                                <td>04 Juli 2025</td>
                            </tr>
                            <tr>
                                <td>#ORD-121</td>
                                <td>Citra</td>
                                <td>Rp 575.000</td>
                                <td><span class="badge bg-primary">Diproses</span></td>
                                <td>03 Juli 2025</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
