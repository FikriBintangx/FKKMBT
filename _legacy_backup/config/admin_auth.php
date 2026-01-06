<?php
/**
 * Admin Authentication Middleware
 * Include this file at the top of any admin page to protect it
 * 
 * Usage:
 * require_once '../config/admin_auth.php';
 */

// Start session if not already started
require_once __DIR__ . '/config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['flash'] = [
        'type' => 'danger',
        'message' => 'Anda harus login terlebih dahulu!'
    ];
    header("Location: " . BASE_URL . "admin_login.php");
    exit;
}

// Check if user is admin
if ($_SESSION['role'] !== 'admin') {
    $_SESSION['flash'] = [
        'type' => 'danger',
        'message' => 'Akses ditolak! Anda tidak memiliki hak sebagai admin.'
    ];
    header("Location: " . BASE_URL . "login.php");
    exit;
}

// Optional: Refresh admin data from database
function getAdminData($conn) {
    if (!isset($_SESSION['user_id'])) {
        return null;
    }
    
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT u.*, a.nama_lengkap, a.jabatan 
            FROM users u 
            LEFT JOIN admins a ON u.id = a.user_id 
            WHERE u.id = $user_id AND u.role = 'admin'";
    
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    
    return null;
}
?>
