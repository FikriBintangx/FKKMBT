<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
require_once 'config/database.php';

echo "<h3>Initializing Dummy Data...</h3>";

try {
    // 1. Setup Table 'organisasi'
    $conn->query("CREATE TABLE IF NOT EXISTS organisasi (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nama_organisasi VARCHAR(100) NOT NULL,
        deskripsi TEXT
    )");
    
    // Check if table exists/works
    $conn->query("DELETE FROM organisasi");
    if ($conn->affected_rows > 0) echo "Cleared 'organisasi' table.<br>";

    $orgs = [
        ['FKKMBT', 'Forum Komunikasi Keluarga Besar Taman'],
        ['Karang Taruna', 'Organisasi Pemuda'],
        ['PKK', 'Pemberdayaan Kesejahteraan Keluarga'],
        ['Majelis Taklim', 'Kegiatan Keagamaan']
    ];

    $stmt = $conn->prepare("INSERT INTO organisasi (nama_organisasi, deskripsi) VALUES (?, ?)");
    foreach ($orgs as $o) {
         $stmt->bind_param("ss", $o[0], $o[1]);
         $stmt->execute();
    }
    echo "✅ Table 'organisasi' populated.<br>";


    // 2. Setup Table 'kegiatan'
    // First, check if column 'organisasi_id' exists. If not, maybe drop table to recreate clean schema.
    // For simplicity, we'll try to CREATE IF NOT EXISTS.
    $conn->query("CREATE TABLE IF NOT EXISTS kegiatan (
        id INT AUTO_INCREMENT PRIMARY KEY,
        organisasi_id INT,
        judul VARCHAR(200),
        deskripsi TEXT,
        tanggal DATE,
        waktu TIME,
        lokasi VARCHAR(100),
        foto VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    $conn->query("DELETE FROM kegiatan");

    $stmt = $conn->prepare("INSERT INTO kegiatan (organisasi_id, judul, deskripsi, tanggal, waktu, lokasi, foto) VALUES (?, ?, ?, ?, ?, ?, NULL)");
    
    $kegiatans = [
        [1, 'Kerja Bakti Akbar', 'Membersihkan saluran air utama dan pemangkasan pohon di jalan utama.', date('Y-m-d', strtotime('+3 days')), '07:00:00', 'Jalan Utama Blok A'],
        [2, 'Turnamen Futsal Pemuda', 'Pertandingan persahabatan antar blok untuk mempererat tali silaturahmi.', date('Y-m-d', strtotime('+10 days')), '15:30:00', 'Lapangan Futsal RW'],
        [3, 'Posyandu Balita', 'Pemeriksaan kesehatan rutin dan pemberian vitamin untuk balita.', date('Y-m-d', strtotime('-2 days')), '08:00:00', 'Balai Warga'],
        [4, 'Pengajian Bulanan', 'Kajian rutin bulanan dengan tema "Menjaga Kerukunan Bertetangga".', date('Y-m-d', strtotime('+1 week')), '19:30:00', 'Masjid Al-Muhajirin'],
        [1, 'Rapat Koordinasi RT', 'Pembahasan mengenai keamanan lingkungan dan jadwal ronda.', date('Y-m-d', strtotime('+5 days')), '20:00:00', 'Rumah Pak RT (Blok D/12)']
    ];

    foreach ($kegiatans as $k) {
        $stmt->bind_param("isssss", $k[0], $k[1], $k[2], $k[3], $k[4], $k[5]);
        $stmt->execute();
    }
    echo "✅ Table 'kegiatan' populated.<br>";


    // 3. Setup Table 'struktur_organisasi'
    $conn->query("CREATE TABLE IF NOT EXISTS struktur_organisasi (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nama VARCHAR(100),
        jabatan VARCHAR(100),
        level INT,
        urutan INT,
        foto VARCHAR(255)
    )");

    $conn->query("DELETE FROM struktur_organisasi");

    $stmt = $conn->prepare("INSERT INTO struktur_organisasi (nama, jabatan, level, urutan, foto) VALUES (?, ?, ?, ?, NULL)");
    
    $struktur = [
        ['Bpk. H. Ahmad Dahlan', 'Ketua Umum', 1, 1],
        ['Bpk. Susanto', 'Wakil Ketua', 2, 1],
        ['Ibu Siti Aminah', 'Sekretaris', 2, 2],
        ['Bpk. Budi Santoso', 'Bendahara', 2, 3],
        ['Bpk. Iwan Fals', 'Koord. Keamanan', 3, 1],
        ['Ibu Megawati', 'Koord. Kebersihan', 3, 2],
        ['Bpk. Rhoma Irama', 'Koord. Humas', 3, 3],
        ['Sdr. Duta Sheila', 'Koord. Pemuda', 3, 4]
    ];

    foreach ($struktur as $s) {
        $stmt->bind_param("ssii", $s[0], $s[1], $s[2], $s[3]);
        $stmt->execute();
    }
    echo "✅ Table 'struktur_organisasi' populated.<br>";

    echo "<br><strong>Done! All menus now have dummy data from database.</strong>";

} catch (mysqli_sql_exception $e) {
    echo "<br><strong style='color:red'>Error: " . $e->getMessage() . "</strong>";
}
echo "<br><a href='user/dashboard.php'>Go to Dashboard</a>";
?>
