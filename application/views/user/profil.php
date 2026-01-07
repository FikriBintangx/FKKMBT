<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Profil Saya - FKKMBT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/mobile.css?v='.time()) ?>">
    <style>
        .profile-hero {
            background: var(--primary-gradient);
            padding: 50px 20px 80px;
            border-radius: 0 0 40px 40px;
            text-align: center;
            color: white;
            position: relative;
        }
        .profile-avatar-wrapper {
            position: relative;
            display: inline-block;
            margin-bottom: 15px;
        }
        .profile-avatar {
            width: 100px; height: 100px;
            background: white;
            border-radius: 30px;
            display: flex; align-items: center; justify-content: center;
            font-size: 45px; color: #2d6a5f;
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
            border: 4px solid rgba(255,255,255,0.2);
        }
        .edit-badge {
            position: absolute;
            bottom: -5px; right: -5px;
            background: #f97316;
            color: white;
            width: 32px; height: 32px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            border: 3px solid white;
            font-size: 14px;
        }
        .settings-container {
            margin-top: -50px;
            padding: 0 20px 100px;
            position: relative;
            z-index: 10;
        }
        .form-group-card {
            background: white;
            border-radius: 24px;
            padding: 24px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }
        .section-label {
            font-size: 11px;
            font-weight: 800;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 20px;
            display: block;
        }
        .input-icon-wrapper {
            position: relative;
            margin-bottom: 15px;
        }
        .input-icon-wrapper i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 18px;
        }
        .input-icon-wrapper .form-control {
            padding-left: 45px !important;
            background: #f8fafc !important;
            border: 1px solid #e2e8f0 !important;
        }
        .input-icon-wrapper textarea.form-control {
            padding-top: 12px !important;
        }
        .btn-update {
            background: var(--primary-gradient);
            color: white;
            border: none;
            width: 100%;
            padding: 16px;
            border-radius: 18px;
            font-weight: 700;
            box-shadow: 0 10px 20px rgba(45, 106, 95, 0.2);
            transition: all 0.3s;
        }
        .btn-update:active {
            transform: scale(0.98);
        }
        .btn-logout {
            background: #fff;
            color: #ef4444;
            border: 2px solid #fee2e2;
            width: 100%;
            padding: 14px;
            border-radius: 18px;
            font-weight: 700;
            margin-top: 10px;
        }
    </style>
</head>
<body class="bg-light">

    <!-- App Bar -->
    <div class="app-bar d-lg-none" style="background: transparent; box-shadow: none;">
        <div class="d-flex align-items-center gap-3">
            <a href="<?= base_url('user/dashboard') ?>" class="text-white"><i class="bi bi-chevron-left fs-4"></i></a>
            <span class="fw-bold">Manajemen Profil</span>
        </div>
    </div>

    <div class="profile-hero">
        <div class="profile-avatar-wrapper">
            <div class="profile-avatar">
                <i class="bi bi-person-fill"></i>
            </div>
            <div class="edit-badge shadow-sm">
                <i class="bi bi-camera-fill"></i>
            </div>
        </div>
        <h4 class="fw-bold mb-1"><?= $warga['nama_lengkap'] ?></h4>
        <p class="small opacity-75 mb-0">Warga Bukit Tiara • Blok <?= $warga['blok'] ?> / <?= $warga['no_rumah'] ?></p>
    </div>

    <main class="settings-container">
        <?php if ($this->session->flashdata('success_msg')): ?>
            <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 py-3 d-flex align-items-center gap-3">
                <i class="bi bi-check-circle-fill fs-4 text-success"></i>
                <div class="small fw-bold text-success"><?= $this->session->flashdata('success_msg') ?></div>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('user/profil/update') ?>" method="POST">
            <div class="form-group-card">
                <label class="section-label">Informasi Personal</label>
                
                <div class="input-icon-wrapper">
                    <i class="bi bi-person text-primary"></i>
                    <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama Lengkap" value="<?= $warga['nama_lengkap'] ?>" required>
                </div>

                <div class="input-icon-wrapper">
                    <i class="bi bi-whatsapp text-success"></i>
                    <input type="text" name="no_hp" class="form-control" placeholder="No. WhatsApp" value="<?= $warga['no_hp'] ?>" required>
                </div>

                <div class="input-icon-wrapper mb-0">
                    <i class="bi bi-geo-alt text-danger" style="top: 25px;"></i>
                    <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat Lengkap"><?= trim(strip_tags(html_entity_decode($warga['alamat']))) ?></textarea>
                </div>
            </div>

            <div class="form-group-card">
                <label class="section-label">Akses Akun</label>
                
                <div class="input-icon-wrapper">
                    <i class="bi bi-shield-lock"></i>
                    <input type="text" class="form-control bg-light opacity-75" value="<?= $user['username'] ?>" readonly>
                </div>

                <div class="input-icon-wrapper mb-0">
                    <i class="bi bi-key"></i>
                    <input type="password" name="password" class="form-control" placeholder="Ubah Password (Optional)">
                </div>
                <small class="text-muted mt-2 d-block" style="font-size: 10px;">Kosongkan jika tidak ingin mengubah password.</small>
            </div>

            <button type="submit" class="btn-update mb-3">
                <i class="bi bi-cloud-upload-fill me-2"></i> Perbarui Profil
            </button>

            <a href="<?= base_url('auth/logout') ?>" class="btn-logout text-decoration-none d-flex align-items-center justify-content-center">
                <i class="bi bi-power me-2"></i> Keluar dari Akun
            </a>
        </form>

        <p class="text-center text-muted mt-5 small">
            FKKMBT • App Version 2.4.0<br>
            <span class="opacity-50">Bukit Tiara Digital Society</span>
        </p>
    </main>

    <!-- Bottom Nav -->
    <?php $this->load->view('templates/mobile_nav'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
