# Form Admin - FKKMBT

## 📋 Deskripsi

Form registrasi dan login khusus untuk administrator sistem FKKMBT dengan keamanan PIN.

## 🔐 Fitur Keamanan

### PIN Admin: `fkkmbt`

PIN ini diperlukan untuk:

- Registrasi akun admin baru
- Login ke sistem admin

## 📄 File yang Dibuat

### 1. `admin_register.php`

Form registrasi untuk membuat akun admin baru.

**Fitur:**

- ✅ Validasi PIN khusus admin (`fkkmbt`)
- ✅ Input nama lengkap, jabatan, username, password
- ✅ Konfirmasi password
- ✅ Password hashing menggunakan `password_hash()`
- ✅ Auto-insert ke tabel `users` (role: admin) dan `admins`
- ✅ Desain modern dengan gradient background
- ✅ Toggle show/hide password
- ✅ Responsive design

**Field yang Diisi:**

1. PIN Admin (harus: `fkkmbt`)
2. Nama Lengkap
3. Jabatan (contoh: Ketua Sekretariat)
4. Username (unique)
5. Password
6. Konfirmasi Password

### 2. `admin_login.php`

Form login khusus untuk admin.

**Fitur:**

- ✅ Validasi PIN khusus admin (`fkkmbt`)
- ✅ Verifikasi username & password
- ✅ Hanya akun dengan role `admin` yang bisa login
- ✅ Session management
- ✅ Redirect ke `admin/dashboard.php` setelah berhasil login
- ✅ Animasi dan transisi yang smooth
- ✅ Visual statistik keamanan
- ✅ Link kembali ke beranda

**Login Flow:**

1. User memasukkan PIN admin
2. User memasukkan username
3. User memasukkan password
4. Sistem validasi: PIN → Role → Password
5. Jika berhasil → Redirect ke dashboard admin

## 🎨 Desain

### Color Palette

- **Primary**: `#6366f1` (Indigo)
- **Primary Dark**: `#4f46e5`
- **Secondary**: `#f59e0b` (Amber)
- **Success**: `#10b981` (Green)
- **Danger**: `#ef4444` (Red)

### Font

- **Google Font**: Inter (Weight: 400, 500, 600, 700, 800)

### Elemen Visual

- ✨ Gradient backgrounds
- 🎭 Glassmorphism effects
- 🌊 Floating animations
- ⚡ Smooth transitions
- 💫 Pulse animations
- 🎯 Micro-interactions

## 🗄️ Struktur Database

### Tabel `users`

```sql
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','warga') NOT NULL DEFAULT 'warga',
  `created_at` timestamp DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
);
```

### Tabel `admins`

```sql
CREATE TABLE `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `jabatan` varchar(50) DEFAULT 'Pengurus',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `fk_admin_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
);
```

## 🚀 Cara Penggunaan

### 1. Registrasi Admin Pertama Kali

1. Buka browser: `http://localhost/fkkmbt/admin_register.php`
2. Masukkan PIN: `fkkmbt`
3. Isi form lengkap
4. Klik "Daftar Sebagai Admin"
5. Redirect otomatis ke halaman login

### 2. Login sebagai Admin

1. Buka browser: `http://localhost/fkkmbt/admin_login.php`
2. Masukkan PIN: `fkkmbt`
3. Masukkan username admin
4. Masukkan password
5. Klik "Masuk ke Dashboard"
6. Redirect ke `admin/dashboard.php`

### 3. Login dari Halaman Utama

Tambahkan link di `index.php`:

```html
<a href="admin_login.php" class="btn btn-primary">
  <i class="bi bi-shield-lock"></i> Login Admin
</a>
```

## 📱 Responsive Design

- ✅ Desktop (> 768px): Two-column layout
- ✅ Mobile (≤ 768px): Single column, visual panel hidden
- ✅ Touch-friendly buttons
- ✅ Optimal spacing untuk semua device

## 🔒 Security Features

1. **PIN Protection**: Extra layer dengan PIN khusus
2. **Password Hashing**: Menggunakan `password_hash()` dan `password_verify()`
3. **SQL Injection Prevention**: Menggunakan `real_escape_string()`
4. **Role Validation**: Hanya role `admin` yang bisa akses
5. **Session Management**: Data admin disimpan di session

## 📊 Session Variables

Setelah login berhasil, data berikut tersimpan di session:

```php
$_SESSION['user_id']       // ID user
$_SESSION['username']      // Username
$_SESSION['role']          // 'admin'
$_SESSION['nama_lengkap']  // Nama lengkap admin
$_SESSION['jabatan']       // Jabatan admin
```

## 🎯 Next Steps

1. **Update `index.php`**: Tambah link ke admin login
2. **Protect Admin Pages**: Tambah auth check di semua halaman admin
3. **Create Auth Middleware**: Buat file untuk check session
4. **Logout Function**: Tambah fungsi logout
5. **Forgot Password**: Implementasi reset password (opsional)

## 📝 Notes

- PIN admin (`fkkmbt`) bersifat hardcoded untuk keamanan tambahan
- Jika ingin mengubah PIN, edit di kedua file (register & login)
- Pastikan database sudah diimport (`database/schema.sql`)
- Default timezone sudah diset ke +07:00 (WIB)

## 🛠️ Troubleshooting

### Error: Username sudah ada

- Gunakan username yang unik
- Check database untuk melihat username yang sudah terpakai

### Error: PIN salah

- Pastikan memasukkan: `fkkmbt` (lowercase, tanpa spasi)

### Redirect tidak berfungsi

- Check apakah `admin/dashboard.php` sudah ada
- Pastikan tidak ada output sebelum `header()`

### CSS tidak muncul

- Check koneksi internet (menggunakan CDN Bootstrap & Google Fonts)
- Clear browser cache

---

**Created by**: Antigravity AI Assistant  
**Date**: 2025-12-30  
**Version**: 1.0



login admin : admin@gmail.com
password admin : admin123
