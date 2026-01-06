<?php
require_once 'config/database.php';

function getKeys($conn, $type) {
    $sql = "SELECT * FROM struktur_organisasi WHERE UPPER(tipe_organisasi) = UPPER('$type')";
    $res = $conn->query($sql);
    $keys = [];
    while($row = $res->fetch_assoc()) {
        $jabatan = strtoupper(trim($row['jabatan']));
        $keys[] = $jabatan;
    }
    return array_unique($keys);
}

$keys = getKeys($conn, 'FKKMMBT');
echo "Keys found in DB for FKKMMBT:\n";
foreach($keys as $k) {
    echo "- '$k'\n";
}
?>
