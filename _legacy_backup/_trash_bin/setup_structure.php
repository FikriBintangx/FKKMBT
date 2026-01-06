<?php
require_once 'config/database.php';

// Create struktur_organisasi table
$sql = "CREATE TABLE IF NOT EXISTS struktur_organisasi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    jabatan VARCHAR(100) NOT NULL,
    level INT NOT NULL COMMENT '1: Ketua, 2: Inti, 3: Koordinator',
    urutan INT DEFAULT 0,
    foto VARCHAR(255) DEFAULT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'struktur_organisasi' created successfully.<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
    exit;
}

// Check if data exists
$result = $conn->query("SELECT count(*) as total FROM struktur_organisasi");
$row = $result->fetch_assoc();

if ($row['total'] == 0) {
    // Insert sample data
    $sql_insert = "INSERT INTO struktur_organisasi (nama, jabatan, level, urutan, foto) VALUES 
    ('H. Agus Salim', 'Ketua FKKMBT', 1, 1, NULL),
    ('Budi Santoso', 'Wakil Ketua', 2, 1, NULL),
    ('Siti Aminah', 'Sekretaris 1', 2, 2, NULL),
    ('Rina Wati', 'Sekretaris 2', 2, 3, NULL),
    ('Joko Susilo', 'Bendahara 1', 2, 4, NULL),
    ('Dewi Lestari', 'Bendahara 2', 2, 5, NULL),
    ('Ahmad Dahlan', 'Koordinator Keagamaan', 3, 1, NULL),
    ('Bambang Pamungkas', 'Koordinator Olahraga', 3, 2, NULL),
    ('Citra Kirana', 'Koordinator Humas', 3, 3, NULL),
    ('Doni Tata', 'Koordinator Keamanan', 3, 4, NULL),
    ('Eko Patrio', 'Koordinator Lingkungan', 3, 5, NULL)";

    if ($conn->query($sql_insert) === TRUE) {
        echo "Sample data inserted successfully.<br>";
    } else {
        echo "Error inserting data: " . $conn->error . "<br>";
    }
} else {
    echo "Data already exists.<br>";
}

echo "Setup completed.";
?>
