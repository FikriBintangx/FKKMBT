<?php
require_once 'config/database.php';

// Check columns in warga table
$result = $conn->query("DESCRIBE warga");
$columns = [];
while ($row = $result->fetch_assoc()) {
    $columns[] = $row['Field'];
}

if (!in_array('foto', $columns)) {
    echo "Adding foto column to warga table...<br>";
    $conn->query("ALTER TABLE warga ADD COLUMN foto VARCHAR(255) DEFAULT NULL AFTER user_id");
} else {
    echo "Column foto already exists.<br>";
}

echo "Current columns: " . implode(", ", $columns) . "<br>";
?>
