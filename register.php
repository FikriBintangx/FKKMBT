<?php
session_start();
require_once 'config/config.php';
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $conn->real_escape_string($_POST['nama']);
    $username = $conn->real_escape_string($_POST['username']);
    $no_hp = $conn->real_escape_string($_POST['no_hp']); // Changed from email to no_hp
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $blok = $conn->real_escape_string($_POST['blok']);
    $no_rumah = $conn->real_escape_string($_POST['no_rumah']);
    $jenis_kelamin = $conn->real_escape_string($_POST['jenis_kelamin']);

    // Check Duplicate
    $check = $conn->query("SELECT id FROM users WHERE username = '$username'");
    if ($check->num_rows > 0) {
        $error = 'Username sudah digunakan!';
    } else {
        $conn->begin_transaction();
        try {
            $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'warga')");
            $stmt->bind_param("ss", $username, $password);
            $stmt->execute();
            $user_id = $conn->insert_id;

            // INSERT with Gender
            $stmtWarga = $conn->prepare("INSERT INTO warga (user_id, nama_lengkap, blok, no_rumah, no_hp, jenis_kelamin) VALUES (?, ?, ?, ?, ?, ?)");
            $stmtWarga->bind_param("isssss", $user_id, $nama, $blok, $no_rumah, $no_hp, $jenis_kelamin);
            $stmtWarga->execute();

            $conn->commit();
            $_SESSION['flash'] = ['type'=>'success', 'message'=>'Pendaftaran berhasil, silakan login.'];
            header("Location: login.php");
            exit;
        } catch (Exception $e) {
            $conn->rollback();
            $error = 'Terjadi kesalahan sistem: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Portal Warga FKKMBT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .register-container {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }
        .back-link {
            position: absolute; top: 30px; left: 40px;
            text-decoration: none; color: #64748b; font-weight: 600;
            display: flex; align-items: center; gap: 8px; transition: all 0.3s;
        }
        .back-link:hover { color: #1e293b; transform: translateX(-5px); }
        
        .register-box {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.08);
            display: flex;
            overflow: hidden;
            max-width: 1000px;
            width: 100%;
        }
        
        .register-visual {
            flex: 1;
            background: linear-gradient(135deg, #16a34a 0%, #059669 100%);
            padding: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            position: relative;
        }
        .register-visual::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0;
            background: url('https://source.unsplash.com/random/800x1200/?community,nature') center/cover;
            opacity: 0.1; mix-blend-mode: overlay;
        }

        .register-form-side { flex: 1.2; padding: 50px 45px; background: white; }
        .form-header { margin-bottom: 30px; }
        .form-header h2 { font-size: 1.8rem; font-weight: 800; color: #1e293b; margin-bottom: 8px; }
        .form-header p { color: #64748b; font-size: 0.95rem; }
        
        .form-control, .form-select {
            padding: 12px 16px; border: 2px solid #e2e8f0; border-radius: 12px;
            font-size: 0.95rem; transition: all 0.3s; background: #f8fafc;
        }
        .form-control:focus, .form-select:focus {
            outline: none; border-color: #16a34a; background: white;
            box-shadow: 0 0 0 4px rgba(22, 163, 74, 0.1);
        }
        
        .btn-register {
            width: 100%; padding: 14px;
            background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
            color: white; border: none; border-radius: 12px;
            font-weight: 700; cursor: pointer; transition: all 0.3s; margin-top: 10px;
        }
        .btn-register:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(22, 163, 74, 0.3); }

        .benefits-list { list-style: none; padding: 0; margin-top: 40px; position: relative; z-index: 2; }
        .benefit-item { display: flex; align-items: center; margin-bottom: 20px; font-weight: 500; font-size: 1.05rem; }
        .benefit-icon {
            width: 32px; height: 32px; background: rgba(255,255,255,0.2);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            margin-right: 15px; flex-shrink: 0;
        }

        @media (max-width: 900px) {
            .register-box { flex-direction: column; }
            .register-visual { padding: 40px; text-align: center; }
            .benefits-list { display: none; }
            .back-link { top: 15px; left: 15px; font-size: 0.9rem; }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <a href="index.php" class="back-link"><i class="bi bi-arrow-left"></i> Kembali</a>

        <div class="register-box">
            <!-- Visual Side -->
            <div class="register-visual">
                <div class="visual-content position-relative z-2">
                    <h1 class="fw-bold mb-3">Bergabung dengan<br>Komunitas Kami</h1>
                    <p class="opacity-75">Nikmati kemudahan akses informasi, pembayaran iuran, dan kegiatan sosial dalam satu portal terpadu.</p>
                    
                    <ul class="benefits-list text-start">
                        <li class="benefit-item"><div class="benefit-icon"><i class="bi bi-check2"></i></div><span>Akses Informasi 24/7</span></li>
                        <li class="benefit-item"><div class="benefit-icon"><i class="bi bi-check2"></i></div><span>Pembayaran Iuran Online</span></li>
                        <li class="benefit-item"><div class="benefit-icon"><i class="bi bi-check2"></i></div><span>Direktori Warga</span></li>
                        <li class="benefit-item"><div class="benefit-icon"><i class="bi bi-check2"></i></div><span>Update Kegiatan Real-time</span></li>
                    </ul>
                </div>
            </div>
            
            <!-- Form Side -->
            <div class="register-form-side">
                <div class="form-header">
                    <h2>Selamat Datang!</h2>
                    <p>Lengkapi biodata Anda untuk mendaftar akun warga.</p>
                </div>
                
                <?php if(isset($error)): ?>
                    <div class="alert alert-danger px-3 py-2 rounded-3 mb-3 d-flex align-items-center gap-2">
                        <i class="bi bi-exclamation-circle-fill"></i> <?= $error ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="form-group mb-3">
                        <label class="form-label small fw-bold text-muted ms-1">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" placeholder="Sesuai KTP" required>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted ms-1">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted ms-1">No. WhatsApp</label>
                            <input type="text" name="no_hp" class="form-control" placeholder="0812xxxx" required>
                        </div>
                    </div>
                    
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-muted ms-1">Blok</label>
                            <select name="blok" class="form-select" required>
                                <?php foreach(range('A','T') as $b): ?>
                                    <option value="<?= $b ?>">Blok <?= $b ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label small fw-bold text-muted ms-1">No Rumah</label>
                            <input type="text" name="no_rumah" class="form-control" placeholder="Contoh: 12" required>
                        </div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label class="form-label small fw-bold text-muted ms-1">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Buat username unik" required>
                    </div>
                    
                    <div class="form-group mb-4">
                        <label class="form-label small fw-bold text-muted ms-1">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required>
                    </div>
                    
                    <button type="submit" class="btn-register shadow-sm">
                        <i class="bi bi-person-plus-fill me-2"></i> Daftar Sekarang
                    </button>
                </form>
                
                <div class="text-center mt-4 text-muted small">
                    Sudah punya akun? <a href="login.php" class="text-success fw-bold text-decoration-none">Masuk di sini</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
