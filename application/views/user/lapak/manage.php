<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Lapak - FKKMBT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #f8fafc; }
        .upload-area {
            border: 2px dashed #cbd5e1; border-radius: 12px; padding: 20px;
            text-align: center; cursor: pointer; transition: 0.3s; background: white;
        }
        .upload-area:hover { border-color: #f97316; background: #fff7ed; }
    </style>
</head>
<body>

    <nav class="navbar navbar-light bg-white border-bottom sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-dark fs-6" href="<?= base_url('user/lapak') ?>">
                <i class="bi bi-arrow-left me-2"></i> Kembali ke Lapak
            </a>
            <span class="fw-bold text-orange">Lapak Saya</span>
        </div>
    </nav>

    <div class="container py-4">
        
        <?php if ($this->session->flashdata('success_msg')): ?>
            <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4">
                <i class="bi bi-check-circle-fill me-2"></i><?= $this->session->flashdata('success_msg') ?>
            </div>
        <?php endif; ?>

        <!-- Add Form -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                <h5 class="fw-bold"><i class="bi bi-plus-circle-fill text-orange me-2"></i>Jual Barang / Jasa</h5>
            </div>
            <div class="card-body p-4">
                <form action="<?= base_url('user/lapak/add') ?>" method="POST" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col-md-4 text-center">
                            <div class="upload-area h-100 d-flex flex-column align-items-center justify-content-center" onclick="document.getElementById('fotoIn').click()">
                                <i class="bi bi-camera-fill fs-2 text-secondary" id="camIcon"></i>
                                <img id="prevImg" class="d-none w-100 h-100 object-fit-cover rounded-3">
                                <span class="small text-muted mt-2" id="lblFoto">Upload Foto Produk</span>
                                <input type="file" name="foto" id="fotoIn" class="d-none" accept="image/*" onchange="preview(this)">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">NAMA PRODUK / JASA</label>
                                <input type="text" name="nama_produk" class="form-control" required placeholder="Contoh: Nasi Uduk Bu Tini">
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-6">
                                    <label class="form-label small fw-bold text-muted">HARGA (Rp)</label>
                                    <input type="text" name="harga" class="form-control" required placeholder="15.000">
                                </div>
                                <div class="col-6">
                                    <label class="form-label small fw-bold text-muted">KATEGORI</label>
                                    <select name="kategori" class="form-select" required>
                                        <option value="makanan">Makanan</option>
                                        <option value="minuman">Minuman</option>
                                        <option value="jasa">Jasa / Tukang</option>
                                        <option value="pakaian">Pakaian</option>
                                        <option value="elektronik">Elektronik</option>
                                        <option value="lainnya">Lainnya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">KONTAK WHATSAPP</label>
                                <input type="text" name="kontak_wa" class="form-control" required placeholder="08xxxxxxxxxx" value="08">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">DESKRIPSI</label>
                                <textarea name="deskripsi" class="form-control" rows="2" placeholder="Jelaskan detail produk..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="d-grid mt-3">
                        <button type="submit" class="btn btn-warning text-white fw-bold py-2 rounded-pill">Tayangkan Sekarang</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- My List -->
        <h6 class="fw-bold ms-1 mb-3 text-muted">Produk Aktif Saya</h6>
        <div class="row g-3">
            <?php if(!empty($produk)): ?>
                <?php foreach($produk as $p): ?>
                <div class="col-12 col-md-6">
                    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                        <div class="d-flex">
                            <div style="width: 100px; height: 100px;">
                                <?php $img = $p['foto'] ? base_url('assets/images/lapak/'.$p['foto']) : 'https://via.placeholder.com/100'; ?>
                                <img src="<?= $img ?>" class="w-100 h-100 object-fit-cover">
                            </div>
                            <div class="p-3 flex-grow-1 d-flex flex-column justify-content-center">
                                <h6 class="fw-bold mb-1"><?= $p['nama_produk'] ?></h6>
                                <div class="text-orange fw-bold">Rp <?= number_format($p['harga'],0,',','.') ?></div>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <small class="text-muted"><i class="bi bi-eye"></i> <?= $p['dilihat'] ?> Views</small>
                                    <a href="<?= base_url('user/lapak/delete/'.$p['id']) ?>" onclick="return confirm('Hapus produk ini?')" class="btn btn-sm btn-outline-danger py-0 px-2 rounded-pill small">Hapus</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-4 text-muted small">
                    Anda belum menjual apapun.
                </div>
            <?php endif; ?>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function preview(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('prevImg').src = e.target.result;
                    document.getElementById('prevImg').classList.remove('d-none');
                    document.getElementById('camIcon').classList.add('d-none');
                    document.getElementById('lblFoto').style.display = 'none';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>
