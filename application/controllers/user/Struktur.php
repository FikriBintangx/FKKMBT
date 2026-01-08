<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Struktur extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id')) redirect('auth/login');
        $this->load->model('Struktur_model');
    }
    
    public function fkkmbt() {
        $data['page_title'] = 'Struktur FKKMBT';
        $data['title'] = 'FKKMBT';
        $data['pengurus'] = $this->Struktur_model->get_struktur('FKKMBT');
        $this->load->view('user/struktur', $data);
    }

    public function fkkmmbt() {
        $data['page_title'] = 'Struktur FKKMMBT';
        $data['title'] = 'FKKMMBT';
        $data['pengurus'] = $this->Struktur_model->get_struktur('FKKMMBT');
        $this->load->view('user/struktur', $data);
    }
}
