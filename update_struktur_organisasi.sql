-- =============================================
-- INSERT STRUKTUR ORGANISASI FKKMMBT (LENGKAP)
-- =============================================
-- Hapus data lama FKKMMBT dulu (opsional)
DELETE FROM `struktur_organisasi` WHERE `tipe_organisasi` = 'FKKMMBT';

-- Insert data baru
INSERT INTO `struktur_organisasi` (`tipe_organisasi`, `nama`, `jabatan`, `level`, `jenis_kelamin`, `kontak`) VALUES
-- LEVEL 1: Ketua Umum
('FKKMMBT', 'Aceva Arie Sadewa', 'Ketua Umum', 1, 'L', '087786720942'),

-- LEVEL 2: Wakil Ketua Umum
('FKKMMBT', 'Ahmad Fauzi', 'Wakil Ketua Umum', 2, 'L', NULL),

-- LEVEL 3: Sekretaris & Bendahara
('FKKMMBT', 'Siti Nurhaliza', 'Sekretaris I', 3, 'P', NULL),
('FKKMMBT', 'Dewi Kartika', 'Sekretaris II', 3, 'P', NULL),
('FKKMMBT', 'Budi Santoso', 'Bendahara I', 3, 'L', NULL),
('FKKMMBT', 'Rina Wati', 'Bendahara II', 3, 'P', NULL),

-- LEVEL 4: Divisi-divisi
('FKKMMBT', 'Andi Pratama', 'Divisi Kepemudaan', 4, 'L', NULL),
('FKKMMBT', 'Riko Saputra', 'Divisi Kepemudaan', 4, 'L', NULL),
('FKKMMBT', 'Dimas Arya', 'Divisi Kreatif', 4, 'L', NULL),
('FKKMMBT', 'Maya Putri', 'Divisi Kreatif', 4, 'P', NULL),
('FKKMMBT', 'Hendra Kurniawan', 'Divisi Humas', 4, 'L', NULL),
('FKKMMBT', 'Lina Marlina', 'Divisi Humas', 4, 'P', NULL),
('FKKMMBT', 'Yoga Pratama', 'Divisi Olahraga', 4, 'L', NULL),
('FKKMMBT', 'Sinta Dewi', 'Divisi Kesenian', 4, 'P', NULL);

-- =============================================
-- INSERT STRUKTUR ORGANISASI FKKMBT (LENGKAP)
-- =============================================
-- Hapus data lama FKKMBT dulu (opsional)
DELETE FROM `struktur_organisasi` WHERE `tipe_organisasi` = 'FKKMBT';

-- Insert data baru
INSERT INTO `struktur_organisasi` (`tipe_organisasi`, `nama`, `jabatan`, `level`, `jenis_kelamin`, `kontak`) VALUES
-- LEVEL 1: Ketua
('FKKMBT', 'Haji Kusnantoro', 'Ketua FKKMBT', 1, 'L', '087885873957'),

-- LEVEL 2: Wakil Ketua & Sekretaris & Bendahara
('FKKMBT', 'Ir. Bambang Sutrisno', 'Wakil Ketua', 2, 'L', NULL),
('FKKMBT', 'Siti Nurhaliza', 'Sekretaris', 2, 'P', NULL),
('FKKMBT', 'Ahmad Dahlan', 'Bendahara', 2, 'L', NULL),

-- LEVEL 3: Seksi-seksi
('FKKMBT', 'Dewi Lestari', 'Seksi Kebersihan', 3, 'P', NULL),
('FKKMBT', 'Rudi Hartono', 'Seksi Keamanan', 3, 'L', NULL),
('FKKMBT', 'Maya Sari', 'Seksi Sosial', 3, 'P', NULL),
('FKKMBT', 'Agus Setiawan', 'Seksi Pembangunan', 3, 'L', NULL),
('FKKMBT', 'Fitri Handayani', 'Seksi Kesehatan', 3, 'P', NULL);

-- =============================================
-- SELESAI
-- =============================================
-- Jalankan SQL ini di phpMyAdmin untuk update struktur organisasi
-- yang lebih lengkap dan sesuai dengan struktur tabel yang ada
-- =============================================
