-- Database: fkkmbt_db

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+07:00";

-- --------------------------------------------------------

-- Table structure for table `users`
-- Berfungsi untuk autentikasi login baik admin maupun warga
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','warga') NOT NULL DEFAULT 'warga',
  `created_at` timestamp DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

-- Table structure for table `admins`
-- Data profil admin
CREATE TABLE `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `jabatan` varchar(50) DEFAULT 'Pengurus',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `fk_admin_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

-- Table structure for table `warga`
-- Data profil warga
CREATE TABLE `warga` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `blok` varchar(5) NOT NULL,
  `no_rumah` varchar(10) NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `foto_profil` varchar(255) DEFAULT 'default.png',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `fk_warga_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

-- Table structure for table `organisasi`
-- Daftar organisasi di dalam FKKMBT (misal: Karang Taruna, PKK, Keamanan)
CREATE TABLE `organisasi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_organisasi` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

-- Table structure for table `kegiatan`
-- Daftar kegiatan per organisasi
CREATE TABLE `kegiatan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organisasi_id` int(11) NOT NULL,
  `judul` varchar(200) NOT NULL,
  `deskripsi` text NOT NULL,
  `tanggal` date NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `organisasi_id` (`organisasi_id`),
  CONSTRAINT `fk_kegiatan_organisasi` FOREIGN KEY (`organisasi_id`) REFERENCES `organisasi` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

-- Table structure for table `iuran_master`
-- Jenis iuran yang harus dibayar (misal: Iuran Kebersihan Jan 2024)
CREATE TABLE `iuran_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_iuran` varchar(100) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `nominal` decimal(10,2) NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

-- Table structure for table `pembayaran_iuran`
-- Transaksi pembayaran warga
CREATE TABLE `pembayaran_iuran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `warga_id` int(11) NOT NULL,
  `iuran_id` int(11) NOT NULL,
  `tgl_bayar` datetime DEFAULT current_timestamp(),
  `bukti_transfer` varchar(255) NOT NULL,
  `status` enum('pending','disetujui','ditolak') DEFAULT 'pending',
  `catatan_admin` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `warga_id` (`warga_id`),
  KEY `iuran_id` (`iuran_id`),
  CONSTRAINT `fk_bayar_warga` FOREIGN KEY (`warga_id`) REFERENCES `warga` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_bayar_iuran` FOREIGN KEY (`iuran_id`) REFERENCES `iuran_master` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

-- Dummp Data
-- Password default: "123456" (hashed using password_hash PASSWORD_DEFAULT)
-- Hash untuk 123456: $2y$10$2.uU.H.0/examplehash... (example only, we will use PHP to generate)

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '$2y$10$sW1.0.0/0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0...', 'admin'), 
(2, 'warga1', '$2y$10$sW1.0.0/0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0...', 'warga');
-- Note: Replace hash with real running php password_hash('123456', PASSWORD_DEFAULT)

INSERT INTO `admins` (`user_id`, `nama_lengkap`, `jabatan`) VALUES
(1, 'Admin FKKMBT', 'Ketua Sekretariat');

INSERT INTO `warga` (`user_id`, `nama_lengkap`, `blok`, `no_rumah`, `no_hp`) VALUES
(2, 'Budi Santoso', 'A', '12', '081234567890');

INSERT INTO `organisasi` (`nama_organisasi`, `deskripsi`) VALUES
('Karang Taruna', 'Organisasi pemuda perumahan Bukit Tiara'),
('PKK', 'Pemberdayaan Kesejahteraan Keluarga');

-- Note: User MUST import this SQL to phpMyAdmin
COMMIT;
