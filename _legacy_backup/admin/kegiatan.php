<?php
session_start();
require_once '../config/database.php';
require_once '../config/helpers.php';


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// HELPER UPLOAD FUNCTION (ENHANCED & ROBUST)
function handleUpload($kegiatan_id) {
    global $conn;
    $target_dir = "../assets/images/kegiatan/";
    
    // 1. Pastikan folder ada
    if (!file_exists($target_dir)) {
        if (!mkdir($target_dir, 0777, true)) {
            return ['success' => 0, 'error' => 'Gagal buat folder'];
        }
    }

    // 2. Pastikan tabel ada (Lazy Init)
    $conn->query("CREATE TABLE IF NOT EXISTS kegiatan_galeri (
        id INT AUTO_INCREMENT PRIMARY KEY,
        kegiatan_id INT NOT NULL,
        file VARCHAR(255) NOT NULL,
        tipe_file ENUM('gambar','video') DEFAULT 'gambar',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // HOTFIX: Cek apakah kolom tipe_file ada? Jika tidak, tambahkan manual.
    $check_col = $conn->query("SHOW COLUMNS FROM kegiatan_galeri LIKE 'tipe_file'");
    if ($check_col->num_rows == 0) {
        $conn->query("ALTER TABLE kegiatan_galeri ADD COLUMN tipe_file ENUM('gambar','video') DEFAULT 'gambar' AFTER file");
    }

    $uploaded_count = 0;
    $error_msg = [];

    // Cek apakah $_FILES ada isinya
    if (!isset($_FILES['media']) || empty($_FILES['media']['name'][0])) {
        return ['success' => 0, 'error' => 'Tidak ada file diterima (Cek ukuran file)'];
    }

    $total = count($_FILES['media']['name']);
    for ($i = 0; $i < $total; $i++) {
        $tmp = $_FILES['media']['tmp_name'][$i];
        $name = $conn->real_escape_string($_FILES['media']['name'][$i]);
        $error = $_FILES['media']['error'][$i];
        
        if ($error === UPLOAD_ERR_OK && $tmp != "") {
            $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            $new_name = "kegiatan_" . $kegiatan_id . "_" . uniqid() . "." . $ext;
            $tipe = in_array($ext, ['mp4','avi','mov']) ? 'video' : 'gambar';
            
            if (move_uploaded_file($tmp, $target_dir . $new_name)) {
                $sql = "INSERT INTO kegiatan_galeri (kegiatan_id, file, tipe_file) VALUES ('$kegiatan_id', '$new_name', '$tipe')";
                if($conn->query($sql)) {
                    $uploaded_count++;
                } else {
                    $error_msg[] = "DB Error: " . $conn->error;
                }
            } else {
                $error_msg[] = "Gagal move_uploaded_file";
            }
        } elseif ($error === UPLOAD_ERR_INI_SIZE || $error === UPLOAD_ERR_FORM_SIZE) {
            $error_msg[] = "File '$name' terlalu besar (Max " . ini_get('upload_max_filesize') . ")";
        } else {
            $error_msg[] = "Error Code: $error untuk file '$name'";
        }
    }
    
    
    // Update foto column with first image
    if ($uploaded_count > 0) {
        $first_img = $conn->query("SELECT file FROM kegiatan_galeri WHERE kegiatan_id = '$kegiatan_id' ORDER BY id ASC LIMIT 1")->fetch_assoc();
        if ($first_img) {
            $conn->query("UPDATE kegiatan SET foto = '{$first_img['file']}' WHERE id = '$kegiatan_id'");
        }
    }
    
    $err_str = count($error_msg) > 0 ? implode(", ", $error_msg) : 0;
    return ['success' => $uploaded_count, 'error' => $err_str];
}

// === HANDLE ACTIONS ===

// 1. ADD KEGIATAN (MULTIPLE UPLOAD)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add_kegiatan') {
    $judul = $conn->real_escape_string($_POST['judul']);
    $deskripsi = $conn->real_escape_string($_POST['deskripsi']);
    $tanggal = $_POST['tanggal'];
    $organisasi_id = $_POST['organisasi_id'];

    $conn->query("INSERT INTO kegiatan (judul, deskripsi, tanggal, organisasi_id) VALUES ('$judul', '$deskripsi', '$tanggal', '$organisasi_id')");
    $kegiatan_id = $conn->insert_id;

    $res = handleUpload($kegiatan_id);
    setFlash('success', "Kegiatan ditambahkan. Sukses: " . $res['success'] . ". Ket: " . $res['error']);
    redirect('admin/kegiatan.php');
}

