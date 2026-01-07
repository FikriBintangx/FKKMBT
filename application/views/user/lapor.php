<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Lapor Warga - FKKMBT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/mobile.css?v='.time()) ?>">
    <style>
        .lapor-hero {
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
        .input-icon-wrapper {
            position: relative;
            margin-bottom: 20px;
        }
        .input-icon-wrapper i {
            position: absolute;
            left: 15px;
            top: 15px;
            color: #94a3b8;
            font-size: 18px;
        }
        .input-icon-wrapper .form-control {
            padding-left: 45px !important;
            padding-top: 12px;
            padding-bottom: 12px;
            background: #f8fafc !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 12px;
        }
        .upload-area {
            border: 2px dashed #cbd5e1;
            border-radius: 16px;
            background: #f8fafc;
            padding: 30px 20px;
            text-align: center;
            transition: all 0.3s;
            cursor: pointer;
        }
        .upload-area:active { background: #e2e8f0; border-color: #94a3b8; }
        .history-card {
            background: white;
            border-radius: 16px;
            padding: 16px;
            border: 1px solid #f1f5f9;
            margin-bottom: 12px;
        }
        .status-badge {
            font-size: 10px; padding: 4px 10px; border-radius: 50px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;
        }
    </style>
</head>
<body class="bg-light">

    <!-- App Bar -->
    <div class="app-bar d-lg-none shadow-none">
        <div class="d-flex align-items-center gap-3">
            <a href="<?= base_url('user/dashboard') ?>" class="text-white"><i class="bi bi-chevron-left fs-4"></i></a>
            <span class="fw-bold text-white">Layanan Pengaduan</span>
        </div>
    </div>

    <!-- Hero -->
    <div class="lapor-hero">
        <h2 class="fw-bold mb-1">Lapor Pak!</h2>
        <p class="small opacity-75 mb-0 px-4">Sampaikan keluhan atau masalah lingkungan Anda secara langsung.</p>
    </div>

    <main class="container px-3 pb-5">
        
        <!-- Form Section -->
        <div class="form-card mb-5">
            <?php if ($this->session->flashdata('success_msg')): ?>
                <div class="alert alert-success border-0 shadow-sm rounded-3 small py-2 mb-3 d-flex align-items-center gap-2">
                    <i class="bi bi-check-circle-fill"></i>
                    <?= $this->session->flashdata('success_msg') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('user/lapor/submit') ?>" method="POST" enctype="multipart/form-data">
                <div class="input-icon-wrapper">
                    <i class="bi bi-chat-square-text text-primary"></i>
                    <input type="text" name="judul" class="form-control" placeholder="Judul Laporan (mis: Lampu Mati)" required>
                </div>
                
                <div class="input-icon-wrapper">
                    <i class="bi bi-card-text text-primary"></i>
                    <textarea name="isi" class="form-control" rows="4" placeholder="Deskripsikan masalah secara detail..." required></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-bold text-muted ps-2">FOTO BUKTI (OPSIONAL)</label>
                    <div class="upload-area" onclick="document.getElementById('fotoInput').click()">
                        <i class="bi bi-camera-fill fs-2 text-primary mb-2 d-block"></i>
                        <span class="small fw-bold text-muted">Ketuk untuk ambil/pilih foto</span>
                        <input type="file" name="foto" id="fotoInput" class="d-none" accept="image/*" onchange="previewImage(this)">
                    </div>
                    <div id="previewContainer" class="mt-3 text-center d-none">
                        <div class="position-relative d-inline-block">
                            <img id="imgPreview" src="" class="rounded-4 shadow-sm" style="max-height: 200px; width: 100%; object-fit: cover;">
                            <button type="button" class="btn btn-danger btn-sm rounded-circle position-absolute top-0 end-0 m-2 shadow-sm" onclick="removeImage()">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow-lg text-uppercase ls-1">
                    <i class="bi bi-send-fill me-2"></i> Kirim Laporan
                </button>
            </form>
        </div>

        <!-- History Section -->
        <h6 class="fw-bold text-muted text-uppercase small ls-1 mb-3 px-2">Riwayat Laporan</h6>
        
        <?php if(empty($riwayat)): ?>
            <div class="text-center py-5">
                <i class="bi bi-inbox fs-1 text-muted opacity-25"></i>
                <p class="text-muted small mt-2">Belum ada laporan yang dikirim.</p>
            </div>
        <?php else: ?>
            <?php foreach($riwayat as $r): ?>
                <div class="history-card">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <?php 
                            $status_class = 'bg-warning-subtle text-warning';
                            if($r['status'] == 'selesai') $status_class = 'bg-success-subtle text-success';
                            if($r['status'] == 'proses') $status_class = 'bg-primary-subtle text-primary';
                            if($r['status'] == 'ditolak') $status_class = 'bg-danger-subtle text-danger';
                        ?>
                        <span class="status-badge <?= $status_class ?>"><?= $r['status'] ?></span>
                        <small class="text-muted" style="font-size: 11px;"><?= date('d M, H:i', strtotime($r['created_at'])) ?></small>
                    </div>
                    <h6 class="fw-bold text-dark mb-1"><?= $r['judul'] ?></h6>
                    <p class="small text-muted mb-0 text-truncate"><?= $r['isi'] ?></p>
                    
                    <?php if($r['tanggapan_admin']): ?>
                        <div class="mt-3 p-3 bg-light rounded-3 border-start border-3 border-success">
                            <small class="fw-bold text-success d-block mb-1"><i class="bi bi-reply-fill me-1"></i>Tanggapan:</small>
                            <p class="small text-dark mb-0"><?= $r['tanggapan_admin'] ?></p>
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
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imgPreview').src = e.target.result;
                    document.getElementById('previewContainer').classList.remove('d-none');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        function removeImage() {
            document.getElementById('fotoInput').value = '';
            document.getElementById('previewContainer').classList.add('d-none');
        }
    </script>
</body>
</html>
