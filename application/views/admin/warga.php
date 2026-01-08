<?php $page_title = 'Kelola Warga'; ?>
<?php $this->load->view('admin/templates/header'); ?>

<main class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-column flex-md-row align-items-start gap-3">
        <div>
            <h2 class="fw-bold mb-1">Kelola Data Warga</h2>
            <p class="text-muted m-0">Tambah, edit, dan kelola akun warga perumahan</p>
        </div>
        <button class="btn btn-primary w-100 w-md-auto rounded-pill shadow-sm px-4 py-2" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="bi bi-person-plus-fill me-2"></i>Tambah Warga
        </button>
    </div>

    <!-- Alert Messages -->
    <?php if ($this->session->flashdata('success_msg')): ?>
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i><?= $this->session->flashdata('success_msg') ?>
        <?php if ($this->session->flashdata('generated_password')): ?>
            <div class="mt-2 p-3 bg-white rounded border border-success-subtle">
                <i class="bi bi-key-fill me-2 text-warning"></i>Password: <strong><?= $this->session->flashdata('generated_password') ?></strong>
                <small class="d-block mt-2 text-danger">⚠️ Catat dan berikan ke warga yang bersangkutan!</small>
            </div>
        <?php endif; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error_msg')): ?>
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i><?= $this->session->flashdata('error_msg') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <!-- DESKTOP VIEW (TABLE) -->
    <div class="card border-0 shadow-sm rounded-4 d-none d-md-block">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">Warga</th>
                            <th>Kontak</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Rumah</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($warga_list as $w): ?>
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center fw-bold text-secondary" style="width:40px;height:40px;">
                                        <?= substr($w['nama_lengkap'],0,1) ?>
                                    </div>
                                    <div class="fw-bold"><?= $w['nama_lengkap'] ?></div>
                                </div>
                            </td>
                            <td><?= $w['no_hp'] ? $w['no_hp'] : '<span class="text-muted">-</span>' ?></td>
                            <td><span class="badge bg-light text-dark border"><?= $w['username'] ?></span></td>
                            <td>
                                <?php 
                                    $p = $w['raw_password'];
                                    if (substr($p, 0, 1) == '$' && strlen($p) > 20) echo '<span class="text-muted small"><em>Encrypted</em></span>';
                                    else echo '<span class="fw-bold text-success font-monospace">'.$p.'</span>';
                                ?>
                            </td>
                            <td><span class="badge bg-primary-subtle text-primary">Blok <?= $w['blok'] ?> / <?= $w['no_rumah'] ?></span></td>
                            <td class="text-end pe-4">
                                <button class="btn btn-sm btn-light text-primary rounded-circle me-1 border shadow-sm" onclick='editWarga(<?= json_encode($w) ?>)'><i class="bi bi-pencil-fill"></i></button>
                                <button class="btn btn-sm btn-light text-danger rounded-circle border shadow-sm" onclick="deleteWarga(<?= $w['id'] ?>, '<?= addslashes($w['nama_lengkap']) ?>')"><i class="bi bi-trash-fill"></i></button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- MOBILE VIEW (CARDS) -->
    <div class="d-md-none d-flex flex-column gap-3">
        <?php foreach($warga_list as $w): ?>
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width:45px;height:45px;font-size:18px;">
                            <?= substr($w['nama_lengkap'],0,1) ?>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0 text-dark"><?= $w['nama_lengkap'] ?></h6>
                            <span class="badge bg-light text-dark border mt-1">Blok <?= $w['blok'] ?> - <?= $w['no_rumah'] ?></span>
                        </div>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-light btn-sm rounded-circle shadow-sm" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></button>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4">
                            <li><a class="dropdown-item py-2" href="#" onclick='editWarga(<?= json_encode($w) ?>)'><i class="bi bi-pencil me-2 text-primary"></i>Edit Data</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item py-2 text-danger" href="#" onclick="deleteWarga(<?= $w['id'] ?>, '<?= addslashes($w['nama_lengkap']) ?>')"><i class="bi bi-trash me-2"></i>Hapus</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="bg-light rounded-3 p-3 mb-2">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="small text-muted">Username</span>
                        <span class="small fw-bold text-dark"><?= $w['username'] ?></span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small text-muted">Password</span>
                         <?php 
                            $p = $w['raw_password'];
                            if (substr($p, 0, 1) == '$' && strlen($p) > 20) echo '<span class="small text-muted"><em>Encrypted</em></span>';
                            else echo '<span class="small fw-bold text-success font-monospace">'.$p.'</span>';
                        ?>
                    </div>
                </div>
                
                <?php if($w['no_hp']): ?>
                <a href="https://wa.me/<?= preg_replace('/^0/','62',$w['no_hp']) ?>" class="btn btn-outline-success w-100 rounded-pill btn-sm">
                    <i class="bi bi-whatsapp me-2"></i>Hubungi (<?= $w['no_hp'] ?>)
                </a>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

