<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Butik Disel</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}" />

    {{-- Vendors --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
    <link href="{{ asset('assets/admin/vendor/bootstrap.min.css') }}" rel="stylesheet" />

    {{-- Custom Style --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7f6;
            background-image: linear-gradient(to top right, #f4f7f6, #dff1eb);
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .card {
            width: 100%;
            max-width: 420px;
            border: 0;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.1);
            border-radius: 0.75rem;
        }

        .login-logo {
            max-height: 60px;
            margin-bottom: 1.5rem;
        }

        .form-control {
            height: 48px;
            padding: 0.5rem 1rem;
        }

        .input-group-text {
            background-color: #e9ecef;
            border: 1px solid #ced4da;
        }

        .btn-toggle-password {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="card">
            <div class="card-body p-4 p-sm-5">
                <div class="text-center">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo Butik Disel" class="login-logo">
                    <h4 class="card-title mb-2 fw-bold">Admin Login</h4>
                    <p class="text-muted">Selamat datang kembali, silakan masuk.</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger py-2 small">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login') }}" class="mt-4">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email') }}" required autofocus placeholder="nama@email.com">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password" required
                                placeholder="Masukkan password">
                            <span class="input-group-text btn-toggle-password" id="togglePassword">
                                <i class="bi bi-eye-slash"></i>
                            </span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center align-items-center mb-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Ingat saya</label>
                        </div>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary fw-bold">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const icon = togglePassword.querySelector('i');

            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                icon.classList.toggle('bi-eye');
                icon.classList.toggle('bi-eye-slash');
            });
        });
    </script>
</body>

</html>
