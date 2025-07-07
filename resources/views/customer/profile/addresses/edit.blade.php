@extends('customer.layouts.app')
@section('title', 'Ubah Alamat')

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

        .form-card {
            border-radius: 0.5rem;
            background-color: #fff;
        }

        .form-header h4 {
            font-family: var(--font-heading);
            font-size: 1.75rem;
            color: var(--text-dark);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(139, 115, 85, 0.25);
        }

        .form-label {
            font-weight: 600;
            color: #555;
        }

        .alert-address-warning {
            background-color: #fff3cd;
            color: #664d03;
            border-color: #ffecb5;
            border-radius: 0.375rem;
        }

        .btn-outline-secondary {
            color: #6c757d;
            border-color: #6c757d;
        }

        .btn-outline-secondary:hover {
            background-color: #6c757d;
            color: white;
        }
    </style>
@endsection

@section('content')
    <div class="container py-5">
        <div class="row">
            @include('customer.components.sidebar')
            <div class="col-lg-9">
                <div class="form-header mb-4">
                    <h4 class="fw-bold">Ubah Alamat</h4>
                </div>
                <div class="card border-0 shadow-sm form-card">
                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('customer.profile.alamat.update', $address->id) }}" method="POST">
                            @method('PUT')
                            @include('customer.profile.addresses._form', ['address' => $address])
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
