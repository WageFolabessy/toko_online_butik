@extends('customer.layouts.app')
@section('title', 'Ubah Alamat')
@section('content')
    <div class="container py-5">
        <div class="row">
            @include('customer.components.sidebar')
            <div class="col-lg-9">
                <h4 class="fw-bold mb-4">Ubah Alamat</h4>
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
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
