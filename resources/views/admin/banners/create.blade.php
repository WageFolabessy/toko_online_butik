@extends('admin.components.app')

@section('title', 'Unggah Banner Baru')

@section('content')
    @component('admin.components.page-header', ['title' => 'Unggah Banner Baru'])
        <li class="breadcrumb-item"><a href="{{ route('admin.banner.index') }}">Banner</a></li>
        <li class="breadcrumb-item active">Unggah</li>
    @endcomponent

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold">Form Unggah Banner</h5>
                    <small class="text-muted">Kolom dengan <span class="text-danger">*</span> wajib diisi.</small>
                </div>
                <form action="{{ route('admin.banner.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="image" class="form-label">File Gambar Banner <span
                                    class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                                name="image" required onchange="previewImage(event)">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Format: JPEG, JPG, PNG, WEBP. Ukuran maks: 2MB.</small>
                        </div>
                        <div class="mb-3">
                            <img id="image-preview" src="#" alt="Preview Gambar" class="img-thumbnail"
                                style="display: none; max-height: 200px;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_active"
                                    name="is_active" value="1" {{ old('is_active', 1) == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Aktif</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white text-end">
                        <a href="{{ route('admin.banner.index') }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Banner</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            const imagePreview = document.getElementById('image-preview');
            reader.onload = function() {
                if (reader.readyState === 2) {
                    imagePreview.style.display = 'block';
                    imagePreview.src = reader.result;
                }
            }
            if (event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }
        }
    </script>
@endpush
