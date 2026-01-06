<?php
require_once 'config/database.php';

$username = 'admin';
$password = 'admin123';
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$role = 'admin';

// Check if admin already exists
$check = $conn->query("SELECT * FROM users WHERE username = '$username'");

echo "<h3>Setup Admin Account</h3>";

if ($check->num_rows > 0) {
    echo "<div style='color: orange;'>Admin user 'admin' already exists.</div>";
    
    // Optional: Reset password if it exists
    $sql = "UPDATE users SET password = '$hashed_password' WHERE username = '$username'";
    if ($conn->query($sql) === TRUE) {
        echo "<div>Password for 'admin' has been reset to: <strong>$password</strong></div>";
        echo "<pre>Query: $sql</pre>";
    } else {
        echo "<div style='color: red;'>Error updating password: " . $conn->error . "</div>";
    }

} else {
    $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashed_password', '$role')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<div style='color: green;'>Admin user created successfully!</div>";
        echo "<p><strong>Username:</strong> $username<br><strong>Password:</strong> $password</p>";
        
        echo "<h4>SQL Query Used:</h4>";
        echo "<code style='background: #f4f4f4; padding: 10px; display: block;'>INSERT INTO users (username, password, role) VALUES ('$username', '".substr($hashed_password,0,10)."...(hashed)...', '$role');</code>";
    } else {
        echo "<div style='color: red;'>Error creating admin: " . $conn->error . "</div>";
    }
}

echo "<br><a href='login.php'>Go to Login</a>";
?>
