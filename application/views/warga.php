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

    <!-- Search & Filter Area -->
    <div class="row g-4 mb-4">
        <!-- Search Bar -->
        <div class="col-12">
            <form action="" method="GET" class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-2 d-flex align-items-center">
                    <input type="hidden" name="blok" value="<?= $this->input->get('blok') ?>">
                    <input type="text" name="search" class="form-control border-0 shadow-none ps-3" placeholder="Ketik nama warga atau nomor rumah..." value="<?= $this->input->get('search') ?>">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Cari</button>
                </div>
            </form>
        </div>

        <!-- Genteng Grid (Filter Blok) -->
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h6 class="fw-bold mb-3"><i class="bi bi-grid-3x3-gap-fill me-2 text-primary"></i>Pilih Blok (Genteng)</h6>
                
                <div class="accordion" id="blokAccordion">
                    <div class="d-grid gap-2">
                        <a href="<?= base_url('warga') ?>" class="btn <?= empty($selected_blok) ? 'btn-success text-white' : 'btn-outline-success' ?> rounded-3 py-2 fw-bold">
                            Tampilkan Semua Blok
                        </a>
                    </div>
                    
                    <div class="row g-2 mt-3">
                        <?php foreach(range('A','T') as $letter): 
                            $isActiveGroup = (substr($selected_blok ?? '', 0, 1) == $letter);
                        ?>
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="accordion-item border-0">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed p-2 rounded-3 shadow-sm d-block text-center <?= $isActiveGroup ? 'bg-primary text-white' : 'bg-light text-dark' ?>" 
                                            type="button" 
                                            data-bs-toggle="collapse" 
                                            data-bs-target="#collapse<?= $letter ?>">
                                        <span class="d-block fw-bold fs-5">Blok <?= $letter ?></span>
                                        <small style="font-size: 10px;" class="opacity-75">Lihat Unit</small>
                                    </button>
                                </h2>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Accordion Bodies (placed outside grid to expand full width) -->
                    <?php foreach(range('A','T') as $letter): 
                         $isActiveGroup = (substr($selected_blok ?? '', 0, 1) == $letter);
                    ?>
                    <div id="collapse<?= $letter ?>" class="accordion-collapse collapse <?= $isActiveGroup ? 'show' : '' ?>" data-bs-parent="#blokAccordion">
                        <div class="card card-body bg-light border-0 mt-2 rounded-4">
                            <h6 class="small fw-bold text-muted mb-2">Pilih Unit Blok <?= $letter ?>:</h6>
                            <div class="row g-2">
                                <?php for($i=1; $i<=10; $i++): $val = $letter . $i; // Generate logic for sub-blocks ?> 
                                <div class="col-3 col-md-2">
                                    <a href="?blok=<?= $letter ?>" class="btn w-100 active-genteng shadow-sm rounded-3 p-1 d-flex flex-column align-items-center justify-content-center" style="height: 60px;">
                                        <!-- Note: Using Letter filter generally as database specific row logic is unknown. 
                                             If user wants strict sub-block, we'd need ?blok=A1 etc. and strict DB matching.
                                             For now, defaulting to filtering by Letter when clicked. -->
                                        <i class="bi bi-house-door-fill fs-5 mb-1 text-secondary"></i>
                                        <span class="lh-1 fw-bold small"><?= $letter ?><?= $i ?></span>
                                    </a>
                                </div>
                                <?php endfor; ?>
                            </div>
                            <div class="mt-2 text-center">
                                <a href="?blok=<?= $letter ?>" class="btn btn-sm btn-primary rounded-pill px-4">Lihat Semua Blok <?= $letter ?></a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
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
        .accordion-button::after { display: none; }
        .hover-scale { transition: transform 0.2s; }
        .hover-scale:hover { transform: scale(1.02); }
        .active-genteng { background: white; border: 1px solid #e2e8f0; color: #334155; }
        .active-genteng:hover { background: #f1f5f9; }
    </style>
</div>
