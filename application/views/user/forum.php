<?php $page_title = 'Forum Warga'; ?>
<?php $this->load->view('user/templates/header'); ?>

<!-- Header -->
<div class="header-section text-white" style="padding: 20px 20px 30px; border-radius: 0 0 30px 30px;">
    <div class="d-flex align-items-center gap-3">
        <a href="<?= base_url('user/dashboard') ?>" class="text-white text-decoration-none bg-white bg-opacity-10 rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h5 class="fw-bold mb-0">Forum Warga</h5>
            <p class="small mb-0 opacity-75">Diskusi dan tanya jawab seputar komplek</p>
        </div>
    </div>
</div>

<main class="container py-4" style="margin-top: -20px;">
    
    <!-- Input Diskusi Baru -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <form action="<?= base_url('user/forum/submit') ?>" method="POST">
                <div class="d-flex gap-3 align-items-center">
                    <div class="bg-light rounded-circle flex-shrink-0" style="width: 40px; height: 40px;">
                        <img src="https://ui-avatars.com/api/?name=<?= $this->session->userdata('username') ?>&background=random" class="rounded-circle w-100 h-100">
                    </div>
                    <input type="text" name="konten" class="form-control rounded-pill bg-light border-0 px-3" placeholder="Apa yang ingin Anda diskusikan?" required autocomplete="off">
                    <button type="submit" class="btn btn-primary rounded-circle shadow-sm" style="width: 40px; height: 40px;">
                        <i class="bi bi-send-fill text-white small"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Feed Diskusi -->
    <h6 class="fw-bold mb-3 px-1 small text-muted text-uppercase ls-1">Diskusi Terbaru</h6>
    
    <?php if(empty($forums)): ?>
        <div class="text-center py-5">
            <p class="text-muted small">Belum ada diskusi. Jadilah yang pertama posting!</p>
        </div>
    <?php else: ?>
        <?php foreach($forums as $f): ?>
        <div class="card border-0 shadow-sm rounded-4 mb-3">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="d-flex gap-2 align-items-center">
                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($f['nama_lengkap']) ?>&background=random" class="rounded-circle" width="35" height="35">
                        <div>
                            <h6 class="fw-bold mb-0 small"><?= $f['nama_lengkap'] ?></h6>
                            <small class="text-muted" style="font-size: 10px;">Blok <?= $f['blok'] ?> No. <?= $f['no_rumah'] ?> • <?= date('d M H:i', strtotime($f['created_at'])) ?></small>
                        </div>
                    </div>
                    <i class="bi bi-three-dots-vertical text-muted"></i>
                </div>
                <p class="small mb-2 text-dark" style="font-size: 13px; line-height: 1.5;"><?= nl2br(htmlspecialchars($f['konten'])) ?></p>
                <div class="d-flex gap-3 border-top pt-2 mt-2">
                    <button class="btn btn-sm btn-link text-decoration-none text-muted p-0 small">
                        <i class="bi bi-heart me-1"></i> <?= $f['likes'] ?> Suka
                    </button>
                    <!-- Fitur komentar menyusul -->
                    <button class="btn btn-sm btn-link text-decoration-none text-muted p-0 small">
                        <i class="bi bi-chat me-1"></i> Komentar
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>

</main>

<?php $this->load->view('user/templates/footer'); ?>
