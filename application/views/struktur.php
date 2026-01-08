<div class="container py-4">
    <!-- Green Header Section -->
    <div class="text-center mb-5 mt-3 rounded-4 p-4 text-white shadow-lg position-relative overflow-hidden" style="background: linear-gradient(135deg, #1e5631 0%, #0d3820 100%);">
        <div class="position-absolute top-0 end-0 p-3 opacity-10">
            <i class="bi bi-diagram-3-fill display-1"></i>
        </div>
        <span class="badge bg-white text-success rounded-pill mb-2 px-3 fw-bold">ORGANISASI</span>
        <h2 class="fw-bold display-6 mb-2">Struktur Pengurus</h2>
        <p class="mb-0 fw-medium" style="max-width: 600px; margin: 0 auto; color: #ffffff !important;">
            Mengenal para penggerak lingkungan yang berdedikasi.
        </p>
    </div>

    <!-- Custom Segmented Tab -->
    <div class="d-flex justify-content-center mb-4">
        <div class="segmented-control shadow-sm">
            <ul class="nav nav-pills nav-fill" id="pills-tab" role="tablist" style="min-width: 300px;">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active w-100" id="pills-fkkmbt-tab" data-bs-toggle="pill" data-bs-target="#pills-fkkmbt" type="button">FKKMBT</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link w-100" id="pills-fkkmmbt-tab" data-bs-toggle="pill" data-bs-target="#pills-fkkmmbt" type="button">FKKMMBT</button>
                </li>
            </ul>
        </div>
    </div>

    <div class="tab-content" id="pills-tabContent">
        <!-- Tab FKKMBT -->
        <div class="tab-pane fade show active" id="pills-fkkmbt" role="tabpanel">
            <?php if(empty($struct_fkkmbt)): ?>
                <div class="text-center py-5">
                    <div class="position-relative d-inline-block mb-3">
                        <div class="bg-success bg-opacity-10 rounded-circle p-5">
                            <i class="bi bi-diagram-3 text-success display-1"></i>
                        </div>
                        <span class="position-absolute bottom-0 end-0 badge bg-warning text-dark border border-white border-2 rounded-pill">Segera Hadir</span>
                    </div>
                    <h4 class="fw-bold text-dark mb-2">Belum Ada Data Pengurus</h4>
                    <p class="text-muted small mx-auto" style="max-width: 300px;">
                        Data struktur kepengurusan FKKMBT sedang dalam proses pembaruan oleh admin.
                    </p>
                </div>
            <?php else: ?>
                <!-- Ketua Card -->
                <?php 
                $ketua_key = false;
                if(isset($struct_fkkmbt['KETUA UMUM'])) $ketua_key = 'KETUA UMUM';
                elseif(isset($struct_fkkmbt['KETUA'])) $ketua_key = 'KETUA';
                
                if($ketua_key && !empty($struct_fkkmbt[$ketua_key])): 
                    $ketua = $struct_fkkmbt[$ketua_key][0];
                ?>
                <div class="card border-0 shadow rounded-4 text-center p-4 mb-4 bg-primary text-white position-relative overflow-hidden">
                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-white opacity-10" style="transform: skewY(-10deg) translateY(-50%);"></div>
                    <div class="position-relative z-1">
                        <div class="bg-white p-1 rounded-circle d-inline-block mb-3 shadow">
                            <img src="<?= $ketua['foto'] ? base_url('assets/images/pengurus/'.$ketua['foto']) : 'https://ui-avatars.com/api/?name='.urlencode($ketua['nama']).'&background=random' ?>" class="rounded-circle" width="100" height="100" style="object-fit: cover;">
                        </div>
                        <h4 class="fw-bold mb-0"><?= $ketua['nama'] ?></h4>
                        <p class="mb-0 opacity-75 small"><?= $ketua_key ?></p>
                        <?php if($ketua['kontak']): ?>
                            <a href="https://wa.me/<?= $ketua['kontak'] ?>" target="_blank" class="btn btn-sm btn-light rounded-pill mt-3 text-primary fw-bold"><i class="bi bi-whatsapp me-1"></i> Kontak</a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Core Team Grid (Wakil, Sekretaris, Bendahara) -->
                <div class="row g-3 justify-content-center">
                    <?php 
                    $cores = ['WAKIL KETUA', 'SEKRETARIS', 'SEKRETARIS I', 'SEKRETARIS II', 'BENDAHARA', 'BENDAHARA I', 'BENDAHARA II'];
                    foreach($cores as $pos):
                        if(isset($struct_fkkmbt[$pos])):
                            foreach($struct_fkkmbt[$pos] as $staff):
                    ?>
                    <div class="col-6 col-md-4">
                        <div class="card border-0 shadow-sm rounded-4 h-100 text-center p-3">
                            <div class="mb-3">
                                <img src="<?= $staff['foto'] ? base_url('assets/images/pengurus/'.$staff['foto']) : 'https://ui-avatars.com/api/?name='.urlencode($staff['nama']).'&background=random' ?>" class="rounded-circle shadow-sm" width="60" height="60" style="object-fit: cover;">
                            </div>
                            <h6 class="fw-bold mb-1 small text-truncate"><?= $staff['nama'] ?></h6>
                            <span class="badge bg-light text-dark rounded-pill" style="font-size: 10px;"><?= $pos ?></span>
                        </div>
                    </div>
                    <?php 
                            endforeach;
                        endif;
                    endforeach; 
                    ?>
                </div>

                <!-- Seksi List -->
                <?php 
                $has_seksi = false;
                foreach($struct_fkkmbt as $key => $vals) {
                    if (strpos($key, 'SEKSI') !== false || strpos($key, 'BIDANG') !== false) {
                        $has_seksi = true;
                        break;
                    }
                }
                
                if($has_seksi):
                ?>
                <h6 class="fw-bold mt-5 mb-3 px-2 border-start border-4 border-warning ms-2 ps-3">Bidang & Seksi</h6>
                <div class="d-flex flex-column gap-3">
                    <?php 
                    foreach($struct_fkkmbt as $pos => $staffs): 
                        if (strpos($pos, 'SEKSI') === false && strpos($pos, 'BIDANG') === false) continue;
                        
                        // Icon mapping
                        $icon = 'bi-people';
                        $bg = 'bg-secondary-subtle text-secondary';
                        if(strpos($pos, 'KEAMANAN')!==false) { $icon='bi-shield-check'; $bg='bg-primary-subtle text-primary'; }
                        elseif(strpos($pos, 'KEBERSIHAN')!==false || strpos($pos, 'LINGKUNGAN')!==false) { $icon='bi-tree'; $bg='bg-success-subtle text-success'; }
                        elseif(strpos($pos, 'SOSIAL')!==false || strpos($pos, 'KESEJAHTERAAN')!==false) { $icon='bi-heart'; $bg='bg-danger-subtle text-danger'; }
                        elseif(strpos($pos, 'HUMAS')!==false) { $icon='bi-broadcast'; $bg='bg-warning-subtle text-warning-emphasis'; }
                        elseif(strpos($pos, 'ROHANI')!==false) { $icon='bi-book'; $bg='bg-info-subtle text-info'; }
                    ?>
                    <div class="card border-0 shadow-sm rounded-4 p-3">
                        <div class="d-flex flex-row align-items-center gap-3 mb-2">
                             <div class="<?= $bg ?> rounded-3 p-2">
                                <i class="bi <?= $icon ?> fs-4"></i>
                            </div>
                            <h6 class="fw-bold mb-0 text-uppercase"><?= $pos ?></h6>
                        </div>
                        <div class="ps-5">
                            <?php foreach($staffs as $s): ?>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <img src="<?= $s['foto'] ? base_url('assets/images/pengurus/'.$s['foto']) : 'https://ui-avatars.com/api/?name='.urlencode($s['nama']).'&background=random' ?>" class="rounded-circle" width="24" height="24">
                                <span class="small fw-medium"><?= $s['nama'] ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

            <?php endif; ?>
        </div>
        
        <!-- Tab FKKMMBT -->
        <div class="tab-pane fade" id="pills-fkkmmbt" role="tabpanel">
             <?php if(empty($struct_fkkmmbt)): ?>
                <div class="text-center py-5">
                    <div class="position-relative d-inline-block mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-5">
                            <i class="bi bi-people text-primary display-1"></i>
                        </div>
                        <span class="position-absolute bottom-0 end-0 badge bg-info text-white border border-white border-2 rounded-pill">Coming Soon</span>
                    </div>
                    <h4 class="fw-bold text-dark mb-2">Muda Mudi Belum Tersedia</h4>
                    <p class="text-muted small mx-auto" style="max-width: 300px;">
                        Data kepengurusan muda-mudi belum diinput.
                    </p>
                </div>
            <?php else: ?>
                 <!-- Copy similar logic or simplify for FKKMMBT -->
                 <div class="row g-3">
                    <?php foreach($struct_fkkmmbt as $pos => $staffs): ?>
                        <div class="col-12">
                            <h6 class="fw-bold mb-2 text-primary small text-uppercase"><?= $pos ?></h6>
                            <div class="row g-2">
                                <?php foreach($staffs as $s): ?>
                                <div class="col-6 col-md-4">
                                    <div class="card border-0 shadow-sm p-2 d-flex flex-row align-items-center gap-2">
                                        <img src="<?= $s['foto'] ? base_url('assets/images/pengurus/'.$s['foto']) : 'https://ui-avatars.com/api/?name='.urlencode($s['nama']).'&background=random' ?>" class="rounded-circle" width="32" height="32">
                                        <span class="small fw-bold text-truncate"><?= $s['nama'] ?></span>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <hr class="opacity-10 my-3">
                        </div>
                    <?php endforeach; ?>
                 </div>
            <?php endif; ?>
        </div>
    </div>
</div>
