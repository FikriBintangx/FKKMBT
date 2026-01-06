<nav class="navbar navbar-expand-lg navbar-dark bg-success sticky-top shadow" style="background: linear-gradient(to right, #16a34a, #15803d);">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center gap-3" href="dashboard.php">
            <img src="../assets/images/LOGO/LOGOFKKMBT.jpg" alt="FKKMBT Logo" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover; cursor: pointer; transition: transform 0.3s;" data-bs-toggle="modal" data-bs-target="#logoModal" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
            <span class="fs-5">FKKMBT <small class="opacity-75">Admin</small></span>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="adminNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 fw-medium gap-lg-3">
                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active fw-bold' : '' ?>" href="dashboard.php">
                        <i class="bi bi-speedometer2 me-1"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'warga.php' ? 'active fw-bold' : '' ?>" href="warga.php">
                        <i class="bi bi-people me-1"></i> Warga
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'kelola_warga.php' ? 'active fw-bold' : '' ?>" href="kelola_warga.php">
                        <i class="bi bi-person-plus me-1"></i> Kelola Warga
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'organisasi.php' ? 'active fw-bold' : '' ?>" href="organisasi.php">
                        <i class="bi bi-diagram-3 me-1"></i> Organisasi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'kegiatan.php' ? 'active fw-bold' : '' ?>" href="kegiatan.php">
                        <i class="bi bi-calendar-event me-1"></i> Kegiatan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'iuran.php' ? 'active fw-bold' : '' ?>" href="iuran.php">
                        <i class="bi bi-wallet2 me-1"></i> Iuran
                    </a>
                </li>
            </ul>
            <div class="ms-lg-3 border-start border-white border-opacity-25 ps-lg-3 d-flex align-items-center gap-2 mt-3 mt-lg-0">
                <span class="text-white-50 small d-none d-lg-block">Hi, Admin</span>
                <a href="../logout.php" class="btn btn-sm btn-danger rounded-pill px-3">
                    Logout <i class="bi bi-box-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</nav>
