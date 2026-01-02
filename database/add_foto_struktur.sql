-- Add foto column to struktur_organisasi if not exists
ALTER TABLE `struktur_organisasi` ADD COLUMN IF NOT EXISTS `foto` VARCHAR(255) DEFAULT NULL AFTER `nama`;

-- You can now upload photos via admin panel (admin/organisasi.php)
-- Photos will be stored in assets/images/pengurus/
