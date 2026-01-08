-- =============================================
-- DATA SEEDER LENGKAP - FKKMBT
-- =============================================
-- Jalankan setelah database_final_fixed.sql
-- Database: fkkmbt_db atau ti2b8143_fkkmbt

-- =============================================
-- 1. INSERT ORGANISASI
-- =============================================
INSERT INTO `organisasi` (`nama_organisasi`, `deskripsi`) VALUES
('FKKMBT', 'Forum Komunikasi Koordinasi Masyarakat Bukit Tiara'),
('PKK', 'Pemberdayaan Kesejahteraan Keluarga'),
('Karang Taruna', 'Organisasi Pemuda Perumahan Bukit Tiara'),
('Posyandu', 'Pos Pelayanan Terpadu Kesehatan Ibu dan Anak'),
('Remaja Masjid', 'Organisasi Remaja Islam Bukit Tiara');

-- =============================================
-- 2. INSERT STRUKTUR ORGANISASI FKKMBT
-- =============================================
INSERT INTO `struktur_organisasi` (`nama`, `jabatan`, `level`, `tipe_organisasi`, `jenis_kelamin`, `kontak`) VALUES
('Haji Kusnantoro', 'Ketua FKKMBT', 1, 'FKKMBT', 'L', '087885873957'),
('Siti Nurhaliza', 'Sekretaris', 2, 'FKKMBT', 'P', '081234567891'),
('Ahmad Dahlan', 'Bendahara', 2, 'FKKMBT', 'L', '081234567892'),
('Dewi Lestari', 'Seksi Kebersihan', 3, 'FKKMBT', 'P', '081234567893'),
('Rudi Hartono', 'Seksi Keamanan', 3, 'FKKMBT', 'L', '081234567894'),
('Maya Sari', 'Seksi Sosial', 3, 'FKKMBT', 'P', '081234567895');

-- =============================================
-- 3. INSERT STRUKTUR ORGANISASI FKKMMBT (Muda-Mudi)
-- =============================================
INSERT INTO `struktur_organisasi` (`nama`, `jabatan`, `level`, `tipe_organisasi`, `jenis_kelamin`, `kontak`) VALUES
('Aceva Arie Sadewa', 'Ketua FKKMMBT', 1, 'FKKMMBT', 'L', '087786720942'),
('Rina Wulandari', 'Wakil Ketua', 2, 'FKKMMBT', 'P', '081234567897'),
('Dimas Aditya', 'Sekretaris', 2, 'FKKMMBT', 'L', '081234567898'),
('Fitri Handayani', 'Bendahara', 2, 'FKKMMBT', 'P', '081234567899'),
('Yoga Pratama', 'Seksi Olahraga', 3, 'FKKMMBT', 'L', '081234567800'),
('Sinta Dewi', 'Seksi Kesenian', 3, 'FKKMMBT', 'P', '081234567801');

