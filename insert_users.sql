-- Insert Data Admin dan Warga untuk FKKMBT
-- Jalankan script ini di phpMyAdmin setelah database sudah dibuat

-- =============================================
-- 1. INSERT ADMIN: StaffFkkmbt (password: staff123)
-- =============================================

-- Insert ke tabel users (untuk login)
INSERT INTO `users` (`username`, `password`, `role`) VALUES
('StaffFkkmbt', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');
-- Password hash untuk 'staff123' (gunakan password_hash('staff123', PASSWORD_DEFAULT) di PHP)

-- Insert ke tabel admins (profil admin)
INSERT INTO `admins` (`user_id`, `nama_lengkap`, `jabatan`) VALUES
(LAST_INSERT_ID(), 'Staff FKKMBT', 'Administrator');

-- =============================================
-- 2. INSERT WARGA: Aceva Arie Sadewa (password: 160704)
-- =============================================

-- Insert ke tabel users (untuk login)
INSERT INTO `users` (`username`, `password`, `role`) VALUES
('aceva', '$2y$10$vI3Z8KqXH5yH5yH5yH5yH5yH5yH5yH5yH5yH5yH5yH5yH5yH5yH5y', 'warga');
-- Password hash untuk '160704' (gunakan password_hash('160704', PASSWORD_DEFAULT) di PHP)

-- Insert ke tabel warga (profil warga)
INSERT INTO `warga` (`user_id`, `nama_lengkap`, `blok`, `no_rumah`, `no_hp`, `jenis_kelamin`) VALUES
(LAST_INSERT_ID(), 'Aceva Arie Sadewa', 'J', '4', '081234567890', 'L');

-- =============================================
-- CATATAN PENTING:
-- =============================================
-- Password hash di atas adalah CONTOH. Untuk keamanan yang lebih baik,
-- generate hash yang sebenarnya menggunakan PHP:
-- 
-- Untuk Admin (staff123):
-- <?php echo password_hash('staff123', PASSWORD_DEFAULT); ?>
-- 
-- Untuk Warga (160704):
-- <?php echo password_hash('160704', PASSWORD_DEFAULT); ?>
--
-- Atau gunakan script PHP di bawah ini untuk generate hash yang benar:
