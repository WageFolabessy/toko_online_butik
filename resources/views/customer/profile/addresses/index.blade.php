@extends('customer.layouts.app')

@section('title', 'Alamat Saya')

@section('content')
    <div class="container py-5">
        <div class="row">
            @include('customer.components.sidebar')

            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-bold">Alamat Saya</h4>
                        <p class="text-muted mb-0">Kelola alamat pengiriman Anda.</p>
                    </div>
                    <a href="{{ route('customer.profile.alamat.create') }}" class="btn btn-primary">Tambah Alamat Baru</a>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @forelse ($addresses as $address)
                    <div class="card card-body mb-3 shadow-sm">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="card-title">{{ $address->label }}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">{{ $address->recipient_name }}</h6>
                                <p class="card-text mb-1">{{ $address->phone_number }}</p>
                                <p class="card-text mb-1">{{ $address->full_address }}</p>
                                <p class="card-text mb-0">Kode Pos: {{ $address->postal_code }}</p>
                            </div>
                            <div class="d-flex flex-column">
                                <a href="{{ route('customer.profile.alamat.edit', $address->id) }}"
                                    class="btn btn-warning btn-sm mb-2">Ubah</a>
                                <form action="{{ route('customer.profile.alamat.destroy', $address->id) }}" method="POST"
                                    onsubmit="return confirm('Anda yakin ingin menghapus alamat ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm w-100">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <p>Anda belum memiliki alamat tersimpan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
