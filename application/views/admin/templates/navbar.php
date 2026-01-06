<nav class="navbar navbar-expand-lg navbar-dark bg-success sticky-top shadow" style="background: linear-gradient(to right, #16a34a, #15803d);">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center gap-3" href="<?= base_url('admin/dashboard') ?>">
            <img src="<?= base_url('assets/images/LOGO/LOGOFKKMBT.jpg') ?>" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
            <span class="fs-5">FKKMBT <small class="opacity-75">Admin</small></span>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="adminNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 fw-medium gap-lg-3">
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(2) == 'dashboard' ? 'active fw-bold' : '' ?>" href="<?= base_url('admin/dashboard') ?>">
                        <i class="bi bi-speedometer2 me-1"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(2) == 'warga' ? 'active fw-bold' : '' ?>" href="<?= base_url('admin/warga') ?>">
                        <i class="bi bi-people me-1"></i> Warga
                    </a>
                </li>
                <!-- Merged Kelola Warga into Warga as per modern standard, but user had separate link? 
                     Legacy had 'warga.php' (read only?) and 'kelola_warga.php' (CRUD). 
                     I implemented CRUD in 'Warga'. Let's just point both to Warga or maybe split if requested.
                     For now, simplified to one powerful Warga page. -->
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(2) == 'organisasi' ? 'active fw-bold' : '' ?>" href="<?= base_url('admin/organisasi') ?>">
                        <i class="bi bi-diagram-3 me-1"></i> Organisasi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(2) == 'kegiatan' ? 'active fw-bold' : '' ?>" href="<?= base_url('admin/kegiatan') ?>">
                        <i class="bi bi-calendar-event me-1"></i> Kegiatan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(2) == 'pengaduan' ? 'active fw-bold' : '' ?>" href="<?= base_url('admin/pengaduan') ?>">
                        <i class="bi bi-megaphone me-1"></i> Pengaduan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(2) == 'panic' ? 'active fw-bold' : '' ?>" href="<?= base_url('admin/panic') ?>">
                        <i class="bi bi-broadcast-pin me-1"></i> SOS
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(2) == 'surat' ? 'active fw-bold' : '' ?>" href="<?= base_url('admin/surat') ?>">
                        <i class="bi bi-file-earmark-text me-1"></i> E-Surat
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(2) == 'lapak' ? 'active fw-bold' : '' ?>" href="<?= base_url('admin/lapak') ?>">
                        <i class="bi bi-shop me-1"></i> Lapak
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(2) == 'keuangan' ? 'active fw-bold' : '' ?>" href="<?= base_url('admin/keuangan') ?>">
                        <i class="bi bi-wallet2 me-1"></i> Keuangan
                    </a>
                </li>
            </ul>
            <div class="ms-lg-3 border-start border-white border-opacity-25 ps-lg-3 d-flex align-items-center gap-2 mt-3 mt-lg-0">
                <span class="text-white-50 small d-none d-lg-block">Hi, Admin</span>
                <a href="<?= base_url('auth/logout') ?>" class="btn btn-sm btn-danger rounded-pill px-3">
                    Logout <i class="bi bi-box-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</nav>
