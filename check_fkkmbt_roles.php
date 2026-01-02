<?php
require_once 'config/database.php';
$conn->query("SET NAMES utf8mb4");
$res = $conn->query("SELECT * FROM struktur_organisasi WHERE tipe_organisasi = 'FKKMBT' ORDER BY level ASC");
while($row = $res->fetch_assoc()) echo $row['jabatan'] . ": " . $row['nama'] . " (Lvl " . $row['level'] . ")\n";
?>
