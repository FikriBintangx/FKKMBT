<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Forum Warga - FKKMBT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body{font-family:'Outfit',sans-serif;background-color:#f8fafc}</style>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?= base_url('user/dashboard') ?>"><i class="bi bi-arrow-left-circle me-2"></i>Dashboard</a>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal">Buat Thread Baru</button>
        </div>
    </nav>

    <div class="container py-4">
        <div class="d-flex gap-2 mb-4 overflow-auto">
            <a href="?" class="btn btn-sm btn-outline-primary rounded-pill">Semua</a>
            <a href="?kategori=INFO" class="btn btn-sm btn-outline-primary rounded-pill">Info</a>
            <a href="?kategori=DISKUSI" class="btn btn-sm btn-outline-primary rounded-pill">Diskusi</a>
            <a href="?kategori=JUAL_BELI" class="btn btn-sm btn-outline-primary rounded-pill">Jual Beli</a>
            <a href="?kategori=KEHILANGAN" class="btn btn-sm btn-outline-primary rounded-pill">Kehilangan</a>
        </div>

        <?php if(!empty($threads)): ?>
            <?php foreach($threads as $t): ?>
            <div class="card border-0 shadow-sm rounded-4 mb-3">
                <div class="card-body p-3">
                    <div class="d-flex gap-3">
                        <div class="flex-shrink-0 text-center">
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center fw-bold text-secondary" style="width:50px;height:50px"><?= substr($t['nama_lengkap'],0,1) ?></div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <a href="<?= base_url('user/forum/thread/'.$t['id']) ?>" class="h6 fw-bold text-dark text-decoration-none hover-primary"><?= $t['judul'] ?></a>
                                    <div class="small text-muted">oleh <?= $t['nama_lengkap'] ?> · <?= date('d M Y', strtotime($t['created_at'])) ?></div>
                                </div>
                                <span class="badge bg-primary rounded-pill"><?= $t['kategori'] ?></span>
                            </div>
                            <p class="small text-secondary mt-2 mb-0"><?= substr($t['isi'],0,150) ?>...</p>
                            <div class="mt-2 small text-muted">
                                <i class="bi bi-eye me-1"></i><?= $t['views'] ?> Views · 
                                <i class="bi bi-chat ms-2 me-1"></i><?= $t['reply_count'] ?> Balasan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-center py-5 text-muted">Belum ada thread diskusi.</div>
        <?php endif; ?>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" action="<?= base_url('user/forum/create') ?>" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Buat Thread Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Kategori</label>
                        <select name="kategori" class="form-select" required>
                            <option value="UMUM">Umum</option>
                            <option value="INFO">Info Lingkungan</option>
                            <option value="DISKUSI">Diskusi</option>
                            <option value="JUAL_BELI">Jual Beli</option>
                            <option value="KEHILANGAN">Kehilangan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Judul</label>
                        <input type="text" name="judul" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Isi</label>
                        <textarea name="isi" class="form-control" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Posting</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
