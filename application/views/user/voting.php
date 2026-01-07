<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>E-Voting - FKKMBT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/mobile.css?v='.time()) ?>">
    <style>
        .voting-hero {
            background: var(--primary-gradient);
            padding: 20px 20px 80px;
            border-radius: 0 0 32px 32px;
            color: white;
            text-align: center;
        }
        .election-info-card {
            background: white;
            border-radius: 20px;
            padding: 20px;
            margin-top: -50px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
            position: relative;
            z-index: 10;
        }
        .candidate-card {
            background: white;
            border-radius: 16px;
            border: 1px solid #f1f5f9;
            overflow: hidden;
            height: 100%;
            transition: transform 0.2s;
        }
        .candidate-card:active { transform: scale(0.98); }
        .candidate-img {
            height: 200px; width: 100%; object-fit: cover; background: #e2e8f0;
        }
        .result-bar {
            height: 8px;
            border-radius: 10px;
            background: #f1f5f9;
            overflow: hidden;
            margin-top: 8px;
        }
        .result-fill {
            height: 100%;
            background: var(--primary-color);
            border-radius: 10px;
        }
    </style>
</head>
<body class="bg-light">

    <!-- App Bar -->
    <div class="app-bar d-lg-none shadow-none">
        <div class="d-flex align-items-center gap-3">
            <a href="<?= base_url('user/dashboard') ?>" class="text-white"><i class="bi bi-chevron-left fs-4"></i></a>
            <span class="fw-bold text-white">E-Voting</span>
        </div>
    </div>

    <!-- Hero -->
    <div class="voting-hero">
        <h2 class="fw-bold mb-1">Suara Warga</h2>
        <p class="small opacity-75 mb-0 px-4">Tentukan masa depan lingkungan kita bersama.</p>
    </div>

    <main class="container px-3 pb-5">
        
        <?php if(!empty($voting)): ?>
            <!-- Election Info -->
            <div class="election-info-card text-center mb-4">
                <span class="badge bg-danger-subtle text-danger rounded-pill mb-2 px-3 fw-bold" style="font-size: 10px; letter-spacing: 1px;">SEDANG BERLANGSUNG</span>
                <h4 class="fw-bold text-dark mb-1"><?= $voting['judul'] ?></h4>
                <p class="text-muted small mb-3"><?= $voting['deskripsi'] ?></p>
                <div class="d-flex justify-content-center gap-2 small text-secondary bg-light py-2 rounded-3">
                    <i class="bi bi-clock-history"></i> Berakhir: <strong><?= date('d M Y • H:i', strtotime($voting['tgl_selesai'])) ?></strong>
                </div>
            </div>

            <?php if ($this->session->flashdata('success_msg')): ?>
                <div class="alert alert-success border-0 shadow-sm rounded-3 small py-2 mb-3 d-flex align-items-center gap-2">
                    <i class="bi bi-check-circle-fill"></i> <?= $this->session->flashdata('success_msg') ?>
                </div>
            <?php endif; ?>

            <?php if($has_voted): ?>
                <!-- Results View -->
                <h6 class="fw-bold text-muted small text-uppercase ls-1 mb-3">Hasil Sementara (Real-time)</h6>
                <div class="row g-3">
                    <?php 
                        $total_votes = array_sum(array_column($results, 'total_suara'));
                        $max_vote = 0;
                        foreach($results as $r) { if($r['total_suara'] > $max_vote) $max_vote = $r['total_suara']; }
                    ?>
                    <?php foreach($results as $r): ?>
                    <div class="col-12">
                        <div class="card border-0 shadow-sm rounded-4 p-3 d-flex flex-row align-items-center gap-3 <?= ($r['total_suara'] == $max_vote && $total_votes > 0) ? 'border border-warning border-2' : '' ?>">
                            <?php $img = $r['foto'] ? base_url('assets/images/kandidat/'.$r['foto']) : 'https://via.placeholder.com/80'; ?>
                            <img src="<?= $img ?>" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                            
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="fw-bold text-dark"><?= $r['nama'] ?></span>
                                    <span class="fw-bold text-primary"><?= $r['total_suara'] ?> Suara</span>
                                </div>
                                <?php $persen = $total_votes > 0 ? ($r['total_suara']/$total_votes)*100 : 0; ?>
                                <div class="result-bar">
                                    <div class="result-fill" style="width: <?= $persen ?>%"></div>
                                </div>
                                <small class="text-muted mt-1 d-block" style="font-size: 10px;"><?= number_format($persen, 1) ?>% dari total suara</small>
                            </div>
                            
                            <?php if($r['total_suara'] == $max_vote && $total_votes > 0): ?>
                                <i class="bi bi-trophy-fill text-warning fs-4"></i>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

            <?php else: ?>
                <!-- Voting Form -->
                <h6 class="fw-bold text-muted small text-uppercase ls-1 mb-3">Kandidat Pilihan</h6>
                <div class="row g-3">
                    <?php foreach($kandidat as $k): ?>
                    <div class="col-12 col-md-6">
                        <div class="candidate-card">
                            <?php $img = $k['foto'] ? base_url('assets/images/kandidat/'.$k['foto']) : 'https://via.placeholder.com/400x300'; ?>
                            <img src="<?= $img ?>" class="candidate-img">
                            <div class="p-3">
                                <h5 class="fw-bold text-dark mb-1"><?= $k['nama'] ?></h5>
                                <p class="small text-muted mb-3" style="line-height: 1.4;"><?= substr($k['visi_misi'], 0, 100) ?>...</p>
                                
                                <div class="d-flex gap-2">
                                    <!-- Detail Modal Trigger could go here -->
                                    <a href="<?= base_url('user/voting/vote/'.$k['id']) ?>" onclick="return confirm('Apakah Anda yakin memilih <?= $k['nama'] ?>? Keputusan tidak dapat diubah.')" class="btn btn-primary w-100 rounded-pill fw-bold">
                                        VOTE <i class="bi bi-box-arrow-in-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-calendar-x fs-1 text-muted opacity-25"></i>
                <h6 class="fw-bold text-dark mt-3">Tidak Ada Pemilihan</h6>
                <p class="text-muted small">Saat ini belum ada agenda pemilihan aktif.</p>
            </div>
        <?php endif; ?>

    </main>

    <!-- Native Bottom Nav -->
    <?php $this->load->view('templates/mobile_nav'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
