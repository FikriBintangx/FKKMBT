<?php
require_once 'config/database.php';
$tables = ['iuran_master', 'pembayaran_iuran', 'warga'];
foreach($tables as $t) {
    echo "Checking $t:\n";
    $res = $conn->query("SHOW COLUMNS FROM $t");
    if($res) {
        while($r = $res->fetch_assoc()) echo " - " . $r['Field'] . "\n";
    } else {
        echo " - Table NOT FOUND\n";
    }
}
?>
