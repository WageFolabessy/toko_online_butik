@extends('admin.components.app')

@section('title', 'Edit Banner')

@section('content')
    @component('admin.components.page-header', ['title' => 'Edit Banner'])
        <li class="breadcrumb-item"><a href="{{ route('admin.banner.index') }}">Banner</a></li>
        <li class="breadcrumb-item active">Edit</li>
    @endcomponent

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0 fw-bold">Form Edit Banner</h5>
                </div>
                <form action="{{ route('admin.banner.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Gambar Saat Ini</label>
                            <div>
                                <img id="image-preview" src="{{ asset('storage/' . $banner->image_path) }}" alt="Banner"
                                    class="img-thumbnail" style="max-height: 200px;">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Unggah Gambar Baru (Opsional)</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                                name="image" onchange="previewImage(event)">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_active"
                                    name="is_active" value="1"
                                    {{ old('is_active', $banner->is_active) == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Aktif</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white text-end">
                        <a href="{{ route('admin.banner.index') }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-primary">Update Banner</button>
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
