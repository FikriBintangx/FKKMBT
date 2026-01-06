<?php
require_once '../config/database.php';

// Menambahkan kolom jenis_kelamin ke tabel struktur_organisasi
$sql = "SHOW COLUMNS FROM struktur_organisasi LIKE 'jenis_kelamin'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    $alter = "ALTER TABLE struktur_organisasi ADD COLUMN jenis_kelamin ENUM('L','P') DEFAULT 'L' AFTER nama";
    if ($conn->query($alter) === TRUE) {
        echo "<div style='font-family:sans-serif; padding:20px; background:#dcfce7; color:#166534; border-radius:10px; border:1px solid #86efac; text-align:center;'>
            <h3>✅ Berhasil!</h3>
            <p>Kolom <strong>jenis_kelamin</strong> berhasil ditambahkan ke tabel <strong>struktur_organisasi</strong>.</p>
            <p>Silakan lanjut update fitur Edit di Organization Admin.</p>
        </div>";
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "<div style='font-family:sans-serif; padding:20px; background:#e0f2fe; color:#075985; border-radius:10px; border:1px solid #7dd3fc; text-align:center;'>
        <h3>ℹ️ Sudah Ada</h3>
        <p>Kolom sudah ada.</p>
    </div>";
}
?>
