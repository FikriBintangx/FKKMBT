<div class="container py-5">
    <div class="text-center mb-5">
        <h6 class="text-primary fw-bold text-uppercase">Keuangan Lingkungan</h6>
        <h1 class="fw-bold">Informasi Iuran</h1>
        <p class="text-muted col-lg-8 mx-auto">Transparansi pengelolaan dana warga untuk kenyamanan bersama.</p>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 bg-primary text-white">
                <div class="card-body p-4">
                    <div class="mb-3">
                        <i class="bi bi-wallet2 fs-1"></i>
                    </div>
                    <h5 class="card-title">Iuran Keamanan</h5>
                    <p class="card-text opacity-75">Digunakan untuk operasional pos satpam, gaji petugas keamanan, dan pemeliharaan portal.</p>
                    <h3 class="fw-bold mt-3">Rp 50.000 <span class="fs-6 fw-normal">/bulan</span></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 bg-success text-white">
                <div class="card-body p-4">
                    <div class="mb-3">
                        <i class="bi bi-trash fs-1"></i>
                    </div>
                    <h5 class="card-title">Iuran Kebersihan</h5>
                    <p class="card-text opacity-75">Digunakan untuk petugas pengangkut sampah dan pemeliharaan kebersihan lingkungan.</p>
                    <h3 class="fw-bold mt-3">Rp 30.000 <span class="fs-6 fw-normal">/bulan</span></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 bg-info text-white">
                <div class="card-body p-4">
                    <div class="mb-3">
                        <i class="bi bi-heart fs-1"></i>
                    </div>
                    <h5 class="card-title">Dana Sosial (Optional)</h5>
                    <p class="card-text opacity-75">Sumbangan sukarela untuk bantuan warga sakit, meninggal dunia, atau bencana alam.</p>
                    <h3 class="fw-bold mt-3">Sukarela</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-5 text-center">
            <h3>Cek Status Pembayaran Anda</h3>
            <p class="text-muted mb-4">Silakan login untuk melihat riwayat pembayaran dan tagihan iuran Anda secara detail.</p>
            
            <?php if(!$this->session->userdata('user_id')): ?>
                <a href="<?= base_url('auth/login') ?>" class="btn btn-primary px-4 py-2">
                    <i class="bi bi-lock-fill me-2"></i>Login untuk Cek Status
                </a>
            <?php else: ?>
                <a href="<?= base_url('user/dashboard') ?>" class="btn btn-primary px-4 py-2">
                    <i class="bi bi-speedometer2 me-2"></i>Ke Dashboard Saya
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>
