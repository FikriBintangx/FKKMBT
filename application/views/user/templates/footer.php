    <!-- Bottom Navigation (Mobile) -->
    <nav class="bottom-nav d-lg-none shadow-lg border-top border-light-subtle" style="border-radius: 20px 20px 0 0;">
        <div class="d-flex justify-content-around py-2">
            <a href="<?= base_url('user/dashboard') ?>" class="nav-item text-center text-decoration-none <?= $this->uri->segment(2) == 'dashboard' ? 'text-success fw-bold' : 'text-secondary' ?>">
                <i class="bi <?= $this->uri->segment(2) == 'dashboard' ? 'bi-house-door-fill fs-3' : 'bi-house-door fs-4' ?> d-block mb-0"></i>
                <small style="font-size: 10px;">Home</small>
            </a>
            <a href="<?= base_url('user/iuran') ?>" class="nav-item text-center text-decoration-none <?= $this->uri->segment(2) == 'iuran' ? 'text-success fw-bold' : 'text-secondary' ?>">
                <i class="bi <?= $this->uri->segment(2) == 'iuran' ? 'bi-wallet2 fs-3' : 'bi-wallet2 fs-4' ?> d-block mb-0"></i>
                <small style="font-size: 10px;">Iuran</small>
            </a>
            <a href="<?= base_url('user/lapor') ?>" class="nav-item text-center text-decoration-none px-3">
                 <div class="bg-success rounded-circle shadow d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; margin-top: -25px;">
                    <i class="bi bi-megaphone-fill text-white fs-4"></i>
                 </div>
                 <small style="font-size: 10px;" class="text-success fw-bold mt-1 d-block">Lapor</small>
            </a>
            <a href="<?= base_url('user/surat') ?>" class="nav-item text-center text-decoration-none <?= $this->uri->segment(2) == 'surat' ? 'text-success fw-bold' : 'text-secondary' ?>">
                <i class="bi <?= $this->uri->segment(2) == 'surat' ? 'bi-envelope-paper-fill fs-3' : 'bi-envelope fs-4' ?> d-block mb-0"></i>
                <small style="font-size: 10px;">Surat</small>
            </a>
            <a href="<?= base_url('user/profil') ?>" class="nav-item text-center text-decoration-none <?= $this->uri->segment(2) == 'profil' ? 'text-success fw-bold' : 'text-secondary' ?>">
                <i class="bi <?= $this->uri->segment(2) == 'profil' ? 'bi-person-circle fs-3' : 'bi-person fs-4' ?> d-block mb-0"></i>
                <small style="font-size: 10px;">Profil</small>
            </a>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
