@csrf
<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title">Informasi Produk</h5>
                <hr>
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name', $product->name ?? '') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                        rows="5">{{ old('description', $product->description ?? '') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title">Varian & Stok</h5>
                <hr>
                <div id="variants-container">
                    @if (isset($product) && $product->variants->count() > 0)
                        @foreach ($product->variants as $index => $variant)
                            <div class="row align-items-center mb-2 variant-item">
                                <div class="col-md-5">
                                    <input type="text" name="variants[{{ $index }}][name]"
                                        class="form-control" placeholder="Nama Varian" value="{{ $variant->name }}"
                                        required>
                                </div>
                                <div class="col-md-5">
                                    <input type="number" name="variants[{{ $index }}][stock]"
                                        class="form-control" placeholder="Stok" value="{{ $variant->stock }}" required
                                        min="0">
                                </div>
                                <div class="col-md-2">
                                    <button type="button"
                                        class="btn btn-danger btn-sm remove-variant-btn">Hapus</button>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <button type="button" id="add-variant-btn" class="btn btn-sm btn-outline-primary mt-2">Tambah
                    Varian</button>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title">Atribut Produk</h5>
                <hr>
                <div class="mb-3">
                    <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                    <select class="form-select @error('category_id') is-invalid @enderror" id="category_id"
                        name="category_id" required>
                        <option value="" disabled selected>Pilih Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Harga <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('price') is-invalid @enderror" id="price"
                        name="price" value="{{ old('price', $product->price ?? '') }}" required>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="discount_price" class="form-label">Harga Diskon (Opsional)</label>
                    <input type="number" class="form-control @error('discount_price') is-invalid @enderror"
                        id="discount_price" name="discount_price"
                        value="{{ old('discount_price', $product->discount_price ?? '0') }}">
                    <small class="form-text text-muted">Isi 0 jika tidak ada diskon.</small>
                    @error('discount_price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="weight" class="form-label">Berat (gram) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('weight') is-invalid @enderror" id="weight"
                        name="weight" value="{{ old('weight', $product->weight ?? '') }}" required>
                    @error('weight')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Galeri Gambar</h5>
                <hr>
                <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                <small class="form-text text-muted">Unggah gambar baru untuk ditambahkan. Gambar pertama akan menjadi
                    gambar utama.</small>

                @if (isset($product) && $product->images->count() > 0)
                    <div class="mt-3">
                        <p><strong>Gambar Saat Ini:</strong></p>
                        <div class="row">
                            @foreach ($product->images as $image)
                                <div class="col-4 mb-2">
                                    <img src="{{ asset('storage/products/' . $image->path) }}"
                                        class="img-fluid img-thumbnail">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="mt-4 d-flex justify-content-end">
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary me-2">Batal</a>
    <button type="submit" class="btn btn-primary">Simpan Produk</button>
</div>
