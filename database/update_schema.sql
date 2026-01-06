-- Disable foreign key checks to allow truncation
SET FOREIGN_KEY_CHECKS = 0;

-- 1. ALTER TABLE skipped because column 'induk' already exists based on your error.
-- If anyone else runs this and needs the column, uncomment the line below:
-- ALTER TABLE `organisasi` ADD COLUMN `induk` ENUM('fkkmbt', 'fkkmmbt') NOT NULL DEFAULT 'fkkmbt';

-- 2. Reset Data Organisasi (Unit/Seksi)
TRUNCATE TABLE `organisasi`;

INSERT INTO `organisasi` (`id`, `nama_organisasi`, `induk`) VALUES 
(1, 'Seksi Keamanan', 'fkkmbt'),
(2, 'Seksi Kebersihan', 'fkkmbt'),
(3, 'Seksi Pembangunan', 'fkkmbt'),
(4, 'Seksi Kerohanian', 'fkkmbt'),
(5, 'Seksi Sosial & Kematian', 'fkkmbt'),
(6, 'Humas', 'fkkmbt'),
(7, 'Karang Taruna', 'fkkmmbt'),
(8, 'Tim Kreatif', 'fkkmmbt'),
(9, 'Seksi Olahraga', 'fkkmmbt'),
(10, 'Divisi Event', 'fkkmmbt');

-- 3. Ensure Galeri Table Exists
CREATE TABLE IF NOT EXISTS `kegiatan_galeri` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kegiatan_id` int(11) NOT NULL,
  `file` varchar(255) NOT NULL,
  `tipe` enum('image','video') NOT NULL DEFAULT 'image',
  `created_at` timestamp DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`kegiatan_id`) REFERENCES `kegiatan` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Reset Struktur Organisasi (Flowchart Data)
TRUNCATE TABLE `struktur_organisasi`;

-- FKKMBT Structure (Bapak2)
INSERT INTO `struktur_organisasi` (`nama`, `jabatan`, `level`, `tipe_organisasi`) VALUES 
('Aceva Arie Sadewa', 'Ketua Umum', 1, 'fkkmbt'),
('Hendra Gunawan', 'Wakil Ketua', 2, 'fkkmbt'),
('Budi Santoso', 'Sekretaris', 2, 'fkkmbt'),
('Siti Aminah', 'Bendahara', 2, 'fkkmbt'),
('Joko Widodo', 'Koord. Keamanan', 3, 'fkkmbt'),
('Bambang P', 'Koord. Kebersihan', 3, 'fkkmbt');

-- FKKMMBT Structure (Muda Mudi)
INSERT INTO `struktur_organisasi` (`nama`, `jabatan`, `level`, `tipe_organisasi`) VALUES 
('Kusmantoro', 'Ketua FKKMMBT', 1, 'fkkmmbt'),
('Rina Wati', 'Wakil Ketua', 2, 'fkkmmbt'),
('Ahmad Dani', 'Sekretaris', 2, 'fkkmmbt'),
('Dedi Corbuz', 'Ketua Karang Taruna', 3, 'fkkmmbt'),
('Cinta Laura', 'Divisi Kreatif', 3, 'fkkmmbt');

-- Re-enable checks
SET FOREIGN_KEY_CHECKS = 1;
