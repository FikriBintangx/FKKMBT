<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Dashboard Warga - FKKMBT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/mobile.css?v='.time()) ?>">
</head>
<body class="bg-light">

    <!-- Mobile App Bar -->
    <div class="app-bar d-lg-none">
        <div class="d-flex align-items-center gap-2">
            <img src="<?= base_url('assets/images/LOGO/LOGOFKKMBT.jpg') ?>" alt="Logo" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
            <span class="fw-bold">FKKMBT</span>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= base_url('user/notifikasi') ?>" class="text-white position-relative">
                <i class="bi bi-bell-fill fs-5"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light" style="font-size: 0.5rem; padding: 0.2rem 0.35rem;">3</span>
            </a>
        </div>
    </div>

    <!-- Desktop Navbar (Hidden on Mobile) -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top d-none d-lg-block" style="background: linear-gradient(135deg, #2d6a5f 0%, #1f5449 100%);">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-3" href="<?= base_url('user/dashboard') ?>">
                <span class="fw-bold fs-4">FKKMBT Warga</span>
            </a>
            <div class="collapse navbar-collapse" id="navUser">
                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    <li class="nav-item"><a class="nav-link active" href="<?= base_url('user/dashboard') ?>">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('user/iuran') ?>">Iuran Saya</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('user/lapor') ?>">Laporan</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('user/surat') ?>">E-Surat</a></li>
                    <li class="nav-item"><a class="nav-link text-warning fw-bold" href="<?= base_url('user/lapak') ?>"><i class="bi bi-shop me-1"></i>Lapak</a></li>
                    <li class="nav-item">
                        <a class="btn btn-outline-light btn-sm" href="<?= base_url('auth/logout') ?>">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container py-3">

        <!-- Welcome Section -->
        <section class="mb-4">
            <?php 
            $sapaan = (isset($warga['jenis_kelamin']) && $warga['jenis_kelamin'] == 'P') ? 'Kak' : 'Mas';
            $display_name = explode('@', $this->session->userdata('username'))[0];
            ?>
            <h2 class="mb-1">Halo, <?= $sapaan ?> <?= $display_name ?>! 👋</h2>
            <p class="text-muted small mb-0">Semoga harimu menyenangkan di Bukit Tiara.</p>
        </section>

        <!-- Quick Access Grid -->
        <section class="quick-grid">
            <a href="<?= base_url('user/iuran') ?>" class="quick-item">
                <div class="quick-icon" style="background: var(--secondary-gradient);">
                    <i class="bi bi-wallet2"></i>
                </div>
                <span class="quick-label">Bayar<br>Iuran</span>
            </a>
            <a href="<?= base_url('user/lapor') ?>" class="quick-item">
                <div class="quick-icon" style="background: var(--danger-gradient);">
                    <i class="bi bi-megaphone"></i>
                </div>
                <span class="quick-label">Lapor<br>Warga</span>
            </a>
            <a href="<?= base_url('user/surat') ?>" class="quick-item">
                <div class="quick-icon" style="background: var(--primary-gradient);">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
                <span class="quick-label">Surat<br>Digital</span>
            </a>
            <a href="<?= base_url('user/lapak') ?>" class="quick-item">
                <div class="quick-icon" style="background: var(--warning-gradient);">
                    <i class="bi bi-shop"></i>
                </div>
                <span class="quick-label">Lapak<br>Warga</span>
            </a>
            <a href="<?= base_url('user/voting') ?>" class="quick-item">
                <div class="quick-icon" style="background: #8b5cf6;">
                    <i class="bi bi-box-seam"></i>
                </div>
                <span class="quick-label">E-Voting<br>Warga</span>
            </a>
            <a href="<?= base_url('user/forum') ?>" class="quick-item">
                <div class="quick-icon" style="background: #10b981;">
                    <i class="bi bi-chat-dots"></i>
                </div>
                <span class="quick-label">Forum<br>Warga</span>
            </a>
            <a href="<?= base_url('user/panic') ?>" class="quick-item">
                <div class="quick-icon" style="background: #ef4444;">
                    <i class="bi bi-broadcast"></i>
                </div>
                <span class="quick-label">Tombol<br>SOS</span>
            </a>
            <a href="<?= base_url('user/chatbot') ?>" class="quick-item">
                <div class="quick-icon" style="background: #6366f1;">
                    <i class="bi bi-robot"></i>
                </div>
                <span class="quick-label">Tanya<br>AI</span>
            </a>
        </section>

        <!-- Dynamic Info Cards -->
        <div class="row g-3 mb-4">
            <div class="col-12">
                <div class="card bg-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="mb-0">Status Iuran</h5>
                            <span class="badge bg-<?= ($unpaid > 0) ? 'danger' : 'success' ?>-subtle text-<?= ($unpaid > 0) ? 'danger' : 'success' ?>">
                                <?= ($unpaid > 0) ? 'Ada Tagihan' : 'Lunas' ?>
                            </span>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                <i class="bi <?= $icon_class ?> fs-4 <?= $status_class ?>"></i>
                            </div>
                            <div>
                                <h4 class="mb-0"><?= $status_iuran ?></h4>
                                <small class="text-muted"><?= $status_desc ?></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-6">
                <div class="card h-100">
                    <div class="card-body text-center py-3">
                        <div class="text-muted small mb-1">Kas Warga</div>
                        <div class="fw-bold text-dark">Rp <?= number_format($total_kas, 0, ',', '.') ?></div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card h-100">
                    <div class="card-body text-center py-3">
                        <div class="text-muted small mb-1">Agenda</div>
                        <div class="fw-bold text-dark"><?= $kegiatan_count ?> Kegiatan</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Announcements / News Section -->
        <section class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">Berita & Kegiatan</h4>
                <a href="<?= base_url('kegiatan') ?>" class="text-primary text-decoration-none small fw-bold">Lihat Semua</a>
            </div>
            
            <div class="snap-scroller">
                <?php if(!empty($news)): ?>
                    <?php foreach($news as $row): ?>
                    <div class="snap-item">
                        <div class="card h-100 shadow-sm border-0 overflow-hidden">
                            <img src="<?= (!empty($row['foto'])) ? base_url('assets/images/kegiatan/' . $row['foto']) : 'https://via.placeholder.com/400x200' ?>" class="card-img-top" alt="..." style="height: 120px; object-fit: cover;">
                            <div class="card-body p-3">
                                <small class="text-primary fw-bold"><?= date('d M Y', strtotime($row['created_at'])) ?></small>
                                <h6 class="card-title fw-bold mt-1 mb-2 text-truncate-2"><?= $row['judul'] ?></h6>
                                <a href="<?= base_url('kegiatan/detail/'.$row['id']) ?>" class="btn btn-light btn-sm w-100">Baca</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="snap-item w-100">
                        <div class="card bg-light border-0">
                            <div class="card-body text-center py-4">
                                <p class="text-muted mb-0">Belum ada berita terbaru.</p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Agenda Section -->
        <section class="mb-5">
            <h4 class="mb-3">Agenda Terdekat</h4>
            <?php if(!empty($agenda)): ?>
                <?php foreach($agenda as $ag): ?>
                <div class="card mb-2">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="text-center p-2 rounded bg-primary-subtle text-primary" style="min-width: 50px;">
                            <div class="small fw-bold lh-1"><?= strtoupper(date('M', strtotime($ag['tanggal']))) ?></div>
                            <div class="fs-4 fw-bold"><?= date('d', strtotime($ag['tanggal'])) ?></div>
                        </div>
                        <div>
                            <h6 class="mb-1 text-dark fw-bold"><?= $ag['judul'] ?></h6>
                            <div class="small text-muted">
                                <i class="bi bi-geo-alt me-1"></i>Halaman Warga
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center py-3">
                    <p class="text-muted">Tidak ada agenda mendatang.</p>
                </div>
            <?php endif; ?>
        </section>

    </main>

    <!-- Native Bottom Nav -->
    <?php $this->load->view('templates/mobile_nav'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .text-truncate-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</body>
</html>