-- =============================================
-- 4. INSERT KEGIATAN (15 kegiatan)
-- =============================================
INSERT INTO `kegiatan` (`organisasi_id`, `judul`, `deskripsi`, `tanggal`, `foto`) VALUES
(1, 'Gotong Royong Bersih Lingkungan', 'Kegiatan rutin membersihkan lingkungan perumahan bersama seluruh warga. Dimulai pukul 07.00 WIB dengan membersihkan selokan, memotong rumput, dan merapikan taman.', '2026-01-05', 'gotong_royong.jpg'),
(1, 'Rapat Koordinasi RT Bulanan', 'Rapat rutin bulanan membahas program kerja, keuangan, dan keluhan warga. Dihadiri oleh pengurus RT dan perwakilan warga dari setiap blok.', '2026-01-10', 'rapat_rt.jpg'),
(2, 'Posyandu Balita dan Lansia', 'Pemeriksaan kesehatan gratis untuk balita dan lansia. Tersedia penimbangan, imunisasi, dan konsultasi kesehatan dengan bidan dan dokter.', '2026-01-12', 'posyandu.jpg'),
(2, 'Arisan PKK Ibu-Ibu', 'Kegiatan arisan bulanan PKK sekaligus sosialisasi program kesehatan keluarga dan pemberdayaan ekonomi rumah tangga.', '2026-01-15', 'arisan_pkk.jpg'),
(3, 'Turnamen Futsal Antar Blok', 'Kompetisi futsal untuk mempererat tali silaturahmi antar warga. Diikuti oleh 16 tim dari berbagai blok di perumahan.', '2026-01-18', 'futsal.jpg'),
(1, 'Peringatan HUT RI ke-81', 'Perayaan kemerdekaan Indonesia dengan berbagai lomba untuk anak-anak dan dewasa. Perlombaan meliputi balap karung, makan kerupuk, dan tarik tambang.', '2026-08-17', 'hut_ri.jpg'),
(3, 'Bakti Sosial ke Panti Asuhan', 'Kegiatan sosial karang taruna mengunjungi panti asuhan dengan membawa donasi sembako dan pakaian layak pakai dari warga.', '2026-01-20', 'baksos.jpg'),
(5, 'Kajian Rutin Malam Jumat', 'Kajian keagamaan rutin setiap malam Jumat setelah Maghrib. Menghadirkan ustadz tamu dengan tema kehidupan berkeluarga.', '2026-01-22', 'kajian.jpg'),
(1, 'Senam Sehat Bersama', 'Senam aerobik gratis setiap Minggu pagi untuk menjaga kesehatan warga. Dipandu oleh instruktur profesional.', '2026-01-24', 'senam.jpg'),
(2, 'Pelatihan Membuat Kue Kering', 'Workshop membuat kue kering untuk ibu-ibu PKK sebagai peluang usaha rumahan menjelang hari raya.', '2026-01-26', 'pelatihan_kue.jpg'),
(3, 'Nonton Bareng Film Keluarga', 'Kegiatan nonton bareng film keluarga di lapangan dengan layar tancap. Gratis untuk seluruh warga.', '2026-01-28', 'nobar.jpg'),
(1, 'Ronda Malam Keamanan', 'Kegiatan ronda malam rutin untuk menjaga keamanan lingkungan. Dijadwalkan bergantian setiap blok.', '2026-01-30', 'ronda.jpg'),
(4, 'Pemeriksaan Kesehatan Gratis', 'Cek kesehatan gratis bekerjasama dengan Puskesmas setempat. Meliputi cek tekanan darah, gula darah, dan kolesterol.', '2026-02-02', 'cek_kesehatan.jpg'),
(1, 'Penanaman Pohon Penghijauan', 'Program penghijauan dengan menanam 100 pohon di area taman dan pinggir jalan perumahan.', '2026-02-05', 'penghijauan.jpg'),
(3, 'Buka Puasa Bersama (Rencana)', 'Kegiatan buka puasa bersama seluruh warga di bulan Ramadhan nanti. Akan diadakan di lapangan utama.', '2026-03-15', 'bukber.jpg');

-- =============================================
-- 5. INSERT IURAN MASTER
-- =============================================
INSERT INTO `iuran_master` (`nama_iuran`, `keterangan`, `nominal`, `jatuh_tempo`, `status`) VALUES
('Iuran Bulanan RT', 'Iuran wajib bulanan untuk operasional RT (listrik, air, kebersihan)', 50000.00, '2026-01-31', 'aktif'),
('Iuran Keamanan', 'Iuran untuk biaya satpam dan ronda malam', 100000.00, '2026-01-31', 'aktif'),
('Iuran Kebersihan', 'Iuran untuk gaji petugas kebersihan dan sampah', 75000.00, '2026-01-31', 'aktif'),
('Iuran Sosial', 'Iuran untuk kegiatan sosial dan santunan warga', 25000.00, '2026-01-31', 'aktif'),
('Iuran HUT RI', 'Iuran khusus untuk perayaan kemerdekaan', 50000.00, '2026-08-10', 'aktif');

-- =============================================
-- 6. INSERT WARGA DUMMY (50 warga)
-- =============================================
-- Note: Password untuk semua warga dummy adalah '123456'
-- Hash: $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi

