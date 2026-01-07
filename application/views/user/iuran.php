<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Iuran Warga - FKKMBT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/mobile.css?v='.time()) ?>">
    <style>
        .bill-card { border-left: 4px solid var(--danger-color); }
        .paid-card { border-left: 4px solid var(--success-color); }
        .status-badge { font-size: 10px; padding: 4px 10px; border-radius: 50px; font-weight: 700; text-transform: uppercase; }
        .bg-pending { background: #fef3c7; color: #d97706; }
        .bg-disetujui { background: #dcfce7; color: #16a34a; }
        .bg-ditolak { background: #fee2e2; color: #dc2626; }
    </style>
</head>
<body class="bg-light">

    <!-- Mobile App Bar -->
    <div class="app-bar d-lg-none">
        <div class="d-flex align-items-center gap-3">
            <a href="<?= base_url('user/dashboard') ?>" class="text-white"><i class="bi bi-chevron-left fs-4"></i></a>
            <span class="fw-bold">Iuran & Keuangan</span>
        </div>
    </div>

    <main class="container py-3">
        <!-- Summary Section -->
        <section class="mb-4">
            <div class="card bg-white shadow-none mb-3">
                <div class="card-body">
                    <small class="text-muted d-block mb-1">Total Tagihan Tertunda</small>
                    <h2 class="fw-bold text-danger mb-0">
                        <?php 
                        $total_unpaid = array_sum(array_column($tagihan, 'nominal'));
                        echo 'Rp ' . number_format($total_unpaid, 0, ',', '.');
                        ?>
                    </h2>
                </div>
            </div>
        </section>

        <!-- Unpaid Bills -->
        <section class="mb-4">
            <h5 class="fw-bold mb-3 d-flex justify-content-between">
                Tagihan Aktif
                <span class="badge bg-danger rounded-pill fw-normal" style="font-size: 10px;"><?= count($tagihan) ?></span>
            </h5>
            <?php if(empty($tagihan)): ?>
                <div class="card border-0 text-center py-4 bg-white shadow-none">
                    <i class="bi bi-check-circle-fill text-success fs-1 mb-2"></i>
                    <p class="text-muted small mb-0">Semua iuran sudah terbayar. Terima kasih!</p>
                </div>
            <?php else: ?>
                <?php foreach($tagihan as $t): ?>
                    <div class="card bill-card mb-3 shadow-none">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="fw-bold mb-1"><?= $t['nama_iuran'] ?></h6>
                                    <span class="text-danger fw-bold">Rp <?= number_format($t['nominal'], 0, ',', '.') ?></span>
                                </div>
                                <button class="btn btn-primary btn-sm rounded-pill px-3" onclick="openPayment('<?= $t['id'] ?>', '<?= $t['nama_iuran'] ?>', '<?= $t['nominal'] ?>')">
                                    Bayar
                                </button>
                            </div>
                            <small class="text-muted"><i class="bi bi-info-circle me-1"></i>Tagihan rutin setiap bulan</small>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>

        <!-- History -->
        <section class="mb-5 pb-4">
            <h5 class="fw-bold mb-3">Riwayat Pembayaran</h5>
            <?php if(empty($riwayat)): ?>
                <p class="text-center text-muted small py-4">Belum ada riwayat pembayaran.</p>
            <?php else: ?>
                <?php foreach($riwayat as $r): ?>
                    <div class="card mb-2 shadow-none paid-card">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="fw-bold small"><?= $r['nama_iuran'] ?></span>
                                <span class="status-badge bg-<?= $r['status'] ?>"><?= $r['status'] ?></span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small"><?= date('d M Y, H:i', strtotime($r['tgl_bayar'])) ?></span>
                                <span class="fw-bold text-success" style="font-size: 14px;">Rp <?= number_format($r['nominal'], 0, ',', '.') ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>
    </main>

    <!-- Payment Modal -->
    <div class="modal fade" id="payModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form action="<?= base_url('user/iuran/bayar') ?>" method="POST" enctype="multipart/form-data" class="modal-content rounded-4 border-0">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Upload Bukti Bayar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="bg-light p-3 rounded-4 mb-4">
                        <div class="text-muted small mb-1" id="payTitle">...</div>
                        <h4 class="fw-bold text-primary mb-0" id="payAmount">Rp 0</h4>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">TRANSFER KE:</label>
                        <div class="p-3 border rounded-4 bg-white d-flex align-items-center gap-3">
                            <img src="https://upload.wikimedia.org/wikipedia/id/thumb/5/55/BNI_logo.svg/1200px-BNI_logo.svg.png" style="width: 50px;">
                            <div>
                                <div class="fw-bold">1234567890</div>
                                <div class="small text-muted">A.N FKKMBT BUKIT TIARA</div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="iuran_id" id="payId">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">UNGGAH BUKTI (JPG/PNG)</label>
                        <input type="file" name="bukti" class="form-control" accept="image/*" required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow-sm">Kirim Konfirmasi</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Native Bottom Nav -->
    <?php $this->load->view('templates/mobile_nav'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openPayment(id, title, amount) {
            document.getElementById('payId').value = id;
            document.getElementById('payTitle').innerText = title;
            document.getElementById('payAmount').innerText = 'Rp ' + parseInt(amount).toLocaleString('id-ID');
            new bootstrap.Modal(document.getElementById('payModal')).show();
        }
    </script>
</body>
</html>
