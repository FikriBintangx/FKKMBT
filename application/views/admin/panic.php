<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Monitor SOS - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <style>
        body{font-family:'Outfit',sans-serif;background-color:#f8fafc}
        .alert-card{border-left:4px solid #ef4444;animation:pulse-border 2s infinite}
        @keyframes pulse-border{0%,100%{border-color:#ef4444}50%{border-color:#fca5a5}}
    </style>
</head>
<body class="bg-light">
    <?php $this->load->view('admin/templates/navbar'); ?>
    <div class="container py-4">
        <h3 class="fw-bold text-danger mb-4"><i class="bi bi-broadcast-pin me-2"></i>Monitor SOS Darurat</h3>
        <?php if ($this->session->flashdata('success_msg')): ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success_msg') ?></div>
        <?php endif; ?>
        
        <?php if(!empty($alerts)): ?>
            <?php foreach($alerts as $a): ?>
            <div class="card border-0 shadow-sm rounded-4 mb-3 alert-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="fw-bold text-danger mb-2">🚨 <?= $a['jenis_darurat'] ?></h5>
                            <p class="mb-2"><strong>Warga:</strong> <?= $a['nama_lengkap'] ?> (Blok <?= $a['blok'] ?>)</p>
                            <p class="mb-2"><strong>Kontak:</strong> <a href="tel:<?= $a['no_hp'] ?>"><?= $a['no_hp'] ?></a></p>
                            <p class="mb-2"><strong>Waktu:</strong> <?= date('d M Y H:i', strtotime($a['created_at'])) ?></p>
                            <?php if($a['lokasi_lat'] && $a['lokasi_long']): ?>
                                <p class="mb-0"><strong>Lokasi:</strong> <a href="https://maps.google.com/?q=<?= $a['lokasi_lat'] ?>,<?= $a['lokasi_long'] ?>" target="_blank" class="text-primary">Buka Peta</a></p>
                            <?php endif; ?>
                        </div>
                        <div>
                            <a href="<?= base_url('admin/panic/handle/'.$a['id']) ?>" class="btn btn-success rounded-pill px-4">Tandai Selesai</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-center py-5 text-muted">Tidak ada SOS aktif saat ini. Semua aman!</div>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
