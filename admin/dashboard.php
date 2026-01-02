<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// --- AUTO-MIGRATE ADMIN NOTES TABLE ---
$conn->query("CREATE TABLE IF NOT EXISTS admin_notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tanggal DATE UNIQUE,
    catatan TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)");

// --- HANDLE NOTE SAVE ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_note'])) {
    $date = $_POST['note_date'];
    $content = $conn->real_escape_string($_POST['note_content']);
    
    if (!empty($date)) {
        // UPSERT (Insert or Update)
        $sql = "INSERT INTO admin_notes (tanggal, catatan) VALUES ('$date', '$content') 
                ON DUPLICATE KEY UPDATE catatan = '$content'";
        $conn->query($sql);
        // Redirect to avoid resubmit
        header("Location: dashboard.php");
        exit;
    }
}

// --- FETCH NOTES FOR CALENDAR ---
$admin_notes = [];
$notes_q = $conn->query("SELECT * FROM admin_notes"); // Fetch all for simplicity or filter by month if needed
if ($notes_q) {
    while ($n = $notes_q->fetch_assoc()) {
        $admin_notes[$n['tanggal']] = $n['catatan'];
    }
}

// 1. STATS DATA (Existing)
$count_pending = $conn->query("SELECT COUNT(*) as total FROM pembayaran_iuran WHERE status='pending'")->fetch_assoc()['total'];
$count_agenda = $conn->query("SELECT COUNT(*) as total FROM kegiatan WHERE tanggal >= CURDATE()")->fetch_assoc()['total'];

