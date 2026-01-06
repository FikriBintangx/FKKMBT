<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - FKKMBT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f3f4f6; }
        
        .dashboard-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            padding: 40px 0 80px;
            color: white;
            border-radius: 0 0 30px 30px;
            margin-bottom: -50px;
        }

        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 24px;
            transition: all 0.3s ease;
            border: 1px solid rgba(0,0,0,0.03);
            height: 100%;
            position: relative;
            overflow: hidden;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .icon-box {
            width: 48px; height: 48px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 24px;
            margin-bottom: 16px;
        }
        
        .card-custom {
            background: white;
            border-radius: 20px;
            border: none;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }
        .card-header-custom {
            background: transparent;
            border-bottom: 1px solid #f3f4f6;
            padding: 20px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-custom tr td {
            padding: 16px 24px;
            vertical-align: middle;
        }
        
        .avatar-circle {
            width: 40px; height: 40px;
            border-radius: 50%;
            object-fit: cover;
            background: #f3f4f6;
            display: flex; align-items: center; justify-content: center;
            font-weight: bold; color: #6b7280;
        }
        
        .badge-custom {
            padding: 6px 12px;
            border-radius: 50px;
            font-weight: 500;
            font-size: 12px;
        }

        /* Sparkline or Decorative elements */
        .stat-decoration {
            position: absolute;
            right: -20px;
            bottom: -20px;
            opacity: 0.1;
            font-size: 100px;
            transform: rotate(-15deg);
        }
        
        /* Modern Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body>

    <!-- Top Navbar -->
    <?php $this->load->view('admin/templates/navbar'); ?>

    <!-- Header Section -->
    <div class="dashboard-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-1">Dashboard Ikhtisar</h2>
                    <p class="opacity-75 m-0">Halo Admin, berikut adalah ringkasan aktivitas hari ini.</p>
                </div>
                <div class="d-none d-md-block">
                    <span class="bg-white bg-opacity-20 px-3 py-2 rounded-pill small fw-medium text-white">
                        <i class="bi bi-calendar2-week me-2"></i><?= date('d F Y') ?>
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
                <a href="<?= base_url('admin/keuangan') ?>" class="text-decoration-none text-dark">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between">
                            <div class="icon-box bg-warning bg-opacity-10 text-warning">
                                <i class="bi bi-wallet2"></i>
                            </div>
                            <?php if($count_pending > 0): ?>
                                <span class="badge bg-warning text-dark rounded-pill align-self-start">Perlu Cek</span>
                            <?php endif; ?>
                        </div>
                        <h2 class="fw-bold mb-1"><?= $count_pending ?></h2>
                        <span class="text-muted small">Pembayaran Pending</span>
                        <i class="bi bi-wallet2 stat-decoration text-warning"></i>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?= base_url('admin/kegiatan') ?>" class="text-decoration-none text-dark">
                    <div class="stat-card">
                        <div class="icon-box bg-info bg-opacity-10 text-info">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                        <h2 class="fw-bold mb-1"><?= $count_agenda ?></h2>
                        <span class="text-muted small">Agenda Aktif</span>
                        <i class="bi bi-calendar-check stat-decoration text-info"></i>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?= base_url('admin/warga') ?>" class="text-decoration-none text-dark">
                    <div class="stat-card">
                        <div class="icon-box bg-success bg-opacity-10 text-success">
                            <i class="bi bi-people"></i>
                        </div>
                        <h2 class="fw-bold mb-1"><?= $total_warga ?? '0' ?></h2> <!-- Pass total_warga from controller or dashboard logic -->
                        <span class="text-muted small">Total Warga</span>
                        <i class="bi bi-people stat-decoration text-success"></i>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                 <a href="<?= base_url('admin/pengaduan') ?>" class="text-decoration-none text-dark">
                    <div class="stat-card">
                        <div class="icon-box bg-danger bg-opacity-10 text-danger">
                            <i class="bi bi-megaphone"></i>
                        </div>
                        <h2 class="fw-bold mb-1">-</h2> <!-- Placeholder for Complaints Count -->
                        <span class="text-muted small">Aduan Masuk</span>
                        <i class="bi bi-megaphone stat-decoration text-danger"></i>
                    </div>
                </a>
            </div>
        </div>

        <div class="row g-4">
            
            <!-- Left Column: Chart & Activities -->
            <div class="col-lg-8">
                
                <!-- Revenue Chart -->
                <div class="card-custom mb-4">
                    <div class="card-header-custom">
                        <div>
                            <h5 class="fw-bold m-0">Tren Pemasukan</h5>
                            <small class="text-muted">Grafik iuran warga bulanan</small>
                        </div>
                        <button class="btn btn-sm btn-outline-secondary rounded-pill"><i class="bi bi-download me-1"></i> Export</button>
                    </div>
                    <div class="card-body p-4">
                        <div style="height: 300px;">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Recent Activities / Logs (Optional) -->
                <div class="card-custom">
                    <div class="card-header-custom">
                        <h5 class="fw-bold m-0">Verifikasi Terakhir</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-custom table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 text-muted small text-uppercase">Warga</th>
                                    <th class="text-muted small text-uppercase">Pembayaran</th>
                                    <th class="text-muted small text-uppercase">Tanggal</th>
                                    <th class="text-muted small text-uppercase text-end pe-4">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($history)): ?>
                                    <?php foreach($history as $h): ?>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="avatar-circle bg-success-subtle text-success">
                                                    <?= substr($h['nama_lengkap'], 0, 1) ?>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark mb-0"><?= $h['nama_lengkap'] ?></div>
                                                    <small class="text-muted">Blok <?= $h['blok'] ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-medium text-dark"><?= $h['nama_iuran'] ?></div>
                                        </td>
                                        <td class="text-muted">
                                            <?= date('d M, H:i', strtotime($h['tgl_bayar'])) ?>
                                        </td>
                                        <td class="text-end pe-4">
                                            <?php if($h['status'] == 'disetujui'): ?>
                                                <span class="badge-custom bg-success-subtle text-success">Sukses</span>
                                            <?php else: ?>
                                                <span class="badge-custom bg-danger-subtle text-danger">Gagal</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="4" class="text-center py-4 text-muted">Belum ada data.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!-- Right Column: Sidebar -->
            <div class="col-lg-4">
                
                <!-- Pengurus Inti -->
                <div class="card-custom mb-4">
                    <div class="card-header-custom">
                        <h5 class="fw-bold m-0">Pengurus Inti</h5>
                        <a href="<?= base_url('admin/organisasi') ?>" class="btn btn-sm btn-light text-primary rounded-pill px-3">Kelola</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush border-0">
                            <?php foreach($pengurus as $p): ?>
                            <div class="list-group-item border-0 px-4 py-3 d-flex align-items-center gap-3">
                                <?php if($p['foto']): ?>
                                    <img src="<?= base_url('assets/images/pengurus/'.$p['foto']) ?>" class="avatar-circle">
                                <?php else: ?>
                                    <div class="avatar-circle bg-light text-secondary">
                                        <?= substr($p['nama'],0,1) ?>
                                    </div>
                                <?php endif; ?>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold text-dark mb-0"><?= $p['nama'] ?></h6>
                                    <small class="text-muted"><?= $p['jabatan'] ?></small>
                                </div>
                                <span class="badge bg-light text-secondary rounded-pill" style="font-size: 10px;"><?= $p['tipe_organisasi'] == 'fkkmbt' ? 'FKKMBT' : 'PEMUDA' ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Shortcuts / Quick Actions -->
                <div class="card-custom bg-dark text-white p-4 text-center position-relative overflow-hidden mb-4">
                   <div class="position-absolute top-0 start-0 w-100 h-100 bg-success opacity-10" style="background: radial-gradient(circle, rgba(16,185,129,0.4) 0%, rgba(0,0,0,0) 70%);"></div>
                   <h5 class="fw-bold mb-3 position-relative">Akses Cepat</h5>
                   <div class="d-grid gap-2 position-relative">
                       <button class="btn btn-success rounded-pill py-2" data-bs-toggle="modal" data-bs-target="#addMaster">
                            <i class="bi bi-plus-lg me-2"></i>Buat Tagihan Baru
                       </button>
                       <a href="<?= base_url('admin/warga') ?>" class="btn btn-outline-light rounded-pill py-2">
                            <i class="bi bi-person-plus me-2"></i>Tambah Warga
                       </a>
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
                            font: { family: "'Plus Jakarta Sans', sans-serif" },
                            callback: function(value) { return 'Rp ' + value/1000 + 'k'; }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: "'Plus Jakarta Sans', sans-serif" } }
                    }
                }
            }
        });
    </script>
</body>
</html>
