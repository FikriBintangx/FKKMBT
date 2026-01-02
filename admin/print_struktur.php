<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

$tipe = isset($_GET['tipe']) ? $_GET['tipe'] : 'fkkmbt';
$title = ($tipe == 'fkkmmbt') ? 'STRUKTUR FKKMMBT (PEMUDA)' : 'STRUKTUR FKKMBT (WARGA)';
$bg_color = ($tipe == 'fkkmmbt') ? 'border-warning' : 'border-success';
$text_color = ($tipe == 'fkkmmbt') ? 'text-dark' : 'text-success';

$res = $conn->query("SELECT * FROM struktur_organisasi WHERE tipe_organisasi = '$tipe' ORDER BY level ASC, id ASC");
$tree = [];
while($row = $res->fetch_assoc()) {
    $tree[$row['level']][] = $row;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Struktur - <?= $tipe ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: white; }
        .tree ul {
            padding-top: 20px; position: relative; transition: all 0.5s;
            display: flex; justify-content: center; gap: 20px; padding-left: 0;
        }
        .tree li {
            float: left; text-align: center; list-style-type: none; position: relative; padding: 20px 5px 0 5px;
            transition: all 0.5s;
        }
        .tree li::before, .tree li::after {
            content: ''; position: absolute; top: 0; right: 50%; border-top: 2px solid #ccc; width: 50%; height: 20px;
        }
        .tree li::after { right: auto; left: 50%; border-left: 2px solid #ccc; }
        .tree li:only-child::after, .tree li:only-child::before { display: none; }
        .tree li:only-child { padding-top: 0; }
        .tree li:first-child::before, .tree li:last-child::after { border: 0 none; }
        .tree li:last-child::before { border-right: 2px solid #ccc; border-radius: 0 5px 0 0; -webkit-border-radius: 0 5px 0 0; }
        .tree li:first-child::after { border-radius: 5px 0 0 0; -webkit-border-radius: 5px 0 0 0; }
        .tree ul ul::before {
            content: ''; position: absolute; top: 0; left: 50%; border-left: 2px solid #ccc; width: 0; height: 20px;
        }
        .tree-card {
            background: white; border: 2px solid #ddd; padding: 15px; border-radius: 12px; display: inline-block;
            min-width: 150px; position: relative; z-index: 10;
        }
        .tree-img { width: 60px; height: 60px; border-radius: 50%; object-fit: cover; margin-bottom: 10px; }
        
        .print-btn { position: fixed; top: 20px; right: 20px; z-index: 999; }
        
        @media print {
            .print-btn { display: none !important; }
            @page { size: landscape; margin: 0.5cm; }
            body { margin: 0; padding: 20px; -webkit-print-color-adjust: exact; }
            .tree-card { box-shadow: none !important; border: 1px solid #999 !important; }
        }
    </style>
</head>
<body>

    <button onclick="window.print()" class="btn btn-primary print-btn shadow-lg rounded-pill px-4">
        <i class="bi bi-printer-fill me-2"></i> Cetak Dokumen
    </button>

    <div class="text-center mb-5">
        <h2 class="fw-bold mb-1"><?= $title ?></h2>
        <p class="text-muted mb-0">Dicetak pada: <?= date('d F Y') ?></p>
    </div>

    <div class="d-flex justify-content-center">
        <div class="tree">
            <ul>
                <?php if(isset($tree[1])): foreach($tree[1] as $p1): ?>
                <li>
                    <div class="tree-card <?= $bg_color ?>">
                        <?php if($p1['foto']): ?>
                            <img src="../assets/images/pengurus/<?= $p1['foto'] ?>" class="tree-img">
                        <?php else: ?>
                            <div class="tree-img bg-light text-dark d-flex align-items-center justify-content-center mx-auto border fs-4 fw-bold">
                                <?= substr($p1['nama'],0,1) ?>
                            </div>
                        <?php endif; ?>
                        <div class="fw-bold text-uppercase small <?= $text_color ?>"><?= $p1['jabatan'] ?></div>
                        <div class="fw-bold fs-5 mb-1"><?= $p1['nama'] ?></div>
                        <?php if(!empty($p1['kontak'])): ?><div class="small text-muted"><i class="bi bi-whatsapp"></i> <?= $p1['kontak'] ?></div><?php endif; ?>
                    </div>

                    <?php if(isset($tree[2])): ?>
                    <ul>
                        <?php foreach($tree[2] as $idx2 => $p2): ?>
                        <li>
                            <div class="tree-card">
                                <?php if($p2['foto']): ?>
                                    <img src="../assets/images/pengurus/<?= $p2['foto'] ?>" class="tree-img" style="width:50px;height:50px;">
                                <?php else: ?>
                                    <div class="tree-img bg-light text-dark d-flex align-items-center justify-content-center mx-auto border" style="width:50px;height:50px;"><?= substr($p2['nama'],0,1) ?></div>
                                <?php endif; ?>
                                <div class="fw-bold small text-muted"><?= $p2['jabatan'] ?></div>
                                <div class="fw-bold mb-1"><?= $p2['nama'] ?></div>
                            </div>
                            
                            <?php 
                                $mid_index = floor(count($tree[2]) / 2);
                                if(isset($tree[3]) && $idx2 == $mid_index): 
                            ?>
                            <ul>
                                <?php foreach($tree[3] as $p3): ?>
                                <li>
                                    <div class="tree-card" style="min-width:120px; padding:10px;">
                                        <div class="fw-bold small text-muted" style="font-size:11px;"><?= $p3['jabatan'] ?></div>
                                        <div class="fw-bold small"><?= $p3['nama'] ?></div>
                                    </div>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                            <?php endif; ?>

                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                </li>
                <?php endforeach; endif; ?>
            </ul>
        </div>
    </div>

</body>
</html>
