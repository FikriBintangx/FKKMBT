<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Warga_model extends CI_Model {
    
    public function get_warga_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->get('warga')->row_array();
    }
    
    public function get_warga_by_user_id($user_id) {
        $this->db->where('user_id', $user_id);
        return $this->db->get('warga')->row_array();
    }
    
    public function get_all_warga() {
        $this->db->select('w.*, u.username, u.email');
        $this->db->from('warga w');
        $this->db->join('users u', 'w.user_id = u.id');
        $this->db->order_by('w.blok', 'ASC');
        $this->db->order_by('w.no_rumah', 'ASC');
        return $this->db->get()->result_array();
    }
    
    public function update_warga($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('warga', $data);
    }
}
