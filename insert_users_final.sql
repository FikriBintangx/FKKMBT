-- =============================================
-- INSERT DATA ADMIN DAN WARGA - FKKMBT
-- =============================================
-- Jalankan script ini di phpMyAdmin setelah database sudah dibuat
-- Database: fkkmbt_db atau ti2b8143_fkkmbt (sesuaikan dengan nama database Anda)

-- =============================================
-- 1. INSERT ADMIN
-- =============================================
-- Username: StaffFkkmbt
-- Password: staff123

INSERT INTO `users` (`username`, `password`, `role`) VALUES
('StaffFkkmbt', '$2y$10$idnRrPUEEFhiLM73CvtyL.zLKTniEHxAPL5cWfBHJjsjwrzV1SlX6', 'admin');

INSERT INTO `admins` (`user_id`, `nama_lengkap`, `jabatan`) VALUES
(LAST_INSERT_ID(), 'Staff FKKMBT', 'Administrator');

-- =============================================
-- 2. INSERT WARGA
-- =============================================
-- Username: aceva
-- Password: 160704
-- Nama: Aceva Arie Sadewa
-- Blok: J, No. 4

INSERT INTO `users` (`username`, `password`, `role`) VALUES
('aceva', '$2y$10$nBJSb70nMl2.Z1C1IZpFU.baV5ZehWg6e4mtydVHo0zzK8UKSs0bi', 'warga');

INSERT INTO `warga` (`user_id`, `nama_lengkap`, `blok`, `no_rumah`, `no_hp`, `jenis_kelamin`) VALUES
(LAST_INSERT_ID(), 'Aceva Arie Sadewa', 'J', '4', '087786720942', 'L');

-- =============================================
-- SELESAI
-- =============================================
-- Setelah menjalankan script ini, Anda bisa login dengan:
-- 
-- ADMIN:
-- Username: StaffFkkmbt
-- Password: staff123
-- 
-- WARGA:
-- Username: aceva
-- Password: 160704
-- =============================================
