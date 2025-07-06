@csrf
<div class="mb-3">
    <label for="image" class="form-label">Gambar Banner <span class="text-danger">*</span></label>
    <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"
        accept="image/*">
    <small class="form-text text-muted">Rekomendasi ukuran: 1200x400 pixels.</small>
    @error('image')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    @if (isset($banner) && $banner->image)
        <div class="mt-3">
            <small>Gambar Saat Ini:</small><br>
            <img src="{{ asset('storage/banners/' . $banner->image) }}" alt="Banner" class="img-thumbnail"
                width="300">
        </div>
    @endif
</div>

<div class="mb-3">
    <label class="form-label">Status <span class="text-danger">*</span></label>
    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1"
            {{ old('is_active', $banner->is_active ?? true) ? 'checked' : '' }}>
        <label class="form-check-label" for="is_active">Aktif</label>
    </div>
    @error('is_active')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>


<div class="d-flex justify-content-end">
    <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary me-2">Batal</a>
    <button type="submit" class="btn btn-primary">Simpan</button>
</div>
