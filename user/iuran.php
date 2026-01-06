<?php
session_start();
require_once '../config/database.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'warga') { header("Location: ../login.php"); exit; }
$user_id = $_SESSION['user_id'];
$warga = $conn->query("SELECT * FROM warga WHERE user_id = $user_id")->fetch_assoc();
$warga_id = $warga['id'];

// Data
$tagihan_aktif = $conn->query("SELECT * FROM iuran_master WHERE id NOT IN (SELECT iuran_id FROM pembayaran_iuran WHERE warga_id = $warga_id AND (status='pending' OR status='disetujui')) AND status='aktif' LIMIT 1")->fetch_assoc();
$history = $conn->query("SELECT p.*, m.nama_iuran, m.nominal FROM pembayaran_iuran p JOIN iuran_master m ON p.iuran_id = m.id WHERE p.warga_id = $warga_id ORDER BY p.tgl_bayar DESC");
$total_dibayar = $conn->query("SELECT SUM(im.nominal) as total FROM pembayaran_iuran p JOIN iuran_master im ON p.iuran_id = im.id WHERE p.warga_id = $warga_id AND p.status='disetujui'")->fetch_assoc()['total'];

// Handle Upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['bukti'])) {
    $iuran_id = $_POST['iuran_id'];
    $target_dir = "../assets/images/bukti_iuran/";
    $filename = time() . "_" . basename($_FILES["bukti"]["name"]);
    if (move_uploaded_file($_FILES["bukti"]["tmp_name"], $target_dir . $filename)) {
        $stmt = $conn->prepare("INSERT INTO pembayaran_iuran (warga_id, iuran_id, bukti_transfer, status) VALUES (?, ?, ?, 'pending')");
        $stmt->bind_param("iis", $warga_id, $iuran_id, $filename);
        $stmt->execute();
        header("Location: iuran.php?success=1"); exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Iuran Warga - FKKMBT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="dashboard-container">
    <!-- Navbar -->
    <?php include 'navbar.php'; ?>

    <div class="main-content container py-4">
        <!-- Tabs for View Switching (Simulating 2 different pages/views in one) -->
        <ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
            <li class="nav-item"><button class="nav-link active fw-bold" id="pills-pay-tab" data-bs-toggle="pill" data-bs-target="#pills-pay">Pembayaran Iuran</button></li>
            <li class="nav-item"><button class="nav-link fw-bold" id="pills-history-tab" data-bs-toggle="pill" data-bs-target="#pills-history">Riwayat Pembayaran</button></li>
        </ul>

        <div class="tab-content" id="pills-tabContent">
            <!-- Tab 1: Pembayaran -->
            <div class="tab-pane fade show active" id="pills-pay">
                <?php 
                // Check if current active bill is already paid/pending
                $status_curr = null;
                if ($tagihan_aktif) {
                    $check_status = $conn->query("SELECT status FROM pembayaran_iuran WHERE warga_id = $warga_id AND iuran_id = ".$tagihan_aktif['id']);
                    if ($check_status->num_rows > 0) {
                        $status_curr = $check_status->fetch_assoc()['status'];
                    }
                }
                ?>

                <div class="row g-4">
                    <!-- LEFT COLUMN: Invoice & Upload -->
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4">
                                <h4 class="fw-bold mb-4">Pembayaran Iuran Bulanan</h4>

                                <?php if($tagihan_aktif): ?>
                                    
                                    <!-- ALERT STATUS -->
                                    <?php if($status_curr == 'pending'): ?>
                                        <div class="text-center py-5 border rounded-4 bg-warning-subtle text-warning-emphasis mb-4">
                                            <i class="bi bi-hourglass-split display-1 mb-3 text-warning"></i>
                                            <h4 class="fw-bold">Pembayaran Sedang Diverifikasi</h4>
                                            <p class="mb-0">Admin sedang mengecek bukti transfer Anda. Mohon tunggu 1x24 jam.</p>
                                        </div>
                                    <?php elseif($status_curr == 'disetujui'): ?>
                                        <div class="text-center py-5 border rounded-4 bg-success-subtle text-success-emphasis mb-4">
                                            <i class="bi bi-check-circle-fill display-1 mb-3 text-success"></i>
                                            <h4 class="fw-bold">LUNAS</h4>
                                            <p class="mb-0">Terima kasih, pembayaran untuk bulan ini telah diterima.</p>
                                        </div>
                                    <?php else: ?>
                                        <!-- UNPAID / REJECTED case -->
                                        <?php if($status_curr == 'ditolak'): ?>
                                            <div class="alert alert-danger rounded-3 mb-4 d-flex align-items-center">
                                                <i class="bi bi-x-circle-fill fs-4 me-3"></i>
                                                <div>Pembayaran sebelumnya <strong>DITOLAK</strong>. Silakan upload ulang bukti yang valid.</div>
                                            </div>
                                        <?php endif; ?>

                                        <div class="alert alert-danger mb-4 border-0 bg-danger-subtle text-danger rounded-3 p-3">
                                            <i class="bi bi-exclamation-triangle-fill me-2"></i> Tagihan <strong><?= $tagihan_aktif['nama_iuran'] ?></strong> belum dibayar. Jatuh tempo: <strong><?= date('d M Y', strtotime($tagihan_aktif['jatuh_tempo'])) ?></strong>
                                        </div>

                                        <!-- Invoice Details -->
                                        <div class="bg-light p-4 rounded-4 mb-4">
                                            <h6 class="fw-bold mb-3 border-bottom pb-2">Rincian Tagihan</h6>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span class="text-muted">Tagihan Bulan Ini</span>
                                                <span class="fw-bold badge bg-primary"><?= $tagihan_aktif['nama_iuran'] ?></span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span class="text-muted">Iuran Kebersihan</span>
                                                <span class="fw-bold">Rp <?= number_format($tagihan_aktif['nominal'] * 0.4) ?></span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span class="text-muted">Iuran Keamanan (Satpam)</span>
                                                <span class="fw-bold">Rp <?= number_format($tagihan_aktif['nominal'] * 0.6) ?></span>
                                            </div>
                                            <hr class="my-2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-bold text-dark">Total Tagihan</span>
                                                <span class="fw-bold fs-4 text-primary">Rp <?= number_format($tagihan_aktif['nominal']) ?></span>
                                            </div>
                                        </div>

                                        <!-- Upload Form -->
                                        <h5 class="fw-bold mb-3"><i class="bi bi-upload me-2"></i>Upload Bukti Transfer</h5>
                                        <form method="POST" enctype="multipart/form-data" class="upload-area p-5 border-2 border-dashed rounded-4 text-center bg-light position-relative">
                                            <input type="hidden" name="iuran_id" value="<?= $tagihan_aktif['id'] ?>">
                                            <input type="file" name="bukti" class="position-absolute top-0 start-0 w-100 h-100 opacity-0 cursor-pointer" required onchange="previewFile(this)">
                                            
                                            <div id="upload-placeholder">
                                                <div class="mb-3">
                                                    <i class="bi bi-cloud-arrow-up-fill text-primary" style="font-size: 3rem;"></i>
                                                </div>
                                                <h6 class="fw-bold text-dark">Klik untuk Pilih Bukti Transfer</h6>
                                                <p class="text-muted small mb-0">Format JPG/PNG, Max 2MB</p>
                                            </div>
                                            <div id="file-preview" class="d-none">
                                                <i class="bi bi-file-earmark-image-fill text-success display-3 mb-2"></i>
                                                <p class="mb-0 fw-bold text-dark" id="filename-display"></p>
                                                <small class="text-primary text-decoration-underline">Klik untuk ganti file</small>
                                            </div>
                                        </form>
                                        
                                        <button onclick="document.querySelector('form.upload-area').submit()" class="btn btn-primary w-100 py-3 rounded-pill fw-bold mt-4 shadow-sm">
                                            <i class="bi bi-send-fill me-2"></i> Kirim Bukti Pembayaran
                                        </button>
                                    <?php endif; ?>

                                <?php else: ?>
                                    <div class="text-center py-5">
                                        <i class="bi bi-check-circle-fill text-success display-1"></i>
                                        <h5 class="text-muted mt-3">Tidak ada tagihan aktif.</h5>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT COLUMN: Rekening Info -->
                    <div class="col-lg-4">
                        <h5 class="fw-bold mb-3">Rekening Tujuan</h5>
                        
                        <!-- ATM CARD 1: BCA -->
                        <div class="card border-0 text-white mb-3 shadow" style="background: linear-gradient(135deg, #00509d 0%, #00296b 100%); border-radius: 15px; position: relative; overflow: hidden; min-height: 200px;">
                            <!-- Decorative Elements -->
                            <div class="position-absolute w-100 h-100" style="background: repeating-linear-gradient(45deg, rgba(255,255,255,0.03) 0px, rgba(255,255,255,0.03) 2px, transparent 2px, transparent 4px); top:0; left:0;"></div>
                            <div class="position-absolute rounded-circle bg-white opacity-10" style="width: 200px; height: 200px; top: -50px; right: -50px; filter: blur(40px);"></div>

                            <div class="card-body p-4 d-flex flex-column justify-content-between position-relative z-1">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fst-italic fw-bold fs-5">BCA</span>
                                    <i class="bi bi-wifi fs-4 opacity-75" style="transform: rotate(90deg);"></i>
                                </div>
                                
                                <div class="mt-4 mb-2">
                                    <div class="d-flex align-items-center gap-2 mb-3">
                                        <div class="bg-warning bg-gradient rounded-2 border border-warning-subtle" style="width: 45px; height: 35px; position: relative;">
                                            <div class="position-absolute border border-dark opacity-25 rounded-2" style="top:5px; left:5px; right:5px; bottom:5px;"></div>
                                        </div> <!-- Chip simulation -->
                                        <i class="bi bi-caret-right-fill text-white opacity-50"></i>
                                    </div>
                                    
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h4 class="fw-bold font-monospace mb-0" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.5); letter-spacing: 2px;">1234 5678 90</h4>
                                        <button class="btn btn-sm btn-link text-white p-0 opacity-75 hover-opacity-100" onclick="copyToClipboard('1234567890')">
                                            <i class="bi bi-copy fs-5"></i>
                                        </button>
                                    </div>
                                    <small class="ls-2 opacity-75" style="font-size: 10px;">VALID THRU 12/30</small>
                                </div>

                                <div class="d-flex justify-content-between align-items-end">
                                    <span class="text-uppercase fw-bold" style="letter-spacing: 1px; text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">FKKMBT / PAK RT</span>
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/2560px-Visa_Inc._logo.svg.png" style="height: 20px; filter: brightness(0) invert(1); opacity: 0.8;">
                                </div>
                            </div>
                        </div>

                        <!-- ATM CARD 2: MANDIRI -->
                        <div class="card border-0 text-white mb-4 shadow" style="background: linear-gradient(135deg, #d4af37 0%, #a67c00 100%); border-radius: 15px; position: relative; overflow: hidden; min-height: 200px;">
                            <!-- Decoration -->
                            <div class="position-absolute w-100 h-100" style="top:0; left:0; background: radial-gradient(circle at 100% 0%, rgba(255,255,255,0.2) 0%, transparent 50%);"></div>

                            <div class="card-body p-4 d-flex flex-column justify-content-between position-relative z-1">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold fs-5">MANDIRI</span>
                                    <i class="bi bi-wifi fs-4 opacity-75" style="transform: rotate(90deg);"></i>
                                </div>
                                
                                <div class="mt-4 mb-2">
                                    <div class="d-flex align-items-center gap-2 mb-3">
                                        <div class="bg-light bg-gradient rounded-2 border border-secondary" style="width: 45px; height: 35px;"></div> <!-- Silver Chip -->
                                        <i class="bi bi-caret-right-fill text-white opacity-50"></i>
                                    </div>
                                    
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h4 class="fw-bold font-monospace mb-0" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.3); letter-spacing: 2px;">9876 5432 10</h4>
                                        <button class="btn btn-sm btn-link text-white p-0 opacity-75 hover-opacity-100" onclick="copyToClipboard('9876543210')">
                                            <i class="bi bi-copy fs-5"></i>
                                        </button>
                                    </div>
                                    <small class="ls-2 opacity-75" style="font-size: 10px;">VALID THRU 12/30</small>
                                </div>

                                <div class="d-flex justify-content-between align-items-end">
                                    <span class="text-uppercase fw-bold" style="letter-spacing: 1px; text-shadow: 1px 1px 2px rgba(0,0,0,0.3);">BENDAHARA RW</span>
                                    <div class="d-flex">
                                        <div class="bg-danger rounded-circle opacity-75" style="width: 25px; height: 25px;"></div>
                                        <div class="bg-warning rounded-circle opacity-75" style="width: 25px; height: 25px; margin-left: -10px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Note Section -->
                        <div class="alert alert-warning border-0 shadow-sm rounded-3 d-flex align-items-start gap-3">
                            <i class="bi bi-info-circle-fill fs-4 text-warning-emphasis"></i>
                            <div>
                                <h6 class="fw-bold text-warning-emphasis mb-1">CATATAN PENTING:</h6>
                                <p class="mb-0 small text-dark opacity-75">
                                    Misal 5058535836 ( ITU CONTOH NOREK NYA NANTI W GANTI MANUAL )
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

                <script>
                    function previewFile(input) {
                        const file = input.files[0];
                        if (file) {
                            document.getElementById('upload-placeholder').classList.add('d-none');
                            document.getElementById('file-preview').classList.remove('d-none');
                            document.getElementById('filename-display').textContent = file.name;
                        }
                    }
                    function copyToClipboard(text) {
                        navigator.clipboard.writeText(text);
                        alert('Nomor disalin!');
                    }
                </script>
            </div>

            <!-- Tab 2: Riwayat (Image 5) -->
            <div class="tab-pane fade" id="pills-history">
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="card-clean p-4 border-start border-4 border-success">
                            <span class="text-muted small"><i class="bi bi-check-circle-fill text-success me-2"></i>Total Iuran Dibayar</span>
                            <h3 class="fw-bold mt-2 mb-0">Rp <?= number_format((float)$total_dibayar) ?></h3>
                            <small class="text-muted">Tahun Berjalan 2024</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card-clean p-4 border-start border-4 border-danger">
                             <span class="text-muted small"><i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>Tagihan Belum Lunas</span>
                             <h3 class="fw-bold mt-2 mb-0">Rp <?= $tagihan_aktif ? number_format($tagihan_aktif['nominal']) : '0' ?></h3>
                             <small class="text-muted"><?= $tagihan_aktif ? '1 Tagihan Aktif' : 'Tidak ada tunggakan' ?></small>
                        </div>
                    </div>
                </div>

                <div class="card-clean">
                    <div class="card-clean-header d-flex justify-content-between">
                        <h5 class="fw-bold m-0">Riwayat Pembayaran</h5>
                        <div class="d-flex gap-2">
                             <input type="text" class="form-control form-control-sm" placeholder="Cari ID Transaksi...">
                             <select class="form-select form-select-sm" style="width: auto;"><option>2024</option></select>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-custom mb-0">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Periode Iuran</th>
                                    <th>Nominal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($history->num_rows > 0): ?>
                                    <?php while($row = $history->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= date('d M Y', strtotime($row['tgl_bayar'])) ?></td>
                                        <td>
                                            <span class="fw-bold d-block"><?= $row['nama_iuran'] ?></span>
                                            <small class="text-muted text-xs">ID: #TRX-<?= $row['id'] ?>992</small>
                                        </td>
                                        <td>Rp <?= number_format($row['nominal']) ?></td>
                                        <td>
                                            <?php if($row['status']=='disetujui'): ?>
                                                <span class="badge bg-success-subtle text-success border border-success px-2 py-1 rounded-pill"><i class="bi bi-check-circle me-1"></i>Lunas</span>
                                            <?php elseif($row['status']=='pending'): ?>
                                                <span class="badge bg-warning-subtle text-warning border border-warning px-2 py-1 rounded-pill"><i class="bi bi-hourglass-split me-1"></i>Pending</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger-subtle text-danger border border-danger px-2 py-1 rounded-pill"><i class="bi bi-x-circle me-1"></i>Ditolak</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="../assets/images/bukti_iuran/<?= $row['bukti_transfer'] ?>" target="_blank" class="btn btn-sm btn-outline-primary fw-bold"><i class="bi bi-eye me-1"></i> Bukti</a>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr><td colspan="5" class="text-center py-5 text-muted">Belum ada riwayat pembayaran.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
