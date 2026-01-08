<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Surat extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id') || $this->session->userdata('role') !== 'admin') {
            redirect('auth/login');
        }
        $this->load->model('Surat_model');
    }

    public function index() {
        $data['requests'] = $this->Surat_model->get_all_requests();
        $this->load->view('admin/surat', $data);
    }

    public function approve($id) {
        // In real world, generate PDF here
        $this->Surat_model->update_status($id, 'Selesai', 'Surat disetujui oleh Admin.');
        $this->session->set_flashdata('success_msg', 'Permohonan disetujui.');
        redirect('admin/surat');
    }

    public function reject($id) {
        $this->Surat_model->update_status($id, 'Ditolak', 'Permohonan ditolak.');
        $this->session->set_flashdata('success_msg', 'Permohonan ditolak.');
        redirect('admin/surat');
    }
}
