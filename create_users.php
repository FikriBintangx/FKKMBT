<?php
// Script untuk membuat user default admin dan warga
require_once 'config/database.php';

// Hapus user lama jika ada
$conn->query("DELETE FROM users WHERE username IN ('admin', 'warga1')");

// 1. Buat Admin User
$admin_username = 'admin';
$admin_password = 'admin123';
$admin_hash = password_hash($admin_password, PASSWORD_DEFAULT);

$conn->query("INSERT INTO users (username, password, role) VALUES ('$admin_username', '$admin_hash', 'admin')");
$admin_user_id = $conn->insert_id;

$conn->query("INSERT INTO admins (user_id, nama_lengkap, jabatan) VALUES ('$admin_user_id', 'Administrator FKKMBT', 'Admin Utama')");

echo "✅ Admin created successfully!\n";
echo "   Username: admin\n";
echo "   Password: admin123\n\n";

// 2. Buat Warga User
$warga_username = 'warga1';
$warga_password = 'warga123';
$warga_hash = password_hash($warga_password, PASSWORD_DEFAULT);

$conn->query("INSERT INTO users (username, password, role) VALUES ('$warga_username', '$warga_hash', 'warga')");
$warga_user_id = $conn->insert_id;

$conn->query("INSERT INTO warga (user_id, nama_lengkap, blok, no_rumah, no_hp) VALUES ('$warga_user_id', 'Budi Santoso', 'A', '12', '081234567890')");

echo "✅ Warga created successfully!\n";
echo "   Username: warga1\n";
echo "   Password: warga123\n\n";

echo "🎉 Sekarang coba login di: http://localhost/fkkmbt/login.php\n";

$conn->close();
?>
