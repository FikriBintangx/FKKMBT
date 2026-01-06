<?php
session_start();
require_once '../config/database.php';
require_once '../config/helpers.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// Handle CRUD Logic
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        // ADD NEW WARGA
        if ($_POST['action'] == 'add') {
            $nama = $conn->real_escape_string($_POST['nama']);
            $username = $conn->real_escape_string($_POST['username']);
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $blok = $conn->real_escape_string($_POST['blok_huruf'] . $_POST['blok_angka']);
            $no_rumah = $conn->real_escape_string($_POST['no_rumah']);
            $hp = $conn->real_escape_string($_POST['no_hp']);

            // Check username
            $check = $conn->query("SELECT id FROM users WHERE username = '$username'");
            if ($check->num_rows == 0) {
                // 1. Create User
                $conn->query("INSERT INTO users (username, password, role) VALUES ('$username', '$password', 'warga')");
                $user_id = $conn->insert_id;

                // 2. Create Warga
                if ($conn->query("INSERT INTO warga (user_id, nama_lengkap, blok, no_rumah, no_hp) VALUES ('$user_id', '$nama', '$blok', '$no_rumah', '$hp')")) {
                    setFlash('success', 'Warga berhasil ditambahkan.');
                } else {
                    setFlash('error', 'Gagal menambah data warga.');
                }
            } else {
                setFlash('error', 'Username sudah digunakan.');
            }
            redirect('admin/warga.php');
        }

        // EDIT WARGA
        if ($_POST['action'] == 'edit') {
            $id = $_POST['id'];
            $nama = $conn->real_escape_string($_POST['nama']);
            $blok = $conn->real_escape_string($_POST['blok_huruf'] . $_POST['blok_angka']);
            $no_rumah = $conn->real_escape_string($_POST['no_rumah']);
            $hp = $conn->real_escape_string($_POST['no_hp']);

            // Update Warga Data
            $updateWarga = $conn->query("UPDATE warga SET nama_lengkap = '$nama', blok = '$blok', no_rumah = '$no_rumah', no_hp = '$hp' WHERE id = '$id'");
            
            if (!$updateWarga) {
                setFlash('error', 'Gagal update data warga: ' . $conn->error);
                redirect('admin/warga.php');
            }
            
            // Optional: Reset Password if filled
            if (!empty($_POST['password'])) {
                $user_id = $_POST['user_id'];
                if(!empty($user_id)) {
                    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    $updateUser = $conn->query("UPDATE users SET password = '$password' WHERE id = '$user_id'");
                    if (!$updateUser) {
                        setFlash('error', 'Gagal reset password: ' . $conn->error);
                        redirect('admin/warga.php');
                    }
                }
            }
            
            setFlash('success', 'Data warga berhasil diperbarui.');
            redirect('admin/warga.php');
        }

        // DELETE WARGA
        if ($_POST['action'] == 'delete') {
            $id = $_POST['id'];
            $user_id = $_POST['user_id'];
            
            // Delete Warga first then User
            $conn->query("DELETE FROM warga WHERE id = '$id'");
            $conn->query("DELETE FROM users WHERE id = '$user_id'"); // Caution: This deletes the account
            
            setFlash('success', 'Warga berhasil dihapus.');
            redirect('admin/warga.php');
        }
    }
}

