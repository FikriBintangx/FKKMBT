<!-- Footer Component -->
<footer class="mt-auto text-white position-relative overflow-hidden" style="background: linear-gradient(180deg, #1e5631 0%, #064e3b 100%); z-index: 10;">
    
    <!-- Decorative Top Wave/Border -->
    <div style="height: 1px; background: rgba(255,255,255,0.1); width: 100%;"></div>

    <div class="container pt-5 pb-2">
        <div class="row g-4 justify-content-between">
            
            <!-- Brand Column -->
            <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="bg-white p-1 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <img src="<?= base_url('assets/images/LOGO/LOGOFKKMBT.jpg') ?>" class="rounded-circle" style="width: 42px; height: 42px; object-fit: cover;">
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0 text-white" style="letter-spacing: -0.5px;">FKKMBT</h5>
                        <small class="text-white opacity-75" style="letter-spacing: 1px; font-size: 0.75rem;">BUKIT TIARA</small>
                    </div>
                </div>
                <p class="text-white opacity-75 mb-4" style="line-height: 1.7; font-size: 0.95rem;">
                    Wadah silaturahmi dan koordinasi warga untuk menciptakan lingkungan yang aman, nyaman, dan harmonis.
                </p>
                <div class="d-flex gap-2">
                    <a href="#" class="btn btn-outline-light btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; border-color: rgba(255,255,255,0.2);"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="btn btn-outline-light btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; border-color: rgba(255,255,255,0.2);"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="btn btn-outline-light btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; border-color: rgba(255,255,255,0.2);"><i class="bi bi-youtube"></i></a>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="col-6 col-lg-2 col-md-3 mb-4 mb-lg-0">
                <h6 class="fw-bold text-warning mb-4 text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px;">Akses Cepat</h6>
                <ul class="list-unstyled d-flex flex-column gap-3 mb-0">
                    <li><a href="<?= base_url() ?>" class="text-white text-decoration-none hover-link">Beranda</a></li>
                    <li><a href="<?= base_url('tentang') ?>" class="text-white text-decoration-none hover-link">Tentang Kami</a></li>
                    <li><a href="<?= base_url('kegiatan') ?>" class="text-white text-decoration-none hover-link">Kegiatan</a></li>
                    <li><a href="<?= base_url('warga') ?>" class="text-white text-decoration-none hover-link">Direktori</a></li>
                </ul>
            </div>

            <!-- Utility Links -->
            <div class="col-6 col-lg-2 col-md-3 mb-4 mb-lg-0">
                <h6 class="fw-bold text-warning mb-4 text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px;">Layanan</h6>
                <ul class="list-unstyled d-flex flex-column gap-3 mb-0">
                    <li><a href="<?= base_url('auth/login') ?>" class="text-white text-decoration-none hover-link">Portal Warga</a></li>
                    <li><a href="<?= base_url('iuran') ?>" class="text-white text-decoration-none hover-link">Info Iuran</a></li>
                    <li><a href="<?= base_url('struktur') ?>" class="text-white text-decoration-none hover-link">Pengurus</a></li>
                    <li><a href="#" class="text-white text-decoration-none hover-link">Bantuan</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-3 col-md-12">
                <h6 class="fw-bold text-warning mb-4 text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px;">Hubungi Kami</h6>
                <ul class="list-unstyled d-flex flex-column gap-3">
                    <li class="d-flex gap-3">
                        <i class="bi bi-geo-alt-fill text-white opacity-50 mt-1"></i>
                        <span class="text-white opacity-75 small" style="line-height: 1.6;">Perumahan Bukit Tiara,<br>Cikupa, Tangerang, Banten</span>
                    </li>
                    <li class="d-flex gap-3">
                        <i class="bi bi-telephone-fill text-white opacity-50"></i>
                        <span class="text-white opacity-75 small">0877-8672-0942 (Humas)</span>
                    </li>
                    <li class="d-flex gap-3">
                        <i class="bi bi-envelope-fill text-white opacity-50"></i>
                        <span class="text-white opacity-75 small">info@fkkmbt.or.id</span>
                    </li>
                </ul>
            </div>
        </div>

        <hr class="my-5" style="border-color: rgba(255,255,255,0.1);">

        <!-- Bottom Copyright -->
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                <p class="mb-0 small text-white opacity-50">
                    &copy; <?= date('Y') ?> FKKMBT. All rights reserved.
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <p class="mb-0 small text-white opacity-50">
                    Developed with <i class="bi bi-heart-fill text-danger mx-1" style="font-size: 10px;"></i> by <span class="text-white fw-bold">Ceva_Star</span>
                </p>
            </div>
        </div>
    </div>
    
    <!-- Mobile Bottom Nav Spacer -->
    <div class="d-lg-none" style="height: 80px;"></div>
