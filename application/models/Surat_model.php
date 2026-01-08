<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Surat_model extends CI_Model {
    
    public function __construct() {
        // parent::__construct(); // Removed to fix error
        $this->check_table_exists();
    }

    private function check_table_exists() {
        $query = "CREATE TABLE IF NOT EXISTS `pengajuan_surat` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `warga_id` int(11) NOT NULL,
            `jenis_surat` enum('Surat Pengantar','Keterangan Domisili','Izin Keramaian','Keterangan Kematian') NOT NULL,
            `keperluan` text NOT NULL,
            `keterangan` text DEFAULT NULL,
            `status` enum('Pending','Diproses','Selesai','Ditolak') DEFAULT 'Pending',
            `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        $this->db->query($query);
    }
    
    public function create_surat($data) {
        return $this->db->insert('pengajuan_surat', $data);
    }
    
    public function get_riwayat_surat($warga_id) {
        $this->db->where('warga_id', $warga_id);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('pengajuan_surat')->result_array();
    }

    // Fungsi Khusus Admin
    public function get_all_requests() {
        $this->db->select('pengajuan_surat.*, warga.nama_lengkap, warga.blok, warga.no_rumah');
        $this->db->from('pengajuan_surat');
        $this->db->join('warga', 'warga.id = pengajuan_surat.warga_id');
        $this->db->order_by('pengajuan_surat.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function update_status($id, $status, $keterangan = null) {
        $data = ['status' => $status];
        if($keterangan) {
            $data['keterangan'] = $keterangan;
        }
        $this->db->where('id', $id);
        return $this->db->update('pengajuan_surat', $data);
    }
}
