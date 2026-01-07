<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Keuangan - FKKMBT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/mobile.css?v='.time()) ?>">
    <style>
        .finance-hero {
            background: var(--primary-gradient);
            padding: 20px 20px 60px;
            border-radius: 0 0 32px 32px;
            color: white;
            position: relative;
        }
        .bill-card {
            background: white;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            transition: transform 0.2s;
            border: 1px solid rgba(0,0,0,0.02);
            position: relative;
            overflow: hidden;
        }
        .bill-card:active { transform: scale(0.98); }
        .bill-card::before {
            content: '';
            position: absolute;
            left: 0; top: 0; bottom: 0;
            width: 6px;
            background: var(--danger-color);
        }
        .history-item {
            background: white;
            padding: 16px;
            border-radius: 16px;
            margin-bottom: 12px;
            border: 1px solid #f1f5f9;
        }
        .icon-box {
            width: 42px; height: 42px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
        }
        .badge-pill {
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body class="bg-light">

    <!-- App Bar -->
    <div class="app-bar d-lg-none shadow-none">
        <div class="d-flex align-items-center gap-3">
            <a href="<?= base_url('user/dashboard') ?>" class="text-white"><i class="bi bi-chevron-left fs-4"></i></a>
            <span class="fw-bold text-white">Dompet Warga</span>
        </div>
    </div>

    <!-- Hero Section -->
    <div class="finance-hero">
        <div class="text-center">
            <span class="opacity-75 small text-uppercase fw-bold ls-1">Total Tagihan Anda</span>
            <?php $total_unpaid = array_sum(array_column($tagihan, 'nominal')); ?>
            <h1 class="display-4 fw-bold mb-0">Rp <?= number_format($total_unpaid, 0, ',', '.') ?></h1>
            <p class="small opacity-75 mt-2 mb-0">Segera selesaikan pembayaran agar layanan tidak terganggu.</p>
        </div>
    </div>

    <main class="container" style="margin-top: -40px; position: relative; z-index: 10;">
        
        <!-- Navigation Tabs (Visual only) -->
        <div class="d-flex justify-content-center gap-2 mb-4">
            <button class="btn btn-light bg-white shadow-sm rounded-pill px-4 fw-bold text-primary">Tagihan</button>
            <button class="btn btn-link text-white text-decoration-none opacity-75 fw-bold" onclick="document.getElementById('historySection').scrollIntoView({behavior: 'smooth'})">Riwayat</button>
        </div>

        <!-- Tagihan Section -->
        <section class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold text-dark text-uppercase small ls-1 mb-0">Menunggu Pembayaran</h6>
                <span class="badge bg-danger rounded-pill"><?= count($tagihan) ?> Item</span>
            </div>

            <?php if(empty($tagihan)): ?>
                <div class="text-center py-5 bg-white rounded-4 shadow-sm">
                    <div class="mb-3">
                        <div class="mx-auto bg-success-subtle rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="bi bi-check-lg fs-1 text-success"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold text-dark">Luar Biasa!</h5>
                    <p class="text-muted small mb-0 px-4">Tidak ada tagihan tertunggak. Terima kasih telah menjadi warga yang taat.</p>
                </div>
            <?php else: ?>
                <?php foreach($tagihan as $t): ?>
                    <div class="bill-card mb-3">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="d-flex gap-3">
                                <div class="icon-box bg-danger-subtle text-danger">
                                    <i class="bi bi-receipt"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-1"><?= $t['nama_iuran'] ?></h6>
                                    <small class="text-muted d-block">Iuran Wajib Bulanan</small>
                                </div>
                            </div>
                            <div class="text-end">
                                <h6 class="fw-bold text-danger mb-0">Rp <?= number_format($t['nominal'], 0, ',', '.') ?></h6>
                            </div>
                        </div>
                        <button class="btn btn-dark w-100 rounded-pill py-2 fw-bold" onclick="openPayment('<?= $t['id'] ?>', '<?= $t['nama_iuran'] ?>', '<?= $t['nominal'] ?>')">
                            Bayar Sekarang <i class="bi bi-arrow-right-short ms-1"></i>
                        </button>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>

        <!-- History Section -->
        <section id="historySection" class="mb-5 pb-5">
            <h6 class="fw-bold text-dark text-uppercase small ls-1 mb-3">Riwayat Transaksi</h6>
            
            <?php if(empty($riwayat)): ?>
                <p class="text-center text-muted small py-4">Belum ada riwayat transaksi.</p>
            <?php else: ?>
                <?php foreach($riwayat as $r): ?>
                    <div class="history-item d-flex justify-content-between align-items-center">
                        <div class="d-flex gap-3 align-items-center">
                            <?php 
                                $status_color = 'warning';
                                $icon = 'bi-clock-history';
                                if($r['status'] == 'disetujui') { $status_color = 'success'; $icon = 'bi-check-circle-fill'; }
                                if($r['status'] == 'ditolak') { $status_color = 'danger'; $icon = 'bi-x-circle-fill'; }
                            ?>
                            <div class="icon-box bg-<?= $status_color ?>-subtle text-<?= $status_color ?>">
                                <i class="bi <?= $icon ?>"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0" style="font-size: 14px;"><?= $r['nama_iuran'] ?></h6>
                                <small class="text-muted" style="font-size: 11px;"><?= date('d M Y • H:i', strtotime($r['tgl_bayar'])) ?></small>
                            </div>
                        </div>
                        <div class="text-end">
                            <h6 class="fw-bold text-<?= $status_color ?> mb-1" style="font-size: 14px;">Rp <?= number_format($r['nominal'], 0, ',', '.') ?></h6>
                            <span class="badge bg-<?= $status_color ?>-subtle text-<?= $status_color ?> rounded-pill" style="font-size: 9px; padding: 2px 8px;"><?= strtoupper($r['status']) ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>

    </main>

    <!-- Payment Modal (Bottom Sheet Style) -->
    <div class="modal fade" id="payModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-bottom modal-dialog-scrollable">
            <form action="<?= base_url('user/iuran/bayar') ?>" method="POST" enctype="multipart/form-data" class="modal-content rounded-top-5 border-0">
                <div class="modal-header border-0 pb-0 justify-content-center">
                    <div style="width: 50px; height: 5px; background: #e2e8f0; border-radius: 10px;"></div>
                </div>
                <div class="modal-body pt-4 px-4 pb-0">
                    <div class="text-center mb-4">
                        <div class="text-muted small fw-bold text-uppercase ls-1">Konfirmasi Pembayaran</div>
                        <h2 class="fw-bold text-dark mt-1" id="payAmount">Rp 0</h2>
                        <span class="badge bg-light text-dark border px-3 py-2 rounded-pill mt-2" id="payTitle">...</span>
                    </div>

                    <div class="card bg-light border-0 rounded-4 p-3 mb-4">
                        <div class="d-flex gap-3 align-items-center">
                            <div class="bg-white p-2 rounded-3 shadow-sm">
                                <img src="https://upload.wikimedia.org/wikipedia/id/thumb/5/55/BNI_logo.svg/1200px-BNI_logo.svg.png" style="height: 20px;">
                            </div>
                            <div>
                                <small class="text-muted d-block" style="font-size: 10px;">REKENING TUJUAN</small>
                                <span class="fw-bold">1234 567 890 (FKKMBT)</span>
                            </div>
                            <button type="button" class="btn btn-white btn-sm ms-auto shadow-sm rounded-circle"><i class="bi bi-copy"></i></button>
                        </div>
                    </div>

                    <input type="hidden" name="iuran_id" id="payId">
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">UPLOAD BUKTI TRANSFER</label>
                        <input type="file" name="bukti" class="form-control form-control-lg fs-6" accept="image/*" required style="border-radius: 16px;">
                        <small class="text-muted" style="font-size: 10px;">Format: JPG, PNG. Maks 2MB</small>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4">
                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-4 fw-bold shadow-lg">Kirim Konfirmasi</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .modal-dialog-bottom {
            margin: 0;
            display: flex;
            align-items: flex-end;
            min-height: 100%;
        }
        .modal.fade .modal-dialog-bottom {
            transform: translate(0, 100%);
        }
        .modal.show .modal-dialog-bottom {
            transform: none;
            transition: transform 0.3s ease-out;
        }
        .modal-content.rounded-top-5 {
            border-radius: 32px 32px 0 0 !important;
        }
    </style>

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
