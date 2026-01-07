<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?= isset($title) ? $title . ' - ' : '' ?>FKKMBT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css?v='.time()) ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/mobile.css?v='.time()) ?>"> 
    <style>
        /* Mobile-First Navbar Styling - Dark Green Theme */
        body { padding-top: 70px; }
        .navbar {
            background: linear-gradient(135deg, #1e5631 0%, #0d3820 100%); /* Hijau Tua */
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            padding: 12px 0;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .navbar-brand img { width: 42px; height: 42px; border: 2px solid rgba(255,255,255,0.2); }
        .navbar-brand span { 
            font-family: 'Inter', sans-serif; 
            font-weight: 800; 
            letter-spacing: 0.5px;
            color: #ffffff;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .navbar-toggler { border: none; padding: 0; color: #ffffff !important; opacity: 1; }
        .navbar-toggler:focus { box-shadow: none; }
        .navbar-toggler-icon { filter: brightness(0) invert(1); } /* Force white icon */
        
        /* Mobile Menu Overlay */
        @media (max-width: 991.98px) {
            .navbar-collapse {
                position: fixed;
                top: 70px; left: 0; right: 0; bottom: 0;
                background: white;
                padding: 20px;
                border-top: 1px solid #f1f5f9;
                height: calc(100vh - 70px);
                overflow-y: auto;
                transform: translateX(100%);
                transition: transform 0.3s ease-in-out;
            }
            .navbar-collapse.show { transform: translateX(0); }
            
            .nav-item {
                border-bottom: 1px solid #f8fafc;
                margin-bottom: 5px;
            }
            .nav-link {
                padding: 15px 0;
                font-weight: 600;
                color: #334155 !important;
                display: flex; justify-content: space-between; align-items: center;
            }
            .nav-link.active { color: #1e5631 !important; }
            .nav-link::after {
                font-family: "bootstrap-icons";
                content: "\f285"; /* chevron-right */
                font-size: 14px; color: #cbd5e1;
            }
            .btn-login-mobile {
                width: 100%; margin-top: 20px; padding: 15px;
                border-radius: 12px; font-weight: 700;
                background: #1e5631; color: white; border: none;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="<?= base_url() ?>">
                <img src="<?= base_url('assets/images/LOGO/LOGOFKKMBT.jpg') ?>" class="rounded-circle shadow-sm">
                <span>FKKMBT</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mobileMenu">
                <i class="bi bi-list fs-1 text-white"></i>
            </button>

            <div class="collapse navbar-collapse" id="mobileMenu">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?= ($this->uri->segment(1) == '' ? 'active' : '') ?>" href="<?= base_url() ?>">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($this->uri->segment(1) == 'tentang' ? 'active' : '') ?>" href="<?= base_url('tentang') ?>">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($this->uri->segment(1) == 'kegiatan' ? 'active' : '') ?>" href="<?= base_url('kegiatan') ?>">Kegiatan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($this->uri->segment(1) == 'warga' ? 'active' : '') ?>" href="<?= base_url('warga') ?>">Direktori Warga</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($this->uri->segment(1) == 'struktur' ? 'active' : '') ?>" href="<?= base_url('struktur') ?>">Struktur Organisasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($this->uri->segment(1) == 'iuran' ? 'active' : '') ?>" href="<?= base_url('iuran') ?>">Info Iuran</a>
                    </li>
                </ul>

                <?php if($this->session->userdata('user_id')): ?>
                <a href="<?= ($this->session->userdata('role') == 'admin') ? base_url('admin/dashboard') : base_url('user/dashboard') ?>" class="btn btn-login-mobile d-lg-none">
                    Dashboard Saya <i class="bi bi-arrow-right ms-2"></i>
                </a>
                <?php else: ?>
                <a href="<?= base_url('auth/login') ?>" class="btn btn-login-mobile d-lg-none">
                    Masuk Akun <i class="bi bi-box-arrow-in-right ms-2"></i>
                </a>
                <?php endif; ?>

                <!-- Desktop Buttons -->
                <div class="d-none d-lg-flex gap-2 ms-3">
                    <?php if($this->session->userdata('user_id')): ?>
                        <a href="<?= ($this->session->userdata('role') == 'admin') ? base_url('admin/dashboard') : base_url('user/dashboard') ?>" class="btn btn-outline-light rounded-pill px-4 fw-bold small">Dashboard</a>
                    <?php else: ?>
                        <a href="<?= base_url('auth/login') ?>" class="btn btn-outline-light rounded-pill px-4 fw-bold small">Masuk</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
