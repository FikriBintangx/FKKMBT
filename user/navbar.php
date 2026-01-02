<?php
// Ensure $warga is available
$current_page = basename($_SERVER['PHP_SELF'], '.php');
$warga_nav = $warga ?? []; 
if(empty($warga_nav) && isset($_SESSION['user_id'])) {
    // Fallback fetch if not provided
    global $conn;
    if($conn) {
        $uid_nav = $_SESSION['user_id'];
        $warga_nav = $conn->query("SELECT * FROM warga WHERE user_id = $uid_nav")->fetch_assoc();
    }
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-success fixed-top shadow-sm py-3">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand fw-bold d-flex align-items-center gap-3" href="dashboard.php">
            <img src="../assets/images/LOGO/LOGOFKKMBT.jpg" alt="FKKMBT Logo" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover; cursor: pointer; transition: transform 0.3s;" data-bs-toggle="modal" data-bs-target="#logoModal" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
            <span class="fs-5">FKKMBT</span>
        </a>

        <!-- Mobile Toggle -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu Items -->
        <div class="collapse navbar-collapse justify-content-center" id="navContent">
            <ul class="navbar-nav gap-1 gap-lg-4 text-center mt-3 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'dashboard' ? 'active fw-bold' : '' ?>" href="dashboard.php">
                        <i class="bi bi-speedometer2 me-1"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'kegiatan' ? 'active fw-bold' : '' ?>" href="kegiatan.php">
                        <i class="bi bi-calendar-event me-1"></i> Kegiatan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'struktur' ? 'active fw-bold' : '' ?>" href="struktur.php">
                        <i class="bi bi-diagram-3 me-1"></i> Struktur
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'warga' ? 'active fw-bold' : '' ?>" href="warga.php">
                        <i class="bi bi-people me-1"></i> Warga
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'iuran' ? 'active fw-bold' : '' ?>" href="iuran.php">
                        <i class="bi bi-wallet2 me-1"></i> Iuran
                    </a>
                </li>
            </ul>
        </div>

        <!-- User Profile (Right) -->
        <div class="collapse navbar-collapse justify-content-end" id="navProfile">
             <div class="dropdown text-center text-lg-end mt-3 mt-lg-0">
                <a href="#" class="d-flex align-items-center justify-content-center justify-content-lg-end gap-2 text-decoration-none dropdown-toggle text-white" data-bs-toggle="dropdown">
                    <div class="text-end d-none d-lg-block">
                        <span class="d-block fw-bold small"><?= isset($warga_nav['nama_lengkap']) ? explode(' ', $warga_nav['nama_lengkap'])[0] : 'User' ?></span>
                        <span class="d-block small opacity-75" style="font-size: 10px;">Warga</span>
                    </div>
                    <?php if(!empty($warga_nav['foto'])): ?>
                        <img src="../assets/images/warga/<?= $warga_nav['foto'] ?>" class="rounded-circle object-fit-cover border border-2 border-white" style="width: 38px; height: 38px;">
                    <?php else: ?>
                        <div class="bg-white text-success rounded-circle d-flex align-items-center justify-content-center fw-bold border border-2 border-white" style="width: 38px; height: 38px;">
                            <?= isset($warga_nav['nama_lengkap']) ? substr($warga_nav['nama_lengkap'],0,1) : 'U' ?>
                        </div>
                    <?php endif; ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-2">
                    <li><a class="dropdown-item py-2" href="profil.php"><i class="bi bi-person-circle me-2 text-secondary"></i> Profil Saya</a></li>
                    <li><a class="dropdown-item py-2" href="ganti_password.php"><i class="bi bi-key me-2 text-warning"></i> Ganti Password</a></li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li><a class="dropdown-item py-2 text-danger" href="../logout.php"><i class="bi bi-box-arrow-right me-2"></i> Keluar</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Bottom Nav (IOS Style) -->
<nav class="d-lg-none fixed-bottom bg-white border-top shadow-lg pb-safe-area" style="z-index: 1040;">
    <div class="d-flex justify-content-around py-2">
        <a href="dashboard.php" class="text-decoration-none d-flex flex-column align-items-center text-secondary <?= $current_page == 'dashboard' ? 'text-success fw-bold' : '' ?>">
            <i class="bi bi-grid-fill fs-5 mb-1"></i>
            <span style="font-size: 10px;">Home</span>
        </a>
        <a href="kegiatan.php" class="text-decoration-none d-flex flex-column align-items-center text-secondary <?= $current_page == 'kegiatan' ? 'text-success fw-bold' : '' ?>">
            <i class="bi bi-calendar-event fs-5 mb-1"></i>
            <span style="font-size: 10px;">Kegiatan</span>
        </a>
        <a href="warga.php" class="text-decoration-none d-flex flex-column align-items-center text-secondary <?= $current_page == 'warga' ? 'text-success fw-bold' : '' ?>">
            <i class="bi bi-people fs-5 mb-1"></i>
            <span style="font-size: 10px;">Warga</span>
        </a>
        <a href="iuran.php" class="text-decoration-none d-flex flex-column align-items-center text-secondary <?= $current_page == 'iuran' ? 'text-success fw-bold' : '' ?>">
            <i class="bi bi-wallet2 fs-5 mb-1"></i>
            <span style="font-size: 10px;">Iuran</span>
        </a>
         <a href="profil.php" class="text-decoration-none d-flex flex-column align-items-center text-secondary <?= $current_page == 'profil' ? 'text-success fw-bold' : '' ?>">
            <i class="bi bi-person-circle fs-5 mb-1"></i>
            <span style="font-size: 10px;">Profil</span>
        </a>
    </div>
</nav>
