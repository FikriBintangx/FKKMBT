<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
require_once 'config/database.php';

echo "<h3>Seeding Random Data for Iuran & Kegiatan...</h3>";

try {
    // 1. Seed Iuran Master (Bills for the last 6 months)
    echo "<h4>Generating Bills (Iuran Master)...</h4>";
    // Check existing
    $check = $conn->query("SELECT COUNT(*) as total FROM iuran_master");
    if ($check->fetch_assoc()['total'] < 2) {
        $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $currentMonthIndex = (int)date('n') - 1; // 0-11
        
        // Generate for last 6 months including current
        for ($i = 5; $i >= 0; $i--) {
            $monthIndex = $currentMonthIndex - $i;
            if ($monthIndex < 0) $monthIndex += 12;
            
            $monthName = $months[$monthIndex];
            $year = date('Y'); // Simplified year logic
            
            $nama_iuran = "Iuran Warga $monthName $year";
            $nominal = 100000;
            $jatuh_tempo = date('Y-m-20', strtotime("-$i months"));
            $status = ($i == 0) ? 'aktif' : 'selesai';

            $conn->query("INSERT INTO iuran_master (nama_iuran, nominal, jatuh_tempo, status) VALUES ('$nama_iuran', '$nominal', '$jatuh_tempo', '$status')");
        }
        echo "✅ Created 6 months of Iuran bills.<br>";
    } else {
        echo "ℹ️ Iuran bills already exist. Skipping.<br>";
    }

    // 2. Seed Pembayaran Iuran (Random payments for existing Warga)
    echo "<h4>Generating Payment History...</h4>";
    $warga_res = $conn->query("SELECT id FROM warga");
    $iuran_res = $conn->query("SELECT id, nominal FROM iuran_master");
    
    $iurans = [];
    while($row = $iuran_res->fetch_assoc()) $iurans[] = $row;
    
    while($w = $warga_res->fetch_assoc()) {
        foreach($iurans as $iuran) {
            // 80% chance to have paid
            if (rand(1, 100) <= 80) {
                // Check if already paid
                $check_pay = $conn->query("SELECT id FROM pembayaran_iuran WHERE warga_id = {$w['id']} AND iuran_id = {$iuran['id']}");
                if ($check_pay->num_rows == 0) {
                    $status = (rand(1, 10) > 1) ? 'disetujui' : 'pending'; // Mostly approved
                    $bukti = 'receipt_dummy.jpg'; // Files won't exist but DB record will
                    $tgl_bayar = date('Y-m-d', strtotime('-'.rand(1, 30).' days'));
                    
                    $stmt = $conn->prepare("INSERT INTO pembayaran_iuran (warga_id, iuran_id, tgl_bayar, bukti_transfer, status) VALUES (?, ?, ?, ?, ?)");
                    $stmt->bind_param("iisss", $w['id'], $iuran['id'], $tgl_bayar, $bukti, $status);
                    $stmt->execute();
                }
            }
        }
    }
    echo "✅ Generated random payment history for all Warga.<br>";


    // 3. Seed More Kegiatan (Activities)
    echo "<h4>Generating More Activities...</h4>";
    // Check count
    $cnt_keg = $conn->query("SELECT COUNT(*) as total FROM kegiatan")->fetch_assoc()['total'];
    if ($cnt_keg < 10) {
        $titles = [
            "Senam Pagi Bersama", "Penyuluhan DBD", "Festival Kuliner Warga", 
            "Rapat panitia 17an", "Donor Darah Rutin", "Lomba Memasak Ibu-ibu"
        ];
        
        $stmt = $conn->prepare("INSERT INTO kegiatan (organisasi_id, judul, deskripsi, tanggal, waktu, lokasi) VALUES (?, ?, ?, ?, ?, ?)");
        
        foreach($titles as $t) {
            $org_id = rand(1, 4); // Assuming orgs 1-4 exist
            $desc = "Kegiatan rutin untuk mempererat kebersamaan dan kesehatan warga.";
            $date = date('Y-m-d', strtotime('+'.rand(1, 60).' days'));
            $time = '08:00:00';
            $loc = "Balai Warga RW 05";
            
            $stmt->bind_param("isssss", $org_id, $t, $desc, $date, $time, $loc);
            $stmt->execute();
        }
        echo "✅ Added " . count($titles) . " more random activities.<br>";
    } else {
        echo "ℹ️ Activities already sufficient.<br>";
    }

    echo "<br><strong>Done! Random data seeded successfully.</strong>";

} catch (Exception $e) {
    echo "<br><strong style='color:red'>Error: " . $e->getMessage() . "</strong>";
}
echo "<br><a href='user/iuran.php'>Check Iuran Menu</a>";
?>