// 2. EDIT KEGIATAN
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'edit_kegiatan') {
    $id = $_POST['id'];
    $judul = $conn->real_escape_string($_POST['judul']);
    $deskripsi = $conn->real_escape_string($_POST['deskripsi']);
    $tanggal = $_POST['tanggal'];
    $organisasi_id = $_POST['organisasi_id'];

    $conn->query("UPDATE kegiatan SET judul='$judul', deskripsi='$deskripsi', tanggal='$tanggal', organisasi_id='$organisasi_id' WHERE id=$id");
    
    // Upload New Files (Append)
    $res = handleUpload($id);
    setFlash('success', "Perubahan disimpan. Sukses: " . $res['success'] . ". Ket: " . $res['error']);
    redirect('admin/kegiatan.php');
}

// 3. DELETE KEGIATAN (FULL)
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $files = $conn->query("SELECT file FROM kegiatan_galeri WHERE kegiatan_id = $id");
    while($f = $files->fetch_assoc()){
        if(file_exists("../assets/images/kegiatan/".$f['file'])) unlink("../assets/images/kegiatan/".$f['file']);
    }
    $conn->query("DELETE FROM kegiatan_galeri WHERE kegiatan_id = $id");
    $conn->query("DELETE FROM kegiatan WHERE id = $id");
    setFlash('success', 'Kegiatan dihapus.');
    redirect('admin/kegiatan.php');
}

// 4. DELETE SINGLE MEDIA (FROM EDIT MODAL)
if (isset($_GET['delete_media'])) {
    $media_id = $_GET['delete_media'];
    $f = $conn->query("SELECT file FROM kegiatan_galeri WHERE id = $media_id")->fetch_assoc();
    if($f) {
        if(file_exists("../assets/images/kegiatan/".$f['file'])) unlink("../assets/images/kegiatan/".$f['file']);
        $conn->query("DELETE FROM kegiatan_galeri WHERE id = $media_id");
    }
    setFlash('success', 'Media dihapus.');
    redirect('admin/kegiatan.php');
}


// FETCH DATA (Refactored for Calendar & List)
$kegiatan_res = $conn->query("SELECT k.*, o.nama_organisasi FROM kegiatan k JOIN organisasi o ON k.organisasi_id = o.id ORDER BY k.tanggal DESC");
$kegiatan_list = [];
$activity_dates = []; // [ '2025-01-01' => true ]

