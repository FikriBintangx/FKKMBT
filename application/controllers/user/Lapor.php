<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lapor extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
        $this->load->model('Pengaduan_model');
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        $data['riwayat'] = $this->Pengaduan_model->get_by_user($user_id);
        $this->load->view('user/lapor', $data);
    }

    public function submit() {
        if ($this->input->method() == 'post') {
            $user_id = $this->session->userdata('user_id');
            $judul = $this->input->post('judul');
            $isi = $this->input->post('isi');
            
            $foto = null;
            if (!empty($_FILES['foto']['name'])) {
                $config['upload_path'] = FCPATH . 'assets/images/pengaduan/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['file_name'] = 'lapor_' . time();
                
                if (!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0777, true);

                $this->load->library('upload', $config);
                if ($this->upload->do_upload('foto')) {
                    $foto = $this->upload->data('file_name');
                } else {
                    $this->session->set_flashdata('error_msg', $this->upload->display_errors());
                    redirect('user/lapor');
                    return;
                }
            }

            $data = [
                'user_id' => $user_id,
                'judul' => $judul,
                'isi' => $isi,
                'foto' => $foto,
                'status' => 'pending'
            ];

            if ($this->Pengaduan_model->create($data)) {
                $this->session->set_flashdata('success_msg', 'Laporan berhasil dikirim! Petugas akan segera meninjau.');
            } else {
                $this->session->set_flashdata('error_msg', 'Gagal mengirim laporan.');
            }
            redirect('user/lapor');
        }
    }
}
