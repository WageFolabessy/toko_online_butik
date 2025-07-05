<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lupa Password - Butik Disel</title>
    <meta name="description" content="Toko Butik Disel" />
    <meta name="author" content="Dedy Wahyudi" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}" />

    {{-- Vendors and Custom CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
    <link href="{{ asset('assets/admin/vendor/bootstrap.min.css') }}" rel="stylesheet" />
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-sm" style="width: 100%; max-width: 450px;">
            <div class="card-body p-5">
                <h4 class="card-title text-center mb-3">Lupa Password</h4>
                <p class="text-muted text-center mb-4">Masukkan email Anda dan kami akan mengirimkan link untuk mereset
                    password Anda.</p>
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Alamat Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary">Kirim Link Reset Password</button>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('login') }}">Kembali ke Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
