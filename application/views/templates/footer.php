    <!-- Footer -->
    <footer class="mt-auto pt-5 pb-3 text-white" style="margin-top: 50px !important; background: linear-gradient(135deg, #1e5631 0%, #0d3820 100%);">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <img src="<?= base_url('assets/images/LOGO/LOGOFKKMBT.jpg') ?>" class="rounded-circle border border-white" style="width: 40px; height: 40px;">
                        <strong class="fs-5 text-white">FKKMBT</strong>
                    </div>
                    <!-- CHANGED: Replaced 'text-white-50' with 'text-white' -->
                    <p class="text-white small" style="line-height: 1.6; opacity: 1 !important;">Forum Komunikasi Koordinasi Masyarakat Bukit Tiara - Membangun komunitas yang harmonis, sejahtera, dan saling mendukung.</p>
                </div>
                
                <div class="col-md-2">
                    <h6 class="text-white mb-3 fw-bold text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px;">Menu Cepat</h6>
                    <ul class="list-unstyled d-flex flex-column gap-2">
                        <!-- CHANGED: Replaced 'text-white-50' with 'text-white' -->
                        <li><a href="<?= base_url('tentang') ?>" class="text-white text-decoration-none hover-white" style="opacity: 1;">Tentang Kami</a></li>
                        <li><a href="<?= base_url('kegiatan') ?>" class="text-white text-decoration-none hover-white" style="opacity: 1;">Kegiatan</a></li>
                        <li><a href="<?= base_url('struktur') ?>" class="text-white text-decoration-none hover-white" style="opacity: 1;">Organisasi</a></li>
                    </ul>
                </div>
                
                <div class="col-md-3">
                    <h6 class="text-white mb-3 fw-bold text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px;">Organisasi</h6>
                    <ul class="list-unstyled d-flex flex-column gap-2">
                        <!-- CHANGED: Replaced 'text-white-50' with 'text-white' -->
                        <li><a href="<?= base_url('struktur?tab=fkkmbt') ?>" class="text-white text-decoration-none hover-white" style="opacity: 1;">Struktur FKKMBT</a></li>
                        <li><a href="<?= base_url('struktur?tab=fkkmmbt') ?>" class="text-white text-decoration-none hover-white" style="opacity: 1;">Struktur FKKMMBT</a></li>
                    </ul>
                </div>
                
                <div class="col-md-3">
                    <h6 class="text-white mb-3 fw-bold text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px;">Kontak</h6>
                    <!-- CHANGED: Replaced 'text-white-50' with 'text-white' -->
                    <p class="text-white small mb-2" style="opacity: 1;">
                        <i class="bi bi-geo-alt me-2 text-white"></i>
                        Perumahan Bukit Tiara, Cikupa, Tangerang
                    </p>
                    <p class="text-white small mb-2" style="opacity: 1;">
                        <i class="bi bi-whatsapp me-2 text-white"></i>
                        0877-8672-0942
                    </p>
                </div>
            </div>
            
            <hr class="my-4 border-white opacity-100">
            
            <!-- CHANGED: Replaced 'text-white-50' with 'text-white' -->
            <div class="text-center text-white small">
                <p class="mb-0">&copy; 2025 FKKMBT. Developed by Ceva_Star.</p>
            </div>
        </div>
        
        <!-- Bottom Spacer for Mobile Nav -->
        <div class="d-lg-none" style="height: 60px;"></div>
    </footer>

    <!-- Panic Button & Modal - Same as before -->
    <div class="fixed-bottom p-4 d-none d-lg-block" style="z-index: 1050; pointer-events: none;">
        <div class="text-end" style="pointer-events: auto;">
            <button class="btn btn-danger rounded-circle shadow-lg d-flex align-items-center justify-content-center shake-animation" style="width: 60px; height: 60px; border: 4px solid rgba(255,255,255,0.3);" data-bs-toggle="modal" data-bs-target="#panicModal">
                <i class="bi bi-exclamation-triangle-fill fs-3"></i>
            </button>
        </div>
    </div>

    <!-- Mobile Panic Button (Adjusted Position) -->
    <div class="fixed-bottom p-3 d-lg-none" style="z-index: 1040; pointer-events: none; bottom: 70px;">
        <div class="text-end" style="pointer-events: auto;">
             <button class="btn btn-danger rounded-circle shadow-lg d-flex align-items-center justify-content-center shake-animation" style="width: 50px; height: 50px; border: 3px solid rgba(255,255,255,0.3);" data-bs-toggle="modal" data-bs-target="#panicModal">
                <i class="bi bi-exclamation-triangle-fill fs-4"></i>
            </button>
        </div>
    </div>


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
        .hover-white:hover { color: white !important; }
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

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });
    </script>
</body>
</html>
