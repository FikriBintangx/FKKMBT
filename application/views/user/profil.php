<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Profil Saya - FKKMBT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/mobile.css?v='.time()) ?>">
    <style>
        .profile-header {
            background: var(--primary-gradient);
            padding: 40px 20px;
            border-radius: 0 0 32px 32px;
            text-align: center;
            color: white;
            margin-bottom: -40px;
        }
        .avatar-box {
            width: 90px; height: 90px;
            background: white;
            border-radius: 24px;
            margin: 0 auto 15px;
            display: flex; align-items: center; justify-content: center;
            font-size: 40px; color: var(--primary-color);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .settings-card {
            background: white;
            border-radius: 24px;
            padding: 24px;
            margin: 0 20px;
            position: relative;
            z-index: 10;
        }
    </style>
</head>
<body class="bg-light">

    <!-- Mobile App Bar (Light version) -->
    <div class="app-bar d-lg-none" style="background: transparent; box-shadow: none;">
        <div class="d-flex align-items-center gap-3">
            <a href="<?= base_url('user/dashboard') ?>" class="text-white"><i class="bi bi-chevron-left fs-4"></i></a>
            <span class="fw-bold">Pengaturan Profil</span>
        </div>
    </div>

    <div class="profile-header">
        <div class="avatar-box">
            <i class="bi bi-person-fill"></i>
        </div>
        <h4 class="fw-bold mb-1"><?= $warga['nama_lengkap'] ?></h4>
        <p class="small opacity-75 mb-0">Blok <?= $warga['blok'] ?> No. <?= $warga['no_rumah'] ?></p>
    </div>

    <main class="py-5 mt-4">
        <div class="settings-card shadow-sm mb-4">
            <h6 class="fw-bold mb-4 text-muted text-uppercase small">Informasi Pribadi</h6>
            
            <?php if ($this->session->flashdata('success_msg')): ?>
                <div class="alert alert-success small py-2 mb-4"><?= $this->session->flashdata('success_msg') ?></div>
            <?php endif; ?>

            <form action="<?= base_url('user/profil/update') ?>" method="POST">
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">NAMA LENGKAP</label>
                    <input type="text" name="nama_lengkap" class="form-control" value="<?= $warga['nama_lengkap'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">NO. WHATSAPP</label>
                    <input type="text" name="no_hp" class="form-control" value="<?= $warga['no_hp'] ?>" required>
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-bold text-muted">ALAMAT</label>
                    <textarea name="alamat" class="form-control" rows="2"><?= $warga['alamat'] ?></textarea>
                </div>

                <hr class="my-4 opacity-5">
                <h6 class="fw-bold mb-4 text-muted text-uppercase small">Keamanan Akun</h6>
                
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">USERNAME</label>
                    <input type="text" class="form-control bg-light" value="<?= $user['username'] ?>" readonly>
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-bold text-muted">GANTI PASSWORD (KOSONGKAN JIKA TIDAK)</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••">
                </div>

                <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow-sm">
                    Simpan Perubahan
                </button>
            </form>
        </div>

        <div class="px-4 mt-5">
            <a href="<?= base_url('auth/logout') ?>" class="btn btn-outline-danger w-100 py-3 rounded-pill fw-bold">
                <i class="bi bi-box-arrow-right me-2"></i>Keluar Aplikasi
            </a>
            <p class="text-center text-muted mt-4 pb-5 small">FKKMBT Mobile Version 2.0.0</p>
        </div>
    </main>

    <!-- Native Bottom Nav -->
    <?php $this->load->view('templates/mobile_nav'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
