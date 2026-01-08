<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Surat_model extends CI_Model {
    
    public function create_surat($data) {
        return $this->db->insert('pengajuan_surat', $data);
    }
    
    public function get_riwayat_surat($warga_id) {
        $this->db->where('warga_id', $warga_id);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('pengajuan_surat')->result_array();
    }
}
