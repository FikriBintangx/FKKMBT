<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FKKMBT - Forum Komunikasi Koordinasi Masyarakat Bukit Tiara</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background: linear-gradient(135deg, #2d6a5f 0%, #1f5449 100%);">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-3" href="<?= base_url() ?>">
                <img src="<?= base_url('assets/images/LOGO/LOGOFKKMBT.jpg') ?>" alt="FKKMBT Logo" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover; cursor: pointer; transition: transform 0.3s;" data-bs-toggle="modal" data-bs-target="#logoModal" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                <span class="fw-bold fs-4">FKKMBT</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    <li class="nav-item"><a class="nav-link active" href="<?= base_url() ?>">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('tentang') ?>">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('kegiatan') ?>">Kegiatan</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('warga') ?>">Direktori Warga</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('struktur') ?>">Struktur FKKMBT</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('iuran') ?>">Iuran</a></li>
                    <?php if($this->session->userdata('user_id')): ?>
                        <li class="nav-item">
                            <a class="btn btn-outline-light" href="<?= ($this->session->userdata('role') == 'admin') ? base_url('admin/dashboard') : base_url('user/dashboard') ?>">
                                <i class="bi bi-speedometer2 me-2"></i>Dashboard
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="btn btn-outline-light" href="<?= base_url('auth/login') ?>">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-white" id="beranda" style="background: linear-gradient(135deg, #2d6a5f 0%, #1f5449 100%); padding-top: 100px; margin-top: 56px;">
        <div class="container">
            <div class="hero-badge">
                <i class="bi bi-stars"></i>
                <span>Selamat Datang di Portal Komunitas</span>
            </div>
            <h1>FKKMBT</h1>
            <p class="subtitle">Forum Komunikasi dan Koordinasi</p>
            <p class="highlight">Masyarakat Bukit Tiara</p>
            <p>Bersama membangun komunitas yang harmonis, sejahtera, dan saling mendukung.<br>
            Portal resmi untuk informasi, kegiatan, dan koordinasi warga Perumahan Bukit Tiara.</p>
            
            <div class="hero-buttons">
                <a href="<?= base_url('auth/register') ?>" class="btn btn-hero-primary">
                    Jelajahi Sekarang
                    <i class="bi bi-arrow-right"></i>
                </a>
                <a href="<?= base_url('auth/login') ?>" class="btn btn-hero-secondary">
                    Masuk Portal
                </a>
            </div>

            <div class="hero-stats">
                <div class="stat-item">
                    <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
                    <span class="stat-number">500+</span>
                    <span class="stat-label">Warga Aktif</span>
                </div>
                <div class="stat-item">
                    <div class="stat-icon"><i class="bi bi-buildings-fill"></i></div>
                    <span class="stat-number">A - T</span>
                    <span class="stat-label">Blok Hunian</span>
                </div>
                <div class="stat-item">
                    <div class="stat-icon"><i class="bi bi-calendar-event-fill"></i></div>
                    <span class="stat-number">50+</span>
                    <span class="stat-label">Kegiatan/Tahun</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5" id="tentang">
        <div class="container">
            <div class="section-title mb-5">
                <h6>Fitur Lengkap</h6>
                <h2>Semua yang Anda Butuhkan</h2>
                <p>Portal lengkap untuk mengakses informasi dan layanan komunitas Bukit Tiara</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon-box icon-teal">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <h4>Sejarah & Tentang</h4>
                        <p>Mengenal lebih dekat sejarah dan visi misi komunitas Bukit Tiara</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon-box icon-orange">
                            <i class="bi bi-calendar-event"></i>
                        </div>
                        <h4>Kegiatan Organisasi</h4>
                        <p>Informasi kegiatan RT/RW, FKKMBT, Karang Taruna, dan lainnya</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon-box icon-blue">
                            <i class="bi bi-book"></i>
                        </div>
                        <h4>Direktori Warga</h4>
                        <p>Database alamat warga dari Blok A sampai T lengkap dengan nomor rumah</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon-box icon-purple">
                            <i class="bi bi-diagram-3"></i>
                        </div>
                        <h4>Struktur Organisasi</h4>
                        <p>Susunan pengurus FKKMBT dan FKKMMBT periode aktif</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon-box icon-red">
                            <i class="bi bi-credit-card"></i>
                        </div>
                        <h4>Iuran Warga</h4>
                        <p>Informasi dan status pembayaran iuran bulanan warga</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon-box icon-slate">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        <h4>Portal Admin</h4>
                        <p>Akses khusus untuk pengelolaan data dan konten website</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="container my-5">
        <div class="cta-section">
            <div class="cta-badge">
                <i class="bi bi-rainbow"></i>
                <span>Bergabung Bersama Kami</span>
            </div>
            <h2>Jadilah Bagian dari Komunitas<br>Bukit Tiara</h2>
            <p>Akses informasi lengkap, ikuti kegiatan komunitas, dan berkontribusi untuk kemajuan lingkungan kita bersama.</p>
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <a href="<?= base_url('auth/register') ?>" class="btn btn-cta-primary">
                    Daftar Sekarang
                    <i class="bi bi-arrow-right"></i>
                </a>
                <a href="#tentang" class="btn btn-cta-secondary">
                    Pelajari Lebih Lanjut
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="footer-logo">
                        <div class="logo-circle">F</div>
                        <div class="brand-text">
                            <strong>FKKMBT</strong>
                        </div>
                    </div>
                    <p class="text-white-50">Forum Komunikasi Koordinasi Masyarakat Bukit Tiara - Membangun komunitas yang harmonis, sejahtera, dan saling mendukung.</p>
                </div>
                
                <div class="col-md-2">
                    <h6>Menu Cepat</h6>
                    <a href="<?= base_url('tentang') ?>">Tentang Kami</a>
                    <a href="<?= base_url('kegiatan') ?>">Kegiatan</a>
                    <a href="<?= base_url('struktur') ?>">Organisasi </a>
                </div>
                
                <div class="col-md-3">
                    <h6>Organisasi</h6>
                    <a href="<?= base_url('struktur?tab=fkkmbt') ?>">Struktur FKKMBT</a>
                    <a href="<?= base_url('struktur?tab=fkkmmbt') ?>">Struktur FKKMMBT</a>
                </div>
                
                <div class="col-md-3">
                    <h6>Kontak</h6>
                    <p class="text-white-50 mb-2">
                        <i class="bi bi-geo-alt me-2"></i>
                        Perumahan Bukit Tiara, Kecamatan Cikupa, Kabupaten Tangerang, Banten 15710
                    </p>
                    <p class="text-white-50 mb-2">
                        <i class="bi bi-telephone me-2"></i>
                        087786720942
                    </p>
                </div>
            </div>
            
            <hr class="my-4">
            
            <div class="text-center text-white-50">
                <p class="mb-0">&copy; 2025 FKKMBT. Developed by Ceva_Star.</p>
            </div>
        </div>
    </footer>


    <!-- Logo Zoom Modal -->
    <div class="modal fade" id="logoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-body text-center p-0">
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close" style="z-index: 10;"></button>
                    <img src="<?= base_url('assets/images/LOGO/LOGOFKKMBT.jpg') ?>" alt="FKKMBT Logo" class="img-fluid rounded-circle" style="max-width: 400px; box-shadow: 0 10px 40px rgba(0,0,0,0.5);">
                    <h3 class="text-white mt-3 fw-bold">FKKMBT</h3>
                    <p class="text-white-50">Forum Komunikasi Koordinasi Masyarakat Bukit Tiara</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
