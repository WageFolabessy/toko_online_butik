@extends('admin.layouts.app')

@section('title', 'Ubah Kategori')

@section('content')
    <div class="container-fluid">
        <div class="mb-4">
            <h3 class="fw-bold">Manajemen Kategori</h3>
            <p class="text-muted">Ubah kategori: {{ $category->name }}</p>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @method('PUT')
                    @include('admin.categories._form', ['category' => $category])
                </form>
            </div>
        </div>
    </div>
@endsection
