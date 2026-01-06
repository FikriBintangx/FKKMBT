<?php
session_start();
require_once 'config/config.php';
require_once 'config/database.php';

// Redirect if already logged in
// Redirect if already logged in -> DISABLED per user request
// if (isset($_SESSION['user_id'])) {
//     if ($_SESSION['role'] == 'admin') header("Location: admin/dashboard.php");
//     else header("Location: user/dashboard.php");
//     exit;
// }

$error_msg = '';
$success_msg = '';

// --- HANDLE SUBMISSIONS ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';

    // === LOGIN (WARGA & ADMIN) ===
    if ($action == 'login') {
        $username = $conn->real_escape_string($_POST['username'] ?? $_POST['email']);
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE username = '$username'"; 
        $result = $conn->query($sql);
        
        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // 1. Check with Hash (Secure)
            if (password_verify($password, $user['password'])) {
                $auth_success = true;
            } 
            // 2. Check as Plain Text (Fallback)
            elseif ($password === $user['password']) {
                $auth_success = true;
            } else {
                $auth_success = false;
            }

            if ($auth_success) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                
                if ($user['role'] == 'admin') header("Location: admin/dashboard.php");
                else header("Location: user/dashboard.php");
                exit;
            } else {
                $error_msg = "Password salah!";
            }
        } else {
            // HELPFUL DEBUG: Check for similar usernames
            $check_similar = $conn->query("SELECT username FROM users WHERE username LIKE '%$username%' LIMIT 1");
            if ($check_similar->num_rows > 0) {
                $found = $check_similar->fetch_assoc()['username'];
                $error_msg = "Username tidak ditemukan! Apakah maksud Anda: <strong>$found</strong>?";
            } else {
                $error_msg = "Username tidak ditemukan! Pastikan ejaan benar.";
            }
        }
    }

    // === REGISTER ADMIN ===
    elseif ($action == 'register_admin') {
        $pin = $_POST['admin_pin'];
        if ($pin !== 'FKKMBT_Secure_2025') {
            $error_msg = "PIN Admin Salah! Pendaftaran ditolak.";
        } else {
            $username = $conn->real_escape_string($_POST['username']);
            $password = $_POST['password'];
            $fullname = $conn->real_escape_string($_POST['fullname']);
            $jabatan = $conn->real_escape_string($_POST['jabatan']);

            $check = $conn->query("SELECT id FROM users WHERE username = '$username'");
            if ($check->num_rows > 0) {
                $error_msg = "Username sudah terdaftar!";
            } else {
                $hashed = password_hash($password, PASSWORD_DEFAULT);
                $conn->query("INSERT INTO users (username, password, role) VALUES ('$username', '$hashed', 'admin')");
                $user_id = $conn->insert_id;
                $conn->query("INSERT INTO admins (user_id, nama_lengkap, jabatan) VALUES ('$user_id', '$fullname', '$jabatan')");
                
                $success_msg = "Admin berhasil didaftarkan! Silakan login.";
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
    <title>Portal Masuk - FKKMBT</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        /* CSS Reset & Variables */
        :root {
            --bg-color: #1e3f35; /* Dark Green */
            --card-color: #f2f4f1; /* Cream */
            --primary: #f97316; /* Orange */
            --primary-hover: #ea580c;
            --text-main: #1f2937;
            --text-muted: #6b7280;
            --input-bg: #ffffff;
            --input-border: #e5e7eb;
            --toggle-bg: #e5e7eb;
            --success: #16a34a;
            --error: #ef4444;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }

        body {
            background: linear-gradient(135deg, #1e3f35 0%, #17332b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .back-link {
            position: absolute;
            top: 30px;
            left: 30px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            transition: color 0.2s;
        }
        .back-link:hover { color: white; }

        /* Card Container */
        .portal-card {
            background: var(--card-color);
            width: 100%;
            max-width: 450px;
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            position: relative;
            overflow: hidden;
        }

        /* Header */
        .portal-header { text-center: center; margin-bottom: 30px; }
        .logo-box {
            width: 64px; height: 64px;
            background: #16a34a; /* Logo Green */
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Playfair Display', serif;
            font-size: 32px; font-weight: bold; color: white;
            margin: 0 auto 20px;
            box-shadow: 0 10px 15px -3px rgba(22, 163, 74, 0.3);
        }
        .portal-title {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            color: var(--text-main);
            margin-bottom: 8px;
        }
        .portal-subtitle {
            font-size: 14px;
            color: var(--text-muted);
        }

        /* Role Toggle */
        .role-switch {
            background: #e2e8f0;
            padding: 4px;
            border-radius: 12px;
            display: flex;
            margin-bottom: 24px;
        }
        .role-option {
            flex: 1;
            padding: 10px;
            text-align: center;
            cursor: pointer;
            border-radius: 10px;
            font-weight: 600;
            color: var(--text-muted);
            transition: all 0.3s ease;
        }
        .role-option.active {
            background: white;
            color: var(--text-main);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        /* Sub Toggle (Masuk / Daftar) for Warga */
        .action-switch {
            display: flex;
            border-bottom: 2px solid #e5e7eb;
            margin-bottom: 30px;
        }
        .action-btn {
            flex: 1;
            background: none;
            border: none;
            padding: 12px;
            font-weight: 600;
            color: var(--text-muted);
            cursor: pointer;
            position: relative;
        }
        .action-btn.active { color: var(--text-main); }
        .action-btn.active::after {
            content: '';
            position: absolute; bottom: -2px; left: 0; width: 100%;
            height: 2px; background: var(--text-main);
        }

        /* Forms */
        .form-group { margin-bottom: 20px; }
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 14px;
            color: var(--text-main);
        }
        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--input-border);
            border-radius: 12px;
            font-size: 15px;
            transition: border-color 0.2s;
            outline: none;
        }
        .form-input:focus { border-color: var(--primary); }
        
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 10px;
        }
        .btn-submit:hover { background: var(--primary-hover); }

        .info-box {
            background: #fffbeb;
            border: 1px solid #fcd34d;
            color: #92400e;
            padding: 15px;
            border-radius: 12px;
            font-size: 14px;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .alert {
            padding: 12px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 20px;
            text-align: center;
        }
        .alert-error { background: #fee2e2; color: #b91c1c; }
        .alert-success { background: #dcfce7; color: #15803d; }

        /* Transitions */
        .view-section { display: none; animation: fadeIn 0.4s ease; }
        .view-section.active { display: block; }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Admin Regis Link */
        .admin-regis-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }
        .admin-regis-link a { color: var(--primary); text-decoration: none; font-weight: 600; cursor: pointer; }

        /* Modal PIN */
        .modal {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.6);
            display: none; align-items: center; justify-content: center; z-index: 100;
        }
        .modal.active { display: flex; }
        .modal-box {
            background: white;
            padding: 30px;
            border-radius: 20px;
            max-width: 400px;
            width: 90%;
            text-align: center;
        }

        /* Password Toggle */
        .password-wrapper { position: relative; }
        .password-wrapper input { padding-right: 45px; }
        .toggle-password {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-muted);
            font-size: 1.2rem;
        }
        .toggle-password:hover { color: var(--text-main); }
    </style>
</head>
<body>

    <a href="index.php" class="back-link">
        <i class="bi bi-arrow-left"></i> Kembali ke Beranda
    </a>

    <!-- PHP LOGIC UPDATE: Remove role_target check inside POST handling -->
    <?php
    // ... inside the existing PHP block at the top ...
    // Note: I will update the PHP block via a separate hunk or just rely on the user applying the logic change.
    // Actually, I should update the PHP block too.
    ?>

    <div class="portal-card">
        <div class="portal-header">
            <div class="logo-box">F</div>
            <h1 class="portal-title">Portal FKKMBT</h1>
            <p class="portal-subtitle">Masuk untuk mengakses layanan warga & admin</p>
        </div>

        <?php if($error_msg): ?>
            <div class="alert alert-error"><?= $error_msg ?></div>
        <?php endif; ?>
        <?php if($success_msg): ?>
            <div class="alert alert-success"><?= $success_msg ?></div>
        <?php endif; ?>

        <!-- === UNIFIED LOGIN SECTION === -->
        <?php if (isset($_SESSION['user_id'])): ?>
            <!-- ALREADY LOGGED IN VIEW -->
            <div id="view-loggedin" class="view-section active text-center">
                <div class="mb-4">
                    <div class="mx-auto mb-3 d-flex align-items-center justify-content-center" style="width:64px; height:64px; background:#dcfce7; color:#16a34a; border-radius:50%;">
                        <i class="bi bi-person-check-fill fs-3"></i>
                    </div>
                    <?php 
                        $display_name = isset($_SESSION['username']) ? explode('@', $_SESSION['username'])[0] : 'User';
                    ?>
                    <h3 style="font-size:24px; font-weight:700; color:#1f2937;">Halo, <?= $display_name ?>!</h3>
                    <p class="text-muted">Anda sudah berhasil login.</p>
                </div>
                
                <div class="d-grid gap-3">
                    <a href="<?= $_SESSION['role'] == 'admin' ? 'admin/dashboard.php' : 'user/dashboard.php' ?>" class="btn-submit text-decoration-none d-flex align-items-center justify-content-center gap-2">
                        Masuk Dashboard <i class="bi bi-arrow-right"></i>
                    </a>
                    <a href="logout.php" class="text-danger fw-semibold text-decoration-none small">
                        Ganti Akun / Logout
                    </a>
                </div>
            </div>
        <?php else: ?>
            <!-- LOGIN FORM VIEW -->
            <div id="view-login" class="view-section active">
                <form id="login-form" method="POST">
                <input type="hidden" name="action" value="login">
                <!-- No role_target needed, we detect automatically -->
                
                <div class="form-group">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-input" placeholder="Masukkan username Anda" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="password-wrapper">
                        <input type="password" name="password" class="form-input" placeholder="••••••••" required>
                        <button type="button" class="toggle-password" onclick="togglePassword(this)"><i class="bi bi-eye"></i></button>
                    </div>
                </div>
                <button type="submit" class="btn-submit">Masuk</button>
                
                <div class="text-center mt-4">
                    <a onclick="showPinModal()" style="color:var(--primary); font-weight:600; font-size:14px; cursor:pointer;">
                        Daftar Akun Pengurus
                    </a>
                </div>
                <!-- Optional: Help text for Warga -->
                 <div class="text-center mt-2">
                    <small class="text-muted" style="font-size:12px;">Warga belum punya akun? Hubungi Admin.</small>
                </div>
            </form>
            </div>
        <?php endif; ?>

        <!-- === REGISTER ADMIN SECTION (Hidden) === -->
        <div id="view-register" class="view-section">
             <div class="portal-header mb-3">
                <h2 class="portal-title" style="font-size:24px;">Daftar Pengurus</h2>
            </div>

            <form id="admin-register-form" method="POST">
                <input type="hidden" name="action" value="register_admin">
                <input type="hidden" name="admin_pin" id="pin-input-hidden">
                
                <div class="form-group">
                    <label class="form-label">PIN Admin (Terverifikasi)</label>
                    <input type="text" class="form-input" value="••••••" disabled style="background:#e5ebd8; border-color:#84cc16; color:#365314;">
                </div>

                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="fullname" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Jabatan</label>
                    <input type="text" name="jabatan" class="form-input" placeholder="Cth: Bendahara" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="password-wrapper">
                        <input type="password" name="password" class="form-input" required>
                        <button type="button" class="toggle-password" onclick="togglePassword(this)"><i class="bi bi-eye"></i></button>
                    </div>
                </div>
                
                <button type="submit" class="btn-submit">Daftar Admin</button>
                <div class="admin-regis-link">
                    <a onclick="cancelAdminRegis()">Kembali ke Login</a>
                </div>
            </form>
        </div>

    </div>

    <!-- PIN Modal -->
    <div class="modal" id="pin-modal">
        <div class="modal-box">
            <h3 style="margin-bottom:15px; font-family:'Playfair Display'">Verifikasi Keamanan</h3>
            <p style="color:#666; margin-bottom:20px; font-size:14px;">Masukkan PIN khusus admin untuk mendaftar akun pengurus baru.</p>
            <input type="password" id="pin-input" class="form-input" placeholder="Masukkan PIN..." style="text-align:center; letter-spacing:5px; font-size:20px; margin-bottom:20px;">
            <div style="display:flex; gap:10px;">
                <button class="btn-submit" onclick="checkPin()" style="background:var(--success)">Verifikasi</button>
                <button class="btn-submit" onclick="document.getElementById('pin-modal').classList.remove('active')" style="background:#ccc; color:#333;">Batal</button>
            </div>
        </div>
    </div>

    <script>
        // Admin Registration Logic
        function showPinModal() {
            document.getElementById('pin-modal').classList.add('active');
        }

        function checkPin() {
            const pin = document.getElementById('pin-input').value;
            // Provide simple client side feedback
            if (pin === 'FKKMBT_Secure_2025') {
                document.getElementById('pin-modal').classList.remove('active');
                // Switch View to Register
                document.getElementById('view-login').classList.remove('active');
                document.getElementById('view-register').classList.add('active');
                // Set hidden inputs
                document.getElementById('pin-input-hidden').value = pin;
            } else {
                alert("PIN Salah!");
            }
        }

        function cancelAdminRegis() {
            document.getElementById('view-register').classList.remove('active');
            document.getElementById('view-login').classList.add('active');
        }

        function togglePassword(btn) {
            const wrapper = btn.closest('.password-wrapper');
            const input = wrapper.querySelector('input');
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
    </script>
</body>
</html>
