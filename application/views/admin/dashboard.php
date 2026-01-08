<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - FKKMBT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #f0fdf4; }
        
        .dashboard-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            padding: 40px 0 80px;
            color: white;
            border-radius: 0 0 40px 40px;
            margin-bottom: -60px;
            position: relative;
            overflow: hidden;
        }

        @media (max-width: 768px) {
            .dashboard-header {
                padding: 30px 0 60px;
                border-radius: 0 0 30px 30px;
                margin-bottom: -40px;
            }
        }

        .dashboard-header::before {
            content: ''; position: absolute; top: -50px; right: -50px; width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0) 70%); border-radius: 50%;
        }

        /* COLORFUL STAT CARDS */
        .stat-card-gradient {
            border-radius: 24px; padding: 24px; color: white; border: none;
            transition: transform 0.3s; position: relative; overflow: hidden;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .stat-card-gradient:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.15); }
        
        .gradient-orange { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
        .gradient-blue { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); }
        .gradient-green { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
        .gradient-purple { background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); }

        .stat-icon-floating {
            position: absolute; right: -10px; bottom: -10px; opacity: 0.2; font-size: 80px; transform: rotate(-15deg);
        }
        
        .card-modern {
            background: white; border-radius: 24px; border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05); overflow: hidden;
        }
        .card-header-modern {
            padding: 24px; border-bottom: 1px dashed #e5e7eb; display: flex; justify-content: space-between; align-items: center;
        }

        .table-vibrant tr td { padding: 16px 24px; vertical-align: middle; border-bottom: 1px solid #f1f5f9; }
        .table-vibrant tr:last-child td { border-bottom: none; }
        
        .avatar-vibrant {
            width: 45px; height: 45px; border-radius: 12px; object-fit: cover;
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: 18px; color: #fff; text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .av-bg-1 { background: linear-gradient(45deg, #ef4444, #f87171); }
        .av-bg-2 { background: linear-gradient(45deg, #f59e0b, #fbbf24); }
        .av-bg-3 { background: linear-gradient(45deg, #10b981, #34d399); }
        .av-bg-4 { background: linear-gradient(45deg, #3b82f6, #60a5fa); }
        
        .badge-pill-soft { padding: 6px 14px; border-radius: 50px; font-weight: 600; font-size: 11px; letter-spacing: 0.5px; }

        /* Sidebar Item */
        .pengurus-item {
            transition: all 0.2s; padding: 12px; border-radius: 16px; border: 1px solid transparent;
        }
        .pengurus-item:hover { background: #f0fdf4; border-color: #bbf7d0; }
        
        /* Quick Actions Grid */
        .quick-btn {
            background: white; border: 1px solid #e5e7eb; border-radius: 16px; padding: 15px;
            display: flex; flex-direction: column; align-items: center; gap: 8px;
            color: #4b5563; text-decoration: none; transition: all 0.2s;
        }
        .quick-btn:hover { background: #ecfdf5; border-color: #10b981; color: #047857; transform: translateY(-2px); }
        .quick-icon {
            width: 40px; height: 40px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; color: white;
        }
    </style>
</head>
<body>

    <!-- Top Navbar -->
    <?php $this->load->view('admin/templates/navbar'); ?>

    <!-- Header Section -->
    <div class="dashboard-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center position-relative" style="z-index: 2;">
                <div>
                    <h1 class="fw-bold mb-1">Dashboard FKKMBT</h1>
                    <p class="opacity-90 m-0 fw-light">Selamat datang kembali, Admin! Semangat mengurus warga 💪</p>
                </div>
                <div class="d-none d-md-block">
                    <span class="bg-white bg-opacity-20 px-4 py-2 rounded-pill fw-bold text-white shadow-sm border border-white border-opacity-25">
                        <i class="bi bi-calendar-event me-2"></i><?= date('d F Y') ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container pb-5">
        
        <!-- Stats Row -->
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <a href="<?= base_url('admin/keuangan') ?>" class="text-decoration-none">
                    <div class="stat-card-gradient gradient-orange">
                        <div class="d-flex justify-content-between">
                            <i class="bi bi-wallet2 fs-2 opacity-75"></i>
                            <?php if($count_pending > 0): ?>
                                <span class="bg-white text-warning rounded-pill px-3 py-1 fw-bold small shadow-sm">
                                    <?= $count_pending ?> Pending
                                </span>
                            <?php else: ?>
                                <i class="bi bi-check-circle-fill opacity-50 fs-5"></i>
                            <?php endif; ?>
                        </div>
                        <h2 class="fw-bold mt-3 mb-0"><?= $count_pending ?></h2>
                        <span class="opacity-75 small fw-medium">Verifikasi Pembayaran</span>
                        <i class="bi bi-coin stat-icon-floating"></i>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?= base_url('admin/kegiatan') ?>" class="text-decoration-none">
                    <div class="stat-card-gradient gradient-blue">
                         <div class="d-flex justify-content-between">
                            <i class="bi bi-calendar-check fs-2 opacity-75"></i>
                            <span class="bg-white bg-opacity-20 rounded-pill px-3 py-1 small">Active</span>
                        </div>
                        <h2 class="fw-bold mt-3 mb-0"><?= $count_agenda ?></h2>
                        <span class="opacity-75 small fw-medium">Agenda Kegiatan</span>
                        <i class="bi bi-calendar-event stat-icon-floating"></i>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?= base_url('admin/warga') ?>" class="text-decoration-none">
                    <div class="stat-card-gradient gradient-green">
                         <div class="d-flex justify-content-between">
                            <i class="bi bi-people fs-2 opacity-75"></i>
                        </div>
                        <h2 class="fw-bold mt-3 mb-0"><?= $total_warga ?? '0' ?></h2> <!-- Total Warga Logic -->
                        <span class="opacity-75 small fw-medium">Total Warga</span>
                        <i class="bi bi-people-fill stat-icon-floating"></i>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                 <a href="<?= base_url('admin/pengaduan') ?>" class="text-decoration-none">
                    <div class="stat-card-gradient gradient-purple">
                         <div class="d-flex justify-content-between">
                            <i class="bi bi-megaphone fs-2 opacity-75"></i>
                             <span class="bg-white bg-opacity-20 rounded-pill px-2 py-1 small"><i class="bi bi-arrow-right"></i></span>
                        </div>
                        <h2 class="fw-bold mt-3 mb-0">-</h2> <!-- Placeholder for Complaints Count -->
                        <span class="opacity-75 small fw-medium">Aduan Masuk</span>
                        <i class="bi bi-chat-heart stat-icon-floating"></i>
                    </div>
                </a>
            </div>
        </div>

        <div class="row g-4">
            
            <!-- Left Column -->
            <div class="col-lg-8">
                
                <!-- Revenue Chart -->
                <div class="card-modern mb-4">
                    <div class="card-header-modern">
                        <div>
                            <h5 class="fw-bold m-0 text-dark"><i class="bi bi-graph-up-arrow me-2 text-success"></i>Tren Pemasukan</h5>
                        </div>
                        <button class="btn btn-sm btn-light border rounded-pill px-3 fw-medium text-secondary hover-bg-light">
                            Lihat Detail
                        </button>
                    </div>
                    <div class="card-body p-4">
                        <div style="height: 320px;">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="card-modern">
                    <div class="card-header-modern">
                        <h5 class="fw-bold m-0 text-dark"><i class="bi bi-clock-history me-2 text-primary"></i>Verifikasi Terakhir</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-vibrant mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 text-secondary small fw-bold">WARGA</th>
                                    <th class="text-secondary small fw-bold">TAGIHAN</th>
                                    <th class="text-secondary small fw-bold">TANGGAL</th>
                                    <th class="text-secondary small fw-bold text-end pe-4">STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($history)): ?>
                                    <?php foreach($history as $index => $h): 
                                        $bg_idx = ($index % 4) + 1; 
                                    ?>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="avatar-vibrant av-bg-<?= $bg_idx ?>">
                                                    <?= substr($h['nama_lengkap'], 0, 1) ?>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark mb-0"><?= $h['nama_lengkap'] ?></div>
                                                    <small class="text-muted">Blok <?= $h['blok'] ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="fw-semibold text-secondary"><?= $h['nama_iuran'] ?></span>
                                        </td>
                                        <td class="text-muted fw-medium">
                                            <?= date('d M', strtotime($h['tgl_bayar'])) ?>
                                        </td>
                                        <td class="text-end pe-4">
                                            <?php if($h['status'] == 'disetujui'): ?>
                                                <span class="badge-pill-soft bg-success bg-opacity-10 text-success">
                                                    <i class="bi bi-check-circle-fill me-1"></i>SUKSES
                                                </span>
                                            <?php else: ?>
                                                <span class="badge-pill-soft bg-danger bg-opacity-10 text-danger">
                                                    <i class="bi bi-x-circle-fill me-1"></i>GAGAL
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="4" class="text-center py-5 text-muted">Belum ada aktivitas terbaru.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!-- Right Column -->
            <div class="col-lg-4">
                
                <!-- Quick Actions -->
                <div class="card-modern mb-4 p-4">
                     <h6 class="fw-bold mb-3 text-secondary text-uppercase small ls-1">Akses Cepat</h6>
                     <div class="row g-2">
                         <div class="col-6">
                             <a href="#" data-bs-toggle="modal" data-bs-target="#addMaster" class="quick-btn">
                                 <div class="quick-icon bg-warning text-white shadow-sm"><i class="bi bi-receipt"></i></div>
                                 <span class="small fw-bold">Buat Tagihan</span>
                             </a>
                         </div>
                         <div class="col-6">
                             <a href="<?= base_url('admin/warga') ?>" class="quick-btn">
                                 <div class="quick-icon bg-success text-white shadow-sm"><i class="bi bi-person-plus-fill"></i></div>
                                 <span class="small fw-bold">Tambah Warga</span>
                             </a>
                         </div>
                         <div class="col-6">
                             <a href="<?= base_url('admin/pengaduan') ?>" class="quick-btn">
                                 <div class="quick-icon bg-danger text-white shadow-sm"><i class="bi bi-exclamation-triangle-fill"></i></div>
                                 <span class="small fw-bold">Cek Aduan</span>
                             </a>
                         </div>
                         <div class="col-6">
                             <a href="<?= base_url('admin/organisasi') ?>" class="quick-btn">
                                 <div class="quick-icon bg-primary text-white shadow-sm"><i class="bi bi-diagram-3-fill"></i></div>
                                 <span class="small fw-bold">Struktur Org</span>
                             </a>
                         </div>
                     </div>
                </div>

                <!-- Pengurus List -->
                <div class="card-modern">
                    <div class="card-header-modern">
                        <h5 class="fw-bold m-0 text-dark">Pengurus Inti</h5>
                        <a href="<?= base_url('admin/organisasi') ?>" class="text-success small fw-bold text-decoration-none">Kelola</a>
                    </div>
                    <div class="card-body p-3">
                        <div class="d-flex flex-column gap-1">
                            <?php foreach($pengurus as $p): ?>
                            <div class="pengurus-item d-flex align-items-center gap-3">
                                <?php if($p['foto']): ?>
                                    <img src="<?= base_url('assets/images/pengurus/'.$p['foto']) ?>" class="rounded-circle border" style="width: 40px; height: 40px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center fw-bold text-secondary" style="width: 40px; height: 40px;">
                                        <?= substr($p['nama'],0,1) ?>
                                    </div>
                                <?php endif; ?>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold text-dark mb-0 small"><?= $p['nama'] ?></h6>
                                    <small class="text-muted d-block" style="font-size: 11px;"><?= $p['jabatan'] ?></small>
                                </div>
                                <span class="badge bg-light text-dark border rounded-pill" style="font-size: 9px;"><?= $p['tipe_organisasi'] == 'fkkmbt' ? 'FKKMBT' : 'PEMUDA' ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- ChartJS Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const ctx = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?= json_encode($chart_labels) ?>,
                datasets: [{
                    label: 'Pemasukan',
                    data: <?= json_encode($chart_values) ?>,
                    borderColor: '#10b981',
                    backgroundColor: (ctx) => {
                        const gradient = ctx.chart.ctx.createLinearGradient(0, 0, 0, 300);
                        gradient.addColorStop(0, 'rgba(16, 185, 129, 0.2)');
                        gradient.addColorStop(1, 'rgba(16, 185, 129, 0)');
                        return gradient;
                    },
                    borderWidth: 3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#10b981',
                    pointBorderWidth: 3,
                    pointRadius: 6,
                    fill: true,
                    tension: 0.4
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
                        grid: { borderDash: [5, 5], color: '#f3f4f6' },
                        ticks: {
                            font: { family: "'Outfit', sans-serif" },
                            callback: function(value) { return 'Rp ' + value/1000 + 'k'; }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: "'Outfit', sans-serif" } }
                    }
                }
            }
        });
    </script>
</body>
</html>
