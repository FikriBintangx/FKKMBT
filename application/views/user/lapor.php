<?php $page_title = 'Laporan Warga'; ?>
<?php $this->load->view('user/templates/header'); ?>

<!-- Green Header -->
<div style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); padding: 20px; color: white;">
    <div class="container">
        <a href="<?= base_url('user/dashboard') ?>" class="text-white text-decoration-none">
            <i class="bi bi-arrow-left me-2"></i>
        </a>
        <h4 class="fw-bold mb-1 mt-2">Layanan Pengaduan</h4>
        <p class="mb-0 small opacity-75">Laporkan keluhan atau masalah di lingkungan</p>
    </div>
</div>

<main class="container py-4">
    <!-- Form Laporan -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-4">Buat Laporan Baru</h5>
            <form action="<?= base_url('user/lapor/submit') ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">Judul Laporan</label>
                    <input type="text" class="form-control" name="judul" placeholder="Contoh: Lampu jalan mati" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">Kategori</label>
                    <select class="form-select" name="kategori" required>
                        <option value="">Pilih Kategori</option>
                        <option value="Keamanan">Keamanan</option>
                        <option value="Kebersihan">Kebersihan</option>
                        <option value="Fasilitas">Fasilitas Umum</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">Deskripsi Detail</label>
                    <textarea class="form-control" name="deskripsi" rows="4" placeholder="Jelaskan detail masalah..." required></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-bold text-muted">Foto Bukti (Opsional)</label>
                    <input type="file" class="form-control" name="foto" accept="image/*">
                </div>

                <button type="submit" class="btn btn-success w-100 py-3 fw-bold rounded-pill">
                    <i class="bi bi-send-fill me-2"></i>Kirim Laporan
                </button>
            </form>
        </div>
    </div>

    <!-- Riwayat (Placeholder) -->
    <h6 class="fw-bold mb-3 px-1">Riwayat Laporan</h6>
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body text-center py-5">
            <img src="https://cdn-icons-png.flaticon.com/512/7486/7486747.png" width="80" class="mb-3 opacity-50">
            <p class="text-muted small mb-0">Belum ada laporan yang dikirim</p>
        </div>
    </div>
</main>

<?php $this->load->view('user/templates/footer'); ?>
