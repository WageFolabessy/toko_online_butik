@extends('admin.components.app')

@section('title', 'Tambah Kategori')

@section('content')
    @component('admin.components.page-header', ['title' => 'Tambah Kategori'])
        <li class="breadcrumb-item"><a href="{{ route('admin.kategori.index') }}">Kategori</a></li>
        <li class="breadcrumb-item active">Tambah</li>
    @endcomponent

    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold">Form Input Kategori</h5>
                    <small class="text-muted">Kolom dengan <span class="text-danger">*</span> wajib diisi.</small>
                </div>
                <form action="{{ route('admin.kategori.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Kategori <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-tags"></i></span>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}" required autofocus
                                    placeholder="Contoh: Baju Wanita">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="form-label">Tampilan Slug</label>
                            <div class="form-control bg-light" id="slug-preview" style="color: #6c757d;">-</div>
                            <div class="form-text">Slug akan dibuat otomatis dan digunakan untuk URL.</div>
                        </div>
                    </div>
                    <div class="card-footer bg-white text-end">
                        <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            const slugPreview = document.getElementById('slug-preview');

            const generateSlug = (text) => {
                if (!text) return '-';
                return text.toString().toLowerCase()
                    .replace(/\s+/g, '-')
                    .replace(/[^\w\-]+/g, '')
                    .replace(/\-\-+/g, '-')
                    .replace(/^-+/, '')
                    .replace(/-+$/, '');
            };

            nameInput.addEventListener('keyup', function() {
                slugPreview.textContent = generateSlug(this.value);
            });
        });
    </script>
@endpush
