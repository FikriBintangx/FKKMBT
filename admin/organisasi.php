<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// === AUTO MIGRATE TABLE IF MISSING COLUMNS ===
$check_cols = $conn->query("SHOW COLUMNS FROM struktur_organisasi");
$existing_cols = [];
while($col = $check_cols->fetch_assoc()) {
    $existing_cols[] = $col['Field'];
}

if (!in_array('jenis_kelamin', $existing_cols)) {
    $conn->query("ALTER TABLE struktur_organisasi ADD COLUMN jenis_kelamin ENUM('L','P') DEFAULT 'L' AFTER level");
}
if (!in_array('kontak', $existing_cols)) {
    $conn->query("ALTER TABLE struktur_organisasi ADD COLUMN kontak VARCHAR(20) DEFAULT NULL AFTER level");
}
if (!in_array('foto', $existing_cols)) {
    $conn->query("ALTER TABLE struktur_organisasi ADD COLUMN foto VARCHAR(255) DEFAULT NULL AFTER nama");
}
// ============================================

// === HANDLE ACTIONS ===

// 1. ADD DATA
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add_struktur') {
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $level = $_POST['level'];
    $tipe = $_POST['tipe_organisasi'];
    $jk = $_POST['jenis_kelamin'];
    $kontak = isset($_POST['kontak']) ? $_POST['kontak'] : '';
    
    // Format WA
    if(!empty($kontak)){
        $kontak = preg_replace('/[^0-9]/', '', $kontak);
        if(substr($kontak, 0, 1) == '0') $kontak = '62'.substr($kontak, 1);
    }

    $foto = '';
    if (!empty($_FILES['foto']['name'])) {
        $target_dir = '../assets/images/pengurus/';
        if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);

        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto = 'pengurus_'.time().'.'.$ext;
        
        if(!move_uploaded_file($_FILES['foto']['tmp_name'], $target_dir.$foto)){
             $foto = '';
        }
    }

    $stmt = $conn->prepare("INSERT INTO struktur_organisasi (nama, jabatan, level, foto, tipe_organisasi, kontak, jenis_kelamin) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssissss", $nama, $jabatan, $level, $foto, $tipe, $kontak, $jk);
    $stmt->execute();
    setFlash('success', 'Pengurus berhasil ditambahkan.');
    redirect('admin/organisasi.php');
}

// 2. EDIT DATA
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'edit_struktur') {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $level = $_POST['level'];
    $jk = $_POST['jenis_kelamin'];
    $kontak = isset($_POST['kontak']) ? $_POST['kontak'] : '';
    
    // Format WA
    if(!empty($kontak)){
        $kontak = preg_replace('/[^0-9]/', '', $kontak);
        if(substr($kontak, 0, 1) == '0') $kontak = '62'.substr($kontak, 1);
    }

    // Cek foto lama
    $existing = $conn->query("SELECT foto FROM struktur_organisasi WHERE id=$id")->fetch_assoc();
    $foto = $existing['foto'];

    if (!empty($_FILES['foto']['name'])) {
        $target_dir = '../assets/images/pengurus/';
        if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);

        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $new_foto = 'pengurus_edit_'.time().'.'.$ext;
        
        if(move_uploaded_file($_FILES['foto']['tmp_name'], $target_dir.$new_foto)){
            $foto = $new_foto;
        }
    }

    $stmt = $conn->prepare("UPDATE struktur_organisasi SET nama=?, jabatan=?, level=?, foto=?, kontak=?, jenis_kelamin=? WHERE id=?");
    $stmt->bind_param("ssisssi", $nama, $jabatan, $level, $foto, $kontak, $jk, $id);
    $stmt->execute();
    setFlash('success', 'Data pengurus berhasil diperbarui.');
    redirect('admin/organisasi.php');
}

// 3. DELETE DATA
if (isset($_GET['delete_struktur'])) {
    $id = $_GET['delete_struktur'];
    $conn->query("DELETE FROM struktur_organisasi WHERE id = $id");
    setFlash('success', 'Pengurus dihapus.');
    redirect('admin/organisasi.php');
}

