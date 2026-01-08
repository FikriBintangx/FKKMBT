<?php $this->load->view('user/templates/header'); ?>

<!-- Modern Header Section -->
<div class="header-section" style="background: linear-gradient(135deg, #022c22 0%, #14532d 100%); padding: 30px 20px 80px; color: white; border-radius: 0 0 30px 30px; position: relative; z-index: 1;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-3">
             <div class="bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 45px; height: 45px;">
                <img src="<?= base_url('assets/images/LOGO/LOGOFKKMBT.jpg') ?>" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
            </div>
            <div>
                <h6 class="mb-0 opacity-75 small text-uppercase fw-bold ls-1">Warga Bukit Tiara</h6>
                <h5 class="fw-bold mb-0">Halo, <?= explode(' ', $warga['nama_lengkap'])[0] ?>! 👋</h5>
            </div>
        </div>
        <a href="<?= base_url('user/notifikasi') ?>" class="btn position-relative rounded-circle p-2 d-flex align-items-center justify-content-center border-0 shadow-none" style="width: 40px; height: 40px; background: rgba(255,255,255,0.2); backdrop-filter: blur(5px);">
            <i class="bi bi-bell-fill text-white"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-white" style="font-size: 8px;">3</span>
        </a>
    </div>

    <!-- Status Iuran Card (Floating) -->
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="margin-bottom: -60px;">
        <div class="card-body p-4 position-relative">
            <!-- Decorative Circle -->
            <div class="position-absolute top-0 end-0 translate-middle-y me-n3 mt-n3 rounded-circle bg-success opacity-10" style="width: 100px; height: 100px;"></div>
            
            <div class="row align-items-center">
                <div class="col-7">
                    <p class="text-muted small mb-1 fw-bold text-uppercase ls-1">Status Iuran Anda</p>
                    <h4 class="fw-bold <?= $status_class ?> mb-1">
                        <?= $status_iuran ?>
                    </h4>
                    <p class="text-muted small mb-0 fst-italic">
                        <?= $status_desc ?>
                    </p>
                </div>
                <div class="col-5 text-end">
                     <?php if($unpaid > 0): ?>
                        <a href="<?= base_url('user/iuran') ?>" class="btn btn-danger btn-sm rounded-pill px-3 shadow-sm fw-bold pulse-animation">
                            Bayar Sekarang
                        </a>
                     <?php else: ?>
                        <div class="d-inline-flex flex-column align-items-center">
                             <i class="bi bi-shield-check text-success fs-1"></i>
                             <span class="small fw-bold text-success">Aman</span>
                        </div>
                     <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<main class="container mb-5" style="margin-top: 80px; padding-bottom: 80px;">
    
    <!-- Quick Actions Grid -->
    <div class="mb-4">
        <h6 class="fw-bold mb-3 text-secondary px-1">Layanan Warga</h6>
        <div class="row g-3">
            <!-- Menu Items -->
            <div class="col-3 text-center">
                <a href="<?= base_url('user/lapor') ?>" class="text-decoration-none text-dark d-block card-hover-effect">
                    <div class="bg-danger bg-opacity-10 rounded-4 shadow-sm p-3 mb-2 d-flex align-items-center justify-content-center mx-auto aspect-ratio-1" style="width: 60px; height: 60px;">
                        <i class="bi bi-megaphone-fill text-danger fs-4"></i>
                    </div>
                    <small class="fw-bold small-font">Lapor</small>
                </a>
            </div>
            
            <div class="col-3 text-center">
                <a href="<?= base_url('user/surat') ?>" class="text-decoration-none text-dark d-block card-hover-effect">
                    <div class="bg-primary bg-opacity-10 rounded-4 shadow-sm p-3 mb-2 d-flex align-items-center justify-content-center mx-auto aspect-ratio-1" style="width: 60px; height: 60px;">
                         <i class="bi bi-file-earmark-text-fill text-primary fs-4"></i>
                    </div>
                    <small class="fw-bold small-font">Surat</small>
                </a>
            </div>

            <div class="col-3 text-center">
                <a href="<?= base_url('user/lapak') ?>" class="text-decoration-none text-dark d-block card-hover-effect">
                    <div class="bg-warning bg-opacity-10 rounded-4 shadow-sm p-3 mb-2 d-flex align-items-center justify-content-center mx-auto aspect-ratio-1" style="width: 60px; height: 60px;">
                         <i class="bi bi-shop text-warning fs-4"></i>
                    </div>
                    <small class="fw-bold small-font">Lapak</small>
                </a>
            </div>

            <div class="col-3 text-center">
                <a href="<?= base_url('user/sos') ?>" class="text-decoration-none text-dark d-block card-hover-effect">
                    <div class="bg-danger rounded-4 shadow-sm p-3 mb-2 d-flex align-items-center justify-content-center mx-auto aspect-ratio-1" style="width: 60px; height: 60px; box-shadow: 0 4px 10px rgba(220,53,69,0.3)!important;">
                         <i class="bi bi-broadcast text-white fs-4"></i>
                    </div>
                    <small class="fw-bold text-danger small-font">SOS</small>
                </a>
            </div>
            
            <!-- Row 2 -->
             <div class="col-3 text-center mt-3">
                <a href="<?= base_url('user/kas') ?>" class="text-decoration-none text-dark d-block card-hover-effect">
                    <div class="bg-info bg-opacity-10 rounded-4 shadow-sm p-3 mb-2 d-flex align-items-center justify-content-center mx-auto aspect-ratio-1" style="width: 60px; height: 60px;">
                         <i class="bi bi-briefcase-fill text-info fs-4"></i>
                    </div>
                    <small class="fw-bold small-font">Kas</small>
                </a>
            </div>
             <div class="col-3 text-center mt-3">
                <a href="<?= base_url('user/forum') ?>" class="text-decoration-none text-dark d-block card-hover-effect">
                    <div class="bg-success bg-opacity-10 rounded-4 shadow-sm p-3 mb-2 d-flex align-items-center justify-content-center mx-auto aspect-ratio-1" style="width: 60px; height: 60px;">
                         <i class="bi bi-chat-dots-fill text-success fs-4"></i>
                    </div>
                    <small class="fw-bold small-font">Forum</small>
                </a>
            </div>
             <div class="col-3 text-center mt-3">
                <a href="<?= base_url('user/struktur/fkkmbt') ?>" class="text-decoration-none text-dark d-block card-hover-effect">
                    <div class="bg-secondary bg-opacity-10 rounded-4 shadow-sm p-3 mb-2 d-flex align-items-center justify-content-center mx-auto aspect-ratio-1" style="width: 60px; height: 60px;">
                         <i class="bi bi-diagram-3-fill text-dark fs-4"></i>
                    </div>
                    <small class="fw-bold small-font">FKKMBT</small>
                </a>
            </div>
             <div class="col-3 text-center mt-3">
                <a href="<?= base_url('user/struktur/fkkmmbt') ?>" class="text-decoration-none text-dark d-block card-hover-effect">
                    <div class="bg-secondary bg-opacity-10 rounded-4 shadow-sm p-3 mb-2 d-flex align-items-center justify-content-center mx-auto aspect-ratio-1" style="width: 60px; height: 60px;">
                         <i class="bi bi-people-fill text-secondary fs-4"></i>
                    </div>
                    <small class="fw-bold small-font">FKKMMBT</small>
                </a>
            </div>
             <div class="col-3 text-center mt-3">
                <a href="<?= base_url('user/cctv') ?>" class="text-decoration-none text-dark d-block card-hover-effect">
                    <div class="bg-dark bg-opacity-10 rounded-4 shadow-sm p-3 mb-2 d-flex align-items-center justify-content-center mx-auto aspect-ratio-1" style="width: 60px; height: 60px;">
                         <i class="bi bi-camera-video-fill text-dark fs-4"></i>
                    </div>
                    <small class="fw-bold small-font">CCTV</small>
                </a>
            </div>
        </div>
    </div>

    <!-- Informasi Kas Warga -->
    <div class="mb-4">
        <h6 class="fw-bold mb-3 text-secondary px-1">Informasi Keuangan</h6>
        <div class="card border-0 bg-primary bg-gradient text-white rounded-4 shadow py-2">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="opacity-75 d-block mb-1">Total Kas Warga</small>
                        <h4 class="fw-bold mb-0">Rp <?= number_format($total_kas, 0, ',', '.') ?></h4>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-2">
                        <i class="bi bi-graph-up-arrow fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Berita & Pengumuman -->
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3 px-1">
             <h6 class="fw-bold mb-0 text-secondary">Berita Terkini</h6>
             <a href="#" class="text-decoration-none small fw-bold text-success">Lihat Semua</a>
        </div>
        
        <?php foreach($news as $n): ?>
        <div class="card border-0 shadow-sm rounded-4 mb-3 overflow-hidden card-hover-effect">
            <div class="row g-0">
                <div class="col-4 position-relative">
                    <img src="<?= base_url('assets/images/news/') . $n['image'] ?>" class="img-fluid h-100 object-fit-cover position-absolute" style="top:0; left:0; width:100%; height:100%;" onerror="this.src='https://placehold.co/400x400/e2e8f0/1e293b?text=News'">
                </div>
                <div class="col-8">
                    <div class="card-body p-3">
                        <span class="badge bg-light text-secondary border mb-2 small-font"><?= date('d M Y', strtotime($n['created_at'])) ?></span>
                        <h6 class="card-title fw-bold mb-1 text-truncate-2 small"><?= $n['title'] ?></h6>
                         <a href="#" class="stretched-link small text-decoration-none text-muted">Baca selengkapnya <i class="bi bi-chevron-right" style="font-size: 10px;"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</main>

<style>
    .small-font { font-size: 0.75rem; }
    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .card-hover-effect { transition: transform 0.2s; }
    .card-hover-effect:active { transform: scale(0.95); }
    
    .feature-coming-soon { position: relative; opacity: 0.7; }
    .feature-coming-soon::after {
        content: "Soon";
        position: absolute;
        top: -5px; right: 5px;
        background: #94a3b8;
        color: white;
        font-size: 8px;
        padding: 2px 6px;
        border-radius: 10px;
        font-weight: bold;
    }
    .pulse-animation {
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7); }
        70% { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(220, 53, 69, 0); }
        100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
    }
</style>

<?php $this->load->view('user/templates/footer'); ?>
