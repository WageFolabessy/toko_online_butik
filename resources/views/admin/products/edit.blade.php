@extends('admin.components.app')

@section('title', 'Edit Produk')

@section('content')
    @component('admin.components.page-header', ['title' => 'Edit Produk'])
        <li class="breadcrumb-item"><a href="{{ route('admin.produk.index') }}">Produk</a></li>
        <li class="breadcrumb-item active">Edit</li>
    @endcomponent

    <form action="{{ route('admin.produk.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0 fw-bold">Informasi Produk</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                id="name" value="{{ old('name', $product->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label class="form-label">Tampilan Slug</label>
                            <div class="form-control bg-light" id="slug-preview" style="color: #6c757d;">
                                {{ $product->slug }}</div>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description"
                                rows="5" required>{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm mt-4">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0 fw-bold">Varian & Stok <span class="text-danger">*</span></h5>
                    </div>
                    <div class="card-body">
                        <div id="variants-container">
                            @foreach ($product->variants as $key => $variant)
                                <div class="row variant-row mb-3 gx-2">
                                    <div class="col-md-5">
                                        <label class="form-label d-md-none">Nama Varian</label>
                                        <input type="text" name="variants[name][]" class="form-control" required
                                            placeholder="Contoh: Ukuran S"
                                            value="{{ old('variants.name.' . $key, $variant->name) }}">
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label d-md-none">Stok</label>
                                        <input type="number" name="variants[stock][]" class="form-control" required
                                            min="0" placeholder="Jumlah Stok"
                                            value="{{ old('variants.stock.' . $key, $variant->stock) }}">
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-danger w-100 remove-variant"><i
                                                class="bi bi-trash"></i></button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" id="add-variant" class="btn btn-outline-primary mt-2"><i
                                class="bi bi-plus"></i> Tambah Varian</button>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0 fw-bold">Aksi</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">Kolom dengan <span class="text-danger">*</span> wajib diisi.</p>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Update Produk</button>
                            <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm mt-4">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0 fw-bold">Atribut</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror"
                                required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Harga <span class="text-danger">*</span></label>
                            <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                                value="{{ old('price', $product->price) }}" required min="0">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="discount_price" class="form-label">Harga Diskon (Opsional)</label>
                            <input type="number" name="discount_price"
                                class="form-control @error('discount_price') is-invalid @enderror"
                                value="{{ old('discount_price', $product->discount_price) }}" min="0">
                            @error('discount_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="weight" class="form-label">Berat (gram) <span
                                    class="text-danger">*</span></label>
                            <input type="number" name="weight"
                                class="form-control @error('weight') is-invalid @enderror"
                                value="{{ old('weight', $product->weight) }}" required min="1">
                            @error('weight')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm mt-4">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0 fw-bold">Gambar Produk</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Gambar Saat Ini:</strong></p>
                        <div class="mb-3">
                            @forelse ($product->images as $image)
                                <img src="{{ asset('storage/' . $image->path) }}" alt="Gambar Produk"
                                    class="img-thumbnail me-2 mb-2" width="80">
                            @empty
                                <small class="text-muted">Tidak ada gambar.</small>
                            @endforelse
                        </div>
                        <hr>
                        <label for="images" class="form-label">Unggah Gambar Baru (Opsional)</label>
                        <input type="file" name="images[]" class="form-control" multiple>
                        <small class="form-text text-muted">Unggah gambar baru untuk mengganti yang lama.</small>
                        @error('images')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                        @error('images.*')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            const slugPreview = document.getElementById('slug-preview');
            const generateSlug = (text) => text.toString().toLowerCase().replace(/\s+/g, '-').replace(/[^\w\-]+/g,
                '').replace(/\-\-+/g, '-').replace(/^-+/, '').replace(/-+$/, '');
            nameInput.addEventListener('keyup', function() {
                slugPreview.textContent = generateSlug(this.value) || '-';
            });

            const variantsContainer = document.getElementById('variants-container');
            const addVariantButton = document.getElementById('add-variant');
            addVariantButton.addEventListener('click', () => {
                const newRow = document.createElement('div');
                newRow.className = 'row variant-row mb-3 gx-2';
                newRow.innerHTML = `
                <div class="col-md-5">
                    <input type="text" name="variants[name][]" class="form-control" required placeholder="Contoh: Ukuran S">
                </div>
                <div class="col-md-5">
                    <input type="number" name="variants[stock][]" class="form-control" required min="0" placeholder="Jumlah Stok">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger w-100 remove-variant"><i class="bi bi-trash"></i></button>
                </div>
            `;
                variantsContainer.appendChild(newRow);
            });
            variantsContainer.addEventListener('click', function(e) {
                if (e.target.closest('.remove-variant')) {
                    e.target.closest('.variant-row').remove();
                }
            });
        });
    </script>
@endpush
