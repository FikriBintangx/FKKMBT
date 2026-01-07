<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Notifikasi - FKKMBT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/mobile.css?v='.time()) ?>">
</head>
<body class="bg-light">

    <!-- Mobile App Bar -->
    <div class="app-bar d-lg-none">
        <div class="d-flex align-items-center gap-3">
            <a href="<?= base_url('user/dashboard') ?>" class="text-white"><i class="bi bi-chevron-left fs-4"></i></a>
            <span class="fw-bold">Pesan & Notifikasi</span>
        </div>
    </div>

    <main class="container py-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">Terbaru</h5>
            <a href="#" class="small text-primary text-decoration-none">Tandai sudah baca</a>
        </div>

        <?php foreach($notifications as $n): ?>
            <div class="card mb-3 shadow-none border-0">
                <div class="card-body p-3">
                    <div class="d-flex gap-3">
                        <div class="rounded-4 <?= $n['bg'] ?> text-white d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px;">
                            <i class="bi <?= $n['icon'] ?> fs-4"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start">
                                <h6 class="fw-bold mb-1" style="font-size: 14px;"><?= $n['title'] ?></h6>
                                <small class="text-muted" style="font-size: 10px;"><?= $n['time'] ?></small>
                            </div>
                            <p class="small text-secondary mb-0"><?= $n['desc'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        
        <div class="text-center py-5">
            <p class="text-muted small">Tidak ada notifikasi lainnya.</p>
        </div>
    </main>

    <!-- Native Bottom Nav -->
    <?php $this->load->view('templates/mobile_nav'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
