<?php
// Seeder Script used to populate the database with required tables and dummy data
// Run this by visiting it in the browser or via CLI

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'fkkmbt');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h3>Starting Database Seeding...</h3>";

// 1. Create struktur_organisasi table
$sql = "CREATE TABLE IF NOT EXISTS `struktur_organisasi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `level` int(1) NOT NULL DEFAULT 2 COMMENT '1: Ketua, 2: Wakil/Inti, 3: Anggota/Seksi',
  `urutan` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "Table 'struktur_organisasi' created or exists.<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

// 2. Insert Dummy Users and Warga
// Check if user exists first to avoid duplicate errors
$users = [
    ['user' => 'agus_susilo', 'pass' => 'password123', 'nama' => 'Agus Susilo', 'blok' => 'B', 'no' => '10'],
    ['user' => 'bambang_p', 'pass' => 'password123', 'nama' => 'Bambang Pamungkas', 'blok' => 'C', 'no' => '05'],
    ['user' => 'citra_k', 'pass' => 'password123', 'nama' => 'Citra Kirana', 'blok' => 'A', 'no' => '02'],
];

foreach ($users as $u) {
    $check = $conn->query("SELECT id FROM users WHERE username = '".$u['user']."'");
    if ($check->num_rows == 0) {
        $hash = password_hash($u['pass'], PASSWORD_DEFAULT);
        $conn->query("INSERT INTO users (username, password, role) VALUES ('".$u['user']."', '$hash', 'warga')");
        $uid = $conn->insert_id;
        $conn->query("INSERT INTO warga (user_id, nama_lengkap, blok, no_rumah, no_hp) VALUES ($uid, '".$u['nama']."', '".$u['blok']."', '".$u['no']."', '081200000000')");
        echo "Inserted user: " . $u['user'] . "<br>";
    }
}

// 3. Insert Dummy Struktur
$struktur = [
    ['nama' => 'H. Budi Santoso', 'jab' => 'Ketua RW', 'lvl' => 1, 'img' => ''],
    ['nama' => 'Iwan Setiawan', 'jab' => 'Wakil Ketua', 'lvl' => 2, 'img' => ''],
    ['nama' => 'Rina Hartati', 'jab' => 'Sekretaris', 'lvl' => 2, 'img' => ''],
    ['nama' => 'Joko Anwar', 'jab' => 'Bendahara', 'lvl' => 2, 'img' => ''],
    ['nama' => 'Ahmad Rizki', 'jab' => 'Koordinator Keamanan', 'lvl' => 3, 'img' => ''],
    ['nama' => 'Siti Aminah', 'jab' => 'Koordinator Kebersihan', 'lvl' => 3, 'img' => ''],
];

// Truncate to reset demo data? No, let's just insert if empty
$check_struct = $conn->query("SELECT id FROM struktur_organisasi LIMIT 1");
if ($check_struct->num_rows == 0) {
    echo "Seeding Struktur Organisasi...<br>";
    foreach ($struktur as $s) {
        $stmt = $conn->prepare("INSERT INTO struktur_organisasi (nama, jabatan, level, foto) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $s['nama'], $s['jab'], $s['lvl'], $s['img']);
        $stmt->execute();
    }
} else {
    echo "Struktur Organisasi already has data.<br>";
}

echo "<h3>Seeding Completed Successfully!</h3>";
echo "<a href='../index.php'>Go Home</a>";
?>
