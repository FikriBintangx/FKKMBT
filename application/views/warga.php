<div class="container py-4">
    <div class="text-center mb-5 mt-3">
        <span class="badge bg-success-subtle text-success rounded-pill mb-2 px-3 fw-bold">DATABASE</span>
        <h2 class="fw-bold display-6">Direktori Warga<br>Bukit Tiara</h2>
        <p class="text-muted mx-auto" style="max-width: 600px;">
            Cari lokasi blok dan informasi warga untuk keperluan silaturahmi atau pengiriman.
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

    <!-- Search & Filter Card -->
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-4">
        <div class="card-body p-4">
            <h6 class="fw-bold mb-3"><i class="bi bi-search me-2 text-primary"></i>Pencarian Cepat</h6>
            
            <div class="row g-3">
                <div class="col-12">
                     <select class="form-select form-select-lg bg-light border-0 rounded-4 fs-6" id="filterBlok">
                        <option value="all" selected>🏠 Tampilkan Semua Blok</option>
                        <option value="A">Blok A</option>
                        <option value="B">Blok B</option>
                        <option value="C">Blok C</option>
                        <option value="D">Blok D</option>
                        <option value="E">Blok E</option>
                    </select>
                </div>
                <div class="col-12">
                    <div class="position-relative">
                        <input type="text" class="form-control form-control-lg bg-light border-0 rounded-4 fs-6 ps-5" id="searchWarga" placeholder="Ketik nama atau nomor rumah...">
                        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Privacy Notice -->
    <div class="alert alert-light border shadow-sm rounded-4 d-flex align-items-center gap-3 p-3 mb-4" role="alert">
        <div class="bg-primary text-white rounded-circle p-2 flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
             <i class="bi bi-shield-lock-fill small"></i>
        </div>
        <div>
             <small class="text-muted d-block" style="line-height: 1.3;">
                <strong>Info Privasi:</strong> Detail kontak lengkap hanya dapat diakses oleh sesama warga yang sudah <a href="<?= base_url('auth/login') ?>" class="fw-bold text-decoration-none">login</a>.
             </small>
        </div>
    </div>

    <!-- List Warga (Card Style) -->
    <div id="wargaList" class="d-flex flex-column gap-3">
        <!-- Item 1 -->
        <div class="card border-0 shadow-sm rounded-4 w-100 warga-item" data-blok="A" data-info="a 01 ahmad fauzi">
            <div class="card-body p-3 d-flex align-items-center gap-3">
                <div class="bg-primary text-white rounded-3 d-flex flex-column align-items-center justify-content-center p-2" style="width: 50px; height: 50px;">
                    <small style="font-size: 8px; font-weight: 700;">BLOK</small>
                    <span class="fs-4 fw-bold lh-1">A</span>
                    <small style="font-size: 8px; font-weight: 700;">NO. 01</small>
                </div>
                <div class="flex-grow-1">
                    <h6 class="fw-bold text-dark mb-1">Bpk. Ahmad Fauzi</h6>
                    <span class="badge bg-success-subtle text-success rounded-pill" style="font-size: 10px;">Warga Tetap</span>
                </div>
                <button class="btn btn-light rounded-circle text-muted"><i class="bi bi-chevron-right"></i></button>
            </div>
        </div>

        <!-- Item 2 -->
        <div class="card border-0 shadow-sm rounded-4 w-100 warga-item" data-blok="B" data-info="b 12 dewi sartika">
            <div class="card-body p-3 d-flex align-items-center gap-3">
                <div class="bg-warning text-dark rounded-3 d-flex flex-column align-items-center justify-content-center p-2" style="width: 50px; height: 50px;">
                    <small style="font-size: 8px; font-weight: 700;">BLOK</small>
                    <span class="fs-4 fw-bold lh-1">B</span>
                    <small style="font-size: 8px; font-weight: 700;">NO. 12</small>
                </div>
                <div class="flex-grow-1">
                    <h6 class="fw-bold text-dark mb-1">Ibu Dewi Sartika</h6>
                    <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill" style="font-size: 10px;">Kontrak</span>
                </div>
                <button class="btn btn-light rounded-circle text-muted"><i class="bi bi-chevron-right"></i></button>
            </div>
        </div>

        <!-- Item 3 -->
        <div class="card border-0 shadow-sm rounded-4 w-100 warga-item" data-blok="C" data-info="c 05 joko widodo">
            <div class="card-body p-3 d-flex align-items-center gap-3">
                <div class="bg-info text-white rounded-3 d-flex flex-column align-items-center justify-content-center p-2" style="width: 50px; height: 50px;">
                    <small style="font-size: 8px; font-weight: 700;">BLOK</small>
                    <span class="fs-4 fw-bold lh-1">C</span>
                    <small style="font-size: 8px; font-weight: 700;">NO. 05</small>
                </div>
                <div class="flex-grow-1">
                    <h6 class="fw-bold text-dark mb-1">Bpk. Joko Widodo</h6>
                    <span class="badge bg-success-subtle text-success rounded-pill" style="font-size: 10px;">Warga Tetap</span>
                </div>
                <button class="btn btn-light rounded-circle text-muted"><i class="bi bi-chevron-right"></i></button>
            </div>
        </div>
    </div>
    
    <!-- No Results -->
    <div id="noResults" class="text-center py-5 d-none">
        <div class="bg-light rounded-circle d-inline-flex p-4 mb-3 text-muted">
            <i class="bi bi-search fs-1 opacity-50"></i>
        </div>
        <h6 class="fw-bold text-dark">Warga Tidak Ditemukan</h6>
        <p class="text-muted small">Coba kata kunci atau blok lain.</p>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterBlok = document.getElementById('filterBlok');
    const searchWarga = document.getElementById('searchWarga');
    const listItems = document.querySelectorAll('.warga-item');
    const noResults = document.getElementById('noResults');

    function filterList() {
        const blokValue = filterBlok.value;
        const searchValue = searchWarga.value.toLowerCase();
        let visibleCount = 0;

        listItems.forEach(item => {
            const itemBlok = item.getAttribute('data-blok');
            const itemInfo = item.getAttribute('data-info'); 

            const matchBlok = (blokValue === 'all' || itemBlok === blokValue);
            const matchSearch = itemInfo.includes(searchValue);

            if (matchBlok && matchSearch) {
                item.classList.remove('d-none');
                visibleCount++;
            } else {
                item.classList.add('d-none');
            }
        });

        if (visibleCount === 0) {
            noResults.classList.remove('d-none');
        } else {
            noResults.classList.add('d-none');
        }
    }

    filterBlok.addEventListener('change', filterList);
    searchWarga.addEventListener('keyup', filterList);
});
</script>
