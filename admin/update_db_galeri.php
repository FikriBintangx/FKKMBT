<?php
require_once '../config/database.php';

// 1. Buat Tabel kegiatan_galeri
$sql = "CREATE TABLE IF NOT EXISTS kegiatan_galeri (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kegiatan_id INT NOT NULL,
    file VARCHAR(255) NOT NULL,
    tipe_file ENUM('gambar','video') DEFAULT 'gambar',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (kegiatan_id) REFERENCES kegiatan(id) ON DELETE CASCADE
)";

if ($conn->query($sql) === TRUE) {
    echo "<div style='font-family:sans-serif; padding:20px; background:#dcfce7; color:#166534; border-radius:10px; border:1px solid #86efac; text-align:center;'>
        <h3>✅ Tabel Galeri Siap!</h3>
        <p>Tabel <strong>kegiatan_galeri</strong> berhasil dibuat.</p>
        <p>Sekarang sistem bisa menampung banyak foto & video per kegiatan.</p>
    </div>";
} else {
    echo "Error creating table: " . $conn->error;
}

// 2. Cek Folder Upload
$dir = "../assets/images/kegiatan";
if (!file_exists($dir)) {
    mkdir($dir, 0777, true);
    echo "<br>Folder $dir berhasil dibuat.";
}
?>
