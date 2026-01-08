<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Surat extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id') || $this->session->userdata('role') != 'warga') {
            redirect('auth/login');
        }
    }
    
    public function index() {
        $data['page_title'] = 'E-Surat Digital';
        $this->load->view('user/surat', $data);
    }
}
