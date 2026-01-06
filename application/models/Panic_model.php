<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Panic_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->_check_table();
    }

    private function _check_table() {
        $sql = "CREATE TABLE IF NOT EXISTS panic_log (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            jenis_darurat ENUM('KEBAKARAN','MALING','MEDIS','LAINNYA') DEFAULT 'LAINNYA',
            pesan TEXT,
            lokasi_lat VARCHAR(50),
            lokasi_long VARCHAR(50),
            status ENUM('OPEN','HANDLED') DEFAULT 'OPEN',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        $this->db->query($sql);
    }

    public function create_alert($data) {
        $this->db->insert('panic_log', $data);
        return $this->db->insert_id();
    }

    public function get_active_alerts() {
        $this->db->select('p.*, u.username, w.nama_lengkap, w.blok, w.no_rumah, w.no_hp');
        $this->db->from('panic_log p');
        $this->db->join('users u', 'p.user_id = u.id');
        $this->db->join('warga w', 'w.user_id = u.id', 'left');
        $this->db->where('p.status', 'OPEN');
        $this->db->order_by('p.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function mark_handled($id) {
        $this->db->where('id', $id);
        $this->db->update('panic_log', ['status' => 'HANDLED']);
    }
}
