<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

// Helper function to group by Jabatan with CUSTOM SORT
function getGroupedStruct($conn, $type) {
    // 1. Fetch Data
    $sql = "SELECT * FROM struktur_organisasi WHERE UPPER(tipe_organisasi) = UPPER('$type')";
    $res = $conn->query($sql);
    
    $grouped = [];
    while($row = $res->fetch_assoc()) {
        $jabatan = strtoupper(trim($row['jabatan'])); // Normalize key
        $grouped[$jabatan][] = $row;
    }

    // 2. Define Custom Sort Order (Sesuai Gambar Dokumen: Kiri-Kanan, Atas-Bawah)
    $sortOrder = [
        'KETUA UMUM' => 0, // FKKMMBT Priority
        'PEMBINA' => 1,
        'KETUA' => 2,
        'PENASEHAT' => 3,
        'WAKIL KETUA' => 4, // Shared
        'BENDAHARA I' => 5,
        'SEKRETARIS I' => 6,
        'BENDAHARA II' => 7,
        'SEKRETARIS II' => 8,
        
        // Seksi-seksi
        'SEKSI KESEJAHTERAAN' => 20,
        'SEKSI PENGEMBANGAN EKONOMI' => 21,
        'SEKSI HUMAS, PUBLIKASI DAN KOMUNIKASI' => 22,
        'SEKSI KEPEMUDAAN DAN OLAHRAGA' => 23,
        'SEKSI PERENCANAAN LINGKUNGAN' => 24,
        'SEKSI SENI DAN BUDAYA' => 25,
        'SEKSI KEROHANIAN' => 26,
        'SEKSI KEAMANAN' => 27,
        'SEKSI PERLENGKAPAN' => 28,
        'SEKSI KEWANITAAN' => 29,

        // Divisi FKKMMBT
        'DIVISI KEPEMUDAAN' => 30,
        'DIVISI KREATIF' => 31, 
        'DIVISI HUMAS' => 32
    ];

    // 3. Sort Array keys based on $sortOrder
    uksort($grouped, function($key1, $key2) use ($sortOrder) {
        // Ambil prioritas (default 999 jika tidak ada di list)
        $p1 = $sortOrder[$key1] ?? 999;
        $p2 = $sortOrder[$key2] ?? 999;
        
        if ($p1 == $p2) return 0;
        return ($p1 < $p2) ? -1 : 1;
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
    <title>Struktur Organisasi - Portal Warga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .org-box {
            background: white; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden;
            height: 100%; transition: all 0.2s;
        }
        .org-box:hover { box-shadow: 0 10px 20px rgba(0,0,0,0.05); transform: translateY(-3px); border-color: #cbd5e1; }
        
        .org-header {
            background: #f8fafc; padding: 12px; border-bottom: 1px solid #e2e8f0;
            text-align: center; font-weight: 700; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;
            color: #334155; min-height: 50px; display: flex; align-items: center; justify-content: center;
        }
        
        .org-body { padding: 15px; }
        
        .person-item {
            display: flex; align-items: center; gap: 12px; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px dashed #f1f5f9;
        }
        .person-item:last-child { margin-bottom: 0; padding-bottom: 0; border-bottom: none; }
        
        .person-avatar {
            width: 40px; height: 40px; border-radius: 50%; object-fit: cover; 
            border: 2px solid #e2e8f0; flex-shrink: 0;
        }
        .person-avatar-placeholder {
            width: 40px; height: 40px; border-radius: 50%; 
            background: linear-gradient(135deg, #134e4a 0%, #0f3730 100%);
            display: flex; align-items: center; justify-content: center;
            color: white; font-weight: 600; font-size: 0.9rem;
            flex-shrink: 0;
        }
        
        .person-name { font-weight: 600; font-size: 0.95rem; color: #1e293b; }
        .person-wa { margin-left: auto; color: #22c55e; }
        
        .section-badge { display: inline-block; padding: 8px 24px; border-radius: 50px; font-weight: bold; font-size: 1rem; }
    </style>
</head>
<body class="bg-light">

    <?php include 'navbar.php'; ?>

    <div class="container py-5 mt-5">
        <div class="text-center mb-4 fade-in">
            <h2 class="fw-bold display-6 mb-2">Struktur Organisasi</h2>
            <p class="text-muted">Susunan pengurus FKKMBT dan FKKMMBT</p>
        </div>

        <?php if(!empty($struct_fkkmbt)): 
            // Helper untuk render card
            function render_card($data, $members, $color='success') {
                if(empty($members)) return '<div class="h-100"></div>'; 
                
                $html = '<div class="org-box w-100 border-'.$color.' position-relative z-1">'; // z-1 agar di atas garis
                $html .= '<div class="org-header text-'.$color.' bg-'.$color.' bg-opacity-10">'.$data.'</div>';
                $html .= '<div class="org-body">';
                
                $total = count($members);
                foreach($members as $idx => $m) {
                    $html .= '<div class="person-item">';
                    
                    // LOGIKA FOTO / NOMOR
                    if(!empty($m['foto']) && file_exists('../assets/images/pengurus/'.$m['foto'])) {
                         $html .= '<img src="../assets/images/pengurus/'.$m['foto'].'" class="rounded-circle border shadow-sm" style="width: 32px; height: 32px; object-fit: cover; min-width:32px;">';
                    } else {
                        // LOGIKA NOMOR: Jika Cuma 1 orang, GANTI jadi Icon. Jika banyak, pakai Nomor.
                        if($total > 1) {
                             $html .= '<div class="bg-light rounded-circle d-flex align-items-center justify-content-center text-secondary fw-bold shadow-sm" style="width: 32px; height: 32px; font-size: 0.8rem; min-width:32px;">'.($idx+1).'</div>';
                        } else {
                             $html .= '<div class="bg-light rounded-circle d-flex align-items-center justify-content-center text-secondary shadow-sm" style="width: 32px; height: 32px; font-size: 1rem; min-width:32px;"><i class="bi bi-person-fill"></i></div>';
                        }
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
        <style>
            /* CONNECTOR LINES CSS - UPDATED TEBAL & NYAMBUNG */
            :root {
                --line-color: #94a3b8; /* Lebih gelap biar tegas */
                --line-width: 4px;     /* Tebal 4px */
                --line-reach: 40px;    /* Panjang 40px biar nyambung table-to-table */
            }

            /* Garis Vertikal Turun */
            .line-down::after {
                content: ''; position: absolute; width: var(--line-width); height: var(--line-reach); background: var(--line-color);
                left: 50%; bottom: calc(var(--line-reach) * -1); transform: translateX(-50%); z-index: 0;
            }
             /* Garis Vertikal Naik */
            .line-up::before {
                content: ''; position: absolute; width: var(--line-width); height: var(--line-reach); background: var(--line-color);
                left: 50%; top: calc(var(--line-reach) * -1); transform: translateX(-50%); z-index: 0;
            }
            /* Garis Horizontal Penghubung 3 Kotak */
            .line-horizontal {
                position: relative;
            }
            .line-horizontal::before {
                content: ''; position: absolute; height: var(--line-width); background: var(--line-color);
                top: calc(var(--line-reach) * -1); left: 16%; right: 16%; z-index: 0;
            }
            /* Connect center line to horizontal bar */
            .line-center-connector::after {
                content: ''; position: absolute; width: var(--line-width); height: var(--line-reach); background: var(--line-color);
                left: 50%; top: calc(var(--line-reach) * -1); transform: translateX(-50%); z-index: 0;
            }

            /* Spacer Dashed Line (Updated) */
            .spacer-dashed {
                position:absolute; left:50%; top:-40px; height:120px; 
                border-left: 4px dashed var(--line-color); opacity: 0.5;
            }

            /* Responsive: HIDE garis di Mobile */
            @media (max-width: 768px) {
                .line-down::after, .line-up::before, .line-horizontal::before, .line-center-connector::after, .spacer-dashed { display: none; }
            }
        </style>

        <div class="mb-5 fade-in-up">
            <div class="text-center mb-4">
                 <span class="section-badge bg-success text-white shadow-sm">
                    <i class="bi bi-people-fill me-2"></i> FKKMBT
                </span>
            </div>
            
            <div class="container-fluid px-0">
                <!-- ROW 1: PEMBINA | KETUA | PENASEHAT -->
                <div class="row g-3 justify-content-center mb-5">
                    <div class="col-12 col-md-4 order-2 order-md-1 pt-md-4"> <!-- Turun dikit biar sejajar visual -->
                        <?= render_card('PEMBINA', $struct_fkkmbt['PEMBINA'] ?? []) ?>
                    </div>
                    <!-- KETUA punya Garis Turun (line-down) -->
                    <div class="col-12 col-md-4 order-1 order-md-2 position-relative line-down">
                         <?= render_card('KETUA', $struct_fkkmbt['KETUA'] ?? []) ?>
                    </div>
                    <div class="col-12 col-md-4 order-3 order-md-3 pt-md-4">
                         <?= render_card('PENASEHAT', $struct_fkkmbt['PENASEHAT'] ?? []) ?>
                    </div>
                </div>

                 <!-- ROW 2: BENDAHARA I | WAKIL KETUA | SEKRETARIS I -->
                 <!-- Baris ini punya Garis Horizontal di atasnya yang menghubungkan ketiganya -->
                 <div class="row g-3 justify-content-center mb-5 position-relative line-horizontal">
                    <div class="col-12 col-md-4 order-2 order-md-1 position-relative line-up">
                        <?= render_card('BENDAHARA I', $struct_fkkmbt['BENDAHARA I'] ?? []) ?>
                    </div>
                    <!-- WAKIL KETUA connect ke Garis Horizontal di atasnya & Garis Turun ke bawah -->
                    <div class="col-12 col-md-4 order-1 order-md-2 position-relative line-center-connector line-down">
                         <?= render_card('WAKIL KETUA', $struct_fkkmbt['WAKIL KETUA'] ?? []) ?>
                    </div>
                    <div class="col-12 col-md-4 order-3 order-md-3 position-relative line-up">
                         <?= render_card('SEKRETARIS I', $struct_fkkmbt['SEKRETARIS I'] ?? []) ?>
                    </div>
                </div>

                <!-- ROW 3: BENDAHARA II | (SPACER) | SEKRETARIS II -->
                <div class="row g-3 justify-content-center mb-4">
                    <div class="col-12 col-md-4 position-relative line-up"> <!-- line-up connect ke Bendahara 1 -->
                        <?= render_card('BENDAHARA II', $struct_fkkmbt['BENDAHARA II'] ?? []) ?>
                    </div>
                    <!-- Spacer dengan garis turun dari Wakil Ketua -->
                    <div class="col-md-4 d-none d-md-block position-relative">
                         <!-- Garis putus-putus ke bawah -->
                         <div class="spacer-dashed"></div>
                    </div>
                    <div class="col-12 col-md-4 position-relative line-up">
                         <?= render_card('SEKRETARIS II', $struct_fkkmbt['SEKRETARIS II'] ?? []) ?>
                    </div>
                </div>

                <!-- SEKSI-SEKSI (GRID 3 Column) -->
                <h5 class="text-center text-muted fw-bold mb-3 mt-4">— BIDANG & SEKSI —</h5>
                <div class="row g-3">
                    <?php 
                    // Filter hanya yang depannya "SEKSI"
                    foreach($struct_fkkmbt as $jabatan => $members) {
                        if(strpos($jabatan, 'SEKSI') === 0) {
                            echo '<div class="col-12 col-md-4">';
                            echo render_card($jabatan, $members);
                            echo '</div>';
                        }
                    }
                    ?>
                </div>

            </div>
        </div>
        <?php endif; ?>

        <!-- FKKMMBT (Pemuda) - Generic Grid for simplicity or same structure if needed -->
        <?php if(!empty($struct_fkkmmbt)): ?>
        <div class="mb-5 fade-in-up">
             <div class="text-center mb-4">
                 <span class="section-badge bg-warning text-dark shadow-sm">
                    <i class="bi bi-lightning-charge-fill me-2"></i> FKKMMBT 
                </span>
            </div>
            
            <div class="container-fluid px-0">
                 <!-- LEVEL 1: KETUA UMUM -->
                 <div class="row g-3 justify-content-center mb-5">
                     <div class="col-12 col-md-4 position-relative line-down">
                         <?= render_card('KETUA UMUM', $struct_fkkmmbt['KETUA UMUM'] ?? [], 'warning') ?>
                     </div>
                 </div>

                 <!-- LEVEL 2: WAKIL KETUA -->
                 <div class="row g-3 justify-content-center mb-5">
                     <div class="col-12 col-md-4 position-relative line-up line-down">
                         <?= render_card('WAKIL KETUA', $struct_fkkmmbt['WAKIL KETUA'] ?? [], 'warning') ?>
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
                      <div class="row g-3 justify-content-center">
                     <?php 
                         foreach($struct_fkkmmbt as $jabatan => $members) {
                             if(!in_array($jabatan, ['KETUA UMUM', 'WAKIL KETUA', 'SEKRETARIS I', 'SEKRETARIS II', 'BENDAHARA I', 'BENDAHARA II'])) {
                                 echo '<div class="col-12 col-md-4">'.render_card($jabatan, $members, 'warning').'</div>';
                             }
                         }
                     ?>
                     </div>
                  </div>
            </div>
        </div>
        <?php endif; ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
