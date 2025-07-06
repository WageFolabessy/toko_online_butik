@extends('admin.layouts.app')

@section('title', 'Manajemen Pelanggan')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold">Manajemen Pelanggan</h3>
                <p class="text-muted mb-0">Daftar semua pengguna yang terdaftar sebagai pelanggan</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="customers-table" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Tanggal Bergabung</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                                <tr>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->created_at->translatedFormat('d F Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.customers.show', $customer->id) }}"
                                            class="btn btn-info btn-sm text-white">Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#customers-table').DataTable({
                "language": {
                    "url": '{{ asset('assets/admin/vendor/id.json') }}',
                },
                "order": [
                    [2, "desc"]
                ]
            });
        });
    </script>
@endpush