// Filter
$blok_filter = isset($_GET['blok']) ? $_GET['blok'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Fetch Data with Filter
$sql = "SELECT w.*, u.username FROM warga w JOIN users u ON w.user_id = u.id WHERE 1=1";
if (!empty($blok_filter)) {
    $sql .= " AND w.blok LIKE '" . $conn->real_escape_string($blok_filter) . "%'";
}
if (!empty($search)) {
    $sql .= " AND w.nama_lengkap LIKE '%" . $conn->real_escape_string($search) . "%'";
}
$sql .= " ORDER BY w.blok ASC, w.no_rumah ASC";
$warga = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Data Warga - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- Fix Modal Backdrop Issue -->
    <style>
        .modal-backdrop.show { z-index: 1040; }
        .modal { z-index: 1050; }
    </style>
</head>
<body class="bg-light">

    <!-- Top Navbar -->
    <?php include 'navbar.php'; ?>

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold m-0">Data Warga Perumahan</h3>
                <p class="text-muted m-0">Kelola akun dan data warga blok.</p>
            </div>
            <button class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="bi bi-plus-lg me-2"></i> Tambah Warga
            </button>
        </div>

        <?= getFlash(); ?>

        <!-- Block Selector Grid -->
        <div class="card-clean mb-4 p-4">
            <h5 class="fw-bold mb-3"><i class="bi bi-grid-3x3-gap me-2"></i>Pilih Blok</h5>
            <div class="row g-2">
                <div class="col-6 col-md-3 col-lg-2">
                    <a href="?blok=" class="text-decoration-none">
                        <div class="block-card <?= empty($blok_filter) ? 'active' : '' ?> text-center p-3 rounded-3 border">
                            <i class="bi bi-house-door-fill fs-3 d-block mb-2"></i>
                            <small class="fw-bold">Semua</small>
                        </div>
                    </a>
                </div>
                <?php foreach(range('A','T') as $b): ?>
                <div class="col-6 col-md-3 col-lg-2">
                    <a href="?blok=<?= $b ?><?= !empty($search) ? '&search='.urlencode($search) : '' ?>" class="text-decoration-none">
                        <div class="block-card <?= $blok_filter == $b ? 'active' : '' ?> text-center p-3 rounded-3 border">
                            <i class="bi bi-house-fill fs-3 d-block mb-2"></i>
                            <small class="fw-bold">Blok <?= $b ?></small>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="card-clean mb-4 p-3">
            <form action="" method="GET" class="row g-2 align-items-center">
                <input type="hidden" name="blok" value="<?= htmlspecialchars($blok_filter) ?>">
                <div class="col-md-10">
                    <input type="text" name="search" class="form-control" placeholder="🔍 Cari nama warga..." value="<?= htmlspecialchars($search) ?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Cari</button>
                </div>
            </form>
        </div>

        <div class="card-clean">
            <div class="table-responsive p-3">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 rounded-start">Warga</th>
                            <th class="border-0">Alamat (Blok/No)</th>
                            <th class="border-0">Kontak / Akun</th>
                            <th class="border-0">Foto</th>
                            <th class="border-0 rounded-end text-end px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if ($warga->num_rows > 0):
                            while($row = $warga->fetch_assoc()): 
                                $jsonData = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                        ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width:40px;height:40px;"><?= substr($row['nama_lengkap'],0,1) ?></div>
                                    <div>
                                        <h6 class="mb-0 fw-bold"><?= $row['nama_lengkap'] ?></h6>
                                        <small class="text-muted text-xs">ID: <?= $row['id'] ?></small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border me-1">Blok <?= $row['blok'] ?></span>
                                <span class="fw-bold">No. <?= $row['no_rumah'] ?></span>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <small><i class="bi bi-whatsapp text-success me-1"></i> <?= $row['no_hp'] ?></small>
                                    <small class="text-muted">@<?= $row['username'] ?></small>
                                </div>
                            </td>
                            <td>
                                <?php if(isset($row['foto_profil']) && $row['foto_profil']): ?>
                                    <img src="../assets/images/warga/<?= $row['foto_profil'] ?>" class="rounded-circle" width="32" height="32" style="object-fit:cover; border: 2px solid #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                                <?php else: ?>
                                    <span class="text-muted small">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end px-4">
                                <button class="btn btn-sm btn-light text-primary me-2" onclick='openEditModal(<?= $jsonData ?>)'><i class="bi bi-pencil-fill"></i></button>
                                <button class="btn btn-sm btn-light text-danger" onclick='openDeleteModal(<?= $jsonData ?>)'><i class="bi bi-trash-fill"></i></button>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-center py-5">Belum ada data warga.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- SHARED Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" method="POST">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Tambah Warga Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="add">
                    
                    <h6 class="text-primary fw-bold mb-3 small text-uppercase">Informasi Akun</h6>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold">Username</label>
                            <input type="text" name="username" class="form-control" required placeholder="user123">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold">Password</label>
                            <input type="password" name="password" class="form-control" required placeholder="******">
                        </div>
                    </div>

                    <h6 class="text-primary fw-bold mb-3 mt-4 small text-uppercase">Biodata Warga</h6>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" required placeholder="Nama Lengkap">
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-8">
                            <label class="form-label small fw-bold">Blok</label>
                            <div class="input-group">
                                <span class="input-group-text">Blok</span>
                                <select name="blok_huruf" class="form-select" required>
                                    <option value="">-</option>
                                    <?php foreach(range('A','T') as $h) echo "<option value='$h'>$h</option>"; ?>
                                </select>
                                <select name="blok_angka" class="form-select" required>
                                    <option value="">No</option>
                                    <?php foreach(range(1,5) as $n) echo "<option value='$n'>$n</option>"; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <label class="form-label small fw-bold">No Rumah</label>
                            <input type="number" name="no_rumah" class="form-control" required placeholder="01">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">No HP (WhatsApp)</label>
                        <input type="text" name="no_hp" class="form-control" placeholder="08xxxxxxxxxx">
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <!-- SHARED Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" method="POST">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Edit Warga</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="id" id="edit_id">
                    <input type="hidden" name="user_id" id="edit_user_id">
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Lengkap</label>
                        <input type="text" name="nama" id="edit_nama" class="form-control" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-8">
                            <label class="form-label small fw-bold">Blok</label>
                            <div class="input-group">
                                <span class="input-group-text">Blok</span>
                                <select name="blok_huruf" id="edit_blok_huruf" class="form-select" required>
                                    <?php foreach(range('A','T') as $h) echo "<option value='$h'>$h</option>"; ?>
                                </select>
                                <select name="blok_angka" id="edit_blok_angka" class="form-select" required>
                                    <?php foreach(range(1,5) as $n) echo "<option value='$n'>$n</option>"; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <label class="form-label small fw-bold">No Rumah</label>
                            <input type="text" name="no_rumah" id="edit_no_rumah" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">No HP (WA)</label>
                        <input type="text" name="no_hp" id="edit_no_hp" class="form-control">
                    </div>
                    <div class="mb-3 pt-3 border-top">
                        <label class="form-label small fw-bold text-danger">Reset Password (Opsional)</label>
                        <div class="input-group">
                            <input type="password" name="password" id="edit_password" class="form-control" placeholder="******** (Biarkan kosong jika tidak ingin merubah)">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('edit_password', this)">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- SHARED Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <form class="modal-content" method="POST">
                <div class="modal-body text-center p-4">
                    <i class="bi bi-exclamation-circle text-danger display-4 mb-3"></i>
                    <h5 class="fw-bold mb-2">Hapus Warga?</h5>
                    <p class="text-muted small mb-4">Data akun dan profil warga ini akan dihapus permanen.</p>
                    
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" id="delete_id">
                    <input type="hidden" name="user_id" id="delete_user_id">
                    
                    <div class="d-flex gap-2 justify-content-center">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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

        function openEditModal(data) {

            document.getElementById('edit_id').value = data.id;
            document.getElementById('edit_user_id').value = data.user_id;
            document.getElementById('edit_nama').value = data.nama_lengkap;
            document.getElementById('edit_no_rumah').value = data.no_rumah;
            document.getElementById('edit_no_hp').value = data.no_hp;
            
            // Parse Blok (e.g. "Q5" -> Q and 5)
            const blok = data.blok || '';
            let huruf = '';
            let angka = '';
            
            if (blok.length > 0) {
                huruf = blok.charAt(0); // A-T
                if (blok.length > 1) {
                    angka = blok.substring(1); // 1-5
                }
            }
            
            document.getElementById('edit_blok_huruf').value = huruf;
            document.getElementById('edit_blok_angka').value = angka;

            // Clear password field to avoid accidental changes or browser autofill confusion
            document.getElementById('edit_password').value = '';

            new bootstrap.Modal(document.getElementById('editModal')).show();
        }

        function openDeleteModal(data) {
            document.getElementById('delete_id').value = data.id;
            document.getElementById('delete_user_id').value = data.user_id;
            
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        }
    </script>
</body>
</html>
