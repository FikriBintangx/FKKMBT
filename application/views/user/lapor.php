<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Lapor Warga - FKKMBT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/mobile.css?v='.time()) ?>">
    <style>
        .status-badge { font-size: 10px; padding: 4px 10px; border-radius: 50px; font-weight: 700; text-transform: uppercase; }
        .status-pending { background: #fef3c7; color: #d97706; }
        .status-proses { background: #dbeafe; color: #2563eb; }
        .status-selesai { background: #dcfce7; color: #16a34a; }
        .status-ditolak { background: #fee2e2; color: #dc2626; }
        
        .upload-placeholder {
            border: 2px dashed #e5e7eb;
            border-radius: 16px;
            padding: 20px;
            text-align: center;
            background: #f9fafb;
            cursor: pointer;
        }
    </style>
</head>
<body class="bg-light">

    <!-- Mobile App Bar -->
    <div class="app-bar d-lg-none">
        <div class="d-flex align-items-center gap-3">
            <a href="<?= base_url('user/dashboard') ?>" class="text-white"><i class="bi bi-chevron-left fs-4"></i></a>
            <span class="fw-bold">Buat Laporan</span>
        </div>
    </div>

    <!-- Desktop Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top d-none d-lg-block" style="background: var(--danger-gradient);">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?= base_url('user/dashboard') ?>">
                <i class="bi bi-arrow-left me-2"></i> Kembali ke Dashboard
            </a>
        </div>
    </nav>

    <main class="container py-3">
        <!-- Form Section -->
        <section class="mb-4">
            <div class="card shadow-none">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Detail Laporan</h5>
                    
                    <?php if ($this->session->flashdata('success_msg')): ?>
                        <div class="alert alert-success small py-2 mb-3"><?= $this->session->flashdata('success_msg') ?></div>
                    <?php endif; ?>

                    <form action="<?= base_url('user/lapor/submit') ?>" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Subjek Laporan</label>
                            <input type="text" name="judul" class="form-control" placeholder="Apa yang ingin dilaporkan?" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Deskripsi Masalah</label>
                            <textarea name="isi" class="form-control" rows="4" placeholder="Jelaskan secara detail masalahnya..." required></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Foto Bukti</label>
                            <div class="upload-placeholder" onclick="document.getElementById('fotoInput').click()">
                                <i class="bi bi-camera-fill fs-2 text-muted mb-2 d-block"></i>
                                <span class="small text-muted">Ketuk untuk pilih foto</span>
                                <input type="file" name="foto" id="fotoInput" class="d-none" accept="image/*" onchange="previewImage(this)">
                            </div>
                            <div id="previewContainer" class="mt-3 text-center d-none">
                                <div class="position-relative d-inline-block">
                                    <img id="imgPreview" src="" class="rounded-3 shadow-sm" style="max-height: 150px;">
                                    <button type="button" class="btn btn-danger btn-sm rounded-circle position-absolute top-0 start-100 translate-middle" onclick="removeImage()">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-danger w-100 shadow-sm text-uppercase fw-bold">Kirim Laporan</button>
                    </form>
                </div>
            </div>
        </section>

        <!-- History Section -->
        <section class="mb-5">
            <h5 class="fw-bold mb-3">Laporan Saya</h5>
            
            <?php if(empty($riwayat)): ?>
                <div class="text-center py-4 bg-white rounded-4 border">
                    <i class="bi bi-clipboard-x fs-1 text-muted opacity-25"></i>
                    <p class="text-muted small mb-0">Belum ada laporan.</p>
                </div>
            <?php else: ?>
                <?php foreach($riwayat as $r): ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="status-badge status-<?= $r['status'] ?>"><?= $r['status'] ?></span>
                                <small class="text-muted"><?= date('d/m/Y', strtotime($r['created_at'])) ?></small>
                            </div>
                            <h6 class="fw-bold text-dark mb-1"><?= $r['judul'] ?></h6>
                            <p class="small text-muted mb-2"><?= $r['isi'] ?></p>
                            
                            <?php if($r['tanggapan_admin']): ?>
                                <div class="p-2 rounded bg-light border-start border-3 border-success mt-2">
                                    <small class="fw-bold text-success d-block">Tanggapan:</small>
                                    <p class="small mb-0"><?= $r['tanggapan_admin'] ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>
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

