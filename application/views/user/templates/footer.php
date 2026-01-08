    <!-- Bottom Navigation (Mobile) -->
    <nav class="fixed-bottom bg-white shadow-lg border-top" style="border-radius: 20px 20px 0 0; z-index: 1050; padding-bottom: env(safe-area-inset-bottom);">
        <div class="d-flex justify-content-around align-items-end" style="height: 70px;">
            
            <!-- Home -->
            <a href="<?= base_url('user/dashboard') ?>" class="text-decoration-none w-100 text-center mb-2 pb-1 group">
                <i class="bi <?= $this->uri->segment(2) == 'dashboard' || $this->uri->segment(2) == '' ? 'bi-house-door-fill text-success fs-4' : 'bi-house-door text-secondary fs-4' ?>"></i>
                <small class="d-block fw-bold" style="font-size: 10px; <?= $this->uri->segment(2) == 'dashboard' || $this->uri->segment(2) == '' ? 'color: #14532d;' : 'color: #6c757d;' ?>">Home</small>
            </a>

            <!-- Iuran -->
            <a href="<?= base_url('user/iuran') ?>" class="text-decoration-none w-100 text-center mb-2 pb-1">
                <i class="bi <?= $this->uri->segment(2) == 'iuran' ? 'bi-wallet-fill text-success fs-4' : 'bi-wallet2 text-secondary fs-4' ?>"></i>
                <small class="d-block fw-bold" style="font-size: 10px; <?= $this->uri->segment(2) == 'iuran' ? 'color: #14532d;' : 'color: #6c757d;' ?>">Iuran</small>
            </a>

            <!-- Lapor (Center Floating) -->
            <div class="position-relative w-100 text-center">
                <a href="<?= base_url('user/lapor') ?>" class="text-decoration-none d-inline-block position-relative" style="top: -30px;">
                    <div class="rounded-circle shadow-lg d-flex align-items-center justify-content-center" 
                         style="width: 60px; height: 60px; background: linear-gradient(135deg, #022c22 0%, #14532d 100%); border: 4px solid #fff;">
                        <i class="bi bi-megaphone-fill text-white fs-3"></i>
                    </div>
                    <small class="d-block fw-bold mt-1 text-success" style="font-size: 10px;">Lapor</small>
                </a>
            </div>

            <!-- Surat -->
            <a href="<?= base_url('user/surat') ?>" class="text-decoration-none w-100 text-center mb-2 pb-1">
                <i class="bi <?= $this->uri->segment(2) == 'surat' ? 'bi-envelope-paper-fill text-success fs-4' : 'bi-envelope text-secondary fs-4' ?>"></i>
                <small class="d-block fw-bold" style="font-size: 10px; <?= $this->uri->segment(2) == 'surat' ? 'color: #14532d;' : 'color: #6c757d;' ?>">Surat</small>
            </a>

            <!-- Profil -->
            <a href="<?= base_url('user/profil') ?>" class="text-decoration-none w-100 text-center mb-2 pb-1">
                <i class="bi <?= $this->uri->segment(2) == 'profil' ? 'bi-person-fill text-success fs-4' : 'bi-person text-secondary fs-4' ?>"></i>
                <small class="d-block fw-bold" style="font-size: 10px; <?= $this->uri->segment(2) == 'profil' ? 'color: #14532d;' : 'color: #6c757d;' ?>">Profil</small>
            </a>

        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
