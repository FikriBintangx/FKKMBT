<?php
class Setup_surat extends CI_Controller {
    public function index() {
        $this->load->database();
        
        $sql = "CREATE TABLE IF NOT EXISTS `pengajuan_surat` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `warga_id` int(11) NOT NULL,
            `jenis_surat` enum('Surat Pengantar','Keterangan Domisili','Izin Keramaian','Keterangan Kematian') NOT NULL,
            `keperluan` text NOT NULL,
            `keterangan` text DEFAULT NULL,
            `status` enum('Pending','Diproses','Selesai','Ditolak') DEFAULT 'Pending',
            `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

        if($this->db->query($sql)) {
            echo "Tabel Pengajuan Surat berhasil dibuat!";
        } else {
            echo "Gagal: " . $this->db->error();
        }
    }
}
