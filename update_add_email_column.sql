-- =============================================
-- UPDATE DATABASE SCHEMA - ADD EMAIL COLUMN
-- =============================================
-- Jalankan SQL ini untuk menambahkan kolom email

-- 1. Tambah kolom email di tabel users
ALTER TABLE `users` 
ADD COLUMN `email` VARCHAR(100) NULL AFTER `username`,
ADD UNIQUE KEY `email` (`email`);

-- 2. Update existing users dengan email dummy (opsional, untuk data lama)
-- UPDATE `users` SET `email` = CONCAT(username, '@fkkmbt.or.id') WHERE `email` IS NULL;

-- 3. Tambah kolom email di tabel warga (untuk display)
ALTER TABLE `warga` 
ADD COLUMN `email` VARCHAR(100) NULL AFTER `no_hp`;

-- =============================================
-- SELESAI
-- =============================================
-- Setelah ini, sistem login akan menggunakan EMAIL
-- Admin akan auto-generate email dari nama warga
-- =============================================
