@extends('admin.layouts.app')

@section('title', 'Manajemen Pesanan')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold">Manajemen Pesanan</h3>
                <p class="text-muted mb-0">Daftar semua pesanan yang masuk</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="orders-table" class="table table-hover">
                        <thead>
                            <tr>
                                <th>No. Pesanan</th>
                                <th>Pelanggan</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Status Pembayaran</th>
                                <th>Status Pesanan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->order_number }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ $order->created_at->translatedFormat('d M Y') }}</td>
                                    <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                    <td>
                                        @if ($order->payment)
                                            <span
                                                class="badge {{ $order->payment->status_badge_class }}">{{ $order->payment->status_text }}</span>
                                        @else
                                            <span class="badge bg-secondary">Belum Ada</span>
                                        @endif
                                    </td>
                                    <td><span
                                            class="badge {{ $order->status_badge_class }}">{{ $order->status_text }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order->id) }}"
                                            class="btn btn-info btn-sm text-white">Detail</a>
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
    <script>
        $(document).ready(function() {
            $('#orders-table').DataTable({
                "language": {
                    "url": '{{ asset('assets/admin/vendor/id.json') }}',
                },
                "order": [
                    [2, "desc"]
                ]
            });
        });
    </script>
@endpush
