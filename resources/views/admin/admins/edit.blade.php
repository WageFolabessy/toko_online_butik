@extends('admin.layouts.app')

@section('title', 'Ubah Admin')

@section('content')
    <div class="container-fluid">
        <div class="mb-4">
            <h3 class="fw-bold">Manajemen Admin</h3>
            <p class="text-muted">Ubah data admin: {{ $user->name }}</p>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.admins.update', $user->id) }}" method="POST">
                    @method('PUT')
                    @include('admin.admins._form', ['user' => $user])
                </form>
            </div>
        </div>
    </div>
@endsection
