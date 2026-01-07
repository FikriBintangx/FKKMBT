<div class="container py-4">
    <div class="text-center mb-5 mt-3">
        <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill mb-2 px-3 fw-bold">KEUANGAN</span>
        <h2 class="fw-bold display-6">Info Iuran<br>Lingkungan</h2>
        <p class="text-muted mx-auto" style="max-width: 600px;">
            Transparansi rincian biaya pemeliharaan lingkungan.
        </p>
    </div>

    <!-- Pricing Cards -->
    <div class="row g-3 mb-5">
        <!-- Keamanan -->
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden h-100 position-relative">
                <div class="position-absolute top-0 end-0 p-3 opacity-10">
                    <i class="bi bi-shield-lock-fill display-1 text-primary"></i>
                </div>
                <div class="card-body p-4 position-relative z-1">
                    <div class="bg-primary-subtle text-primary rounded-circle d-inline-flex p-3 mb-3">
                         <i class="bi bi-shield-check fs-4"></i>
                    </div>
                    <h5 class="fw-bold text-dark">Keamanan</h5>
                    <p class="text-muted small mb-4" style="min-height: 40px;">Gaji petugas keamanan, operasional pos, dan perawatan CCTV/portal.</p>
                    
                    <div class="d-flex align-items-baseline gap-1">
                        <span class="fs-6 fw-bold text-primary">Rp</span>
                        <h2 class="fw-bold text-primary mb-0">50rb</h2>
                        <span class="text-muted small">/bln</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kebersihan -->
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden h-100 position-relative">
                <div class="position-absolute top-0 end-0 p-3 opacity-10">
                    <i class="bi bi-trash-fill display-1 text-success"></i>
                </div>
                <div class="card-body p-4 position-relative z-1">
                    <div class="bg-success-subtle text-success rounded-circle d-inline-flex p-3 mb-3">
                         <i class="bi bi-recycle fs-4"></i>
                    </div>
                    <h5 class="fw-bold text-dark">Kebersihan</h5>
                    <p class="text-muted small mb-4" style="min-height: 40px;">Pengangkutan sampah rumah tangga dan kebersihan area umum.</p>
                    
                    <div class="d-flex align-items-baseline gap-1">
                        <span class="fs-6 fw-bold text-success">Rp</span>
                        <h2 class="fw-bold text-success mb-0">30rb</h2>
                        <span class="text-muted small">/bln</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sosial -->
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden h-100 position-relative bg-light">
                <div class="card-body p-4 position-relative z-1">
                    <div class="bg-white text-dark rounded-circle d-inline-flex p-3 mb-3 shadow-sm">
                         <i class="bi bi-heart-fill fs-4 text-danger"></i>
                    </div>
                    <h5 class="fw-bold text-dark">Dana Sosial</h5>
                    <p class="text-muted small mb-4" style="min-height: 40px;">Sumbangan sukarela untuk menjenguk warga sakit atau santunan duka.</p>
                    
                    <div class="d-flex align-items-baseline gap-1">
                        <h2 class="fw-bold text-dark mb-0">Sukarela</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Login CTA -->
    <div class="card bg-dark text-white border-0 shadow-lg rounded-4 overflow-hidden">
        <div class="card-body p-5 text-center position-relative">
            <!-- Decorative Circles -->
            <div class="position-absolute top-0 start-0 translate-middle rounded-circle bg-white opacity-10" style="width: 200px; height: 200px;"></div>
            <div class="position-absolute bottom-0 end-0 translate-middle rounded-circle bg-primary opacity-25" style="width: 150px; height: 150px;"></div>

            <div class="position-relative z-1">
                <i class="bi bi-wallet2 display-3 mb-3 d-block text-warning"></i>
                <h3 class="fw-bold mb-2">Cek Status Pembayaran</h3>
                <p class="text-white-50 mb-4 mx-auto" style="max-width: 500px;">
                    Ingin melihat riwayat pembayaran atau tagihan yang belum lunas? Login sekarang untuk akses fitur lengkap.
                </p>
                
                <?php if(!$this->session->userdata('user_id')): ?>
                    <a href="<?= base_url('auth/login') ?>" class="btn btn-primary btn-lg rounded-pill px-5 fw-bold shadow">
                        Masuk Akun <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                <?php else: ?>
                    <a href="<?= base_url('user/dashboard') ?>" class="btn btn-success btn-lg rounded-pill px-5 fw-bold shadow">
                        Buka Dashboard <i class="bi bi-speedometer2 ms-2"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
