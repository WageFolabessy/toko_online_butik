@extends('admin.components.app')

@section('title', 'Detail Kategori: ' . $category->name)

@section('content')
    @component('admin.components.page-header', ['title' => 'Detail Kategori'])
        <li class="breadcrumb-item"><a href="{{ route('admin.kategori.index') }}">Kategori</a></li>
        <li class="breadcrumb-item active">Detail</li>
    @endcomponent

    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold">Informasi Kategori</h5>
                    <i class="bi bi-info-circle-fill text-primary"></i>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-5">Nama Kategori</dt>
                        <dd class="col-sm-7">{{ $category->name }}</dd>

                        <dt class="col-sm-5">Slug</dt>
                        <dd class="col-sm-7">{{ $category->slug }}</dd>

                        <dt class="col-sm-5">Jumlah Produk</dt>
                        <dd class="col-sm-7">{{ $category->products->count() }} Produk</dd>

                        <dt class="col-sm-5">Tanggal Dibuat</dt>
                        <dd class="col-sm-7">{{ $category->created_at->format('d M Y, H:i') }}</dd>
                    </dl>
                </div>
                <div class="card-footer bg-white d-flex justify-content-between">
                    <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                    <a href="{{ route('admin.kategori.edit', $category->id) }}" class="btn btn-warning">
                        <i class="bi bi-pencil-square me-2"></i>Edit Kategori
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0 fw-bold">Produk dalam Kategori Ini</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover datatable" style="width:100%">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Nama Produk</th>
                                    <th class="text-end">Harga</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($category->products as $product)
                                    <tr class="align-middle">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td class="text-end">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.produk.show', $product->id) }}" class="btn btn-sm btn-info"
                                                title="Lihat Detail Produk">
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
