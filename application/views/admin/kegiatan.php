<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Kelola Kegiatan - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin-mobile.css') ?>">
    <style>
        .upload-area {
            border: 2px dashed #cbd5e1; border-radius: 12px; padding: 20px;
            text-align: center; transition: all 0.3s; background: #f8fafc; cursor: pointer;
        }
        .upload-area:hover { border-color: #16a34a; background: #f0fdf4; }
        .preview-container { display: flex; gap: 10px; overflow-x: auto; padding-top: 10px; }
        .preview-item, .existing-item {
            width: 70px; height: 70px; border-radius: 8px; object-fit: cover; border: 1px solid #ddd; flex-shrink: 0;
        }
        .existing-wrapper { position: relative; width: 70px; height: 70px; flex-shrink: 0; }
        .btn-del-img {
            position: absolute; top: -5px; right: -5px; width: 20px; height: 20px;
            background: red; color: white; border-radius: 50%; font-size: 10px;
            display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 10; text-decoration: none;
        }
        .cal-cell:hover { background-color: #f0fdf4; cursor: pointer; }
    </style>
</head>
<body class="bg-light">

    <?php $this->load->view('admin/templates/navbar'); ?>

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-column flex-md-row align-items-start gap-3">
            <div>
                 <h3 class="fw-bold m-0 text-success"><i class="bi bi-calendar2-week-fill me-2"></i>Agenda Kegiatan</h3>
                 <p class="text-muted m-0">Jadwal dan dokumentasi kegiatan warga</p>
            </div>
            <div class="d-flex gap-2 w-100 w-md-auto">
                <button class="btn btn-outline-success d-none d-md-block" onclick="toggleCalendar()"><i class="bi bi-calendar3 me-2"></i>Kalender</button>
                <button class="btn btn-primary flex-fill rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="bi bi-plus-lg me-2"></i> Tambah Kegiatan
                </button>
            </div>
        </div>

        <?php if ($this->session->flashdata('success_msg')): ?>
        <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm rounded-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i><?= $this->session->flashdata('success_msg') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <!-- ADMIN INTERACTIVE CALENDAR (Desktop Only) -->
        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden d-none d-md-block" id="calendarSection">
            <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between">
                <h6 class="fw-bold m-0 text-success">Kalender <?= date('F Y') ?></h6>
                <small class="text-muted">Klik tanggal untuk input cepat</small>
            </div>
            <div class="card-body p-0">
                <?php
                $month = date('m'); $year = date('Y');
                $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                $firstDay = date('N', strtotime("$year-$month-01"));
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered text-center m-0" style="table-layout: fixed;">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-secondary small py-2">SEN</th><th class="text-secondary small py-2">SEL</th>
                                <th class="text-secondary small py-2">RAB</th><th class="text-secondary small py-2">KAM</th>
                                <th class="text-secondary small py-2">JUM</th><th class="text-danger small py-2">SAB</th><th class="text-danger small py-2">MIN</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <?php
                            $offset = 0; $dayCount = 1;
                            for ($i=1; $i<$firstDay; $i++) { echo "<td class='bg-light'></td>"; $offset++; }
                            while ($dayCount <= $daysInMonth) {
                                $dStr = sprintf('%04d-%02d-%02d', $year, $month, $dayCount);
                                $hasEvent = isset($activity_dates[$dStr]);
                                $bg = $hasEvent ? 'bg-success-subtle' : '';
                                
                                echo "<td class='cal-cell $bg p-1 position-relative' style='height:80px; vertical-align:top;' onclick='openAddModal(\"$dStr\")'>";
                                echo "<div class='d-flex justify-content-between p-1'>";
                                echo "<span class='small fw-bold ".($dStr == date('Y-m-d') ? 'text-primary' : 'text-muted')."'>$dayCount</span>";
                                if($hasEvent) echo "<i class='bi bi-circle-fill text-success' style='font-size:6px;'></i>";
                                echo "</div>";
                                if($hasEvent) echo "<div class='text-center mt-1'><span class='badge bg-success' style='font-size:8px'>Ada Kegiatan</span></div>";
                                echo "</td>";
                                
                                $offset++; $dayCount++;
                                if ($offset % 7 == 0) echo "</tr><tr>";
                            }
                            while ($offset % 7 != 0) { echo "<td class='bg-light'></td>"; $offset++; }
                            ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- LIST VIEW (Mobile Optimized) -->
        <div class="card border-0 shadow-sm rounded-4 d-none d-md-block">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3" width="15%">TANGGAL</th>
                                <th width="15%">MEDIA</th>
                                <th width="30%">DETAIL KEGIATAN</th>
                                <th>DESKRIPSI</th>
                                <th class="text-end pe-4">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($kegiatan_list)): ?>
                                <?php foreach($kegiatan_list as $row): ?>
                                    <?php 
                                        $thumbnail = $row['foto'];
                                        $isVideo = (strpos($thumbnail, '.mp4') !== false || strpos($thumbnail, '.mov') !== false);
                                    ?>
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold"><?= date('d M', strtotime($row['tanggal'])) ?></div>
                                        <div class="text-muted small"><?= date('Y', strtotime($row['tanggal'])) ?></div>
                                    </td>
                                    <td>
                                        <div class="position-relative d-inline-block">
                                            <?php if($thumbnail): ?>
                                                <?php if($isVideo): ?>
                                                    <div class="bg-dark text-white rounded-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                        <i class="bi bi-play-circle-fill"></i>
                                                    </div>
                                                <?php else: ?>
                                                    <img src="<?= base_url('assets/images/kegiatan/'.$thumbnail) ?>" class="rounded-3 shadow-sm object-fit-cover" style="width: 60px; height: 60px;">
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <div class="bg-light text-muted rounded-3 d-flex align-items-center justify-content-center border" style="width: 60px; height: 60px;">
                                                    <i class="bi bi-image"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark"><?= $row['judul'] ?></div>
                                        <span class="badge bg-primary-subtle text-primary rounded-pill mt-1" style="font-size: 10px;">
                                            <?= $row['nama_organisasi'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-muted small text-truncate d-block" style="max-width: 300px;">
                                            <?= substr($row['deskripsi'], 0, 100) ?>...
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-light text-primary btn-sm rounded-circle shadow-sm me-1" onclick='openEdit(<?= json_encode($row) ?>)'><i class="bi bi-pencil-fill"></i></button>
                                        <a href="<?= base_url('admin/kegiatan/delete/'.$row['id']) ?>" class="btn btn-light text-danger btn-sm rounded-circle shadow-sm" onclick="return confirm('Hapus kegiatan ini?')" title="Hapus"><i class="bi bi-trash-fill"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="5" class="text-center py-5 text-muted">Belum ada data kegiatan.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- MOBILE CARDS -->
        <div class="d-md-none d-flex flex-column gap-3">
             <?php if(!empty($kegiatan_list)): ?>
                <?php foreach($kegiatan_list as $row): ?>
                     <?php 
                        $thumbnail = $row['foto'];
                        $isVideo = (strpos($thumbnail, '.mp4') !== false || strpos($thumbnail, '.mov') !== false);
                    ?>
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-body p-3">
                        <div class="d-flex gap-3 mb-3">
                            <div class="bg-light border rounded-3 text-center p-2" style="width: 60px; height: 60px;">
                                <span class="d-block fw-bold text-dark h5 mb-0"><?= date('d', strtotime($row['tanggal'])) ?></span>
                                <span class="d-block text-muted small" style="font-size: 10px;"><?= date('M', strtotime($row['tanggal'])) ?></span>
                            </div>
                            <div class="flex-grow-1">
                                <span class="badge bg-primary-subtle text-primary rounded-pill mb-1"><?= $row['nama_organisasi'] ?></span>
                                <h6 class="fw-bold mb-1 text-dark text-truncate"><?= $row['judul'] ?></h6>
                                <p class="small text-muted mb-0" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"><?= $row['deskripsi'] ?></p>
                            </div>
                        </div>
                        
                        <?php if($thumbnail): ?>
                        <div class="mb-3">
                            <?php if($isVideo): ?>
                                 <div class="bg-dark text-white rounded-3 d-flex align-items-center justify-content-center" style="height: 120px;">
                                    <i class="bi bi-play-circle-fill fs-1"></i>
                                </div>
                            <?php else: ?>
                                <img src="<?= base_url('assets/images/kegiatan/'.$thumbnail) ?>" class="w-100 rounded-3 object-fit-cover shadow-sm" style="height: 120px;">
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>

                        <div class="d-flex gap-2">
                             <button class="btn btn-outline-primary btn-sm flex-fill rounded-pill" onclick='openEdit(<?= json_encode($row) ?>)'>Edit</button>
                             <a href="<?= base_url('admin/kegiatan/delete/'.$row['id']) ?>" class="btn btn-outline-danger btn-sm flex-fill rounded-pill" onclick="return confirm('Hapus kegiatan ini?')">Hapus</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                 <div class="text-center py-5 text-muted">Belum ada data.</div>
            <?php endif; ?>
        </div>

    </div>

    <!-- MODAL ADD -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form class="modal-content rounded-4 border-0 shadow-lg" action="<?= base_url('admin/kegiatan/add') ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Tambah Kegiatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3 mb-3">
                        <div class="col-md-8">
                            <label class="form-label small fw-bold text-muted">JUDUL</label>
                            <input type="text" name="judul" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-muted">ORGANISASI</label>
                            <select name="organisasi_id" class="form-select">
                                <?php foreach($organisasi_list as $o): ?>
                                <option value="<?= $o['id'] ?>"><?= $o['nama_organisasi'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">UPLOAD DOKUMENTASI</label>
                        <div class="upload-area" onclick="document.getElementById('fileInput').click()">
                            <i class="bi bi-cloud-arrow-up-fill fs-3 text-muted"></i>
                            <p class="small mb-0 text-muted">Klik untuk upload (Bisa banyak)</p>
                            <input type="file" name="media[]" id="fileInput" class="d-none" multiple accept="image/*,video/*" onchange="previewFiles(this, 'previewBox')">
                        </div>
                        <div class="preview-container" id="previewBox"></div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-4"><label class="form-label small fw-bold text-muted">TANGGAL</label><input type="date" name="tanggal" class="form-control" required></div>
                        <div class="col-md-8"><label class="form-label small fw-bold text-muted">DESKRIPSI</label><textarea name="deskripsi" class="form-control" rows="2" required></textarea></div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0"><button type="submit" class="btn btn-primary w-100 py-2 rounded-pill">Simpan</button></div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form class="modal-content rounded-4 border-0 shadow-lg" action="<?= base_url('admin/kegiatan/edit') ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Edit Kegiatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" name="id" id="edit_id">
                    
                    <div class="row g-3 mb-3">
                        <div class="col-md-8">
                            <label class="form-label small fw-bold text-muted">JUDUL</label>
                            <input type="text" name="judul" id="edit_judul" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-muted">ORGANISASI</label>
                            <select name="organisasi_id" id="edit_org" class="form-select">
                                <?php foreach($organisasi_list as $o): ?>
                                <option value="<?= $o['id'] ?>"><?= $o['nama_organisasi'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">GALERI SAAT INI</label>
                        <div class="d-flex gap-2 overflow-auto pb-2" id="existingMediaBox">
                            <!-- Populated by JS -->
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">TAMBAH FOTO/VIDEO BARU</label>
                        <div class="upload-area" onclick="document.getElementById('editFileInput').click()">
                            <i class="bi bi-plus-circle fs-3 text-muted"></i>
                            <p class="small mb-0 text-muted">Tambah File Baru</p>
                            <input type="file" name="media[]" id="editFileInput" class="d-none" multiple accept="image/*,video/*" onchange="previewFiles(this, 'editPreviewBox')">
                        </div>
                        <div class="preview-container" id="editPreviewBox"></div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4"><label class="form-label small fw-bold text-muted">TANGGAL</label><input type="date" name="tanggal" id="edit_tanggal" class="form-control" required></div>
                        <div class="col-md-8"><label class="form-label small fw-bold text-muted">DESKRIPSI</label><textarea name="deskripsi" id="edit_deskripsi" class="form-control" rows="2" required></textarea></div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0"><button type="submit" class="btn btn-warning text-white w-100 py-2 rounded-pill">Update Perubahan</button></div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function previewFiles(input, targetId) {
            var preview = document.getElementById(targetId);
            preview.innerHTML = '';
            if (input.files) {
                for (i = 0; i < input.files.length; i++) {
                    var reader = new FileReader();
                    reader.onload = function(event) {
                        var img = document.createElement('img');
                        img.src = event.target.result;
                        img.className = 'preview-item';
                        preview.appendChild(img);
                    }
                    reader.readAsDataURL(input.files[i]);
                }
            }
        }

        function openEdit(data) {
            document.getElementById('edit_id').value = data.id;
            document.getElementById('edit_judul').value = data.judul;
            document.getElementById('edit_deskripsi').value = data.deskripsi;
            document.getElementById('edit_tanggal').value = data.tanggal;
            document.getElementById('edit_org').value = data.organisasi_id;
            
            // Fetch Media AJAX
            const box = document.getElementById('existingMediaBox');
            box.innerHTML = '<span class="text-muted small">Loading media...</span>';
            
            fetch('<?= base_url('admin/kegiatan/get_media/') ?>' + data.id)
                .then(response => response.json())
                .then(media => {
                    box.innerHTML = '';
                    if(media && media.length > 0) {
                        media.forEach(m => {
                            const div = document.createElement('div');
                            div.className = 'existing-wrapper';
                            let content = '';
                            if(m.tipe_file === 'video') {
                                content = `<video src="<?= base_url('assets/images/kegiatan/') ?>${m.file}" class="existing-item bg-dark"></video>`;
                            } else {
                                content = `<img src="<?= base_url('assets/images/kegiatan/') ?>${m.file}" class="existing-item">`;
                            }
                            div.innerHTML = `
                                ${content}
                                <a href="<?= base_url('admin/kegiatan/delete_media/') ?>${m.id}" class="btn-del-img" onclick="return confirm('Hapus foto/video ini?')"><i class="bi bi-x"></i></a>
                            `;
                            box.appendChild(div);
                        });
                    } else {
                        box.innerHTML = '<span class="text-muted small">Tidak ada media.</span>';
                    }
                });

            new bootstrap.Modal(document.getElementById('editModal')).show();
        }
        function toggleCalendar() {
            const cal = document.getElementById('calendarSection');
            if(cal.style.display === 'none') {
                cal.style.display = 'block';
            } else {
                cal.style.display = 'none';
            }
        }

        function openAddModal(dateStr) {
            const dateInput = document.querySelector('#addModal input[name="tanggal"]');
            if(dateInput) dateInput.value = dateStr;
            new bootstrap.Modal(document.getElementById('addModal')).show();
        }
    </script>
</body>
</html>
