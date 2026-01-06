-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2026 at 05:36 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fkkmbt_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `jabatan` varchar(50) DEFAULT 'Pengurus'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `user_id`, `nama_lengkap`, `jabatan`) VALUES
(1, 13, 'admin', 'admin'),
(2, 14, 'Aceva', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `admin_notes`
--

CREATE TABLE `admin_notes` (
  `id` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `iuran_master`
--

CREATE TABLE `iuran_master` (
  `id` int(11) NOT NULL,
  `nama_iuran` varchar(100) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `nominal` decimal(10,2) NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `iuran_master`
--

INSERT INTO `iuran_master` (`id`, `nama_iuran`, `keterangan`, `nominal`, `jatuh_tempo`, `status`) VALUES
(1, 'Iuran Kebersihan Januari 2025', NULL, 50000.00, '2025-01-20', 'aktif'),
(2, 'Iuran Keamanan Januari 2025', NULL, 75000.00, '2025-01-20', 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id` int(11) NOT NULL,
  `organisasi_id` int(11) NOT NULL,
  `judul` varchar(200) NOT NULL,
  `deskripsi` text NOT NULL,
  `tanggal` date NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kegiatan`
--

INSERT INTO `kegiatan` (`id`, `organisasi_id`, `judul`, `deskripsi`, `tanggal`, `foto`, `created_at`) VALUES
(1, 1, 'Lomba 17 Agustus', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '2024-08-17', NULL, '2025-12-30 15:03:11'),
(2, 2, 'Pelatihan Memasak', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '2024-09-01', NULL, '2025-12-30 15:03:11'),
(3, 3, 'Ronda Malam Gabungan', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '2024-10-05', NULL, '2025-12-30 15:03:11');

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan_galeri`
--

CREATE TABLE `kegiatan_galeri` (
  `id` int(11) NOT NULL,
  `kegiatan_id` int(11) NOT NULL,
  `file` varchar(255) NOT NULL,
  `tipe_file` enum('image','video') NOT NULL DEFAULT 'image',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `organisasi`
--

CREATE TABLE `organisasi` (
  `id` int(11) NOT NULL,
  `nama_organisasi` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `induk` enum('fkkmbt','fkkmmbt') NOT NULL DEFAULT 'fkkmbt'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organisasi`
--

INSERT INTO `organisasi` (`id`, `nama_organisasi`, `deskripsi`, `induk`) VALUES
(1, 'Karang Taruna', NULL, 'fkkmmbt'),
(2, 'PKK', NULL, 'fkkmbt'),
(3, 'Seksi Keamanan', NULL, 'fkkmbt');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran_iuran`
--

CREATE TABLE `pembayaran_iuran` (
  `id` int(11) NOT NULL,
  `warga_id` int(11) NOT NULL,
  `iuran_id` int(11) NOT NULL,
  `tgl_bayar` datetime DEFAULT current_timestamp(),
  `bukti_transfer` varchar(255) NOT NULL,
  `status` enum('pending','disetujui','ditolak') DEFAULT 'pending',
  `catatan_admin` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `struktur_organisasi`
--

CREATE TABLE `struktur_organisasi` (
  `id` int(11) NOT NULL,
  `tipe_organisasi` varchar(20) NOT NULL DEFAULT 'FKKMBT',
  `nama` varchar(100) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `level` int(11) NOT NULL,
  `urutan` int(11) DEFAULT 0,
  `jenis_kelamin` varchar(10) DEFAULT 'L',
  `foto` varchar(255) DEFAULT NULL,
  `kontak` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `struktur_organisasi`
--

INSERT INTO `struktur_organisasi` (`id`, `tipe_organisasi`, `nama`, `jabatan`, `level`, `urutan`, `jenis_kelamin`, `foto`, `kontak`) VALUES
(1, 'FKKMBT', 'SUPARNO', 'Pembina', 1, 1, 'L', NULL, NULL),
(2, 'FKKMBT', 'PONIMAN', 'Pembina', 1, 2, 'L', NULL, NULL),
(3, 'FKKMBT', 'SAFIK', 'Pembina', 1, 3, 'L', NULL, NULL),
(4, 'FKKMBT', 'H KUSMANTORO', 'Ketua', 1, 4, 'L', NULL, NULL),
(5, 'FKKMBT', 'UST JALALUDIN', 'Penasehat', 1, 5, 'L', NULL, NULL),
(6, 'FKKMBT', 'H AGUS TOMI', 'Penasehat', 1, 6, 'L', NULL, NULL),
(7, 'FKKMBT', 'H TAMAMIL HUDA', 'Penasehat', 1, 7, 'L', NULL, NULL),
(8, 'FKKMBT', 'SUGIONO', 'Bendahara I', 2, 8, 'L', NULL, NULL),
(9, 'FKKMBT', 'SRI HARTATA', 'Bendahara II', 2, 9, 'L', NULL, NULL),
(10, 'FKKMBT', 'WASIS KARYONO', 'Wakil Ketua', 2, 10, 'L', NULL, NULL),
(11, 'FKKMBT', 'KUSNAN JAYA', 'Sekretaris I', 2, 11, 'L', NULL, NULL),
(12, 'FKKMBT', 'SLAMET', 'Sekretaris II', 2, 12, 'L', NULL, NULL),
(13, 'FKKMBT', 'IWA. K', 'Seksi Kesejahteraan', 3, 13, 'L', NULL, NULL),
(14, 'FKKMBT', 'IMANTO', 'Seksi Kesejahteraan', 3, 14, 'L', NULL, NULL),
(15, 'FKKMBT', 'YONO', 'Seksi Pengembangan Ekonomi', 3, 15, 'L', NULL, NULL),
(16, 'FKKMBT', 'AEP S', 'Seksi Pengembangan Ekonomi', 3, 16, 'L', NULL, NULL),
(17, 'FKKMBT', 'ROHADI', 'Seksi Humas, Publikasi dan Komunikasi', 3, 17, 'L', NULL, NULL),
(18, 'FKKMBT', 'YAYAN S', 'Seksi Humas, Publikasi dan Komunikasi', 3, 18, 'L', NULL, NULL),
(19, 'FKKMBT', 'PUNDI', 'Seksi Humas, Publikasi dan Komunikasi', 3, 19, 'L', NULL, NULL),
(20, 'FKKMBT', 'DEDEN IRWAN', 'Seksi Kepemudaan dan Olahraga', 3, 20, 'L', NULL, NULL),
(21, 'FKKMBT', 'DIDIK', 'Seksi Kepemudaan dan Olahraga', 3, 21, 'L', NULL, NULL),
(22, 'FKKMBT', 'IIS ISKANDAR', 'Seksi Perencanaan Lingkungan', 3, 22, 'L', NULL, NULL),
(23, 'FKKMBT', 'AYO', 'Seksi Perencanaan Lingkungan', 3, 23, 'L', NULL, NULL),
(24, 'FKKMBT', 'BIO', 'Seksi Seni dan Budaya', 3, 24, 'L', NULL, NULL),
(25, 'FKKMBT', 'TEKAD', 'Seksi Seni dan Budaya', 3, 25, 'L', NULL, NULL),
(26, 'FKKMBT', 'H. DARCA S', 'Seksi Kerohanian', 3, 26, 'L', NULL, NULL),
(27, 'FKKMBT', 'SUKIRNA', 'Seksi Kerohanian', 3, 27, 'L', NULL, NULL),
(28, 'FKKMBT', 'CIPTO W', 'Seksi Keamanan', 3, 28, 'L', NULL, NULL),
(29, 'FKKMBT', 'PURJITO', 'Seksi Keamanan', 3, 29, 'L', NULL, NULL),
(30, 'FKKMBT', 'KAZMANI', 'Seksi Perlengkapan', 3, 30, 'L', NULL, NULL),
(31, 'FKKMBT', 'DUDUNG', 'Seksi Perlengkapan', 3, 31, 'L', NULL, NULL),
(32, 'FKKMBT', 'SISWANTO', 'Seksi Perlengkapan', 3, 32, 'L', NULL, NULL),
(33, 'FKKMBT', 'ISMAIL MARZUKI', 'Seksi Perlengkapan', 3, 33, 'L', NULL, NULL),
(34, 'FKKMBT', 'IBU RW DAN RT', 'Seksi Kewanitaan', 3, 34, 'P', NULL, NULL),
(40, 'FKKMMBT', 'Aceva Arie Sadewa', 'Ketua Umum', 1, 0, 'L', NULL, NULL),
(41, 'FKKMMBT', 'Rina Wati', 'Wakil Ketua', 2, 0, 'L', NULL, NULL),
(42, 'FKKMMBT', 'Ahmad Dani', 'Sekretaris I', 3, 0, 'L', NULL, NULL),
(43, 'FKKMMBT', 'Siti Badriah', 'Sekretaris II', 3, 0, 'L', NULL, NULL),
(44, 'FKKMMBT', 'Budi Doremi', 'Bendahara I', 3, 0, 'L', NULL, NULL),
(45, 'FKKMMBT', 'Via Vallen', 'Bendahara II', 3, 0, 'L', NULL, NULL),
(46, 'FKKMMBT', 'Dedi Corbuz', 'Divisi Kepemudaan', 4, 0, 'L', NULL, NULL),
(47, 'FKKMMBT', 'Cinta Laura', 'Divisi Kreatif', 4, 0, 'L', NULL, NULL),
(48, 'FKKMMBT', 'Atta Halilintar', 'Divisi Humas', 4, 0, 'L', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','warga') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'agussantoso80', '$2y$10$XxkxU5YvPTOsdb6eeddj/e5duYv3Lf87knLwlpal5oc98lGYt4kku', 'warga'),
(2, 'budihartono2', '$2y$10$Y5B2Vht9l1ie9sN79X5iC.4tGB4yyYAlygWkq4mQehcb7Dqe6hZiW', 'warga'),
(3, 'citralestari12', '$2y$10$ol25HlCLR5XFuSxUVHs57.O.zwl0tV3hvuBHaqN5QMkXtchF0gzaC', 'warga'),
(4, 'dewipersik57', '$2y$10$NQ8S1XJBVp4pRA7P4KTezOp2UWsXzFMojxKCd7Mo3YgNekBPUnxnK', 'warga'),
(5, 'ekoyulianto49', '$2y$10$d/AZEtbj5IESMc/vwk0Rle3kikgcVdDH01Sa0KAm4fVDsg7vemTx.', 'warga'),
(6, 'fajarsadboy55', '$2y$10$moA/DZEUyw1HP6IYyZJb6OSjzHimZdhJgeXiTV.NGfCPEImzOOfn2', 'warga'),
(7, 'gitagutawa10', '$2y$10$s6toNuwRlSDJNzZXbRSJTew7Boz6I4svwaWVSSrZuyLhHemeV7boG', 'warga'),
(8, 'hestipurwadinata61', '$2y$10$xeQvP4GsYuX/m8egYv3WTeHfj3tSkwxqjS6zo/QJOpI/pnvE1o3uW', 'warga'),
(9, 'indrabekti29', '$2y$10$i/Wuj4KwFCf/y5HwXU8Iw.8XnQ1Tmn90Zl8Q7QitTsauy3.EBg20a', 'warga'),
(10, 'jokosasongko65', '$2y$10$GZ35uof2GXCinaTYlCw08uk4Ge2A2IN7./UI9qc3/3zHNVD678A/G', 'warga'),
(13, 'admin@gmail.com', '$2y$10$wGIz5eYQsOeDlKShe7vETO43u0O13VVrx61W0Oz3p3GcVDBWUVTIi', 'admin'),
(14, 'aceva@gmail.com', '$2y$10$x/EYCGzA1usY6Z//7Rymz.Z4.QuYICfzC8yPX2MMDbVX3.tYpqarO', 'admin'),
(16, 'test1@gmail.com90', 'test123', 'warga');

-- --------------------------------------------------------

--
-- Table structure for table `warga`
--

CREATE TABLE `warga` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `blok` varchar(10) NOT NULL,
  `no_rumah` varchar(10) NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `foto_profil` varchar(255) DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT 'L'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `warga`
--

INSERT INTO `warga` (`id`, `user_id`, `nama_lengkap`, `blok`, `no_rumah`, `no_hp`, `foto_profil`, `jenis_kelamin`) VALUES
(1, 1, 'Agus Santoso', 'D2', '9', '', NULL, 'L'),
(2, 2, 'Budi Hartono', 'A', '10', NULL, NULL, 'L'),
(3, 3, 'Citra Lestari', 'A', '40', NULL, NULL, 'L'),
(4, 4, 'Dewi Persik', 'B', '13', NULL, NULL, 'L'),
(5, 5, 'Eko Yulianto', 'B', '3', NULL, NULL, 'L'),
(6, 6, 'Fajar Sadboy', 'D', '38', NULL, NULL, 'L'),
(7, 7, 'Gita Gutawa', 'C', '37', NULL, NULL, 'L'),
(8, 8, 'Hesti Purwadinata', 'A', '39', NULL, NULL, 'L'),
(9, 9, 'Indra Bekti', 'B', '9', NULL, NULL, 'L'),
(10, 10, 'Joko Sasongko', 'C', '16', NULL, NULL, 'L'),
(13, 16, 'test1@gmail.com', 'A1', '21', '-', NULL, 'L');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `admin_notes`
--
ALTER TABLE `admin_notes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tanggal` (`tanggal`);

--
-- Indexes for table `iuran_master`
--
ALTER TABLE `iuran_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `organisasi_id` (`organisasi_id`);

--
-- Indexes for table `kegiatan_galeri`
--
ALTER TABLE `kegiatan_galeri`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kegiatan_id` (`kegiatan_id`);

--
-- Indexes for table `organisasi`
--
ALTER TABLE `organisasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembayaran_iuran`
--
ALTER TABLE `pembayaran_iuran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `warga_id` (`warga_id`),
  ADD KEY `iuran_id` (`iuran_id`);

--
-- Indexes for table `struktur_organisasi`
--
ALTER TABLE `struktur_organisasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `warga`
--
ALTER TABLE `warga`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_notes`
--
ALTER TABLE `admin_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `iuran_master`
--
ALTER TABLE `iuran_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kegiatan_galeri`
--
ALTER TABLE `kegiatan_galeri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `organisasi`
--
ALTER TABLE `organisasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pembayaran_iuran`
--
ALTER TABLE `pembayaran_iuran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `struktur_organisasi`
--
ALTER TABLE `struktur_organisasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `warga`
--
ALTER TABLE `warga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `fk_admin_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD CONSTRAINT `kegiatan_ibfk_1` FOREIGN KEY (`organisasi_id`) REFERENCES `organisasi` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kegiatan_galeri`
--
ALTER TABLE `kegiatan_galeri`
  ADD CONSTRAINT `kegiatan_galeri_ibfk_1` FOREIGN KEY (`kegiatan_id`) REFERENCES `kegiatan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pembayaran_iuran`
--
ALTER TABLE `pembayaran_iuran`
  ADD CONSTRAINT `fk_bayar_iuran` FOREIGN KEY (`iuran_id`) REFERENCES `iuran_master` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_bayar_warga` FOREIGN KEY (`warga_id`) REFERENCES `warga` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `warga`
--
ALTER TABLE `warga`
  ADD CONSTRAINT `warga_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
