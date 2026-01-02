<?php
session_start();
require_once '../config/database.php';

// Auth Check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'warga') { 
    header("Location: ../login.php"); 
    exit; 
}
$warga = $conn->query("SELECT * FROM warga WHERE user_id = ".$_SESSION['user_id'])->fetch_assoc();

// Filter
$blok_filter = isset($_GET['blok']) ? $_GET['blok'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Warga Table Data with Filter
$sql = "SELECT * FROM warga WHERE 1=1";
if (!empty($blok_filter)) {
    $sql .= " AND blok = '" . $conn->real_escape_string($blok_filter) . "'";
}
if (!empty($search)) {
    $sql .= " AND nama_lengkap LIKE '%" . $conn->real_escape_string($search) . "%'";
}
$sql .= " ORDER BY blok, no_rumah";
$all_warga = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Warga - FKKMBT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="dashboard-container">
    <!-- Sidebar (Full Code - No Include) -->
    <!-- Navbar -->
    <?php include 'navbar.php'; ?>

    <!-- Main Content -->
    <div class="main-content container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold">Direktori Warga</h2>
                <p class="text-muted">Daftar lengkap warga perumahan untuk keperluan informasi.</p>
            </div>
        </div>

        <!-- Block Selector with Grouping -->
        <div class="card-bubble mb-4 p-4">
            <h5 class="fw-bold mb-3"><i class="bi bi-grid-3x3-gap me-2"></i>Pilih Blok</h5>
            
            <!-- Semua Button -->
            <div class="mb-3">
                <a href="?blok=" class="btn <?= empty($blok_filter) ? 'btn-success' : 'btn-outline-secondary' ?> rounded-pill btn-sm">
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
                        <button class="accordion-button <?= $is_active_group ? '' : 'collapsed' ?> rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $letter ?>" style="background: <?= $is_active_group ? 'linear-gradient(135deg, #2d6a5f 0%, #1f5449 100%)' : '#f8f9fa' ?>; color: <?= $is_active_group ? 'white' : '#333' ?>; font-size: 0.95rem;">
                            <i class="bi bi-buildings me-2"></i>
                            <strong>Blok <?= $letter ?></strong>
                            <span class="ms-2 badge bg-white text-dark"><?= $letter ?>1-<?= $letter ?>5</span>
                        </button>
                    </h2>
                    <div id="collapse<?= $letter ?>" class="accordion-collapse collapse <?= $is_active_group ? 'show' : '' ?>" data-bs-parent="#blokAccordion">
                        <div class="accordion-body p-3 bg-light rounded-bottom-3">
                            <div class="row g-2">
                                <?php for($num = 1; $num <= 5; $num++): 
                                    $blok_code = $letter . $num;
                                ?>
                                <div class="col-4 col-md-2">
                                    <a href="?blok=<?= $blok_code ?><?= !empty($search) ? '&search='.urlencode($search) : '' ?>" class="btn w-100 btn-sm <?= $blok_filter == $blok_code ? 'btn-primary' : 'btn-outline-primary' ?> rounded-3">
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
        <div class="card-bubble mb-4 py-3 px-4">
            <form action="" method="GET" class="row g-3 align-items-center">
                <input type="hidden" name="blok" value="<?= htmlspecialchars($blok_filter) ?>">
                <div class="col-md-10">
                     <div class="position-relative">
                        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        <input type="text" name="search" class="form-control form-control-bubble ps-5" placeholder="Cari nama tetangga..." value="<?= htmlspecialchars($search) ?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Cari</button>
                </div>
            </form>
        </div>

        <!-- Warga Cards Grid -->
        <div class="row g-4">
            <?php if($all_warga->num_rows > 0): ?>
                <?php while($row = $all_warga->fetch_assoc()): ?>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card-bubble h-100 hover-lift-card" style="transition: all 0.3s ease; border-radius: 16px; overflow: hidden;">
                            <!-- Card Header with Avatar -->
                            <div class="p-4">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="avatar-circle-dash" style="width: 56px; height: 56px; background: linear-gradient(135deg, #2d6a5f 0%, #1f5449 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; font-weight: bold; box-shadow: 0 4px 12px rgba(45, 106, 95, 0.3);">
                                        <?= strtoupper(substr($row['nama_lengkap'], 0, 1)) ?>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="mb-1 fw-bold" style="color: #1f2937; font-size: 1.1rem;"><?= $row['nama_lengkap'] ?></h5>
                                        <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1" style="font-size: 0.75rem;">
                                            <i class="bi bi-check-circle-fill me-1"></i>Warga Tetap
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Address Info -->
                                <div class="info-box-dash p-3 rounded-3 mb-3" style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); border-left: 4px solid #2d6a5f;">
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
                                <div class="d-flex gap-2">
                                    <a href="https://wa.me/<?= $row['no_hp'] ?>" target="_blank" class="btn btn-outline-success btn-sm flex-grow-1 rounded-pill" style="font-weight: 600;">
                                        <i class="bi bi-whatsapp me-2"></i>Chat
                                    </a>
                                    <a href="#" class="btn btn-outline-primary btn-sm flex-grow-1 rounded-pill" style="font-weight: 600;">
                                        <i class="bi bi-info-circle me-2"></i>Detail
                                    </a>
                                </div>
                                <?php else: ?>
                                <div>
                                    <a href="#" class="btn btn-outline-primary btn-sm w-100 rounded-pill" style="font-weight: 600;">
                                        <i class="bi bi-info-circle me-2"></i>Lihat Detail
                                    </a>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="card-bubble text-center py-5">
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
            .hover-lift-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 12px 24px rgba(0,0,0,0.15) !important;
            }
            .avatar-circle-dash {
                position: relative;
            }
            .avatar-circle-dash::after {
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
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