// FETCH DATA with Custom Sorting
function getGroupedStruct($conn, $type) {
    $sql = "SELECT * FROM struktur_organisasi WHERE UPPER(tipe_organisasi) = UPPER('$type')";
    $res = $conn->query($sql);
    
    $grouped = [];
    while($row = $res->fetch_assoc()) {
        $jabatan = strtoupper(trim($row['jabatan']));
        $grouped[$jabatan][] = $row;
    }

    $sortOrder = [
        'PEMBINA' => 1, 'KETUA' => 2, 'PENASEHAT' => 3, 'BENDAHARA I' => 4, 'WAKIL KETUA' => 5, 'SEKRETARIS I' => 6,
        'BENDAHARA II' => 7, 'SEKRETARIS II' => 8,
        'SEKSI KESEJAHTERAAN' => 20, 'SEKSI PENGEMBANGAN EKONOMI' => 21, 'SEKSI HUMAS, PUBLIKASI DAN KOMUNIKASI' => 22,
        'SEKSI KEPEMUDAAN DAN OLAHRAGA' => 23, 'SEKSI PERENCANAAN LINGKUNGAN' => 24, 'SEKSI SENI DAN BUDAYA' => 25,
        'SEKSI KEROHANIAN' => 26, 'SEKSI KEAMANAN' => 27, 'SEKSI PERLENGKAPAN' => 28, 'SEKSI KEWANITAAN' => 29
    ];

    uksort($grouped, function($k1, $k2) use ($sortOrder) {
        $p1 = $sortOrder[$k1] ?? 999;
        $p2 = $sortOrder[$k2] ?? 999;
        return ($p1 == $p2) ? 0 : (($p1 < $p2) ? -1 : 1);
    });

    return $grouped;
}

