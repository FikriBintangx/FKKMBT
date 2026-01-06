<?php
session_start();
require_once 'config/database.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - FKKMBT</title>
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
    <section class="text-white py-4 py-md-5 pt-5" style="background: linear-gradient(135deg, #2d6a5f 0%, #1f5449 100%); margin-top: 56px;">
        <div class="container py-4 py-md-5 text-center">
            <h1 class="fw-bold mb-3" style="font-size: clamp(2rem, 5vw, 3.5rem);">Tentang FKKMBT</h1>
            <p class="lead opacity-75">Membangun harmoni dan sinergi di lingkungan Bukit Tiara</p>
        </div>
    </section>

    <!-- Content -->
    <section class="py-5">
        <div class="container">
            <!-- Sejarah -->
            <div class="row mb-5">
                <div class="col-12">
                    <small class="text-primary fw-bold text-uppercase mb-2 d-block"><i class="bi bi-clock-history me-2"></i>Sejarah FKKMBT</small>
                    <h3 class="fw-bold mb-4">Latar Belakang Organisasi</h3>
                    <p class="text-muted mb-3" style="font-size: 1rem; line-height: 1.7;">
                        Forum Komunikasi Koordinasi Masyarakat Bukit Tiara (FKKMBT) merupakan organisasi kemasyarakatan yang lahir dari semangat persatuan dan kebutuhan akan wadah koordinasi warga Perumahan Bukit Tiara. FKKMBT merupakan kelanjutan dan penguatan dari forum-forum komunikasi sebelumnya yang telah ada di lingkungan Bukit Tiara, dengan tujuan menyatukan berbagai elemen masyarakat dalam satu forum yang lebih terstruktur, profesional, dan berlandaskan nilai kekeluargaan.
                    </p>
                    <p class="text-muted" style="font-size: 1rem; line-height: 1.7;">
                        Sejak didirikan, FKKMBT berperan sebagai sarana komunikasi, koordinasi, dan penyalur aspirasi warga dalam upaya menciptakan lingkungan yang aman, tertib, harmonis, serta sejahtera.
                    </p>
                </div>
            </div>

            <!-- Visi & Misi -->
            <div class="row g-4 mb-5">
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100 p-4 rounded-4">
                        <div class="feature-icon-box icon-teal rounded-3 mb-3" style="width: 60px; height: 60px; font-size: 1.8rem;">
                            <i class="bi bi-eye"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Visi</h5>
                        <p class="text-muted" style="font-size: 0.95rem; line-height: 1.6;">
                            Mewujudkan masyarakat Bukit Tiara yang <strong>bersatu, harmonis, aman, dan sejahtera</strong> melalui semangat kekeluargaan, gotong royong, serta koordinasi yang berkesinambungan.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100 p-4 rounded-4">
                        <div class="feature-icon-box icon-orange rounded-3 mb-3" style="width: 60px; height: 60px; font-size: 1.8rem;">
                            <i class="bi bi-bullseye"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Misi</h5>
                        <ul class="text-muted list-unstyled" style="font-size: 0.95rem; line-height: 1.6;">
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i>Mempererat persatuan dan kesatuan antarwarga Perumahan Bukit Tiara</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i>Menyalurkan dan memperjuangkan aspirasi masyarakat secara konstruktif</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i>Meningkatkan kualitas SDM melalui pembinaan sosial kemasyarakatan</li>
                            <li><i class="bi bi-check-circle-fill text-primary me-2"></i>Menjalin kerja sama dengan pemerintah dan lembaga terkait</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Penjelasan Organisasi -->
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <img src="https://source.unsplash.com/800x600/?community,meeting" class="img-fluid rounded-4 shadow-lg" alt="FKKMBT">
                </div>
                <div class="col-lg-6">
                    <small class="text-primary fw-bold text-uppercase mb-2 d-block"><i class="bi bi-building me-2"></i>Penjelasan Organisasi</small>
                    <h3 class="fw-bold mb-4">Forum Komunikasi Koordinasi Masyarakat Bukit Tiara</h3>
                    <p class="text-muted mb-3" style="font-size: 1rem; line-height: 1.7;">
                        FKKMBT adalah wadah sosial kemasyarakatan yang bersifat <strong>terbuka, mandiri, dan bertanggung jawab</strong>.
                    </p>
                    <p class="text-muted mb-3" style="font-size: 1rem; line-height: 1.7;">
                        Organisasi ini menjadi penghubung antara warga dengan pengurus lingkungan serta pihak terkait dalam menyampaikan aspirasi, menyelesaikan permasalahan, dan melaksanakan kegiatan sosial, keagamaan, serta kemasyarakatan.
                    </p>
                    <p class="text-muted" style="font-size: 1rem; line-height: 1.7;">
                        Dengan melibatkan peran aktif RT dan RW, FKKMBT diharapkan mampu menjadi motor penggerak partisipasi masyarakat dalam menjaga persatuan, keamanan, dan kemajuan lingkungan Perumahan Bukit Tiara.
                    </p>
                </div>
            </div>
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
                <p class="mb-0">&copy; 2024 FKKMBT Bukit Tiara. Developed by Ceva_Star.</p>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
