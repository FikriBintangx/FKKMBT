<nav class="navbar navbar-expand-lg navbar-dark sticky-top shadow" style="background: linear-gradient(to right, #16a34a, #15803d); padding: 0.5rem 0.75rem;">
    <div class="container-fluid" style="max-width: 100%; padding: 0 1rem;">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="<?= base_url('admin/dashboard') ?>" style="gap: 0.5rem; font-size: 1rem;">
            <img src="<?= base_url('assets/images/LOGO/LOGOFKKMBT.jpg') ?>" class="rounded-circle border border-2 border-white" style="width: 35px; height: 35px; object-fit: cover;">
            <span>FKKMBT <small class="opacity-75" style="font-size: 0.75rem;">Admin</small></span>
        </a>
        
        <button class="navbar-toggler border-0 shadow-none text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminOffcanvas">
            <i class="bi bi-list fs-1"></i>
        </button>

        <div class="offcanvas offcanvas-end" tabindex="-1" id="adminOffcanvas" style="max-width: 250px;">
            <div class="offcanvas-header bg-success text-white">
                <h5 class="offcanvas-title fw-bold">Menu Admin</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body p-0">
                <ul class="navbar-nav justify-content-end flex-grow-1 p-3 gap-1">
                    <li class="nav-item">
                        <a class="nav-link rounded px-3 <?= $this->uri->segment(2) == 'dashboard' ? 'active bg-success text-white fw-bold shadow-sm' : 'text-dark' ?>" href="<?= base_url('admin/dashboard') ?>">
                            <i class="bi bi-speedometer2 me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link rounded px-3 <?= $this->uri->segment(2) == 'warga' ? 'active bg-success text-white fw-bold shadow-sm' : 'text-dark' ?>" href="<?= base_url('admin/warga') ?>">
                            <i class="bi bi-people me-2"></i> Warga
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link rounded px-3 <?= $this->uri->segment(2) == 'organisasi' ? 'active bg-success text-white fw-bold shadow-sm' : 'text-dark' ?>" href="<?= base_url('admin/organisasi') ?>">
                            <i class="bi bi-diagram-3 me-2"></i> Organisasi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link rounded px-3 <?= $this->uri->segment(2) == 'kegiatan' ? 'active bg-success text-white fw-bold shadow-sm' : 'text-dark' ?>" href="<?= base_url('admin/kegiatan') ?>">
                            <i class="bi bi-calendar-event me-2"></i> Kegiatan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link rounded px-3 <?= $this->uri->segment(2) == 'pengaduan' ? 'active bg-success text-white fw-bold shadow-sm' : 'text-dark' ?>" href="<?= base_url('admin/pengaduan') ?>">
                            <i class="bi bi-megaphone me-2"></i> Pengaduan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link rounded px-3 <?= $this->uri->segment(2) == 'panic' ? 'active bg-success text-white fw-bold shadow-sm' : 'text-dark' ?>" href="<?= base_url('admin/panic') ?>">
                            <i class="bi bi-broadcast-pin me-2"></i> SOS
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link rounded px-3 <?= $this->uri->segment(2) == 'surat' ? 'active bg-success text-white fw-bold shadow-sm' : 'text-dark' ?>" href="<?= base_url('admin/surat') ?>">
                            <i class="bi bi-file-earmark-text me-2"></i> E-Surat
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link rounded px-3 <?= $this->uri->segment(2) == 'lapak' ? 'active bg-success text-white fw-bold shadow-sm' : 'text-dark' ?>" href="<?= base_url('admin/lapak') ?>">
                            <i class="bi bi-shop me-2"></i> Lapak
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link rounded px-3 <?= $this->uri->segment(2) == 'keuangan' ? 'active bg-success text-white fw-bold shadow-sm' : 'text-dark' ?>" href="<?= base_url('admin/keuangan') ?>">
                            <i class="bi bi-wallet2 me-2"></i> Keuangan
                        </a>
                    </li>
                    <li class="nav-item mt-3 pt-3 border-top">
                        <a href="<?= base_url('auth/logout') ?>" class="btn btn-danger w-100 rounded-pill fw-bold">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
