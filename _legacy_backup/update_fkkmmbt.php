<?php
require_once 'config/database.php';

// Data to insert
$data = [
    ['Aceva Arie Sadewa', 'Ketua Umum', 1],
    ['Rina Wati', 'Wakil Ketua', 2],
    ['Ahmad Dani', 'Sekretaris', 2],
    ['Dedi Corbuz', 'Ketua Karang Taruna', 3],
    ['Cinta Laura', 'Divisi Kreatif', 3]
];

$stmt = $conn->prepare("INSERT INTO struktur_organisasi (tipe_organisasi, nama, jabatan, level, jenis_kelamin) VALUES (?, ?, ?, ?, 'L')");
$type = 'FKKMMBT';

foreach ($data as $row) {
    // Check if exists first to avoid dupes (though table was empty)
    $check = $conn->query("SELECT id FROM struktur_organisasi WHERE nama = '{$row[0]}' AND tipe_organisasi = '$type'");
    if ($check->num_rows == 0) {
        $stmt->bind_param("sssi", $type, $row[0], $row[1], $row[2]);
        if ($stmt->execute()) {
            echo "Inserted: {$row[0]} as {$row[1]}\n";
        } else {
            echo "Error inserting {$row[0]}: " . $stmt->error . "\n";
        }
    } else {
        echo "Skipped existing: {$row[0]}\n";
    }
}

echo "FKKMMBT update complete.\n";
?>
