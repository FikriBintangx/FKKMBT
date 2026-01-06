<div class="container py-5">
    <div class="text-center mb-5">
        <h6 class="text-primary fw-bold text-uppercase">Data Kependudukan</h6>
        <h1 class="fw-bold">Direktori Warga</h1>
        <p class="text-muted col-lg-8 mx-auto">Cari informasi lokasi unit rumah dan warga di Perumahan Bukit Tiara.</p>
    </div>

    <div class="card border-0 shadow-sm p-4">
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label fw-bold">Pilih Blok</label>
                <select class="form-select">
                    <option selected>Semua Blok</option>
                    <option value="A">Blok A</option>
                    <option value="B">Blok B</option>
                    <option value="C">Blok C</option>
                    <!-- Add more blocks as needed -->
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Cari Nama / Nomor Rumah</label>
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Ketik nama warga atau nomor rumah...">
                    <button class="btn btn-primary"><i class="bi bi-search"></i> Cari</button>
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
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Blok</th>
                        <th>Nomor</th>
                        <th>Nama Kepala Keluarga</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Static Dummy Data -->
                    <tr>
                        <td>A</td>
                        <td>01</td>
                        <td>Bpk. Ahmad Fauzi</td>
                        <td><span class="badge bg-success">Tetap</span></td>
                    </tr>
                    <tr>
                        <td>A</td>
                        <td>02</td>
                        <td>Bpk. Budi Santoso</td>
                        <td><span class="badge bg-success">Tetap</span></td>
                    </tr>
                    <tr>
                        <td>B</td>
                        <td>10</td>
                        <td>Ibu Siti Aminah</td>
                        <td><span class="badge bg-warning text-dark">Kontrak</span></td>
                    </tr>
                    <tr>
                        <td>C</td>
                        <td>05</td>
                        <td>Bpk. Joko Widodo</td>
                        <td><span class="badge bg-success">Tetap</span></td>
                    </tr>
                </tbody>
            </table>
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
