    <!-- Bottom Navigation (Mobile) -->
    <nav class="bottom-nav d-lg-none">
        <a href="<?= base_url('user/dashboard') ?>" class="nav-item <?= $this->uri->segment(2) == 'dashboard' ? 'active' : '' ?>">
            <i class="bi bi-house-door-fill"></i>
            <span>Home</span>
        </a>
        <a href="<?= base_url('user/iuran') ?>" class="nav-item <?= $this->uri->segment(2) == 'iuran' ? 'active' : '' ?>">
            <i class="bi bi-wallet2"></i>
            <span>Iuran</span>
        </a>
        <a href="#" class="nav-item">
            <i class="bi bi-megaphone"></i>
            <span>Lapor</span>
        </a>
        <a href="#" class="nav-item">
            <i class="bi bi-envelope"></i>
            <span>Surat</span>
        </a>
        <a href="<?= base_url('user/profil') ?>" class="nav-item <?= $this->uri->segment(2) == 'profil' ? 'active' : '' ?>">
            <i class="bi bi-person-circle"></i>
            <span>Profil</span>
        </a>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
