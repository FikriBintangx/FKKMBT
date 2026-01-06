    <!-- Footer -->
    <footer class="mt-auto pt-5 pb-3 bg-dark text-white" style="margin-top: 100px !important;">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="bg-white text-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-weight: bold;">F</div>
                        <strong class="fs-5">FKKMBT</strong>
                    </div>
                    <p class="text-white-50 small">Forum Komunikasi Koordinasi Masyarakat Bukit Tiara - Membangun komunitas yang harmonis, sejahtera, dan saling mendukung.</p>
                </div>
                
                <div class="col-md-2">
                    <h6 class="text-white mb-3">Menu Cepat</h6>
                    <ul class="list-unstyled">
                        <li><a href="<?= base_url('tentang') ?>" class="text-white-50 text-decoration-none">Tentang Kami</a></li>
                        <li><a href="<?= base_url('kegiatan') ?>" class="text-white-50 text-decoration-none">Kegiatan</a></li>
                        <li><a href="<?= base_url('struktur') ?>" class="text-white-50 text-decoration-none">Organisasi</a></li>
                    </ul>
                </div>
                
                <div class="col-md-3">
                    <h6 class="text-white mb-3">Organisasi</h6>
                    <ul class="list-unstyled">
                        <li><a href="<?= base_url('struktur?tab=fkkmbt') ?>" class="text-white-50 text-decoration-none">Struktur FKKMBT</a></li>
                        <li><a href="<?= base_url('struktur?tab=fkkmmbt') ?>" class="text-white-50 text-decoration-none">Struktur FKKMMBT</a></li>
                    </ul>
                </div>
                
                <div class="col-md-3">
                    <h6 class="text-white mb-3">Kontak</h6>
                    <p class="text-white-50 small mb-2">
                        <i class="bi bi-geo-alt me-2"></i>
                        Perumahan Bukit Tiara, Kecamatan Cikupa, Kabupaten Tangerang, Banten 15710
                    </p>
                    <p class="text-white-50 small mb-2">
                        <i class="bi bi-telephone me-2"></i>
                        087786720942
                    </p>
                </div>
            </div>
            
            <hr class="my-4 border-secondary">
            
            <div class="text-center text-white-50 small">
                <p class="mb-0">&copy; 2025 FKKMBT. Developed by Ceva_Star.</p>
            </div>
        </div>
    </footer>

    <!-- Panic Button & Modal -->
    <div class="fixed-bottom p-4" style="z-index: 1050; pointer-events: none;">
        <div class="text-end" style="pointer-events: auto;">
            <button class="btn btn-danger rounded-circle shadow-lg d-flex align-items-center justify-content-center shake-animation" style="width: 60px; height: 60px;" data-bs-toggle="modal" data-bs-target="#panicModal">
                <i class="bi bi-exclamation-triangle-fill fs-3"></i>
            </button>
        </div>
    </div>

    <div class="modal fade" id="panicModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                <div class="modal-header bg-danger text-white border-0">
                    <h5 class="modal-title fw-bold"><i class="bi bi-shield-exclamation me-2"></i>DARURAT / EMERGENCY</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-muted text-center mb-4">Tekan tombol di bawah untuk menghubungi nomor darurat.</p>
                    <div class="d-grid gap-3">
                        <a href="tel:112" class="btn btn-outline-danger btn-lg d-flex align-items-center justify-content-between">
                            <span><i class="bi bi-telephone-fill me-2"></i>Panggilan Darurat Umum</span>
                            <span class="fw-bold">112</span>
                        </a>
                        <a href="tel:110" class="btn btn-outline-warning text-dark btn-lg d-flex align-items-center justify-content-between">
                            <span><i class="bi bi-shield-fill me-2"></i>Polisi</span>
                            <span class="fw-bold">110</span>
                        </a>
                        <a href="tel:113" class="btn btn-outline-danger btn-lg d-flex align-items-center justify-content-between">
                            <span><i class="bi bi-fire me-2"></i>Pemadam Kebakaran</span>
                            <span class="fw-bold">113</span>
                        </a>
                        <a href="tel:118" class="btn btn-outline-success btn-lg d-flex align-items-center justify-content-between">
                            <span><i class="bi bi-hospital-fill me-2"></i>Ambulans</span>
                            <span class="fw-bold">118</span>
                        </a>
                         <a href="tel:081234567890" class="btn btn-dark btn-lg d-flex align-items-center justify-content-between">
                            <span><i class="bi bi-person-badge-fill me-2"></i>Satpam / Security</span>
                            <span class="fw-bold">Hubungi Pos</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
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
