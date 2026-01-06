<div class="container py-5">
    <div class="text-center mb-5">
        <h6 class="text-primary fw-bold text-uppercase">Data Kependudukan</h6>
        <h1 class="fw-bold"><i class="bi bi-house-heart-fill me-2 text-danger"></i>Direktori Warga</h1>
        <p class="text-muted col-lg-8 mx-auto">Cari informasi lokasi unit rumah dan warga di Perumahan Bukit Tiara.</p>
    </div>

    <div class="card border-0 shadow-sm p-4">
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label fw-bold">Pilih Blok</label>
                <select class="form-select" id="filterBlok">
                    <option value="all" selected>Semua Blok</option>
                    <option value="A">Blok A</option>
                    <option value="B">Blok B</option>
                    <option value="C">Blok C</option>
                    <option value="D">Blok D</option>
                    <option value="E">Blok E</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Cari Nama / Nomor Rumah</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" class="form-control border-start-0 ps-0" id="searchWarga" placeholder="Ketik nama warga atau nomor rumah...">
                </div>
            </div>
        </div>

        <div class="alert alert-info d-flex align-items-center" role="alert">
            <i class="bi bi-info-circle-fill me-2 fs-4"></i>
            <div>
                Untuk alasan privasi, detail lengkap data warga hanya dapat diakses oleh warga yang sudah login.
            </div>
        </div>

        <div class="table-responsive mt-3">
            <table class="table table-striped table-hover align-middle" id="tableWarga">
                <thead class="table-dark">
                    <tr>
                        <th>Blok</th>
                        <th>Nomor</th>
                        <th>Nama Kepala Keluarga</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dummy Data with Data Attributes for Filtering -->
                    <tr class="warga-row" data-blok="A" data-info="a 01 ahmad fauzi">
                        <td><span class="badge bg-secondary">Blok A</span></td>
                        <td class="fw-bold">01</td>
                        <td>Bpk. Ahmad Fauzi</td>
                        <td><span class="badge bg-success">Tetap</span></td>
                    </tr>
                    <tr class="warga-row" data-blok="A" data-info="a 02 budi santoso">
                        <td><span class="badge bg-secondary">Blok A</span></td>
                        <td class="fw-bold">02</td>
                        <td>Bpk. Budi Santoso</td>
                        <td><span class="badge bg-success">Tetap</span></td>
                    </tr>
                    <tr class="warga-row" data-blok="A" data-info="a 05 charlie chaplin">
                        <td><span class="badge bg-secondary">Blok A</span></td>
                        <td class="fw-bold">05</td>
                        <td>Bpk. Charlie Chaplin</td>
                        <td><span class="badge bg-warning text-dark">Kontrak</span></td>
                    </tr>
                    <tr class="warga-row" data-blok="B" data-info="b 10 siti aminah">
                        <td><span class="badge bg-info text-dark">Blok B</span></td>
                        <td class="fw-bold">10</td>
                        <td>Ibu Siti Aminah</td>
                        <td><span class="badge bg-warning text-dark">Kontrak</span></td>
                    </tr>
                    <tr class="warga-row" data-blok="B" data-info="b 12 dewi sartika">
                        <td><span class="badge bg-info text-dark">Blok B</span></td>
                        <td class="fw-bold">12</td>
                        <td>Ibu Dewi Sartika</td>
                        <td><span class="badge bg-success">Tetap</span></td>
                    </tr>
                    <tr class="warga-row" data-blok="C" data-info="c 05 joko widodo">
                        <td><span class="badge bg-primary">Blok C</span></td>
                        <td class="fw-bold">05</td>
                        <td>Bpk. Joko Widodo</td>
                        <td><span class="badge bg-success">Tetap</span></td>
                    </tr>
                    <tr class="warga-row" data-blok="C" data-info="c 08 susi susanti">
                        <td><span class="badge bg-primary">Blok C</span></td>
                        <td class="fw-bold">08</td>
                        <td>Ibu Susi Susanti</td>
                        <td><span class="badge bg-success">Tetap</span></td>
                    </tr>
                     <tr class="warga-row" data-blok="D" data-info="d 01 deddy corbuzier">
                        <td><span class="badge bg-danger">Blok D</span></td>
                        <td class="fw-bold">01</td>
                        <td>Bpk. Deddy Corbuzier</td>
                        <td><span class="badge bg-success">Tetap</span></td>
                    </tr>
                    <tr class="warga-row" data-blok="E" data-info="e 22 erick thohir">
                        <td><span class="badge bg-warning text-dark">Blok E</span></td>
                        <td class="fw-bold">22</td>
                        <td>Bpk. Erick Thohir</td>
                        <td><span class="badge bg-success">Tetap</span></td>
                    </tr>
                </tbody>
            </table>
            <!-- No Results Message -->
            <div id="noResults" class="text-center py-5 d-none">
                <i class="bi bi-search display-1 text-muted opacity-25"></i>
                <p class="text-muted mt-3">Data tidak ditemukan.</p>
            </div>
        </div>
        
        <nav aria-label="Page navigation" class="mt-4">
            <ul class="pagination justify-content-center">
                <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterBlok = document.getElementById('filterBlok');
    const searchWarga = document.getElementById('searchWarga');
    const tableRows = document.querySelectorAll('.warga-row');
    const noResults = document.getElementById('noResults');

    function filterTable() {
        const blokValue = filterBlok.value;
        const searchValue = searchWarga.value.toLowerCase();
        let visibleCount = 0;

        tableRows.forEach(row => {
            const rowBlok = row.getAttribute('data-blok');
            const rowInfo = row.getAttribute('data-info'); // Contains combined text for easier searching

            const matchBlok = (blokValue === 'all' || rowBlok === blokValue);
            const matchSearch = rowInfo.includes(searchValue);

            if (matchBlok && matchSearch) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        if (visibleCount === 0) {
            noResults.classList.remove('d-none');
        } else {
            noResults.classList.add('d-none');
        }
    }

    filterBlok.addEventListener('change', filterTable);
    searchWarga.addEventListener('keyup', filterTable);
});
</script>
