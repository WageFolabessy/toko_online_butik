@extends('admin.layouts.app')

@section('title', 'Tambah Banner')

@section('content')
    <div class="container-fluid">
        <div class="mb-4">
            <h3 class="fw-bold">Manajemen Banner</h3>
            <p class="text-muted">Tambah banner promosi baru</p>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
                    @include('admin.banners._form')
                </form>
            </div>
        </div>
    </div>
@endsection
