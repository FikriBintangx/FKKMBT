<?php
require_once 'config/database.php';

// Disable FK checks to allow drops
$conn->query("SET FOREIGN_KEY_CHECKS = 0");

// 1. Setup 'organisasi' table
$conn->query("DROP TABLE IF EXISTS organisasi");
$sql_org = "CREATE TABLE organisasi (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama_organisasi VARCHAR(100) NOT NULL,
  deskripsi TEXT DEFAULT NULL,
  induk ENUM('fkkmbt', 'fkkmmbt') NOT NULL DEFAULT 'fkkmbt'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
if ($conn->query($sql_org)) echo "Table 'organisasi' created.\n";
else echo "Error 'organisasi': " . $conn->error . "\n";

// Insert dummy organisasi
$conn->query("INSERT INTO organisasi (nama_organisasi, induk) VALUES 
('Karang Taruna', 'fkkmmbt'),
('PKK', 'fkkmbt'), 
('Seksi Keamanan', 'fkkmbt')");

// 2. Setup 'kegiatan' table
$conn->query("DROP TABLE IF EXISTS kegiatan");
$sql_keg = "CREATE TABLE kegiatan (
  id INT AUTO_INCREMENT PRIMARY KEY,
  organisasi_id INT NOT NULL,
  judul VARCHAR(200) NOT NULL,
  deskripsi TEXT NOT NULL,
  tanggal DATE NOT NULL,
  foto VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (organisasi_id) REFERENCES organisasi(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
if ($conn->query($sql_keg)) echo "Table 'kegiatan' created.\n";
else echo "Error 'kegiatan': " . $conn->error . "\n";

// Insert dummy kegiatan
$desc = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.";
$sql_ins_keg = "INSERT INTO kegiatan (organisasi_id, judul, deskripsi, tanggal, foto) VALUES 
(1, 'Lomba 17 Agustus', '$desc', '2024-08-17', NULL),
(2, 'Pelatihan Memasak', '$desc', '2024-09-01', NULL),
(3, 'Ronda Malam Gabungan', '$desc', '2024-10-05', NULL)";
if ($conn->query($sql_ins_keg)) echo "Dummy data 'kegiatan' inserted.\n";

// 3. Setup 'kegiatan_galeri' table
$conn->query("DROP TABLE IF EXISTS kegiatan_galeri");
$sql_gal = "CREATE TABLE kegiatan_galeri (
  id INT AUTO_INCREMENT PRIMARY KEY,
  kegiatan_id INT NOT NULL,
  file VARCHAR(255) NOT NULL,
  tipe_file ENUM('image','video') NOT NULL DEFAULT 'image',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (kegiatan_id) REFERENCES kegiatan(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
if ($conn->query($sql_gal)) echo "Table 'kegiatan_galeri' created.\n";
else echo "Error 'kegiatan_galeri': " . $conn->error . "\n";
// Note: Changed column 'tipe' to 'tipe_file' based on kegiatan.php line 114 ($img['tipe_file'])

// Enable FK checks
$conn->query("SET FOREIGN_KEY_CHECKS = 1");
echo "Fix complete.\n";
?>
