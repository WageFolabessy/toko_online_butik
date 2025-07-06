@csrf
<div class="mb-3">
    <label for="name" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
        placeholder="Contoh: Gaun Pesta" value="{{ old('name', $category->name ?? '') }}" required>
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="image" class="form-label">Gambar Kategori <span class="text-danger">*</span></label>
    <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"
        accept="image/*">
    @error('image')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    @if (isset($category) && $category->image)
        <div class="mt-3">
            <small>Gambar Saat Ini:</small><br>
            <img src="{{ asset('storage/categories/' . $category->image) }}" alt="{{ $category->name }}"
                class="img-thumbnail" width="150">
        </div>
    @endif
</div>

<div class="d-flex justify-content-end">
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary me-2">Batal</a>
    <button type="submit" class="btn btn-primary">Simpan</button>
</div>
