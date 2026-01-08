<?php $page_title = 'Iuran Saya'; ?>
<?php $this->load->view('user/templates/header'); ?>

<main class="container py-4">
    <!-- Page Header -->
    <div class="mb-4">
        <h2 class="fw-bold mb-1">Iuran Saya</h2>
        <p class="text-muted mb-0">Bayar iuran dan lihat riwayat pembayaran</p>
    </div>

    <!-- Alert Messages -->
    <?php if ($this->session->flashdata('success_msg')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i><?= $this->session->flashdata('success_msg') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error_msg')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i><?= $this->session->flashdata('error_msg') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <!-- Iuran Aktif -->
    <div class="mb-4">
        <h5 class="fw-bold mb-3">Iuran Aktif</h5>
        <div class="row g-3">
            <?php foreach($iuran_aktif as $iuran): ?>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h6 class="fw-bold mb-1"><?= $iuran['nama_iuran'] ?></h6>
                                <small class="text-muted"><?= $iuran['keterangan'] ?></small>
                            </div>
                            <div class="bg-success-subtle text-success rounded-pill px-3 py-1">
                                <small class="fw-bold">Rp <?= number_format($iuran['nominal'], 0, ',', '.') ?></small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">
                                <i class="bi bi-calendar-event me-1"></i>
                                Jatuh Tempo: <?= date('d M Y', strtotime($iuran['jatuh_tempo'])) ?>
                            </small>
                        </div>
                        <button class="btn btn-primary w-100" onclick="showUploadModal(<?= $iuran['id'] ?>, '<?= $iuran['nama_iuran'] ?>', <?= $iuran['nominal'] ?>)">
                            <i class="bi bi-upload me-2"></i>Upload Bukti Bayar
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Riwayat Pembayaran -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-3">Riwayat Pembayaran</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0">Tanggal</th>
                            <th class="border-0">Jenis Iuran</th>
                            <th class="border-0">Nominal</th>
                            <th class="border-0">Status</th>
                            <th class="border-0">Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($riwayat_bayar)): ?>
                            <?php foreach($riwayat_bayar as $row): ?>
                            <tr>
                                <td><?= date('d M Y', strtotime($row['tgl_bayar'])) ?></td>
                                <td><?= $row['nama_iuran'] ?></td>
                                <td>Rp <?= number_format($row['nominal'], 0, ',', '.') ?></td>
                                <td>
                                    <?php if($row['status'] == 'pending'): ?>
                                        <span class="badge bg-warning">Menunggu Verifikasi</span>
                                    <?php elseif($row['status'] == 'disetujui'): ?>
                                        <span class="badge bg-success">Disetujui</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Ditolak</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($row['status'] == 'ditolak' && !empty($row['catatan_admin'])): ?>
                                        <small class="text-danger"><?= $row['catatan_admin'] ?></small>
                                    <?php else: ?>
                                        <small class="text-muted">-</small>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    Belum ada riwayat pembayaran
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Upload Bukti Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('user/iuran/upload') ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="iuran_id" id="upload_iuran_id">
                <div class="modal-body p-4">
                    <div class="alert alert-info mb-3">
                        <strong id="upload_nama_iuran"></strong><br>
                        <small>Nominal: <span id="upload_nominal"></span></small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Bukti Transfer *</label>
                        <input type="file" name="bukti_transfer" class="form-control" accept="image/*,application/pdf" required>
                        <small class="text-muted">Format: JPG, PNG, atau PDF. Maksimal 2MB</small>
                    </div>
                    
                    <div class="alert alert-warning">
                        <small>
                            <i class="bi bi-info-circle me-1"></i>
                            <strong>Petunjuk:</strong><br>
                            1. Pastikan foto/scan bukti transfer jelas dan terbaca<br>
                            2. Nominal transfer harus sesuai dengan jumlah iuran<br>
                            3. Pembayaran akan diverifikasi oleh admin
                        </small>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Upload Bukti</button>
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
