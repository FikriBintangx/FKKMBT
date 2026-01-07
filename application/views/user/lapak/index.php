<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Lapak Warga - FKKMBT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/mobile.css?v='.time()) ?>">
    <style>
        .lapak-hero {
            background: var(--primary-gradient);
            padding: 20px 20px 80px;
            border-radius: 0 0 32px 32px;
            color: white;
            text-align: center;
        }
        .search-container {
            margin-top: -45px;
            padding: 0 20px;
            position: relative;
            z-index: 10;
        }
        .search-box {
            background: white;
            border-radius: 50px;
            padding: 8px 15px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
        }
        .category-scroll {
            overflow-x: auto;
            white-space: nowrap;
            padding: 15px 20px;
            scrollbar-width: none;
        }
        .category-scroll::-webkit-scrollbar { display: none; }
        .cat-chip {
            display: inline-block;
            padding: 8px 20px;
            background: white;
            border: 1px solid #f1f5f9;
            border-radius: 50px;
            margin-right: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #64748b;
            text-decoration: none;
            transition: all 0.2s;
            box-shadow: 0 2px 5px rgba(0,0,0,0.02);
        }
        .cat-chip.active {
            background: #0f172a;
            color: white;
            border-color: #0f172a;
        }
        .product-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #f1f5f9;
            height: 100%;
            transition: transform 0.2s;
        }
        .product-card:active { transform: scale(0.98); }
        .product-img {
            height: 140px;
            width: 100%;
            object-fit: cover;
            background: #e2e8f0;
        }
        .fab-add {
            position: fixed;
            bottom: 90px;
            right: 20px;
            width: 56px; height: 56px;
            background: #f97316;
            color: white;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 10px 20px rgba(249, 115, 22, 0.4);
            font-size: 24px;
            z-index: 999;
        }
        .seller-badge {
            position: absolute;
            top: 10px; right: 10px;
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(4px);
            color: white;
            font-size: 10px;
            padding: 4px 8px;
            border-radius: 50px;
            display: flex; align-items: center; gap: 4px;
        }
    </style>
</head>
<body class="bg-light">

    <!-- App Bar -->
    <div class="app-bar d-lg-none shadow-none">
        <div class="d-flex align-items-center gap-3">
            <a href="<?= base_url('user/dashboard') ?>" class="text-white"><i class="bi bi-chevron-left fs-4"></i></a>
            <span class="fw-bold text-white">Lapak Warga</span>
        </div>
        <a href="<?= base_url('user/lapak/saya') ?>" class="btn btn-sm btn-light rounded-pill px-3 fw-bold small text-primary shadow-sm ms-auto">
            <i class="bi bi-shop me-1"></i> Toko Saya
        </a>
    </div>

    <!-- Hero -->
    <div class="lapak-hero">
        <h2 class="fw-bold mb-1">Pasar Lokal</h2>
        <p class="small opacity-75 mb-0 px-4">Dukung usaha tetangga, hidupkan ekonomi warga.</p>
    </div>

    <!-- Search Box -->
    <div class="search-container">
        <form action="" method="GET">
            <div class="search-box">
                <i class="bi bi-search text-muted me-2"></i>
                <input type="text" name="q" class="form-control border-0 shadow-none p-0 bg-transparent" placeholder="Cari nasi uduk, jasa, laundry..." value="<?= $this->input->get('q') ?>">
            </div>
        </form>
    </div>

    <!-- Categories -->
    <div class="category-scroll mt-2">
        <?php $k = $this->input->get('kategori'); ?>
        <a href="?" class="cat-chip <?= empty($k) ? 'active' : '' ?>">Semua</a>
        <a href="?kategori=makanan" class="cat-chip <?= $k=='makanan' ? 'active' : '' ?>">🍽️ Makanan</a>
        <a href="?kategori=minuman" class="cat-chip <?= $k=='minuman' ? 'active' : '' ?>">🥤 Minuman</a>
        <a href="?kategori=jasa" class="cat-chip <?= $k=='jasa' ? 'active' : '' ?>">🛠️ Jasa</a>
        <a href="?kategori=pakaian" class="cat-chip <?= $k=='pakaian' ? 'active' : '' ?>">👕 Pakaian</a>
        <a href="?kategori=elektronik" class="cat-chip <?= $k=='elektronik' ? 'active' : '' ?>">📱 Gadget</a>
    </div>

    <!-- Product Grid -->
    <main class="container px-3 pb-5">
        <div class="d-flex justify-content-between align-items-center mb-3 px-1">
            <h6 class="fw-bold text-muted small text-uppercase ls-1 mb-0">Rekomendasi</h6>
        </div>

        <div class="row g-3">
            <?php if(!empty($produk)): ?>
                <?php foreach($produk as $p): ?>
                <div class="col-6">
                    <div class="product-card position-relative">
                        <!-- Seller Badge -->
                        <div class="seller-badge">
                            <i class="bi bi-person-circle"></i>
                            <?= explode(' ', $p['nama_lengkap'])[0] ?>
                        </div>

                        <!-- Image -->
                        <?php 
                            $img = $p['foto'] ? base_url('assets/images/lapak/'.$p['foto']) : 'https://via.placeholder.com/300x300/f1f5f9/94a3b8?text=No+Image';
                        ?>
                        <img src="<?= $img ?>" class="product-img">
                        
                        <div class="p-3">
                            <div class="small text-muted mb-1 text-uppercase fw-bold" style="font-size: 9px; letter-spacing: 0.5px;"><?= $p['kategori'] ?></div>
                            <h6 class="fw-bold text-dark text-truncate mb-1" style="font-size: 14px;"><?= $p['nama_produk'] ?></h6>
                            <div class="fw-bold text-primary mb-2" style="font-size: 14px;">Rp <?= number_format($p['harga'], 0, ',', '.') ?></div>
                            
                            <a href="https://wa.me/<?= $p['kontak_wa'] ?>?text=Halo, saya tertarik dengan *<?= $p['nama_produk'] ?>* di Lapak Warga." target="_blank" class="btn btn-success btn-sm w-100 rounded-pill fw-bold" style="font-size: 11px;">
                                <i class="bi bi-whatsapp me-1"></i> Beli
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <i class="bi bi-shop fs-1 text-muted opacity-25"></i>
                    <p class="text-muted small mt-2">Belum ada barang di kategori ini.</p>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <!-- FAB -->
    <a href="<?= base_url('user/lapak/saya') ?>" class="fab-add">
        <i class="bi bi-plus-lg"></i>
    </a>

    <!-- Native Bottom Nav -->
    <?php $this->load->view('templates/mobile_nav'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
