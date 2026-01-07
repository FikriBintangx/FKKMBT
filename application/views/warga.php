<div class="container py-4">
    <div class="text-center mb-5 mt-3">
        <span class="badge bg-success-subtle text-success rounded-pill mb-2 px-3 fw-bold">DATABASE</span>
        <h2 class="fw-bold display-6">Direktori Warga<br>Bukit Tiara</h2>
        <p class="text-muted mx-auto" style="max-width: 600px;">
            Cari lokasi blok dan informasi warga untuk keperluan silaturahmi.
        </p>
    </div>

    <!-- Stats Overview -->
    <div class="row g-3 mb-4">
        <div class="col-4">
             <div class="card border-0 shadow-sm rounded-4 text-center py-3 h-100 bg-primary-subtle">
                 <h3 class="fw-bold text-primary mb-0">500+</h3>
                 <small class="text-primary-emphasis fw-bold" style="font-size: 10px;">TOTAL KK</small>
             </div>
        </div>
        <div class="col-4">
             <div class="card border-0 shadow-sm rounded-4 text-center py-3 h-100 bg-success-subtle">
                 <h3 class="fw-bold text-success mb-0">95%</h3>
                 <small class="text-success-emphasis fw-bold" style="font-size: 10px;">HUNI TETAP</small>
             </div>
        </div>
        <div class="col-4">
             <div class="card border-0 shadow-sm rounded-4 text-center py-3 h-100 bg-warning-subtle">
                 <h3 class="fw-bold text-warning-emphasis mb-0">20</h3>
                 <small class="text-warning-emphasis fw-bold" style="font-size: 10px;">TOTAL BLOK</small>
             </div>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="row mb-4">
        <div class="col-12">
            <form action="" method="GET" class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-2 d-flex align-items-center">
                    <input type="hidden" name="blok" value="<?= $this->input->get('blok') ?>">
                    <input type="text" name="search" class="form-control border-0 shadow-none ps-3" placeholder="Ketik nama warga atau nomor rumah..." value="<?= $this->input->get('search') ?>">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Cari</button>
                </div>
            </form>
        </div>
    </div>

    <!-- House Icon Grid (Filter Blok) -->
    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
        <h6 class="fw-bold mb-4 text-center"><i class="bi bi-houses-fill me-2 text-primary"></i>Pilih Blok (Rumah)</h6>
        
        <?php 
           // Define block ranges based on available data or A-T structure
           // Assuming DB has Blocks A-T, and each block has rows 1-5 or similar.
           $blocks = range('A', 'T');
        ?>
        
        <div class="row g-3 justify-content-center">
            <div class="col-12 mb-2">
                 <a href="<?= base_url('warga') ?>" class="btn w-100 <?= empty($selected_blok) ? 'btn-success text-white' : 'btn-outline-secondary' ?> rounded-pill fw-bold">
                    Tampilkan Semua Warga
                </a>
            </div>

            <?php foreach($blocks as $letter): ?>
                <?php 
                 // We will create 5 sub-blocks (Genteng/Rumah) for each Letter as per user request to mimic legacy
                 // User said: "di database ada A1 sampe A5". So we generate A1..A5 buttons.
                 for($i=1; $i<=5; $i++): 
                    $blokCode = $letter . $i;
                    $isActive = ($selected_blok == $blokCode);
                ?>
                <div class="col-4 col-sm-3 col-md-2 p-1">
                    <a href="?blok=<?= $blokCode ?>" class="btn w-100 p-0 border-0 position-relative house-btn <?= $isActive ? 'active' : '' ?>">
                         <!-- House Icon Shape -->
                         <div class="house-icon shadow-sm">
                             <div class="roof"></div>
                             <div class="body d-flex flex-column align-items-center justify-content-center">
                                 <span class="fw-bold fs-5 house-text"><?= $blokCode ?></span>
                             </div>
                         </div>
                    </a>
                </div>
                <?php endfor; ?>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Results List -->
    <div class="d-flex flex-column gap-3">
        <?php if(!empty($warga_list)): ?>
            <?php foreach($warga_list as $row): ?>
            <div class="card border-0 shadow-sm rounded-4 w-100 hover-scale cursor-pointer">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="bg-primary text-white rounded-3 d-flex flex-column align-items-center justify-content-center p-2 shadow-sm" style="width: 50px; height: 50px;">
                        <small style="font-size: 8px; font-weight: 700;">BLOK</small>
                        <span class="fs-4 fw-bold lh-1"><?= $row['blok'] ?></span>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="fw-bold text-dark mb-1"><?= $row['nama_lengkap'] ?></h6>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-light text-dark border rounded-pill" style="font-size: 10px;">No. <?= $row['no_rumah'] ?></span>
                            <?php if(!empty($row['status_huni'])): ?>
                                <span class="badge bg-success-subtle text-success rounded-pill" style="font-size: 10px;"><?= $row['status_huni'] ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <a href="https://wa.me/<?= $row['no_hp'] ?>" class="btn btn-success rounded-circle shadow-sm" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-center py-5">
                <div class="bg-light rounded-circle d-inline-flex p-4 mb-3 text-muted">
                    <i class="bi bi-search fs-1 opacity-50"></i>
                </div>
                <h6 class="fw-bold text-dark">Warga Tidak Ditemukan</h6>
                <p class="text-muted small">Coba kata kunci atau blok lain.</p>
            </div>
        <?php endif; ?>
    </div>

    <style>
        .hover-scale { transition: transform 0.2s; }
        .hover-scale:hover { transform: scale(1.02); }
        
        /* House Icon CSS */
        .house-btn { text-decoration: none; }
        .house-icon {
            display: flex; flex-direction: column; align-items: center;
            transition: transform 0.2s;
        }
        .house-btn:hover .house-icon { transform: translateY(-5px); }
        
        .roof {
            width: 0; 
            height: 0; 
            border-left: 25px solid transparent;
            border-right: 25px solid transparent;
            border-bottom: 20px solid #cbd5e1; /* Default roof color */
            position: relative;
            z-index: 1;
        }
        .body {
            width: 40px;
            height: 35px;
            background-color: #f1f5f9; /* Default body color */
            border-bottom-left-radius: 4px;
            border-bottom-right-radius: 4px;
            color: #64748b;
        }
        
        /* Active State */
        .house-btn.active .roof { border-bottom-color: #15803d; /* Green roof */ }
        .house-btn.active .body { background-color: #dcfce7; color: #15803d; font-weight: 800; }
        
        .house-text { font-size: 12px !important; letter-spacing: -0.5px; }

    </style>
</div>
