<div class="container py-4">
    <!-- Green Header Section -->
    <div class="text-center mb-5 mt-3 rounded-4 p-4 text-white shadow-lg position-relative overflow-hidden" style="background: linear-gradient(135deg, #1e5631 0%, #0d3820 100%);">
        <div class="position-absolute top-0 end-0 p-3 opacity-10">
            <i class="bi bi-calendar-event-fill display-1"></i>
        </div>
        <span class="badge bg-white text-success rounded-pill mb-2 px-3 fw-bold">AGENDA & DOKUMENTASI</span>
        <h2 class="fw-bold display-6 mb-2">Kegiatan Warga</h2>
        <p class="mb-0 fw-medium" style="max-width: 600px; margin: 0 auto; color: #ffffff !important;">
            Jadwal kegiatan rutin dan dokumentasi acara kebersamaan.
        </p>
    </div>

    <!-- Upcoming Events Section -->
    <?php if(!empty($upcoming)): ?>
    <div class="mb-5">
        <h5 class="fw-bold mb-4 px-2 border-start border-4 border-warning ms-2 ps-3">Agenda Akan Datang</h5>
        
        <!-- Featured Upcoming Event -->
        <?php $feat = $upcoming[0]; ?>
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-4">
            <div class="row g-0">
                <div class="col-md-6 bg-dark text-white p-5 d-flex flex-column justify-content-center position-relative">
                    <div class="position-absolute top-0 start-0 p-4">
                        <span class="badge bg-warning text-dark fw-bold animate-pulse">SEGERA</span>
                    </div>
                    <h4 class="text-white-50 mb-1 text-uppercase"><?= date('F Y', strtotime($feat['tanggal'])) ?></h4>
                    <h1 class="fw-bold mb-3"><?= $feat['judul'] ?></h1>
                    <p class="opacity-75 mb-4 text-truncate-3"><?= strip_tags($feat['deskripsi']) ?></p>
                    
                    <div class="d-flex gap-4">
                        <div>
                            <i class="bi bi-calendar-check fs-4 d-block mb-1 text-warning"></i>
                            <span class="small fw-bold"><?= date('d M', strtotime($feat['tanggal'])) ?></span>
                        </div>
                        <div>
                            <i class="bi bi-person-badge fs-4 d-block mb-1 text-warning"></i>
                            <span class="small fw-bold"><?= $feat['nama_organisasi'] ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 bg-secondary d-none d-md-block" style="min-height: 300px; position: relative;">
                    <?php if(!empty($feat['foto'])): ?>
                        <div style="background: url('<?= base_url('assets/images/kegiatan/'.$feat['foto']) ?>') center/cover no-repeat; width: 100%; height: 100%;"></div>
                    <?php else: ?>
                        <div class="d-flex align-items-center justify-content-center h-100 bg-light text-muted">
                            <i class="bi bi-image fs-1"></i>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- List of other upcoming -->
        <?php if(count($upcoming) > 1): ?>
        <div class="row g-3">
            <?php for($i=1; $i < count($upcoming); $i++): $ev = $upcoming[$i]; ?>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4 d-flex align-items-center gap-3">
                        <div class="bg-primary-subtle text-primary rounded-3 text-center p-3" style="min-width: 80px;">
                            <span class="d-block fw-bold small"><?= date('M', strtotime($ev['tanggal'])) ?></span>
                            <span class="d-block fw-bold fs-3 lh-1"><?= date('d', strtotime($ev['tanggal'])) ?></span>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1"><?= $ev['judul'] ?></h6>
                            <p class="text-muted small mb-0"><i class="bi bi-people me-1"></i> <?= $ev['nama_organisasi'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php endfor; ?>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <!-- Past Events Gallery -->
    <h5 class="fw-bold mb-4 px-2 border-start border-4 border-primary ms-2 ps-3">Dokumentasi Kegiatan</h5>
    
    <?php if(!empty($past)): ?>
    <div class="row g-4">
        <?php foreach($past as $row): ?>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 hover-zoom">
                <div class="ratio ratio-4x3 bg-light">
                    <?php if(!empty($row['foto'])): ?>
                        <img src="<?= base_url('assets/images/kegiatan/'.$row['foto']) ?>" class="object-fit-cover" loading="lazy">
                    <?php else: ?>
                        <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                            <i class="bi bi-image"></i>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card-body p-3">
                    <small class="text-primary fw-bold" style="font-size: 10px;"><?= strtoupper($row['nama_organisasi']) ?></small>
                    <h6 class="fw-bold mb-1 mt-1 text-truncate-2" style="font-size: 14px; line-height: 1.4;"><?= $row['judul'] ?></h6>
                    <small class="text-muted" style="font-size: 11px;"><?= date('d F Y', strtotime($row['tanggal'])) ?></small>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
        <div class="text-center py-5">
            <p class="text-muted">Belum ada dokumentasi kegiatan.</p>
        </div>
    <?php endif; ?>

    <style>
        .hover-zoom { transition: transform 0.3s; }
        .hover-zoom:hover { transform: translateY(-5px); }
        .text-truncate-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
        .animate-pulse { animation: pulse 2s infinite; }
        @keyframes pulse { 0% { opacity: 1; } 50% { opacity: 0.5; } 100% { opacity: 1; } }
    </style>
</div>
