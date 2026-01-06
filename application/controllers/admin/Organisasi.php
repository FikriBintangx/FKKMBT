<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Organisasi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id') || $this->session->userdata('role') !== 'admin') {
            redirect('auth/login');
        }
    }

    public function index() {
        $data['struct_fkkmbt'] = $this->_get_grouped_struct('FKKMBT');
        $data['struct_fkkmmbt'] = $this->_get_grouped_struct('FKKMMBT');
        $this->load->view('admin/organisasi', $data);
    }

    private function _get_grouped_struct($type) {
        $this->db->where('UPPER(tipe_organisasi)', strtoupper($type));
        $rows = $this->db->get('struktur_organisasi')->result_array();

        $grouped = [];
        foreach ($rows as $row) {
            $jabatan = strtoupper(trim($row['jabatan']));
            $grouped[$jabatan][] = $row;
        }

        // Custom Sorting
        $sortOrder = [
            'PEMBINA' => 1, 'KETUA' => 2, 'PENASEHAT' => 3, 'BENDAHARA I' => 4, 'WAKIL KETUA' => 5, 'SEKRETARIS I' => 6,
            'BENDAHARA II' => 7, 'SEKRETARIS II' => 8,
            'SEKSI KESEJAHTERAAN' => 20, 'SEKSI PENGEMBANGAN EKONOMI' => 21, 'SEKSI HUMAS, PUBLIKASI DAN KOMUNIKASI' => 22,
            'SEKSI KEPEMUDAAN DAN OLAHRAGA' => 23, 'SEKSI PERENCANAAN LINGKUNGAN' => 24, 'SEKSI SENI DAN BUDAYA' => 25,
            'SEKSI KEROHANIAN' => 26, 'SEKSI KEAMANAN' => 27, 'SEKSI PERLENGKAPAN' => 28, 'SEKSI KEWANITAAN' => 29
        ];

        uksort($grouped, function($k1, $k2) use ($sortOrder) {
            $p1 = isset($sortOrder[$k1]) ? $sortOrder[$k1] : 999;
            $p2 = isset($sortOrder[$k2]) ? $sortOrder[$k2] : 999;
            return ($p1 == $p2) ? 0 : (($p1 < $p2) ? -1 : 1);
        });

        return $grouped;
    }

    public function add() {
        if ($this->input->method() == 'post') {
            $data = [
                'nama' => $this->input->post('nama'),
                'jabatan' => $this->input->post('jabatan'),
                'level' => $this->input->post('level'),
                'tipe_organisasi' => $this->input->post('tipe_organisasi'),
                'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                'kontak' => $this->_format_wa($this->input->post('kontak'))
            ];

            // Upload Foto
            if (!empty($_FILES['foto']['name'])) {
                $config['upload_path'] = FCPATH . 'assets/images/pengurus/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['file_name'] = 'pengurus_' . time();
                
                if (!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0777, true);

                $this->load->library('upload', $config);
                if ($this->upload->do_upload('foto')) {
                    $data['foto'] = $this->upload->data('file_name');
                }
            }

            $this->db->insert('struktur_organisasi', $data);
            $this->session->set_flashdata('success_msg', 'Pengurus berhasil ditambahkan.');
            redirect('admin/organisasi');
        }
    }

    public function edit() {
        if ($this->input->method() == 'post') {
            $id = $this->input->post('id');
            $data = [
                'nama' => $this->input->post('nama'),
                'jabatan' => $this->input->post('jabatan'),
                'level' => $this->input->post('level'),
                'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                'kontak' => $this->_format_wa($this->input->post('kontak'))
            ];

            if (!empty($_FILES['foto']['name'])) {
                $config['upload_path'] = FCPATH . 'assets/images/pengurus/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['file_name'] = 'pengurus_edit_' . time();
                
                if (!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0777, true);

                $this->load->library('upload', $config);
                if ($this->upload->do_upload('foto')) {
                    $data['foto'] = $this->upload->data('file_name');
                }
            }

            $this->db->where('id', $id)->update('struktur_organisasi', $data);
            $this->session->set_flashdata('success_msg', 'Data pengurus berhasil diperbarui.');
            redirect('admin/organisasi');
        }
    }

    public function delete($id) {
        $this->db->delete('struktur_organisasi', ['id' => $id]);
        $this->session->set_flashdata('success_msg', 'Pengurus dihapus.');
        redirect('admin/organisasi');
    }

    private function _format_wa($number) {
        if (empty($number)) return '';
        $number = preg_replace('/[^0-9]/', '', $number);
        if (substr($number, 0, 1) == '0') $number = '62' . substr($number, 1);
        return $number;
    }
}
