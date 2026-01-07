<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?= $thread['judul'] ?> - Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/mobile.css?v='.time()) ?>">
    <style>
        .thread-header {
            background: white;
            padding: 20px;
            border-bottom: 1px solid #f1f5f9;
            position: sticky; top: 0; z-index: 100;
        }
        .author-avatar {
            width: 40px; height: 40px;
            background: var(--primary-color);
            color: white;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700;
            font-size: 14px;
        }
        .comment-item {
            display: flex; gap: 12px;
            margin-bottom: 20px;
        }
        .comment-bubble {
            background: white;
            padding: 12px 16px;
            border-radius: 0 16px 16px 16px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
            max-width: 90%;
        }
        .is-me .comment-bubble {
            background: #dcfce7;
            border-radius: 16px 0 16px 16px;
        }
        .is-me {
            flex-direction: row-reverse;
        }
        .sticky-footer {
            position: fixed; bottom: 0; left: 0; right: 0;
            background: white;
            padding: 10px 15px;
            border-top: 1px solid #f1f5f9;
            display: flex; align-items: center; gap: 10px;
            z-index: 1000;
        }
        body { padding-bottom: 70px; }
    </style>
</head>
<body class="bg-light">

    <!-- App Bar -->
    <div class="thread-header shadow-sm">
        <div class="d-flex align-items-center gap-3">
            <a href="<?= base_url('user/forum') ?>" class="text-dark"><i class="bi bi-arrow-left fs-4"></i></a>
            <div class="text-truncate">
                <h6 class="fw-bold mb-0 text-truncate" style="max-width: 250px;"><?= $thread['judul'] ?></h6>
                <small class="text-muted"><?= $thread['reply_count'] ?> Balasan</small>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="container py-4">
        
        <!-- Original Post -->
        <div class="mb-4">
            <div class="d-flex gap-3 mb-2">
                <div class="author-avatar shadow-sm">
                    <?= substr($thread['nama_lengkap'], 0, 1) ?>
                </div>
                <div>
                    <div class="fw-bold text-dark"><?= $thread['nama_lengkap'] ?></div>
                    <div class="text-muted small">
                        Blok <?= $thread['blok'] ?> • <?= date('d M, H:i', strtotime($thread['created_at'])) ?>
                        <span class="badge bg-primary-subtle text-primary rounded-pill ms-2" style="font-size: 10px;"><?= $thread['kategori'] ?></span>
                    </div>
                </div>
            </div>
            
            <div class="ps-5 ms-2">
                <h5 class="fw-bold text-dark mb-2"><?= $thread['judul'] ?></h5>
                <p class="text-dark opacity-100" style="font-size: 15px; line-height: 1.6;"><?= nl2br($thread['isi']) ?></p>
            </div>
        </div>

        <hr class="border-light-subtle my-4">

        <!-- Comments -->
        <h6 class="fw-bold text-muted small mb-3 text-uppercase ls-1">Komentar</h6>

        <?php if(empty($replies)): ?>
            <div class="text-center py-4">
                <p class="text-muted small">Belum ada balasan. Jadilah yang pertama!</p>
            </div>
        <?php else: ?>
            <?php foreach($replies as $r): ?>
                <?php 
                    $is_me = ($r['user_id'] == $this->session->userdata('user_id'));
                ?>
                <div class="comment-item <?= $is_me ? 'is-me' : '' ?>">
                    <div class="author-avatar" style="width: 32px; height: 32px; font-size: 12px; background: <?= $is_me ? '#10b981' : '#64748b' ?>;">
                        <?= substr($r['nama_lengkap'], 0, 1) ?>
                    </div>
                    <div>
                        <div class="comment-bubble">
                            <?php if(!$is_me): ?>
                                <small class="fw-bold text-primary d-block mb-1" style="font-size: 11px;"><?= $r['nama_lengkap'] ?></small>
                            <?php endif; ?>
                            <p class="mb-0 text-dark" style="font-size: 14px;"><?= nl2br($r['isi']) ?></p>
                        </div>
                        <small class="text-muted d-block mt-1 <?= $is_me ? 'text-end' : '' ?>" style="font-size: 10px;">
                            <?= date('d M H:i', strtotime($r['created_at'])) ?>
                        </small>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </main>

    <!-- Sticky Reply Input -->
    <form class="sticky-footer" action="<?= base_url('user/forum/reply/'.$thread['id']) ?>" method="POST">
        <input type="text" name="isi" class="form-control rounded-pill border-0 bg-light py-2 px-3 focus-ring-0" placeholder="Tulis balasan..." required style="background: #f1f5f9;">
        <button type="submit" class="btn btn-primary rounded-circle shadow-sm" style="width: 42px; height: 42px;">
            <i class="bi bi-send-fill text-white small"></i>
        </button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