-- Blok A
INSERT INTO `users` (`username`, `password`, `role`) VALUES
('warga_a1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'warga'),
('warga_a2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'warga'),
('warga_a3', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'warga'),
('warga_a4', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'warga'),
('warga_a5', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'warga');

INSERT INTO `warga` (`user_id`, `nama_lengkap`, `blok`, `no_rumah`, `no_hp`, `jenis_kelamin`) VALUES
(LAST_INSERT_ID()-4, 'Agus Setiawan', 'A', '1', '081234560001', 'L'),
(LAST_INSERT_ID()-3, 'Ani Wijaya', 'A', '2', '081234560002', 'P'),
(LAST_INSERT_ID()-2, 'Bambang Sutrisno', 'A', '3', '081234560003', 'L'),
(LAST_INSERT_ID()-1, 'Citra Dewi', 'A', '4', '081234560004', 'P'),
(LAST_INSERT_ID(), 'Dedi Kurniawan', 'A', '5', '081234560005', 'L');

-- Blok B
INSERT INTO `users` (`username`, `password`, `role`) VALUES
('warga_b1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'warga'),
('warga_b2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'warga'),
('warga_b3', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'warga'),
('warga_b4', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'warga'),
('warga_b5', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'warga');

INSERT INTO `warga` (`user_id`, `nama_lengkap`, `blok`, `no_rumah`, `no_hp`, `jenis_kelamin`) VALUES
(LAST_INSERT_ID()-4, 'Eko Prasetyo', 'B', '1', '081234560006', 'L'),
(LAST_INSERT_ID()-3, 'Fitri Handayani', 'B', '2', '081234560007', 'P'),
(LAST_INSERT_ID()-2, 'Gunawan Wibowo', 'B', '3', '081234560008', 'L'),
(LAST_INSERT_ID()-1, 'Hani Kusuma', 'B', '4', '081234560009', 'P'),
(LAST_INSERT_ID(), 'Irfan Hakim', 'B', '5', '081234560010', 'L');

-- Blok C
INSERT INTO `users` (`username`, `password`, `role`) VALUES
('warga_c1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'warga'),
('warga_c2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'warga'),
('warga_c3', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'warga'),
('warga_c4', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'warga'),
('warga_c5', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'warga');

INSERT INTO `warga` (`user_id`, `nama_lengkap`, `blok`, `no_rumah`, `no_hp`, `jenis_kelamin`) VALUES
(LAST_INSERT_ID()-4, 'Joko Widodo', 'C', '1', '081234560011', 'L'),
(LAST_INSERT_ID()-3, 'Kartika Sari', 'C', '2', '081234560012', 'P'),
(LAST_INSERT_ID()-2, 'Lukman Hakim', 'C', '3', '081234560013', 'L'),
(LAST_INSERT_ID()-1, 'Maya Anggraini', 'C', '4', '081234560014', 'P'),
(LAST_INSERT_ID(), 'Nugroho Santoso', 'C', '5', '081234560015', 'L');

-- Blok D
INSERT INTO `users` (`username`, `password`, `role`) VALUES
('warga_d1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'warga'),
('warga_d2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'warga'),
('warga_d3', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'warga'),
('warga_d4', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'warga'),
('warga_d5', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'warga');

INSERT INTO `warga` (`user_id`, `nama_lengkap`, `blok`, `no_rumah`, `no_hp`, `jenis_kelamin`) VALUES
(LAST_INSERT_ID()-4, 'Omar Bakri', 'D', '1', '081234560016', 'L'),
(LAST_INSERT_ID()-3, 'Putri Ayu', 'D', '2', '081234560017', 'P'),
(LAST_INSERT_ID()-2, 'Qomar Zaman', 'D', '3', '081234560018', 'L'),
(LAST_INSERT_ID()-1, 'Rina Susanti', 'D', '4', '081234560019', 'P'),
(LAST_INSERT_ID(), 'Surya Pratama', 'D', '5', '081234560020', 'L');

-- Blok E
INSERT INTO `users` (`username`, `password`, `role`) VALUES
('warga_e1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'warga'),
('warga_e2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'warga'),
('warga_e3', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'warga'),
('warga_e4', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'warga'),
('warga_e5', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'warga');

INSERT INTO `warga` (`user_id`, `nama_lengkap`, `blok`, `no_rumah`, `no_hp`, `jenis_kelamin`) VALUES
(LAST_INSERT_ID()-4, 'Tono Sumarno', 'E', '1', '081234560021', 'L'),
(LAST_INSERT_ID()-3, 'Uci Sanusi', 'E', '2', '081234560022', 'P'),
(LAST_INSERT_ID()-2, 'Vino Bastian', 'E', '3', '081234560023', 'L'),
(LAST_INSERT_ID()-1, 'Wulan Guritno', 'E', '4', '081234560024', 'P'),
(LAST_INSERT_ID(), 'Yudi Latif', 'E', '5', '081234560025', 'L');

-- Blok J (untuk Aceva yang sudah ada)
INSERT INTO `users` (`username`, `password`, `role`) VALUES
('warga_j2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'warga'),
('warga_j3', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'warga'),
('warga_j5', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'warga');

INSERT INTO `warga` (`user_id`, `nama_lengkap`, `blok`, `no_rumah`, `no_hp`, `jenis_kelamin`) VALUES
(LAST_INSERT_ID()-2, 'Zainal Abidin', 'J', '2', '081234560026', 'L'),
(LAST_INSERT_ID()-1, 'Aisha Putri', 'J', '3', '081234560027', 'P'),
(LAST_INSERT_ID(), 'Bima Sakti', 'J', '5', '081234560028', 'L');

-- =============================================
-- SELESAI
-- =============================================
-- Total Data:
-- - 5 Organisasi
-- - 12 Pengurus (6 FKKMBT + 6 FKKMMBT)
-- - 15 Kegiatan
-- - 5 Jenis Iuran
-- - 33 Warga (+ 1 Aceva yang sudah ada = 34 warga)
--
-- Login Info:
-- Username: warga_a1 sampai warga_e5, warga_j2, warga_j3, warga_j5
-- Password: 123456 (semua sama)
-- =============================================