</footer>

<!-- Floating Action Buttons Container (Panic & Up) -->
<div class="position-fixed end-0 bottom-0 p-3 d-flex flex-column gap-3" style="z-index: 1050; padding-bottom: 90px !important;">
    <!-- Desktop Panic Button -->
    <button class="btn btn-danger rounded-circle shadow-lg d-none d-lg-flex align-items-center justify-content-center shake-animation" style="width: 56px; height: 56px; border: 4px solid rgba(255,255,255,0.3);" data-bs-toggle="modal" data-bs-target="#panicModal" title="Tombol Darurat">
        <i class="bi bi-exclamation-triangle-fill fs-4"></i>
    </button>
</div>

<!-- Mobile Panic Button (Fixed Position above Nav) -->
<div class="fixed-bottom d-lg-none" style="bottom: 80px; right: 20px; left: auto; z-index: 1040;">
    <button class="btn btn-danger rounded-circle shadow-lg d-flex align-items-center justify-content-center shake-animation" style="width: 50px; height: 50px; border: 3px solid rgba(255,255,255,0.3);" data-bs-toggle="modal" data-bs-target="#panicModal">
        <i class="bi bi-exclamation-triangle-fill fs-4"></i>
    </button>
</div>

<!-- Panic Modal -->
<div class="modal fade" id="panicModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-bottom">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px 20px 0 0;">
            <div class="modal-header border-0 pb-0 justify-content-center">
                <div style="width: 40px; height: 4px; background: #e2e8f0; border-radius: 10px;"></div>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="bg-danger-subtle text-danger rounded-circle d-inline-flex p-3 mb-3">
                    <i class="bi bi-shield-exclamation fs-1"></i>
                </div>
                <h5 class="fw-bold mb-2">DARURAT</h5>
                <p class="text-muted small mb-4">Segera hubungi bantuan jika Anda dalam keadaan darurat.</p>
                
                <div class="d-grid gap-3">
                    <a href="tel:112" class="btn btn-light btn-lg d-flex align-items-center justify-content-between p-3 border">
                        <span class="d-flex align-items-center gap-3">
                            <i class="bi bi-telephone-fill text-danger"></i> Darurat Umum
                        </span>
                        <span class="fw-bold text-dark">112</span>
                    </a>
                        <a href="tel:081234567890" class="btn btn-dark btn-lg d-flex align-items-center justify-content-between p-3">
                        <span class="d-flex align-items-center gap-3">
                            <i class="bi bi-person-badge-fill"></i> Satpam / Security
                        </span>
                        <span class="fw-bold">Call Pos</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-link { transition: all 0.2s; opacity: 0.75; }
    .hover-link:hover { opacity: 1; padding-left: 5px; color: #fff !important; }
    
    .shake-animation {
        animation: shake 5s cubic-bezier(.36,.07,.19,.97) both infinite;
        transform: translate3d(0, 0, 0);
    }
    @keyframes shake {
        1%, 9% { transform: translate3d(-1px, 0, 0); }
        2%, 8% { transform: translate3d(2px, 0, 0); }
        3%, 5%, 7% { transform: translate3d(-4px, 0, 0); }
        4%, 6% { transform: translate3d(4px, 0, 0); }
        10%, 100% { transform: translate3d(0, 0, 0); }
    }
    .modal-dialog-bottom { margin: 0; display: flex; align-items: flex-end; min-height: 100%; }
    .modal.fade .modal-dialog-bottom { transform: translate(0, 100%); }
    .modal.show .modal-dialog-bottom { transform: none; transition: transform 0.3s ease-out; }
</style>

<!-- Init AOS if not already -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    if(typeof AOS !== 'undefined') {
        AOS.init({ duration: 800, once: true });
    }
</script>
</body>
</html>
