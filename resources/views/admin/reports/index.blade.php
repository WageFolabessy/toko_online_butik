@extends('admin.layouts.app')

@section('title', 'Laporan Penjualan')

{{-- CSS Tambahan untuk Date Picker --}}
@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold">Laporan Penjualan</h3>
                <p class="text-muted mb-0">Lihat rekapitulasi penjualan berdasarkan periode</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form action="{{ route('admin.reports.index') }}" method="GET">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-5">
                            <label for="start_date" class="form-label">Tanggal Mulai</label>
                            <input type="text" class="form-control date-picker" id="start_date" name="start_date"
                                value="{{ $startDate }}">
                        </div>
                        <div class="col-md-5">
                            <label for="end_date" class="form-label">Tanggal Selesai</label>
                            <input type="text" class="form-control date-picker" id="end_date" name="end_date"
                                value="{{ $endDate }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="fs-1 text-success me-3"><i class="bi bi-cash-stack"></i></div>
                        <div>
                            <h5 class="card-title text-muted">Total Pendapatan</h5>
                            <p class="card-text fs-4 fw-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="fs-1 text-primary me-3"><i class="bi bi-cart-check-fill"></i></div>
                        <div>
                            <h5 class="card-title text-muted">Total Pesanan Berhasil</h5>
                            <p class="card-text fs-4 fw-bold">{{ $totalOrders }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header">
                Detail Pesanan Periode {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d M Y') }} -
                {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d M Y') }}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="reports-table" class="table table-hover">
                        <thead>
                            <tr>
                                <th>No. Pesanan</th>
                                <th>Pelanggan</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->order_number }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ $order->created_at->translatedFormat('d M Y, H:i') }}</td>
                                    <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                    <td><span
                                            class="badge {{ $order->status_badge_class }}">{{ $order->status_text }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
    <script>
        $(document).ready(function() {
            flatpickr(".date-picker", {
                locale: "id",
                dateFormat: "Y-m-d",
            });

            $('#reports-table').DataTable({
                "language": {
                    "url": '{{ asset('assets/admin/vendor/id.json') }}',
                },
                "order": [
                    [2, "desc"]
                ],
                "searching": false, 
                "lengthChange": false,
                "info": false
            });
        });
    </script>
@endpush
