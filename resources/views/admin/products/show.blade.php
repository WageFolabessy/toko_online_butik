@extends('admin.components.app')

@section('title', 'Detail Produk: ' . $product->name)

@section('content')
    @component('admin.components.page-header', ['title' => 'Detail Produk'])
        <li class="breadcrumb-item"><a href="{{ route('admin.produk.index') }}">Produk</a></li>
        <li class="breadcrumb-item active">Detail</li>
    @endcomponent

    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0 fw-bold">Galeri Gambar</h5>
                </div>
                <div class="card-body">
                    <div id="productImageCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner rounded">
                            @forelse ($product->images as $key => $image)
                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                    <img src="{{ asset('storage/' . $image->path) }}" class="d-block w-100"
                                        alt="Gambar produk">
                                </div>
                            @empty
                                <div class="carousel-item active">
                                    <img src="{{ asset('assets/images/default-product.png') }}" class="d-block w-100"
                                        alt="Gambar tidak tersedia">
                                </div>
                            @endforelse
                        </div>
                        @if ($product->images->count() > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#productImageCarousel"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span><span
                                    class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#productImageCarousel"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span><span
                                    class="visually-hidden">Next</span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0 fw-bold">Varian & Stok</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Varian</th>
                                <th class="text-center">Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($product->variants as $variant)
                                <tr>
                                    <td>{{ $variant->name }}</td>
                                    <td class="text-center">{{ $variant->stock }}</td>
                                </tr>
                            @endforeach
                            <tr class="table-light">
                                <td class="fw-bold">TOTAL STOK</td>
                                <td class="text-center fw-bold">{{ $product->variants->sum('stock') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0 fw-bold">Detail Informasi</h5>
                </div>
                <div class="card-body">
                    <h3>{{ $product->name }}</h3>
                    <hr>
                    <dl class="row">
                        <dt class="col-sm-4">Kategori</dt>
                        <dd class="col-sm-8"><a
                                href="{{ route('admin.kategori.show', $product->category->id) }}">{{ $product->category->name }}</a>
                        </dd>

                        <dt class="col-sm-4">Harga Normal</dt>
                        <dd class="col-sm-8">Rp {{ number_format($product->price, 0, ',', '.') }}</dd>
                        
                        @if ($product->discount_price > 0)
                            <dt class="col-sm-4">Harga Diskon</dt>
                            <dd class="col-sm-8"><span class="badge bg-success">Rp
                                    {{ number_format($product->discount_price, 0, ',', '.') }}</span></dd>
                        @endif

                        <dt class="col-sm-4">Berat</dt>
                        <dd class="col-sm-8">{{ $product->weight }} gram</dd>

                        <dt class="col-sm-4">Tanggal Dibuat</dt>
                        <dd class="col-sm-8">{{ $product->created_at->format('d M Y, H:i') }}</dd>
                    </dl>
                    <hr>
                    <h5 class="mt-4">Deskripsi Produk</h5>
                    <div>{!! nl2br(e($product->description)) !!}</div>
                </div>
                <div class="card-footer bg-white d-flex justify-content-between">
                    <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                    <a href="{{ route('admin.produk.edit', $product->id) }}" class="btn btn-warning">
                        <i class="bi bi-pencil-square me-2"></i>Edit Produk
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
