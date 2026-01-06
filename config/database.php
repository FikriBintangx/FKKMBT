<?php
// config/database.php

// === PENTING: BACA PETUNJUK INI UNTUK CPANEL ===
// 1. Di cPanel, nama database dan user PASTI ada awalan/prefix.
//    Contoh: Jika username cPanel Anda 'ti24se1', dan nama DB 'fkkmbt'
//    Maka nama lengkapnya jadi: 'ti24se1_fkkmbt'
// 2. Silakan edit bagian "SETTING HOSTING" di bawah ini sebelum dipakai.

$host = 'localhost';

// Deteksi otomatis: Apakah ini Laptop (Local) atau Hosting?
$is_localhost = ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1');

if ($is_localhost) {
    // === KONEKSI LOKAL (XAMPP LAMPTOP) ===
    $user = 'root';
    $pass = '';           
    $db   = 'fkkmbt';     
} else {
    // === KONEKSI HOSTING (CPANEL) - ISI BAGIAN INI ===
    
    // Ganti 'PREFIX' dengan username hosting Anda (lihat di cPanel sebelah kanan)
    // Biasanya formatnya: usernamecpanel_namadatabase
    
    $user = 'ti2b8143_fkkmbt_admin'; // <-- User Database dari screenshot cPanel
    $pass = '@fkkmbtjayajaya';       // <-- Password tetap (sesuai yang kakak ketik sebelumnya)
    $db   = 'ti2b8143_fkkmbt';       // <-- Nama Database dari screenshot cPanel
}

// Membuat koneksi
$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    if ($is_localhost) {
        die("Koneksi Gagal (Local): " . $conn->connect_error);
    } else {
        // Pesan error lebih sopan untuk user di hosting
        die("<h3>Mohon Maaf, Terjadi Kesalahan Sistem.</h3><p>Gagal terhubung ke database. Silakan hubungi administrator.</p><!-- Error asli (untuk admin): " . $conn->connect_error . " -->");
    }
}
?>
