@extends('admin.components.app')

@section('title', 'Detail Pelanggan: ' . $customer->name)

@section('content')
    @component('admin.components.page-header', ['title' => 'Detail Pelanggan'])
        <li class="breadcrumb-item"><a href="{{ route('admin.pelanggan.index') }}">Pelanggan</a></li>
        <li class="breadcrumb-item active">Detail</li>
    @endcomponent

    <div class="row justify-content-center">
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold">Kontak Pelanggan</h5>
                    <i class="bi bi-person-badge-fill text-primary"></i>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <i class="bi bi-person-circle display-4 text-secondary"></i>
                        <h5 class="mt-2 mb-0">{{ $customer->name }}</h5>
                    </div>
                    <dl class="row">
                        <dt class="col-sm-4">Email</dt>
                        <dd class="col-sm-8">{{ $customer->email }}</dd>

                        <dt class="col-sm-4">Telepon</dt>
                        <dd class="col-sm-8">{{ $customer->phone_number ?? '-' }}</dd>

                        <dt class="col-sm-4">Bergabung</dt>
                        <dd class="col-sm-8">{{ $customer->created_at->format('d M Y') }}</dd>
                    </dl>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0 fw-bold">Daftar Alamat Tersimpan</h5>
                </div>
                <div class="card-body">
                    @forelse ($customer->addresses as $address)
                        <div class="pb-2">
                            <strong>{{ $address->label }}</strong>
                            <p class="mb-0 small">{{ $address->recipient_name }} ({{ $address->phone_number }})</p>
                            <p class="mb-0 text-muted small">{{ $address->full_address }}, {{ $address->postal_code }}</p>
                        </div>
                        @if (!$loop->last)
                            <hr class="my-2">
                        @endif
                    @empty
                        <p class="text-muted mb-0">Pelanggan belum menyimpan alamat.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0 fw-bold">Riwayat Pesanan</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover datatable" style="width:100%">
                            <thead class="table-light">
                                <tr>
                                    <th>No. Invoice</th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-end">Total Bayar</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customer->orders as $order)
                                    <tr class="align-middle">
                                        <td><strong>{{ $order->invoice_number }}</strong></td>
                                        <td class="text-center">{{ $order->created_at->format('d M Y') }}</td>
                                        <td class="text-end">Rp {{ number_format($order->total_bill, 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            @php
                                                $statusClass =
                                                    [
                                                        'Menunggu Pembayaran' => 'bg-warning text-dark',
                                                        'Diproses' => 'bg-info text-dark',
                                                        'Dikirim' => 'bg-primary',
                                                        'Selesai' => 'bg-success',
                                                        'Dibatalkan' => 'bg-danger',
                                                    ][$order->status] ?? 'bg-secondary';
                                            @endphp
                                            <span class="badge {{ $statusClass }}">{{ $order->status }}</span>
                                        </td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-sm btn-info" title="Lihat Detail Pesanan">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <a href="{{ route('admin.pelanggan.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar Pelanggan
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    @include('admin.components.datatables-script')
@endpush
