<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Struktur_model extends CI_Model {
    
    public function get_struktur($tipe) {
        $this->db->where('tipe_organisasi', $tipe);
        $this->db->order_by('level', 'ASC');
        $this->db->order_by('id', 'ASC');
        return $this->db->get('struktur_organisasi')->result_array();
    }
}
