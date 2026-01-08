<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Pengaduan - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <style>
         .status-badge { font-size: 11px; padding: 4px 10px; border-radius: 50px; font-weight: 600; text-transform: uppercase; }
        .status-pending { background: #fef3c7; color: #d97706; }
        .status-proses { background: #dbeafe; color: #2563eb; }
        .status-selesai { background: #dcfce7; color: #16a34a; }
        .status-ditolak { background: #fee2e2; color: #dc2626; }
        .lapor-img { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; cursor: pointer; }
    </style>
</head>
<body class="bg-light">

    <?php $this->load->view('admin/templates/navbar'); ?>

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold m-0 text-danger"><i class="bi bi-megaphone-fill me-2"></i>Pengaduan Warga</h3>
                <p class="text-muted m-0">Kelola laporan dan aspirasi dari warga</p>
            </div>
             <div class="btn-group shadow-sm">
                <a href="<?= base_url('admin/pengaduan') ?>" class="btn btn-light border <?= empty($_GET['status']) ? 'active fw-bold' : '' ?>">Semua</a>
                <a href="?status=pending" class="btn btn-light border <?= (isset($_GET['status']) && $_GET['status']=='pending') ? 'active fw-bold text-warning' : '' ?>">Pending</a>
                <a href="?status=proses" class="btn btn-light border <?= (isset($_GET['status']) && $_GET['status']=='proses') ? 'active fw-bold text-primary' : '' ?>">Proses</a>
            </div>
        </div>
        
        <?php if ($this->session->flashdata('success_msg')): ?>
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i><?= $this->session->flashdata('success_msg') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3">Tgl Lapor</th>
                                <th>Pelapor</th>
                                <th>Judul & Isi</th>
                                <th>Bukti</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($laporan)): ?>
                                <?php foreach($laporan as $row): ?>
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold"><?= date('d M Y', strtotime($row['created_at'])) ?></div>
                                        <small class="text-muted"><?= date('H:i', strtotime($row['created_at'])) ?></small>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark"><?= $row['nama_lengkap'] ?></div>
                                        <small class="text-muted">Blok <?= $row['blok'] ?>/<?= $row['no_rumah'] ?></small>
                                    </td>
                                    <td style="max-width: 300px;">
                                        <div class="fw-bold text-dark mb-1">
                                            <span class="badge bg-secondary me-1"><?= $row['kategori'] ?></span>
                                            <?= $row['judul'] ?>
                                        </div>
                                        <p class="small text-secondary m-0 text-truncate"><?= $row['deskripsi'] ?></p>
                                        <?php if($row['tanggapan']): ?>
                                            <small class="text-success fst-italic mt-1 d-block"><i class="bi bi-reply me-1"></i><?= substr($row['tanggapan'],0,30) ?>...</small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($row['foto']): ?>
                                            <img src="<?= base_url('assets/uploads/laporan/'.$row['foto']) ?>" class="lapor-img bg-light border" onclick="showImageModal(this.src)">
                                        <?php else: ?>
                                            <span class="text-muted small">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="status-badge status-<?= strtolower($row['status']) ?>"><?= $row['status'] ?></span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-outline-primary btn-sm rounded-pill px-3" onclick='openRespond(<?= json_encode($row) ?>)'>
                                            <i class="bi bi-pencil-square me-1"></i>Respon
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="6" class="text-center py-5 text-muted">Tidak ada laporan ditemukan.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Respond Modal -->
    <div class="modal fade" id="respondModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content rounded-4" action="<?= base_url('admin/pengaduan/update_status') ?>" method="POST">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Tindak Lanjuti Laporan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" name="id" id="resp_id">
                    
                    <div class="bg-light p-3 rounded-3 mb-3">
                        <small class="text-muted d-block fw-bold mb-1">LAPORAN:</small>
                        <h6 class="fw-bold mb-1" id="resp_judul">Judul</h6>
                        <p class="small mb-0 text-secondary" id="resp_isi">Isi...</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">UPDATE STATUS</label>
                        <select name="status" id="resp_status" class="form-select form-select-lg">
                            <option value="Pending">Pending</option>
                            <option value="Proses">Sedang Diproses</option>
                            <option value="Selesai">Selesai</option>
                            <option value="Ditolak">Ditolak</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">TANGGAPAN / BALASAN</label>
                        <textarea name="tanggapan" id="resp_tanggapan" class="form-control" rows="3" placeholder="Tulis balasan untuk warga..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="submit" class="btn btn-primary w-100 py-2">Simpan Update</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-transparent border-0 shadow-none">
                 <button type="button" class="btn-close btn-close-white ms-auto mb-2" data-bs-dismiss="modal"></button>
                <div class="modal-body text-center p-0">
                    <img id="modalImage" src="" class="img-fluid rounded shadow-lg" style="max-height: 85vh;">
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openRespond(data) {
            document.getElementById('resp_id').value = data.id;
            document.getElementById('resp_judul').innerText = data.judul;
            document.getElementById('resp_isi').innerText = data.deskripsi;
            document.getElementById('resp_status').value = data.status;
            document.getElementById('resp_tanggapan').value = data.tanggapan || '';
            
            new bootstrap.Modal(document.getElementById('respondModal')).show();
        }
        function showImageModal(src) {
            document.getElementById('modalImage').src = src;
            new bootstrap.Modal(document.getElementById('imageModal')).show();
        }
    </script>
</body>
</html>
