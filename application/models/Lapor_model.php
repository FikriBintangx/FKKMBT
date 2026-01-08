<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lapor_model extends CI_Model {
    
    public function __construct() {
        // parent::__construct(); // Removed to fix error
        $this->check_table();
    }

    private function check_table() {
        // Buat tabel laporan_warga jika belum ada
        $sql = "CREATE TABLE IF NOT EXISTS `laporan_warga` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `warga_id` int(11) NOT NULL,
            `judul` varchar(255) NOT NULL,
            `kategori` varchar(100) NOT NULL,
            `deskripsi` text NOT NULL,
            `foto` varchar(255) DEFAULT NULL,
            `status` enum('Pending','Diproses','Selesai','Ditolak') DEFAULT 'Pending',
            `tanggapan` text DEFAULT NULL,
            `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        $this->db->query($sql);
    }

    public function create_laporan($data) {
        return $this->db->insert('laporan_warga', $data);
    }

    public function get_riwayat_laporan($warga_id) {
        $this->db->where('warga_id', $warga_id);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('laporan_warga')->result_array();
    }
}
