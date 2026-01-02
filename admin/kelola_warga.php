<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

$success_msg = '';
$error_msg = '';
$generated_password = '';

// Function to generate random password
function generatePassword($length = 8) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    return substr(str_shuffle($chars), 0, $length);
}

// Handle Actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';

    // CREATE WARGA
    if ($action == 'create') {
        $nama = $conn->real_escape_string($_POST['nama_lengkap']);
        $blok = $conn->real_escape_string($_POST['blok']);
        $no_rumah = $conn->real_escape_string($_POST['no_rumah']);
        $no_hp = $conn->real_escape_string($_POST['no_hp']);
        $jenis_kelamin = $conn->real_escape_string($_POST['jenis_kelamin']);
        
        // Generate username from nama (lowercase, no spaces)
        $username = strtolower(str_replace(' ', '', $nama));
        
        // Check if username exists, add number if needed
        $check = $conn->query("SELECT id FROM users WHERE username = '$username'");
        if ($check->num_rows > 0) {
            $username .= rand(10, 99);
        }
        
        // Generate password
        $password = generatePassword(8);
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert to users table
        $conn->query("INSERT INTO users (username, password, role) VALUES ('$username', '$hashed', 'warga')");
        $user_id = $conn->insert_id;
        
        // Insert to warga table
        $conn->query("INSERT INTO warga (user_id, nama_lengkap, blok, no_rumah, no_hp, jenis_kelamin) 
                     VALUES ('$user_id', '$nama', '$blok', '$no_rumah', '$no_hp', '$jenis_kelamin')");
        
        $success_msg = "Warga berhasil ditambahkan!";
        $generated_password = "Username: <strong>$username</strong> | Password: <strong>$password</strong>";
    }

    // UPDATE WARGA
    elseif ($action == 'update') {
        $warga_id = $_POST['warga_id'];
        $nama = $conn->real_escape_string($_POST['nama_lengkap']);
        $blok = $conn->real_escape_string($_POST['blok']);
        $no_rumah = $conn->real_escape_string($_POST['no_rumah']);
        $no_hp = $conn->real_escape_string($_POST['no_hp']);
        $jenis_kelamin = $conn->real_escape_string($_POST['jenis_kelamin']);
        
        $conn->query("UPDATE warga SET nama_lengkap='$nama', blok='$blok', no_rumah='$no_rumah', 
                      no_hp='$no_hp', jenis_kelamin='$jenis_kelamin' WHERE id='$warga_id'");
        
        $success_msg = "Data warga berhasil diupdate!";
    }

    // RESET PASSWORD
    elseif ($action == 'reset_password') {
        $user_id = $_POST['user_id'];
        $password = generatePassword(8);
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        
        $conn->query("UPDATE users SET password='$hashed' WHERE id='$user_id'");
        
        $user = $conn->query("SELECT username FROM users WHERE id='$user_id'")->fetch_assoc();
        $success_msg = "Password berhasil direset!";
        $generated_password = "Username: <strong>{$user['username']}</strong> | Password Baru: <strong>$password</strong>";
    }

    // DELETE WARGA
    elseif ($action == 'delete') {
        $warga_id = $_POST['warga_id'];
        $user_id_query = $conn->query("SELECT user_id FROM warga WHERE id='$warga_id'")->fetch_assoc();
        $user_id = $user_id_query['user_id'];
        
        $conn->query("DELETE FROM warga WHERE id='$warga_id'");
        $conn->query("DELETE FROM users WHERE id='$user_id'");
        
        $success_msg = "Warga berhasil dihapus!";
    }
}

// Get all warga
$warga_list = $conn->query("SELECT w.*, u.username FROM warga w JOIN users u ON w.user_id = u.id ORDER BY w.blok, w.no_rumah");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Warga - Admin FKKMBT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <main class="main-content container py-4 mt-5 pt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold">Kelola Data Warga</h2>
                <p class="text-muted">Tambah, edit, dan kelola akun warga perumahan</p>
            </div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="bi bi-plus-circle me-2"></i>Tambah Warga Baru
            </button>
        </div>

        <!-- Alert Messages -->
        <?php if ($success_msg): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i><?= $success_msg ?>
            <?php if ($generated_password): ?>
                <div class="mt-2 p-3 bg-white rounded border">
                    <i class="bi bi-key-fill me-2"></i><?= $generated_password ?>
                    <small class="d-block mt-2 text-danger">⚠️ Catat dan berikan ke warga yang bersangkutan!</small>
                </div>
            <?php endif; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <!-- Warga Table -->
        <div class="card border-0 shadow-sm" style="border-radius: 20px;">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 ps-4">No</th>
                                <th class="border-0">Nama Lengkap</th>
                                <th class="border-0">Username</th>
                                <th class="border-0">Alamat</th>
                                <th class="border-0">No. HP</th>
                                <th class="border-0">JK</th>
                                <th class="border-0 text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; while($w = $warga_list->fetch_assoc()): ?>
                            <tr>
                                <td class="ps-4"><?= $no++ ?></td>
                                <td class="fw-semibold"><?= $w['nama_lengkap'] ?></td>
                                <td><span class="badge bg-info-subtle text-info"><?= $w['username'] ?></span></td>
                                <td>Blok<?= $w['blok'] ?> Nomer <?= $w['no_rumah'] ?></td>
                                <td><?= $w['no_hp'] ?? '-' ?></td>
                                <td><?= $w['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-primary" onclick="editWarga(<?= htmlspecialchars(json_encode($w)) ?>)">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-outline-warning" onclick="resetPassword(<?= $w['user_id'] ?>)">
                                            <i class="bi bi-key"></i>
                                        </button>
                                        <button class="btn btn-outline-danger" onclick="deleteWarga(<?= $w['id'] ?>, '<?= $w['nama_lengkap'] ?>')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- Add Warga Modal -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Tambah Warga Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <input type="hidden" name="action" value="create">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Lengkap *</label>
                            <input type="text" name="nama_lengkap" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Blok *</label>
                                <select name="blok" class="form-select" required>
                                    <?php 
                                    foreach(range('A','T') as $letter) {
                                        for($num = 1; $num <= 5; $num++) {
                                            echo "<option value='{$letter}{$num}'>{$letter}{$num}</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">No. Rumah *</label>
                                <input type="text" name="no_rumah" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">No. HP</label>
                            <input type="text" name="no_hp" class="form-control" placeholder="08xx">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Jenis Kelamin *</label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="alert alert-info border-0">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            <small>Username & password akan di-generate otomatis</small>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Warga</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Warga Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Edit Data Warga</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="warga_id" id="edit_warga_id">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Lengkap *</label>
                            <input type="text" name="nama_lengkap" id="edit_nama" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Blok *</label>
                                <select name="blok" id="edit_blok" class="form-select" required>
                                    <?php 
                                    foreach(range('A','T') as $letter) {
                                        for($num = 1; $num <= 5; $num++) {
                                            echo "<option value='{$letter}{$num}'>{$letter}{$num}</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">No. Rumah *</label>
                                <input type="text" name="no_rumah" id="edit_no_rumah" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">No. HP</label>
                            <input type="text" name="no_hp" id="edit_no_hp" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Jenis Kelamin *</label>
                            <select name="jenis_kelamin" id="edit_jk" class="form-select" required>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Hidden Forms for Actions -->
    <form id="resetPasswordForm" method="POST" style="display:none;">
        <input type="hidden" name="action" value="reset_password">
        <input type="hidden" name="user_id" id="reset_user_id">
    </form>

    <form id="deleteForm" method="POST" style="display:none;">
        <input type="hidden" name="action" value="delete">
        <input type="hidden" name="warga_id" id="delete_warga_id">
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function editWarga(data) {
            document.getElementById('edit_warga_id').value = data.id;
            document.getElementById('edit_nama').value = data.nama_lengkap;
            document.getElementById('edit_blok').value = data.blok;
            document.getElementById('edit_no_rumah').value = data.no_rumah;
            document.getElementById('edit_no_hp').value = data.no_hp || '';
            document.getElementById('edit_jk').value = data.jenis_kelamin;
            new bootstrap.Modal(document.getElementById('editModal')).show();
        }

        function resetPassword(userId) {
            if(confirm('Reset password untuk warga ini? Password baru akan di-generate otomatis.')) {
                document.getElementById('reset_user_id').value = userId;
                document.getElementById('resetPasswordForm').submit();
            }
        }

        function deleteWarga(wargaId, nama) {
            if(confirm(`Hapus warga "${nama}"? Data tidak dapat dikembalikan!`)) {
                document.getElementById('delete_warga_id').value = wargaId;
                document.getElementById('deleteForm').submit();
            }
        }
    </script>
</body>
</html>
