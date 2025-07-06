<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Butik Disel - @yield('title')</title>
    <meta name="author" content="Butik Disel" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}" />

    {{-- CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
    <link href="{{ asset('assets/admin/vendor/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/user/css/custom-user.css') }}" rel="stylesheet" />

    @yield('css')

    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
</head>

<body>

    @include('customer.layouts.navbar')

    <main class="main-content">
        @yield('content')
    </main>

    @include('customer.layouts.footer')

    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="appToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="bi bi-bell-fill me-2"></i>
                <strong class="me-auto" id="toast-title">Notifikasi</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="toast-body">
            </div>
        </div>
    </div>

    {{-- JS --}}
    <script src="{{ asset('assets/admin/vendor/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('assets/admin/vendor/bootstrap.bundle.min.js') }}"></script>
    {{-- <script type="module" src="{{ asset('assets/user/js/custom-user.js') }}"></script> --}}

    <script>
        function showAppToast(message, type = 'success') {
            const toastEl = document.getElementById('appToast');
            const toastTitleEl = document.getElementById('toast-title');
            const toastBodyEl = document.getElementById('toast-body');

            toastEl.classList.remove('bg-success-subtle', 'bg-danger-subtle');
            toastTitleEl.classList.remove('text-success', 'text-danger');

            if (type === 'success') {
                toastTitleEl.innerText = 'Berhasil!';
                toastTitleEl.classList.add('text-success');
                toastEl.classList.add('bg-success-subtle');
            } else {
                toastTitleEl.innerText = 'Terjadi Kesalahan';
                toastTitleEl.classList.add('text-danger');
                toastEl.classList.add('bg-danger-subtle');
            }

            toastBodyEl.innerText = message;
            const appToast = new bootstrap.Toast(toastEl);
            appToast.show();
        }
    </script>
    @stack('script')

    @auth
        <script type="module">
            import {
                initializeApp
            } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-app.js";
            import {
                getMessaging,
                getToken,
                onMessage
            } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-messaging.js";

            const firebaseConfig = {
                apiKey: "{{ config('services.firebase.api_key') }}",
                authDomain: "{{ config('services.firebase.auth_domain') }}",
                projectId: "{{ config('services.firebase.project_id') }}",
                storageBucket: "{{ config('services.firebase.storage_bucket') }}",
                messagingSenderId: "{{ config('services.firebase.messaging_sender_id') }}",
                appId: "{{ config('services.firebase.app_id') }}"
            };

            const app = initializeApp(firebaseConfig);
            const messaging = getMessaging(app);

            function requestPermissionAndGetToken() {
                console.log('Requesting permission...');
                Notification.requestPermission().then((permission) => {
                    if (permission === 'granted') {
                        console.log('Notification permission granted.');

                        // Dapatan token
                        getToken(messaging, {
                            vapidKey: '{{ config('services.firebase.vapid_key') }}'
                        }).then((currentToken) => {
                            if (currentToken) {
                                console.log('FCM Token:', currentToken);
                                sendTokenToServer(currentToken);
                            } else {
                                console.log('No registration token available.');
                            }
                        }).catch((err) => {
                            console.log('An error occurred while retrieving token. ', err);
                        });
                    } else {
                        console.log('Unable to get permission to notify.');
                    }
                });
            }

            function sendTokenToServer(token) {
                $.ajax({
                    url: "{{ route('customer.fcm.token.store') }}", 
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        token: token
                    },
                    success: function(response) {
                        console.log('Token stored successfully.');
                    },
                    error: function(err) {
                        console.error('Error storing token.', err);
                    }
                });
            }

            requestPermissionAndGetToken();

            onMessage(messaging, (payload) => {
                console.log('Message received. ', payload);
                showAppToast(payload.notification.body, 'info');
            });
        </script>
    @endauth
</body>

</html>
