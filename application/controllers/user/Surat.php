<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Surat extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id') || $this->session->userdata('role') != 'warga') {
            redirect('auth/login');
        }
        $this->load->model('Surat_model');
    }
    
    public function index() {
        $data['page_title'] = 'Layanan Surat Digital';
        $warga_id = $this->session->userdata('warga_id');
        $data['riwayat'] = $this->Surat_model->get_riwayat_surat($warga_id);
        $this->load->view('user/surat', $data);
    }

    public function submit() {
        $jenis_surat = $this->input->post('jenis_surat');
        $keperluan = $this->input->post('keperluan');

        if (!empty($jenis_surat) && !empty($keperluan)) {
            $data = [
                'warga_id' => $this->session->userdata('warga_id'),
                'jenis_surat' => $jenis_surat,
                'keperluan' => $keperluan,
                'status' => 'Pending',
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            if ($this->Surat_model->create_surat($data)) {
                $this->session->set_flashdata('success', 'Permohonan surat berhasil diajukan!');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengajukan surat.');
            }
        } else {
            $this->session->set_flashdata('error', 'Mohon lengkapi formulir.');
        }
        redirect('user/surat');
    }
}
