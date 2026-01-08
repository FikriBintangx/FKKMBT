<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Dashboard Warga - FKKMBT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/mobile.css?v='.time()) ?>">
    <style>
        body {
            padding-top: 0 !important;
            margin-top: 0 !important;
        }
        .hero-section {
            background: var(--primary-gradient);
            padding: 20px 20px 60px;
            border-radius: 0 0 40px 40px;
            color: white;
            margin-bottom: -40px;
            margin-top: 0;
        }
        .balance-card {
            background: white;
            border-radius: 24px;
            padding: 24px;
            margin: 0 10px;
            position: relative;
            z-index: 10;
            box-shadow: 0 15px 30px rgba(0,0,0,0.08);
        }
        .section-title { font-weight: 800; font-size: 1.1rem; margin-bottom: 1.25rem; color: #1e293b; }
        .text-truncate-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .feature-coming-soon { opacity: 0.6; filter: grayscale(1); position: relative; }
        .feature-coming-soon::after {
            content: "Soon";
            position: absolute;
            top: -5px; right: -5px;
            background: #64748b; color: white;
            font-size: 8px;
            padding: 2px 5px;
            border-radius: 4px;
            font-weight: bold;
        }
    </style>
</head>
<body class="bg-light">

    <!-- Mobile App Bar -->
    <div class="app-bar d-lg-none shadow-none">
        <div class="d-flex align-items-center gap-2">
            <div class="rounded-circle overflow-hidden border border-white" style="width: 32px; height: 32px;">
                <img src="<?= base_url('assets/images/LOGO/LOGOFKKMBT.jpg') ?>" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <span class="fw-bold text-white" style="letter-spacing: 0.5px; font-size: 14px;">BUKIT TIARA</span>
        </div>
        <div class="d-flex gap-3">
            <a href="<?= base_url('user/dashboard/notifikasi') ?>" class="text-white position-relative">
                <i class="bi bi-bell-fill fs-5"></i>
                <span class="notif-badge">3</span>
            </a>
            <a href="<?= base_url('user/profil') ?>" class="text-white">
                <i class="bi bi-person-circle fs-5"></i>
            </a>
        </div>
    </div>

    <!-- Hero Greeting -->
    <div class="hero-section">
        <?php 
        $sapaan = (isset($warga['jenis_kelamin']) && $warga['jenis_kelamin'] == 'P') ? 'Ibu' : 'Bapak';
        $display_name = explode('@', $this->session->userdata('username'))[0];
        ?>
        <h3 class="fw-bold mb-1">Halo, <?= $sapaan ?> <?= ucwords($display_name) ?>!</h3>
        <p class="small opacity-75 mb-0"><i class="bi bi-geo-alt-fill me-1"></i>Blok <?= $warga['blok'] ?> No. <?= $warga['no_rumah'] ?></p>
    </div>

    <!-- Balance / Pocket Card -->
    <div class="balance-card mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <small class="text-muted fw-bold d-block mb-1 text-uppercase" style="font-size: 10px; letter-spacing: 1px;">Saldo Kas Warga</small>
                <h3 class="fw-bold text-dark mb-0">Rp <?= number_format($total_kas, 0, ',', '.') ?></h3>
            </div>
            <a href="<?= base_url('user/iuran') ?>" class="btn btn-primary btn-sm rounded-pill px-3 py-2 fw-bold" style="font-size: 12px;">
                <i class="bi bi-plus-circle me-1"></i> Bayar Iuran
            </a>
        </div>
        <hr class="opacity-5 my-3">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <div class="rounded-circle <?= ($unpaid > 0) ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success' ?> d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="bi <?= ($unpaid > 0) ? 'bi-exclamation-triangle-fill' : 'bi-shield-check' ?>" style="font-size: 14px;"></i>
                </div>
                <div>
                    <div class="fw-bold" style="font-size: 11px;"><?= ($unpaid > 0) ? 'Ada Tagihan' : 'Status Iuran Aman' ?></div>
                    <div class="text-muted" style="font-size: 10px;"><?= ($unpaid > 0) ? $unpaid.' Tagihan tertunda' : 'Sudah lunas bulan ini' ?></div>
                </div>
            </div>
            <i class="bi bi-chevron-right text-muted small"></i>
        </div>
    </div>

    <main class="container py-3">
        <!-- Quick Services -->
        <section class="mb-4 mt-2">
            <h6 class="section-title">Layanan Warga</h6>
            <div class="quick-grid">
                <a href="<?= base_url('user/lapor') ?>" class="quick-item">
                    <div class="quick-icon shadow-sm bg-danger text-white border-0">
                        <i class="bi bi-megaphone-fill"></i>
                    </div>
                    <span class="quick-label">Lapor<br>Warga</span>
                </a>
                <a href="<?= base_url('user/surat') ?>" class="quick-item">
                    <div class="quick-icon shadow-sm bg-primary text-white border-0">
                        <i class="bi bi-file-earmark-text-fill"></i>
                    </div>
                    <span class="quick-label">E-Surat<br>Digital</span>
                </a>
                <a href="<?= base_url('user/lapak') ?>" class="quick-item">
                    <div class="quick-icon shadow-sm bg-warning text-dark border-0">
                        <i class="bi bi-shop"></i>
                    </div>
                    <span class="quick-label">Lapak<br>Warga</span>
                </a>
                <a href="<?= base_url('user/panic') ?>" class="quick-item">
                    <div class="quick-icon pulse shadow-sm bg-danger text-white border-0">
                        <i class="bi bi-broadcast"></i>
                    </div>
                    <span class="quick-label text-danger fw-bold">Tombol<br>SOS</span>
                </a>
                <a href="<?= base_url('user/voting') ?>" class="quick-item">
                    <div class="quick-icon shadow-sm text-white border-0" style="background-color: #8b5cf6;">
                        <i class="bi bi-box-seam-fill"></i>
                    </div>
                    <span class="quick-label">E-Voting</span>
                </a>
                <a href="<?= base_url('user/forum') ?>" class="quick-item">
                    <div class="quick-icon shadow-sm bg-success text-white border-0">
                        <i class="bi bi-chat-left-dots-fill"></i>
                    </div>
                    <span class="quick-label">Forum</span>
                </a>
                <a href="<?= base_url('user/chatbot') ?>" class="quick-item">
                    <div class="quick-icon shadow-sm text-white border-0" style="background-color: #6366f1;">
                        <i class="bi bi-robot"></i>
                    </div>
                    <span class="quick-label">Tanya AI</span>
                </a>
                <a href="#" class="quick-item feature-coming-soon" onclick="return false;">
                    <div class="quick-icon shadow-sm bg-secondary text-white border-0 opacity-50">
                         <i class="bi bi-camera-video-fill"></i>
                    </div>
                    <span class="quick-label text-muted">CCTV<br>Area</span>
                </a>
            </div>
        </section>

        <!-- News Flash Slider -->
        <section class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="section-title mb-0">Warta Bukit Tiara</h6>
                <a href="<?= base_url('kegiatan') ?>" class="text-primary text-decoration-none small fw-bold">Lihat Semua</a>
            </div>
            
            <div class="snap-scroller">
                <?php if(!empty($news)): ?>
                    <?php foreach($news as $row): ?>
                    <div class="snap-item">
                        <div class="card h-100 shadow-sm border-0 overflow-hidden">
                            <div class="position-relative">
                                <img src="<?= (!empty($row['foto'])) ? base_url('assets/images/kegiatan/' . $row['foto']) : 'https://via.placeholder.com/400x200' ?>" class="card-img-top" style="height: 140px; object-fit: cover;">
                                <div class="position-absolute top-0 end-0 m-2">
                                    <span class="badge bg-white text-dark glass py-1 px-2" style="font-size: 9px;"><?= date('d M', strtotime($row['created_at'])) ?></span>
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <h6 class="card-title fw-bold mb-2 text-truncate-2" style="font-size: 13px; line-height: 1.4;"><?= $row['judul'] ?></h6>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted" style="font-size: 11px;"><?= $row['nama_organisasi'] ?></small>
                                    <a href="<?= base_url('kegiatan/detail/'.$row['id']) ?>" class="text-primary fw-bold text-decoration-none" style="font-size: 11px;">Baca <i class="bi bi-chevron-right ms-1"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="snap-item w-100">
                        <div class="card bg-light border-0">
                            <div class="card-body text-center py-4">
                                <p class="text-muted small mb-0">Belum ada berita terbaru.</p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Upcoming Events List -->
        <section class="mb-5 pb-5">
            <h6 class="section-title">Agenda Terdekat</h6>
            <?php if(!empty($agenda)): ?>
                <?php foreach($agenda as $ag): ?>
                <div class="card mb-3 shadow-none border bg-white">
                    <div class="card-body d-flex align-items-center gap-3 p-3">
                        <div class="text-center p-2 rounded-4 bg-primary text-white" style="min-width: 55px; box-shadow: 0 8px 15px rgba(45, 106, 95, 0.2);">
                            <div class="small fw-bold opacity-75" style="font-size: 9px;"><?= strtoupper(date('M', strtotime($ag['tanggal']))) ?></div>
                            <div class="fs-4 fw-bold lh-1"><?= date('d', strtotime($ag['tanggal'])) ?></div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1 text-dark fw-bold" style="font-size: 14px;"><?= $ag['judul'] ?></h6>
                            <div class="d-flex align-items-center gap-2 text-muted" style="font-size: 11px;">
                                <span><i class="bi bi-clock me-1"></i>08:00 WIB</span>
                                <span>•</span>
                                <span><i class="bi bi-geo-alt me-1"></i>Balai Warga</span>
                            </div>
                        </div>
                        <i class="bi bi-chevron-right text-muted small ms-2"></i>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center py-4 bg-white rounded-4 border border-dashed">
                    <p class="text-muted small mb-0">Tidak ada agenda mendatang.</p>
                </div>
            <?php endif; ?>
        </section>

    </main>

    <!-- Native Bottom Nav -->
    <?php $this->load->view('templates/mobile_nav'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
