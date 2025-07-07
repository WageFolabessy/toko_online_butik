@extends('customer.layouts.app')

@section('title', 'Kontak Kami')

@section('css')
    <style>
        .page-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .page-header h2 {
            font-family: var(--font-heading);
            font-size: 2.8rem;
            color: var(--text-dark);
        }

        .page-header p {
            font-size: 1.1rem;
            color: #777;
            max-width: 600px;
            margin: 0.5rem auto 0 auto;
        }

        .info-section {
            background-color: #fff;
            padding: 3rem;
            border-radius: 0.5rem;
            border: 1px solid #eee;
        }

        .info-section .section-title {
            font-family: var(--font-heading);
            font-size: 1.75rem;
            margin-bottom: 1.5rem;
            color: var(--text-dark);
            position: relative;
            padding-bottom: 0.5rem;
        }

        .info-section .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background-color: var(--primary-color);
        }

        .contact-detail {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1.5rem;
        }

        .contact-detail .icon {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-right: 1rem;
            min-width: 25px;
        }

        .contact-detail .info h6 {
            margin-bottom: 0.25rem;
            font-weight: 700;
        }

        .contact-detail .info p,
        .contact-detail .info a {
            margin-bottom: 0;
            color: #555;
            text-decoration: none;
        }

        .contact-detail .info a:hover {
            color: var(--primary-color);
        }

        .map-container {
            border-radius: 0.5rem;
            overflow: hidden;
            height: 100%;
            min-height: 350px;
            border: 1px solid #eee;
        }

        .map-container iframe {
            border: 0;
            height: 100%;
            width: 100%;
        }

        .social-icons .social-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--secondary-color);
            color: var(--primary-color);
            font-size: 1.2rem;
            margin-right: 0.5rem;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-icons .social-link:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-3px);
        }
    </style>
@endsection

@section('content')
    <div class="container py-5">
        <div class="page-header">
            <h2>Informasi Toko</h2>
            <p>Temukan kami dan jangan ragu untuk berkunjung atau menghubungi kami pada jam operasional.</p>
        </div>

        <div class="info-section">
            <div class="row">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h4 class="section-title">Tentang Kami</h4>
                    <p class="text-muted" style="line-height: 1.8;">
                        Selamat datang di toko kami! Kami berdedikasi untuk menyediakan produk-produk berkualitas terbaik
                        dengan sentuhan khas dari Pontianak. Sejak berdiri, kami berkomitmen untuk memberikan pelayanan yang
                        ramah dan pengalaman berbelanja yang tak terlupakan bagi setiap pelanggan.
                    </p>

                    <h4 class="section-title mt-5">Detail Kontak</h4>
                    <div class="contact-detail">
                        <div class="icon"><i class="bi bi-geo-alt-fill"></i></div>
                        <div class="info">
                            <h6>Alamat</h6>
                            <p>Jl. Toko</p>
                        </div>
                    </div>
                    <div class="contact-detail">
                        <div class="icon"><i class="bi bi-telephone-fill"></i></div>
                        <div class="info">
                            <h6>Telepon / WhatsApp</h6>
                            <a href="tel:+6281234567890">+62 812-3456-7890</a>
                        </div>
                    </div>
                    <div class="contact-detail">
                        <div class="icon"><i class="bi bi-envelope-fill"></i></div>
                        <div class="info">
                            <h6>Email</h6>
                            <a href="mailto:info@tokoanda.com">info@tokoanda.com</a>
                        </div>
                    </div>
                    <div class="contact-detail">
                        <div class="icon"><i class="bi bi-clock-fill"></i></div>
                        <div class="info">
                            <h6>Jam Operasional</h6>
                            <p>Senin - Sabtu: 09:00 - 21:00 WIB<br>Minggu: Tutup</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="map-container">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.817292211475!2d109.35246737588147!3d-0.05149999995166419!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e1d5991c4202335%3A0x2a1dd3c3746c2185!2sMegamal%20Ayani%20Pontianak!5e0!3m2!1sen!2sid!4v1720371690045!5m2!1sen!2sid"
                            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
