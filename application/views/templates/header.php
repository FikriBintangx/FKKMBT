<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title . ' - ' : '' ?>FKKMBT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css?v='.time()) ?>">
    <style>
        /* Internal Page Adjustments */
        body {
            padding-top: 76px; /* Offset for fixed navbar */
            background-color: #f8f9fa;
        }
        .navbar {
            background: linear-gradient(135deg, #2d6a5f 0%, #1f5449 100%);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-3" href="<?= base_url() ?>">
                <img src="<?= base_url('assets/images/LOGO/LOGOFKKMBT.jpg') ?>" alt="FKKMBT Logo" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                <span class="fw-bold fs-5">FKKMBT</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    <li class="nav-item"><a class="nav-link <?= ($this->uri->segment(1) == '' ? 'active' : '') ?>" href="<?= base_url() ?>">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($this->uri->segment(1) == 'tentang' ? 'active' : '') ?>" href="<?= base_url('tentang') ?>">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($this->uri->segment(1) == 'kegiatan' ? 'active' : '') ?>" href="<?= base_url('kegiatan') ?>">Kegiatan</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($this->uri->segment(1) == 'warga' ? 'active' : '') ?>" href="<?= base_url('warga') ?>">Direktori Warga</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($this->uri->segment(1) == 'struktur' ? 'active' : '') ?>" href="<?= base_url('struktur') ?>">Struktur FKKMBT</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($this->uri->segment(1) == 'iuran' ? 'active' : '') ?>" href="<?= base_url('iuran') ?>">Iuran</a></li>
                    <?php if($this->session->userdata('user_id')): ?>
                        <li class="nav-item">
                            <a class="btn btn-outline-light btn-sm" href="<?= ($this->session->userdata('role') == 'admin') ? base_url('admin/dashboard') : base_url('user/dashboard') ?>">
                                <i class="bi bi-speedometer2 me-2"></i>Dashboard
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="btn btn-outline-light btn-sm" href="<?= base_url('auth/login') ?>">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
