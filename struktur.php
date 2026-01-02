<?php
session_start();
require_once 'config/database.php';

// Helper function to group by Jabatan with CUSTOM SORT
function getGroupedStruct($conn, $type) {
    $sql = "SELECT * FROM struktur_organisasi WHERE UPPER(tipe_organisasi) = UPPER('$type')";
    $res = $conn->query($sql);
    
    $grouped = [];
    while($row = $res->fetch_assoc()) {
        $jabatan = strtoupper(trim($row['jabatan']));
        $grouped[$jabatan][] = $row;
    }

    $sortOrder = [
        'KETUA UMUM' => 0, // FKKMMBT Top
        'WAKIL KETUA UMUM' => 1, // FKKMMBT
        'PEMBINA' => 2, 'KETUA' => 3, 'PENASEHAT' => 4, 
        'WAKIL KETUA' => 5, // Shared/Both
        'SEKRETARIS I' => 6, 'SEKRETARIS II' => 7,
        'BENDAHARA I' => 8, 'BENDAHARA II' => 9,
        'SEKSI KESEJAHTERAAN' => 20, 'SEKSI PENGEMBANGAN EKONOMI' => 21, 'SEKSI HUMAS, PUBLIKASI DAN KOMUNIKASI' => 22,
        'SEKSI KEPEMUDAAN DAN OLAHRAGA' => 23, 'SEKSI PERENCANAAN LINGKUNGAN' => 24, 'SEKSI SENI DAN BUDAYA' => 25,
        'SEKSI KEROHANIAN' => 26, 'SEKSI KEAMANAN' => 27, 'SEKSI PERLENGKAPAN' => 28, 'SEKSI KEWANITAAN' => 29,
        'DIVISI KEPEMUDAAN' => 30, 'DIVISI KREATIF' => 31, 'DIVISI HUMAS' => 32, 
        'DIVISI OLAHRAGA' => 33, 'DIVISI TEKNOLOGI' => 34, 'DIVISI SOSIAL' => 35,
        'DIVISI KEAMANAN' => 36, 'DIVISI KEWANITAAN' => 37
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struktur Organisasi - FKKMBT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .org-box {
            background: white; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden;
            height: 100%; transition: all 0.2s; position: relative; z-index: 1;
        }
        .org-box:hover { box-shadow: 0 10px 20px rgba(0,0,0,0.05); transform: translateY(-3px); border-color: #cbd5e1; }
        .org-header {
            padding: 12px; border-bottom: 1px solid #e2e8f0; text-align: center; 
            font-weight: 700; font-size: 0.85rem; text-transform: uppercase;
        }
        .org-body { padding: 15px; }
        .person-item {
            display: flex; align-items: center; gap: 10px; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px dashed #f1f5f9;
        }
        .person-item:last-child { margin-bottom: 0; padding-bottom: 0; border-bottom: none; }
        .person-name { font-weight: 600; font-size: 0.9rem; color: #1e293b; line-height: 1.2; }
        .person-wa { margin-left: auto; }
        .section-badge { display: inline-block; padding: 8px 24px; border-radius: 50px; font-weight: bold; font-size: 1rem; }

        /* CONNECTOR LINES CSS */
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
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top navbar-dark" style="background: linear-gradient(135deg, #2d6a5f 0%, #1f5449 100%);">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-3" href="index.php">
                <img src="assets/images/LOGO/LOGOFKKMBT.jpg" alt="FKKMBT Logo" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover; cursor: pointer; transition: transform 0.3s;" data-bs-toggle="modal" data-bs-target="#logoModal" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                <span class="fw-bold fs-4 text-white">FKKMBT</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    <li class="nav-item"><a class="nav-link text-white" href="index.php">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="tentang.php">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="kegiatan.php">Kegiatan</a></li>
                    <li class="nav-item"><a class="nav-link text-white active fw-bold" href="struktur.php">Struktur</a></li>
                    <li class="nav-item">
                        <a class="btn btn-outline-light rounded-pill px-4" href="login.php">Masuk</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="pt-5 mt-5">
        <div class="container py-5">
            <div class="text-center mb-4">
                <h2 class="fw-bold mb-3">Struktur Organisasi</h2>
                <p class="text-muted">Mengenal lebih dekat para pengurus FKKMBT dan FKKMMBT</p>
            </div>

            <!-- Tabs -->
            <div class="d-flex justify-content-center gap-3 mb-5">
                <a href="#fkkmbt" class="btn rounded-pill px-4 py-2 fw-bold btn-success shadow" onclick="showTab('fkkmbt'); return false;">FKKMBT</a>
                <a href="#fkkmmbt" class="btn rounded-pill px-4 py-2 fw-bold btn-white border" onclick="showTab('fkkmmbt'); return false;">FKKMMBT</a>
            </div>

            <?php 
            // Helper Render Card
            function render_card($data, $members, $color='success') {
                if(empty($members)) return '<div class="h-100"></div>'; 
                
                $html = '<div class="org-box border-'.$color.'">';
                $html .= '<div class="org-header text-'.$color.' bg-'.$color.' bg-opacity-10">'.$data.'</div>';
                $html .= '<div class="org-body">';
                
                $total = count($members);
                foreach($members as $idx => $m) {
                    $html .= '<div class="person-item">';
                    
                    // Conditional numbering
                    if($total > 1) {
                         $html .= '<div class="bg-light rounded-circle d-flex align-items-center justify-content-center text-secondary fw-bold shadow-sm" style="width: 32px; height: 32px; font-size: 0.8rem; min-width:32px;">'.($idx+1).'</div>';
                    } else {
                         $html .= '<div class="bg-light rounded-circle d-flex align-items-center justify-content-center text-secondary shadow-sm" style="width: 32px; height: 32px; font-size: 1rem; min-width:32px;"><i class="bi bi-person-fill"></i></div>';
                    }

                    $html .= '<div class="person-name">'.$m['nama'].'</div>';
                    
                    if(!empty($m['kontak'])) {
                         $html .= '<a href="https://wa.me/'.$m['kontak'].'" target="_blank" class="person-wa btn btn-sm btn-light rounded-circle text-success"><i class="bi bi-whatsapp"></i></a>';
                    }
                    $html .= '</div>';
                }
                $html .= '</div></div>';
                return $html;
            }
            ?>

            <!-- FKKMBT Tab Content -->
            <div id="tab-fkkmbt" class="tab-content">
                <?php if(empty($struct_fkkmbt)): ?>
                    <p class="text-muted text-center">Belum ada data.</p>
                <?php else: ?>
                <div class="container-fluid px-0">
                    <!-- ROW 1 -->
                    <div class="row g-3 justify-content-center mb-5">
                        <div class="col-12 col-md-4 order-2 order-md-1 pt-md-4"><?= render_card('PEMBINA', $struct_fkkmbt['PEMBINA'] ?? []) ?></div>
                        <div class="col-12 col-md-4 order-1 order-md-2 position-relative line-down"><?= render_card('KETUA', $struct_fkkmbt['KETUA'] ?? []) ?></div>
                        <div class="col-12 col-md-4 order-3 order-md-3 pt-md-4"><?= render_card('PENASEHAT', $struct_fkkmbt['PENASEHAT'] ?? []) ?></div>
                    </div>
                    <!-- ROW 2 -->
                     <div class="row g-3 justify-content-center mb-5 position-relative line-horizontal">
                        <div class="col-12 col-md-4 order-2 order-md-1 position-relative line-up"><?= render_card('BENDAHARA I', $struct_fkkmbt['BENDAHARA I'] ?? []) ?></div>
                        <div class="col-12 col-md-4 order-1 order-md-2 position-relative line-center-connector line-down"><?= render_card('WAKIL KETUA', $struct_fkkmbt['WAKIL KETUA'] ?? []) ?></div>
                        <div class="col-12 col-md-4 order-3 order-md-3 position-relative line-up"><?= render_card('SEKRETARIS I', $struct_fkkmbt['SEKRETARIS I'] ?? []) ?></div>
                    </div>
                    <!-- ROW 3 -->
                    <div class="row g-3 justify-content-center mb-4">
                        <div class="col-12 col-md-4 position-relative line-up"><?= render_card('BENDAHARA II', $struct_fkkmbt['BENDAHARA II'] ?? []) ?></div>
                        <div class="col-md-4 d-none d-md-block position-relative">
                             <div class="spacer-dashed"></div>
                        </div>
                        <div class="col-12 col-md-4 position-relative line-up"><?= render_card('SEKRETARIS II', $struct_fkkmbt['SEKRETARIS II'] ?? []) ?></div>
                    </div>

                    <!-- SEKSI -->
                    <h6 class="text-center text-muted fw-bold mb-3 mt-4">— BIDANG & SEKSI —</h6>
                    <div class="row g-3">
                    <?php 
                        foreach($struct_fkkmbt as $jabatan => $members) {
                            if(strpos($jabatan, 'SEKSI') === 0) {
                                echo '<div class="col-12 col-md-4">'.render_card($jabatan, $members).'</div>';
                            }
                        }
                    ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- FKKMMBT Tab Content -->
            <div id="tab-fkkmmbt" class="tab-content" style="display:none;">
                <?php if(empty($struct_fkkmmbt)): ?>
                    <p class="text-muted text-center">Belum ada data.</p>
                <?php else: ?>
                    <div class="container-fluid px-0">
                        <!-- LEVEL 1: KETUA UMUM -->
                        <div class="row g-3 justify-content-center mb-5">
                            <div class="col-12 col-md-4 position-relative line-down">
                                <?= render_card('KETUA UMUM', $struct_fkkmmbt['KETUA UMUM'] ?? [], 'warning') ?>
                            </div>
                        </div>

                        <!-- LEVEL 2: WAKIL KETUA UMUM -->
                        <div class="row g-3 justify-content-center mb-5">
                            <div class="col-12 col-md-4 position-relative line-up line-down">
                                <?= render_card('WAKIL KETUA UMUM', $struct_fkkmmbt['WAKIL KETUA UMUM'] ?? [], 'warning') ?>
                            </div>
                        </div>

                        <!-- LEVEL 3: SEK & BEN -->
                        <div class="row g-3 justify-content-center mb-5 position-relative line-horizontal pt-4">
                            <!-- Helper line center connector to connect to parent -->
                            <div class="position-absolute top-0 start-50 translate-middle-x" style="height: 40px; border-left: 4px solid var(--line-color); margin-top: -40px; z-index:0;"></div>
                            
                            <div class="col-12 col-md-3 position-relative line-up">
                                <?= render_card('SEKRETARIS I', $struct_fkkmmbt['SEKRETARIS I'] ?? [], 'warning') ?>
                            </div>
                            <div class="col-12 col-md-3 position-relative line-up">
                                <?= render_card('SEKRETARIS II', $struct_fkkmmbt['SEKRETARIS II'] ?? [], 'warning') ?>
                            </div>
                             <div class="col-12 col-md-3 position-relative line-up">
                                <?= render_card('BENDAHARA I', $struct_fkkmmbt['BENDAHARA I'] ?? [], 'warning') ?>
                            </div>
                            <div class="col-12 col-md-3 position-relative line-up">
                                <?= render_card('BENDAHARA II', $struct_fkkmmbt['BENDAHARA II'] ?? [], 'warning') ?>
                            </div>
                        </div>

                        <!-- LEVEL 4: DIVISI -->
                         <div class="position-relative pt-4"> <!-- Wrapper for Divisi lines -->
                             <!-- Center line down from Row 3 to Divisi Header -->
                             <div class="position-absolute top-0 start-50 translate-middle-x" style="height: 40px; border-left: 4px dashed var(--line-color); margin-top: -24px; opacity:0.5;"></div>
                             
                             <h6 class="text-center text-muted fw-bold mb-3 mt-2">— DIVISI —</h6>
                             <div class="row g-3">
                            <?php 
                                foreach($struct_fkkmmbt as $jabatan => $members) {
                                    if(strpos($jabatan, 'DIVISI') === 0) {
                                        echo '<div class="col-12 col-md-4">'.render_card($jabatan, $members, 'warning').'</div>';
                                    }
                                }
                            ?>
                            </div>
                         </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="footer-logo">
                        <div class="logo-circle">F</div>
                        <div class="brand-text">
                            <strong>FKKMBT</strong>
                            <small>Bukit Tiara</small>
                        </div>
                    </div>
                    <p class="text-white-50">Forum Komunikasi Koordinasi Masyarakat Bukit Tiara - Membangun komunitas yang harmonis, sejahtera, dan saling mendukung.</p>
                </div>
                
                <div class="col-md-2">
                    <h6>Menu Cepat</h6>
                    <a href="tentang.php">Tentang Kami</a>
                    <a href="kegiatan.php">Kegiatan</a>
                    <a href="struktur.php">Organisasi</a>
                </div>
                
                <div class="col-md-3">
                    <h6>Organisasi</h6>
                    <a href="struktur.php?tab=fkkmbt">Struktur FKKMBT</a>
                    <a href="struktur.php?tab=fkkmmbt">Struktur FKKMMBT</a>
                </div>
                
                <div class="col-md-3">
                    <h6>Kontak</h6>
                    <p class="text-white-50 mb-2">
                        <i class="bi bi-geo-alt me-2"></i>
                        Perumahan Bukit Tiara, Kecamatan Cikupa, Kabupaten Tangerang, Banten 15710
                    </p>
                    <p class="text-white-50 mb-2">
                        <i class="bi bi-telephone me-2"></i>
                        087786720942
                    </p>
                </div>
            </div>
            
            <hr class="my-4">
            
            <div class="text-center text-white-50">
                <p class="mb-0">&copy; 2024 FKKMBT Bukit Tiara. Developed by Aceva Pr.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showTab(tab) {
            document.querySelectorAll('.tab-content').forEach(el => el.style.display = 'none');
            document.getElementById('tab-' + tab).style.display = 'block';
            
            // Update button states
            const btns = document.querySelectorAll('.btn.rounded-pill');
            btns.forEach(btn => {
                if(btn.getAttribute('href') === '#' + tab) {
                    btn.classList.remove('btn-white', 'border');
                    btn.classList.add('btn-success', 'shadow');
                } else {
                    btn.classList.remove('btn-success', 'shadow');
                    btn.classList.add('btn-white', 'border');
                }
            });
        }
    </script>
</body>
</html>
