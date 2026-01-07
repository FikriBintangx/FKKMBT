<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>E-Surat - FKKMBT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/mobile.css?v='.time()) ?>">
    <style>
        .surat-hero {
            background: var(--primary-gradient);
            padding: 20px 20px 60px;
            border-radius: 0 0 32px 32px;
            color: white;
            text-align: center;
        }
        .form-card {
            background: white;
            border-radius: 24px;
            padding: 24px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            margin-top: -40px;
            position: relative;
            z-index: 10;
        }
        .service-option {
            border: 2px solid #f1f5f9;
            border-radius: 16px;
            padding: 15px;
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .service-option:active { transform: scale(0.95); }
        .service-option.active {
            border-color: var(--primary-color);
            background: #f0fdf4;
        }
        .service-icon {
            width: 40px; height: 40px;
            border-radius: 10px;
            background: #e2e8f0;
            color: #64748b;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
            margin-bottom: 10px;
        }
        .service-option.active .service-icon {
            background: var(--primary-color);
            color: white;
        }
        .history-card {
            background: white;
            border-radius: 16px;
            padding: 16px;
            border: 1px solid #f1f5f9;
            margin-bottom: 12px;
        }
        .input-icon-wrapper {
            position: relative;
            margin-bottom: 20px;
        }
        .input-icon-wrapper i {
            position: absolute;
            left: 15px;
            top: 25px; /* Adjust for textarea */
            color: #94a3b8;
            font-size: 18px;
        }
        .input-icon-wrapper .form-control {
            padding-left: 45px !important;
            padding-top: 15px;
            background: #f8fafc !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 12px;
        }
    </style>
</head>
<body class="bg-light">

    <!-- App Bar -->
    <div class="app-bar d-lg-none shadow-none">
        <div class="d-flex align-items-center gap-3">
            <a href="<?= base_url('user/dashboard') ?>" class="text-white"><i class="bi bi-chevron-left fs-4"></i></a>
            <span class="fw-bold text-white">Layanan Surat Digital</span>
        </div>
    </div>

    <!-- Hero -->
    <div class="surat-hero">
        <h2 class="fw-bold mb-1">Surat Pintar</h2>
        <p class="small opacity-75 mb-0 px-4">Ajukan surat pengantar resmi tanpa harus ke rumah Pak RT.</p>
    </div>

    <main class="container px-3 pb-5">

        <div class="form-card mb-5">
            <?php if ($this->session->flashdata('success_msg')): ?>
                <div class="alert alert-success border-0 shadow-sm rounded-3 small py-2 mb-3 d-flex align-items-center gap-2">
                    <i class="bi bi-check-circle-fill"></i>
                    <?= $this->session->flashdata('success_msg') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('user/surat/request') ?>" method="POST" id="suratForm">
                <input type="hidden" name="jenis_surat" id="jenisSuratInput">
                
                <label class="form-label small fw-bold text-muted ps-1 mb-3">PILIH JENIS SURAT</label>
                <div class="row g-2 mb-4">
                    <div class="col-4">
                        <div class="service-option" onclick="selectService(this, 'Surat Keterangan Domisili')">
                            <div class="service-icon"><i class="bi bi-house-door-fill"></i></div>
                            <small class="fw-bold lh-1" style="font-size: 10px;">DOMISILI</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="service-option" onclick="selectService(this, 'Surat Pengantar Nikah')">
                            <div class="service-icon"><i class="bi bi-heart-fill"></i></div>
                            <small class="fw-bold lh-1" style="font-size: 10px;">NIKAH</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="service-option" onclick="selectService(this, 'Surat Keterangan Usaha')">
                            <div class="service-icon"><i class="bi bi-shop"></i></div>
                            <small class="fw-bold lh-1" style="font-size: 10px;">USAHA</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="service-option" onclick="selectService(this, 'Surat Izin Keramaian')">
                            <div class="service-icon"><i class="bi bi-people-fill"></i></div>
                            <small class="fw-bold lh-1" style="font-size: 10px;">KERAMAIAN</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="service-option" onclick="selectService(this, 'Surat Keterangan Tidak Mampu')">
                            <div class="service-icon"><i class="bi bi-file-earmark-text-fill"></i></div>
                            <small class="fw-bold lh-1" style="font-size: 10px;">TIDAK MAMPU</small>
                        </div>
                    </div>
                </div>

                <div class="input-icon-wrapper">
                    <i class="bi bi-pencil-fill text-primary"></i>
                    <textarea name="keperluan" class="form-control" rows="3" placeholder="Tuliskan keperluan surat Anda secara singkat..." required></textarea>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow-lg text-uppercase ls-1">
                    <i class="bi bi-file-earmark-arrow-up-fill me-2"></i> Ajukan Surat
                </button>
            </form>
        </div>

        <!-- History -->
        <h6 class="fw-bold text-muted text-uppercase small ls-1 mb-3 px-2">Riwayat Pengajuan</h6>
        
        <?php if(empty($riwayat)): ?>
            <div class="text-center py-5">
                <i class="bi bi-file-earmark-x fs-1 text-muted opacity-25"></i>
                <p class="text-muted small mt-2">Belum ada surat yang diajukan.</p>
            </div>
        <?php else: ?>
            <?php foreach($riwayat as $r): ?>
                <div class="history-card">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <?php 
                            $badge_color = 'warning';
                            $status_text = 'PENDING';
                            if($r['status'] == 'APPROVED') { $badge_color = 'success'; $status_text = 'SIAP DIAMBIL'; }
                            if($r['status'] == 'REJECTED') { $badge_color = 'danger'; $status_text = 'DITOLAK'; }
                        ?>
                        <span class="badge bg-<?= $badge_color ?>-subtle text-<?= $badge_color ?> rounded-pill" style="font-size: 10px; letter-spacing: 0.5px;"><?= $status_text ?></span>
                        <small class="text-muted" style="font-size: 11px;"><?= date('d M Y', strtotime($r['tgl_request'])) ?></small>
                    </div>
                    <h6 class="fw-bold text-dark mb-1"><?= $r['jenis_surat'] ?></h6>
                    <p class="small text-muted mb-3 text-truncate"><?= $r['keperluan'] ?></p>
                    
                    <?php if($r['status'] == 'APPROVED'): ?>
                        <div class="d-grid">
                            <button class="btn btn-success btn-sm rounded-pill fw-bold py-2">
                                <i class="bi bi-download me-2"></i>Unduh Dokumen PDF
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </main>

    <!-- Native Bottom Nav -->
    <?php $this->load->view('templates/mobile_nav'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function selectService(el, value) {
            // Remove active class from all
            document.querySelectorAll('.service-option').forEach(e => e.classList.remove('active'));
            // Add to clicked
            el.classList.add('active');
            // Set input value
            document.getElementById('jenisSuratInput').value = value;
        }
    </script>
</body>
</html>
