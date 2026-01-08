<?php $this->load->view('user/templates/header'); ?>

<!-- Header with Gradient -->
<div class="header-section" style="background: linear-gradient(135deg, #022c22 0%, #14532d 100%); padding: 30px 20px 100px; color: white; border-radius: 0 0 30px 30px; position: relative; z-index: 1;">
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="<?= base_url('user/dashboard') ?>" class="text-white text-decoration-none bg-white bg-opacity-10 rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div class="flex-grow-1">
            <h5 class="fw-bold mb-0">Kas Warga</h5>
            <p class="mb-0 small opacity-75">Transparansi keuangan lingkungan</p>
        </div>
        <button class="btn btn-white-glass btn-sm border-0 bg-white bg-opacity-20 text-white rounded-pill px-3">
            <i class="bi bi-calendar-check me-1"></i> Bulan Ini
        </button>
    </div>

    <!-- Saldo Utama Card -->
    <div class="text-center mt-2">
        <p class="mb-1 text-white-50 small text-uppercase ls-1">Total Saldo Kas</p>
        <h1 class="fw-bold mb-0 display-4">Rp <?= number_format($saldo, 0, ',', '.') ?></h1>
        <div class="d-flex justify-content-center gap-4 mt-4">
            <div class="text-center">
                <div class="bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" style="width: 40px; height: 40px;">
                    <i class="bi bi-arrow-down-left text-white"></i>
                </div>
                <small class="d-block text-white-50" style="font-size: 10px;">Pemasukan</small>
                <span class="fw-bold small">Rp <?= number_format($pemasukan, 0, ',', '.') ?></span>
            </div>
            <div class="text-center">
                <div class="bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" style="width: 40px; height: 40px;">
                    <i class="bi bi-arrow-up-right text-white"></i>
                </div>
                <small class="d-block text-white-50" style="font-size: 10px;">Pengeluaran</small>
                <span class="fw-bold small">Rp <?= number_format($pengeluaran, 0, ',', '.') ?></span>
            </div>
        </div>
    </div>
</div>

<main class="container py-4" style="margin-top: -60px; position: relative; z-index: 2;">
    
    <!-- Filter Card -->
    <!-- <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-2 d-flex justify-content-between">
            <button class="btn btn-sm btn-dark rounded-pill px-3">Semua</button>
            <button class="btn btn-sm btn-light rounded-pill px-3 text-muted">Pemasukan</button>
            <button class="btn btn-sm btn-light rounded-pill px-3 text-muted">Pengeluaran</button>
        </div>
    </div> -->

    <h6 class="fw-bold mb-3 px-1 text-secondary small text-uppercase ls-1">Riwayat Transaksi Terakhir</h6>

    <?php if(empty($transaksi)): ?>
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body text-center py-5">
                <i class="bi bi-wallet2 fs-1 text-muted opacity-25 mb-3"></i>
                <p class="text-muted small mb-0">Belum ada data transaksi tercatat.</p>
            </div>
        </div>
    <?php else: ?>
        <div class="d-flex flex-column gap-3">
            <?php foreach($transaksi as $t): ?>
                <div class="card border-0 shadow-sm rounded-4 card-hover-effect">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-success bg-opacity-10 rounded-4 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="bi bi-arrow-down-left text-success fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1 text-dark small"><?= $t['nama_iuran'] ?></h6>
                                    <p class="mb-0 text-muted" style="font-size: 11px;">
                                        Dari: <?= explode(' ', $t['nama_lengkap'])[0] ?> • <?= date('d M Y', strtotime($t['tanggal_bayar'])) ?>
                                    </p>
                                </div>
                            </div>
                            <div class="text-end">
                                <span class="fw-bold text-success d-block small">+Rp <?= number_format($t['jumlah_bayar'], 0, ',', '.') ?></span>
                                <span class="badge bg-light text-secondary border rounded-pill" style="font-size: 9px;">Lunas</span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</main>

<?php $this->load->view('user/templates/footer'); ?>
