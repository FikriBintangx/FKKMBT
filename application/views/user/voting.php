<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>E-Voting - FKKMBT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body{font-family:'Outfit',sans-serif;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);min-height:100vh}
        .voting-card{border-radius:20px;transition:transform 0.2s}
        .voting-card:hover{transform:scale(1.02)}
    </style>
</head>
<body class="text-white">
    <nav class="navbar navbar-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?= base_url('user/dashboard') ?>">
                <i class="bi bi-arrow-left-circle me-2"></i> Dashboard
            </a>
        </div>
    </nav>

    <div class="container py-4">
        <?php if ($this->session->flashdata('success_msg')): ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success_msg') ?></div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error_msg')): ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error_msg') ?></div>
        <?php endif; ?>

        <?php if(!empty($voting)): ?>
            <div class="text-center mb-5">
                <h1 class="fw-bold display-5">🗳️ <?= $voting['judul'] ?></h1>
                <p class="lead"><?= $voting['deskripsi'] ?></p>
                <small class="opacity-75">Berakhir: <?= date('d M Y H:i', strtotime($voting['tgl_selesai'])) ?></small>
            </div>

            <?php if($has_voted): ?>
                <!-- Results View -->
                <h4 class="text-center mb-4">📊 Quick Count (Real-time)</h4>
                <div class="row g-3">
                    <?php foreach($results as $r): ?>
                    <div class="col-md-6">
                        <div class="card voting-card bg-white bg-opacity-10 border-0 text-white p-3">
                            <div class="d-flex align-items-center gap-3">
                                <?php $img = $r['foto'] ? base_url('assets/images/kandidat/'.$r['foto']) : 'https://via.placeholder.com/80'; ?>
                                <img src="<?= $img ?>" class="rounded-circle" style="width:60px;height:60px;object-fit:cover">
                                <div class="flex-grow-1">
                                    <h5 class="fw-bold mb-0"><?= $r['nama'] ?></h5>
                                    <div class="progress mt-2" style="height:20px">
                                        <?php $total = array_sum(array_column($results, 'total_suara')); ?>
                                        <?php $persen = $total > 0 ? ($r['total_suara']/$total)*100 : 0; ?>
                                        <div class="progress-bar bg-success fw-bold" style="width:<?= $persen ?>%"><?= number_format($persen,1) ?>%</div>
                                    </div>
                                    <small class="opacity-75"><?= $r['total_suara'] ?> Suara</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <!-- Voting Form -->
                <div class="row g-3">
                    <?php foreach($kandidat as $k): ?>
                    <div class="col-md-6">
                        <div class="card voting-card bg-white text-dark border-0 h-100">
                            <?php $img = $k['foto'] ? base_url('assets/images/kandidat/'.$k['foto']) : 'https://via.placeholder.com/400x300'; ?>
                            <img src="<?= $img ?>" class="card-img-top" style="height:200px;object-fit:cover">
                            <div class="card-body">
                                <h4 class="fw-bold"><?= $k['nama'] ?></h4>
                                <p class="small text-muted"><?= substr($k['visi_misi'],0,150) ?>...</p>
                                <a href="<?= base_url('user/voting/vote/'.$k['id']) ?>" onclick="return confirm('Pilih kandidat ini?')" class="btn btn-primary w-100 rounded-pill fw-bold py-2">
                                    <i class="bi bi-check-circle me-2"></i>PILIH
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-inbox display-1 opacity-50 mb-3"></i>
                <h4>Tidak ada pemilihan aktif saat ini.</h4>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
