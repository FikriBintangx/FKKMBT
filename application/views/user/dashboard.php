<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Warga - FKKMBT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/mobile.css?v='.time()) ?>">
    <style>
        /* MOBILE NATIVE COMPACT - INLINE FOR IMMEDIATE EFFECT */
        @media (max-width: 768px) {
            * { box-sizing: border-box; }
            .container { padding: 0.25rem !important; max-width: 100% !important; }
            .main-content, main { padding-top: 55px !important; padding-bottom: 0.25rem !important; }
            .py-5, .py-4, .py-3 { padding-top: 0.25rem !important; padding-bottom: 0.25rem !important; }
            .mb-5 { margin-bottom: 0.3rem !important; }
            .mb-4 { margin-bottom: 0.25rem !important; }
            .mb-3 { margin-bottom: 0.2rem !important; }
            .row { --bs-gutter-x: 0.25rem !important; --bs-gutter-y: 0.25rem !important; margin: 0 !important; }
            .col-md-4, .col-md-6, [class*="col-"] { padding: 0.125rem !important; margin-bottom: 0.25rem !important; }
            header { padding: 0.25rem 0 !important; margin-bottom: 0.3rem !important; flex-direction: column !important; }
            header h2 { font-size: 1.1rem !important; margin: 0 !important; }
            header p { font-size: 0.7rem !important; margin: 0 !important; }
            header .d-flex.gap-3 { gap: 0.3rem !important; width: 100%; margin-top: 0.3rem !important; }
            header .btn { padding: 0.3rem 0.6rem !important; font-size: 0.7rem !important; }
            .card { border-radius: 8px !important; margin-bottom: 0.25rem !important; }
            .card-body { padding: 0.4rem !important; }
            .card h3 { font-size: 1rem !important; margin-bottom: 0.15rem !important; }
            .card h4 { font-size: 0.9rem !important; }
            .card h5 { font-size: 0.85rem !important; }
            .card p, .card small { font-size: 0.75rem !important; margin-bottom: 0.1rem !important; }
            .card .rounded-circle { width: 30px !important; height: 30px !important; }
            .card .rounded-circle i { font-size: 0.9rem !important; }
            .badge { padding: 0.15rem 0.4rem !important; font-size: 0.65rem !important; }
            .quick-card-modern .card-body { padding: 0.3rem !important; }
            .quick-card-modern .rounded-circle { width: 30px !important; height: 30px !important; }
            .quick-card-modern i { font-size: 0.9rem !important; }
            .quick-card-modern .fw-bold { font-size: 0.7rem !important; }
            .table { font-size: 0.7rem !important; }
            .table thead th { padding: 0.3rem 0.25rem !important; font-size: 0.65rem !important; }
            .table tbody td { padding: 0.3rem 0.25rem !important; }
            .navbar { padding: 0.4rem 0.5rem !important; }
            .navbar-brand { font-size: 1rem !important; }
            .nav-link { padding: 0.4rem 0.6rem !important; font-size: 0.8rem !important; }
            .btn { padding: 0.4rem 0.8rem !important; font-size: 0.8rem !important; }
            h1 { font-size: 1.3rem !important; }
            h2 { font-size: 1.1rem !important; }
            h3 { font-size: 1rem !important; }
            h4 { font-size: 0.9rem !important; }
        }
        @media (max-width: 375px) {
            .container { padding: 0.2rem !important; }
            .card-body { padding: 0.3rem !important; }
            header h2 { font-size: 1rem !important; }
        }
    </style>
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
    <main class="main-content" style="padding: 0.5rem; margin-top: 55px;">

        <!-- Header -->
        <header style="margin-bottom: 0.5rem; display: flex; flex-direction: column; gap: 0.5rem;">
            <div>
                <?php 
                $sapaan = (isset($warga['jenis_kelamin']) && $warga['jenis_kelamin'] == 'P') ? 'Kak' : 'Mas';
                $display_name = explode('@', $this->session->userdata('username'))[0];
                ?>
                <h2 style="font-size: 1.2rem; margin: 0; font-weight: 700;">Selamat Datang, <?= $sapaan ?> <?= $display_name ?></h2>
                <p style="font-size: 0.75rem; margin: 0; color: #6b7280;"><i class="bi bi-calendar4" style="font-size: 0.7rem;"></i> <?= date('d M Y') ?></p>
            </div>
            <div style="display: flex; gap: 0.4rem; flex-wrap: wrap;">
                <button class="btn btn-light" style="padding: 0.4rem; border-radius: 50%; width: 35px; height: 35px;"><i class="bi bi-bell" style="font-size: 0.9rem;"></i></button>
                <a href="<?= base_url('user/chatbot') ?>" class="btn btn-success" style="padding: 0.4rem 0.75rem; font-size: 0.75rem; border-radius: 20px;"><i class="bi bi-robot"></i> Tanya</a>
                <a href="<?= base_url('user/panic') ?>" class="btn btn-danger" style="padding: 0.4rem 0.75rem; font-size: 0.75rem; border-radius: 20px;"><i class="bi bi-broadcast"></i> SOS</a>
            </div>
        </header>

        <!-- Stats Row with Enhanced Design -->
        <div style="display: grid; grid-template-columns: 1fr; gap: 0.4rem; margin-bottom: 0.5rem;">
            <div>
                <div class="card border-0 h-100 overflow-hidden position-relative" style="border-radius: 20px; transition: all 0.3s;">
                    <!-- Gradient Background -->
                    <div class="position-absolute w-100 h-100" style="background: linear-gradient(135deg, <?= $unpaid > 0 ? '#fee2e2' : '#d1fae5' ?> 0%, <?= $unpaid > 0 ? '#fecaca' : '#a7f3d0' ?> 100%); opacity: 0.6;"></div>
                    <div style="padding: 0.5rem; position: relative;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.3rem;">
                            <span style="font-size: 0.7rem; color: #6b7280; font-weight: 600;">Status Iuran (<?= date('M Y') ?>)</span>
                            <div style="border-radius: 50%; padding: 0.3rem; background: white; box-shadow: 0 2px 8px rgba(0,0,0,0.1); width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi <?= $icon_class ?>" style="font-size: 0.9rem;"></i>
                            </div>
                        </div>
                        <h3 style="font-weight: 700; font-size: 1rem; margin-bottom: 0.2rem;" class="<?= $status_class ?>"><?= $status_iuran ?></h3>
                        <small style="font-size: 0.7rem; color: #6b7280;"><?= $status_desc ?></small>
                    </div>
                </div>
            </div>
            <div>
                <div class="card border-0" style="border-radius: 12px; background: linear-gradient(135deg, #2d6a5f 0%, #1f5449 100%);">
                    <div style="padding: 0.5rem; position: relative; color: white;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.3rem;">
                            <span style="font-size: 0.7rem; opacity: 0.9; font-weight: 600;">Total Kas Warga</span>
                            <div style="border-radius: 50%; padding: 0.3rem; background: rgba(255,255,255,0.2); width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-piggy-bank-fill" style="font-size: 0.9rem;"></i>
                            </div>
                        </div>
                        <h3 style="font-weight: 700; font-size: 1rem; margin-bottom: 0.2rem;">Rp <?= number_format($total_kas, 0, ',', '.') ?></h3>
                        <span style="background: rgba(16, 185, 129, 0.2); color: #6ee7b7; padding: 0.15rem 0.5rem; border-radius: 12px; font-size: 0.65rem;">
                            <i class="bi bi-arrow-up"></i> +2.5% dari bulan lalu
                        </span>
                    </div>
                </div>
            </div>
            <div>
                <div class="card border-0" style="border-radius: 12px; overflow: hidden; position: relative;">
                    <div class="position-absolute w-100 h-100" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); opacity: 0.6;"></div>
                    <div style="padding: 0.5rem; position: relative;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.3rem;">
                            <span style="font-size: 0.7rem; color: #6b7280; font-weight: 600;">Kegiatan Bulan Ini</span>
                            <div style="border-radius: 50%; padding: 0.3rem; background: white; box-shadow: 0 2px 8px rgba(0,0,0,0.1); width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-calendar-check-fill text-warning" style="font-size: 0.9rem;"></i>
                            </div>
                        </div>
                        <h3 style="font-weight: 700; font-size: 1rem; margin-bottom: 0.2rem;"><?= $kegiatan_count ?> Agenda</h3>
                        <small style="font-size: 0.7rem; color: #6b7280;">Ayo berpartisipasi!</small>
                    </div>
                </div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr; gap: 0.4rem; margin-bottom: 0.5rem;">
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
