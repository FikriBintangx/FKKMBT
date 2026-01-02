<?php
session_start();
require_once 'config/database.php';

// Fetch kegiatan from database if exists, or use dummy
$sql = "SELECT * FROM kegiatan ORDER BY tanggal DESC LIMIT 6";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kegiatan - FKKMBT</title>
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
            <h1 class="display-4 fw-bold">Kegiatan Warga</h1>
            <p class="lead opacity-75">Dokumentasi dan jadwal aktivitas di lingkungan Bukit Tiara</p>
        </div>
    </section>

    <!-- Content -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <?php
                        // Fetch gallery images for this kegiatan
                        $galeri = $conn->query("SELECT * FROM kegiatan_galeri WHERE kegiatan_id = ".$row['id']);
                        $images = [];
                        while($img = $galeri->fetch_assoc()) {
                            $images[] = $img;
                        }
                        ?>
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm hover-shadow overflow-hidden">
                                <img src="<?= !empty($row['foto']) ? 'assets/images/kegiatan/'.$row['foto'] : 'https://via.placeholder.com/800x600/16a34a/ffffff?text=Kegiatan+FKKMBT' ?>" class="card-img-top" alt="<?= $row['judul'] ?>" style="height: 200px; object-fit: cover;">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center gap-2 mb-3">
                                        <span class="badge bg-light text-primary border border-primary-subtle rounded-pill">
                                            <i class="bi bi-calendar-event me-1"></i>
                                            <?= date('d M Y', strtotime($row['tanggal'])) ?>
                                        </span>
                                    </div>
                                    <h5 class="card-title fw-bold mb-2"><?= $row['judul'] ?></h5>
                                    <p class="card-text text-muted small"><?= substr($row['deskripsi'], 0, 100) ?>...</p>
                                    <button class="btn btn-outline-primary btn-sm rounded-pill mt-2" data-bs-toggle="modal" data-bs-target="#detailModal<?= $row['id'] ?>">Selengkapnya</button>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Detail -->
                        <div class="modal fade" id="detailModal<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg">
                                    <div class="modal-header border-0 pb-0">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-0">
                                        <div class="row g-0">
                                            <!-- Image Carousel -->
                                            <div class="col-md-6">
                                                <?php if(count($images) > 0): ?>
                                                    <div id="carouselKegiatan<?= $row['id'] ?>" class="carousel slide h-100" data-bs-ride="carousel">
                                                        <div class="carousel-inner h-100">
                                                            <?php foreach($images as $idx => $img): ?>
                                                            <div class="carousel-item <?= $idx == 0 ? 'active' : '' ?>">
                                                                <?php if($img['tipe_file'] == 'video'): ?>
                                                                    <video src="assets/images/kegiatan/<?= $img['file'] ?>" class="d-block w-100" style="height: 400px; object-fit: cover;" controls></video>
                                                                <?php else: ?>
                                                                    <img src="assets/images/kegiatan/<?= $img['file'] ?>" class="d-block w-100" alt="Dokumentasi" style="height: 400px; object-fit: cover;">
                                                                <?php endif; ?>
                                                            </div>
                                                            <?php endforeach; ?>
                                                        </div>
                                                        <?php if(count($images) > 1): ?>
                                                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselKegiatan<?= $row['id'] ?>" data-bs-slide="prev">
                                                            <span class="carousel-control-prev-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                                                        </button>
                                                        <button class="carousel-control-next" type="button" data-bs-target="#carouselKegiatan<?= $row['id'] ?>" data-bs-slide="next">
                                                            <span class="carousel-control-next-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                                                        </button>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php else: ?>
                                                    <img src="<?= !empty($row['foto']) ? 'assets/images/kegiatan/'.$row['foto'] : 'https://via.placeholder.com/600x400/134e4a/ffffff?text=No+Image' ?>" class="d-block w-100" style="height: 400px; object-fit: cover;">
                                                <?php endif; ?>
                                            </div>

                                            <!-- Content -->
                                            <div class="col-md-6 p-4">
                                                <span class="badge bg-primary-subtle text-primary mb-3">FKKMBT</span>
                                                <h4 class="fw-bold mb-3"><?= $row['judul'] ?></h4>
                                                <div class="mb-3">
                                                    <small class="text-muted">
                                                        <i class="bi bi-calendar-event me-1"></i>
                                                        <?= date('d M Y', strtotime($row['tanggal'])) ?>
                                                    </small>
                                                </div>
                                                <div class="mb-3">
                                                    <h6 class="fw-bold">Deskripsi Kegiatan</h6>
                                                    <p class="text-muted"><?= nl2br($row['deskripsi']) ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <!-- Dummy Data if Empty -->
                    <?php for($i=1; $i<=3; $i++): ?>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm hover-shadow overflow-hidden">
                            <img src="https://source.unsplash.com/800x600/?gathering,community&sig=<?= $i ?>" class="card-img-top" alt="Kegiatan" style="height: 200px; object-fit: cover;">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <span class="badge bg-light text-primary border border-primary-subtle rounded-pill">
                                        <i class="bi bi-calendar-event me-1"></i>
                                        <?= date('d M Y') ?>
                                    </span>
                                </div>
                                <h5 class="card-title fw-bold mb-2">Kerja Bakti Lingkungan</h5>
                                <p class="card-text text-muted small">Kegiatan bersih-bersih rutin lingkungan blok untuk menjaga kebersihan dan kesehatan warga...</p>
                                <a href="#" class="btn btn-outline-primary btn-sm rounded-pill mt-2">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                    <?php endfor; ?>
                <?php endif; ?>
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
