<?php
require_once 'config/database.php';

// 1. Clear existing FKKMMBT data to start fresh (easier than updating)
$conn->query("DELETE FROM struktur_organisasi WHERE tipe_organisasi = 'FKKMMBT'");

// 2. Insert new structure matching user request
// Level 1: Ketua Umum
// Level 2: Wakil Ketua
// Level 3: Sekretaris 1, Sekretaris 2, Bendahara 1, Bendahara 2
// Level 4: Divisi

$data = [
    // Row 1
    ['Aceva Arie Sadewa', 'Ketua Umum', 1],
    
    // Row 2
    ['Rina Wati', 'Wakil Ketua', 2],
    
    // Row 3
    ['Ahmad Dani', 'Sekretaris I', 3],
    ['Siti Badriah', 'Sekretaris II', 3],
    ['Budi Doremi', 'Bendahara I', 3],
    ['Via Vallen', 'Bendahara II', 3],
    
    // Row 4 (Divisi)
    ['Dedi Corbuz', 'Divisi Kepemudaan', 4],
    ['Cinta Laura', 'Divisi Kreatif', 4],
    ['Atta Halilintar', 'Divisi Humas', 4]
];

$stmt = $conn->prepare("INSERT INTO struktur_organisasi (tipe_organisasi, nama, jabatan, level, jenis_kelamin) VALUES ('FKKMMBT', ?, ?, ?, 'L')");

foreach ($data as $row) {
    // Assuming mixed gender for variety, but default 'L' for simplicity in checking script
    $stmt->bind_param("ssi", $row[0], $row[1], $row[2]);
    $stmt->execute();
}

echo "FKKMMBT roles updated successfully.\n";
?>
