@extends('admin.layouts.app')

@section('title', 'Tambah Produk')

@section('content')
    <div class="container-fluid">
        <div class="mb-4">
            <h3 class="fw-bold">Manajemen Produk</h3>
            <p class="text-muted">Tambah produk baru ke dalam toko</p>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @include('admin.products._form')
        </form>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            let variantIndex = 0;

            $('#add-variant-btn').click(function() {
                let variantForm = `
                <div class="row align-items-center mb-2 variant-item">
                    <div class="col-md-6">
                        <input type="text" name="variants[${variantIndex}][name]" class="form-control" placeholder="Nama Varian (e.g. Merah, XL)" required>
                    </div>
                    <div class="col-md-4">
                        <input type="number" name="variants[${variantIndex}][stock]" class="form-control" placeholder="Stok" required min="0">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-sm remove-variant-btn">Hapus</button>
                    </div>
                </div>
            `;
                $('#variants-container').append(variantForm);
                variantIndex++;
            });

            $(document).on('click', '.remove-variant-btn', function() {
                $(this).closest('.variant-item').remove();
            });
        });
    </script>
@endpush
