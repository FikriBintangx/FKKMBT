-- Database: fkkmbt_db
-- Final Fixed Version

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+07:00";

-- --------------------------------------------------------

-- Table structure for table `users`
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
CREATE TABLE `warga` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `blok` varchar(5) NOT NULL,
  `no_rumah` varchar(10) NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `foto_profil` varchar(255) DEFAULT 'default.png',
  `jenis_kelamin` enum('L','P') DEFAULT 'L',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `fk_warga_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

-- Table structure for table `organisasi`
CREATE TABLE `organisasi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_organisasi` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

-- Table structure for table `struktur_organisasi`
CREATE TABLE `struktur_organisasi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `level` int(11) DEFAULT 99,
  `tipe_organisasi` enum('FKKMBT','FKKMMBT') DEFAULT 'FKKMBT',
  `jenis_kelamin` enum('L','P') DEFAULT 'L',
  `kontak` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

-- Table structure for table `kegiatan`
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

-- Table structure for table `kegiatan_galeri`
CREATE TABLE `kegiatan_galeri` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kegiatan_id` int(11) NOT NULL,
  `file` varchar(255) NOT NULL,
  `tipe_file` enum('gambar','video') DEFAULT 'gambar',
  PRIMARY KEY (`id`),
  KEY `kegiatan_id` (`kegiatan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

-- Table structure for table `iuran_master`
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

-- Dump Data

INSERT INTO `users` (`username`, `password`, `role`) VALUES
('admin', '$2y$10$C8q.J.0/examplehash...', 'admin'), 
('warga1', '$2y$10$C8q.J.0/examplehash...', 'warga');

INSERT INTO `admins` (`user_id`, `nama_lengkap`, `jabatan`) VALUES
(1, 'Admin FKKMBT', 'Ketua Sekretariat');

INSERT INTO `warga` (`user_id`, `nama_lengkap`, `blok`, `no_rumah`, `no_hp`) VALUES
(2, 'Budi Santoso', 'A', '12', '081234567890');

INSERT INTO `organisasi` (`nama_organisasi`, `deskripsi`) VALUES
('FKKMBT', 'Forum Komunikasi Koordinasi Masyarakat Bukit Tiara'),
('Karang Taruna', 'Organisasi pemuda perumahan Bukit Tiara'),
('PKK', 'Pemberdayaan Kesejahteraan Keluarga');

COMMIT;
