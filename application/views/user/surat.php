<?php $this->load->view('user/templates/header'); ?>

<!-- Header with Gradient -->
<div class="header-section" style="background: linear-gradient(135deg, #022c22 0%, #14532d 100%); padding: 30px 20px 80px; color: white; border-radius: 0 0 30px 30px; position: relative; z-index: 1;">
    <div class="d-flex align-items-center gap-3">
        <a href="<?= base_url('user/dashboard') ?>" class="text-white text-decoration-none bg-white bg-opacity-10 rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div class="flex-grow-1">
            <h5 class="fw-bold mb-0">Layanan Surat</h5>
            <p class="mb-0 small opacity-75">Administrasi desa digital</p>
        </div>
        <button class="btn btn-sm border-0 text-white rounded-pill px-3 shadow-none" style="background: rgba(255,255,255,0.2);">
            <i class="bi bi-clock-history me-1"></i> Riwayat
        </button>
    </div>
</div>

<main class="container py-4" style="margin-top: -60px; position: relative; z-index: 2;">

    <!-- Menu Pilihan -->
    <h6 class="fw-bold mb-3 px-1 text-white small text-uppercase ls-1 opacity-75">Buat Pengajuan Baru</h6>
    <div class="row g-3 mb-4">
        <div class="col-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 card-hover-effect" onclick="showForm('sp')" style="cursor: pointer;">
                <div class="card-body p-3">
                    <div class="bg-primary bg-opacity-10 rounded-4 d-flex align-items-center justify-content-center mb-3" style="width: 45px; height: 45px;">
                        <i class="bi bi-file-earmark-text text-primary fs-4"></i>
                    </div>
                    <h6 class="fw-bold mb-1 small text-dark">Surat Pengantar</h6>
                    <p class="text-muted mb-0" style="font-size: 10px; line-height: 1.3;">Pengantar RT/RW untuk Kelurahan/Kecamatan</p>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 card-hover-effect" onclick="showForm('domisili')" style="cursor: pointer;">
                <div class="card-body p-3">
                    <div class="bg-success bg-opacity-10 rounded-4 d-flex align-items-center justify-content-center mb-3" style="width: 45px; height: 45px;">
                        <i class="bi bi-house-check text-success fs-4"></i>
                    </div>
                    <h6 class="fw-bold mb-1 small text-dark">Ket. Domisili</h6>
                    <p class="text-muted mb-0" style="font-size: 10px; line-height: 1.3;">Surat keterangan bukti tempat tinggal</p>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 card-hover-effect" onclick="showForm('keramaian')" style="cursor: pointer;">
                <div class="card-body p-3">
                    <div class="bg-warning bg-opacity-10 rounded-4 d-flex align-items-center justify-content-center mb-3" style="width: 45px; height: 45px;">
                         <i class="bi bi-megaphone text-warning fs-4"></i>
                    </div>
                    <h6 class="fw-bold mb-1 small text-dark">Izin Keramaian</h6>
                    <p class="text-muted mb-0" style="font-size: 10px; line-height: 1.3;">Untuk acara pernikahan, syukuran, dll</p>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 card-hover-effect" onclick="showForm('kematian')" style="cursor: pointer;">
                <div class="card-body p-3">
                    <div class="bg-secondary bg-opacity-10 rounded-4 d-flex align-items-center justify-content-center mb-3" style="width: 45px; height: 45px;">
                        <i class="bi bi-heart-pulse text-secondary fs-4"></i>
                    </div>
                    <h6 class="fw-bold mb-1 small text-dark">Ket. Kematian</h6>
                    <p class="text-muted mb-0" style="font-size: 10px; line-height: 1.3;">Pelaporan warga meninggal dunia</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Pengajuan Lists (Dummy) -->
    <h6 class="fw-bold mb-3 px-1 text-secondary small text-uppercase ls-1">Riwayat Pengajuan Terakhir</h6>
    <div class="d-flex flex-column gap-3">
        <!-- Item 1 (Selesai) -->
        <div class="card border-0 shadow-sm rounded-4 card-hover-effect">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="bi bi-file-earmark-check-fill text-success"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0 small text-dark">Surat Pengantar SKCK</h6>
                            <small class="text-muted" style="font-size: 10px;">05 Jan 2024</small>
                        </div>
                    </div>
                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill" style="font-size: 9px;">Selesai</span>
                </div>
            </div>
        </div>

        <!-- Item 2 (Proses) -->
        <div class="card border-0 shadow-sm rounded-4 card-hover-effect">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="bi bi-hourglass-split text-warning"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0 small text-dark">Izin Keramaian (Hajatan)</h6>
                            <small class="text-muted" style="font-size: 10px;">Hari ini, 09:30</small>
                        </div>
                    </div>
                    <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill" style="font-size: 9px;">Diproses</span>
                </div>
            </div>
        </div>
    </div>

</main>

<script>
function showForm(type) {
    // Placeholder function for future implementation
    let title = '';
    switch(type) {
        case 'sp': title = 'Surat Pengantar'; break;
        case 'domisili': title = 'Keterangan Domisili'; break;
        case 'keramaian': title = 'Izin Keramaian'; break;
        case 'kematian': title = 'Keterangan Kematian'; break;
    }
    alert('Formulir ' + title + ' akan segera hadir!');
}
</script>

<?php $this->load->view('user/templates/footer'); ?>
