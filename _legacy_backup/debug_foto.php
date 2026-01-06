<?php
// Debug script to check kegiatan foto data
require_once 'config/database.php';

echo "<h3>Debug: Kegiatan Foto</h3>";

$result = $conn->query("SELECT id, judul, foto, tanggal FROM kegiatan ORDER BY created_at DESC LIMIT 5");

if ($result && $result->num_rows > 0) {
    echo "<table border='1' cellpadding='10'>";
    echo "<tr><th>ID</th><th>Judul</th><th>Foto Column</th><th>Tanggal</th><th>File Exists?</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        $file_path = 'assets/uploads/' . $row['foto'];
        $file_exists = !empty($row['foto']) && file_exists($file_path) ? '✅ Yes' : '❌ No';
        
        echo "<tr>";
        echo "<td>{$row['id']}</td>";
        echo "<td>{$row['judul']}</td>";
        echo "<td>" . ($row['foto'] ? $row['foto'] : '<em>NULL/Empty</em>') . "</td>";
        echo "<td>{$row['tanggal']}</td>";
        echo "<td>{$file_exists}</td>";
        echo "</tr>";
    }
    
    echo "</table>";
} else {
    echo "<p>No data found in kegiatan table.</p>";
}

// Check if uploads directory exists
echo "<h4>Upload Directory Check:</h4>";
$upload_dir = 'assets/uploads/';
if (is_dir($upload_dir)) {
    echo "✅ Directory exists: " . realpath($upload_dir) . "<br>";
    $files = scandir($upload_dir);
    echo "Files in directory: <br>";
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            echo "- $file<br>";
        }
    }
} else {
    echo "❌ Directory does not exist: $upload_dir";
}
?>
