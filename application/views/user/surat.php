<?php $page_title = 'E-Surat Digital'; ?>
<?php $this->load->view('user/templates/header'); ?>

<!-- Green Header -->
<div style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); padding: 20px; color: white;">
    <div class="container">
        <a href="<?= base_url('user/dashboard') ?>" class="text-white text-decoration-none">
            <i class="bi bi-arrow-left me-2"></i>
        </a>
        <h4 class="fw-bold mb-1 mt-2">Layanan Surat Digital</h4>
        <p class="mb-0 small opacity-75">Ajukan permohonan surat secara online</p>
    </div>
</div>

<main class="container py-4">
    <!-- Pilihan Surat -->
    <h6 class="fw-bold mb-3 px-1">Pilih Jenis Surat</h6>
    <div class="row g-3 mb-4">
        <div class="col-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 card-hover-effect" onclick="alert('Form Surat Pengantar')">
                <div class="card-body p-3 text-center">
                    <div class="bg-primary bg-opacity-10 rounded-circle w-100 mb-3 d-flex align-items-center justify-content-center" style="height: 60px;">
                        <i class="bi bi-file-text-fill text-primary fs-3"></i>
                    </div>
                    <h6 class="fw-bold small mb-1">Surat Pengantar</h6>
                    <small class="text-muted" style="font-size: 10px;">Untuk RT/RW/Kelurahan</small>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 card-hover-effect" onclick="alert('Form Keterangan Domisili')">
                <div class="card-body p-3 text-center">
                    <div class="bg-success bg-opacity-10 rounded-circle w-100 mb-3 d-flex align-items-center justify-content-center" style="height: 60px;">
                        <i class="bi bi-house-check-fill text-success fs-3"></i>
                    </div>
                    <h6 class="fw-bold small mb-1">Ket. Domisili</h6>
                    <small class="text-muted" style="font-size: 10px;">Bukti tinggal warga</small>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 card-hover-effect" onclick="alert('Form Izin Keramaian')">
                <div class="card-body p-3 text-center">
                    <div class="bg-warning bg-opacity-10 rounded-circle w-100 mb-3 d-flex align-items-center justify-content-center" style="height: 60px;">
                        <i class="bi bi-people-fill text-warning fs-3"></i>
                    </div>
                    <h6 class="fw-bold small mb-1">Izin Keramaian</h6>
                    <small class="text-muted" style="font-size: 10px;">Acara pernikahan dll</small>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 card-hover-effect" onclick="alert('Form Surat Kematian')">
                <div class="card-body p-3 text-center">
                    <div class="bg-secondary bg-opacity-10 rounded-circle w-100 mb-3 d-flex align-items-center justify-content-center" style="height: 60px;">
                        <i class="bi bi-heart-pulse-fill text-secondary fs-3"></i>
                    </div>
                    <h6 class="fw-bold small mb-1">Ket. Kematian</h6>
                    <small class="text-muted" style="font-size: 10px;">Lapor warga meninggal</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Pengajuan -->
    <h6 class="fw-bold mb-3 px-1">Riwayat Pengajuan</h6>
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body text-center py-5">
            <i class="bi bi-envelope-open fs-1 text-muted opacity-25 mb-3"></i>
            <p class="text-muted small mb-0">Belum ada surat yang diajukan</p>
        </div>
    </div>
</main>

<?php $this->load->view('user/templates/footer'); ?>
