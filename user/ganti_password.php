<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !==  'warga') {
    header("Location: ../login.php");
    exit;
}

$success_msg = '';
$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id =$_SESSION['user_id'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validate
    if ($new_password !== $confirm_password) {
        $error_msg = "Password baru dan konfirmasi tidak cocok!";
    } else {
        // Check old password
        $user = $conn->query("SELECT password FROM users WHERE id='$user_id'")->fetch_assoc();
        
        if (!password_verify($old_password, $user['password'])) {
            $error_msg = "Password lama salah!";
        } else {
            // Update password
            $hashed = password_hash($new_password, PASSWORD_DEFAULT);
            $conn->query("UPDATE users SET password='$hashed' WHERE id='$user_id'");
            $success_msg = "Password berhasil diubah!";
        }
    }
}

$warga = $conn->query("SELECT * FROM warga WHERE user_id = {$_SESSION['user_id']}")->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ganti Password - FKKMBT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <main class="main-content container py-4 mt-5 pt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <div class="mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background: linear-gradient(135deg, #2d6a5f 0%, #1f5449 100%); border-radius: 50%;">
                                <i class="bi bi-key-fill text-white" style="font-size: 2rem;"></i>
                            </div>
                            <h4 class="fw-bold">Ganti Password</h4>
                            <p class="text-muted">Ubah password akun Anda untuk keamanan</p>
                        </div>

                        <?php if ($success_msg): ?>
                        <div class="alert alert-success alert-dismissible">
                            <i class="bi bi-check-circle-fill me-2"></i><?= $success_msg ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php endif; ?>

                        <?php if ($error_msg): ?>
                        <div class="alert alert-danger alert-dismissible">
                            <i class="bi bi-exclamation-circle-fill me-2"></i><?= $error_msg ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Password Lama</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-lock text-muted"></i>
                                    </span>
                                    <input type="password" name="old_password" class="form-control border-start-0" placeholder="Masukkan password lama" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Password Baru</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-key text-muted"></i>
                                    </span>
                                    <input type="password" name="new_password" class="form-control border-start-0" placeholder="Masukkan password baru" minlength="6" required>
                                </div>
                                <small class="text-muted">Minimal 6 karakter</small>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Konfirmasi Password Baru</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-shield-check text-muted"></i>
                                    </span>
                                    <input type="password" name="confirm_password" class="form-control border-start-0" placeholder="Ulangi password baru" required>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-check-circle me-2"></i>Ubah Password
                                </button>
                                <a href="dashboard.php" class="btn btn-light">
                                    <i class="bi bi-arrow-left me-2"></i>Kembali ke Dashboard
                                </a>
                            </div>
                        </form>

                        <div class="alert alert-warning border-0 mt-4">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            <small><strong>Tips Keamanan:</strong> Gunakan kombinasi huruf besar, kecil, angka, dan simbol untuk password yang kuat.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
