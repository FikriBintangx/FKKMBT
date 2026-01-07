<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>FKKMBT - Forum Komunikasi Koordinasi Masyarakat Bukit Tiara</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css?v='.time()) ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/mobile.css?v='.time()) ?>">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            padding: 140px 0 80px;
            border-radius: 0 0 40px 40px;
            color: white;
            position: relative;
            overflow: hidden;
            margin-top: -80px; /* Compensate for navbar */
        }
        .hero-title {
            font-size: 2.5rem;
            font-weight: 800;
            line-height: 1.2;
            background: linear-gradient(to right, #ffffff, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 20px;
        }
        .hero-badge {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }
        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            text-align: center;
            height: 100%;
        }
        .feature-icon-circle {
            width: 60px; height: 60px;
            border-radius: 50%;
            background: #f1f5f9;
            display: flex; align-items: center; justify-content: center;
            font-size: 24px;
            margin: 0 auto 15px;
            color: #1e293b;
        }
    </style>
</head>
<body class="bg-light">
    
    <!-- Navbar Included -->
    <?php $this->load->view('templates/header'); ?>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container text-center">
            <div class="hero-badge" data-aos="fade-down">
                <i class="bi bi-stars text-warning"></i>
                <span>Portal Resmi Warga Bukit Tiara</span>
            </div>
            
            <h1 class="hero-title" data-aos="fade-up">Membangun Komunitas<br>Yang Lebih Harmonis</h1>
            <p class="text-white-50 mb-5 px-3" data-aos="fade-up" data-aos-delay="100">
                Pusat informasi, kegiatan, layanan, dan transparansi iuran untuk seluruh warga Perumahan Bukit Tiara.
            </p>
            
            <div class="d-flex justify-content-center gap-3" data-aos="fade-up" data-aos-delay="200">
                <a href="<?= base_url('auth/login') ?>" class="btn btn-primary rounded-pill px-4 py-3 fw-bold shadow-lg">
                    Masuk Portal <i class="bi bi-arrow-right ms-2"></i>
                </a>
                <a href="#fitur" class="btn btn-outline-light rounded-pill px-4 py-3 fw-bold">
                    Pelajari Fitur
                </a>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="container" style="margin-top: -40px; position: relative; z-index: 10;">
        <div class="row g-3">
            <div class="col-4">
                <div class="stat-card" data-aos="fade-up" data-aos-delay="300">
                    <h3 class="fw-bold mb-0 text-primary">500+</h3>
                    <small class="text-muted fw-bold" style="font-size: 10px;">WARGA</small>
                </div>
            </div>
            <div class="col-4">
                <div class="stat-card" data-aos="fade-up" data-aos-delay="400">
                    <h3 class="fw-bold mb-0 text-success">20</h3>
                    <small class="text-muted fw-bold" style="font-size: 10px;">BLOK</small>
                </div>
            </div>
            <div class="col-4">
                <div class="stat-card" data-aos="fade-up" data-aos-delay="500">
                    <h3 class="fw-bold mb-0 text-warning">50+</h3>
                    <small class="text-muted fw-bold" style="font-size: 10px;">KEGIATAN</small>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Grid -->
    <section class="container py-5" id="fitur">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="text-primary fw-bold small text-uppercase ls-1">Layanan</span>
                <h3 class="fw-bold text-dark mt-1">Akses Mudah</h3>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-6 col-md-4" data-aos="fade-up">
                <a href="<?= base_url('tentang') ?>" class="text-decoration-none">
                    <div class="stat-card">
                        <div class="feature-icon-circle text-white bg-primary shadow-sm">
                            <i class="bi bi-info-circle-fill"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-1">Tentang Kami</h6>
                        <small class="text-secondary" style="font-size: 11px;">Visi & Misi FKKMBT</small>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4" data-aos="fade-up" data-aos-delay="100">
                <a href="<?= base_url('kegiatan') ?>" class="text-decoration-none">
                    <div class="stat-card">
                        <div class="feature-icon-circle text-white bg-danger shadow-sm">
                            <i class="bi bi-calendar-event-fill"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-1">Kegiatan</h6>
                        <small class="text-secondary" style="font-size: 11px;">Agenda Warga</small>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4" data-aos="fade-up" data-aos-delay="200">
                <a href="<?= base_url('warga') ?>" class="text-decoration-none">
                    <div class="stat-card">
                        <div class="feature-icon-circle text-white bg-success shadow-sm">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-1">Direktori</h6>
                        <small class="text-secondary" style="font-size: 11px;">Data Warga</small>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4" data-aos="fade-up" data-aos-delay="300">
                <a href="<?= base_url('iuran') ?>" class="text-decoration-none">
                    <div class="stat-card">
                        <div class="feature-icon-circle text-white bg-warning shadow-sm">
                            <i class="bi bi-wallet-fill"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-1">Info Iuran</h6>
                        <small class="text-secondary" style="font-size: 11px;">Transparansi Dana</small>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white py-5">
        <div class="container text-center">
            <div class="d-flex align-items-center justify-content-center gap-2 mb-3">
                <img src="<?= base_url('assets/images/LOGO/LOGOFKKMBT.jpg') ?>" width="40" class="rounded-circle">
                <span class="fw-bold fs-5 text-dark">FKKMBT</span>
            </div>
            <p class="text-muted small mb-4 px-4">
                Forum Komunikasi Koordinasi Masyarakat Bukit Tiara.<br>
                Mewujudkan lingkungan yang aman, nyaman, dan harmonis.
            </p>
            <div class="d-flex justify-content-center gap-3 mb-4">
                <a href="#" class="btn btn-light rounded-circle"><i class="bi bi-facebook"></i></a>
                <a href="#" class="btn btn-light rounded-circle"><i class="bi bi-instagram"></i></a>
                <a href="#" class="btn btn-light rounded-circle"><i class="bi bi-whatsapp"></i></a>
            </div>
            <hr class="border-light-subtle w-50 mx-auto">
            <small class="text-muted">© 2025 FKKMBT. All Rights Reserved.</small>
        </div>
    </footer>

    <!-- Panic Button & Modal -->
    <div class="fixed-bottom p-4" style="z-index: 1050; pointer-events: none;">
        <div class="text-end" style="pointer-events: auto;">
            <button class="btn btn-danger rounded-circle shadow-lg d-flex align-items-center justify-content-center shake-animation" style="width: 60px; height: 60px;" data-bs-toggle="modal" data-bs-target="#panicModal">
                <i class="bi bi-exclamation-triangle-fill fs-3"></i>
            </button>
        </div>
    </div>

    <!-- Panic Modal -->
    <div class="modal fade" id="panicModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-bottom">
            <div class="modal-content border-0 shadow-lg rounded-top-5">
                <div class="modal-header border-0 pb-0 justify-content-center">
                    <div style="width: 50px; height: 5px; background: #e2e8f0; border-radius: 10px;"></div>
                </div>
                <div class="modal-body p-4 text-center">
                    <div class="bg-danger-subtle text-danger rounded-circle d-inline-flex p-3 mb-3">
                        <i class="bi bi-shield-exclamation fs-1"></i>
                    </div>
                    <h4 class="fw-bold mb-2">Panggilan Darurat</h4>
                    <p class="text-muted small mb-4">Segera hubungi bantuan jika Anda dalam keadaan darurat.</p>
                    
                    <div class="d-grid gap-3">
                        <a href="tel:112" class="btn btn-light btn-lg d-flex align-items-center justify-content-between p-3 border">
                            <span class="d-flex align-items-center gap-3">
                                <i class="bi bi-telephone-fill text-danger"></i> Darurat Umum
                            </span>
                            <span class="fw-bold text-dark">112</span>
                        </a>
                        <a href="tel:081234567890" class="btn btn-dark btn-lg d-flex align-items-center justify-content-between p-3">
                            <span class="d-flex align-items-center gap-3">
                                <i class="bi bi-person-badge-fill"></i> Satpam
                            </span>
                            <span class="fw-bold">Call Pos</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .shake-animation {
            animation: shake 5s cubic-bezier(.36,.07,.19,.97) both infinite;
            transform: translate3d(0, 0, 0);
        }
        @keyframes shake {
            1%, 9% { transform: translate3d(-1px, 0, 0); }
            2%, 8% { transform: translate3d(2px, 0, 0); }
            3%, 5%, 7% { transform: translate3d(-4px, 0, 0); }
            4%, 6% { transform: translate3d(4px, 0, 0); }
            10%, 100% { transform: translate3d(0, 0, 0); }
        }
        .modal-dialog-bottom { margin: 0; display: flex; align-items: flex-end; min-height: 100%; }
        .modal.fade .modal-dialog-bottom { transform: translate(0, 100%); }
        .modal.show .modal-dialog-bottom { transform: none; transition: transform 0.3s ease-out; }
    </style>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        AOS.init({ duration: 800, once: true });
    </script>
</body>
</html>
