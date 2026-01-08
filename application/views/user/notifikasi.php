<?php $this->load->view('user/templates/header'); ?>

<!-- Header with Gradient -->
<div class="header-section" style="background: linear-gradient(135deg, #022c22 0%, #14532d 100%); padding: 30px 20px 80px; color: white; border-radius: 0 0 30px 30px; position: relative; z-index: 1;">
    <div class="d-flex align-items-center gap-3">
        <a href="<?= base_url('user/dashboard') ?>" class="text-white text-decoration-none bg-white bg-opacity-10 rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div class="flex-grow-1">
            <h5 class="fw-bold mb-0">Notifikasi</h5>
            <p class="mb-0 small opacity-75">Update terbaru seputar lingkungan</p>
        </div>
        <button class="btn btn-white-glass btn-sm border-0 bg-white bg-opacity-20 text-white rounded-pill px-3">
            <i class="bi bi-check-all me-1"></i> Baca Semua
        </button>
    </div>
</div>

<main class="container py-4" style="margin-top: -60px; position: relative; z-index: 2;">

    <?php if(empty($notifikasi)): ?>
        <div class="card border-0 shadow-sm rounded-4 text-center py-5">
            <div class="card-body">
                <div class="bg-light rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                    <i class="bi bi-bell-slash fs-1 text-muted opacity-50"></i>
                </div>
                <h6 class="fw-bold text-dark">Tidak Ada Notifikasi</h6>
                <p class="text-muted small mb-0">Anda akan menerima update di sini.</p>
            </div>
        </div>
    <?php else: ?>
        <div class="d-flex flex-column gap-3">
            <?php foreach($notifikasi as $notif): ?>
                <div class="card border-0 shadow-sm rounded-4 card-hover-effect">
                    <div class="card-body p-3">
                        <div class="d-flex gap-3">
                            <div class="flex-shrink-0">
                                <?php if($notif['tipe'] == 'success'): ?>
                                    <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                        <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                    </div>
                                <?php elseif($notif['tipe'] == 'warning'): ?>
                                    <div class="bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                        <i class="bi bi-exclamation-circle-fill text-warning fs-5"></i>
                                    </div>
                                <?php else: ?>
                                    <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                        <i class="bi bi-info-circle-fill text-primary fs-5"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <h6 class="fw-bold mb-0 text-dark small"><?= $notif['judul'] ?></h6>
                                    <small class="text-muted" style="font-size: 10px;"><?= $notif['waktu'] ?></small>
                                </div>
                                <p class="text-muted small mb-0" style="font-size: 12px; line-height: 1.4;">
                                    <?= $notif['pesan'] ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</main>

<?php $this->load->view('user/templates/footer'); ?>
