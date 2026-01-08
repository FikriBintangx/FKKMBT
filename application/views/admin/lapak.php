<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Moderasi Lapak - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin-mobile.css') ?>">
    <style>body{font-family:'Outfit',sans-serif;background-color:#f8fafc}</style>
</head>
<body>
    <?php $this->load->view('admin/templates/navbar'); ?>
    <div class="container py-4">
        <h3 class="fw-bold text-warning mb-4"><i class="bi bi-shop me-2"></i>Moderasi Lapak Warga</h3>
        <?php if ($this->session->flashdata('success_msg')): ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success_msg') ?></div>
        <?php endif; ?>
        
        <div class="row g-3">
            <?php if(!empty($produk)): ?>
                <?php foreach($produk as $p): ?>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4">
                        <?php $img = $p['foto'] ? base_url('assets/images/lapak/'.$p['foto']) : 'https://via.placeholder.com/300'; ?>
                        <img src="<?= $img ?>" class="card-img-top" style="height:180px;object-fit:cover">
                        <div class="card-body">
                            <h6 class="fw-bold"><?= $p['nama_produk'] ?></h6>
                            <div class="text-warning fw-bold mb-2">Rp <?= number_format($p['harga'],0,',','.') ?></div>
                            <small class="text-muted d-block mb-2">Penjual: <?= $p['nama_lengkap'] ?></small>
                            <a href="<?= base_url('admin/lapak/delete/'.$p['id']) ?>" onclick="return confirm('Hapus produk ini?')" class="btn btn-sm btn-outline-danger w-100">Hapus Produk</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5 text-muted">Belum ada produk.</div>
            <?php endif; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
