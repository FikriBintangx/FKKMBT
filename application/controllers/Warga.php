<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Warga extends CI_Controller {

	public function index()
	{
		$data['title'] = 'Direktori Warga';

        // Filter Logic
        $blok = $this->input->get('blok');
        $search = $this->input->get('search');

        $this->db->select('*');
        $this->db->from('warga');
        
        if (!empty($blok)) {
            // Check if full block (A1) or just letter (A)
            // Assuming database has 'blok' column like 'A' and 'no_rumah' like '1'
            // OR 'blok' column is 'A' and we filter by it.
            // Legacy code used: WHERE blok = '$b'
            // But legacy UI passed 'A1', 'A2', etc.
            // If database stores 'blok' as 'A' and 'no_rumah' as '01', then filtering by 'A1' is tricky unless we have a specific column structure.
            // Let's assume for now we filter by the Letter of the block if the input is just 'A', 'B'.
            // If input is 'A1', 'A2', we might need to exact match if column supports it.
            
            // Re-reading legacy: $blok_code = $letter . $num; -> ?blok=A1
            // Legacy SQL: WHERE blok = '$b'.
            // This implies the 'blok' column in legacy DB held 'A1', 'A2', etc. OR 'A' and user just filtered A.
            // Wait, legacy layout had buttons for A1-A5.
            // If db column 'blok' is just 'A', then ?blok=A1 would return nothing.
            // Let's assume the DB has 'blok' column storing 'A', 'B', etc. 
            // AND maybe the user wants to see specific rows?
            // Actually, in Bukit Tiara, blocks are usually letters. 'A1' usually means Block A, Number 1? Or Block A1?
            
            // Let's try to match exact first.
            $this->db->where('blok', $blok);
        }

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_lengkap', $search);
            $this->db->or_like('no_rumah', $search);
            $this->db->group_end();
        }

        $this->db->order_by('blok', 'ASC');
        $this->db->order_by('no_rumah', 'ASC');
        $this->db->limit(50); // Limit results for performance

        $data['warga_list'] = $this->db->get()->result_array();
        $data['selected_blok'] = $blok;
        $data['search_keyword'] = $search;

		$this->load->view('templates/header', $data);
		$this->load->view('warga', $data);
		$this->load->view('templates/footer');
	}
}
