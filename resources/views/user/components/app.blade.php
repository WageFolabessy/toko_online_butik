<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Butik Disel - @yield('title', 'Fashion Terkini')</title>
    <meta name="description" content="@yield('description', 'Butik Disel - Toko fashion terpercaya dengan koleksi terlengkap dan berkualitas. Temukan gaya terbaikmu!')" />
    <meta name="keywords" content="butik, fashion, baju, dress, blouse, celana" />
    <meta name="author" content="Dedy Wahyudi" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}" />
    
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" as="style">
    
    {{-- CSS --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
    <link href="{{ asset('assets/admin/vendor/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/user/css/custom-user.css') }}" rel="stylesheet" />
    
    @yield('css')
</head>
<body>

    @include('user.components.navbar')

    <main class="main-content">
        @yield('content')
    </main>

    @include('user.components.footer')

    {{-- JS --}}
    <script src="{{ asset('assets/admin/vendor/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('assets/admin/vendor/bootstrap.bundle.min.js') }}"></script>
    <script type="module" src="{{ asset('assets/user/js/custom-user.js') }}"></script>

    {{-- Firebase --}}
    <script type="module" src="https://www.gstatic.com/firebasejs/11.6.1/firebase-app.js"></script>
    <script type="module" src="https://www.gstatic.com/firebasejs/11.6.1/firebase-messaging.js"></script>

    @stack('script')
</body>
</html>

