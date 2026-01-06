<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Surat_model extends CI_Model {
    
    public function __construct() {
        // parent::__construct(); // Removed - causes error on some servers
        $this->_check_table();
    }

    private function _check_table() {
        $sql = "CREATE TABLE IF NOT EXISTS surat_pengantar (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            jenis_surat VARCHAR(100) NOT NULL,
            keperluan TEXT NOT NULL,
            tgl_request DATETIME DEFAULT CURRENT_TIMESTAMP,
            status ENUM('PENDING','APPROVED','REJECTED') DEFAULT 'PENDING',
            file_surat VARCHAR(255) DEFAULT NULL,
            keterangan_admin TEXT,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        $this->db->query($sql);
    }

    public function create_request($data) {
        return $this->db->insert('surat_pengantar', $data);
    }

    public function get_my_requests($user_id) {
        $this->db->order_by('tgl_request', 'DESC');
        return $this->db->get_where('surat_pengantar', ['user_id' => $user_id])->result_array();
    }

    public function get_all_requests() {
        $this->db->select('s.*, u.username, w.nama_lengkap, w.blok, w.no_rumah');
        $this->db->from('surat_pengantar s');
        $this->db->join('users u', 's.user_id = u.id');
        $this->db->join('warga w', 'w.user_id = u.id', 'left');
        $this->db->order_by('s.tgl_request', 'DESC');
        return $this->db->get()->result_array();
    }

    public function update_status($id, $status, $keterangan) {
        $data = ['status' => $status, 'keterangan_admin' => $keterangan];
        $this->db->where('id', $id);
        return $this->db->update('surat_pengantar', $data);
    }
}
