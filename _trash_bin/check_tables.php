<?php
require_once 'config/database.php';

$result = $conn->query("SHOW TABLES");
echo "Tables in database:\n";
while ($row = $result->fetch_array()) {
    echo $row[0] . "\n";
}
?>
