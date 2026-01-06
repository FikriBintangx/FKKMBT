<?php
require_once 'config/database.php';

// Verify kegiatan query
$sql = "SELECT * FROM kegiatan ORDER BY tanggal DESC LIMIT 6";
$result = $conn->query($sql);

if ($result) {
    echo "Kegiatan Query OK. Count: " . $result->num_rows . "\n";
    while($row = $result->fetch_assoc()) {
        echo "- " . $row['judul'] . " (" . $row['tanggal'] . ")\n";
        
        // Verify galeri query
        $sql_gal = "SELECT * FROM kegiatan_galeri WHERE kegiatan_id = " . $row['id'];
        $res_gal = $conn->query($sql_gal);
        if ($res_gal) {
             echo "  Galeri count: " . $res_gal->num_rows . "\n";
        } else {
             echo "  Galeri Error: " . $conn->error . "\n";
        }
    }
} else {
    echo "Kegiatan Error: " . $conn->error . "\n";
}
?>
