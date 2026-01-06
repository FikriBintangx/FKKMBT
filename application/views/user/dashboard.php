<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Warga - FKKMBT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/mobile.css') ?>">
</head>
<body>

    <!-- Navbar Replacement -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background: linear-gradient(135deg, #2d6a5f 0%, #1f5449 100%);">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-3" href="<?= base_url('user/dashboard') ?>">
                <span class="fw-bold fs-4">FKKMBT Warga</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navUser">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navUser">
                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    <li class="nav-item"><a class="nav-link active" href="<?= base_url('user/dashboard') ?>">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('user/iuran') ?>">Iuran Saya</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('user/lapor') ?>">Laporan</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('user/surat') ?>">E-Surat</a></li>
                    <li class="nav-item"><a class="nav-link text-warning fw-bold" href="<?= base_url('user/lapak') ?>"><i class="bi bi-shop me-1"></i>Lapak</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('user/voting') ?>"><i class="bi bi-box-seam me-1"></i>E-Voting</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('user/forum') ?>"><i class="bi bi-chat-dots me-1"></i>Forum</a></li>
                    <li class="nav-item">
                        <a class="btn btn-outline-light btn-sm" href="<?= base_url('auth/logout') ?>">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content container py-4 mt-5 pt-5">

        <!-- Header -->
        <header class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <?php 
                $sapaan = (isset($warga['jenis_kelamin']) && $warga['jenis_kelamin'] == 'P') ? 'Kak' : 'Mas';
                $display_name = explode('@', $this->session->userdata('username'))[0];
                ?>
                <h2 class="fw-bold mb-1">Selamat Datang, <?= $sapaan ?> <?= $display_name ?></h2>
                <p class="text-muted"><i class="bi bi-calendar4 me-2"></i> <?= date('l, d F Y') ?></p>
            </div>
            <div class="d-flex gap-3">
                <button class="btn btn-light rounded-circle shadow-sm p-2" style="width: 45px; height: 45px;"><i class="bi bi-bell"></i></button>
                <a href="<?= base_url('user/chatbot') ?>" class="btn btn-success shadow-sm d-flex align-items-center gap-2 rounded-pill px-3">
                    <i class="bi bi-robot"></i> Tanya Pak RT
                </a>
                <a href="<?= base_url('user/panic') ?>" class="btn btn-danger shadow-sm d-flex align-items-center gap-2 rounded-pill px-4 blink-anim">
                    <i class="bi bi-broadcast"></i> SOS
                </a>
            </div>
        </header>

        <!-- Stats Row with Enhanced Design -->
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card border-0 h-100 overflow-hidden position-relative" style="border-radius: 20px; transition: all 0.3s;">
                    <!-- Gradient Background -->
                    <div class="position-absolute w-100 h-100" style="background: linear-gradient(135deg, <?= $unpaid > 0 ? '#fee2e2' : '#d1fae5' ?> 0%, <?= $unpaid > 0 ? '#fecaca' : '#a7f3d0' ?> 100%); opacity: 0.6;"></div>
                    <div class="card-body p-4 position-relative">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <span class="text-muted fw-semibold small">Status Iuran (<?= date('M Y') ?>)</span>
                            <div class="rounded-circle p-2" style="background: white; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                                <i class="bi <?= $icon_class ?> fs-5"></i>
                            </div>
                        </div>
                        <h3 class="fw-bold <?= $status_class ?> mb-2"><?= $status_iuran ?></h3>
                        <small class="text-muted fw-medium"><?= $status_desc ?></small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 h-100 overflow-hidden position-relative stat-card-hover" style="border-radius: 20px; background: linear-gradient(135deg, #2d6a5f 0%, #1f5449 100%); transition: all 0.3s;">
                    <div class="card-body p-4 position-relative text-white">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <span class="fw-semibold small opacity-90">Total Kas Warga</span>
                            <div class="rounded-circle p-2" style="background: rgba(255,255,255,0.2); backdrop-filter: blur(10px);">
                                <i class="bi bi-piggy-bank-fill fs-5"></i>
                            </div>
                        </div>
                        <h3 class="fw-bold mb-2">Rp <?= number_format($total_kas, 0, ',', '.') ?></h3>
                        <span class="badge px-3 py-1" style="background: rgba(16, 185, 129, 0.2); color: #6ee7b7; border: 1px solid rgba(16, 185, 129, 0.3);">
                            <i class="bi bi-arrow-up me-1"></i>+2.5% dari bulan lalu
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 h-100 overflow-hidden position-relative" style="border-radius: 20px; transition: all 0.3s;">
                    <div class="position-absolute w-100 h-100" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); opacity: 0.6;"></div>
                    <div class="card-body p-4 position-relative">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <span class="text-muted fw-semibold small">Kegiatan Bulan Ini</span>
                            <div class="rounded-circle p-2" style="background: white; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                                <i class="bi bi-calendar-check-fill text-warning fs-5"></i>
                            </div>
                        </div>
                        <h3 class="fw-bold mb-2"><?= $kegiatan_count ?> Agenda</h3>
                        <small class="text-muted fw-medium">Ayo berpartisipasi!</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Left Column: Announcements -->
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold m-0">Pengumuman Terbaru</h5>
                    <a href="<?= base_url('kegiatan') ?>" class="text-primary text-decoration-none small fw-semibold">Lihat Semua →</a>
                </div>

                <?php if(!empty($news)): ?>
                    <?php foreach($news as $row): ?>
                    <div class="card border-0 shadow-sm mb-4 announcement-card-modern" style="border-radius: 20px; overflow: hidden; transition: all 0.3s;">
                        <div class="row g-0">
                            <div class="col-md-4 position-relative overflow-hidden">
                                <?php 
                                $local_path = 'assets/images/kegiatan/' . $row['foto'];
                                // Simple check, ideally use file_exists with FCPATH
                                $display_img = (!empty($row['foto'])) ? base_url($local_path) : 'https://via.placeholder.com/400x300/134e4a/ffffff?text=Kegiatan';
                                ?>
                                <img src="<?= $display_img ?>" class="w-100 h-100" alt="<?= htmlspecialchars($row['judul']) ?>" style="object-fit: cover; min-height: 220px;">
                                <div class="position-absolute top-0 start-0 m-3">
                                    <span class="badge px-3 py-2" style="background: rgba(45, 106, 95, 0.9); backdrop-filter: blur(10px); border-radius: 10px;">
                                        <i class="bi bi-megaphone-fill me-1"></i>KEGIATAN
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center gap-2 mb-3">
                                        <i class="bi bi-clock text-muted"></i>
                                        <small class="text-muted fw-medium"><?= date('d M Y', strtotime($row['created_at'])) ?></small>
                                    </div>
                                    <h5 class="card-title fw-bold mb-3" style="color: #1f2937;"><?= $row['judul'] ?></h5>
                                    <p class="card-text text-muted mb-4" style="line-height: 1.6;"><?= substr($row['deskripsi'], 0, 120) ?>...</p>
                                    <a href="<?= base_url('kegiatan/detail/'.$row['id']) ?>" class="btn btn-outline-primary btn-sm rounded-pill px-4 fw-semibold">
                                        Baca Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="card border-0 shadow-sm text-center py-5" style="border-radius: 20px;">
                        <i class="bi bi-megaphone display-1 text-muted opacity-25 mb-3"></i>
                        <p class="text-muted mb-0">Belum ada pengumuman terbaru.</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Right Column: Agenda & Quick Access -->
            <div class="col-lg-4">
                <h5 class="fw-bold mb-4">Agenda Mendatang</h5>
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px; overflow: hidden;">
                    <div class="card-body p-4">
                        <?php if(!empty($agenda)): ?>
                            <?php foreach($agenda as $ag): ?>
                            <div class="d-flex align-items-start gap-3 mb-3 pb-3 border-bottom">
                                <div class="flex-shrink-0 text-center p-2 rounded-3" style="background: linear-gradient(135deg, #2d6a5f 0%, #1f5449 100%); min-width: 60px;">
                                    <div class="text-white opacity-75 small fw-bold"><?= strtoupper(date('M', strtotime($ag['tanggal']))) ?></div>
                                    <div class="text-white fw-bold fs-4"><?= date('d', strtotime($ag['tanggal'])) ?></div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-1" style="color: #1f2937;"><?= $ag['judul'] ?></h6>
                                    <small class="text-muted"><i class="bi bi-geo-alt-fill me-1"></i>Halaman Warga</small><br>
                                    <small class="text-muted"><i class="bi bi-clock-fill me-1"></i>08:00 WIB</small>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <div class="mt-3">
                                <a href="<?= base_url('kegiatan') ?>" class="btn btn-outline-primary btn-sm w-100 rounded-pill fw-semibold">
                                    <i class="bi bi-calendar-week me-2"></i>Lihat Kalender Lengkap
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="bi bi-calendar-x display-6 text-muted opacity-25 mb-2"></i>
                                <p class="text-muted small mb-0">Tidak ada agenda mendatang</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <h5 class="fw-bold mb-4">Akses Cepat</h5>
                <div class="row g-3">
                    <div class="col-6">
                        <a href="<?= base_url('user/iuran') ?>" class="card border-0 shadow-sm text-decoration-none quick-card-modern" style="border-radius: 16px; transition: all 0.3s;">
                            <div class="card-body p-3 text-center">
                                <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                                    <i class="bi bi-wallet2 fs-4 text-white"></i>
                                </div>
                                <span class="fw-bold small d-block" style="color: #1f2937;">Bayar Iuran</span>
                            </div>
                        </a>
                    </div>
                    </div>
                    <div class="col-6">
                        <a href="<?= base_url('user/lapor') ?>" class="card border-0 shadow-sm text-decoration-none quick-card-modern" style="border-radius: 16px; transition: all 0.3s;">
                            <div class="card-body p-3 text-center">
                                <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);">
                                    <i class="bi bi-megaphone-fill fs-4 text-white"></i>
                                </div>
                                <span class="fw-bold small d-block" style="color: #1f2937;">Lapor Warga</span>
                            </div>
                    <div class="col-6">
                        <a href="<?= base_url('user/lapak') ?>" class="card border-0 shadow-sm text-decoration-none quick-card-modern" style="border-radius: 16px; transition: all 0.3s;">
                            <div class="card-body p-3 text-center">
                                <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);">
                                    <i class="bi bi-basket-fill fs-4 text-white"></i>
                                </div>
                                <span class="fw-bold small d-block" style="color: #1f2937;">Belanja Warga</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .stat-card-hover:hover {
                transform: translateY(-5px);
                box-shadow: 0 20px 40px rgba(45, 106, 95, 0.3) !important;
            }
            .announcement-card-modern:hover {
                transform: translateY(-4px);
                box-shadow: 0 12px 30px rgba(0,0,0,0.12) !important;
            }
            .quick-card-modern:hover {
                transform: translateY(-3px);
                box-shadow: 0 8px 20px rgba(0,0,0,0.15) !important;
            }
            @keyframes blink-red { 0% { opacity: 1; } 50% { opacity: 0.7; } 100% { opacity: 1; } }
            .blink-anim { animation: blink-red 2s infinite; }
        </style>
    </main>

<!-- Quick Access Modal (Lapor Warga) -->
<div class="modal fade" id="laporModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 card-bubble p-0">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="modal-title fw-bold">Lapor Masalah / Pengaduan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="<?= base_url('user/lapor/submit') ?>" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold ms-2">JENIS LAPORAN</label>
                        <select class="form-select form-control-bubble" name="jenis_laporan" required>
                            <option value="">Pilih Kategori...</option>
                            <option value="keamanan">Keamanan (Security)</option>
                            <option value="kebersihan">Kebersihan / Sampah</option>
                            <option value="infrastruktur">Infrastruktur Jalan/Fasilitas</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold ms-2">JUDUL LAPORAN</label>
                        <input type="text" class="form-control form-control-bubble" name="judul" placeholder="Contoh: Lampu Jalan Mati" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold ms-2">DESKRIPSI DETAIL</label>
                        <textarea class="form-control form-control-bubble" name="isi" rows="4" style="border-radius: 20px;" placeholder="Jelaskan masalah secara rinci..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold ms-2">FOTO BUKTI (OPSIONAL)</label>
                        <input type="file" class="form-control form-control-bubble" name="foto">
                    </div>
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-bubble shadow-sm">Kirim Laporan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
