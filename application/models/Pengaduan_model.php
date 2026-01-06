<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaduan_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        // Auto-create table if not exists
        $this->_check_table();
    }

    private function _check_table() {
        $sql = "CREATE TABLE IF NOT EXISTS pengaduan (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            judul VARCHAR(255) NOT NULL,
            isi TEXT NOT NULL,
            foto VARCHAR(255) DEFAULT NULL,
            status ENUM('pending', 'proses', 'selesai', 'ditolak') DEFAULT 'pending',
            tanggapan_admin TEXT DEFAULT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        $this->db->query($sql);
    }

    public function get_all($status = null) {
        $this->db->select('p.*, u.username, w.nama_lengkap, w.blok, w.no_rumah');
        $this->db->from('pengaduan p');
        $this->db->join('users u', 'p.user_id = u.id');
        $this->db->join('warga w', 'w.user_id = u.id', 'left'); // Left join incase user is not in warga table yet
        if ($status) {
            $this->db->where('p.status', $status);
        }
        $this->db->order_by('p.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_by_user($user_id) {
        $this->db->where('user_id', $user_id);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('pengaduan')->result_array();
    }

    public function create($data) {
        return $this->db->insert('pengaduan', $data);
    }

    public function update_status($id, $status, $tanggapan) {
        $data = [
            'status' => $status,
            'tanggapan_admin' => $tanggapan
        ];
        $this->db->where('id', $id);
        return $this->db->update('pengaduan', $data);
    }
    
    // Stats for Dashboard
    public function count_by_status($status) {
        $this->db->where('status', $status);
        return $this->db->count_all_results('pengaduan');
    }
}
