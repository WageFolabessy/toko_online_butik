@extends('customer.layouts.app')
@section('title', 'Tambah Alamat Baru')
@section('content')
    <div class="container py-5">
        <div class="row">
            @include('customer.components.sidebar')
            <div class="col-lg-9">
                <h4 class="fw-bold mb-4">Tambah Alamat Baru</h4>
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form action="{{ route('customer.profile.alamat.store') }}" method="POST">
                            @include('customer.profile.addresses._form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

