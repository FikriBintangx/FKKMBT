<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lapor Pak! - Layanan Pengaduan Warga</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #f8fafc; }
        .hero-lapor {
            background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
            color: white; padding: 40px 20px; border-radius: 0 0 30px 30px; margin-bottom: -30px;
        }
        .form-card {
            background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            padding: 30px; position: relative; z-index: 10;
        }
        .status-badge { font-size: 12px; padding: 5px 12px; border-radius: 50px; font-weight: 600; text-transform: uppercase; }
        .status-pending { background: #fef3c7; color: #d97706; }
        .status-proses { background: #dbeafe; color: #2563eb; }
        .status-selesai { background: #dcfce7; color: #16a34a; }
        .status-ditolak { background: #fee2e2; color: #dc2626; }
        
        .history-card {
            border: none; background: white; border-radius: 16px; margin-bottom: 15px;
            transition: transform 0.2s; border: 1px solid #f1f5f9;
        }
        .history-card:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0,0,0,0.03); }
        .upload-box {
            border: 2px dashed #cbd5e1; border-radius: 12px; padding: 30px; text-align: center;
            cursor: pointer; transition: 0.3s; background: #f8fafc;
        }
        .upload-box:hover { border-color: #ef4444; background: #fef2f2; }
    </style>
</head>
<body>

    <!-- Simple Navbar for User context -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?= base_url('user/dashboard') ?>">
                <i class="bi bi-arrow-left-circle me-2"></i> Kembali ke Dashboard
            </a>
            <span class="text-white-50 small">Layanan Pengaduan Warga</span>
        </div>
    </nav>

    <div class="hero-lapor text-center pb-5">
        <div class="display-1 mb-2"><i class="bi bi-megaphone-fill"></i></div>
        <h1 class="fw-bold">Lapor Pak!</h1>
        <p class="opacity-75 mx-auto" style="max-width: 500px;">
            Temukan masalah di lingkungan sekitar? Laporkan segera agar dapat ditindaklanjuti oleh pengurus.
        </p>
    </div>

    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                <!-- Form Lapor -->
                <div class="form-card mb-5">
                    <h4 class="fw-bold mb-4 text-dark"><i class="bi bi-pencil-square me-2 text-danger"></i>Buat Laporan Baru</h4>
                    
                    <?php if ($this->session->flashdata('success_msg')): ?>
                        <div class="alert alert-success rounded-4 border-0 mb-4">
                            <i class="bi bi-check-circle-fill me-2"></i><?= $this->session->flashdata('success_msg') ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($this->session->flashdata('error_msg')): ?>
                        <div class="alert alert-danger rounded-4 border-0 mb-4">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i><?= $this->session->flashdata('error_msg') ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('user/lapor/submit') ?>" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">JUDUL LAPORAN</label>
                            <input type="text" name="judul" class="form-control form-control-lg" placeholder="Contoh: Lampu Jalan Mati di Blok A5" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">DETAIL MASALAH</label>
                            <textarea name="isi" class="form-control" rows="4" placeholder="Jelaskan detail masalah, lokasi tepat, dan waktu kejadian..." required></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted">BUKTI FOTO (OPSIONAL)</label>
                            <div class="upload-box" onclick="document.getElementById('fotoInput').click()">
                                <i class="bi bi-camera-fill fs-3 text-secondary mb-2"></i>
                                <p class="small text-muted mb-0">Klik untuk ambil/upload foto</p>
                                <input type="file" name="foto" id="fotoInput" class="d-none" accept="image/*" onchange="previewImage(this)">
                            </div>
                            <div id="previewContainer" class="mt-3 text-center d-none">
                                <img id="imgPreview" src="" class="rounded-3 shadow-sm border" style="max-height: 200px; max-width: 100%;">
                                <button type="button" class="btn btn-sm btn-outline-danger mt-2 d-block mx-auto" onclick="removeImage()">Hapus Foto</button>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-danger w-100 py-3 fw-bold rounded-pill text-uppercase shadow-sm">
                            <i class="bi bi-send-fill me-2"></i>Kirim Laporan
                        </button>
                    </form>
                </div>

                <!-- Riwayat -->
                <h5 class="fw-bold mb-3 ms-2 text-secondary"><i class="bi bi-clock-history me-2"></i>Riwayat Laporan Anda</h5>
                
                <?php if(empty($riwayat)): ?>
                    <div class="text-center py-5 opacity-50">
                        <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                        <p>Belum ada laporan yang dikirim.</p>
                    </div>
                <?php else: ?>
                    <?php foreach($riwayat as $r): ?>
                        <div class="history-card p-3">
                            <div class="d-flex gap-3">
                                <div class="flex-shrink-0">
                                    <?php if($r['foto']): ?>
                                        <img src="<?= base_url('assets/images/pengaduan/'.$r['foto']) ?>" class="rounded-3 object-fit-cover bg-light" style="width: 80px; height: 80px;" onclick="showImageModal(this.src)">
                                    <?php else: ?>
                                        <div class="rounded-3 bg-light d-flex align-items-center justify-content-center text-muted" style="width: 80px; height: 80px;">
                                            <i class="bi bi-image-alt fs-4"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <h6 class="fw-bold mb-0 text-dark"><?= $r['judul'] ?></h6>
                                        <span class="status-badge status-<?= $r['status'] ?>"><?= $r['status'] ?></span>
                                    </div>
                                    <small class="text-muted d-block mb-2"><?= date('d M Y, H:i', strtotime($r['created_at'])) ?></small>
                                    <p class="small text-secondary mb-2 text-truncate-2"><?= $r['isi'] ?></p>
                                    
                                    <?php if($r['tanggapan_admin']): ?>
                                        <div class="bg-light p-2 rounded-3 border-start border-4 border-success mt-2">
                                            <small class="fw-bold text-success d-block mb-1"><i class="bi bi-reply-fill me-1"></i>Tanggapan Pengurus:</small>
                                            <p class="small text-dark mb-0"><?= $r['tanggapan_admin'] ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

            </div>
        </div>
    </div>
    
    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-transparent border-0 shadow-none">
                <button type="button" class="btn-close btn-close-white ms-auto mb-2" data-bs-dismiss="modal"></button>
                <img src="" id="modalImage" class="img-fluid rounded-3 shadow-lg">
            </div>
        </div>
    </div>

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
        function showImageModal(src) {
            document.getElementById('modalImage').src = src;
            new bootstrap.Modal(document.getElementById('imageModal')).show();
        }
    </script>
</body>
</html>
