<footer class="footer-custom text-white pt-5 pb-4">
    <div class="container text-center text-md-start">
        <div class="row">
            <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 fw-bold">Butik Disel</h5>
                <p>Menyediakan pakaian fashion terkini dengan kualitas terbaik untuk menunjang penampilan Anda setiap
                    hari. Temukan gaya Anda bersama kami.</p>
            </div>

            <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 fw-bold">Kategori</h5>
                @isset($footerCategories)
                    @forelse ($footerCategories as $category)
                        <p>
                            <a href="{{ route('customer.products.index', ['kategori' => $category->slug]) }}"
                                class="footer-link">{{ $category->name }}</a>
                        </p>
                    @empty
                        <p class="text-white-50">Belum ada kategori.</p>
                    @endforelse
                @endisset
            </div>

            <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 fw-bold">Kontak</h5>
                <p><i class="bi bi-geo-alt-fill me-2"></i> Pontianak, Kalimantan Barat</p>
                <p><i class="bi bi-envelope-fill me-2"></i> butikdisel@gmail.com</p>
                <p><i class="bi bi-telephone-fill me-2"></i> +62 812 3456 7890</p>
            </div>
        </div>
        <hr class="my-4">
        <div class="row align-items-center">
            <div class="col-md-12 text-center">
                <p> © {{ date('Y') }} Copyright:
                    <a href="{{ route('customer.home') }}" class="footer-link fw-bold">
                        Butik Disel
                    </a>. All Rights Reserved.
                </p>
            </div>
        </div>
    </div>
</footer>
