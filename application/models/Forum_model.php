<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forum_model extends CI_Model {
    
    public function __construct() {
        // parent::__construct(); // Removed - causes error on production
        $this->_check_tables();
    }

    private function _check_tables() {
        $sql1 = "CREATE TABLE IF NOT EXISTS forum_thread (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            kategori VARCHAR(50) DEFAULT 'UMUM',
            judul VARCHAR(255) NOT NULL,
            isi TEXT NOT NULL,
            views INT DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        $this->db->query($sql1);

        $sql2 = "CREATE TABLE IF NOT EXISTS forum_reply (
            id INT AUTO_INCREMENT PRIMARY KEY,
            thread_id INT NOT NULL,
            user_id INT NOT NULL,
            isi TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        $this->db->query($sql2);
    }

    public function get_threads($kategori = null, $limit = 50) {
        $this->db->select('t.*, u.username, w.nama_lengkap, COUNT(r.id) as reply_count');
        $this->db->from('forum_thread t');
        $this->db->join('users u', 't.user_id = u.id');
        $this->db->join('warga w', 'w.user_id = u.id', 'left');
        $this->db->join('forum_reply r', 'r.thread_id = t.id', 'left');
        if ($kategori) $this->db->where('t.kategori', $kategori);
        $this->db->group_by('t.id');
        $this->db->order_by('t.created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

    public function get_thread($id) {
        $this->db->select('t.*, u.username, w.nama_lengkap, w.blok');
        $this->db->from('forum_thread t');
        $this->db->join('users u', 't.user_id = u.id');
        $this->db->join('warga w', 'w.user_id = u.id', 'left');
        $this->db->where('t.id', $id);
        return $this->db->get()->row_array();
    }

    public function get_replies($thread_id) {
        $this->db->select('r.*, u.username, w.nama_lengkap, w.blok');
        $this->db->from('forum_reply r');
        $this->db->join('users u', 'r.user_id = u.id');
        $this->db->join('warga w', 'w.user_id = u.id', 'left');
        $this->db->where('r.thread_id', $thread_id);
        $this->db->order_by('r.created_at', 'ASC');
        return $this->db->get()->result_array();
    }

    public function create_thread($data) {
        return $this->db->insert('forum_thread', $data);
    }

    public function create_reply($data) {
        return $this->db->insert('forum_reply', $data);
    }

    public function increment_view($id) {
        $this->db->set('views', 'views+1', FALSE);
        $this->db->where('id', $id);
        $this->db->update('forum_thread');
    }
}
