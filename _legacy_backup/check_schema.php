<?php
require_once 'config/database.php';

$table = 'struktur_organisasi';
$result = $conn->query("SHOW COLUMNS FROM $table");

if ($result) {
    echo "Columns in '$table':\n";
    while ($row = $result->fetch_assoc()) {
        echo $row['Field'] . " (" . $row['Type'] . ")\n";
    }
} else {
    echo "Table '$table' does not exist or error: " . $conn->error;
}
?>
