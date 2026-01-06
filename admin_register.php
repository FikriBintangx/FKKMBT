<?php
session_start();
require_once 'config/config.php';
require_once 'config/database.php';

// Handle Registration
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $nama_lengkap = $conn->real_escape_string($_POST['nama_lengkap']);
    $jabatan = $conn->real_escape_string($_POST['jabatan']);
    $pin = $_POST['pin'];
    
    // Validasi PIN khusus admin
    if ($pin !== 'FKKMBT_Secure_2025') {
        $error = 'PIN Admin salah! Hanya admin yang berhak mendaftar.';
    }
    // Validasi password match
    elseif ($password !== $confirm_password) {
        $error = 'Password dan konfirmasi password tidak cocok!';
    }
    // Cek username sudah ada atau belum
    else {
        $check = $conn->query("SELECT * FROM users WHERE username = '$username'");
        if ($check->num_rows > 0) {
            $error = 'Username sudah digunakan! Silakan pilih username lain.';
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert ke users table
            $sql_user = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashed_password', 'admin')";
            
            if ($conn->query($sql_user)) {
                $user_id = $conn->insert_id;
                
                // Insert ke admins table
                $sql_admin = "INSERT INTO admins (user_id, nama_lengkap, jabatan) VALUES ($user_id, '$nama_lengkap', '$jabatan')";
                
                if ($conn->query($sql_admin)) {
                    $_SESSION['flash'] = [
                        'type' => 'success',
                        'message' => 'Akun admin berhasil didaftarkan! Silakan login.'
                    ];
                    header("Location: admin_login.php");
                    exit;
                } else {
                    $error = 'Gagal menyimpan data profil admin: ' . $conn->error;
                }
            } else {
                $error = 'Gagal membuat akun: ' . $conn->error;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Admin - FKKMBT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --primary-light: #818cf8;
            --secondary: #f59e0b;
            --success: #10b981;
            --danger: #ef4444;
            --dark: #1e293b;
            --dark-alt: #0f172a;
            --light: #f8fafc;
            --border: #e2e8f0;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .register-container {
            width: 100%;
            max-width: 1000px;
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            display: grid;
            grid-template-columns: 1fr 1fr;
            animation: slideUp 0.6s ease-out;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .register-left {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            padding: 60px 40px;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .register-left::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 4s ease-in-out infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }
        
        .register-left-content {
            position: relative;
            z-index: 1;
        }
        
        .logo-section {
            margin-bottom: 40px;
        }
        
        .logo-icon {
            width: 70px;
            height: 70px;
            background: rgba(255,255,255,0.2);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin-bottom: 20px;
            backdrop-filter: blur(10px);
        }
        
        .register-left h1 {
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 16px;
            line-height: 1.2;
        }
        
        .register-left p {
            font-size: 16px;
            opacity: 0.9;
            line-height: 1.6;
            margin-bottom: 40px;
        }
        
        .feature-list {
            list-style: none;
            padding: 0;
        }
        
        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            font-size: 15px;
        }
        
        .feature-icon {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 16px;
            backdrop-filter: blur(10px);
        }
        
        .register-right {
            padding: 60px 50px;
            background: white;
        }
        
        .register-header {
            margin-bottom: 40px;
        }
        
        .register-header h2 {
            font-size: 28px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 8px;
        }
        
        .register-header p {
            color: #64748b;
            font-size: 15px;
        }
        
        .form-group {
            margin-bottom: 24px;
        }
        
        .form-label {
            display: block;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .form-control {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid var(--border);
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s;
            background: var(--light);
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }
        
        .input-icon {
            position: relative;
        }
        
        .input-icon i {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }
        
        .input-icon input {
            padding-right: 45px;
        }
        
        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #94a3b8;
            transition: color 0.3s;
        }
        
        .password-toggle:hover {
            color: var(--primary);
        }
        
        .btn-register {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 30px;
            position: relative;
            overflow: hidden;
        }
        
        .btn-register::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }
        
        .btn-register:hover::before {
            left: 100%;
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(99, 102, 241, 0.4);
        }
        
        .login-link {
            text-align: center;
            margin-top: 24px;
            font-size: 14px;
            color: #64748b;
        }
        
        .login-link a {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .login-link a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }
        
        .alert {
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideDown 0.3s ease-out;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
        
        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }
        
        .pin-info {
            background: #fef3c7;
            border: 2px solid #fcd34d;
            border-radius: 12px;
            padding: 12px 16px;
            margin-bottom: 24px;
            display: flex;
            align-items: start;
            gap: 12px;
        }
        
        .pin-info i {
            color: #f59e0b;
            font-size: 20px;
            margin-top: 2px;
        }
        
        .pin-info-text {
            flex: 1;
        }
        
        .pin-info-text strong {
            display: block;
            color: #92400e;
            margin-bottom: 4px;
        }
        
        .pin-info-text small {
            color: #78350f;
            font-size: 13px;
        }
        
        @media (max-width: 768px) {
            .register-container {
                grid-template-columns: 1fr;
            }
            
            .register-left {
                padding: 40px 30px;
            }
            
            .register-right {
                padding: 40px 30px;
            }
            
            .register-left h1 {
                font-size: 26px;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <!-- Left Side -->
        <div class="register-left">
            <div class="register-left-content">
                <div class="logo-section">
                    <div class="logo-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h1>Panel Admin<br>FKKMBT</h1>
                    <p>Kelola sistem dengan akses penuh sebagai administrator</p>
                </div>
                
                <ul class="feature-list">
                    <li class="feature-item">
                        <div class="feature-icon">
                            <i class="bi bi-people"></i>
                        </div>
                        <span>Kelola Data Warga</span>
                    </li>
                    <li class="feature-item">
                        <div class="feature-icon">
                            <i class="bi bi-calendar-event"></i>
                        </div>
                        <span>Manajemen Kegiatan</span>
                    </li>
                    <li class="feature-item">
                        <div class="feature-icon">
                            <i class="bi bi-cash-coin"></i>
                        </div>
                        <span>Kontrol Iuran</span>
                    </li>
                    <li class="feature-item">
                        <div class="feature-icon">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <span>Laporan & Statistik</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Right Side -->
        <div class="register-right">
            <div class="register-header">
                <h2>Daftar Admin Baru</h2>
                <p>Lengkapi formulir untuk membuat akun administrator</p>
            </div>
            
            <?php if(isset($error)): ?>
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <span><?= $error ?></span>
                </div>
            <?php endif; ?>
            
            <div class="pin-info">
                <i class="bi bi-info-circle-fill"></i>
                <div class="pin-info-text">
                    <strong>PIN Khusus Diperlukan</strong>
                    <small>Hanya yang memiliki PIN admin yang dapat mendaftar</small>
                </div>
            </div>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-key-fill text-warning"></i> PIN Admin
                    </label>
                    <div class="input-icon">
                        <input type="password" name="pin" id="pin" class="form-control" placeholder="Masukkan PIN khusus admin" required>
                        <i class="password-toggle bi bi-eye" onclick="togglePassword('pin', this)"></i>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-person-fill"></i> Nama Lengkap
                    </label>
                    <input type="text" name="nama_lengkap" class="form-control" placeholder="Contoh: Ahmad Rizki Pratama" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-briefcase-fill"></i> Jabatan
                    </label>
                    <input type="text" name="jabatan" class="form-control" placeholder="Contoh: Ketua Sekretariat" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-at"></i> Username
                    </label>
                    <input type="text" name="username" class="form-control" placeholder="Pilih username unik" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-lock-fill"></i> Password
                    </label>
                    <div class="input-icon">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Buat password kuat" required>
                        <i class="password-toggle bi bi-eye" onclick="togglePassword('password', this)"></i>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-lock-fill"></i> Konfirmasi Password
                    </label>
                    <div class="input-icon">
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Ketik ulang password" required>
                        <i class="password-toggle bi bi-eye" onclick="togglePassword('confirm_password', this)"></i>
                    </div>
                </div>
                
                <button type="submit" class="btn-register">
                    <i class="bi bi-shield-check me-2"></i> Daftar Sebagai Admin
                </button>
            </form>
            
            <div class="login-link">
                Sudah punya akun admin? <a href="admin_login.php">Login disini</a>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId, icon) {
            const input = document.getElementById(inputId);
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
    </script>
</body>
</html>