</main>

<!-- Add Warga Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Tambah Warga Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('admin/warga/create') ?>" method="POST">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-muted">NAMA LENGKAP</label>
                        <input type="text" name="nama_lengkap" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold small text-muted">BLOK</label>
                            <select name="blok" class="form-select" required>
                                <?php foreach(range('A','T') as $letter) { for($num = 1; $num <= 5; $num++) { echo "<option value='{$letter}{$num}'>{$letter}{$num}</option>"; } } ?>
                            </select>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold small text-muted">NO. RUMAH</label>
                            <input type="text" name="no_rumah" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                         <div class="col-6 mb-3">
                             <label class="form-label fw-semibold small text-muted">GENDER</label>
                             <select name="jenis_kelamin" class="form-select" required>
                                 <option value="L">Laki-laki</option>
                                 <option value="P">Perempuan</option>
                             </select>
                         </div>
                         <div class="col-6 mb-3">
                            <label class="form-label fw-semibold small text-muted">NO. HP</label>
                            <input type="text" name="no_hp" class="form-control" placeholder="08xx">
                         </div>
                    </div>
                    <div class="alert alert-light border small text-muted">
                        <i class="bi bi-info-circle me-1"></i> Username & Password bisa dikosongkan (Auto-Generate).
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Warga Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Edit Data Warga</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('admin/warga/update') ?>" method="POST">
                <input type="hidden" name="warga_id" id="edit_warga_id">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-muted">NAMA LENGKAP</label>
                        <input type="text" name="nama_lengkap" id="edit_nama" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold small text-muted">BLOK</label>
                            <select name="blok" id="edit_blok" class="form-select" required>
                                <?php foreach(range('A','T') as $letter) { for($num = 1; $num <= 5; $num++) { echo "<option value='{$letter}{$num}'>{$letter}{$num}</option>"; } } ?>
                            </select>
                        </div>
                        <div class="col-6 mb-3">
                             <label class="form-label fw-semibold small text-muted">NO. RUMAH</label>
                            <input type="text" name="no_rumah" id="edit_no_rumah" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                         <div class="col-6 mb-3">
                            <label class="form-label fw-semibold small text-muted">GENDER</label>
                            <select name="jenis_kelamin" id="edit_jk" class="form-select" required>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                         </div>
                         <div class="col-6 mb-3">
                            <label class="form-label fw-semibold small text-muted">NO. HP</label>
                            <input type="text" name="no_hp" id="edit_no_hp" class="form-control">
                         </div>
                    </div>
                    
                    <div class="bg-light p-3 rounded-3 mt-2">
                        <h6 class="small fw-bold text-dark mb-2">AKUN LOGIN</h6>
                        <div class="mb-2">
                             <input type="text" name="username" id="edit_username" class="form-control form-control-sm" placeholder="Username">
                        </div>
                         <div class="input-group input-group-sm">
                            <input type="password" name="password" id="edit_password" class="form-control" placeholder="Password Baru (Opsional)">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('edit_password', this)"><i class="bi bi-eye"></i></button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning text-white rounded-pill px-4">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Form -->
<form id="deleteForm" action="<?= base_url('admin/warga/delete') ?>" method="POST" style="display:none;">
    <input type="hidden" name="warga_id" id="delete_warga_id">
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        const icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }

    function editWarga(data) {
        document.getElementById('edit_warga_id').value = data.id;
        document.getElementById('edit_nama').value = data.nama_lengkap;
        document.getElementById('edit_username').value = data.username;
        document.getElementById('edit_blok').value = data.blok;
        document.getElementById('edit_no_rumah').value = data.no_rumah;
        document.getElementById('edit_no_hp').value = data.no_hp || '';
        document.getElementById('edit_jk').value = data.jenis_kelamin;
        
        const rawPass = data.raw_password || '';
        if (rawPass.length > 0 && !rawPass.startsWith('$2y$')) {
            document.getElementById('edit_password').value = rawPass;
        } else {
            document.getElementById('edit_password').value = '';
        }
        
        new bootstrap.Modal(document.getElementById('editModal')).show();
    }

    function deleteWarga(wargaId, nama) {
        if(confirm(`Hapus warga "${nama}"? Data tidak dapat dikembalikan!`)) {
            document.getElementById('delete_warga_id').value = wargaId;
            document.getElementById('deleteForm').submit();
        }
    }
</script>
<?php $this->load->view('admin/templates/footer'); ?>
