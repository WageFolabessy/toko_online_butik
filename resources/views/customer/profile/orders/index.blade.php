@extends('customer.layouts.app')

@section('title', 'Riwayat Pesanan')

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

        .page-header h4 {
            font-family: var(--font-heading);
            font-size: 1.75rem;
            color: var(--text-dark);
        }

        .order-accordion .accordion-item {
            background-color: #fff;
            border: 1px solid #e5e5e5;
            border-radius: 0.5rem !important;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .order-accordion .accordion-item:hover {
            border-color: var(--primary-color);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.07);
        }

        .order-accordion .accordion-header {
            border-radius: 0.5rem;
        }

        .order-accordion .accordion-button {
            display: grid;
            grid-template-columns: repeat(2, 1fr) repeat(2, auto);
            gap: 1rem;
            align-items: center;
            font-size: 0.9rem;
            font-weight: 500;
            border-radius: 0.5rem !important;
        }

        .order-accordion .accordion-button:not(.collapsed) {
            background-color: var(--secondary-color);
            color: var(--primary-color);
            box-shadow: none;
        }

        .order-accordion .accordion-button:focus {
            box-shadow: 0 0 0 0.25rem rgba(139, 115, 85, 0.25);
        }

        .order-accordion .accordion-button::after {
            display: none;
        }

        .order-accordion .accordion-body {
            padding: 1rem 1.25rem;
        }

        .order-info span {
            display: block;
        }

        .order-info .label {
            font-size: 0.75rem;
            color: #888;
            text-transform: uppercase;
        }

        .status-badge {
            padding: 0.4em 0.8em;
            font-weight: 600;
            font-size: 0.8rem;
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

        .pagination .page-link {
            color: var(--primary-color);
        }

        .pagination .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
    </style>
@endsection

@section('content')
    <div class="container py-5">
        <div class="row">
            @include('customer.components.sidebar')

            <div class="col-lg-9">
                <div class="page-header mb-4">
                    <h4 class="fw-bold">Riwayat Pesanan Saya</h4>
                </div>

                <div class="accordion order-accordion" id="ordersAccordion">
                    @forelse ($orders as $order)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading-{{ $order->id }}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse-{{ $order->id }}" aria-expanded="false"
                                    aria-controls="collapse-{{ $order->id }}">
                                    <div class="order-info">
                                        <span class="label">No. Pesanan</span>
                                        <span>#{{ $order->order_number }}</span>
                                    </div>
                                    <div class="order-info">
                                        <span class="label">Tanggal</span>
                                        <span>{{ $order->created_at->translatedFormat('d F Y') }}</span>
                                    </div>
                                    <div class="order-info">
                                        <span class="label">Total</span>
                                        <span class="fw-bold">Rp
                                            {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="order-info text-end">
                                        <span
                                            class="badge status-badge {{ $order->status_badge_class }}">{{ $order->status_text }}</span>
                                    </div>
                                </button>
                            </h2>
                            <div id="collapse-{{ $order->id }}" class="accordion-collapse collapse"
                                aria-labelledby="heading-{{ $order->id }}" data-bs-parent="#ordersAccordion">
                                <div class="accordion-body border-top">
                                    <h6 class="fw-bold">Item Pesanan:</h6>
                                    @foreach ($order->items as $item)
                                        <div class="d-flex align-items-center mb-2">
                                            <img src="{{ $item->product->images->first() ? asset('storage/products/' . $item->product->images->first()->path) : 'https://via.placeholder.com/60' }}"
                                                class="rounded me-3" width="60" height="60"
                                                style="object-fit: cover;">
                                            <div>
                                                <div class="fw-semibold">{{ $item->product->name }}</div>
                                                <div class="small text-muted">{{ $item->qty }} item</div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <a href="{{ route('customer.profile.orders.show', $order) }}"
                                        class="btn btn-sm btn-primary mt-3">
                                        Lihat Detail Pesanan <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="bi bi-receipt"></i>
                            <h5 class="mt-3">Anda Belum Punya Pesanan</h5>
                            <p class="text-muted">Semua pesanan yang Anda buat akan muncul di sini.</p>
                            <a href="{{ route('customer.products.index') }}" class="btn btn-primary mt-2">
                                <i class="bi bi-bag-heart-fill me-2"></i> Mulai Belanja
                            </a>
                        </div>
                    @endforelse
                </div>

                <div class="mt-4">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
