@extends('admin.layouts.app')

@section('title', 'Ubah Banner')

@section('content')
    <div class="container-fluid">
        <div class="mb-4">
            <h3 class="fw-bold">Manajemen Banner</h3>
            <p class="text-muted">Ubah data banner</p>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @include('admin.banners._form', ['banner' => $banner])
                </form>
            </div>
        </div>
    </div>
@endsection
