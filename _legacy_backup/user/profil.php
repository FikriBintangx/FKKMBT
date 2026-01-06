<?php
session_start();
require_once '../config/database.php';

// Auth Check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'warga') {
    header("Location: ../login.php");
    exit;
}

// --- AUTO FIX SCHEMA (DARURAT) ---
$cols = [];
$res = $conn->query("SHOW COLUMNS FROM warga");
while($r = $res->fetch_assoc()) { $cols[] = $r['Field']; }

if(!in_array('jenis_kelamin', $cols)) {
    $conn->query("ALTER TABLE warga ADD COLUMN jenis_kelamin ENUM('L','P') DEFAULT NULL AFTER nama_lengkap");
}
if(!in_array('no_hp', $cols)) {
    $conn->query("ALTER TABLE warga ADD COLUMN no_hp VARCHAR(20) DEFAULT NULL AFTER jenis_kelamin");
}
// ---------------------------------

$user_id = $_SESSION['user_id'];
$success_msg = '';
$error_msg = '';

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 1. Update Profile Info
    // 1. Update Profile Info
    if (isset($_POST['update_profile'])) {
        $nama = $conn->real_escape_string($_POST['nama_lengkap']);
        if (!empty($nama)) {
            $jk = $conn->real_escape_string($_POST['jenis_kelamin']);
            $hp_new = (isset($_POST['no_hp']) && !empty($_POST['no_hp'])) ? $conn->real_escape_string($_POST['no_hp']) : null;
            
            // Cek apakah data warga sudah ada?
            $check = $conn->query("SELECT id FROM warga WHERE user_id = $user_id");
            
            if ($check->num_rows > 0) {
                // UPDATE (Data sudah ada)
                $sql_update = "UPDATE warga SET nama_lengkap = '$nama', jenis_kelamin = '$jk'";
                if ($hp_new) {
                    $sql_update .= ", no_hp = '$hp_new'";
                }
                $sql_update .= " WHERE user_id = $user_id";
                $conn->query($sql_update);
            } else {
                // INSERT (Baru pertama kali isi profil)
                // Kita sederhanakan query agar sesuai schema umum (wajib: blok, no_rumah biasanya not null default '-')
                // Hilangkan status_huni/status_nikah yg mungkin tidak ada kolomnya
                
                $hp_val = $hp_new ? "'$hp_new'" : "NULL";
                // Gunakan default '-' untuk blok/rumah karena user belum tentu tau/isi form ini
                $sql_insert = "INSERT INTO warga (user_id, nama_lengkap, jenis_kelamin, no_hp, blok, no_rumah) 
                               VALUES ($user_id, '$nama', '$jk', $hp_val, '-', '-')";
                
                if(!$conn->query($sql_insert)) {
                    // Jika masih gagal (mungkin kolom blok/no_rumah ga ada?), coba super simple
                    // TAPI kali ini sertakan no_hp jika ada
                    $sql_fallback = "INSERT INTO warga (user_id, nama_lengkap, jenis_kelamin";
                    if($hp_new) $sql_fallback .= ", no_hp";
                    $sql_fallback .= ") VALUES ($user_id, '$nama', '$jk'";
                    if($hp_new) $sql_fallback .= ", '$hp_new'";
                    $sql_fallback .= ")";
                    
                    $conn->query($sql_fallback);
                }
            }
            
            $success_msg = "Profil berhasil diperbarui.";
        } else {
            $error_msg = "Nama tidak boleh kosong.";
        }
    }

    // 2. Upload Photo
    if (isset($_POST['upload_photo'])) {
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
            $allowed = ['jpg', 'jpeg', 'png'];
            $filename = $_FILES['foto']['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            
            if (in_array($ext, $allowed)) {
                $new_name = "warga_" . $user_id . "_" . time() . "." . $ext;
                $destination = "../assets/images/warga/" . $new_name;
                
                // Create dir if not exists
                if (!file_exists("../assets/images/warga")) {
                    mkdir("../assets/images/warga", 0777, true);
                }

                if (move_uploaded_file($_FILES['foto']['tmp_name'], $destination)) {
                    // Start Transaction
                    $conn->begin_transaction();
                    try {
                        // Get old photo to delete
                        $old = $conn->query("SELECT foto FROM warga WHERE user_id = $user_id")->fetch_assoc();
                        
                        // Update DB
                        $conn->query("UPDATE warga SET foto = '$new_name' WHERE user_id = $user_id");
                        
                        // Delete old file
                        if ($old['foto'] && file_exists("../assets/images/warga/" . $old['foto'])) {
                            unlink("../assets/images/warga/" . $old['foto']);
                        }
                        
                        $conn->commit();
                        $success_msg = "Foto profil berhasil diperbarui.";
                    } catch (Exception $e) {
                        $conn->rollback();
                        $error_msg = "Gagal memperbarui database.";
                    }
                } else {
                    $error_msg = "Gagal mengupload gambar.";
                }
            } else {
                $error_msg = "Format file tidak valid. Gunakan JPG atau PNG.";
            }
        }
    }

    // 3. Change Password
    if (isset($_POST['change_password'])) {
        $old_pass = $_POST['old_password'];
        $new_pass = $_POST['new_password'];
        $confirm_pass = $_POST['confirm_password'];

        $user = $conn->query("SELECT password FROM users WHERE id = $user_id")->fetch_assoc();
        
        if (password_verify($old_pass, $user['password'])) {
            if ($new_pass === $confirm_pass) {
                if (strlen($new_pass) >= 6) {
                    $hashed = password_hash($new_pass, PASSWORD_DEFAULT);
                    $conn->query("UPDATE users SET password = '$hashed' WHERE id = $user_id");
                    $success_msg = "Password berhasil diubah.";
                } else {
                    $error_msg = "Password baru minimal 6 karakter.";
                }
            } else {
                $error_msg = "Konfirmasi password tidak cocok.";
            }
        } else {
            $error_msg = "Password lama salah.";
        }
    }
}

