<?php
session_start();
require_once '../config/database.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'warga') { header("Location: ../login.php"); exit; }
$warga = $conn->query("SELECT * FROM warga WHERE user_id = ".$_SESSION['user_id'])->fetch_assoc();

// Fetch Data Activities
$kegiatan = $conn->query("SELECT k.*, o.nama_organisasi FROM kegiatan k JOIN organisasi o ON k.organisasi_id = o.id ORDER BY k.tanggal DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kegiatan - FKKMBT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .activity-img {
            height: 250px;
            object-fit: cover;
            width: 100%;
        }
        .carousel-control-prev, .carousel-control-next {
            width: 10%;
            background: rgba(0,0,0,0.2);
        }
        .carousel-control-prev:hover, .carousel-control-next:hover {
            background: rgba(0,0,0,0.5);
        }
    </style>
</head>
<body class="bg-light">

    <!-- Navbar -->
    <?php include 'navbar.php'; ?>

    <div class="main-content container py-4 mt-5 pt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold">Kegiatan & Agenda Warga</h2>
                <p class="text-muted">Temukan informasi kegiatan terkini dan jadwal gotong royong.</p>
            </div>
            <!-- Search & Filter (Visual Only) -->
            <div class="d-flex gap-2">
                <input type="text" class="form-control" placeholder="Cari kegiatan...">
                <button class="btn btn-primary px-4">Cari</button>
            </div>
        </div>

        <!-- CALENDAR SECTION -->
        <div class="card mb-5 border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white border-0 py-4 px-4 d-flex justify-content-between align-items-center">
                <h4 class="fw-bold mb-0 text-dark"><i class="bi bi-calendar-event me-2 text-primary"></i>Agenda <?= date('F Y') ?></h4>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3"><i class="bi bi-circle-fill small me-1"></i> Ada Kegiatan</span>
                    <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3">Hari Ini</span>
                </div>
            </div>
            <div class="card-body p-0">
                <?php
                // 1. Prepare Data for Calendar & List
                $all_activities = [];
                while($row = $kegiatan->fetch_assoc()) {
                    $all_activities[] = $row;
                }
                
                // Map dates to activities
                $activity_dates = [];
                foreach($all_activities as $act) {
                    $d = date('Y-m-d', strtotime($act['tanggal']));
                    $activity_dates[$d][] = $act;
                }

                // 2. Calendar Logic
                $month = date('m');
                $year = date('Y');
                $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                $firstDay = date('N', strtotime("$year-$month-01")); // 1 (Mon) - 7 (Sun)
                ?>

                <div class="table-responsive">
                    <table class="table table-bordered text-center m-0 align-middle" style="table-layout: fixed;">
                        <thead class="bg-light">
                            <tr>
                                <th class="py-3 text-secondary text-uppercase small ls-1">Sen</th>
                                <th class="py-3 text-secondary text-uppercase small ls-1">Sel</th>
                                <th class="py-3 text-secondary text-uppercase small ls-1">Rab</th>
                                <th class="py-3 text-secondary text-uppercase small ls-1">Kam</th>
                                <th class="py-3 text-secondary text-uppercase small ls-1">Jum</th>
                                <th class="py-3 text-secondary text-uppercase small ls-1 text-danger">Sab</th>
                                <th class="py-3 text-secondary text-uppercase small ls-1 text-danger">Min</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                $dayCount = 1;
                                $offset = 0;
                                
                                // Empty cells before first day
                                for ($i = 1; $i < $firstDay; $i++) {
                                    echo "<td class='bg-light'></td>";
                                    $offset++;
                                }

                                // Days
                                while ($dayCount <= $daysInMonth) {
                                    $currentDate = sprintf('%04d-%02d-%02d', $year, $month, $dayCount);
                                    $isToday = ($currentDate == date('Y-m-d'));
                                    $hasEvent = isset($activity_dates[$currentDate]);
                                    
                                    // Cell Class
                                    $cellClass = $isToday ? 'bg-primary-subtle text-primary fw-bold' : '';
                                    if ($hasEvent) $cellClass .= ' cursor-pointer position-relative';
                                    
                                    echo "<td class='p-0 $cellClass' style='height: 100px; vertical-align: top;'>";
                                    echo "<div class='d-flex justify-content-between p-2'>";
                                    echo "<span class='" . ($isToday ? "bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" : "") . "' style='width:30px; height:30px;'>$dayCount</span>";
                                    echo "</div>";

                                    // Event Indicator
                                    if ($hasEvent) {
                                        foreach($activity_dates[$currentDate] as $ev) {
                                            $shortTitle = strlen($ev['judul']) > 15 ? substr($ev['judul'], 0, 15) . '...' : $ev['judul'];
                                            echo "<div class='mx-1 mb-1 p-1 rounded bg-primary text-white small text-start lh-1' style='font-size: 10px;' title='".$ev['judul']."'>";
                                            echo $shortTitle;
                                            echo "</div>";
                                        }
                                    }

                                    echo "</td>";

                                    $offset++;
                                    $dayCount++;

                                    // New Row
                                    if ($offset % 7 == 0) echo "</tr><tr>";
                                }

                                // Fill remaining cells
                                while ($offset % 7 != 0) {
                                    echo "<td class='bg-light'></td>";
                                    $offset++;
                                }
                                ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- LIST ACTIVITIES -->
        <h4 class="fw-bold mb-4 ps-2 border-start border-4 border-primary">Semua Kegiatan</h4>
        <div class="row g-4">
            <?php foreach($all_activities as $row): ?>
                <?php
                // Fetch Media for this specific activity
                $media_q = $conn->query("SELECT * FROM kegiatan_galeri WHERE kegiatan_id = ".$row['id']);
                $media = [];
                while($m = $media_q->fetch_assoc()) $media[] = $m;
                $carouselId = "carouselAct" . $row['id'];
                ?>
            <div class="col-md-6 col-lg-4">
                <div class="card card-clean border-0 shadow-sm h-100 activity-card position-relative overflow-hidden">
                    <div class="activity-img-wrapper">
                        <span class="badge-category text-primary position-absolute top-0 start-0 m-3 bg-white shadow-sm p-2 rounded-3 z-3 fw-bold" style="font-size: 10px;"><?= strtoupper($row['nama_organisasi']) ?></span>
                        
                        <?php if(count($media) > 1): ?>
                            <!-- CAROUSEL -->
                            <div id="<?= $carouselId ?>" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <?php foreach($media as $idx => $item): ?>
                                    <div class="carousel-item <?= $idx == 0 ? 'active' : '' ?>">
                                        <?php if($item['tipe_file'] == 'video'): ?>
                                            <video src="../assets/images/kegiatan/<?= $item['file'] ?>" class="activity-img bg-dark" controls></video>
                                        <?php else: ?>
                                            <img src="../assets/images/kegiatan/<?= $item['file'] ?>" class="activity-img d-block w-100" alt="Dokumentasi">
                                        <?php endif; ?>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#<?= $carouselId ?>" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#<?= $carouselId ?>" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                </button>
                            </div>

                        <?php elseif(count($media) == 1): ?>
                            <!-- SINGLE IMAGE/VIDEO -->
                            <?php $item = $media[0]; ?>
                            <?php if($item['tipe_file'] == 'video'): ?>
                                <video src="../assets/images/kegiatan/<?= $item['file'] ?>" class="activity-img bg-dark" controls></video>
                            <?php else: ?>
                                <img src="../assets/images/kegiatan/<?= $item['file'] ?>" class="activity-img" alt="Dokumentasi">
                            <?php endif; ?>

                        <?php else: ?>
                            <!-- PLACEHOLDER IF NO IMAGE -->
                            <img src="https://source.unsplash.com/400x300/?event,community" class="activity-img grayscale">
                        <?php endif; ?>
                    </div>

                    <div class="card-body p-4">
                        <small class="text-muted d-block mb-2"><i class="bi bi-calendar me-2"></i><?= date('d M Y', strtotime($row['tanggal'])) ?></small>
                        <h5 class="fw-bold mb-3"><?= $row['judul'] ?></h5>
                        <p class="text-muted small mb-4"><?= substr($row['deskripsi'], 0, 80) ?>...</p>
                        <button class="btn btn-link text-decoration-none p-0 fw-bold" onclick="showDetail(this)" 
                            data-title="<?= $row['judul'] ?>"
                            data-desc="<?= $row['deskripsi'] ?>"
                            data-date="<?= date('d M Y', strtotime($row['tanggal'])) ?>"
                            data-org="<?= $row['nama_organisasi'] ?>"
                            data-media='<?= json_encode($media) ?>'
                        >Lihat Detail <i class="bi bi-arrow-right ms-1"></i></button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content overflow-hidden rounded-4">
                <div class="modal-body p-0">
                    <div class="row g-0">
                        <!-- Media Section in Modal (Also Carousel) -->
                        <div class="col-md-7 bg-dark d-flex align-items-center justify-content-center" style="min-height: 400px;" id="modalMediaContainer">
                            <!-- JS will inject content here -->
                        </div>
                        
                        <div class="col-md-5 p-5 d-flex flex-column bg-white">
                             <div class="mb-auto">
                                <span class="badge bg-primary-subtle text-primary mb-3" id="modalOrg">ORGANISASI</span>
                                <h2 class="fw-bold mb-3" id="modalTitle">Judul Kegiatan</h2>
                                <div class="d-flex gap-4 text-muted small mb-4">
                                    <span><i class="bi bi-calendar me-2"></i><span id="modalDate">Date</span></span>
                                    <span><i class="bi bi-clock me-2"></i>08:00 - Selesai</span>
                                </div>
                                <h6 class="fw-bold">Deskripsi Kegiatan</h6>
                                <p class="text-muted" id="modalDesc">Deskripsi...</p>
                             </div>
                             
                             <div class="mt-4 pt-3 border-top">
                                 <button class="btn btn-secondary w-100 rounded-pill" data-bs-dismiss="modal">Tutup</button>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showDetail(btn) {
            const title = btn.getAttribute('data-title');
            const desc = btn.getAttribute('data-desc');
            const date = btn.getAttribute('data-date');
            const org = btn.getAttribute('data-org');
            const media = JSON.parse(btn.getAttribute('data-media'));

            document.getElementById('modalTitle').innerText = title;
            document.getElementById('modalDesc').innerText = desc;
            document.getElementById('modalDate').innerText = date;
            document.getElementById('modalOrg').innerText = org.toUpperCase();

            // Build Modal Carousel
            let mediaHtml = '';
            if(media.length > 0) {
                if(media.length === 1) {
                    if(media[0].tipe_file === 'video') {
                        mediaHtml = `<video src="../assets/images/kegiatan/${media[0].file}" class="w-100 h-100 object-fit-contain" controls></video>`;
                    } else {
                        mediaHtml = `<img src="../assets/images/kegiatan/${media[0].file}" class="w-100 h-100 object-fit-cover">`;
                    }
                } else {
                    mediaHtml = `
                    <div id="carouselModal" class="carousel slide" data-bs-ride="carousel" style="width:100%; height:100%;">
                        <div class="carousel-inner h-100">
                            ${media.map((m, i) => `
                            <div class="carousel-item h-100 ${i === 0 ? 'active' : ''}">
                                ${m.tipe_file === 'video' 
                                    ? `<video src="../assets/images/kegiatan/${m.file}" class="d-block w-100 h-100 object-fit-contain" controls></video>` 
                                    : `<img src="../assets/images/kegiatan/${m.file}" class="d-block w-100 h-100 object-fit-cover">`}
                            </div>
                            `).join('')}
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselModal" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselModal" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </button>
                    </div>`;
                }
            } else {
                mediaHtml = `<img src="https://source.unsplash.com/800x600/?community" class="w-100 h-100 object-fit-cover">`;
            }

            document.getElementById('modalMediaContainer').innerHTML = mediaHtml;
            new bootstrap.Modal(document.getElementById('detailModal')).show();
        }
    </script>
</body>
</html>
