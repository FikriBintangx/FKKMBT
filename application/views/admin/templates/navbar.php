<nav class="navbar navbar-expand-lg navbar-dark sticky-top shadow" style="background: linear-gradient(to right, #16a34a, #15803d); padding: 0.5rem 0.75rem;">
    <div class="container-fluid" style="max-width: 100%; padding: 0;">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="<?= base_url('admin/dashboard') ?>" style="gap: 0.5rem; font-size: 0.9rem;">
            <img src="<?= base_url('assets/images/LOGO/LOGOFKKMBT.jpg') ?>" class="rounded-circle" style="width: 30px; height: 30px; object-fit: cover;">
            <span>FKKMBT <small style="opacity: 0.7; font-size: 0.75rem;">Admin</small></span>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav" style="padding: 0.25rem 0.5rem; font-size: 0.9rem;">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="adminNav" style="margin-top: 0.5rem;">
            <ul class="navbar-nav" style="gap: 0; padding: 0;">
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(2) == 'dashboard' ? 'active fw-bold' : '' ?>" href="<?= base_url('admin/dashboard') ?>" style="padding: 0.5rem 0.75rem; font-size: 0.85rem;">
                        <i class="bi bi-speedometer2" style="font-size: 0.9rem;"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(2) == 'warga' ? 'active fw-bold' : '' ?>" href="<?= base_url('admin/warga') ?>" style="padding: 0.5rem 0.75rem; font-size: 0.85rem;">
                        <i class="bi bi-people" style="font-size: 0.9rem;"></i> Warga
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(2) == 'organisasi' ? 'active fw-bold' : '' ?>" href="<?= base_url('admin/organisasi') ?>" style="padding: 0.5rem 0.75rem; font-size: 0.85rem;">
                        <i class="bi bi-diagram-3" style="font-size: 0.9rem;"></i> Organisasi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(2) == 'kegiatan' ? 'active fw-bold' : '' ?>" href="<?= base_url('admin/kegiatan') ?>" style="padding: 0.5rem 0.75rem; font-size: 0.85rem;">
                        <i class="bi bi-calendar-event" style="font-size: 0.9rem;"></i> Kegiatan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(2) == 'pengaduan' ? 'active fw-bold' : '' ?>" href="<?= base_url('admin/pengaduan') ?>" style="padding: 0.5rem 0.75rem; font-size: 0.85rem;">
                        <i class="bi bi-megaphone" style="font-size: 0.9rem;"></i> Pengaduan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(2) == 'panic' ? 'active fw-bold' : '' ?>" href="<?= base_url('admin/panic') ?>" style="padding: 0.5rem 0.75rem; font-size: 0.85rem;">
                        <i class="bi bi-broadcast-pin" style="font-size: 0.9rem;"></i> SOS
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(2) == 'surat' ? 'active fw-bold' : '' ?>" href="<?= base_url('admin/surat') ?>" style="padding: 0.5rem 0.75rem; font-size: 0.85rem;">
                        <i class="bi bi-file-earmark-text" style="font-size: 0.9rem;"></i> E-Surat
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(2) == 'lapak' ? 'active fw-bold' : '' ?>" href="<?= base_url('admin/lapak') ?>" style="padding: 0.5rem 0.75rem; font-size: 0.85rem;">
                        <i class="bi bi-shop" style="font-size: 0.9rem;"></i> Lapak
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(2) == 'keuangan' ? 'active fw-bold' : '' ?>" href="<?= base_url('admin/keuangan') ?>" style="padding: 0.5rem 0.75rem; font-size: 0.85rem;">
                        <i class="bi bi-wallet2" style="font-size: 0.9rem;"></i> Keuangan
                    </a>
                </li>
                <li class="nav-item" style="margin-top: 0.5rem; padding-top: 0.5rem; border-top: 1px solid rgba(255,255,255,0.2);">
                    <a href="<?= base_url('auth/logout') ?>" class="btn btn-sm btn-danger" style="padding: 0.4rem 1rem; font-size: 0.8rem; width: 100%;">
                        Logout <i class="bi bi-box-arrow-right ms-1"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
