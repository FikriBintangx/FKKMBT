<!-- Native Mobile Bottom Navigation -->
<div class="mobile-nav d-lg-none">
    <a href="<?= base_url('user/dashboard') ?>" class="mobile-nav-item <?= ($this->uri->segment(2) == 'dashboard') ? 'active' : '' ?>">
        <i class="bi bi-house-door<?= ($this->uri->segment(2) == 'dashboard') ? '-fill' : '' ?>"></i>
        <span>Home</span>
    </a>
    <a href="<?= base_url('user/iuran') ?>" class="mobile-nav-item <?= ($this->uri->segment(2) == 'iuran') ? 'active' : '' ?>">
        <i class="bi bi-wallet2"></i>
        <span>Iuran</span>
    </a>
    <a href="<?= base_url('user/lapor') ?>" class="mobile-nav-item <?= ($this->uri->segment(2) == 'lapor') ? 'active' : '' ?>">
        <i class="bi bi-megaphone<?= ($this->uri->segment(2) == 'lapor') ? '-fill' : '' ?>"></i>
        <span>Lapor</span>
    </a>
    <a href="<?= base_url('user/surat') ?>" class="mobile-nav-item <?= ($this->uri->segment(2) == 'surat') ? 'active' : '' ?>">
        <i class="bi bi-envelope<?= ($this->uri->segment(2) == 'surat') ? '-fill' : '' ?>"></i>
        <span>Surat</span>
    </a>
    <a href="<?= base_url('user/profil') ?>" class="mobile-nav-item <?= ($this->uri->segment(2) == 'profil') ? 'active' : '' ?>">
        <i class="bi bi-person<?= ($this->uri->segment(2) == 'profil') ? '-fill' : '' ?>"></i>
        <span>Profil</span>
    </a>
</div>
