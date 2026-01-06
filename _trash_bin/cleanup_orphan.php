<?php
require_once 'config/database.php';

$id = 12; // The ID found in previous step
$username = 'admin@gmail.com';

$sql = "DELETE FROM users WHERE id=$id AND username='$username'";
if ($conn->query($sql) === TRUE) {
    echo "Deleted orphan user ID $id successfully.";
} else {
    echo "Error deleting: " . $conn->error;
}
?>