// Reload Data
$warga = $conn->query("SELECT * FROM warga WHERE user_id = $user_id")->fetch_assoc();
$username = $conn->query("SELECT username FROM users WHERE id = $user_id")->fetch_assoc()['username'];
$current_page = 'profil';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Saya - FKKMBT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="dashboard-container">
    <!-- Navbar -->
    <?php include 'navbar.php'; ?>

    <div class="main-content container py-4 mt-5 pt-5">
        <h3 class="fw-bold mb-4">Pengaturan Profil</h3>

        <?php if($success_msg): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $success_msg ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if($error_msg): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $error_msg ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row g-4">
            <!-- Left: Profile Card & Photo -->
            <div class="col-md-4">
                <div class="card-bubble text-center">
                    <div class="position-relative d-inline-block mb-3">
                        <?php if($warga['foto']): ?>
                            <img src="../assets/images/warga/<?= $warga['foto'] ?>" class="rounded-circle shadow-sm" style="width:120px;height:120px;object-fit:cover;border:4px solid white;">
                        <?php else: ?>
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto shadow-sm" style="width:120px;height:120px;font-size:3rem;border:4px solid white;">
                                <?= substr($warga['nama_lengkap'],0,1) ?>
                            </div>
                        <?php endif; ?>
                        <button class="btn btn-sm btn-primary position-absolute bottom-0 end-0 rounded-circle shadow-sm" data-bs-toggle="modal" data-bs-target="#photoModal" style="width:36px;height:36px;">
                            <i class="bi bi-camera-fill"></i>
                        </button>
                    </div>
                    <h5 class="fw-bold mb-1"><?= $warga['nama_lengkap'] ?></h5>
                    <p class="text-muted mb-3">@<?= $username ?></p>
                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">Warga</span>
                </div>
                
                <div class="card-bubble mt-4">
                    <h6 class="fw-bold mb-3 border-bottom pb-2">Informasi Hunian</h6>
                    <div class="d-flex justify-content-between mb-2 p-2">
                        <span class="text-muted">Blok</span>
                        <span class="fw-bold"><?= $warga['blok'] ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 p-2 bg-light rounded-3">
                        <span class="text-muted">No. Rumah</span>
                        <span class="fw-bold"><?= $warga['no_rumah'] ?></span>
                    </div>
                    <div class="d-flex justify-content-between p-2">
                        <span class="text-muted">Status</span>
                        <span class="fw-bold text-success">Aktif</span>
                    </div>
                </div>
            </div>

            <!-- Right: Edit Forms -->
            <div class="col-md-8">
                <div class="card-bubble mb-4">
                    <h5 class="fw-bold mb-4">Edit Biodata</h5>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold ms-2">NAMA LENGKAP</label>
                            <input type="text" name="nama_lengkap" class="form-control form-control-bubble border border-dark border-opacity-25" value="<?= $warga['nama_lengkap'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold ms-2">JENIS KELAMIN</label>
                            <select name="jenis_kelamin" class="form-select form-control-bubble border border-dark border-opacity-25" required>
                                <option value="L" <?= isset($warga['jenis_kelamin']) && $warga['jenis_kelamin'] == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                <option value="P" <?= isset($warga['jenis_kelamin']) && $warga['jenis_kelamin'] == 'P' ? 'selected' : '' ?>>Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold ms-2">NOMOR HP (WhatsApp)</label>
                            <?php if(!empty($warga['no_hp'])): ?>
                                <input type="text" class="form-control form-control-bubble bg-light border border-dark border-opacity-10" value="<?= $warga['no_hp'] ?>" readonly disabled>
                                <div class="form-text ms-2 mt-2 text-danger small"><i class="bi bi-info-circle me-1"></i> Hubungi admin untuk mengubah nomor HP.</div>
                            <?php else: ?>
                                <input type="text" name="no_hp" class="form-control form-control-bubble border border-dark border-opacity-25" placeholder="Masukkan Nomor WA (Wajib)" required>
                            <?php endif; ?>
                        </div>
                        <div class="text-end mt-4">
                            <button type="submit" name="update_profile" class="btn btn-primary btn-bubble shadow-sm text-white">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>

                <div class="card-bubble">
                    <h5 class="fw-bold mb-4">Keamanan / Ganti Password</h5>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold ms-2">PASSWORD LAMA</label>
                            <input type="password" name="old_password" class="form-control form-control-bubble border border-dark border-opacity-25" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted small fw-bold ms-2">PASSWORD BARU</label>
                                <input type="password" name="new_password" class="form-control form-control-bubble border border-dark border-opacity-25" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted small fw-bold ms-2">KONFIRMASI PASSWORD</label>
                                <input type="password" name="confirm_password" class="form-control form-control-bubble border border-dark border-opacity-25" required>
                            </div>
                        </div>
                        <div class="text-end mt-2">
                            <button type="submit" name="change_password" class="btn btn-danger btn-bubble shadow-sm">Ganti Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upload Photo Modal -->
<div class="modal fade" id="photoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Ganti Foto Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pilih Foto (JPG/PNG)</label>
                        <input type="file" name="foto" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="upload_photo" class="btn btn-primary">Upload Foto</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
