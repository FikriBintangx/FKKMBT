<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - FKKMBT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
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

    <!-- Navbar Replacement -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background: linear-gradient(135deg, #2d6a5f 0%, #1f5449 100%);">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-3" href="<?= base_url('admin/dashboard') ?>">
                <span class="fw-bold fs-4">FKKMBT Admin</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navAdmin">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navAdmin">
                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    <li class="nav-item"><a class="nav-link active" href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('admin/warga') ?>">Warga</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('admin/keuangan') ?>">Keuangan</a></li>
                    <li class="nav-item">
                        <a class="btn btn-outline-light btn-sm" href="<?= base_url('auth/logout') ?>">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-4" style="margin-top: 60px;">
        
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
                        <a href="<?= base_url('admin/iuran') ?>" class="text-decoration-none">
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
                        <a href="<?= base_url('admin/kegiatan') ?>" class="text-decoration-none">
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
                        <a href="<?= base_url('admin/organisasi') ?>" class="btn btn-sm btn-success rounded-pill px-3"><i class="bi bi-plus-lg me-1"></i> Edit</a>
                    </div>
                    <div class="card-body widget-scroll pt-0">
                        <?php foreach($pengurus as $p): ?>
                        <div class="list-item-clean">
                            <?php if($p['foto']): ?>
                                <img src="<?= base_url('assets/images/pengurus/'.$p['foto']) ?>" class="avatar-small object-fit-cover">
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
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN: Verifikasi & History -->
            <div class="col-lg-4">
                
                <!-- Pending List -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold m-0">Perlu Verifikasi (<?= $count_pending ?>)</h6>
                        <a href="<?= base_url('admin/iuran') ?>" class="btn btn-sm btn-outline-primary rounded-pill">Lihat</a>
                    </div>
                    <div class="card-body pt-0">
                        <?php if(!empty($pending_list)): ?>
                            <?php foreach($pending_list as $row): ?>
                            <div class="d-flex align-items-center gap-3 py-2 border-bottom">
                                <div class="avatar-small bg-light text-muted"><i class="bi bi-hourglass-split"></i></div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <h6 class="m-0 small fw-bold text-truncate"><?= $row['nama_iuran'] ?></h6>
                                    <small class="text-muted"><?= $row['nama_lengkap'] ?></small>
                                </div>
                                <span class="text-warning small fw-bold">Rp <?= number_format($row['nominal']/1000) ?>k</span>
                            </div>
                            <?php endforeach; ?>
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
                        <?php foreach($history as $h): ?>
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
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

        </div> <!-- End Row -->

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
