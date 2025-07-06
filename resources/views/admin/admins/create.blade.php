@extends('admin.layouts.app')

@section('title', 'Tambah Admin')

@section('content')
    <div class="container-fluid">
        <div class="mb-4">
            <h3 class="fw-bold">Manajemen Admin</h3>
            <p class="text-muted">Tambah akun admin baru</p>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.admins.store') }}" method="POST">
                    @include('admin.admins._form')
                </form>
            </div>
        </div>
    </div>
@endsection