$struct_fkkmbt = getGroupedStruct($conn, 'FKKMBT');
$struct_fkkmmbt = getGroupedStruct($conn, 'FKKMMBT');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Struktur - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .org-box {
            background: white; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden;
            height: 100%; transition: all 0.2s; position: relative; z-index: 1;
        }
        .org-box:hover { box-shadow: 0 10px 20px rgba(0,0,0,0.05); transform: translateY(-3px); }
        .org-header {
            padding: 12px; border-bottom: 1px solid #e2e8f0; text-align: center; 
            font-weight: 700; font-size: 0.85rem; text-transform: uppercase;
        }
        .org-body { padding: 15px; }
        .person-item {
            display: flex; align-items: center; gap: 10px; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px dashed #f1f5f9;
            position: relative;
        }
        .person-item:last-child { margin-bottom: 0; padding-bottom: 0; border-bottom: none; }
        .person-name { font-weight: 600; font-size: 0.9rem; color: #1e293b; line-height: 1.2; }
        
        /* Admin Actions */
        .admin-actions { margin-left: auto; display: flex; gap: 5px; }
        .btn-act { width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; border-radius: 4px; border: none; font-size: 10px; transition: 0.2s; color: white !important;}
        .btn-act:hover { opacity: 0.9; transform: scale(1.05); }
        
        .section-badge { display: inline-block; padding: 6px 16px; border-radius: 50px; font-weight: bold; margin-bottom: 20px; font-size: 14px; }

        /* CONNECTOR LINES CSS - UPDATED TEBAL & NYAMBUNG */
        .org-box { --line-color: #94a3b8; --line-width: 4px; --line-reach: 40px; } /* Variables Scoped if needed, or global */
        
        :root {
            --line-color: #94a3b8;
            --line-width: 4px;
            --line-reach: 40px;
        }

        .line-down::after {
            content: ''; position: absolute; width: var(--line-width); height: var(--line-reach); background: var(--line-color);
            left: 50%; bottom: calc(var(--line-reach) * -1); transform: translateX(-50%); z-index: 0;
        }
        .line-up::before {
            content: ''; position: absolute; width: var(--line-width); height: var(--line-reach); background: var(--line-color);
            left: 50%; top: calc(var(--line-reach) * -1); transform: translateX(-50%); z-index: 0;
        }
        .line-horizontal { position: relative; }
        .line-horizontal::before {
            content: ''; position: absolute; height: var(--line-width); background: var(--line-color);
            top: calc(var(--line-reach) * -1); left: 16%; right: 16%; z-index: 0;
        }
        .line-center-connector::after {
            content: ''; position: absolute; width: var(--line-width); height: var(--line-reach); background: var(--line-color);
            left: 50%; top: calc(var(--line-reach) * -1); transform: translateX(-50%); z-index: 0;
        }
        
        /* Spacer Dashed */
        .spacer-dashed {
            position:absolute; left:50%; top:-40px; height:120px; 
            border-left: 4px dashed var(--line-color); opacity: 0.5;
        }
        
        @media (max-width: 768px) {
            .line-down::after, .line-up::before, .line-horizontal::before, .line-center-connector::after, .spacer-dashed { display: none; }
        }
    </style>
</head>
<body class="bg-light">

    <?php include 'navbar.php'; ?>

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold m-0">Kelola Data Struktur Organisasi</h3>
            <div>
                 <button class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#addPengurusModal">
                    <i class="bi bi-plus-lg me-2"></i> Tambah Pengurus
                </button>
            </div>
        </div>

        <?= getFlash(); ?>
        
        <?php
        // Helper Render Card with Admin Actions
        function renderAdminCard($data, $members, $color='success') {
            if(empty($members)) return ''; 
            
            $textClass = ($color == 'warning') ? 'text-dark' : 'text-'.$color;
            
            $html = '<div class="org-box border-'.$color.'">';
            $html .= '<div class="org-header '.$textClass.' bg-'.$color.' bg-opacity-10">'.$data.'</div>';
            $html .= '<div class="org-body">';
            
            $total = count($members);

            foreach($members as $idx => $m) {
                $json = htmlspecialchars(json_encode($m), ENT_QUOTES, 'UTF-8');
                
                $html .= '<div class="person-item">';
                
                // DISPLAY FOTO IF EXISTS
                if(!empty($m['foto']) && file_exists('../assets/images/pengurus/'.$m['foto'])) {
                    $html .= '<img src="../assets/images/pengurus/'.$m['foto'].'" class="rounded-circle border" style="width: 28px; height: 28px; object-fit: cover;">';
                } else { 
                    // CONDITIONAL NUMBERING
                    if($total > 1) {
                         $html .= '<div class="bg-light rounded-circle d-flex align-items-center justify-content-center text-secondary fw-bold" style="width: 28px; height: 28px; font-size: 0.75rem;">'.($idx+1).'</div>';
                    } else {
                         $html .= '<div class="bg-light rounded-circle d-flex align-items-center justify-content-center text-secondary" style="width: 28px; height: 28px; font-size: 0.9rem;"><i class="bi bi-person-fill"></i></div>';
                    }
                }
                
                $html .= '<div>';
                $html .= '<div class="person-name">'.$m['nama'].'</div>';
                if(!empty($m['kontak'])) $html .= '<small class="text-muted" style="font-size:10px"><i class="bi bi-whatsapp"></i> '.$m['kontak'].'</small>';
                $html .= '</div>';
                
                // Admin Buttons
                $html .= '<div class="admin-actions">';
                $html .= '<a href="#" class="btn-act bg-warning" onclick=\'openEditModal('.$json.')\' title="Edit"><i class="bi bi-pencil"></i></a>';
                $html .= '<a href="?delete_struktur='.$m['id'].'" class="btn-act bg-danger" onclick="return confirm(\'Yakin hapus?\')" title="Hapus"><i class="bi bi-trash"></i></a>';
                $html .= '</div>'; 
                
                $html .= '</div>'; 
            }
            $html .= '</div></div>';
            return $html;
        }
        ?>

        <!-- BAGAN FKKMBT -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white border-bottom-0 pt-3 text-center">
                <span class="section-badge bg-success text-white shadow-sm"><i class="bi bi-people-fill me-2"></i> FKKMBT</span>
                <a href="print_struktur.php?tipe=fkkmbt" target="_blank" class="btn btn-sm btn-outline-success rounded-pill ms-2"><i class="bi bi-printer"></i> Cetak</a>
            </div>
            <div class="card-body bg-light bg-opacity-10 p-4">
                 <?php if(empty($struct_fkkmbt)): ?><p class="text-muted small text-center">Belum ada data.</p><?php else: ?>
                 
                 <div class="container-fluid px-0">
                    <!-- ROW 1 -->
                    <div class="row g-3 justify-content-center mb-5">
                        <div class="col-12 col-md-4 order-2 order-md-1 pt-md-4"><?= renderAdminCard('PEMBINA', $struct_fkkmbt['PEMBINA'] ?? []) ?></div>
                        <div class="col-12 col-md-4 order-1 order-md-2 position-relative line-down"><?= renderAdminCard('KETUA', $struct_fkkmbt['KETUA'] ?? []) ?></div>
                        <div class="col-12 col-md-4 order-3 order-md-3 pt-md-4"><?= renderAdminCard('PENASEHAT', $struct_fkkmbt['PENASEHAT'] ?? []) ?></div>
                    </div>
                    <!-- ROW 2 -->
                     <div class="row g-3 justify-content-center mb-5 position-relative line-horizontal">
                        <div class="col-12 col-md-4 order-2 order-md-1 position-relative line-up"><?= renderAdminCard('BENDAHARA I', $struct_fkkmbt['BENDAHARA I'] ?? []) ?></div>
                        <div class="col-12 col-md-4 order-1 order-md-2 position-relative line-center-connector line-down"><?= renderAdminCard('WAKIL KETUA', $struct_fkkmbt['WAKIL KETUA'] ?? []) ?></div>
                        <div class="col-12 col-md-4 order-3 order-md-3 position-relative line-up"><?= renderAdminCard('SEKRETARIS I', $struct_fkkmbt['SEKRETARIS I'] ?? []) ?></div>
                    </div>
                    <!-- ROW 3 -->
                    <div class="row g-3 justify-content-center mb-4">
                        <div class="col-12 col-md-4 position-relative line-up"><?= renderAdminCard('BENDAHARA II', $struct_fkkmbt['BENDAHARA II'] ?? []) ?></div>
                        <div class="col-md-4 d-none d-md-block position-relative">
                             <div class="spacer-dashed"></div>
                        </div>
                        <div class="col-12 col-md-4 position-relative line-up"><?= renderAdminCard('SEKRETARIS II', $struct_fkkmbt['SEKRETARIS II'] ?? []) ?></div>
                    </div>

                    <!-- SEKSI -->
                    <h6 class="text-center text-muted fw-bold mb-3 mt-4">— BIDANG & SEKSI —</h6>
                    <div class="row g-3">
                    <?php 
                        foreach($struct_fkkmbt as $jabatan => $members) {
                            if(strpos($jabatan, 'SEKSI') === 0) {
                                echo '<div class="col-12 col-md-4">'.renderAdminCard($jabatan, $members).'</div>';
                            }
                        }
                    ?>
                    </div>
                 </div>
                 <?php endif; ?>
            </div>
        </div>

        <!-- BAGAN FKKMMBT -->
        <div class="card border-0 shadow-sm rounded-4 mb-5">
            <div class="card-header bg-white border-bottom-0 pt-3 text-center">
                <span class="section-badge bg-warning text-dark shadow-sm"><i class="bi bi-lightning-fill me-2"></i> FKKMMBT</span>
                 <a href="print_struktur.php?tipe=fkkmmbt" target="_blank" class="btn btn-sm btn-outline-warning text-dark rounded-pill ms-2"><i class="bi bi-printer"></i> Cetak</a>
            </div>
            <div class="card-body bg-light bg-opacity-10 p-4">
               <?php if(empty($struct_fkkmmbt)): ?><p class="text-muted small text-center">Belum ada data.</p><?php else: ?>
                    <div class="row g-3 justify-content-center">
                    <?php foreach($struct_fkkmmbt as $jabatan => $members): ?>
                        <div class="col-12 col-md-4"><?= renderAdminCard($jabatan, $members, 'warning') ?></div>
                    <?php endforeach; ?>
                    </div>
               <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Modal Add Pengurus -->
    <div class="modal fade" id="addPengurusModal" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" method="POST" enctype="multipart/form-data">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Tambah Pengurus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="add_struktur">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Organisasi</label>
                        <select name="tipe_organisasi" class="form-select form-select-sm" required>
                            <option value="fkkmbt">FKKMBT</option>
                            <option value="fkkmmbt">FKKMMBT</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Level</label>
                        <select name="level" class="form-select form-select-sm" required>
                            <option value="1">Ketua (Level 1)</option>
                            <option value="2">Wakil/Sekretaris (Level 2)</option>
                            <option value="3">Anggota/Seksi (Level 3)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control form-control-sm" required>
                    </div>
                    <!-- Gender Field -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select form-select-sm" required>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Jabatan</label>
                        <input type="text" name="jabatan" class="form-control form-control-sm" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Kontak WA</label>
                        <input type="text" name="kontak" class="form-control form-control-sm">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Foto</label>
                        <input type="file" name="foto" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-primary btn-sm px-4 rounded-pill">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Pengurus -->
    <div class="modal fade" id="editPengurusModal" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" method="POST" enctype="multipart/form-data">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Edit Data Pengurus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="edit_struktur">
                    <input type="hidden" name="id" id="edit_id">
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Level</label>
                        <select name="level" id="edit_level" class="form-select form-select-sm" required>
                            <option value="1">Ketua (Level 1)</option>
                            <option value="2">Wakil/Sekretaris (Level 2)</option>
                            <option value="3">Anggota/Seksi (Level 3)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Lengkap</label>
                        <input type="text" name="nama" id="edit_nama" class="form-control form-control-sm" required>
                    </div>
                    <!-- Gender Field -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="edit_jk" class="form-select form-select-sm" required>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Jabatan</label>
                        <input type="text" name="jabatan" id="edit_jabatan" class="form-control form-control-sm" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Kontak WA</label>
                        <input type="text" name="kontak" id="edit_kontak" class="form-control form-control-sm">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Ganti Foto (Opsional)</label>
                        <input type="file" name="foto" class="form-control form-control-sm">
                        <small class="text-muted d-block mt-1">*Kosongkan jika tidak ingin mengubah foto</small>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-warning text-white btn-sm px-4 rounded-pill">Update Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openEditModal(data) {
            document.getElementById('edit_id').value = data.id;
            document.getElementById('edit_nama').value = data.nama;
            document.getElementById('edit_jabatan').value = data.jabatan;
            document.getElementById('edit_level').value = data.level;
            document.getElementById('edit_kontak').value = data.kontak || '';
            // Handle Gender Display (if column not exists, default to L)
            document.getElementById('edit_jk').value = data.jenis_kelamin || 'L';
            
            new bootstrap.Modal(document.getElementById('editPengurusModal')).show();
        }
    </script>
</body>
</html>
