<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'warga') {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$warga = $conn->query("SELECT * FROM warga WHERE user_id = $user_id")->fetch_assoc();
$warga_id = $warga['id'];

// Data: Kegaitan Bulan Ini
$current_month = date('m');
$kegiatan_count = $conn->query("SELECT COUNT(*) as total FROM kegiatan WHERE MONTH(tanggal) = '$current_month'")->fetch_assoc()['total'];

// Data: Iuran
$unpaid = $conn->query("SELECT COUNT(*) as total FROM iuran_master WHERE id NOT IN (SELECT iuran_id FROM pembayaran_iuran WHERE warga_id = $warga_id AND (status = 'pending' OR status = 'disetujui')) AND status='aktif'")->fetch_assoc()['total'];
$status_iuran = ($unpaid > 0) ? 'Belum Lunas' : 'LUNAS';
$status_class = ($unpaid > 0) ? 'text-danger' : 'text-success';
$icon_class = ($unpaid > 0) ? 'bi-exclamation-circle-fill text-danger' : 'bi-check-circle-fill text-success';
$status_desc = ($unpaid > 0) ? 'Ada '.$unpaid.' tagihan tertunggak' : 'Terima kasih atas partisipasi Anda';

// Data: Data Kas (Simulasi, Sum All Approved Iuran)
$total_kas = $conn->query("SELECT SUM(im.nominal) as total FROM pembayaran_iuran pi JOIN iuran_master im ON pi.iuran_id = im.id WHERE pi.status = 'disetujui'")->fetch_assoc()['total'];

// Data: Pengumuman Terbaru
$news = $conn->query("SELECT k.*, o.nama_organisasi FROM kegiatan k JOIN organisasi o ON k.organisasi_id = o.id ORDER BY k.created_at DESC LIMIT 2");

// Data: Agenda Mendatang
$agenda = $conn->query("SELECT * FROM kegiatan WHERE tanggal >= CURDATE() ORDER BY tanggal ASC LIMIT 3");

$current_page = 'dashboard';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Warga - FKKMBT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <!-- Sidebar -->
    <!-- Navbar -->
    <?php include 'navbar.php'; ?>

    <!-- Main Content -->
    <main class="main-content container py-4 mt-5 pt-5">

        <!-- Header -->
        <header class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <?php 
                $sapaan = (isset($warga['jenis_kelamin']) && $warga['jenis_kelamin'] == 'P') ? 'Kak' : 'Mas';
                ?>
                <h2 class="fw-bold mb-1">Selamat Datang, <?= $sapaan ?> <?= explode('@', $_SESSION['username'])[0] ?></h2>
                <p class="text-muted"><i class="bi bi-calendar4 me-2"></i> <?= date('l, d F Y') ?></p>
            </div>
            <div class="d-flex gap-3">
                <button class="btn btn-light rounded-circle shadow-sm p-2" style="width: 45px; height: 45px;"><i class="bi bi-bell"></i></button>
                <button class="btn btn-primary btn-bubble shadow-sm d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#laporModal">
                    <i class="bi bi-megaphone-fill"></i> Lapor Warga
                </button>
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
                    <a href="kegiatan.php" class="text-primary text-decoration-none small fw-semibold">Lihat Semua →</a>
                </div>

                <?php if($news->num_rows > 0): ?>
                    <?php while($row = $news->fetch_assoc()): ?>
                    <div class="card border-0 shadow-sm mb-4 announcement-card-modern" style="border-radius: 20px; overflow: hidden; transition: all 0.3s;">
                        <div class="row g-0">
                            <div class="col-md-4 position-relative overflow-hidden">
                                <?php 
                                $local_path = '../assets/images/kegiatan/' . $row['foto'];
                                $display_img = (!empty($row['foto']) && file_exists($local_path)) ? $local_path : 'https://via.placeholder.com/400x300/134e4a/ffffff?text=Kegiatan';
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
                                    <a href="kegiatan.php" class="btn btn-outline-primary btn-sm rounded-pill px-4 fw-semibold">
                                        Baca Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
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
                        <?php if($agenda->num_rows > 0): ?>
                            <?php while($ag = $agenda->fetch_assoc()): ?>
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
                            <?php endwhile; ?>
                            <div class="mt-3">
                                <a href="kegiatan.php" class="btn btn-outline-primary btn-sm w-100 rounded-pill fw-semibold">
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
                        <a href="iuran.php" class="card border-0 shadow-sm text-decoration-none quick-card-modern" style="border-radius: 16px; transition: all 0.3s;">
                            <div class="card-body p-3 text-center">
                                <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                                    <i class="bi bi-wallet2 fs-4 text-white"></i>
                                </div>
                                <span class="fw-bold small d-block" style="color: #1f2937;">Bayar Iuran</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="#" class="card border-0 shadow-sm text-decoration-none quick-card-modern" style="border-radius: 16px; transition: all 0.3s;">
                            <div class="card-body p-3 text-center">
                                <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                                    <i class="bi bi-exclamation-triangle fs-4 text-white"></i>
                                </div>
                                <span class="fw-bold small d-block" style="color: #1f2937;">Lapor Masalah</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="#" class="card border-0 shadow-sm text-decoration-none quick-card-modern" style="border-radius: 16px; transition: all 0.3s;">
                            <div class="card-body p-3 text-center">
                                <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                                    <i class="bi bi-telephone fs-4 text-white"></i>
                                </div>
                                <span class="fw-bold small d-block" style="color: #1f2937;">Kontak Darurat</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="warga.php" class="card border-0 shadow-sm text-decoration-none quick-card-modern" style="border-radius: 16px; transition: all 0.3s;">
                            <div class="card-body p-3 text-center">
                                <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                                    <i class="bi bi-file-earmark-text fs-4 text-white"></i>
                                </div>
                                <span class="fw-bold small d-block" style="color: #1f2937;">Dokumen Warga</span>
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
                <form action="lapor.php" method="POST" enctype="multipart/form-data">
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
                        <textarea class="form-control form-control-bubble" name="deskripsi" rows="4" style="border-radius: 20px;" placeholder="Jelaskan masalah secara rinci..." required></textarea>
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
