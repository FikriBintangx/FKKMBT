<?php
require_once 'config/database.php';

echo "Checking for admin users...\n";
$result = $conn->query("SELECT * FROM users WHERE role='admin'");
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "User ID: " . $row['id'] . ", Username: " . $row['username'] . "\n";
        
        // Check if exists in admins
        // Since we just created the table empty, we know it won't exist unless someone inserted it just now.
        // But let's write the query to be safe or to fix it.
    }
} else {
    echo "No admin users found.\n";
}
?>
