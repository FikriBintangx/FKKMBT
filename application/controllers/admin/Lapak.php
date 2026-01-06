<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lapak extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id') || $this->session->userdata('role') !== 'admin') {
            redirect('auth/login');
        }
        $this->load->model('Lapak_model');
    }

    public function index() {
        $data['produk'] = $this->Lapak_model->get_all();
        $this->load->view('admin/lapak', $data);
    }

    public function delete($id) {
        $prod = $this->Lapak_model->get_detail($id);
        if ($prod && $prod['foto'] && file_exists(FCPATH . 'assets/images/lapak/' . $prod['foto'])) {
            unlink(FCPATH . 'assets/images/lapak/' . $prod['foto']);
        }
        $this->Lapak_model->delete($id);
        $this->session->set_flashdata('success_msg', 'Produk dihapus.');
        redirect('admin/lapak');
    }
}
