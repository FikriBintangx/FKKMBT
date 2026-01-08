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

    <!-- Riwayat Pengajuan Lists -->
    <h6 class="fw-bold mb-3 px-1 text-secondary small text-uppercase ls-1">Riwayat Pengajuan Terakhir</h6>
    
    <?php if(empty($riwayat)): ?>
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body text-center py-5">
                <i class="bi bi-envelope-open fs-1 text-muted opacity-25 mb-3"></i>
                <p class="text-muted small mb-0">Belum ada surat yang diajukan</p>
            </div>
        </div>
    <?php else: ?>
        <div class="d-flex flex-column gap-3">
            <?php foreach($riwayat as $r): ?>
                <?php
                    $status_badge = '';
                    $icon_status = '';
                    if($r['status'] == 'Pending') {
                        $status_badge = 'bg-warning bg-opacity-10 text-warning';
                        $icon_status = 'bi-hourglass-split text-warning';
                    } elseif($r['status'] == 'Selesai') {
                        $status_badge = 'bg-success bg-opacity-10 text-success';
                        $icon_status = 'bi-check-circle-fill text-success';
                    } elseif($r['status'] == 'Diproses') {
                        $status_badge = 'bg-info bg-opacity-10 text-info';
                        $icon_status = 'bi-arrow-repeat text-info';
                    } else {
                        $status_badge = 'bg-danger bg-opacity-10 text-danger';
                        $icon_status = 'bi-x-circle-fill text-danger';
                    }
                ?>
                <div class="card border-0 shadow-sm rounded-4 card-hover-effect">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <div class="<?= str_replace('text-', 'bg-', $status_badge) ?> rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="bi bi-file-earmark-text"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0 small text-dark"><?= $r['jenis_surat'] ?></h6>
                                    <small class="text-muted" style="font-size: 10px;"><?= date('d M Y, H:i', strtotime($r['created_at'])) ?></small>
                                </div>
                            </div>
                            <span class="badge <?= $status_badge ?> rounded-pill" style="font-size: 9px;"><?= $r['status'] ?></span>
                        </div>
                         <div class="mt-2 pt-2 border-top">
                            <small class="text-muted fst-italic" style="font-size: 11px;">Keperluan: <?= $r['keperluan'] ?></small>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="mb-5 pb-5"></div>

</main>

<!-- Modal Form Pengajuan -->
<div class="modal fade" id="formModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-bottom-sheet">
        <div class="modal-content border-0 shadow-lg rounded-top-4">
            <div class="modal-header border-0 pb-0 justify-content-center position-relative">
                <div class="bg-secondary opacity-25 rounded-pill position-absolute top-0 mt-2" style="width: 40px; height: 4px;"></div>
                <h6 class="modal-title fw-bold mt-3" id="modalTitle">Form Pengajuan</h6>
                <button type="button" class="btn-close position-absolute end-0 top-0 m-3" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('user/surat/submit') ?>" method="POST">
                <div class="modal-body p-4">
                    <input type="hidden" name="jenis_surat" id="inputJenisSurat">
                    
                    <div class="text-center mb-4">
                        <div class="bg-primary bg-opacity-10 rounded-circle mx-auto d-flex align-items-center justify-content-center mb-2" style="width: 60px; height: 60px;">
                             <i class="bi bi-pencil-square text-primary fs-2"></i>
                        </div>
                        <p class="text-muted small">Silakan lengkapi data permohonan surat di bawah ini.</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Keperluan Surat / Keterangan</label>
                        <textarea name="keperluan" class="form-control rounded-4 bg-light border-0 p-3" rows="4" placeholder="Contoh: Untuk persyaratan administrasi pernikahan, melamar pekerjaan, dll..." required></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-3 fw-bold shadow-sm">
                        Ajukan Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showForm(type) {
    let title = '';
    let jenis = '';
    switch(type) {
        case 'sp': 
            title = 'Ajukan Surat Pengantar'; 
            jenis = 'Surat Pengantar';
            break;
        case 'domisili': 
            title = 'Ajukan Ket. Domisili'; 
            jenis = 'Keterangan Domisili';
            break;
        case 'keramaian': 
            title = 'Ajukan Izin Keramaian'; 
            jenis = 'Izin Keramaian';
            break;
        case 'kematian': 
            title = 'Lapor Kematian'; 
            jenis = 'Keterangan Kematian';
            break;
    }
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('inputJenisSurat').value = jenis;
    new bootstrap.Modal(document.getElementById('formModal')).show();
}
</script>

<?php $this->load->view('user/templates/footer'); ?>
