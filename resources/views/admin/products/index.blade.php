@extends('admin.components.app')

@section('title', 'Manajemen Produk')

@section('content')
    @component('admin.components.page-header', ['title' => 'Manajemen Produk'])
        <li class="breadcrumb-item active">Produk</li>
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold">Daftar Produk</h5>
                    <a href="{{ route('admin.produk.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i>
                        Tambah Produk
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover datatable" style="width:100%">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" style="width: 5%;">No</th>
                                    <th class="text-center" style="width: 10%;">Gambar</th>
                                    <th>Nama Produk</th>
                                    <th>Kategori</th>
                                    <th class="text-end">Harga</th>
                                    <th class="text-center" style="width: 10%;">Stok</th>
                                    <th class="text-center" style="width: 15%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr class="align-middle">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">
                                            <img src="{{ $product->images->first() ? asset('storage/' . $product->images->first()->path) : asset('assets/images/default-product.png') }}"
                                                alt="{{ $product->name }}" class="img-thumbnail" width="60">
                                        </td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->category->name ?? 'Tanpa Kategori' }}</td>
                                        <td class="text-end">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                        <td class="text-center">{{ $product->variants->sum('stock') }}</td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    Aksi
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('admin.produk.show', $product->id) }}"><i
                                                                class="bi bi-eye me-2"></i>Detail</a></li>
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('admin.produk.edit', $product->id) }}"><i
                                                                class="bi bi-pencil-square me-2"></i>Edit</a></li>
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                    <li>
                                                        <button type="button" class="dropdown-item text-danger"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal{{ $product->id }}">
                                                            <i class="bi bi-trash me-2"></i>Hapus
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
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

    @foreach ($products as $product)
        <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1"
            aria-labelledby="deleteModalLabel{{ $product->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel{{ $product->id }}">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus produk <strong>{{ $product->name }}</strong>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('admin.produk.destroy', $product->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@push('script')
    @include('admin.components.datatables-script')
@endpush
