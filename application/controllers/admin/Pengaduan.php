<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaduan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id') || $this->session->userdata('role') !== 'admin') {
            redirect('auth/login');
        }
        $this->load->model('Pengaduan_model');
    }

    public function index() {
        $status = $this->input->get('status');
        $data['laporan'] = $this->Pengaduan_model->get_all($status);
        $this->load->view('admin/pengaduan', $data);
    }

    public function update_status() {
        if ($this->input->method() == 'post') {
            $id = $this->input->post('id');
            $status = $this->input->post('status');
            $tanggapan = $this->input->post('tanggapan');

            if ($this->Pengaduan_model->update_status($id, $status, $tanggapan)) {
                $this->session->set_flashdata('success_msg', 'Status laporan berhasil diperbarui.');
            } else {
                $this->session->set_flashdata('error_msg', 'Gagal memperbarui status.');
            }
            redirect('admin/pengaduan');
        }
    }
}
