@extends('admin.layouts.app')

@section('title', 'Manajemen Ulasan Produk')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold">Manajemen Ulasan Produk</h3>
                <p class="text-muted mb-0">Daftar semua ulasan dari pelanggan</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="reviews-table" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Pelanggan</th>
                                <th>Rating</th>
                                <th>Ulasan</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reviews as $review)
                                <tr>
                                    <td>{{ $review->product->name ?? 'N/A' }}</td>
                                    <td>{{ $review->user->name ?? 'N/A' }}</td>
                                    <td class="text-warning">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="bi {{ $i <= $review->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                        @endfor
                                    </td>
                                    <td>{{ Str::limit($review->review, 50) }}</td>
                                    <td>{{ $review->created_at->translatedFormat('d M Y') }}</td>
                                    <td>
                                        <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Anda yakin ingin menghapus ulasan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash-fill"></i> Hapus
                                            </button>
                                        </form>
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
            $('#reviews-table').DataTable({
                "language": {
                    "url": '{{ asset('assets/admin/vendor/id.json') }}',
                },
                "order": [
                    [4, "desc"]
                ]
            });
        });
    </script>
@endpush
