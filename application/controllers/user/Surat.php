<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Surat extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id')) redirect('auth/login');
        $this->load->model('Surat_model');
    }

    public function index() {
        $data['riwayat'] = $this->Surat_model->get_my_requests($this->session->userdata('user_id'));
        $this->load->view('user/surat/index', $data);
    }

    public function request() {
        if ($this->input->method() == 'post') {
            $data = [
                'user_id' => $this->session->userdata('user_id'),
                'jenis_surat' => $this->input->post('jenis_surat'),
                'keperluan' => $this->input->post('keperluan'),
                'status' => 'PENDING'
            ];
            $this->Surat_model->create_request($data);
            $this->session->set_flashdata('success_msg', 'Permohonan surat berhasil dikirim.');
            redirect('user/surat');
        }
    }
}
