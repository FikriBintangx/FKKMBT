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

        /* Mobile Responsiveness */
        @media (max-width: 576px) {
            body {
                padding: 15px;
                align-items: flex-start; /* Allow scrolling more easily if needed */
                padding-top: 40px;
            }
            .portal-card {
                padding: 25px 20px;
                border-radius: 20px;
            }
            .back-link {
                position: relative;
                top: auto; left: auto;
                width: 100%;
                justify-content: center;
                margin-bottom: 20px;
                color: rgba(255,255,255,0.9);
            }
            .portal-header { margin-bottom: 20px; }
            .logo-box { width: 50px; height: 50px; font-size: 24px; }
            .portal-title { font-size: 24px; }
        }
    </style>
</head>
<body>

    <a href="<?= base_url() ?>" class="back-link">
        <i class="bi bi-arrow-left"></i> Kembali ke Beranda
    </a>

    <div class="portal-card">
        <div class="portal-header">
            <div class="logo-box">F</div>
            <h1 class="portal-title">Portal FKKMBT</h1>
            <p class="portal-subtitle">Masuk untuk mengakses layanan warga & admin</p>
        </div>

        <?php if(isset($error_msg) && $error_msg): ?>
            <div class="alert alert-error"><?= $error_msg ?></div>
        <?php endif; ?>
        <?php if(isset($success_msg) && $success_msg): ?>
            <div class="alert alert-success"><?= $success_msg ?></div>
        <?php endif; ?>

        <!-- LOGIN FORM VIEW -->
        <div id="view-login" class="view-section active">
            <form id="login-form" method="POST" action="<?= site_url('auth/login') ?>">
            
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

        <!-- === REGISTER ADMIN SECTION (Hidden) === -->
        <div id="view-register" class="view-section">
                <div class="portal-header mb-3">
                <h2 class="portal-title" style="font-size:24px;">Daftar Pengurus</h2>
            </div>

            <form id="admin-register-form" method="POST" action="<?= site_url('auth/register_admin') ?>">
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
