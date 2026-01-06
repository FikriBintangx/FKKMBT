<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lapak Warga - FKKMBT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #f8fafc; }
        
        .lapak-header {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            padding: 40px 0 80px; margin-bottom: -50px; border-radius: 0 0 30px 30px;
            color: white; position: relative; overflow: hidden;
        }
        .lapak-header::before {
            content: ''; position: absolute; right: -20px; top: -20px;
            width: 200px; height: 200px; background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }

        .category-scroll {
            display: flex; gap: 10px; overflow-x: auto; padding-bottom: 10px;
            scrollbar-width: none;
        }
        .category-scroll::-webkit-scrollbar { display: none; }
        
        .cat-pill {
            white-space: nowrap; padding: 8px 16px; border-radius: 50px;
            background: white; border: 1px solid #e2e8f0; color: #64748b;
            text-decoration: none; font-size: 14px; fw-bold; transition: all 0.2s;
        }
        .cat-pill.active, .cat-pill:hover {
            background: #f97316; color: white; border-color: #f97316;
        }

        .product-card {
            border: none; border-radius: 16px; overflow: hidden; background: white;
            transition: transform 0.2s, box-shadow 0.2s; height: 100%;
            text-decoration: none; color: inherit; display: block;
        }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
        
        .product-img {
            height: 180px; width: 100%; object-fit: cover; background: #f1f5f9;
        }
        .seller-avatar {
            width: 24px; height: 24px; border-radius: 50%; object-fit: cover;
            background: #cbd5e1; font-size: 10px; display: flex; align-items: center; justify-content: center;
        }
        
        .price-tag { color: #f97316; font-weight: 700; font-size: 16px; }
        
        .floating-sell-btn {
            position: fixed; bottom: 30px; right: 30px; z-index: 100;
            background: #f97316; color: white; width: 60px; height: 60px;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 24px; box-shadow: 0 10px 25px rgba(249, 115, 22, 0.4);
            transition: transform 0.2s;
        }
        .floating-sell-btn:hover { transform: scale(1.1); color: white; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?= base_url('user/dashboard') ?>">
                <i class="bi bi-arrow-left-circle me-2"></i> Dashboard
            </a>
            <span class="text-white-50 small">Lapak Warga</span>
        </div>
    </nav>

    <div class="lapak-header text-center">
        <div class="container">
            <h1 class="fw-bold mb-2">Lapak Warga</h1>
            <p class="opacity-90 mb-4">Belanja lokal, dukung usaha tetangga!</p>
            
            <form action="" method="GET" class="position-relative mx-auto" style="max-width: 500px;">
                <input type="text" name="q" class="form-control rounded-pill py-3 px-4 shadow-sm border-0" 
                       placeholder="Cari nasi uduk, laundry, tukang..." value="<?= $this->input->get('q') ?>">
                <button type="submit" class="btn btn-dark rounded-circle position-absolute top-50 end-0 translate-middle-y me-2" style="width: 40px; height: 40px;">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="container" style="margin-top: -30px; position: relative; z-index: 10;">
        <!-- Kategori -->
        <div class="category-scroll mb-4">
            <a href="?kategori=" class="cat-pill shadow-sm <?= empty($this->input->get('kategori')) ? 'active' : '' ?>">Semua</a>
            <a href="?kategori=makanan" class="cat-pill shadow-sm <?= $this->input->get('kategori')=='makanan' ? 'active' : '' ?>">🍽️ Makanan</a>
            <a href="?kategori=minuman" class="cat-pill shadow-sm <?= $this->input->get('kategori')=='minuman' ? 'active' : '' ?>">🥤 Minuman</a>
            <a href="?kategori=jasa" class="cat-pill shadow-sm <?= $this->input->get('kategori')=='jasa' ? 'active' : '' ?>">🛠️ Jasa & Tukang</a>
            <a href="?kategori=pakaian" class="cat-pill shadow-sm <?= $this->input->get('kategori')=='pakaian' ? 'active' : '' ?>">👕 Pakaian</a>
            <a href="?kategori=elektronik" class="cat-pill shadow-sm <?= $this->input->get('kategori')=='elektronik' ? 'active' : '' ?>">📱 Elektronik</a>
            <a href="?kategori=lainnya" class="cat-pill shadow-sm <?= $this->input->get('kategori')=='lainnya' ? 'active' : '' ?>">📦 Lainnya</a>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold m-0 text-secondary">Etalase Warga</h6>
            <a href="<?= base_url('user/lapak/saya') ?>" class="text-decoration-none small fw-bold text-orange">
                <i class="bi bi-shop me-1"></i> Kelola Lapak Saya (<?= $my_products_count ?>)
            </a>
        </div>

        <div class="row g-3">
            <?php if(!empty($produk)): ?>
                <?php foreach($produk as $p): ?>
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="product-card shadow-sm h-100 position-relative">
                        <!-- Image -->
                        <?php 
                            $img = $p['foto'] ? base_url('assets/images/lapak/'.$p['foto']) : 'https://via.placeholder.com/300x300/f1f5f9/94a3b8?text=No+Image';
                        ?>
                        <img src="<?= $img ?>" class="product-img">
                        
                        <div class="p-3">
                            <div class="small text-muted mb-1 text-uppercase" style="font-size: 10px; letter-spacing: 0.5px;"><?= $p['kategori'] ?></div>
                            <h6 class="fw-bold text-dark text-truncate mb-1"><?= $p['nama_produk'] ?></h6>
                            <div class="price-tag mb-2">Rp <?= number_format($p['harga'], 0, ',', '.') ?></div>
                            
                            <div class="d-flex align-items-center justify-content-between pt-2 border-top">
                                <div class="d-flex align-items-center gap-2" style="max-width: 70%;">
                                    <div class="seller-avatar text-white">
                                        <?= substr($p['nama_lengkap'], 0, 1) ?>
                                    </div>
                                    <small class="text-truncate text-muted" style="font-size: 11px;">
                                        <?= explode(' ', $p['nama_lengkap'])[0] ?>
                                    </small>
                                </div>
                                <a href="https://wa.me/<?= $p['kontak_wa'] ?>?text=Halo Kak, saya lihat produk *<?= $p['nama_produk'] ?>* di Aplikasi Warga, apakah masih ada?" target="_blank" class="btn btn-sm btn-success rounded-circle" style="width: 32px; height: 32px; display:flex; align-items:center; justify-content:center;">
                                    <i class="bi bi-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <img src="https://cdn-icons-png.flaticon.com/512/4076/4076432.png" width="100" class="mb-3 opacity-50">
                    <p class="text-muted">Belum ada produk di kategori ini.<br>Jadilah yang pertama berjualan!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Floating Action Button -->
    <a href="<?= base_url('user/lapak/saya') ?>" class="floating-sell-btn" title="Jual Produk">
        <i class="bi bi-plus-lg"></i>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
