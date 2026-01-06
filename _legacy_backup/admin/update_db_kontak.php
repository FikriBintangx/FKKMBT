<?php
require_once '../config/database.php';

$sql = "ALTER TABLE struktur_organisasi ADD COLUMN kontak VARCHAR(20) DEFAULT NULL";

if ($conn->query($sql) === TRUE) {
    echo "<h1>Berhasil!</h1><p>Kolom 'kontak' berhasil ditambahkan ke tabel struktur_organisasi.</p>";
    echo "<a href='organisasi.php'>Kembali ke Admin Organisasi</a>";
} else {
    if($conn->errno == 1060) {
        echo "<h1>Sudah Ada</h1><p>Kolom 'kontak' sudah ada sebelumnya. Tidak perlu update.</p>";
        echo "<a href='organisasi.php'>Kembali ke Admin Organisasi</a>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>
