<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Voting_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->_check_tables();
    }

    private function _check_tables() {
        // Pemilihan Table
        $sql1 = "CREATE TABLE IF NOT EXISTS voting_pemilihan (
            id INT AUTO_INCREMENT PRIMARY KEY,
            judul VARCHAR(255) NOT NULL,
            deskripsi TEXT,
            tgl_mulai DATETIME NOT NULL,
            tgl_selesai DATETIME NOT NULL,
            status ENUM('DRAFT','ACTIVE','CLOSED') DEFAULT 'DRAFT',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        $this->db->query($sql1);

        // Kandidat Table
        $sql2 = "CREATE TABLE IF NOT EXISTS voting_kandidat (
            id INT AUTO_INCREMENT PRIMARY KEY,
            pemilihan_id INT NOT NULL,
            nama VARCHAR(255) NOT NULL,
            foto VARCHAR(255),
            visi_misi TEXT,
            urutan INT DEFAULT 1
        )";
        $this->db->query($sql2);

        // Vote Table
        $sql3 = "CREATE TABLE IF NOT EXISTS voting_suara (
            id INT AUTO_INCREMENT PRIMARY KEY,
            pemilihan_id INT NOT NULL,
            kandidat_id INT NOT NULL,
            user_id INT NOT NULL,
            voted_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            UNIQUE KEY unique_vote (pemilihan_id, user_id)
        )";
        $this->db->query($sql3);
    }

    public function get_active_voting() {
        $now = date('Y-m-d H:i:s');
        $this->db->where('status', 'ACTIVE');
        $this->db->where('tgl_mulai <=', $now);
        $this->db->where('tgl_selesai >=', $now);
        return $this->db->get('voting_pemilihan')->row_array();
    }

    public function get_kandidat($pemilihan_id) {
        $this->db->where('pemilihan_id', $pemilihan_id);
        $this->db->order_by('urutan', 'ASC');
        return $this->db->get('voting_kandidat')->result_array();
    }

    public function check_has_voted($pemilihan_id, $user_id) {
        $this->db->where(['pemilihan_id' => $pemilihan_id, 'user_id' => $user_id]);
        return $this->db->count_all_results('voting_suara') > 0;
    }

    public function cast_vote($pemilihan_id, $kandidat_id, $user_id) {
        return $this->db->insert('voting_suara', [
            'pemilihan_id' => $pemilihan_id,
            'kandidat_id' => $kandidat_id,
            'user_id' => $user_id
        ]);
    }

    public function get_results($pemilihan_id) {
        $this->db->select('k.*, COUNT(v.id) as total_suara');
        $this->db->from('voting_kandidat k');
        $this->db->join('voting_suara v', 'k.id = v.kandidat_id', 'left');
        $this->db->where('k.pemilihan_id', $pemilihan_id);
        $this->db->group_by('k.id');
        $this->db->order_by('total_suara', 'DESC');
        return $this->db->get()->result_array();
    }
}
