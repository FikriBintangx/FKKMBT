-- Hapus data FKKMMBT lama
DELETE FROM struktur_organisasi WHERE tipe_organisasi = 'fkkmmbt';

-- Insert data FKKMMBT baru
INSERT INTO struktur_organisasi (nama, jabatan, level, tipe_organisasi, urutan, jenis_kelamin, kontak) VALUES
('Aceva Arie Sadewa', 'Ketua Umum', 1, 'fkkmmbt', 1, 'L', '6287786720942'),
('Ahmad Fauzi', 'Wakil Ketua Umum', 2, 'fkkmmbt', 2, 'L', NULL),
('Siti Nurhaliza', 'Sekretaris I', 3, 'fkkmmbt', 3, 'P', NULL),
('Dewi Kartika', 'Sekretaris II', 3, 'fkkmmbt', 4, 'P', NULL),
('Budi Santoso', 'Bendahara I', 3, 'fkkmmbt', 5, 'L', NULL),
('Rina Wati', 'Bendahara II', 3, 'fkkmmbt', 6, 'P', NULL),
('Andi Pratama', 'Divisi Kepemudaan', 4, 'fkkmmbt', 7, 'L', NULL),
('Riko Saputra', 'Divisi Kepemudaan', 4, 'fkkmmbt', 8, 'L', NULL),
('Dimas Arya', 'Divisi Kreatif', 4, 'fkkmmbt', 9, 'L', NULL),
('Maya Putri', 'Divisi Kreatif', 4, 'fkkmmbt', 10, 'P', NULL),
('Hendra Kurniawan', 'Divisi Humas', 4, 'fkkmmbt', 11, 'L', NULL),
('Linda Safitri', 'Divisi Humas', 4, 'fkkmmbt', 12, 'P', NULL),
('Yoga Pratama', 'Divisi Olahraga', 4, 'fkkmmbt', 13, 'L', NULL),
('Faisal Rahman', 'Divisi Olahraga', 4, 'fkkmmbt', 14, 'L', NULL),
('Surya Wijaya', 'Divisi Teknologi', 4, 'fkkmmbt', 15, 'L', NULL),
('Fikri Ramadhan', 'Divisi Teknologi', 4, 'fkkmmbt', 16, 'L', NULL),
('Indah Permata', 'Divisi Sosial', 4, 'fkkmmbt', 17, 'P', NULL),
('Ayu Lestari', 'Divisi Sosial', 4, 'fkkmmbt', 18, 'P', NULL),
('Bayu Setiawan', 'Divisi Keamanan', 4, 'fkkmmbt', 19, 'L', NULL),
('Doni Saputra', 'Divisi Keamanan', 4, 'fkkmmbt', 20, 'L', NULL),
('Eka Putri', 'Divisi Kewanitaan', 4, 'fkkmmbt', 21, 'P', NULL),
('Nur Azizah', 'Divisi Kewanitaan', 4, 'fkkmmbt', 22, 'P', NULL);
