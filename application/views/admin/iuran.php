<?php $page_title = 'Kelola Iuran'; ?>
<?php $this->load->view('admin/templates/header'); ?>

<main class="container py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Kelola Iuran</h2>
            <p class="text-muted mb-0">Atur jenis iuran dan verifikasi pembayaran warga</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="bi bi-plus-circle me-2"></i>Tambah Jenis Iuran
        </button>
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

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-success text-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 opacity-75 small">Pemasukan Bulan Ini</p>
                            <h3 class="fw-bold mb-0">Rp <?= number_format($total_pemasukan, 0, ',', '.') ?></h3>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded-circle p-3">
                            <i class="bi bi-cash-stack fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-warning text-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 opacity-75 small">Menunggu Verifikasi</p>
                            <h3 class="fw-bold mb-0"><?= $jumlah_pending ?> Pembayaran</h3>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded-circle p-3">
                            <i class="bi bi-hourglass-split fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-primary text-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 opacity-75 small">Total Jenis Iuran</p>
                            <h3 class="fw-bold mb-0"><?= count($iuran_list) ?> Jenis</h3>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded-circle p-3">
                            <i class="bi bi-list-check fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mb-4">
        <a href="<?= base_url('admin/iuran/verifikasi') ?>" class="btn btn-outline-warning">
            <i class="bi bi-check-circle me-2"></i>Verifikasi Pembayaran (<?= $jumlah_pending ?>)
        </a>
    </div>

    <!-- Iuran List Table -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-3">Daftar Jenis Iuran</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 ps-4">No</th>
                            <th class="border-0">Nama Iuran</th>
                            <th class="border-0">Nominal</th>
                            <th class="border-0">Jatuh Tempo</th>
                            <th class="border-0">Status</th>
                            <th class="border-0 text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach($iuran_list as $row): ?>
                        <tr>
                            <td class="ps-4"><?= $no++ ?></td>
                            <td>
                                <div class="fw-semibold"><?= $row['nama_iuran'] ?></div>
                                <small class="text-muted"><?= $row['keterangan'] ?></small>
                            </td>
                            <td><span class="badge bg-success-subtle text-success">Rp <?= number_format($row['nominal'], 0, ',', '.') ?></span></td>
                            <td><?= date('d M Y', strtotime($row['jatuh_tempo'])) ?></td>
                            <td>
                                <?php if($row['status'] == 'aktif'): ?>
                                    <span class="badge bg-success">Aktif</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Nonaktif</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-primary" onclick='editIuran(<?= json_encode($row) ?>)'>
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <a href="<?= base_url('admin/iuran/delete/'.$row['id']) ?>" class="btn btn-outline-danger" onclick="return confirm('Hapus iuran ini?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pembayaran Pending Preview -->
    <?php if(!empty($pembayaran_pending)): ?>
    <div class="card border-0 shadow-sm rounded-4 mt-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Pembayaran Menunggu Verifikasi</h5>
                <a href="<?= base_url('admin/iuran/verifikasi') ?>" class="btn btn-sm btn-warning text-white">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0">Warga</th>
                            <th class="border-0">Iuran</th>
                            <th class="border-0">Nominal</th>
                            <th class="border-0">Tanggal Upload</th>
                            <th class="border-0 text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach(array_slice($pembayaran_pending, 0, 5) as $p): ?>
                        <tr>
                            <td>
                                <div class="fw-semibold"><?= $p['nama_lengkap'] ?></div>
                                <small class="text-muted">Blok <?= $p['blok'] ?> No. <?= $p['no_rumah'] ?></small>
                            </td>
                            <td><?= $p['nama_iuran'] ?></td>
                            <td>Rp <?= number_format($p['nominal'], 0, ',', '.') ?></td>
                            <td><?= date('d M Y H:i', strtotime($p['tgl_bayar'])) ?></td>
                            <td class="text-end">
                                <a href="<?= base_url('admin/iuran/verifikasi') ?>" class="btn btn-sm btn-outline-primary">Verifikasi</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>
</main>

<!-- Add Iuran Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Tambah Jenis Iuran Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('admin/iuran/create') ?>" method="POST">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Iuran *</label>
                        <input type="text" name="nama_iuran" class="form-control" required placeholder="Contoh: Iuran Bulanan RT">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="2" placeholder="Deskripsi singkat tentang iuran ini"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Nominal (Rp) *</label>
                            <input type="number" name="nominal" class="form-control" required placeholder="50000">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Jatuh Tempo *</label>
                            <input type="date" name="jatuh_tempo" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Iuran</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Iuran Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Edit Jenis Iuran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('admin/iuran/update') ?>" method="POST">
                <input type="hidden" name="iuran_id" id="edit_id">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Iuran *</label>
                        <input type="text" name="nama_iuran" id="edit_nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Keterangan</label>
                        <textarea name="keterangan" id="edit_keterangan" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Nominal (Rp) *</label>
                            <input type="number" name="nominal" id="edit_nominal" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Jatuh Tempo *</label>
                            <input type="date" name="jatuh_tempo" id="edit_jatuh_tempo" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" id="edit_status" class="form-select">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update Iuran</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editIuran(data) {
    document.getElementById('edit_id').value = data.id;
    document.getElementById('edit_nama').value = data.nama_iuran;
    document.getElementById('edit_keterangan').value = data.keterangan;
    document.getElementById('edit_nominal').value = data.nominal;
    document.getElementById('edit_jatuh_tempo').value = data.jatuh_tempo;
    document.getElementById('edit_status').value = data.status;
    
    new bootstrap.Modal(document.getElementById('editModal')).show();
}
</script>

<?php $this->load->view('admin/templates/footer'); ?>
