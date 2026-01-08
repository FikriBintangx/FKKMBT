<?php $page_title = 'Profil Saya'; ?>
<?php $this->load->view('user/templates/header'); ?>

<!-- Green Header -->
<div style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); padding: 20px; color: white;">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <a href="<?= base_url('user/dashboard') ?>" class="text-white text-decoration-none">
                <i class="bi bi-arrow-left me-2"></i>
            </a>
            <h4 class="fw-bold mb-1 mt-2">Manajemen Profil</h4>
            <p class="mb-0 small opacity-75">Kelola informasi profil dan keamanan akun</p>
        </div>
        <a href="<?= base_url('auth/logout') ?>" class="btn btn-light btn-sm">
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

    <!-- Profil Card -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-4">Informasi Pribadi</h5>
            
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label text-muted small">Nama Lengkap</label>
                    <input type="text" class="form-control" value="<?= $warga['nama_lengkap'] ?? '-' ?>" readonly>
                </div>
                <div class="col-md-3">
                    <label class="form-label text-muted small">Blok</label>
                    <input type="text" class="form-control" value="<?= $warga['blok'] ?? '-' ?>" readonly>
                </div>
                <div class="col-md-3">
                    <label class="form-label text-muted small">No. Rumah</label>
                    <input type="text" class="form-control" value="<?= $warga['no_rumah'] ?? '-' ?>" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted small">Email</label>
                    <input type="text" class="form-control" value="<?= isset($user->email) ? $user->email : '-' ?>" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted small">No. HP</label>
                    <input type="text" class="form-control" value="<?= $warga['no_hp'] ?? '-' ?>" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted small">Jenis Kelamin</label>
                    <input type="text" class="form-control" value="<?= ($warga['jenis_kelamin'] ?? 'L') == 'L' ? 'Laki-laki' : 'Perempuan' ?>" readonly>
                </div>
            </div>

            <div class="alert alert-info mt-4 mb-0">
                <small>
                    <i class="bi bi-info-circle me-1"></i>
                    Untuk mengubah data profil, silakan hubungi admin RT.
                </small>
            </div>
        </div>
    </div>

    <!-- Ubah Password Card -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-4">Ubah Password</h5>
            
            <form action="<?= base_url('user/profil/change_password') ?>" method="POST">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Password Lama *</label>
                    <div class="input-group">
                        <input type="password" name="old_password" id="old_password" class="form-control" required>
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('old_password', this)">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
                
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