// 2. CHART DATA (Pemasukan 6 Bulan Terakhir)
$chart_query = $conn->query("
    SELECT DATE_FORMAT(p.tgl_bayar, '%M') as bulan, SUM(m.nominal) as total 
    FROM pembayaran_iuran p 
    JOIN iuran_master m ON p.iuran_id = m.id 
    WHERE p.status='disetujui' 
    GROUP BY YEAR(p.tgl_bayar), MONTH(p.tgl_bayar) 
    ORDER BY p.tgl_bayar DESC LIMIT 6
");
$chart_labels = [];
$chart_values = [];
while($c = $chart_query->fetch_assoc()) {
    array_unshift($chart_labels, substr($c['bulan'], 0, 3)); // Jan, Feb
    array_unshift($chart_values, $c['total']);
}

// 3. PENGURUS INTI (Gabungan FKKMBT & FKKMMBT)
$pengurus = $conn->query("SELECT * FROM struktur_organisasi WHERE level IN (1, 2) ORDER BY level ASC LIMIT 5");

// 4. MENUNGGU VERIFIKASI (Limit 3)
$pending_list = $conn->query("
    SELECT p.*, w.nama_lengkap, m.nama_iuran, m.nominal 
    FROM pembayaran_iuran p 
    JOIN warga w ON p.warga_id = w.id 
    JOIN iuran_master m ON p.iuran_id = m.id 
    WHERE p.status = 'pending' 
    ORDER BY p.tgl_bayar DESC LIMIT 4
");

// 5. RIWAYAT TERAKHIR
$history = $conn->query("
    SELECT p.*, w.nama_lengkap, m.nama_iuran 
    FROM pembayaran_iuran p 
    JOIN warga w ON p.warga_id = w.id 
    JOIN iuran_master m ON p.iuran_id = m.id 
    WHERE p.status != 'pending' 
    ORDER BY p.tgl_bayar DESC LIMIT 4
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - FKKMBT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .card-stat-small {
            border-radius: 16px;
            padding: 20px;
            color: white;
            transition: transform 0.2s;
            height: 100%;
        }
        .card-stat-small:hover { transform: translateY(-5px); }
        .bg-yellow-gradient { background: linear-gradient(135deg, #fcd34d 0%, #f59e0b 100%); }
        .bg-blue-gradient { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); }
        
        .list-item-clean {
            display: flex; align-items: center; gap: 15px;
            padding: 12px 0; border-bottom: 1px solid #f1f5f9;
        }
        .list-item-clean:last-child { border-bottom: none; }
        .avatar-small {
            width: 40px; height: 40px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: bold; font-size: 14px;
        }
        .chart-container { position: relative; height: 200px; width: 100%; }
        
        /* Custom Scrollbar for widgets */
        .widget-scroll { overflow-y: auto; max-height: 350px; }
        .widget-scroll::-webkit-scrollbar { width: 4px; }
        .widget-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
    </style>
</head>
<body class="bg-light">

    <!-- Top Navbar -->
    <?php include 'navbar.php'; ?>

    <div class="container py-4">
        
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold m-0">Dashboard Overview</h3>
                <p class="text-muted m-0">Ringkasan aktivitas dan keuangan perumahan.</p>
            </div>
            <div class="d-flex gap-2">
                <div class="bg-white rounded-pill px-3 py-2 border d-flex align-items-center gap-2 shadow-sm">
                    <i class="bi bi-search text-muted"></i>
                    <input type="text" class="border-0 small" placeholder="Cari data..." style="outline:none;">
                </div>
            </div>
        </div>

        <div class="row g-4">
            
            <!-- KOLOM KIRI: Stats & Chart -->
            <div class="col-lg-4">
                <div class="row g-3 mb-4">
                    <div class="col-6">
                        <a href="iuran.php" class="text-decoration-none">
                            <div class="card-stat-small bg-yellow-gradient shadow-sm">
                                <small class="text-white-50 fw-bold">Menunggu Verifikasi</small>
                                <div class="d-flex justify-content-between align-items-end mt-2">
                                    <h2 class="m-0 fw-bold"><?= $count_pending ?></h2>
                                    <div class="bg-white bg-opacity-25 rounded-circle p-2 d-flex">
                                        <i class="bi bi-check2-square text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="kegiatan.php" class="text-decoration-none">
                            <div class="card-stat-small bg-blue-gradient shadow-sm">
                                <small class="text-white-50 fw-bold">Agenda Aktif</small>
                                <div class="d-flex justify-content-between align-items-end mt-2">
                                    <h2 class="m-0 fw-bold"><?= $count_agenda ?></h2>
                                    <div class="bg-white bg-opacity-25 rounded-circle p-2 d-flex">
                                        <i class="bi bi-calendar-event text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- CHART -->
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                        <h6 class="fw-bold m-0">Tren Kas Masuk</h6>
                        <small class="text-muted">Grafik pemasukan iuran bulanan</small>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KOLOM TENGAH: Pengurus Inti -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold m-0">Pengurus Inti</h6>
                        <a href="organisasi.php" class="btn btn-sm btn-success rounded-pill px-3"><i class="bi bi-plus-lg me-1"></i> Edit</a>
                    </div>
                    <div class="card-body widget-scroll pt-0">
                        <?php while($p = $pengurus->fetch_assoc()): ?>
                        <div class="list-item-clean">
                            <?php if($p['foto']): ?>
                                <img src="../assets/images/pengurus/<?= $p['foto'] ?>" class="avatar-small object-fit-cover">
                            <?php else: ?>
                                <div class="avatar-small bg-<?= $p['tipe_organisasi'] == 'fkkmbt' ? 'success' : 'warning' ?> text-white">
                                    <?= substr($p['nama'],0,1) ?>
                                </div>
                            <?php endif; ?>
                            <div class="flex-grow-1">
                                <h6 class="m-0 small fw-bold text-dark"><?= $p['nama'] ?></h6>
                                <small class="text-muted d-block" style="font-size: 11px;"><?= $p['jabatan'] ?></small>
                            </div>
                            <?php if(!empty($p['kontak'])): ?>
                                <a href="https://wa.me/<?= $p['kontak'] ?>" target="_blank" class="text-success small me-2"><i class="bi bi-whatsapp"></i></a>
                            <?php endif; ?>
                            <?php if($p['tipe_organisasi'] == 'fkkmbt'): ?>
                                <span class="badge bg-success-subtle text-success rounded-pill" style="font-size:10px;">FKKMBT</span>
                            <?php else: ?>
                                <span class="badge bg-warning-subtle text-dark rounded-pill" style="font-size:10px;">PEMUDA</span>
                            <?php endif; ?>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN: Verifikasi & History -->
            <div class="col-lg-4">
                
                <!-- Pending List -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold m-0">Perlu Verifikasi (<?= $count_pending ?>)</h6>
                        <a href="iuran.php" class="btn btn-sm btn-outline-primary rounded-pill">Lihat</a>
                    </div>
                    <div class="card-body pt-0">
                        <?php if($pending_list->num_rows > 0): ?>
                            <?php while($row = $pending_list->fetch_assoc()): ?>
                            <div class="d-flex align-items-center gap-3 py-2 border-bottom">
                                <div class="avatar-small bg-light text-muted"><i class="bi bi-hourglass-split"></i></div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <h6 class="m-0 small fw-bold text-truncate"><?= $row['nama_iuran'] ?></h6>
                                    <small class="text-muted"><?= $row['nama_lengkap'] ?></small>
                                </div>
                                <span class="text-warning small fw-bold">Rp <?= number_format($row['nominal']/1000) ?>k</span>
                            </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <div class="text-center py-3 text-muted small">Tidak ada pending..</div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- History -->
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                        <h6 class="fw-bold m-0">Riwayat Terakhir</h6>
                    </div>
                    <div class="card-body pt-0">
                        <?php while($h = $history->fetch_assoc()): ?>
                        <div class="d-flex align-items-start gap-3 py-2 border-bottom">
                            <div class="mt-1">
                                <?php if($h['status'] == 'disetujui'): ?>
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                <?php else: ?>
                                    <i class="bi bi-x-circle-fill text-danger"></i>
                                <?php endif; ?>
                            </div>
                            <div>
                                <h6 class="m-0 small fw-bold text-dark"><?= $h['nama_lengkap'] ?></h6>
                                <small class="text-muted d-block lh-sm" style="font-size: 11px;"><?= $h['nama_iuran'] ?> &bull; <?= date('d/m', strtotime($h['tgl_bayar'])) ?></small>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>

        </div> <!-- End Row -->

        <!-- ADMIN CALENDAR SECTION -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white border-0 py-4 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0"><i class="bi bi-calendar-check me-2 text-primary"></i>Agenda & Rencana Admin <?= date('F Y') ?></h5>
                        <small class="text-muted"><i class="bi bi-info-circle me-1"></i> Klik tanggal untuk tambah/edit catatan</small>
                    </div>
                    <div class="card-body p-0">
                        <?php
                        $month = date('m');
                        $year = date('Y');
                        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                        $firstDay = date('N', strtotime("$year-$month-01"));
                        ?>
                        <div class="table-responsive">
                            <table class="table table-bordered text-center m-0 align-middle table-hover" style="table-layout: fixed;">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="py-3 text-secondary small">SEN</th>
                                        <th class="py-3 text-secondary small">SEL</th>
                                        <th class="py-3 text-secondary small">RAB</th>
                                        <th class="py-3 text-secondary small">KAM</th>
                                        <th class="py-3 text-secondary small">JUM</th>
                                        <th class="py-3 text-danger small">SAB</th>
                                        <th class="py-3 text-danger small">MIN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php
                                        $dayCount = 1;
                                        $offset = 0;
                                        for ($i = 1; $i < $firstDay; $i++) { echo "<td class='bg-light'></td>"; $offset++; }
                                        
                                        while ($dayCount <= $daysInMonth) {
                                            $currDate = sprintf('%04d-%02d-%02d', $year, $month, $dayCount);
                                            $isToday = ($currDate == date('Y-m-d'));
                                            $note = isset($admin_notes[$currDate]) ? $admin_notes[$currDate] : '';
                                            $hasNote = !empty($note);
                                            
                                            $bgClass = $isToday ? 'bg-primary-subtle' : ($hasNote ? 'bg-warning-subtle' : '');
                                            
                                            echo "<td class='$bgClass cursor-pointer position-relative p-0' style='height: 100px; vertical-align: top;' onclick='openNoteModal(\"$currDate\", `".htmlspecialchars($note, ENT_QUOTES)."`)'>";
                                            echo "<div class='d-flex justify-content-between p-2'>";
                                            echo "<span class='" . ($isToday ? "bg-primary text-white rounded-circle shadow-sm" : "text-muted") . " d-flex align-items-center justify-content-center fw-bold' style='width:28px; height:28px; font-size:12px;'>$dayCount</span>";
                                            if ($hasNote) echo "<i class='bi bi-sticky-fill text-warning fs-5'></i>";
                                            echo "</div>";
                                            
                                            if ($hasNote) {
                                                echo "<div class='mx-2 mb-1 p-1 rounded bg-white border small text-start text-dark shadow-sm' style='font-size: 11px; max-height: 50px; overflow: hidden;'>";
                                                echo nl2br(substr($note, 0, 50)) . (strlen($note)>50 ? '...' : '');
                                                echo "</div>";
                                            }
                                            
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
            </div>
        </div>

        <!-- NOTE MODAL -->
        <div class="modal fade" id="noteModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4 border-0 shadow">
                    <form method="POST">
                        <div class="modal-header border-bottom-0 pb-0">
                            <h5 class="modal-title fw-bold">Catatan / Rencana</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="note_date" id="modalNoteDate">
                            <p class="text-muted small mb-2">Tanggal: <span id="displayDate" class="fw-bold text-dark"></span></p>
                            <div class="mb-3">
                                <textarea name="note_content" id="modalNoteContent" class="form-control bg-light border-0" rows="5" placeholder="Tulis rencana kegiatan atau catatan admin di sini..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer border-top-0 pt-0">
                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" name="save_note" class="btn btn-primary rounded-pill px-4">Simpan Note</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
        function openNoteModal(dateStr, content) {
            document.getElementById('modalNoteDate').value = dateStr;
            // Format Date for Display
            const dateObj = new Date(dateStr);
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('displayDate').innerText = dateObj.toLocaleDateString('id-ID', options);
            
            document.getElementById('modalNoteContent').value = content;
            new bootstrap.Modal(document.getElementById('noteModal')).show();
        }
        </script>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Init ChartJS
        const ctx = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?= json_encode($chart_labels) ?>,
                datasets: [{
                    label: 'Pemasukan (Rp)',
                    data: <?= json_encode($chart_values) ?>,
                    borderColor: '#16a34a',
                    backgroundColor: 'rgba(22, 163, 74, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [5, 5] },
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value/1000 + 'k';
                            }
                        }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    </script>
</body>
</html>
