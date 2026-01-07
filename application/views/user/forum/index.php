<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Forum Warga - FKKMBT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/mobile.css?v='.time()) ?>">
    <style>
        .forum-hero {
            background: var(--primary-gradient);
            padding: 20px 20px 80px;
            border-radius: 0 0 32px 32px;
            color: white;
            text-align: center;
        }
        .search-container {
            margin-top: -45px;
            padding: 0 20px;
            position: relative;
            z-index: 10;
        }
        .search-box {
            background: white;
            border-radius: 50px;
            padding: 8px 15px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
        }
        .filter-scroll {
            overflow-x: auto;
            white-space: nowrap;
            padding: 10px 20px;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .filter-scroll::-webkit-scrollbar { display: none; }
        .filter-chip {
            display: inline-block;
            padding: 8px 20px;
            background: white;
            border: 1px solid #f1f5f9;
            border-radius: 50px;
            margin-right: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #64748b;
            text-decoration: none;
            transition: all 0.2s;
        }
        .filter-chip.active {
            background: #0f172a;
            color: white;
            border-color: #0f172a;
        }
        .thread-card {
            background: white;
            border-radius: 20px;
            padding: 20px;
            margin-bottom: 15px;
            border: 1px solid #f8fafc;
            box-shadow: 0 2px 5px rgba(0,0,0,0.02);
        }
        .avatar-small {
            width: 40px; height: 40px;
            background: #f1f5f9;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; color: #475569;
        }
        .fab-add {
            position: fixed;
            bottom: 90px;
            right: 20px;
            width: 56px; height: 56px;
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.4);
            font-size: 24px;
            z-index: 999;
            transition: transform 0.2s;
        }
        .fab-add:active { transform: scale(0.9); }
        .category-badge {
            font-size: 10px; font-weight: 700; padding: 4px 10px; border-radius: 50px; text-transform: uppercase; letter-spacing: 0.5px;
        }
        .cat-umum { background: #f1f5f9; color: #475569; }
        .cat-info { background: #dbeafe; color: #2563eb; }
        .cat-diskusi { background: #fdf2f8; color: #db2777; }
        .cat-jual_beli { background: #ecfdf5; color: #059669; }
        .cat-kehilangan { background: #fef2f2; color: #dc2626; }
    </style>
</head>
<body class="bg-light">

    <!-- App Bar -->
    <div class="app-bar d-lg-none shadow-none">
        <div class="d-flex align-items-center gap-3">
            <a href="<?= base_url('user/dashboard') ?>" class="text-white"><i class="bi bi-chevron-left fs-4"></i></a>
            <span class="fw-bold text-white">Forum Diskusi</span>
        </div>
    </div>

    <!-- Hero -->
    <div class="forum-hero">
        <h2 class="fw-bold mb-1">Ruang Warga</h2>
        <p class="small opacity-75 mb-0 px-4">Tempat berdiskusi, berbagi info, dan silaturahmi.</p>
    </div>

    <!-- Search Box -->
    <div class="search-container">
        <form action="" method="GET">
            <div class="search-box">
                <i class="bi bi-search text-muted me-2"></i>
                <input type="text" name="q" class="form-control border-0 shadow-none p-0 bg-transparent" placeholder="Cari topik diskusi..." value="<?= $this->input->get('q') ?>">
            </div>
        </form>
    </div>

    <!-- Filters -->
    <div class="filter-scroll mt-3">
        <?php $k = $this->input->get('kategori'); ?>
        <a href="?" class="filter-chip <?= empty($k) ? 'active' : '' ?>">Semua</a>
        <a href="?kategori=INFO" class="filter-chip <?= $k == 'INFO' ? 'active' : '' ?>">📢 Info</a>
        <a href="?kategori=DISKUSI" class="filter-chip <?= $k == 'DISKUSI' ? 'active' : '' ?>">💬 Diskusi</a>
        <a href="?kategori=JUAL_BELI" class="filter-chip <?= $k == 'JUAL_BELI' ? 'active' : '' ?>">🛒 Jual Beli</a>
        <a href="?kategori=KEHILANGAN" class="filter-chip <?= $k == 'KEHILANGAN' ? 'active' : '' ?>">⚠️ Kehilangan</a>
    </div>

    <main class="container px-3 pb-5">
        <?php if(!empty($threads)): ?>
            <?php foreach($threads as $t): ?>
                <?php 
                    $cat_class = 'cat-umum';
                    if($t['kategori'] == 'INFO') $cat_class = 'cat-info';
                    if($t['kategori'] == 'DISKUSI') $cat_class = 'cat-diskusi';
                    if($t['kategori'] == 'JUAL_BELI') $cat_class = 'cat-jual_beli';
                    if($t['kategori'] == 'KEHILANGAN') $cat_class = 'cat-kehilangan';
                ?>
                <a href="<?= base_url('user/forum/thread/'.$t['id']) ?>" class="text-decoration-none">
                    <div class="thread-card">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <span class="category-badge <?= $cat_class ?>"><?= str_replace('_', ' ', $t['kategori']) ?></span>
                                <span class="text-muted small" style="font-size: 11px;">• <?= date('d M', strtotime($t['created_at'])) ?></span>
                            </div>
                        </div>

                        <h6 class="fw-bold text-dark mb-2 lh-base"><?= $t['judul'] ?></h6>
                        <p class="small text-secondary mb-3 text-truncate"><?= strip_tags($t['isi']) ?></p>

                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar-small" style="width: 24px; height: 24px; font-size: 10px;">
                                    <?= substr($t['nama_lengkap'], 0, 1) ?>
                                </div>
                                <span class="small fw-bold text-dark" style="font-size: 11px;"><?= explode(' ', $t['nama_lengkap'])[0] ?></span>
                            </div>
                            <div class="d-flex gap-3 text-muted small" style="font-size: 11px;">
                                <span><i class="bi bi-eye-fill me-1"></i><?= $t['views'] ?></span>
                                <span><i class="bi bi-chat-fill me-1"></i><?= $t['reply_count'] ?></span>
                            </div>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-chat-square-quote fs-1 text-muted opacity-25"></i>
                <p class="text-muted small mt-2">Belum ada diskusi di kategori ini.</p>
            </div>
        <?php endif; ?>
    </main>

    <!-- FAB -->
    <button class="fab-add" data-bs-toggle="modal" data-bs-target="#createModal">
        <i class="bi bi-plus-lg"></i>
    </button>

    <!-- Create Modal (Bottom Sheet) -->
    <div class="modal fade" id="createModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-bottom">
            <form class="modal-content rounded-top-5 border-0" action="<?= base_url('user/forum/create') ?>" method="POST">
                <div class="modal-header border-0 pb-0 justify-content-center">
                    <div style="width: 50px; height: 5px; background: #e2e8f0; border-radius: 10px;"></div>
                </div>
                <div class="modal-body pt-4 px-4">
                    <h5 class="fw-bold mb-4 text-center">Mulai Diskusi Baru</h5>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">KATEGORI</label>
                        <select name="kategori" class="form-select form-select-lg fs-6 rounded-4 bg-light border-0" required>
                            <option value="UMUM">Umum</option>
                            <option value="INFO">Info Lingkungan</option>
                            <option value="DISKUSI">Diskusi Warga</option>
                            <option value="JUAL_BELI">Jual Beli</option>
                            <option value="KEHILANGAN">Laporan Kehilangan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">TOPIK</label>
                        <input type="text" name="judul" class="form-control form-control-lg fs-6 rounded-4 bg-light border-0" placeholder="Apa yang ingin dibahas?" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted">DETAIL</label>
                        <textarea name="isi" class="form-control form-control-lg fs-6 rounded-4 bg-light border-0" rows="5" placeholder="Tuliskan detail diskusi di sini..." required></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow-lg mb-3">Posting ke Forum</button>
                </div>
            </form>
        </div>
    </div>
    
    <style>
        .modal-dialog-bottom { margin: 0; display: flex; align-items: flex-end; min-height: 100%; }
        .modal.fade .modal-dialog-bottom { transform: translate(0, 100%); }
        .modal.show .modal-dialog-bottom { transform: none; transition: transform 0.3s ease-out; }
    </style>

    <!-- Native Bottom Nav -->
    <?php $this->load->view('templates/mobile_nav'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
