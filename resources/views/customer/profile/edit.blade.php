@extends('customer.layouts.app')

@section('title', 'Profil Saya')

@section('css')
    <style>
        .profile-sidebar .list-group-item {
            border: none;
            border-radius: 0.375rem !important;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--text-dark);
            transition: all 0.2s ease-in-out;
            padding: 0.8rem 1.2rem;
        }

        .profile-sidebar .list-group-item:hover {
            background-color: var(--secondary-color);
            color: var(--primary-color);
            transform: translateX(5px);
        }

        .profile-sidebar .list-group-item.active {
            background-color: var(--primary-color);
            color: var(--accent-color);
            box-shadow: 0 4px 10px rgba(139, 115, 85, 0.3);
        }

        .profile-sidebar .list-group-item.logout-link:hover {
            background-color: #f8d7da;
            color: #721c24;
            transform: translateX(5px);
        }

        .profile-card {
            border-radius: 0.5rem;
            background-color: #fff;
        }

        .profile-card-header h4 {
            font-family: var(--font-heading);
            font-size: 1.75rem;
            color: var(--text-dark);
        }

        .profile-card-header p {
            color: #888;
        }

        .form-control {
            border-radius: 0.375rem;
            border: 1px solid #ddd;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(139, 115, 85, 0.25);
        }

        .form-label {
            font-weight: 600;
            color: #555;
        }

        .form-section-divider {
            border-top: 1px dashed #eee;
        }

        .alert-profile-success {
            background-color: #e9f5e9;
            color: #1f7c3c;
            border: 1px solid #c8e6c9;
            border-radius: 0.375rem;
        }
    </style>
@endsection

@section('content')
    <div class="container py-5">
        <div class="row">
            @include('customer.components.sidebar')
            <div class="col-lg-9">
                <div class="card border-0 shadow-sm profile-card">
                    <div class="card-body p-4 p-md-5">

                        <div class="profile-card-header mb-4">
                            <h4 class="fw-bold">Update Profil</h4>
                            <p class="text-muted mb-0">Kelola informasi data diri dan password Anda.</p>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-profile-success">{{ session('success') }}</div>
                        @endif

                        <form action="{{ route('customer.profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Nama Lengkap <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email <span
                                            class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <hr class="my-4 form-section-divider">

                            <div class="mb-4">
                                <h5 class="fw-bold">Ubah Password</h5>
                                <p class="text-muted small mb-0">Kosongkan field di bawah ini jika Anda tidak ingin mengubah
                                    password.</p>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Password Baru</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation">
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-save-fill me-2"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
