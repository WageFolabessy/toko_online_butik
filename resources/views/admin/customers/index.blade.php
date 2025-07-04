@extends('admin.components.app')

@section('title', 'Manajemen Pelanggan')

@section('content')
    @component('admin.components.page-header', ['title' => 'Manajemen Pelanggan'])
        <li class="breadcrumb-item active">Pelanggan</li>
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0 fw-bold">Daftar Semua Pelanggan</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover datatable" style="width:100%">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" style="width: 5%;">No</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Email</th>
                                    <th class="text-center">No. Telepon</th>
                                    <th class="text-center">Jumlah Pesanan</th>
                                    <th class="text-center">Tgl. Bergabung</th>
                                    <th class="text-center" style="width: 10%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $customer)
                                    <tr class="align-middle">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $customer->name }}</td>
                                        <td>{{ $customer->email }}</td>
                                        <td class="text-center">{{ $customer->phone_number ?? '-' }}</td>
                                        <td class="text-center">{{ $customer->orders_count }}</td>
                                        <td class="text-center">{{ $customer->created_at->format('d M Y') }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.pelanggan.show', $customer->id) }}"
                                                class="btn btn-sm btn-info" title="Lihat Detail Pelanggan">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    @include('admin.components.datatables-script')
@endpush
