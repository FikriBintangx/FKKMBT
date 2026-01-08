<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forum_model extends CI_Model {
    
    public function get_all_forum() {
        $this->db->select('f.*, w.nama_lengkap, w.blok, w.no_rumah');
        $this->db->from('forum f');
        $this->db->join('warga w', 'w.id = f.warga_id');
        $this->db->order_by('f.created_at', 'DESC');
        return $this->db->get()->result_array();
    }
    
    public function create_forum($data) {
        return $this->db->insert('forum', $data);
    }
    
    public function count_comments($forum_id) {
        $this->db->where('forum_id', $forum_id);
        return $this->db->count_all_results('forum_komentar');
    }
}
