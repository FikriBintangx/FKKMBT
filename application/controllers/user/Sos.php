<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sos extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id') || $this->session->userdata('role') != 'warga') {
            redirect('auth/login');
        }
    }
    
    public function index() {
        $data['page_title'] = 'Tombol SOS';
        $this->load->view('user/sos', $data);
    }
    
    public function send() {
        // Logic untuk kirim SOS ke admin/RT
        $warga_id = $this->session->userdata('warga_id');
        $nama = $this->session->userdata('nama_lengkap');
        
        // TODO: Save to database & send notification
        
        $this->session->set_flashdata('success_msg', 'SOS berhasil dikirim! Admin akan segera menghubungi Anda.');
        redirect('user/sos');
    }
}
