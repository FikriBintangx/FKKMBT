<?php
require_once 'config/database.php';

$type = 'FKKMBT';
$sql = "SELECT * FROM struktur_organisasi WHERE UPPER(tipe_organisasi) = UPPER('$type')";
$res = $conn->query($sql);

if ($res) {
    echo "Query successful. Found " . $res->num_rows . " rows.\n";
    while($row = $res->fetch_assoc()) {
        echo $row['nama'] . " - " . $row['jabatan'] . "\n";
    }
} else {
    echo "Query failed: " . $conn->error . "\n";
}
?>
