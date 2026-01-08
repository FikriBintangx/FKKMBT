<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Struktur extends CI_Controller {
    public function index()
    {
        $data['title'] = 'Struktur Organisasi';
        
        // Fetch Data
        $data['struct_fkkmbt'] = $this->_get_grouped_struct('FKKMBT');
        $data['struct_fkkmmbt'] = $this->_get_grouped_struct('FKKMMBT');

        // Debug if needed or pass empty if table missing
        if (empty($data['struct_fkkmbt']) && empty($data['struct_fkkmmbt'])) {
             // Fallback or empty state handled in view
        }

        $this->load->view('templates/header', $data);
        $this->load->view('struktur', $data);
        $this->load->view('templates/footer');
    }

    private function _get_grouped_struct($type) {
        // Check if table exists first to avoid crash if migration not run
        if (!$this->db->table_exists('struktur_organisasi')) {
            return [];
        }

        $this->db->where('UPPER(tipe_organisasi)', strtoupper($type));
        $rows = $this->db->get('struktur_organisasi')->result_array();

        $grouped = [];
        foreach ($rows as $row) {
            $jabatan = strtoupper(trim($row['jabatan']));
            $grouped[$jabatan][] = $row;
        }

        // Custom Sorting Priorities
        $sortOrder = [
            'PEMBINA' => 1, 
            'KETUA' => 2, 'KETUA UMUM' => 2,
            'PENASEHAT' => 3, 
            'WAKIL KETUA' => 5, 'WAKIL' => 5,
            'SEKRETARIS' => 6, 'SEKRETARIS I' => 6, 'SEKRETARIS II' => 6, 'SEKRETARIS JENDERAL' => 6,
            'BENDAHARA' => 7, 'BENDAHARA I' => 7, 'BENDAHARA II' => 7,
            // Seksi
            'SEKSI KESEJAHTERAAN' => 20, 
            'SEKSI PENGEMBANGAN EKONOMI' => 21, 
            'SEKSI HUMAS' => 22, 'SEKSI HUMAS, PUBLIKASI DAN KOMUNIKASI' => 22,
            'SEKSI KEPEMUDAAN' => 23, 'SEKSI KEPEMUDAAN DAN OLAHRAGA' => 23, 
            'SEKSI LINGKUNGAN' => 24, 'SEKSI PERENCANAAN LINGKUNGAN' => 24, 
            'SEKSI SENI' => 25, 'SEKSI SENI DAN BUDAYA' => 25,
            'SEKSI ROHANI' => 26, 'SEKSI KEROHANIAN' => 26, 
            'SEKSI KEAMANAN' => 27, 
            'SEKSI PERLENGKAPAN' => 28, 
            'SEKSI KEWANITAAN' => 29
        ];

        uksort($grouped, function($k1, $k2) use ($sortOrder) {
            $p1 = isset($sortOrder[$k1]) ? $sortOrder[$k1] : 999;
            $p2 = isset($sortOrder[$k2]) ? $sortOrder[$k2] : 999;
            return ($p1 == $p2) ? 0 : (($p1 < $p2) ? -1 : 1);
        });

        return $grouped;
    }
}
