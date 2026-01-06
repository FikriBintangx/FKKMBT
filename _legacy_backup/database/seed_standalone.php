<?php
// Seeder Script - Standalone
// Run this to populate database with new structure tables and dummy data

$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'fkkmbt';

$conn = new mysqli($host, $user, $pass);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

// Create DB if not exists
$conn->query("CREATE DATABASE IF NOT EXISTS $db");
$conn->select_db($db);

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
    echo "Table 'struktur_organisasi' ready.<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

// 2. Clear existing structure data to prevent duplicates during testing
$conn->query("TRUNCATE TABLE struktur_organisasi");

// 3. Insert Dummy Struktur (Matches the requested image layout)
$struktur = [
    // Level 1: Ketua
    ['nama' => 'Bapak Ketua', 'jab' => 'Ketua RW', 'lvl' => 1, 'urutan' => 1],
    
    // Level 2: Wakil, Bendahara, Sekretaris
    ['nama' => 'Bapak Wakil', 'jab' => 'Wakil Ketua', 'lvl' => 2, 'urutan' => 1],
    ['nama' => 'Ibu Bendahara', 'jab' => 'Bendahara', 'lvl' => 2, 'urutan' => 2],
    ['nama' => 'Bapak Sekretaris', 'jab' => 'Sekretaris', 'lvl' => 2, 'urutan' => 3],
    
    // Level 3: Seksi (Optional)
    ['nama' => 'Seksi Keamanan', 'jab' => 'Koordinator', 'lvl' => 3, 'urutan' => 1],
    ['nama' => 'Seksi Kebersihan', 'jab' => 'Koordinator', 'lvl' => 3, 'urutan' => 2],
];

foreach ($struktur as $s) {
    $stmt = $conn->prepare("INSERT INTO struktur_organisasi (nama, jabatan, level, urutan) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssii", $s['nama'], $s['jab'], $s['lvl'], $s['urutan']);
    $stmt->execute();
}
echo "Inserted " . count($struktur) . " items into Struktur Organisasi.<br>";

// 4. Ensure Users Table exists
$conn->query("CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','warga') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

$conn->query("CREATE TABLE IF NOT EXISTS `warga` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `blok` varchar(10) NOT NULL,
  `no_rumah` varchar(10) NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `foto_profil` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `warga_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");


// 5. Insert Random Warga Data
$faker_names = ['Agus Santoso', 'Budi Hartono', 'Citra Lestari', 'Dewi Persik', 'Eko Yulianto', 'Fajar Sadboy', 'Gita Gutawa', 'Hesti Purwadinata', 'Indra Bekti', 'Joko Sasongko'];
$blocks = ['A', 'B', 'C', 'D'];

echo "Seeding Random Warga...<br>";
for($i=0; $i<10; $i++) {
    $name = $faker_names[$i];
    $username = strtolower(str_replace(' ', '', $name)) . rand(1,99);
    $password = password_hash('password', PASSWORD_DEFAULT);
    $block = $blocks[array_rand($blocks)];
    $num = rand(1, 40);
    
    // Check if username exists
    $chk = $conn->query("SELECT id FROM users WHERE username='$username'");
    if($chk->num_rows == 0) {
        $conn->query("INSERT INTO users (username, password, role) VALUES ('$username', '$password', 'warga')");
        $uid = $conn->insert_id;
        $conn->query("INSERT INTO warga (user_id, nama_lengkap, blok, no_rumah) VALUES ($uid, '$name', '$block', '$num')");
    }
}

echo "<h3>Seeding Complete!</h3>";
?>
