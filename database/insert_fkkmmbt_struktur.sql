-- PANDUAN:
-- 1. Copy text ini ke Tab SQL di phpMyAdmin
-- 2. Klik GO untuk menambahkan data FKKMMBT

-- Hapus data FKKMMBT yang lama (jika ada)
DELETE FROM struktur_organisasi WHERE tipe_organisasi = 'FKKMMBT';

-- Masukkan Data Struktur FKKMMBT
INSERT INTO struktur_organisasi (tipe_organisasi, nama, jabatan, level, urutan, jenis_kelamin, kontak) VALUES
-- LEVEL 1: Ketua Umum
('FKKMMBT', 'Aceva Arie Sadewa', 'Ketua Umum', 1, 1, 'L', '6287786720942'),

-- LEVEL 2: Wakil Ketua Umum
('FKKMMBT', 'Ahmad Fauzi', 'Wakil Ketua Umum', 2, 2, 'L', NULL),

-- LEVEL 3: Sekretaris & Bendahara
('FKKMMBT', 'Siti Nurhaliza', 'Sekretaris I', 3, 3, 'P', NULL),
('FKKMMBT', 'Dewi Kartika', 'Sekretaris II', 3, 4, 'P', NULL),
('FKKMMBT', 'Budi Santoso', 'Bendahara I', 3, 5, 'L', NULL),
('FKKMMBT', 'Rina Wati', 'Bendahara II', 3, 6, 'P', NULL),

-- LEVEL 4: Divisi-divisi
('FKKMMBT', 'Andi Pratama', 'Divisi Kepemudaan', 4, 7, 'L', NULL),
('FKKMMBT', 'Riko Saputra', 'Divisi Kepemudaan', 4, 8, 'L', NULL),

('FKKMMBT', 'Dimas Arya', 'Divisi Kreatif', 4, 9, 'L', NULL),
('FKKMMBT', 'Maya Putri', 'Divisi Kreatif', 4, 10, 'P', NULL),

('FKKMMBT', 'Hendra Kurniawan', 'Divisi Humas', 4, 11, 'L', NULL),
('FKKMMBT', 'Linda Safitri', 'Divisi Humas', 4, 12, 'P', NULL),

('FKKMMBT', 'Yoga Pratama', 'Divisi Olahraga', 4, 13, 'L', NULL),
('FKKMMBT', 'Faisal Rahman', 'Divisi Olahraga', 4, 14, 'L', NULL),

('FKKMMBT', 'Surya Wijaya', 'Divisi Teknologi', 4, 15, 'L', NULL),
('FKKMMBT', 'Fikri Ramadhan', 'Divisi Teknologi', 4, 16, 'L', NULL),

('FKKMMBT', 'Indah Permata', 'Divisi Sosial', 4, 17, 'P', NULL),
('FKKMMBT', 'Ayu Lestari', 'Divisi Sosial', 4, 18, 'P', NULL),

('FKKMMBT', 'Bayu Setiawan', 'Divisi Keamanan', 4, 19, 'L', NULL),
('FKKMMBT', 'Doni Saputra', 'Divisi Keamanan', 4, 20, 'L', NULL),

('FKKMMBT', 'Eka Putri', 'Divisi Kewanitaan', 4, 21, 'P', NULL),
('FKKMMBT', 'Nur Azizah', 'Divisi Kewanitaan', 4, 22, 'P', NULL);
