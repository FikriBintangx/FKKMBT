<?php
require_once 'config/database.php';

echo "Checking 'kegiatan' table:\n";
$result = $conn->query("SELECT id, judul, foto FROM kegiatan");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row['id'] . ", Judul: " . $row['judul'] . ", Foto: " . $row['foto'] . "\n";
    }
} else {
    echo "Error querying kegiatan: " . $conn->error . "\n";
}

echo "\nChecking 'kegiatan_galeri' table:\n";
$result2 = $conn->query("SELECT id, kegiatan_id, file FROM kegiatan_galeri");
if ($result2) {
    if ($result2->num_rows > 0) {
        while ($row = $result2->fetch_assoc()) {
            echo "ID: " . $row['id'] . ", KegiatanID: " . $row['kegiatan_id'] . ", File: " . $row['file'] . "\n";
        }
    } else {
        echo "No data in kegiatan_galeri.\n";
    }
} else {
    echo "Error querying kegiatan_galeri: " . $conn->error . "\n";
}
?>
