<?php
require_once 'config/database.php';
$res = $conn->query("SELECT * FROM struktur_organisasi WHERE nama LIKE '%Aceva%'");
while($row = $res->fetch_assoc()) {
    echo "Found: " . $row['nama'] . " - " . $row['jabatan'] . " (" . $row['tipe_organisasi'] . ")\n";
}
?>
