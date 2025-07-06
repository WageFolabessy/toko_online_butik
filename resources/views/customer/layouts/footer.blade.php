<footer class="bg-dark text-white pt-5 pb-4">
    <div class="container text-center text-md-left">
        <div class="row text-center text-md-left">
            <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 font-weight-bold text-primary">Butik Disel</h5>
                <p>Menyediakan pakaian fashion terkini dengan kualitas terbaik untuk menunjang penampilan Anda setiap
                    hari.</p>
            </div>
            <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 font-weight-bold text-primary">Kategori</h5>

                @isset($footerCategories)
                    @forelse ($footerCategories as $category)
                        <p>
                            <a href="#" class="text-white" style="text-decoration: none;">{{ $category->name }}</a>
                        </p>
                    @empty
                        <p>
                            <a href="#" class="text-white" style="text-decoration: none;">Belum ada kategori.</a>
                        </p>
                    @endforelse
                @endisset

            </div>
            <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 font-weight-bold text-primary">Kontak</h5>
                <p><i class="bi bi-geo-alt-fill me-2"></i> Pontianak, Kalimantan Barat</p>
                <p><i class="bi bi-envelope-fill me-2"></i> butikdisel@gmail.com</p>
                <p><i class="bi bi-telephone-fill me-2"></i> +62 812 3456 7890</p>
            </div>
        </div>
        <hr class="mb-4">
        <div class="row align-items-center">
            <div class="col">
                <p> © {{ date('Y') }} Copyright:
                    <a href="#" class="text-white" style="text-decoration: none;">
                        <strong class="text-primary">Butik Disel</strong>
                    </a>
                </p>
            </div>
        </div>
    </div>
</footer>
