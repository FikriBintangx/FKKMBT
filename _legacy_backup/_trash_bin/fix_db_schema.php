<?php
require_once 'config/database.php';

// 1. Drop existing table
$conn->query("DROP TABLE IF EXISTS struktur_organisasi");
echo "Dropped table struktur_organisasi.\n";

// 2. Create new table with all required columns
$sql = "CREATE TABLE struktur_organisasi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipe_organisasi VARCHAR(20) NOT NULL DEFAULT 'FKKMBT',
    nama VARCHAR(100) NOT NULL,
    jabatan VARCHAR(100) NOT NULL,
    level INT NOT NULL,
    urutan INT DEFAULT 0,
    jenis_kelamin VARCHAR(10) DEFAULT 'L',
    foto VARCHAR(255) DEFAULT NULL,
    kontak VARCHAR(20) DEFAULT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'struktur_organisasi' created successfully.\n";
} else {
    die("Error creating table: " . $conn->error . "\n");
}

// 3. Insert data from fix_struktur_organisasi.sql
$sql_insert = "INSERT INTO struktur_organisasi (tipe_organisasi, nama, jabatan, level, urutan, jenis_kelamin) VALUES
('FKKMBT', 'SUPARNO', 'Pembina', 1, 1, 'L'),
('FKKMBT', 'PONIMAN', 'Pembina', 1, 2, 'L'),
('FKKMBT', 'SAFIK', 'Pembina', 1, 3, 'L'),
('FKKMBT', 'H KUSMANTORO', 'Ketua', 1, 4, 'L'),
('FKKMBT', 'UST JALALUDIN', 'Penasehat', 1, 5, 'L'),
('FKKMBT', 'H AGUS TOMI', 'Penasehat', 1, 6, 'L'),
('FKKMBT', 'H TAMAMIL HUDA', 'Penasehat', 1, 7, 'L'),
('FKKMBT', 'SUGIONO', 'Bendahara I', 2, 8, 'L'),
('FKKMBT', 'SRI HARTATA', 'Bendahara II', 2, 9, 'L'),
('FKKMBT', 'WASIS KARYONO', 'Wakil Ketua', 2, 10, 'L'),
('FKKMBT', 'KUSNAN JAYA', 'Sekretaris I', 2, 11, 'L'),
('FKKMBT', 'SLAMET', 'Sekretaris II', 2, 12, 'L'),
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
('FKKMBT', 'IBU RW DAN RT', 'Seksi Kewanitaan', 3, 34, 'P')";

if ($conn->query($sql_insert) === TRUE) {
    echo "Data inserted successfully.\n";
} else {
    echo "Error inserting data: " . $conn->error . "\n";
}

// 4. Also insert sample FKKMMBT data? The tab FKKMMBT exists.
// The file fix_struktur_organisasi.sql did not have FKKMMBT but let's see check_kegiatan.sql or others?
// For now, I'll just stick to FKKMBT since that's what's in the sql file.
?>
