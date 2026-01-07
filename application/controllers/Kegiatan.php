<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kegiatan extends CI_Controller {

	public function index()
	{
		$data['title'] = 'Kegiatan Warga';

        // Fetch All Kegiatan
        $this->db->select('k.*, o.nama_organisasi');
        $this->db->from('kegiatan k');
        $this->db->join('organisasi o', 'k.organisasi_id = o.id', 'left');
        $this->db->order_by('k.tanggal', 'DESC');
        $data['kegiatan_list'] = $this->db->get()->result_array();

        // Separate Upcoming vs Past
        $data['upcoming'] = [];
        $data['past'] = [];
        $today = date('Y-m-d');

        foreach ($data['kegiatan_list'] as $row) {
            if ($row['tanggal'] >= $today) {
                $data['upcoming'][] = $row;
            } else {
                $data['past'][] = $row;
            }
        }

        // Sort upcoming: ASC (closest first)
        usort($data['upcoming'], function($a, $b) {
            return $a['tanggal'] <=> $b['tanggal'];
        });

		$this->load->view('templates/header', $data);
		$this->load->view('kegiatan', $data);
		$this->load->view('templates/footer');
	}

    public function detail($id)
    {
        $this->db->select('k.*, o.nama_organisasi');
        $this->db->from('kegiatan k');
        $this->db->join('organisasi o', 'k.organisasi_id = o.id', 'left');
        $this->db->where('k.id', $id);
        $data['kegiatan'] = $this->db->get()->row_array();

        if (!$data['kegiatan']) show_404();

        // Start Gallery Fetch
        $data['galeri'] = $this->db->get_where('kegiatan_galeri', ['kegiatan_id' => $id])->result_array();

        $data['title'] = $data['kegiatan']['judul'];
        $this->load->view('templates/header', $data);
        $this->load->view('kegiatan_detail', $data); // Assuming I might need this, but for now I focus on main page
        $this->load->view('templates/footer');
    }
}
