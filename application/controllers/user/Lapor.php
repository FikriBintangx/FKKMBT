<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lapor extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id') || $this->session->userdata('role') != 'warga') {
            redirect('auth/login');
        }
        $this->load->model('Lapor_model');
    }
    
    public function index() {
        $data['page_title'] = 'Layanan Pengaduan';
        $warga_id = $this->session->userdata('warga_id');
        $data['riwayat'] = $this->Lapor_model->get_riwayat_laporan($warga_id);
        $this->load->view('user/lapor', $data);
    }

    public function submit() {
        $config['upload_path'] = './assets/uploads/laporan/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = 5120; // 5MB
        $config['encrypt_name'] = TRUE;

        // Buat folder jika belum ada
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, TRUE);
        }

        $this->load->library('upload', $config);

        $foto = null;
        if (!empty($_FILES['foto']['name'])) {
            if ($this->upload->do_upload('foto')) {
                $foto = $this->upload->data('file_name');
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('user/lapor');
                return; 
            }
        }

        $data = [
            'warga_id' => $this->session->userdata('warga_id'),
            'judul' => $this->input->post('judul'),
            'kategori' => $this->input->post('kategori'),
            'deskripsi' => $this->input->post('deskripsi'),
            'foto' => $foto,
            'status' => 'Pending',
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->Lapor_model->create_laporan($data)) {
            $this->session->set_flashdata('success', 'Laporan berhasil dikirim!');
        } else {
            $this->session->set_flashdata('error', 'Gagal mengirim laporan.');
        }
        redirect('user/lapor');
    }
}
