<?php $page_title = 'Iuran Saya'; ?>
<?php $this->load->view('user/templates/header'); ?>

<!-- Header with Gradient -->
<div class="header-section" style="background: linear-gradient(135deg, #022c22 0%, #14532d 100%); padding: 30px 20px 80px; color: white; border-radius: 0 0 30px 30px; position: relative; z-index: 1;">
    <div class="d-flex align-items-center gap-3">
        <a href="<?= base_url('user/dashboard') ?>" class="text-white text-decoration-none bg-white bg-opacity-10 rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div class="flex-grow-1">
            <h5 class="fw-bold mb-0">Iuran Warga</h5>
            <p class="mb-0 small opacity-75">Kewajiban bulanan warga</p>
        </div>
        <a href="<?= base_url('user/kas') ?>" class="btn btn-sm border-0 text-white rounded-pill px-3 shadow-none" style="background: rgba(255,255,255,0.2);">
            <i class="bi bi-wallet2 me-1"></i> Cek Kas
        </a>
    </div>
</div>

<main class="container py-4" style="margin-top: -60px; position: relative; z-index: 2;">

    <!-- Alert Messages -->
    <?php if ($this->session->flashdata('success_msg')): ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-4 mb-3 small" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i><?= $this->session->flashdata('success_msg') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error_msg')): ?>
    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 rounded-4 mb-3 small" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i><?= $this->session->flashdata('error_msg') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <!-- Iuran Aktif (Tagihan) -->
    <h6 class="fw-bold mb-3 px-1 text-white small text-uppercase ls-1 opacity-75">Tagihan Tersedia</h6>
    <div class="row g-3 mb-4">
        <?php foreach($iuran_aktif as $iuran): ?>
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 card-hover-effect">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex gap-3 align-items-center">
                             <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="bi bi-receipt-cutoff text-primary fs-4"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0 text-dark"><?= $iuran['nama_iuran'] ?></h6>
                                <small class="text-muted"><?= $iuran['keterangan'] ?></small>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="d-block fw-bold text-primary fs-5">Rp <?= number_format($iuran['nominal'], 0, ',', '.') ?></span>
                            <span class="badge bg-light text-secondary border rounded-pill" style="font-size: 10px;">
                                Jatuh Tempo: <?= date('d M Y', strtotime($iuran['jatuh_tempo'])) ?>
                            </span>
                        </div>
                    </div>
                    <button class="btn btn-primary w-100 rounded-pill py-2 fw-bold shadow-sm" onclick="showUploadModal(<?= $iuran['id'] ?>, '<?= $iuran['nama_iuran'] ?>', <?= $iuran['nominal'] ?>)">
                        <i class="bi bi-upload me-2"></i>Upload Bukti Bayar
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Riwayat Pembayaran (Card List) -->
    <h6 class="fw-bold mb-3 px-1 text-secondary small text-uppercase ls-1">Riwayat Pembayaran</h6>
    
    <?php if(empty($riwayat_bayar)): ?>
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body text-center py-5">
                <img src="https://cdn-icons-png.flaticon.com/512/2761/2761118.png" width="60" class="mb-3 opacity-25" alt="No Data">
                <p class="text-muted small mb-0">Belum ada riwayat pembayaran</p>
            </div>
        </div>
    <?php else: ?>
        <div class="d-flex flex-column gap-3">
            <?php foreach($riwayat_bayar as $row): ?>
            <div class="card border-0 shadow-sm rounded-4 card-hover-effect">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                <?php if($row['status'] == 'Lunas' || $row['status'] == 'disetujui'): ?>
                                    <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                <?php elseif($row['status'] == 'pending' || $row['status'] == 'Menunggu Validasi'): ?>
                                    <i class="bi bi-clock-history text-warning fs-5"></i>
                                <?php else: ?>
                                    <i class="bi bi-x-circle-fill text-danger fs-5"></i>
                                <?php endif; ?>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0 text-dark small"><?= $row['nama_iuran'] ?></h6>
                                <small class="text-muted" style="font-size: 11px;">
                                    <?= date('d M Y', strtotime($row['tgl_bayar'])) ?>
                                </small>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="fw-bold text-dark d-block small">Rp <?= number_format($row['nominal'], 0, ',', '.') ?></span>
                            <?php if($row['status'] == 'Lunas' || $row['status'] == 'disetujui'): ?>
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill" style="font-size: 9px;">Lunas</span>
                            <?php elseif($row['status'] == 'pending' || $row['status'] == 'Menunggu Validasi'): ?>
                                <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill" style="font-size: 9px;">Menunggu</span>
                            <?php else: ?>
                                <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill" style="font-size: 9px;"><?= ucfirst($row['status']) ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                     <?php if($row['status'] == 'ditolak' && !empty($row['catatan_admin'])): ?>
                        <div class="mt-2 pt-2 border-top">
                            <small class="text-danger fst-italic" style="font-size: 11px;">
                                <i class="bi bi-info-circle me-1"></i> Catatan: <?= $row['catatan_admin'] ?>
                            </small>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="mb-5 pb-5"></div> 
</main>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-bottom-sheet">
        <div class="modal-content border-0 shadow-lg rounded-top-4">
            <div class="modal-header border-0 pb-0 justify-content-center position-relative">
                <div class="bg-secondary opacity-25 rounded-pill position-absolute top-0 mt-2" style="width: 40px; height: 4px;"></div>
                <h6 class="modal-title fw-bold mt-3">Upload Bukti Pembayaran</h6>
                <button type="button" class="btn-close position-absolute end-0 top-0 m-3" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('user/iuran/upload') ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="iuran_id" id="upload_iuran_id">
                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <div class="bg-primary bg-opacity-10 rounded-circle mx-auto d-flex align-items-center justify-content-center mb-2" style="width: 60px; height: 60px;">
                             <i class="bi bi-receipt text-primary fs-2"></i>
                        </div>
                        <h5 id="upload_nama_iuran" class="fw-bold mb-1"></h5>
                        <p id="upload_nominal" class="text-primary fw-bold fs-4 mb-0"></p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">File Bukti Transfer</label>
                        <div class="upload-box border border-2 border-dashed rounded-4 p-4 text-center bg-light">
                            <i class="bi bi-camera fs-3 text-muted mb-2"></i>
                            <input type="file" name="bukti_transfer" class="form-control" accept="image/*,application/pdf" required>
                            <small class="text-muted d-block mt-2" style="font-size: 10px;">Format: JPG, PNG, PDF (Max 2MB)</small>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-3 fw-bold shadow-sm">
                        Kirim Bukti Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showUploadModal(id, nama, nominal) {
    document.getElementById('upload_iuran_id').value = id;
    document.getElementById('upload_nama_iuran').textContent = nama;
    document.getElementById('upload_nominal').textContent = 'Rp ' + nominal.toLocaleString('id-ID');
    
    new bootstrap.Modal(document.getElementById('uploadModal')).show();
}
</script>

<?php $this->load->view('user/templates/footer'); ?>
