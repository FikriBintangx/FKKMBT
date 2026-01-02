<?php
session_start();
require_once 'config/database.php';

// Handle Login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    $pin = $_POST['pin'];
    
    // Validasi PIN khusus admin
    if ($pin !== 'fkkmbt') {
        $error = 'PIN Admin salah! Akses ditolak.';
    } else {
        $sql = "SELECT u.*, a.nama_lengkap, a.jabatan 
                FROM users u 
                LEFT JOIN admins a ON u.id = a.user_id 
                WHERE u.username = '$username' AND u.role = 'admin'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
                $_SESSION['jabatan'] = $user['jabatan'];

                header("Location: admin/dashboard.php");
                exit;
            } else {
                $error = 'Password salah!';
            }
        } else {
            $error = 'Username tidak ditemukan atau bukan akun admin!';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - FKKMBT</title>
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
            position: relative;
            overflow: hidden;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at center, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }
        
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .login-container {
            width: 100%;
            max-width: 950px;
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            display: grid;
            grid-template-columns: 1fr 1fr;
            position: relative;
            z-index: 1;
            animation: slideUp 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: scale(0.8) translateY(50px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }
        
        .login-visual {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            padding: 60px 40px;
            color: white;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .login-visual::before {
            content: '';
            position: absolute;
            top: -100px;
            right: -100px;
            width: 300px;
            height: 300px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }
        
        .login-visual::after {
            content: '';
            position: absolute;
            bottom: -150px;
            left: -150px;
            width: 400px;
            height: 400px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
            animation: float 8s ease-in-out infinite reverse;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        
        .visual-content {
            position: relative;
            z-index: 1;
        }
        
        .shield-icon {
            width: 120px;
            height: 120px;
            background: rgba(255,255,255,0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
            backdrop-filter: blur(10px);
            border: 3px solid rgba(255,255,255,0.3);
            animation: pulse-border 2s ease-in-out infinite;
        }
        
        @keyframes pulse-border {
            0%, 100% { box-shadow: 0 0 0 0 rgba(255,255,255,0.7); }
            50% { box-shadow: 0 0 0 15px rgba(255,255,255,0); }
        }
        
        .shield-icon i {
            font-size: 50px;
        }
        
        .visual-content h1 {
            font-size: 36px;
            font-weight: 800;
            margin-bottom: 16px;
            line-height: 1.2;
        }
        
        .visual-content p {
            font-size: 16px;
            opacity: 0.9;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }
        
        .stat-card {
            background: rgba(255,255,255,0.15);
            padding: 20px;
            border-radius: 12px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
        }
        
        .stat-number {
            font-size: 28px;
            font-weight: 800;
            display: block;
            margin-bottom: 4px;
        }
        
        .stat-label {
            font-size: 13px;
            opacity: 0.8;
        }
        
        .login-form-side {
            padding: 60px 50px;
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .form-header {
            margin-bottom: 40px;
        }
        
        .form-header h2 {
            font-size: 28px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 8px;
        }
        
        .form-header p {
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
        
        .label-icon {
            margin-right: 6px;
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
        
        .input-wrapper {
            position: relative;
        }
        
        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #94a3b8;
            transition: color 0.3s;
            font-size: 18px;
        }
        
        .password-toggle:hover {
            color: var(--primary);
        }
        
        .btn-login {
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
            margin-top: 10px;
            position: relative;
            overflow: hidden;
        }
        
        .btn-login::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255,255,255,0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .btn-login:hover::before {
            width: 300px;
            height: 300px;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(99, 102, 241, 0.4);
        }
        
        .btn-login span {
            position: relative;
            z-index: 1;
        }
        
        .divider {
            text-align: center;
            margin: 30px 0;
            position: relative;
        }
        
        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--border);
        }
        
        .divider span {
            background: white;
            padding: 0 15px;
            color: #94a3b8;
            font-size: 14px;
            position: relative;
            z-index: 1;
        }
        
        .register-link {
            text-align: center;
            font-size: 14px;
            color: #64748b;
        }
        
        .register-link a {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .register-link a:hover {
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
            animation: shake 0.5s ease-in-out;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
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
        
        .back-to-home {
            position: fixed;
            top: 30px;
            left: 30px;
            z-index: 10;
        }
        
        .back-to-home a {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            background: rgba(255,255,255,0.95);
            color: var(--dark);
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
        }
        
        .back-to-home a:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        @media (max-width: 768px) {
            .login-container {
                grid-template-columns: 1fr;
            }
            
            .login-visual {
                display: none;
            }
            
            .login-form-side {
                padding: 40px 30px;
            }
            
            .back-to-home {
                top: 15px;
                left: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="back-to-home">
        <a href="index.php">
            <i class="bi bi-arrow-left"></i>
            Kembali ke Beranda
        </a>
    </div>

    <div class="login-container">
        <!-- Visual Side -->
        <div class="login-visual">
            <div class="visual-content">
                <div class="shield-icon">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>
                <h1>Admin Access<br>Control Panel</h1>
                <p>Masuk ke sistem manajemen FKKMBT dengan keamanan tingkat tinggi</p>
                
                <div class="stats-grid">
                    <div class="stat-card">
                        <span class="stat-number">100%</span>
                        <span class="stat-label">Secure Login</span>
                    </div>
                    <div class="stat-card">
                        <span class="stat-number">24/7</span>
                        <span class="stat-label">Full Access</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Form Side -->
        <div class="login-form-side">
            <div class="form-header">
                <h2>Login Admin</h2>
                <p>Masukkan kredensial admin Anda untuk melanjutkan</p>
            </div>
            
            <?php if(isset($error)): ?>
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <span><?= $error ?></span>
                </div>
            <?php endif; ?>
            
            <?php if(isset($_SESSION['flash'])): ?>
                <div class="alert alert-<?= $_SESSION['flash']['type'] ?>">
                    <i class="bi bi-check-circle-fill"></i>
                    <span><?= $_SESSION['flash']['message']; unset($_SESSION['flash']); ?></span>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-key-fill label-icon text-warning"></i>
                        PIN Admin
                    </label>
                    <div class="input-wrapper">
                        <input type="password" name="pin" id="pin" class="form-control" placeholder="Masukkan PIN khusus admin" required>
                        <i class="password-toggle bi bi-eye" onclick="togglePassword('pin', this)"></i>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-person-fill label-icon"></i>
                        Username
                    </label>
                    <input type="text" name="username" class="form-control" placeholder="Masukkan username admin" required autofocus>
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-lock-fill label-icon"></i>
                        Password
                    </label>
                    <div class="input-wrapper">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
                        <i class="password-toggle bi bi-eye" onclick="togglePassword('password', this)"></i>
                    </div>
                </div>
                
                <button type="submit" class="btn-login">
                    <span>
                        <i class="bi bi-box-arrow-in-right me-2"></i>
                        Masuk ke Dashboard
                    </span>
                </button>
            </form>
            
            <div class="divider">
                <span>atau</span>
            </div>
            
            <div class="register-link">
                Belum punya akun admin? <a href="admin_register.php">Daftar sekarang</a>
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
        
        // Add ripple effect on button click
        document.querySelector('.btn-login').addEventListener('click', function(e) {
            let ripple = document.createElement('span');
            ripple.classList.add('ripple');
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    </script>
</body>
</html>
