<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Butik Disel - @yield('title', 'Dashboard')</title>
    <meta name="description" content="Toko Butik Disel" />
    <meta name="author" content="Dedy Wahyudi" />
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
    <link href="{{ asset('assets/admin/vendor/fa.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/admin/vendor/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/admin/vendor/datatables.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/admin/css/custom-admin.css') }}" rel="stylesheet" />

    @yield('css')
</head>

<body>

    <div class="wrapper">
        @include('admin.components.sidebar')
        <div class="sidebar-overlay"></div>

        <div class="main">
            @include('admin.components.header')
            <main class="content px-3 py-4">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @yield('content')
            </main>

            @include('admin.components.footer')
        </div>
    </div>

    <script src="{{ asset('assets/admin/vendor/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('assets/admin/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/admin/vendor/datatables.min.js') }}"></script>

    @stack('script')

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sidebar = document.querySelector("#sidebar");
            const sidebarToggle = document.querySelector("#sidebar-toggle");
            const sidebarOverlay = document.querySelector(".sidebar-overlay");

            if (sidebarToggle) {
                // Event untuk membuka sidebar
                sidebarToggle.addEventListener("click", function(e) {
                    e.preventDefault();
                    sidebar.classList.add("active");
                });

                // Event untuk menutup sidebar saat klik overlay
                sidebarOverlay.addEventListener("click", function(e) {
                    e.preventDefault();
                    sidebar.classList.remove("active");
                });
            }
        });
    </script>
</body>

</html>
