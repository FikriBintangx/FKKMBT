<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lapak_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->_check_table();
    }

    private function _check_table() {
        $sql = "CREATE TABLE IF NOT EXISTS lapak_produk (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            nama_produk VARCHAR(255) NOT NULL,
            deskripsi TEXT,
            harga DECIMAL(15,2) DEFAULT 0,
            foto VARCHAR(255) DEFAULT NULL,
            kategori VARCHAR(100) DEFAULT 'lainnya',
            kontak_wa VARCHAR(20) NOT NULL,
            dilihat INT DEFAULT 0,
            is_active TINYINT(1) DEFAULT 1,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        $this->db->query($sql);
    }

    public function get_all($limit = null, $cat = null, $search = null) {
        $this->db->select('l.*, u.username, w.nama_lengkap, w.blok, w.no_rumah');
        $this->db->from('lapak_produk l');
        $this->db->join('users u', 'l.user_id = u.id');
        $this->db->join('warga w', 'w.user_id = u.id', 'left');
        $this->db->where('l.is_active', 1);
        
        if ($cat) $this->db->where('l.kategori', $cat);
        if ($search) $this->db->like('l.nama_produk', $search);
        
        $this->db->order_by('l.created_at', 'DESC');
        if ($limit) $this->db->limit($limit);
        
        return $this->db->get()->result_array();
    }

    public function get_by_user($user_id) {
        $this->db->where('user_id', $user_id);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('lapak_produk')->result_array();
    }

    public function get_detail($id) {
        $this->db->select('l.*, w.nama_lengkap, w.blok, w.no_rumah');
        $this->db->from('lapak_produk l');
        $this->db->join('users u', 'l.user_id = u.id');
        $this->db->join('warga w', 'w.user_id = u.id', 'left');
        $this->db->where('l.id', $id);
        return $this->db->get()->row_array();
    }

    public function increment_view($id) {
        $this->db->set('dilihat', 'dilihat+1', FALSE);
        $this->db->where('id', $id);
        $this->db->update('lapak_produk');
    }

    public function create($data) {
        return $this->db->insert('lapak_produk', $data);
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('lapak_produk', $data);
    }

    public function delete($id) {
        return $this->db->delete('lapak_produk', ['id' => $id]);
    }
}
