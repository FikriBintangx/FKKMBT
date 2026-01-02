<?php
session_start();
// Public Info Page for Iuran - No DB connection needed unless we want to show stats
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Info Iuran - FKKMBT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background: linear-gradient(135deg, #2d6a5f 0%, #1f5449 100%);">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-3" href="index.php">
                <img src="assets/images/LOGO/LOGOFKKMBT.jpg" alt="FKKMBT Logo" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover; cursor: pointer; transition: transform 0.3s;" data-bs-toggle="modal" data-bs-target="#logoModal" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                <span class="fw-bold fs-4">FKKMBT</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    <li class="nav-item"><a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>" href="index.php">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'tentang.php' ? 'active' : '' ?>" href="tentang.php">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'kegiatan.php' ? 'active' : '' ?>" href="kegiatan.php">Kegiatan</a></li>
                    <li class="nav-item"><a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'warga.php' ? 'active' : '' ?>" href="warga.php">Direktori Warga</a></li>
                    <li class="nav-item"><a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'struktur.php' ? 'active' : '' ?>" href="struktur.php">Struktur FKKMBT</a></li>
                    <li class="nav-item"><a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'iuran.php' ? 'active' : '' ?>" href="iuran.php">Iuran</a></li>
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="btn btn-outline-light" href="<?= $_SESSION['role'] == 'admin' ? 'admin/dashboard.php' : 'user/dashboard.php' ?>">
                                <i class="bi bi-speedometer2 me-2"></i>Dashboard
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="btn btn-outline-light" href="login.php">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header Section -->
    <section class="text-white py-5 pt-5" style="background: linear-gradient(135deg, #2d6a5f 0%, #1f5449 100%); margin-top: 56px;">
        <div class="container py-5 text-center">
            <h1 class="display-4 fw-bold">Informasi Iuran</h1>
            <p class="lead opacity-75">Transparansi dan kemudahan pembayaran iuran lingkungan</p>
        </div>
    </section>

    <!-- Content -->
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center g-5 mb-5">
                <div class="col-lg-6">
                    <h2 class="fw-bold mb-4">Mengapa Iuran Penting?</h2>
                    <p class="text-white-50 lead">Iuran warga adalah tulang punggung operasional lingkungan kita. Dana yang terkumpul dikelola secara transparan untuk:</p>
                    <ul class="list-unstyled text-white-50 mt-3 d-flex flex-column gap-3">
                        <li class="d-flex align-items-center gap-3">
                            <div class="bg-primary-subtle text-primary rounded-circle p-2"><i class="bi bi-shield-check"></i></div>
                            <span>Gaji Petugas Keamanan (Satpam)</span>
                        </li>
                        <li class="d-flex align-items-center gap-3">
                            <div class="bg-success-subtle text-success rounded-circle p-2"><i class="bi bi-trash"></i></div>
                            <span>Pengelolaan Sampah & Kebersihan</span>
                        </li>
                        <li class="d-flex align-items-center gap-3">
                            <div class="bg-warning-subtle text-warning rounded-circle p-2"><i class="bi bi-lightbulb"></i></div>
                            <span>Perawatan Fasilitas Umum & Lampu Jalan</span>
                        </li>
                        <li class="d-flex align-items-center gap-3">
                            <div class="bg-danger-subtle text-danger rounded-circle p-2"><i class="bi bi-heart"></i></div>
                            <span>Dana Sosial Kemasyarakatan</span>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-6">
                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-primary text-white">
                        <div class="card-body p-5 text-center">
                            <i class="bi bi-wallet2 display-1 mb-4 opacity-50"></i>
                            <h3 class="fw-bold mb-2">Sudahkah Anda Bayar Iuran?</h3>
                            <p class="opacity-75 mb-4">Cek status tagihan dan bayar iuran bulanan Anda dengan mudah melalui Dashboard Warga.</p>
                            <?php if(isset($_SESSION['user_id'])): ?>
                                <a href="user/iuran.php" class="btn btn-light text-primary fw-bold rounded-pill px-5 py-3 shadow mb-3">
                                    Bayar Sekarang <i class="bi bi-arrow-right ms-2"></i>
                                </a>
                            <?php else: ?>
                                <a href="login.php" class="btn btn-light text-primary fw-bold rounded-pill px-5 py-3 shadow mb-3">
                                    Masuk untuk Bayar <i class="bi bi-box-arrow-in-right ms-2"></i>
                                </a>
                                <div class="small opacity-75">Belum punya akun? <a href="register.php" class="text-white text-decoration-underline">Daftar disini</a></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row g-4 text-center mt-5">
                <div class="col-md-4">
                    <div class="p-4">
                        <div class="mb-3 text-primary"><i class="bi bi-1-circle display-4"></i></div>
                        <h5 class="fw-bold">Login ke Dashboard</h5>
                        <p class="text-white-50 small">Masuk menggunakan akun warga Anda.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4">
                        <div class="mb-3 text-primary"><i class="bi bi-2-circle display-4"></i></div>
                        <h5 class="fw-bold">Upload Bukti</h5>
                        <p class="text-white-50 small">Transfer ke rekening resmi dan upload bukti foto.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4">
                        <div class="mb-3 text-primary"><i class="bi bi-3-circle display-4"></i></div>
                        <h5 class="fw-bold">Verifikasi Otomatis</h5>
                        <p class="text-white-50 small">Admin akan memverifikasi dan status lunas tercatat.</p>
                    </div>
                </div>
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
                            <small>Bukit Tiara</small>
                        </div>
                    </div>
                    <p class="text-white-50">Forum Komunikasi Koordinasi Masyarakat Bukit Tiara - Membangun komunitas yang harmonis, sejahtera, dan saling mendukung.</p>
                </div>
                
                <div class="col-md-2">
                    <h6>Menu Cepat</h6>
                    <a href="tentang.php">Tentang Kami</a>
                    <a href="kegiatan.php">Kegiatan</a>
                    <a href="struktur.php">Organisasi</a>
                </div>
                
                <div class="col-md-3">
                    <h6>Organisasi</h6>
                    <a href="struktur.php?tab=fkkmbt">Struktur FKKMBT</a>
                    <a href="struktur.php?tab=fkkmmbt">Struktur FKKMMBT</a>
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
                <p class="mb-0">&copy; 2024 FKKMBT Bukit Tiara. Developed by AntiGravity.</p>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
