@extends('customer.layouts.app')

@section('title', 'Masuk ke Akun Anda')

@section('content')
    <div class="container py-5" style="min-height: 70vh;">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h3 class="text-center fw-bold mb-4">Masuk</h3>
                        <form action="{{ route('customer.login.submit') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary">Masuk</button>
                            </div>
                            <a href="{{ route('customer.password.request') }}" class="small text-decoration-none">Lupa
                                Password?</a>
                            <p class="text-center text-muted small">Belum punya akun? <a
                                    href="{{ route('customer.register.form') }}">Daftar di sini</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
