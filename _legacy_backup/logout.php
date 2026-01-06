<?php
/**
 * Logout Script
 * Menghapus semua session dan redirect ke halaman utama
 */

session_start();

// Simpan pesan flash sebelum destroy session
$_SESSION = array();

// Destroy session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-3600, '/');
}

// Destroy session
session_destroy();

// Start new session untuk flash message
session_start();
$_SESSION['flash'] = [
    'type' => 'success',
    'message' => 'Anda telah berhasil logout!'
];

// Redirect ke halaman utama
header("Location: index.php");
exit;
?>
