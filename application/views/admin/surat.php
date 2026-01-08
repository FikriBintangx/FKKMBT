<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola E-Surat - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body{font-family:'Outfit',sans-serif;background-color:#f8fafc}</style>
</head>
<body>
    <?php $this->load->view('admin/templates/navbar'); ?>
    <div class="container py-4">
        <h3 class="fw-bold text-primary mb-4"><i class="bi bi-file-earmark-text me-2"></i>Permohonan E-Surat</h3>
        <?php if ($this->session->flashdata('success_msg')): ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success_msg') ?></div>
        <?php endif; ?>
        
        <div class="card border-0 shadow-sm rounded-4">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Warga</th>
                            <th>Jenis Surat</th>
                            <th>Keperluan</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th class="pe-4 text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($requests)): ?>
                            <?php foreach($requests as $r): ?>
                            <tr>
                                <td class="ps-4">
                                    <strong><?= $r['nama_lengkap'] ?></strong><br>
                                    <small class="text-muted">Blok <?= $r['blok'] ?></small>
                                </td>
                                <td><?= $r['jenis_surat'] ?></td>
                                <td><?= substr($r['keperluan'],0,50) ?>...</td>
                                <td><?= date('d M Y', strtotime($r['created_at'])) ?></td>
                                <td>
                                    <?php 
                                    $s = strtolower($r['status']);
                                    $badge = 'secondary';
                                    if($s == 'pending') $badge = 'warning';
                                    else if($s == 'selesai' || $s == 'approved') $badge = 'success';
                                    else if($s == 'ditolak' || $s == 'rejected') $badge = 'danger';
                                    ?>
                                    <span class="badge bg-<?= $badge ?>"><?= ucfirst($r['status']) ?></span>
                                </td>
                                <td class="pe-4 text-end">
                                    <?php if(strtolower($r['status'])=='pending'): ?>
                                        <a href="<?= base_url('admin/surat/approve/'.$r['id']) ?>" class="btn btn-sm btn-success me-1" onclick="return confirm('Setujui surat ini?')">Setujui</a>
                                        <a href="<?= base_url('admin/surat/reject/'.$r['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Tolak surat ini?')">Tolak</a>
                                    <?php else: ?>
                                        <span class="text-muted small">Selesai</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="text-center py-5 text-muted">Tidak ada permohonan.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
