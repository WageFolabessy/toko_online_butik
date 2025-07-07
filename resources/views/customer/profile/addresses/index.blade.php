@extends('customer.layouts.app')
@section('title', 'Alamat Saya')

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

        .alert-profile-success {
            background-color: #e9f5e9;
            color: #1f7c3c;
            border: 1px solid #c8e6c9;
            border-radius: 0.375rem;
        }

        .page-header h4 {
            font-family: var(--font-heading);
            font-size: 1.75rem;
            color: var(--text-dark);
        }

        .address-card {
            background-color: #fff;
            border: 1px solid #e5e5e5;
            border-left: 4px solid var(--primary-color);
            border-radius: 0.375rem;
            padding: 1.25rem;
            transition: all 0.3s ease;
        }

        .address-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.07);
            border-color: var(--primary-color);
        }

        .address-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .address-tag {
            background-color: var(--primary-color);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 25px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .address-actions .btn {
            color: #888;
            font-size: 0.9rem;
            padding: 0.25rem 0.5rem;
        }

        .address-actions .btn:hover {
            color: var(--primary-color);
        }

        .address-body p {
            margin-bottom: 0.5rem;
            color: #555;
            display: flex;
            align-items: center;
        }

        .address-body p i {
            color: var(--primary-color);
            margin-right: 0.75rem;
            width: 16px;
            text-align: center;
        }

        .empty-state {
            background-color: #fff;
            border: 2px dashed #eee;
            padding: 3rem;
            border-radius: 0.5rem;
            text-align: center;
        }

        .empty-state i {
            font-size: 3rem;
            color: #ccc;
        }
    </style>
@endsection

@section('content')
    <div class="container py-5">
        <div class="row">
            @include('customer.components.sidebar')

            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-4 page-header">
                    <div>
                        <h4 class="fw-bold">Alamat Saya</h4>
                        <p class="text-muted mb-0">Kelola semua alamat pengiriman Anda di sini.</p>
                    </div>
                    <a href="{{ route('customer.profile.alamat.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle-fill me-2"></i>Tambah Alamat Baru
                    </a>
                </div>

                @if (session('success'))
                    <div class="alert alert-profile-success">{{ session('success') }}</div>
                @endif

                @forelse ($addresses as $address)
                    <div class="card address-card mb-3">
                        <div class="address-header">
                            <span class="address-tag">{{ $address->label }}</span>
                            <div class="address-actions">
                                <a href="{{ route('customer.profile.alamat.edit', $address->id) }}"
                                    class="btn btn-link text-decoration-none" title="Ubah Alamat"><i
                                        class="bi bi-pencil-square me-1"></i> Ubah</a>
                                <form action="{{ route('customer.profile.alamat.destroy', $address->id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Anda yakin ingin menghapus alamat ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link text-decoration-none text-danger"
                                        title="Hapus Alamat"><i class="bi bi-trash3-fill me-1"></i> Hapus</button>
                                </form>
                            </div>
                        </div>
                        <div class="address-body">
                            <h6 class="fw-bold mb-2">{{ $address->recipient_name }}</h6>
                            <p><i class="bi bi-telephone-fill"></i> {{ $address->phone_number }}</p>
                            <p><i class="bi bi-house-door-fill"></i> {{ $address->full_address }}</p>
                            <p class="mb-0"><i class="bi bi-mailbox"></i> Kode Pos: {{ $address->postal_code }}</p>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="bi bi-geo-alt"></i>
                        <h5 class="mt-3">Belum Ada Alamat</h5>
                        <p class="text-muted">Yuk, tambahkan alamat baru untuk kemudahan berbelanja Anda.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
