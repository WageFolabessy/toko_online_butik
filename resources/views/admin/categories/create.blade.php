@extends('admin.layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
    <div class="container-fluid">
        <div class="mb-4">
            <h3 class="fw-bold">Manajemen Kategori</h3>
            <p class="text-muted">Tambah kategori baru</p>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                    @include('admin.categories._form')
                </form>
            </div>
        </div>
    </div>
@endsection
