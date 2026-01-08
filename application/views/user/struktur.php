<?php $this->load->view('user/templates/header'); ?>

<!-- Header with Gradient -->
<div class="header-section" style="background: linear-gradient(135deg, #022c22 0%, #14532d 100%); padding: 30px 20px 80px; color: white; border-radius: 0 0 30px 30px; position: relative; z-index: 1;">
    <div class="d-flex align-items-center gap-3">
        <a href="<?= base_url('user/dashboard') ?>" class="text-white text-decoration-none bg-white bg-opacity-10 rounded-circle p-2 d-flex align-items-center justify-content-center shadow-none" style="width: 40px; height: 40px; background: rgba(255,255,255,0.2);">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h5 class="fw-bold mb-0">Struktur <?= $title ?></h5>
    </div>
</div>

<main class="container py-4" style="margin-top: -60px; position: relative; z-index: 2;">
    
    <?php if(empty($pengurus)): ?>
        <div class="card border-0 shadow-sm rounded-4 text-center py-5">
            <div class="card-body">
                <i class="bi bi-diagram-3 fs-1 text-secondary opacity-50 mb-3 d-block"></i>
                <h6 class="fw-bold">Data Struktur Belum Tersedia</h6>
                <p class="text-muted small">Silakan hubungi admin untuk update data.</p>
            </div>
        </div>
    <?php else: ?>
        <div class="row g-3 justify-content-center">
            <?php foreach($pengurus as $p): ?>
                <?php 
                    // Level styling
                    $col_class = 'col-6 col-md-4'; // Default
                    if($p['level'] == 1) $col_class = 'col-12 col-md-6 mb-3'; // Ketua lebih besar
                    elseif($p['level'] == 2) $col_class = 'col-6 col-md-4 mb-2';
                    
                    // Card background based on level
                    $card_bg = ($p['level'] == 1) ? 'bg-white border-warning border-top border-4' : 'bg-white';
                    
                    // Avatar logic
                    $avatar_bg = ($p['jenis_kelamin'] == 'L') ? '0d6efd' : 'd63384'; // Blue for L, Pink for P
                    $foto_url = !empty($p['foto']) ? base_url('assets/uploads/struktur/'.$p['foto']) : "https://ui-avatars.com/api/?name=".urlencode($p['nama'])."&background=$avatar_bg&color=fff&size=128";
                ?>
                
                <div class="<?= $col_class ?>">
                    <div class="card border-0 shadow-sm rounded-4 h-100 text-center card-hover-effect overflow-hidden <?= $card_bg ?>" style="transition: transform 0.2s;">
                        <div class="card-body p-3 d-flex flex-column align-items-center justify-content-center">
                            <div class="mb-3 position-relative">
                                <img src="<?= $foto_url ?>" class="rounded-circle shadow-sm object-fit-cover" width="<?= ($p['level']==1)?'100':'80' ?>" height="<?= ($p['level']==1)?'100':'80' ?>" alt="<?= $p['nama'] ?>">
                                <div class="position-absolute bottom-0 end-0 bg-white rounded-circle p-1 shadow-sm" style="width: 24px; height: 24px;">
                                    <div class="bg-success rounded-circle w-100 h-100 border border-2 border-white"></div>
                                </div>
                            </div>
                            
                            <h6 class="fw-bold mb-1 <?= ($p['level']==1) ? 'fs-5' : 'small' ?>"><?= $p['nama'] ?></h6>
                            <span class="badge rounded-pill fw-normal px-3 py-2 mb-2 <?= ($p['level']==1) ? 'bg-warning text-dark' : 'bg-light text-secondary border' ?>">
                                <?= $p['jabatan'] ?>
                            </span>

                            <?php if(!empty($p['kontak'])): ?>
                                <a href="https://wa.me/<?= preg_replace('/^0/', '62', $p['kontak']) ?>" target="_blank" class="btn btn-sm btn-success rounded-pill w-100 mt-auto small">
                                    <i class="bi bi-whatsapp me-1"></i> WhatsApp
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <div class="mt-4 text-center">
        <small class="text-muted fst-italic">Data struktur organisasi update per <?= date('M Y') ?></small>
    </div>

</main>

<style>
/* Custom tree connecting lines (optional, simple CSS implementation) */
/* .card { position: relative; z-index: 2; } */
</style>

<?php $this->load->view('user/templates/footer'); ?>
