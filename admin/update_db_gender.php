<?php
require_once '../config/database.php';

// Menambahkan kolom jenis_kelamin ke tabel warga jika belum ada
$sql = "SHOW COLUMNS FROM warga LIKE 'jenis_kelamin'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    // Kolom belum ada, tambahkan
    $alter = "ALTER TABLE warga ADD COLUMN jenis_kelamin ENUM('L','P') DEFAULT 'L' AFTER nama_lengkap";
    if ($conn->query($alter) === TRUE) {
        echo "<div style='font-family:sans-serif; padding:20px; background:#dcfce7; color:#166534; border-radius:10px; border:1px solid #86efac; text-align:center;'>
            <h3>✅ Berhasil!</h3>
            <p>Kolom <strong>jenis_kelamin</strong> berhasil ditambahkan ke tabel warga.</p>
            <p>Silakan lanjut cek halaman Register.</p>
        </div>";
    } else {
        echo "Error updating database: " . $conn->error;
    }
} else {
    echo "<div style='font-family:sans-serif; padding:20px; background:#e0f2fe; color:#075985; border-radius:10px; border:1px solid #7dd3fc; text-align:center;'>
        <h3>ℹ️ Sudah Ada</h3>
        <p>Kolom <strong>jenis_kelamin</strong> sudah ada di database. Tidak perlu update lagi.</p>
    </div>";
}
?>
