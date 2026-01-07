<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>E-Surat Warga - FKKMBT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/mobile.css?v='.time()) ?>">
    <style>
        .badge-status { font-size: 10px; padding: 4px 10px; border-radius: 50px; font-weight: 700; }
        .bg-pending { background: #fef3c7; color: #d97706; }
        .bg-approved { background: #dcfce7; color: #16a34a; }
        .bg-rejected { background: #fee2e2; color: #dc2626; }
    </style>
</head>
<body class="bg-light">

    <!-- Mobile App Bar -->
    <div class="app-bar d-lg-none">
        <div class="d-flex align-items-center gap-3">
            <a href="<?= base_url('user/dashboard') ?>" class="text-white"><i class="bi bi-chevron-left fs-4"></i></a>
            <span class="fw-bold">Layanan E-Surat</span>
        </div>
    </div>

    <!-- Desktop Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top d-none d-lg-block" style="background: var(--primary-gradient);">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?= base_url('user/dashboard') ?>">
                <i class="bi bi-arrow-left me-2"></i> Kembali ke Dashboard
            </a>
        </div>
    </nav>

    <main class="container py-3">
        <!-- Request Form -->
        <section class="mb-4">
            <div class="card shadow-none">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Buat Permohonan Surat</h5>
                    
                    <?php if ($this->session->flashdata('success_msg')): ?>
                        <div class="alert alert-success small py-2 mb-3"><?= $this->session->flashdata('success_msg') ?></div>
                    <?php endif; ?>

                    <form action="<?= base_url('user/surat/request') ?>" method="POST">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Jenis Surat</label>
                            <select name="jenis_surat" class="form-select" required>
                                <option value="">Pilih Jenis...</option>
                                <option value="Surat Keterangan Domisili">Surat Keterangan Domisili</option>
                                <option value="Surat Pengantar Nikah">Surat Pengantar Nikah</option>
                                <option value="Surat Keterangan Usaha">Surat Keterangan Usaha</option>
                                <option value="Surat Izin Keramaian">Surat Izin Keramaian</option>
                                <option value="Surat Keterangan Tidak Mampu">Surat Keterangan Tidak Mampu</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Keperluan / Alasan</label>
                            <textarea name="keperluan" class="form-control" rows="3" placeholder="Contoh: Untuk persyaratan pembuatan rekening bank..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 shadow-sm text-uppercase fw-bold">Kirim Permohonan</button>
                    </form>
                </div>
            </div>
        </section>

        <!-- History Section -->
        <section class="mb-5">
            <h5 class="fw-bold mb-3">Riwayat Pengajuan</h5>
            
            <?php if(empty($riwayat)): ?>
                <div class="text-center py-4 bg-white rounded-4 border">
                    <i class="bi bi-envelope-x fs-1 text-muted opacity-25"></i>
                    <p class="text-muted small mb-0">Belum ada pengajuan surat.</p>
                </div>
            <?php else: ?>
                <?php foreach($riwayat as $r): ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <?php 
                                    $status_class = strtolower($r['status']);
                                    $badge_class = 'bg-' . $status_class;
                                ?>
                                <span class="badge-status <?= $badge_class ?>"><?= $r['status'] ?></span>
                                <small class="text-muted"><?= date('d/m/Y', strtotime($r['tgl_request'])) ?></small>
                            </div>
                            <h6 class="fw-bold text-dark mb-1"><?= $r['jenis_surat'] ?></h6>
                            <p class="small text-muted mb-3"><?= $r['keperluan'] ?></p>
                            
                            <?php if($r['status'] == 'APPROVED'): ?>
                                <button class="btn btn-success btn-sm w-100 rounded-pill fw-bold">
                                    <i class="bi bi-download me-2"></i>Unduh Surat (PDF)
                                </button>
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
</body>
</html>
