<?php
require_once 'config/database.php';

// Disable FK
$conn->query("SET FOREIGN_KEY_CHECKS = 0");

// 1. iuran_master
$conn->query("DROP TABLE IF EXISTS iuran_master");
$sql1 = "CREATE TABLE iuran_master (
      id int(11) NOT NULL AUTO_INCREMENT,
      nama_iuran varchar(100) NOT NULL,
      keterangan text DEFAULT NULL,
      nominal decimal(10,2) NOT NULL,
      jatuh_tempo date NOT NULL,
      status enum('aktif','nonaktif') DEFAULT 'aktif',
      PRIMARY KEY (id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
if ($conn->query($sql1)) echo "Table iuran_master created.\n";
else echo "Error iuran_master: " . $conn->error . "\n";

// Dummy iuran
$conn->query("INSERT INTO iuran_master (nama_iuran, nominal, jatuh_tempo) VALUES 
('Iuran Kebersihan Januari 2025', 50000, '2025-01-20'),
('Iuran Keamanan Januari 2025', 75000, '2025-01-20')");

// 2. pembayaran_iuran
$conn->query("DROP TABLE IF EXISTS pembayaran_iuran");
$sql2 = "CREATE TABLE pembayaran_iuran (
      id int(11) NOT NULL AUTO_INCREMENT,
      warga_id int(11) NOT NULL,
      iuran_id int(11) NOT NULL,
      tgl_bayar datetime DEFAULT current_timestamp(),
      bukti_transfer varchar(255) NOT NULL,
      status enum('pending','disetujui','ditolak') DEFAULT 'pending',
      catatan_admin text DEFAULT NULL,
      PRIMARY KEY (id),
      KEY warga_id (warga_id),
      KEY iuran_id (iuran_id),
      CONSTRAINT fk_bayar_warga FOREIGN KEY (warga_id) REFERENCES warga (id) ON DELETE CASCADE,
      CONSTRAINT fk_bayar_iuran FOREIGN KEY (iuran_id) REFERENCES iuran_master (id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
if ($conn->query($sql2)) echo "Table pembayaran_iuran created.\n";
else echo "Error pembayaran_iuran: " . $conn->error . "\n";

$conn->query("SET FOREIGN_KEY_CHECKS = 1");
echo "Fix complete.\n";
?>
