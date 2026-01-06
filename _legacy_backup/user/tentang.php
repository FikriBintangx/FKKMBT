<?php
session_start();
require_once '../config/database.php';
// Auth Check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'warga') { header("Location: ../login.php"); exit; }
$warga = $conn->query("SELECT * FROM warga WHERE user_id = ".$_SESSION['user_id'])->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tentang FKKMBT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .hero-banner {
            height: 350px;
            background: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.6)), url('../assets/images/hero_tentang.png');
            background-size: cover;
            background-position: center;
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            margin-bottom: 3rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
<div class="dashboard-container">
    <!-- Sidebar -->
    <!-- Navbar -->
    <?php include 'navbar.php'; ?>

    <!-- Main Content -->
    <div class="main-content container py-4">
        <!-- Hero Section (Image 2 Top) -->
        <div class="hero-banner">
            <div>
                <h1 class="display-4 fw-bold">Mengenal Lebih Dekat FKKMBT</h1>
                <p class="lead opacity-75 mx-auto" style="max-width: 600px;">Forum Komunikasi Keluarga Besar Taman adalah wadah persaudaraan untuk menciptakan lingkungan yang harmonis, aman, dan nyaman.</p>
            </div>
        </div>

        <!-- Content Section (Image 2 Bottom) -->
        <div class="card-clean border-0 shadow-none bg-transparent">
            <div class="row align-items-center g-5">
                <div class="col-md-6">
                    <img src="https://source.unsplash.com/800x600/?meeting,office" class="img-fluid rounded-4 shadow-sm" alt="Tentang Kami">
                </div>
                <div class="col-md-6">
                    <h6 class="text-primary fw-bold text-uppercase mb-2">Siapa Kami?</h6>
                    <h2 class="fw-bold mb-4">Membangun Sinergi Warga Bukit Tiara</h2>
                    <p class="text-muted mb-4">
                        FKKMBT didirikan atas dasar kebutuhan akan komunikasi yang efektif antar warga perumahan.
                        Kami percaya bahwa tetangga adalah saudara terdekat. Oleh karena itu, kerukunan dan kepedulian sosial menjadi fondasi utama organisasi ini.
                    </p>
                    <p class="text-muted mb-4">
                        Sebagai organisasi nirlaba yang dikelola secara swadaya oleh warga, kami berfokus pada:
                    </p>
                    <ul class="list-unstyled mb-4 text-muted">
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> Pengelolaan Keamanan Terpadu</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> Kegiatan Sosial & Keagamaan</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> Transparansi Pengelolaan Iuran</li>
                    </ul>
                    <a href="struktur.php" class="btn btn-outline-primary rounded-pill px-4">Lihat Struktur Organisasi <i class="bi bi-arrow-right ms-2"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
