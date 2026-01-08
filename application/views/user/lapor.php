<?php $this->load->view('user/templates/header'); ?>

<!-- Header with Gradient -->
<div class="header-section" style="background: linear-gradient(135deg, #022c22 0%, #14532d 100%); padding: 30px 20px 80px; color: white; border-radius: 0 0 30px 30px; position: relative; z-index: 1;">
    <div class="d-flex align-items-center gap-3">
        <a href="<?= base_url('user/dashboard') ?>" class="text-white text-decoration-none bg-white bg-opacity-10 rounded-circle p-2 d-flex align-items-center justify-content-center shadow-none" style="width: 40px; height: 40px; background: rgba(255,255,255,0.2);">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div class="flex-grow-1">
            <h5 class="fw-bold mb-0">Layanan Pengaduan</h5>
            <p class="mb-0 small opacity-75">Laporkan keluhan lingkungan</p>
        </div>
    </div>
</div>

<main class="container py-4" style="margin-top: -60px; position: relative; z-index: 2;">

    <!-- Form Buat Laporan Baru -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <h6 class="fw-bold mb-3">Buat Laporan Baru</h6>
            <form action="<?= base_url('user/lapor/submit') ?>" method="POST" enctype="multipart/form-data">
                
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">Judul Laporan</label>
                    <input type="text" name="judul" class="form-control rounded-pill bg-light border-0 px-3 py-2" placeholder="Contoh: Lampu jalan mati" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">Kategori</label>
                    <select name="kategori" class="form-select rounded-pill bg-light border-0 px-3 py-2" required>
                        <option value="">Pilih Kategori</option>
                        <option value="Infrastruktur">Infrastruktur (Jalan/Lampu/Selokan)</option>
                        <option value="Keamanan">Keamanan & Ketertiban</option>
                        <option value="Kebersihan">Kebersihan & Sampah</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">Deskripsi Detail</label>
                    <textarea name="deskripsi" class="form-control rounded-4 bg-light border-0 p-3" rows="3" placeholder="Jelaskan detail masalah..." required></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-bold text-muted">Foto Bukti (Opsional)</label>
                    <input type="file" name="foto" class="form-control bg-light border-0 rounded-pill">
                </div>

                <button type="submit" class="btn btn-success w-100 rounded-pill py-2 fw-bold shadow-sm">
                    <i class="bi bi-send-fill me-2"></i> Kirim Laporan
                </button>
            </form>
        </div>
    </div>

    <!-- Riwayat Laporan -->
    <div class="d-flex justify-content-between align-items-center mb-3 px-1">
        <h6 class="fw-bold mb-0 text-secondary small text-uppercase ls-1">Riwayat Laporan</h6>
        <button class="btn btn-sm btn-outline-secondary rounded-pill fw-bold" onclick="window.print()">
            <i class="bi bi-printer me-1"></i> Cetak
        </button>
    </div>

    <?php if(empty($riwayat)): ?>
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body text-center py-5">
                <i class="bi bi-clipboard-x fs-1 text-muted opacity-25 mb-3"></i>
                <p class="text-muted small mb-0">Belum ada laporan yang dikirim.</p>
            </div>
        </div>
    <?php else: ?>
        <div class="d-flex flex-column gap-3">
            <?php foreach($riwayat as $r): ?>
                <?php
                    $status_badge = '';
                    if($r['status'] == 'Pending') $status_badge = 'bg-warning bg-opacity-10 text-warning';
                    elseif($r['status'] == 'Selesai') $status_badge = 'bg-success bg-opacity-10 text-success';
                    elseif($r['status'] == 'Diproses') $status_badge = 'bg-info bg-opacity-10 text-info';
                    else $status_badge = 'bg-danger bg-opacity-10 text-danger';
                ?>
                <div class="card border-0 shadow-sm rounded-4 card-hover-effect">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <span class="badge bg-light text-secondary border rounded-pill mb-1" style="font-size: 10px;"><?= $r['kategori'] ?></span>
                                <h6 class="fw-bold mb-0 small text-dark"><?= $r['judul'] ?></h6>
                                <small class="text-muted" style="font-size: 10px;"><?= date('d M Y, H:i', strtotime($r['created_at'])) ?></small>
                            </div>
                            <span class="badge <?= $status_badge ?> rounded-pill" style="font-size: 9px;"><?= $r['status'] ?></span>
                        </div>
                        
                        <p class="small text-muted mb-2 border-start border-3 ps-2 fst-italic display-6" style="font-size: 12px;"><?= substr($r['deskripsi'], 0, 100) ?>...</p>

                        <?php if(!empty($r['foto'])): ?>
                            <a href="<?= base_url('assets/uploads/laporan/'.$r['foto']) ?>" target="_blank" class="btn btn-sm btn-light rounded-pill small border" style="font-size: 11px;">
                                <i class="bi bi-image me-1"></i> Lihat Foto
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <div class="mb-5 pb-5"></div>

</main>

<?php $this->load->view('user/templates/footer'); ?>
