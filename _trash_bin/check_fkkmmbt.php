<?php
require_once 'config/database.php';

$type = 'FKKMMBT';
$sql = "SELECT * FROM struktur_organisasi WHERE UPPER(tipe_organisasi) = UPPER('$type') ORDER BY level ASC";
$res = $conn->query($sql);

if ($res) {
    if ($res->num_rows > 0) {
        echo "Exiting FKKMMBT Structure:\n";
        while($row = $res->fetch_assoc()) {
            echo "ID: " . $row['id'] . " - " . $row['jabatan'] . ": " . $row['nama'] . " (Level " . $row['level'] . ")\n";
        }
    } else {
        echo "No data found for FKKMMBT.\n";
    }
} else {
    echo "Query failed: " . $conn->error;
}
?>
