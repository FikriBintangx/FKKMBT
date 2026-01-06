<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Pintar - FKKMBT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <style>body{font-family:'Outfit',sans-serif;background-color:#f8fafc}</style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?= base_url('user/dashboard') ?>">
                <i class="bi bi-arrow-left-circle me-2"></i> Dashboard
            </a>
            <span class="text-white-50 small">Layanan Surat</span>
        </div>
    </nav>

    <div class="container py-4">
        <div class="row g-4">
            <!-- Form Card -->
            <div class="col-md-5">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                        <h5 class="fw-bold text-primary"><i class="bi bi-file-earmark-text-fill me-2"></i>Buat Permohonan Baru</h5>
                    </div>
                    <div class="card-body p-4">
                        <?php if ($this->session->flashdata('success_msg')): ?>
                            <div class="alert alert-success border-0 shadow-sm rounded-3 mb-3">
                                <i class="bi bi-check-circle-fill me-2"></i><?= $this->session->flashdata('success_msg') ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('user/surat/request') ?>" method="POST">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">JENIS SURAT</label>
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
                                <label class="form-label small fw-bold text-muted">KEPERLUAN</label>
                                <textarea name="keperluan" class="form-control" rows="3" placeholder="Contoh: Untuk persyaratan pembuatan rekening bank..." required></textarea>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary rounded-pill py-2 fw-bold">Kirim Permohonan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- History List -->
            <div class="col-md-7">
                <h6 class="fw-bold ms-1 mb-3 text-secondary">Riwayat Permohonan Anda</h6>
                <?php if(!empty($riwayat)): ?>
                    <?php foreach($riwayat as $r): ?>
                    <div class="card border-0 shadow-sm rounded-4 mb-3">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="fw-bold mb-1"><?= $r['jenis_surat'] ?></h6>
                                    <small class="text-muted d-block mb-1"><i class="bi bi-calendar me-1"></i><?= date('d M Y', strtotime($r['tgl_request'])) ?></small>
                                    <small class="text-secondary"><?= $r['keperluan'] ?></small>
                                </div>
                                <div class="text-end">
                                    <?php 
                                        $badges = ['PENDING'=>'bg-warning text-dark','APPROVED'=>'bg-success text-white','REJECTED'=>'bg-danger text-white'];
                                    ?>
                                    <span class="badge rounded-pill <?= $badges[$r['status']] ?> mb-2"><?= $r['status'] ?></span>
                                    <?php if($r['status'] == 'APPROVED'): ?>
                                        <br>
                                        <button class="btn btn-sm btn-outline-success rounded-pill px-3"><i class="bi bi-download me-1"></i>PDF</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-5 text-muted">Belum ada riwayat surat.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
