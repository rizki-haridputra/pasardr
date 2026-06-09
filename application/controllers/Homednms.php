<!DOCTYPE html>
<html lang="id">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - Pasar Modern Pasir Pengaraian</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts (Poppins) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- File CSS Kustom -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- 1. Navigasi / Header -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="Homednms">
                <img src="assets/kios/logo-pasar.png" alt="Logo Pasar Modern" width="30" class="d-inline-block align-text-top me-2">
                Pasar Datuk Rubiah
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="Homednms">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="profil.html">Profil</a></li>
                    <li class="nav-item"><a class="nav-link active" href="berita.html">Berita</a></li>
                    <li class="nav-item"><a class="nav-link" href="galeri.html">Galeri</a></li>
                    <li class="nav-item"><a class="nav-link" href="pasar">Kios</a></li>
                    <li class="nav-item"><a class="nav-link" href="home">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>


    <!-- 2. Dashboard - Slider Gambar Dinamis -->
    <header id="hero-slider" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#hero-slider" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#hero-slider" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#hero-slider" data-bs-slide-to="2"></button>
        </div>
        <div class="carousel-inner">
            <!-- Data ini akan diambil dari tabel 'sliders' di database -->
            <div class="carousel-item active">
                <img src="assets/kios/slider1.jpg" class="d-block w-100" alt="Promosi Buah Segar">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Promosi Buah Segar Lokal</h5>
                    <p>Dapatkan buah-buahan berkualitas langsung dari petani lokal dengan harga terbaik.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="assets/kios/slider2.jpg" class="d-block w-100" alt="Diskon Akhir Pekan">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Diskon Spesial Akhir Pekan!</h5>
                    <p>Nikmati potongan harga hingga 30% untuk berbagai produk kebutuhan pokok.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="assets/kios/slider3.jpg" class="d-block w-100" alt="Area Food Court">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Area Food Court Baru Telah Dibuka</h5>
                    <p>Cicipi aneka jajanan dan makanan lezat di area food court kami yang nyaman.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#hero-slider" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#hero-slider" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </header>

    <main class="container my-5">
        <!-- 3. Profil Singkat -->
        <section id="profil-singkat" class="text-center p-4 rounded-3 bg-light">
            <h2 class="section-title">Selamat Datang di Pasar Modern Pasir Pengaraian</h2>
            <p class="lead col-md-8 mx-auto">
                Kami berkomitmen menjadi pusat perbelanjaan kebutuhan pokok yang bersih, nyaman, dan modern. Menyediakan produk segar berkualitas dengan pelayanan prima untuk kepuasan Anda.
            </p>
            <a href="profil.html" class="btn btn-primary mt-3">Lihat Profil Lengkap</a>
        </section>

        <!-- 4. Berita Terbaru -->
        <section id="berita-terbaru" class="my-5">
            <h2 class="section-title text-center mb-4">Berita & Informasi Terkini</h2>
            <div class="row g-4">
                <!-- Data ini akan diambil dari tabel 'news' di database -->
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm news-card">
                        <img src="assets/kios/berita1.jpg" class="card-img-top" alt="Festival Kuliner">
                        <div class="card-body">
                            <p class="card-text"><small class="text-muted">20 Juli 2025</small></p>
                            <h5 class="card-title">Pasar Modern Gelar Festival Kuliner Nusantara</h5>
                            <p class="card-text">Dalam rangka merayakan hari jadi, kami akan menyelenggarakan festival kuliner nusantara...</p>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <a href="berita-detail.html" class="btn btn-outline-primary">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm news-card">
                        <img src="assets/kios/berita2.jpg" class="card-img-top" alt="Digitalisasi Pedagang">
                        <div class="card-body">
                            <p class="card-text"><small class="text-muted">15 Juli 2025</small></p>
                            <h5 class="card-title">Program Digitalisasi Pedagang Resmi Diluncurkan</h5>
                            <p class="card-text">Manajemen resmi meluncurkan program digitalisasi untuk meningkatkan daya saing pedagang...</p>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <a href="berita-detail.html" class="btn btn-outline-primary">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm news-card">
                        <img src="assets/kios/berita3.jpg" class="card-img-top" alt="Jadwal Libur">
                        <div class="card-body">
                            <p class="card-text"><small class="text-muted">11 Juli 2025</small></p>
                            <h5 class="card-title">Jadwal Operasional Selama Libur Idul Adha</h5>
                            <p class="card-text">Informasi penyesuaian jadwal operasional pasar selama periode libur hari raya Idul Adha...</p>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <a href="berita-detail.html" class="btn btn-outline-primary">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- 5. Footer -->
    <footer class="bg-dark text-white pt-5 pb-4">
        <div class="container text-center text-md-start">
            <div class="row">
                <div class="col-md-4 col-lg-4 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 fw-bold text-primary">Pasar Modern Pasir Pengaraian</h5>
                    <p>Pusat belanja kebutuhan harian yang modern, bersih, dan terpercaya. Kami hadir untuk melayani masyarakat dengan produk terbaik.</p>
                </div>
                <div class="col-md-2 col-lg-2 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 fw-bold">Link Cepat</h5>
                    <p><a href="profil.html" class="text-white">Profil</a></p>
                    <p><a href="berita.html" class="text-white">Berita</a></p>
                    <p><a href="pasar" class="text-white">Tenant</a></p>
                </div>
                <div class="col-md-4 col-lg-3 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 fw-bold">Kontak</h5>
                    <p>Jl. Raya Sejahtera No. 123, Jakarta</p>
                    <p>info@pasarmodern.com</p>
                    <p>(021) 123 4567</p>
                </div>
            </div>
            <hr class="my-3">
            <div class="text-center py-2">
                <p>© 2025 Pasar Modern Pasir Pengaraian. Seluruh Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </footer>


    <!-- Bootstrap JS (Wajib untuk komponen interaktif seperti slider) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>