while($row = $kegiatan_res->fetch_assoc()) {
    $kegiatan_list[] = $row;
    $d = date('Y-m-d', strtotime($row['tanggal']));
    $activity_dates[$d] = true;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Kegiatan - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .upload-area {
            border: 2px dashed #cbd5e1; border-radius: 12px; padding: 20px;
            text-align: center; transition: all 0.3s; background: #f8fafc; cursor: pointer;
        }
        .upload-area:hover { border-color: #16a34a; background: #f0fdf4; }
        .preview-container { display: flex; gap: 10px; overflow-x: auto; padding-top: 10px; }
        .preview-item, .existing-item {
            width: 70px; height: 70px; border-radius: 8px; object-fit: cover; border: 1px solid #ddd; flex-shrink: 0;
        }
        .existing-wrapper { position: relative; width: 70px; height: 70px; flex-shrink: 0; }
        .btn-del-img {
            position: absolute; top: -5px; right: -5px; width: 20px; height: 20px;
            background: red; color: white; border-radius: 50%; font-size: 10px;
            display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 10;
        }
        .cal-cell:hover { background-color: #f0fdf4; cursor: pointer; }
    </style>
</head>
<body class="bg-light">

    <?php include 'navbar.php'; ?>

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold m-0">Kelola Kegiatan Warga</h3>
            <div>
                <button class="btn btn-outline-success me-2" onclick="toggleCalendar()"><i class="bi bi-calendar3 me-2"></i>Toggle Kalender</button>
                <button class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="bi bi-plus-lg me-2"></i> Tambah Kegiatan
                </button>
            </div>
        </div>

        <?= getFlash(); ?>

        <!-- ADMIN INTERACTIVE CALENDAR -->
        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" id="calendarSection">
            <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between">
                <h6 class="fw-bold m-0 text-success"><i class="bi bi-calendar-check me-2"></i>Kalender Kegiatan</h6>
                <small class="text-muted">Klik tanggal kosong untuk tambah kegiatan baru</small>
            </div>
            <div class="card-body p-0">
                <?php
                $month = date('m'); $year = date('Y');
                $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                $firstDay = date('N', strtotime("$year-$month-01"));
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered text-center m-0" style="table-layout: fixed;">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-secondary small py-2">SEN</th><th class="text-secondary small py-2">SEL</th>
                                <th class="text-secondary small py-2">RAB</th><th class="text-secondary small py-2">KAM</th>
                                <th class="text-secondary small py-2">JUM</th><th class="text-danger small py-2">SAB</th><th class="text-danger small py-2">MIN</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <?php
                            $offset = 0; $dayCount = 1;
                            for ($i=1; $i<$firstDay; $i++) { echo "<td class='bg-light'></td>"; $offset++; }
                            while ($dayCount <= $daysInMonth) {
                                $dStr = sprintf('%04d-%02d-%02d', $year, $month, $dayCount);
                                $hasEvent = isset($activity_dates[$dStr]);
                                $bg = $hasEvent ? 'bg-success-subtle' : '';
                                
                                echo "<td class='cal-cell $bg p-1 position-relative' style='height:80px; vertical-align:top;' onclick='openAddModal(\"$dStr\")'>";
                                echo "<div class='d-flex justify-content-between p-1'>";
                                echo "<span class='small fw-bold ".($dStr == date('Y-m-d') ? 'text-primary' : 'text-muted')."'>$dayCount</span>";
                                if($hasEvent) echo "<i class='bi bi-circle-fill text-success' style='font-size:6px;'></i>";
                                echo "</div>";
                                if($hasEvent) echo "<div class='text-center mt-1'><span class='badge bg-success' style='font-size:8px'>Ada Kegiatan</span></div>";
                                echo "</td>";
                                
                                $offset++; $dayCount++;
                                if ($offset % 7 == 0) echo "</tr><tr>";
                            }
                            while ($offset % 7 != 0) { echo "<td class='bg-light'></td>"; $offset++; }
                            ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3" width="15%">TANGGAL</th>
                                <th width="15%">MEDIA</th>
                                <th width="30%">DETAIL KEGIATAN</th>
                                <th>DESKRIPSI</th>
                                <th class="text-end pe-4">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($kegiatan_list) > 0): ?>
                                <?php foreach($kegiatan_list as $row): ?>
                                    <?php 
                                        // Get Media
                                        $media_res = $conn->query("SELECT * FROM kegiatan_galeri WHERE kegiatan_id = ".$row['id']);
                                        $media = [];
                                        while($m = $media_res->fetch_assoc()) $media[] = $m;
                                        
                                        $thumbnail = !empty($media) ? $media[0]['file'] : null;
                                        $thumbType = !empty($media) ? $media[0]['tipe_file'] : 'gambar';
                                        $countMedia = count($media);
                                        
                                        // Prepare data for JS
                                        $jsonData = htmlspecialchars(json_encode([
                                            'id' => $row['id'],
                                            'judul' => $row['judul'],
                                            'deskripsi' => $row['deskripsi'],
                                            'tanggal' => $row['tanggal'],
                                            'organisasi_id' => $row['organisasi_id'],
                                            'media' => $media
                                        ]), ENT_QUOTES, 'UTF-8');
                                    ?>
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold"><?= date('d M', strtotime($row['tanggal'])) ?></div>
                                        <div class="text-muted small"><?= date('Y', strtotime($row['tanggal'])) ?></div>
                                    </td>
                                    <td>
                                        <div class="position-relative d-inline-block">
                                            <?php if($thumbnail): ?>
                                                <?php if($thumbType == 'video'): ?>
                                                    <div class="bg-dark text-white rounded-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                        <i class="bi bi-play-circle-fill"></i>
                                                    </div>
                                                <?php else: ?>
                                                    <img src="../assets/images/kegiatan/<?= $thumbnail ?>" class="rounded-3 shadow-sm object-fit-cover" style="width: 60px; height: 60px;">
                                                <?php endif; ?>
                                                
                                                <?php if($countMedia > 1): ?>
                                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                                                        +<?= $countMedia-1 ?>
                                                    </span>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <div class="bg-light text-muted rounded-3 d-flex align-items-center justify-content-center border" style="width: 60px; height: 60px;">
                                                    <i class="bi bi-image"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark"><?= $row['judul'] ?></div>
                                        <span class="badge bg-primary-subtle text-primary rounded-pill mt-1" style="font-size: 10px;">
                                            <?= $row['nama_organisasi'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-muted small text-truncate d-block" style="max-width: 300px;">
                                            <?= substr($row['deskripsi'], 0, 100) ?>...
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-light text-primary btn-sm rounded-circle shadow-sm me-1" onclick='openEdit(<?= $jsonData ?>)'><i class="bi bi-pencil-fill"></i></button>
                                        <a href="?delete=<?= $row['id'] ?>" class="btn btn-light text-danger btn-sm rounded-circle shadow-sm" onclick="return confirm('Hapus kegiatan ini?')" title="Hapus"><i class="bi bi-trash-fill"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="5" class="text-center py-5 text-muted">Belum ada data kegiatan.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL ADD (Sama seperti sebelumnya) -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form class="modal-content rounded-4" method="POST" enctype="multipart/form-data">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Tambah Kegiatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" name="action" value="add_kegiatan">
                    <!-- Form Fields (Simplified for brevity as they are standard) -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-8">
                            <label class="form-label small fw-bold text-muted">JUDUL</label>
                            <input type="text" name="judul" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-muted">ORGANISASI</label>
                            <select name="organisasi_id" class="form-select">
                                <?php $orgs = $conn->query("SELECT * FROM organisasi"); while($o = $orgs->fetch_assoc()): ?>
                                <option value="<?= $o['id'] ?>"><?= $o['nama_organisasi'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">UPLOAD DOKUMENTASI</label>
                        <div class="upload-area" onclick="document.getElementById('fileInput').click()">
                            <i class="bi bi-cloud-arrow-up-fill fs-3 text-muted"></i>
                            <p class="small mb-0 text-muted">Klik untuk upload (Bisa banyak)</p>
                            <input type="file" name="media[]" id="fileInput" class="d-none" multiple accept="image/*,video/*" onchange="previewFiles(this, 'previewBox')">
                        </div>
                        <div class="preview-container" id="previewBox"></div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-4"><label class="form-label small fw-bold text-muted">TANGGAL</label><input type="date" name="tanggal" class="form-control" required></div>
                        <div class="col-md-8"><label class="form-label small fw-bold text-muted">DESKRIPSI</label><textarea name="deskripsi" class="form-control" rows="2" required></textarea></div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0"><button type="submit" class="btn btn-primary-custom w-100 py-2">Simpan</button></div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form class="modal-content rounded-4" method="POST" enctype="multipart/form-data">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Edit Kegiatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" name="action" value="edit_kegiatan">
                    <input type="hidden" name="id" id="edit_id">
                    
                    <div class="row g-3 mb-3">
                        <div class="col-md-8">
                            <label class="form-label small fw-bold text-muted">JUDUL</label>
                            <input type="text" name="judul" id="edit_judul" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-muted">ORGANISASI</label>
                            <select name="organisasi_id" id="edit_org" class="form-select">
                                <?php $orgs = $conn->query("SELECT * FROM organisasi"); while($o = $orgs->fetch_assoc()): ?>
                                <option value="<?= $o['id'] ?>"><?= $o['nama_organisasi'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Existing Media -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">GALERI SAAT INI</label>
                        <div class="d-flex gap-2 overflow-auto pb-2" id="existingMediaBox">
                            <!-- Populated by JS -->
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">TAMBAH FOTO/VIDEO BARU</label>
                        <div class="upload-area" onclick="document.getElementById('editFileInput').click()">
                            <i class="bi bi-plus-circle fs-3 text-muted"></i>
                            <p class="small mb-0 text-muted">Tambah File Baru</p>
                            <input type="file" name="media[]" id="editFileInput" class="d-none" multiple accept="image/*,video/*" onchange="previewFiles(this, 'editPreviewBox')">
                        </div>
                        <div class="preview-container" id="editPreviewBox"></div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4"><label class="form-label small fw-bold text-muted">TANGGAL</label><input type="date" name="tanggal" id="edit_tanggal" class="form-control" required></div>
                        <div class="col-md-8"><label class="form-label small fw-bold text-muted">DESKRIPSI</label><textarea name="deskripsi" id="edit_deskripsi" class="form-control" rows="2" required></textarea></div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0"><button type="submit" class="btn btn-warning text-white w-100 py-2">Update Perubahan</button></div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function previewFiles(input, targetId) {
            var preview = document.getElementById(targetId);
            preview.innerHTML = '';
            if (input.files) {
                for (i = 0; i < input.files.length; i++) {
                    var reader = new FileReader();
                    reader.onload = function(event) {
                        var img = document.createElement('img');
                        img.src = event.target.result;
                        img.className = 'preview-item';
                        preview.appendChild(img);
                    }
                    reader.readAsDataURL(input.files[i]);
                }
            }
        }

        function openEdit(data) {
            document.getElementById('edit_id').value = data.id;
            document.getElementById('edit_judul').value = data.judul;
            document.getElementById('edit_deskripsi').value = data.deskripsi;
            document.getElementById('edit_tanggal').value = data.tanggal;
            document.getElementById('edit_org').value = data.organisasi_id;
            
            // Populate Existing Media
            const box = document.getElementById('existingMediaBox');
            box.innerHTML = '';
            if(data.media && data.media.length > 0) {
                data.media.forEach(m => {
                    const div = document.createElement('div');
                    div.className = 'existing-wrapper';
                    
                    let content = '';
                    if(m.tipe_file === 'video') {
                        content = `<video src="../assets/images/kegiatan/${m.file}" class="existing-item bg-dark"></video>`;
                    } else {
                        content = `<img src="../assets/images/kegiatan/${m.file}" class="existing-item">`;
                    }
                    
                    div.innerHTML = `
                        ${content}
                        <a href="?delete_media=${m.id}" class="btn-del-img" onclick="return confirm('Hapus foto/video ini?')"><i class="bi bi-x"></i></a>
                    `;
                    box.appendChild(div);
                });
            } else {
                box.innerHTML = '<span class="text-muted small">Tidak ada media.</span>';
            }

            new bootstrap.Modal(document.getElementById('editModal')).show();
        }
        function toggleCalendar() {
            const cal = document.getElementById('calendarSection');
            if(cal.style.display === 'none') {
                cal.style.display = 'block';
            } else {
                cal.style.display = 'none';
            }
        }

        function openAddModal(dateStr) {
            // Set field tanggal di form addModal
            const dateInput = document.querySelector('#addModal input[name="tanggal"]');
            if(dateInput) dateInput.value = dateStr;
            
            new bootstrap.Modal(document.getElementById('addModal')).show();
        }
    </script>
</body>
</html>
