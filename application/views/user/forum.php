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
            <div class="d-flex gap-3 align-items-center">
                <div class="bg-light rounded-circle flex-shrink-0" style="width: 40px; height: 40px;">
                    <img src="https://ui-avatars.com/api/?name=<?= $this->session->userdata('username') ?>&background=random" class="rounded-circle w-100 h-100">
                </div>
                <input type="text" class="form-control rounded-pill bg-light border-0 px-3" placeholder="Apa yang ingin Anda diskusikan?">
            </div>
        </div>
    </div>

    <!-- Feed Diskusi -->
    <h6 class="fw-bold mb-3 px-1 small text-muted text-uppercase ls-1">Diskusi Terbaru</h6>
    
    <!-- Post 1 -->
    <div class="card border-0 shadow-sm rounded-4 mb-3">
        <div class="card-body p-3">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div class="d-flex gap-2 align-items-center">
                    <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=random" class="rounded-circle" width="35" height="35">
                    <div>
                        <h6 class="fw-bold mb-0 small">Budi Santoso</h6>
                        <small class="text-muted" style="font-size: 10px;">Blok A No. 12 • 2 jam yang lalu</small>
                    </div>
                </div>
                <i class="bi bi-three-dots-vertical text-muted"></i>
            </div>
            <p class="small mb-2 text-dark">Bapak/Ibu, untuk kerja bakti besok jadinya kumpul jam berapa ya? Dan apakah perlu bawa alat sendiri?</p>
            <div class="d-flex gap-3 border-top pt-2 mt-2">
                <button class="btn btn-sm btn-link text-decoration-none text-muted p-0 small">
                    <i class="bi bi-heart me-1"></i> 12 Suka
                </button>
                <button class="btn btn-sm btn-link text-decoration-none text-muted p-0 small">
                    <i class="bi bi-chat me-1"></i> 5 Komentar
                </button>
            </div>
        </div>
    </div>

    <!-- Post 2 -->
    <div class="card border-0 shadow-sm rounded-4 mb-3">
        <div class="card-body p-3">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div class="d-flex gap-2 align-items-center">
                    <img src="https://ui-avatars.com/api/?name=Siti+Aminah&background=random" class="rounded-circle" width="35" height="35">
                    <div>
                        <h6 class="fw-bold mb-0 small">Siti Aminah</h6>
                        <small class="text-muted" style="font-size: 10px;">Blok C No. 5 • 5 jam yang lalu</small>
                    </div>
                </div>
                <i class="bi bi-three-dots-vertical text-muted"></i>
            </div>
            <p class="small mb-2 text-dark">Info dong, tukang galon yang biasa lewat pagi kok hari ini belum lewat ya? Ada yang punya nomornya?</p>
            <div class="d-flex gap-3 border-top pt-2 mt-2">
                <button class="btn btn-sm btn-link text-decoration-none text-muted p-0 small">
                    <i class="bi bi-heart me-1"></i> 3 Suka
                </button>
                <button class="btn btn-sm btn-link text-decoration-none text-muted p-0 small">
                    <i class="bi bi-chat me-1"></i> 8 Komentar
                </button>
            </div>
        </div>
    </div>

</main>

<?php $this->load->view('user/templates/footer'); ?>
