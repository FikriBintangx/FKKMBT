<?php $page_title = 'Tombol SOS'; ?>
<?php $this->load->view('user/templates/header'); ?>

<!-- Green Header -->
<div style="background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%); padding: 20px; color: white;">
    <div class="container">
        <a href="<?= base_url('user/dashboard') ?>" class="text-white text-decoration-none">
            <i class="bi bi-arrow-left me-2"></i>
        </a>
        <h4 class="fw-bold mb-1 mt-2">Tombol Darurat SOS</h4>
        <p class="mb-0 small opacity-75">Hubungi petugas keamanan segera</p>
    </div>
</div>

<main class="container py-4">
    <!-- Alert Messages -->
    <?php if ($this->session->flashdata('success_msg')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i><?= $this->session->flashdata('success_msg') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4 text-center">
            <div class="alert alert-danger mb-4">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>PERINGATAN!</strong> Gunakan tombol ini hanya untuk keadaan darurat.
            </div>
            
            <i class="bi bi-shield-exclamation fs-1 text-danger mb-3 d-block"></i>
            <h5 class="fw-bold mb-2">Tombol Darurat</h5>
            <p class="text-muted mb-4">Tekan tombol di bawah untuk mengirim sinyal darurat ke petugas keamanan dan admin RT.</p>
            
            <form action="<?= base_url('user/sos/send') ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengirim sinyal SOS?')">
                <button type="submit" class="btn btn-danger btn-lg px-5 py-3 rounded-pill">
                    <i class="bi bi-broadcast me-2"></i>
                    <strong>KIRIM SOS</strong>
                </button>
            </form>
            
            <div class="mt-4">
                <small class="text-muted">
                    <i class="bi bi-info-circle me-1"></i>
                    Petugas akan segera menghubungi Anda setelah SOS dikirim
                </small>
            </div>
        </div>
    </div>
    
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <h6 class="fw-bold mb-3">Kontak Darurat</h6>
            <div class="d-flex align-items-center mb-2">
                <i class="bi bi-telephone-fill text-success me-3"></i>
                <div>
                    <strong>Satpam:</strong> 0812-3456-7890
                </div>
            </div>
            <div class="d-flex align-items-center">
                <i class="bi bi-telephone-fill text-primary me-3"></i>
                <div>
                    <strong>Ketua RT:</strong> 087885873957
                </div>
            </div>
        </div>
    </div>
</main>

<?php $this->load->view('user/templates/footer'); ?>
