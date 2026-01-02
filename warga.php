<?php
session_start();
require_once 'config/database.php';

// Search & Filter
$search = $_GET['search'] ?? '';
$blok_filter = $_GET['blok'] ?? '';

$where = "WHERE 1=1";
if ($search) {
    $s = $conn->real_escape_string($search);
    $where .= " AND (nama_lengkap LIKE '%$s%' OR no_rumah LIKE '%$s%')";
}
if ($blok_filter) {
    $b = $conn->real_escape_string($blok_filter);
    $where .= " AND blok = '$b'";
}

// Pagination setup could go here, but keeping it simple for now
$sql = "SELECT * FROM warga $where ORDER BY blok ASC, no_rumah ASC LIMIT 50";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Direktori Warga - FKKMBT</title>
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
            <h1 class="display-4 fw-bold">Direktori Warga</h1>
            <p class="lead opacity-75">Data warga Perumahan Bukit Tiara</p>
        </div>
    </section>

    <!-- Content -->
    <section class="py-5">
        <div class="container">
            <!-- Block Selector Grid with Grouping -->
            <div class="card border-0 shadow-sm p-4 mb-4 rounded-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-grid-3x3-gap me-2"></i>Pilih Blok</h5>
                
                <!-- Semua Button -->
                <div class="mb-3">
                    <a href="?blok=" class="btn <?= empty($blok_filter) ? 'btn-success' : 'btn-outline-secondary' ?> rounded-pill">
                        <i class="bi bi-house-door-fill me-2"></i>Semua Blok
                    </a>
                </div>

                <!-- Accordion for Block Groups -->
                <div class="accordion" id="blokAccordion">
                    <?php 
                    foreach(range('A','T') as $letter) {
                        $is_active_group = !empty($blok_filter) && substr($blok_filter, 0, 1) == $letter;
                    ?>
                    <div class="accordion-item border-0 mb-2">
                        <h2 class="accordion-header">
                            <button class="accordion-button <?= $is_active_group ? '' : 'collapsed' ?> rounded-3 shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $letter ?>" style="background: <?= $is_active_group ? 'linear-gradient(135deg, #2d6a5f 0%, #1f5449 100%)' : '#f8f9fa' ?>; color: <?= $is_active_group ? 'white' : '#333' ?>;">
                                <i class="bi bi-buildings me-2"></i>
                                <strong>Blok <?= $letter ?></strong>
                                <span class="ms-2 badge bg-white text-dark"><?= $letter ?>1 - <?= $letter ?>5</span>
                            </button>
                        </h2>
                        <div id="collapse<?= $letter ?>" class="accordion-collapse collapse <?= $is_active_group ? 'show' : '' ?>" data-bs-parent="#blokAccordion">
                            <div class="accordion-body p-3 bg-light rounded-bottom-3">
                                <div class="row g-2">
                                    <?php for($num = 1; $num <= 5; $num++): 
                                        $blok_code = $letter . $num;
                                    ?>
                                    <div class="col-4 col-md-2">
                                        <a href="?blok=<?= $blok_code ?>" class="btn w-100 <?= $blok_filter == $blok_code ? 'btn-primary' : 'btn-outline-primary' ?> rounded-3">
                                            <i class="bi bi-house-fill mb-1 d-block"></i>
                                            <small class="fw-bold"><?= $blok_code ?></small>
                                        </a>
                                    </div>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="card border-0 shadow-sm p-3 mb-4 rounded-4">
                <form action="" method="GET" class="row g-2 align-items-center">
                    <input type="hidden" name="blok" value="<?= htmlspecialchars($blok_filter) ?>">
                    <div class="col-md-10">
                        <input type="text" name="search" class="form-control" placeholder="🔍 Cari nama warga..." value="<?= htmlspecialchars($search) ?>">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Cari</button>
                    </div>
                </form>
            </div>

            <!-- Warga Cards Grid -->
            <div class="row g-4">
                <?php if($result && $result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card border-0 shadow-sm h-100 hover-lift" style="transition: all 0.3s ease; border-radius: 16px; overflow: hidden;">
                                <!-- Card Header with Avatar -->
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center gap-3 mb-3">
                                        <div class="avatar-circle" style="width: 56px; height: 56px; background: linear-gradient(135deg, #2d6a5f 0%, #1f5449 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; font-weight: bold; box-shadow: 0 4px 12px rgba(45, 106, 95, 0.3);">
                                            <?= strtoupper(substr($row['nama_lengkap'], 0, 1)) ?>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h5 class="mb-1 fw-bold" style="color: #1f2937; font-size: 1.1rem;"><?= $row['nama_lengkap'] ?></h5>
                                            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1" style="font-size: 0.75rem;">
                                                <i class="bi bi-check-circle-fill me-1"></i>Warga Aktif
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- Address Info -->
                                    <div class="info-box p-3 rounded-3" style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); border-left: 4px solid #2d6a5f;">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-geo-alt-fill text-primary" style="font-size: 1.2rem;"></i>
                                            <div>
                                                <small class="text-muted d-block" style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.5px;">Alamat</small>
                                                <strong class="text-dark" style="font-size: 0.95rem;">
                                                    Blok<?= $row['blok'] ?> Nomer <?= $row['no_rumah'] ?>
                                                </strong>
                                            </div>
                                        </div>
                                    </div>

                                    <?php if(!empty($row['no_hp'])): ?>
                                    <!-- Contact Info -->
                                    <div class="mt-3">
                                        <a href="https://wa.me/<?= $row['no_hp'] ?>" target="_blank" class="btn btn-outline-success btn-sm w-100 rounded-pill" style="font-weight: 600;">
                                            <i class="bi bi-whatsapp me-2"></i>Hubungi Warga
                                        </a>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="bi bi-people display-1 text-muted opacity-25"></i>
                            </div>
                            <h4 class="text-muted mb-2">Data Warga Tidak Ditemukan</h4>
                            <p class="text-muted">Coba gunakan filter atau pencarian lain</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <style>
                .hover-lift:hover {
                    transform: translateY(-8px);
                    box-shadow: 0 12px 24px rgba(0,0,0,0.15) !important;
                }
                .avatar-circle {
                    position: relative;
                }
                .avatar-circle::after {
                    content: '';
                    position: absolute;
                    bottom: -2px;
                    right: -2px;
                    width: 18px;
                    height: 18px;
                    background: #10b981;
                    border: 3px solid white;
                    border-radius: 50%;
                }
            </style>
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
                    <p class="text-muted">Forum Komunikasi Koordinasi Masyarakat Bukit Tiara - Membangun komunitas yang harmonis, sejahtera, dan saling mendukung.</p>
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
                    <p class="text-muted mb-2">
                        <i class="bi bi-geo-alt me-2"></i>
                        Perumahan Bukit Tiara, Kecamatan Cikupa, Kabupaten Tangerang, Banten 15710
                    </p>
                    <p class="text-muted mb-2">
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
