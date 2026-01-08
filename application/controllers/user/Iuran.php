<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Iuran extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        // Check if user is logged in as warga
        if (!$this->session->userdata('user_id') || $this->session->userdata('role') != 'warga') {
            redirect('auth/login');
        }
        $this->load->model('Iuran_model');
        $this->load->model('Warga_model');
    }
    
    // ========================================
    // HALAMAN UTAMA - List Iuran & Riwayat
    // ========================================
    public function index() {
        $warga_id = $this->session->userdata('warga_id');
        
        $data['page_title'] = 'Iuran Saya';
        $data['iuran_aktif'] = $this->Iuran_model->get_iuran_aktif();
        $data['riwayat_bayar'] = $this->Iuran_model->get_pembayaran_by_warga($warga_id);
        
        $this->load->view('user/iuran', $data);
    }
    
    // ========================================
    // UPLOAD BUKTI BAYAR
    // ========================================
    public function upload() {
        $warga_id = $this->session->userdata('warga_id');
        $iuran_id = $this->input->post('iuran_id');
        
        // Check if already paid this month
        if ($this->Iuran_model->check_sudah_bayar($warga_id, $iuran_id, date('m'), date('Y'))) {
            $this->session->set_flashdata('error_msg', 'Anda sudah melakukan pembayaran untuk iuran ini bulan ini!');
            redirect('user/iuran');
            return;
        }
        
        // Upload file
        $config['upload_path'] = './assets/uploads/bukti_transfer/';
        $config['allowed_types'] = 'jpg|jpeg|png|pdf';
        $config['max_size'] = 2048; // 2MB
        $config['file_name'] = 'bukti_' . $warga_id . '_' . time();
        
        // Create directory if not exists
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0755, true);
        }
        
        $this->load->library('upload', $config);
        
        if (!$this->upload->do_upload('bukti_transfer')) {
            $this->session->set_flashdata('error_msg', 'Gagal upload: ' . $this->upload->display_errors());
            redirect('user/iuran');
            return;
        }
        
        $upload_data = $this->upload->data();
        
        // Save to database
        $data = [
            'warga_id' => $warga_id,
            'iuran_id' => $iuran_id,
            'bukti_transfer' => $upload_data['file_name'],
            'status' => 'pending'
        ];
        
        if ($this->Iuran_model->create_pembayaran($data)) {
            $this->session->set_flashdata('success_msg', 'Bukti pembayaran berhasil diupload! Menunggu verifikasi admin.');
        } else {
            $this->session->set_flashdata('error_msg', 'Gagal menyimpan data pembayaran.');
        }
        
        redirect('user/iuran');
    }
}
