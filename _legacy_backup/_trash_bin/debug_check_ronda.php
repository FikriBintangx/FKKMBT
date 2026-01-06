<?php
require_once 'config/database.php';

$sql = "SELECT id, judul, foto FROM kegiatan WHERE judul LIKE '%Ronda Malam%'";
$result = $conn->query($sql);

if ($result) {
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "Found: " . $row['judul'] . "\n";
        echo "Foto file: '" . $row['foto'] . "'\n";
    } else {
        echo "Ronda Malam not found in DB\n";
    }
} else {
    echo "Query error\n";
}
?>
