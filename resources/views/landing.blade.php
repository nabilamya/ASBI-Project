<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignLearn</title>

    {{-- Font Poppins --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>
<body>
    <div class="page">

        {{-- ===== NAVBAR ===== --}}
        <header class="navbar container">
            <div class="logo-wrap">
                <img src="{{ asset('assets/logo.png') }}" alt="Logo SignLearn" class="logo">
            </div>

            <nav class="nav-menu">
                {{-- Ganti href ke route yang sesuai --}}
                <a href="#">Beranda</a>
                <a href="#">Pembelajaran</a>
                <a href="#">History</a>
            </nav>

            <div class="nav-actions">
                {{-- Ganti href ke route login & register --}}
                <a href="#"    class="btn btn-outline">Masuk</a>
                <a href="#" class="btn btn-primary">Daftar</a>
            </div>
        </header>

        {{-- ===== HERO ===== --}}
        <section class="hero container">
            <div class="hero-text">
                <h1>
                    Belajar <span>Bahasa Isyarat</span><br>
                    Dengan AI Secara<br>
                    Mandiri
                </h1>

                <p>
                    Aplikasi cerdas berbasis AI untuk belajar dan melatih bahasa isyarat
                    dengan mudah dan menyenangkan.
                </p>

                <div class="hero-buttons">
                    {{-- Ganti href sesuai halaman tujuan --}}
                    <a href="#" class="btn btn-light">Mulai Belajar</a>
                    <a href="#"      class="btn btn-primary">Coba Latihan</a>
                </div>
            </div>

            <div class="hero-image-box">
                {{-- Ilustrasi utama: taruh di public/assets/hero-illustration.png --}}
                <img
                    src="{{ asset('assets/hero-illustration.png') }}"
                    alt="Ilustrasi Belajar Bahasa Isyarat"
                    class="hero-image"
                >

                {{-- Icon dekoratif mengambang: taruh di public/assets/icon-1.png dst --}}
                <img src="{{ asset('assets/icon-1.png') }}" alt="" class="floating-icon icon-1">
                <img src="{{ asset('assets/icon-2.png') }}" alt="" class="floating-icon icon-2">
                <img src="{{ asset('assets/icon-3.png') }}" alt="" class="floating-icon icon-3">
            </div>
        </section>

        {{-- ===== FITUR UTAMA ===== --}}
        <section class="features container">
            <h2>Fitur Utama SIGNLEARN</h2>

            <div class="feature-grid">

                <div class="feature-card">
                    <h3>Modul Pembelajaran</h3>
                    {{-- Icon modul: taruh di public/assets/feature-1.png --}}
                    <img src="{{ asset('assets/feature-1.png') }}" alt="Modul Pembelajaran" class="feature-icon">
                    <p>Belajar bahasa isyarat SIBI dan BISINDO melalui modul dan video tutorial.</p>
                </div>

                <div class="feature-card">
                    <h3>Latihan gesture berbasis AI</h3>
                    {{-- Icon latihan: taruh di public/assets/feature-2.png --}}
                    <img src="{{ asset('assets/feature-2.png') }}" alt="Latihan Gesture" class="feature-icon">
                    <p>Latihan gesture tangan menggunakan kamera yang dianalisis oleh AI.</p>
                </div>

                <div class="feature-card">
                    <h3>Riwayat Pembelajaran</h3>
                    {{-- Icon riwayat: taruh di public/assets/feature-3.png --}}
                    <img src="{{ asset('assets/feature-3.png') }}" alt="Riwayat Skor" class="feature-icon">
                    <p>Melihat skor dan perkembangan latihan sebelumnya.</p>
                </div>

            </div>
        </section>

        {{-- ===== CTA ===== --}}
        <section class="cta container">
            <h2>Mulai Belajar Bahasa Isyarat Sekarang <span>›</span></h2>

            <div class="cta-buttons">
                {{-- Ganti href sesuai route --}}
                <a href="#"    class="btn btn-outline large">Masuk</a>
                <a href="#" class="btn btn-primary large">Daftar Sekarang</a>
            </div>
        </section>

    </div>
</body>
</html>
