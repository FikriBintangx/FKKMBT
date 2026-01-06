<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Warga - Admin FKKMBT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body class="bg-light">
    <?php $this->load->view('admin/templates/navbar'); ?>

    <main class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold">Kelola Data Warga</h2>
                <p class="text-muted">Tambah, edit, dan kelola akun warga perumahan</p>
            </div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="bi bi-plus-circle me-2"></i>Tambah Warga Baru
            </button>
        </div>

        <!-- Alert Messages -->
        <?php if ($this->session->flashdata('success_msg')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i><?= $this->session->flashdata('success_msg') ?>
            <?php if ($this->session->flashdata('generated_password')): ?>
                <div class="mt-2 p-3 bg-white rounded border">
                    <i class="bi bi-key-fill me-2"></i><?= $this->session->flashdata('generated_password') ?>
                    <small class="d-block mt-2 text-danger">⚠️ Catat dan berikan ke warga yang bersangkutan!</small>
                </div>
            <?php endif; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error_msg')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i><?= $this->session->flashdata('error_msg') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <!-- Warga Table -->
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 ps-4">No</th>
                                <th class="border-0">Nama Lengkap</th>
                                <th class="border-0">Username</th>
                                <th class="border-0">Password</th>
                                <th class="border-0">Alamat</th>
                                <th class="border-0">No. HP</th>
                                <th class="border-0">JK</th>
                                <th class="border-0 text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach($warga_list as $w): ?>
                            <tr>
                                <td class="ps-4"><?= $no++ ?></td>
                                <td class="fw-semibold"><?= $w['nama_lengkap'] ?></td>
                                <td><span class="badge bg-info-subtle text-info"><?= $w['username'] ?></span></td>
                                <td>
                                    <?php 
                                        $p = $w['raw_password'];
                                        // Legacy logic for "encrypted" display vs ID
                                        if (substr($p, 0, 1) == '$' && strlen($p) > 20) {
                                            echo '<span class="text-muted small"><em>(Ter-enkripsi)</em></span>';
                                        } else {
                                            echo '<span class="fw-bold text-success">'.$p.'</span>';
                                        }
                                    ?>
                                </td>
                                <td>Blok <?= $w['blok'] ?> No. <?= $w['no_rumah'] ?></td>
                                <td><?= $w['no_hp'] ?? '-' ?></td>
                                <td><?= ($w['jenis_kelamin'] ?? 'L') == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-primary" onclick='editWarga(<?= json_encode($w) ?>)'>
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-outline-danger" onclick="deleteWarga(<?= $w['id'] ?>, '<?= $w['nama_lengkap'] ?>')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
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
                            <label class="form-label fw-semibold">Nama Lengkap *</label>
                            <input type="text" name="nama_lengkap" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Username (Opsional)</label>
                            <input type="text" name="username" class="form-control" placeholder="Biarkan kosong untuk auto-generate">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password (Opsional)</label>
                            <div class="input-group">
                                <input type="password" name="password" id="add_password" class="form-control" placeholder="Biarkan kosong untuk auto-generate">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('add_password', this)">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Blok *</label>
                                <select name="blok" class="form-select" required>
                                    <?php 
                                    foreach(range('A','T') as $letter) {
                                        for($num = 1; $num <= 5; $num++) {
                                            echo "<option value='{$letter}{$num}'>{$letter}{$num}</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">No. Rumah *</label>
                                <input type="text" name="no_rumah" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Jenis Kelamin *</label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">No. HP</label>
                            <input type="text" name="no_hp" class="form-control" placeholder="08xx">
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Warga</button>
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
                            <label class="form-label fw-semibold">Nama Lengkap *</label>
                            <input type="text" name="nama_lengkap" id="edit_nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Username</label>
                            <input type="text" name="username" id="edit_username" class="form-control">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Blok *</label>
                                <select name="blok" id="edit_blok" class="form-select" required>
                                    <?php 
                                    foreach(range('A','T') as $letter) {
                                        for($num = 1; $num <= 5; $num++) {
                                            echo "<option value='{$letter}{$num}'>{$letter}{$num}</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">No. Rumah *</label>
                                <input type="text" name="no_rumah" id="edit_no_rumah" class="form-control" required>
                            </div>
                        </div>
                         <div class="mb-3">
                            <label class="form-label fw-semibold">Jenis Kelamin *</label>
                            <select name="jenis_kelamin" id="edit_jk" class="form-select" required>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">No. HP</label>
                            <input type="text" name="no_hp" id="edit_no_hp" class="form-control">
                        </div>
                        <div class="mb-3 pt-3 border-top">
                            <label class="form-label small fw-bold text-danger">Ubah Password (Opsional)</label>
                            <div class="input-group">
                                <input type="password" name="password" id="edit_password" class="form-control" placeholder="********">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('edit_password', this)">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update Data</button>
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
</body>
</html>
