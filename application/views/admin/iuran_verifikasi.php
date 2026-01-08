<?php $page_title = 'Verifikasi Pembayaran Iuran'; ?>
<?php $this->load->view('admin/templates/header'); ?>

<main class="container py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Verifikasi Pembayaran</h2>
            <p class="text-muted mb-0">Periksa dan setujui bukti pembayaran iuran warga</p>
        </div>
        <a href="<?= base_url('admin/iuran') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Alert Messages -->
    <?php if ($this->session->flashdata('success_msg')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i><?= $this->session->flashdata('success_msg') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <!-- Filter Tabs -->
    <ul class="nav nav-pills mb-4" id="statusTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pending-tab" data-bs-toggle="pill" data-bs-target="#pending" type="button">
                <i class="bi bi-hourglass-split me-2"></i>Pending
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="approved-tab" data-bs-toggle="pill" data-bs-target="#approved" type="button">
                <i class="bi bi-check-circle me-2"></i>Disetujui
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="rejected-tab" data-bs-toggle="pill" data-bs-target="#rejected" type="button">
                <i class="bi bi-x-circle me-2"></i>Ditolak
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="statusTabContent">
        <!-- Pending Tab -->
        <div class="tab-pane fade show active" id="pending" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3">Warga</th>
                                    <th>Jenis Iuran</th>
                                    <th>Nominal</th>
                                    <th>Tanggal Upload</th>
                                    <th>Bukti Transfer</th>
                                    <th class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $pending = array_filter($pembayaran_list, function($p) { return $p['status'] == 'pending'; });
                                if(!empty($pending)): 
                                    foreach($pending as $row): 
                                ?>
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-semibold"><?= $row['nama_lengkap'] ?></div>
                                        <small class="text-muted">Blok <?= $row['blok'] ?> No. <?= $row['no_rumah'] ?></small>
                                    </td>
                                    <td><?= $row['nama_iuran'] ?></td>
                                    <td><span class="badge bg-success-subtle text-success">Rp <?= number_format($row['nominal'], 0, ',', '.') ?></span></td>
                                    <td><?= date('d M Y H:i', strtotime($row['tgl_bayar'])) ?></td>
                                    <td>
                                        <a href="<?= base_url('assets/uploads/bukti_transfer/'.$row['bukti_transfer']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-image me-1"></i>Lihat Bukti
                                        </a>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= base_url('admin/iuran/approve/'.$row['id']) ?>" class="btn btn-success" onclick="return confirm('Setujui pembayaran ini?')">
                                                <i class="bi bi-check-lg"></i> Setujui
                                            </a>
                                            <button class="btn btn-danger" onclick="showRejectModal(<?= $row['id'] ?>, '<?= $row['nama_lengkap'] ?>')">
                                                <i class="bi bi-x-lg"></i> Tolak
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php 
                                    endforeach;
                                else: 
                                ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        Tidak ada pembayaran yang menunggu verifikasi
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Approved Tab -->
        <div class="tab-pane fade" id="approved" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3">Warga</th>
                                    <th>Jenis Iuran</th>
                                    <th>Nominal</th>
                                    <th>Tanggal Bayar</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $approved = array_filter($pembayaran_list, function($p) { return $p['status'] == 'disetujui'; });
                                if(!empty($approved)): 
                                    foreach($approved as $row): 
                                ?>
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-semibold"><?= $row['nama_lengkap'] ?></div>
                                        <small class="text-muted">Blok <?= $row['blok'] ?> No. <?= $row['no_rumah'] ?></small>
                                    </td>
                                    <td><?= $row['nama_iuran'] ?></td>
                                    <td>Rp <?= number_format($row['nominal'], 0, ',', '.') ?></td>
                                    <td><?= date('d M Y', strtotime($row['tgl_bayar'])) ?></td>
                                    <td><span class="badge bg-success">Disetujui</span></td>
                                </tr>
                                <?php 
                                    endforeach;
                                else: 
                                ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">Belum ada pembayaran yang disetujui</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rejected Tab -->
        <div class="tab-pane fade" id="rejected" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3">Warga</th>
                                    <th>Jenis Iuran</th>
                                    <th>Nominal</th>
                                    <th>Tanggal Upload</th>
                                    <th>Catatan Admin</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $rejected = array_filter($pembayaran_list, function($p) { return $p['status'] == 'ditolak'; });
                                if(!empty($rejected)): 
                                    foreach($rejected as $row): 
                                ?>
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-semibold"><?= $row['nama_lengkap'] ?></div>
                                        <small class="text-muted">Blok <?= $row['blok'] ?> No. <?= $row['no_rumah'] ?></small>
                                    </td>
                                    <td><?= $row['nama_iuran'] ?></td>
                                    <td>Rp <?= number_format($row['nominal'], 0, ',', '.') ?></td>
                                    <td><?= date('d M Y', strtotime($row['tgl_bayar'])) ?></td>
                                    <td><small class="text-danger"><?= $row['catatan_admin'] ?? '-' ?></small></td>
                                </tr>
                                <?php 
                                    endforeach;
                                else: 
                                ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">Tidak ada pembayaran yang ditolak</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0 bg-danger text-white rounded-top-4">
                <h5 class="modal-title fw-bold">Tolak Pembayaran</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('admin/iuran/reject') ?>" method="POST">
                <input type="hidden" name="pembayaran_id" id="reject_id">
                <div class="modal-body p-4">
                    <p class="mb-3">Anda akan menolak pembayaran dari: <strong id="reject_nama"></strong></p>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Alasan Penolakan *</label>
                        <textarea name="catatan_admin" class="form-control" rows="3" required placeholder="Contoh: Bukti transfer tidak jelas, nominal tidak sesuai, dll"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak Pembayaran</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showRejectModal(id, nama) {
    document.getElementById('reject_id').value = id;
    document.getElementById('reject_nama').textContent = nama;
    new bootstrap.Modal(document.getElementById('rejectModal')).show();
}
</script>

<?php $this->load->view('admin/templates/footer'); ?>
