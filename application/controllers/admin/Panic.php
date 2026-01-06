<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Panic extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id') || $this->session->userdata('role') !== 'admin') {
            redirect('auth/login');
        }
        $this->load->model('Panic_model');
    }

    public function index() {
        $data['alerts'] = $this->Panic_model->get_active_alerts();
        $this->load->view('admin/panic', $data);
    }

    public function handle($id) {
        $this->Panic_model->mark_handled($id);
        $this->session->set_flashdata('success_msg', 'Alert ditandai selesai.');
        redirect('admin/panic');
    }
}
