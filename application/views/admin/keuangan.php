<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Kelola Iuran - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin-mobile.css') ?>">
</head>
<body class="bg-light">
    <?php $this->load->view('admin/templates/navbar'); ?>

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-column flex-md-row align-items-start">
            <div class="mb-3 mb-md-0">
                <h3 class="fw-bold m-0">Keuangan & Iuran</h3>
                <p class="text-muted m-0">Verifikasi pembayaran warga dan kelola tagihan</p>
            </div>
            <button class="btn btn-primary w-100 w-md-auto" data-bs-toggle="modal" data-bs-target="#addMaster">
                <i class="bi bi-plus-lg me-2"></i> Buat Tagihan
            </button>
        </div>

        <?php if ($this->session->flashdata('success_msg')): ?>
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i><?= $this->session->flashdata('success_msg') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <div class="row g-4">
            <!-- Left Column: Pending & Active Bills -->
            <div class="col-lg-8">
                
                <!-- Pending Verification Section -->
                <?php if(count($pending_data) > 0): ?>
                <div class="card border-0 shadow-sm rounded-4 mb-4 border-start border-4 border-warning">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                        <div class="d-flex align-items-center gap-2 text-warning">
                            <i class="bi bi-exclamation-circle-fill fs-5"></i>
                            <h5 class="fw-bold mb-0 text-dark">Menunggu Verifikasi (<?= count($pending_data) ?>)</h5>
                        </div>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <div class="d-flex flex-column gap-3">
                            <?php foreach($pending_data as $row): ?>
                            <div class="p-3 bg-white border rounded-3 hover-shadow transition-all d-flex align-items-center justify-content-between flex-wrap gap-3">
                                <div class="d-flex align-items-center gap-3 w-100 w-md-auto">
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center text-muted fw-bold flex-shrink-0" style="width:45px;height:45px;">
                                        <?= substr($row['nama_lengkap'], 0, 1) ?>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-0 text-dark"><?= $row['nama_lengkap'] ?></h6>
                                        <div class="small text-muted">Blok <?= $row['blok'] ?>/<?= $row['no_rumah'] ?> &bull; <span class="text-primary"><?= $row['nama_iuran'] ?></span></div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-3 w-100 w-md-auto justify-content-between mt-2 mt-md-0">
                                    <div class="text-end">
                                        <div class="fw-bold text-success fs-5">Rp <?= number_format($row['nominal'],0,',','.') ?></div>
                                        <small class="text-muted"><?= date('d M Y', strtotime($row['tgl_bayar'])) ?></small>
                                    </div>
                                    <div class="vr mx-2"></div>
                                    <button class="btn btn-sm btn-outline-secondary rounded-pill" onclick="showImage('<?= $row['bukti_transfer'] ?>')">
                                        <i class="bi bi-image"></i>
                                    </button>
                                    <button class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#verifyModal<?= $row['id'] ?>">
                                        Verifikasi
                                    </button>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                    <div class="alert alert-success border-0 shadow-sm d-flex align-items-center gap-3 rounded-4 mb-4">
                        <i class="bi bi-check-circle-fill fs-4"></i>
                        <div>Semua pembayaran telah diverifikasi. Kerja bagus!</div>
                    </div>
                <?php endif; ?>

                <!-- Active Bills List -->
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                        <h5 class="fw-bold mb-0">Daftar Tagihan Aktif</h5>
                    </div>
                    <div class="card-body px-0 pt-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4">Nama Tagihan</th>
                                        <th>Nominal</th>
                                        <th>Jatuh Tempo</th>
                                        <th class="text-end pe-4">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($masters as $m): 
                                        $is_expired = strtotime($m['jatuh_tempo']) < time();
                                    ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-dark"><?= $m['nama_iuran'] ?></td>
                                        <td>Rp <?= number_format($m['nominal'],0,',','.') ?></td>
                                        <td class="text-muted"><?= date('d M Y', strtotime($m['jatuh_tempo'])) ?></td>
                                        <td class="text-end pe-4">
                                            <?php if($is_expired): ?>
                                                <span class="badge bg-secondary-subtle text-secondary rounded-pill">Selesai</span>
                                            <?php else: ?>
                                                <span class="badge bg-success-subtle text-success rounded-pill">Aktif</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: History -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                        <h5 class="fw-bold mb-0">Riwayat Terakhir</h5>
                    </div>
                    <div class="card-body px-4">
                        <div class="d-flex flex-column gap-3">
                            <?php if(!empty($history)): ?>
                            <?php foreach($history as $h): ?>
                            <div class="d-flex gap-3 align-items-start border-bottom pb-3">
                                <div class="mt-1">
                                    <?php if($h['status'] == 'disetujui'): ?>
                                        <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                    <?php else: ?>
                                        <i class="bi bi-x-circle-fill text-danger fs-5"></i>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1 text-dark"><?= $h['nama_lengkap'] ?></h6>
                                    <p class="small text-muted mb-1 lh-sm">
                                        <?= $h['nama_iuran'] ?> 
                                    </p>
                                    <small class="text-muted" style="font-size: 0.75rem;">
                                        <?= date('d/m/Y H:i', strtotime($h['tgl_bayar'])) ?>
                                    </small>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-muted text-center py-4">Belum ada riwayat.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 1. Verify Modals -->
    <?php foreach($pending_data as $row): ?>
    <div class="modal fade" id="verifyModal<?= $row['id'] ?>" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" action="<?= base_url('admin/keuangan/verify') ?>" method="POST">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Verifikasi Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    
                    <div class="text-center py-4 bg-light rounded-3 mb-4">
                        <h1 class="text-success fw-bold mb-0">Rp <?= number_format($row['nominal']) ?></h1>
                        <p class="text-muted mb-0"><?= $row['nama_iuran'] ?> - <?= $row['nama_lengkap'] ?></p>
                    </div>

                    <?php if(!empty($row['bukti_transfer'])): ?>
                    <div class="mb-3 text-center">
                        <button type="button" class="btn btn-outline-primary btn-sm rounded-pill" onclick="showImage('<?= $row['bukti_transfer'] ?>')">
                            <i class="bi bi-image me-1"></i> Lihat Bukti Transfer
                        </button>
                    </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Keputusan</label>
                        <select name="status" class="form-select" required>
                            <option value="disetujui">✅ TERIMA (Valid)</option>
                            <option value="ditolak">❌ TOLAK (Tidak Valid)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Catatan</label>
                        <textarea name="catatan" class="form-control" rows="2" placeholder="Opsional..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    <?php endforeach; ?>

    <!-- 2. Add Master Modal -->
    <div class="modal fade" id="addMaster" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" action="<?= base_url('admin/keuangan/add_master') ?>" method="POST">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Buat Tagihan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Tagihan</label>
                        <input type="text" name="nama_iuran" class="form-control" placeholder="Contoh: Iuran Warga Maret 2026" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nominal (Rp)</label>
                        <input type="number" name="nominal" class="form-control" placeholder="100000" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Batas Waktu</label>
                        <input type="date" name="jatuh_tempo" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-primary px-4">Terbitkan</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- 3. Image Preview Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-transparent border-0 shadow-none">
                <div class="modal-body text-center position-relative">
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"></button>
                    <img id="previewImage" src="" class="img-fluid rounded shadow-lg" style="max-height: 85vh; background: #fff;">
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showImage(src) {
            if(!src) {
                alert("Tidak ada gambar bukti transfer.");
                return;
            }
            const fullPath = '<?= base_url("assets/images/bukti_iuran/") ?>' + src;
            document.getElementById('previewImage').src = fullPath;
            new bootstrap.Modal(document.getElementById('imageModal')).show();
        }
    </script>
</body>
</html>
