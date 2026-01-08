<?php $page_title = 'E-Surat Digital'; ?>
<?php $this->load->view('user/templates/header'); ?>

<!-- Green Header -->
<div style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); padding: 20px; color: white;">
    <div class="container">
        <a href="<?= base_url('user/dashboard') ?>" class="text-white text-decoration-none">
            <i class="bi bi-arrow-left me-2"></i>
        </a>
        <h4 class="fw-bold mb-1 mt-2">Layanan Surat Digital</h4>
        <p class="mb-0 small opacity-75">Ajukan permohonan surat secara online</p>
    </div>
</div>

<main class="container py-4">
    <div class="alert alert-info">
        <i class="bi bi-info-circle me-2"></i>
        <strong>Coming Soon!</strong> Fitur E-Surat sedang dalam pengembangan.
    </div>
    
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4 text-center">
            <i class="bi bi-envelope-paper fs-1 text-muted mb-3 d-block"></i>
            <h5 class="fw-bold mb-2">E-Surat Digital</h5>
            <p class="text-muted">Fitur ini akan segera hadir untuk memudahkan pengajuan surat online.</p>
        </div>
    </div>
</main>

<?php $this->load->view('user/templates/footer'); ?>
