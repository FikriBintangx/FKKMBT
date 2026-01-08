<?php $page_title = 'Profil Saya'; ?>
<?php $this->load->view('user/templates/header'); ?>

<!-- Green Header -->
<div class="header-section" style="background: linear-gradient(135deg, #022c22 0%, #14532d 100%); padding: 20px; color: white;">
    <div class="d-flex align-items-center gap-3">
        <a href="<?= base_url('user/dashboard') ?>" class="text-white text-decoration-none bg-white bg-opacity-10 rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div class="flex-grow-1">
            <h5 class="fw-bold mb-0">Manajemen Profil</h5>
            <p class="mb-0 small opacity-75">Kelola informasi profil dan akun</p>
        </div>
        <a href="<?= base_url('auth/logout') ?>" class="btn btn-white-glass btn-sm border-0 bg-white bg-opacity-20 text-white rounded-pill px-3">
            <i class="bi bi-box-arrow-right me-1"></i>Logout
        </a>
    </div>
</div>

<main class="container py-4">
    <!-- Page Header -->
    <div class="mb-4" style="display: none;">
        <h2 class="fw-bold mb-1">Profil Saya</h2>
        <p class="text-muted mb-0">Kelola informasi profil dan keamanan akun</p>
    </div>

    <!-- Alert Messages -->
    <?php if ($this->session->flashdata('success_msg')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i><?= $this->session->flashdata('success_msg') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error_msg')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i><?= $this->session->flashdata('error_msg') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>
    
    <!-- Kartu Informasi Pribadi -->
    <div class="card border-0 shadow-sm rounded-4 mb-3">
        <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0">
            <h6 class="fw-bold mb-0 d-flex align-items-center gap-2">
                <i class="bi bi-person-badge text-primary"></i> Informasi Pribadi
            </h6>
        </div>
        <div class="card-body p-4">
            <div class="mb-3">
                <label class="small text-muted mb-1">Nama Lengkap</label>
                <div class="fw-bold text-dark"><?= isset($warga['nama_lengkap']) ? $warga['nama_lengkap'] : '-' ?></div>
            </div>
            
            <div class="row g-3">
                <div class="col-6">
                    <label class="small text-muted mb-1">Blok Rumah</label>
                    <div class="fw-bold text-dark fs-5"><?= isset($warga['blok']) ? $warga['blok'] : '-' ?></div>
                </div>
                <div class="col-6">
                    <label class="small text-muted mb-1">No. Rumah</label>
                    <div class="fw-bold text-dark fs-5"><?= isset($warga['no_rumah']) ? $warga['no_rumah'] : '-' ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kartu Kontak -->
    <div class="card border-0 shadow-sm rounded-4 mb-3">
         <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0">
            <h6 class="fw-bold mb-0 d-flex align-items-center gap-2">
                <i class="bi bi-telephone text-success"></i> Kontak & Akun
            </h6>
        </div>
        <div class="card-body p-4">
             <div class="mb-3">
                <label class="small text-muted mb-1">Email</label>
                <div class="d-flex align-items-center gap-2">
                    <span class="fw-medium text-dark"><?= isset($user->email) ? $user->email : '-' ?></span>
                    <?php if(isset($user->email)): ?>
                        <i class="bi bi-check-circle-fill text-success small" title="Terverifikasi"></i>
                    <?php endif; ?>
                </div>
            </div>
            <div class="mb-0">
                <label class="small text-muted mb-1">No. Handphone</label>
                <div class="fw-medium text-dark"><?= isset($warga['no_hp']) ? $warga['no_hp'] : '-' ?></div>
            </div>
        </div>
    </div>

    <!-- Kartu Keamanan (Ganti Password) -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0">
            <h6 class="fw-bold mb-0 d-flex align-items-center gap-2">
                <i class="bi bi-shield-lock text-danger"></i> Keamanan
            </h6>
        </div>
        <div class="card-body p-4">
            
            <?php if($this->session->flashdata('success')): ?>
                <div class="alert alert-success rounded-3 small py-2 mb-3">
                    <i class="bi bi-check-circle me-1"></i> <?= $this->session->flashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger rounded-3 small py-2 mb-3">
                    <i class="bi bi-exclamation-circle me-1"></i> <?= $this->session->flashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('user/profil/change_password') ?>" method="POST">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Password Baru *</label>
                    <div class="input-group">
                        <input type="password" name="new_password" id="new_password" class="form-control" required minlength="6">
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('new_password', this)">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <small class="text-muted">Minimal 6 karakter</small>
                </div>
                
                <div class="mb-4">
                    <label class="form-label fw-semibold">Konfirmasi Password Baru *</label>
                    <div class="input-group">
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" required minlength="6">
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirm_password', this)">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-shield-lock me-2"></i>Ubah Password
                </button>
            </form>
        </div>
    </div>
</main>

<script>
function togglePassword(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
}
</script>

<?php $this->load->view('user/templates/footer'); ?>
