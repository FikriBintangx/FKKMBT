<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $thread['judul'] ?> - Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/mobile.css') ?>">
    <style>body{font-family:'Outfit',sans-serif;background-color:#f8fafc}.reply-box{border-left:3px solid #10b981;background:#f0fdf4}</style>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?= base_url('user/forum') ?>"><i class="bi bi-arrow-left me-2"></i>Kembali ke Forum</a>
        </div>
    </nav>

    <div class="container py-4">
        <!-- Thread -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between">
                    <span class="badge bg-primary mb-2"><?= $thread['kategori'] ?></span>
                    <small class="text-muted"><?= date('d M Y H:i', strtotime($thread['created_at'])) ?></small>
                </div>
                <h3 class="fw-bold"><?= $thread['judul'] ?></h3>
                <div class="small text-muted mb-3">oleh <strong><?= $thread['nama_lengkap'] ?></strong> (Blok <?= $thread['blok'] ?>)</div>
                <p><?= nl2br($thread['isi']) ?></p>
            </div>
        </div>

        <!-- Replies -->
        <h5 class="fw-bold mb-3">💬 Balasan (<?= count($replies) ?>)</h5>
        <?php foreach($replies as $r): ?>
        <div class="reply-box p-3 rounded-3 mb-3">
            <div class="d-flex justify-content-between">
                <strong class="text-success"><?= $r['nama_lengkap'] ?></strong>
                <small class="text-muted"><?= date('d M H:i', strtotime($r['created_at'])) ?></small>
            </div>
            <p class="mb-0 mt-2"><?= nl2br($r['isi']) ?></p>
        </div>
        <?php endforeach; ?>

        <!-- Reply Form -->
        <div class="card border-0 shadow-sm rounded-4 mt-4">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3">Tulis Balasan</h6>
                <form action="<?= base_url('user/forum/reply/'.$thread['id']) ?>" method="POST">
                    <textarea name="isi" class="form-control mb-3" rows="3" placeholder="Tulis komentar Anda..." required></textarea>
                    <button type="submit" class="btn btn-success rounded-pill px-4">Kirim Balasan</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
