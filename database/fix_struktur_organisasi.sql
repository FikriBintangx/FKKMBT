-- PANDUAN:
-- 1. Copy text ini ke Tab SQL di phpMyAdmin
-- 2. Klik GO

-- A. Hapus Data Lama
TRUNCATE TABLE struktur_organisasi;

-- B. Masukkan Data Baru
INSERT INTO struktur_organisasi (tipe_organisasi, nama, jabatan, level, urutan, jenis_kelamin) VALUES
-- LEVEL 1 (Pembina - Ketua - Penasehat)
('FKKMBT', 'SUPARNO', 'Pembina', 1, 1, 'L'),
('FKKMBT', 'PONIMAN', 'Pembina', 1, 2, 'L'),
('FKKMBT', 'SAFIK', 'Pembina', 1, 3, 'L'),
('FKKMBT', 'H KUSMANTORO', 'Ketua', 1, 4, 'L'),
('FKKMBT', 'UST JALALUDIN', 'Penasehat', 1, 5, 'L'),
('FKKMBT', 'H AGUS TOMI', 'Penasehat', 1, 6, 'L'),
('FKKMBT', 'H TAMAMIL HUDA', 'Penasehat', 1, 7, 'L'),

-- LEVEL 2 (Bendahara - Wakil - Sekretaris)
('FKKMBT', 'SUGIONO', 'Bendahara I', 2, 8, 'L'),
('FKKMBT', 'SRI HARTATA', 'Bendahara II', 2, 9, 'L'),
('FKKMBT', 'WASIS KARYONO', 'Wakil Ketua', 2, 10, 'L'),
('FKKMBT', 'KUSNAN JAYA', 'Sekretaris I', 2, 11, 'L'),
('FKKMBT', 'SLAMET', 'Sekretaris II', 2, 12, 'L'),

-- LEVEL 3 (Seksi-seksi sesuai urutan grid)
('FKKMBT', 'IWA. K', 'Seksi Kesejahteraan', 3, 13, 'L'),
('FKKMBT', 'IMANTO', 'Seksi Kesejahteraan', 3, 14, 'L'),
('FKKMBT', 'YONO', 'Seksi Pengembangan Ekonomi', 3, 15, 'L'),
('FKKMBT', 'AEP S', 'Seksi Pengembangan Ekonomi', 3, 16, 'L'),
('FKKMBT', 'ROHADI', 'Seksi Humas, Publikasi dan Komunikasi', 3, 17, 'L'),
('FKKMBT', 'YAYAN S', 'Seksi Humas, Publikasi dan Komunikasi', 3, 18, 'L'),
('FKKMBT', 'PUNDI', 'Seksi Humas, Publikasi dan Komunikasi', 3, 19, 'L'),
('FKKMBT', 'DEDEN IRWAN', 'Seksi Kepemudaan dan Olahraga', 3, 20, 'L'),
('FKKMBT', 'DIDIK', 'Seksi Kepemudaan dan Olahraga', 3, 21, 'L'),
('FKKMBT', 'IIS ISKANDAR', 'Seksi Perencanaan Lingkungan', 3, 22, 'L'),
('FKKMBT', 'AYO', 'Seksi Perencanaan Lingkungan', 3, 23, 'L'),
-- Row Bawah
('FKKMBT', 'BIO', 'Seksi Seni dan Budaya', 3, 24, 'L'),
('FKKMBT', 'TEKAD', 'Seksi Seni dan Budaya', 3, 25, 'L'),
('FKKMBT', 'H. DARCA S', 'Seksi Kerohanian', 3, 26, 'L'),
('FKKMBT', 'SUKIRNA', 'Seksi Kerohanian', 3, 27, 'L'),
('FKKMBT', 'CIPTO W', 'Seksi Keamanan', 3, 28, 'L'),
('FKKMBT', 'PURJITO', 'Seksi Keamanan', 3, 29, 'L'),
('FKKMBT', 'KAZMANI', 'Seksi Perlengkapan', 3, 30, 'L'),
('FKKMBT', 'DUDUNG', 'Seksi Perlengkapan', 3, 31, 'L'),
('FKKMBT', 'SISWANTO', 'Seksi Perlengkapan', 3, 32, 'L'),
('FKKMBT', 'ISMAIL MARZUKI', 'Seksi Perlengkapan', 3, 33, 'L'),
('FKKMBT', 'IBU RW DAN RT', 'Seksi Kewanitaan', 3, 34, 'P');
