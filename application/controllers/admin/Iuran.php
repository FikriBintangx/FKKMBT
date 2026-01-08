<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Iuran extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        // Check if admin is logged in
        if (!$this->session->userdata('user_id') || $this->session->userdata('role') != 'admin') {
            redirect('auth/login');
        }
        $this->load->model('Iuran_model');
    }
    
    // ========================================
    // HALAMAN UTAMA - List Iuran & Pembayaran
    // ========================================
    public function index() {
        $data['page_title'] = 'Kelola Iuran';
        $data['iuran_list'] = $this->Iuran_model->get_all_iuran();
        $data['pembayaran_pending'] = $this->Iuran_model->get_pembayaran_by_status('pending');
        $data['total_pemasukan'] = $this->Iuran_model->get_total_pemasukan_bulan_ini();
        $data['jumlah_pending'] = $this->Iuran_model->get_jumlah_pending();
        
        $this->load->view('admin/iuran', $data);
    }
    
    // ========================================
    // CRUD IURAN MASTER
    // ========================================
    public function create() {
        $data = [
            'nama_iuran' => $this->input->post('nama_iuran'),
            'keterangan' => $this->input->post('keterangan'),
            'nominal' => $this->input->post('nominal'),
            'jatuh_tempo' => $this->input->post('jatuh_tempo'),
            'status' => $this->input->post('status') ?? 'aktif'
        ];
        
        if ($this->Iuran_model->create_iuran($data)) {
            $this->session->set_flashdata('success_msg', 'Jenis iuran berhasil ditambahkan!');
        } else {
            $this->session->set_flashdata('error_msg', 'Gagal menambahkan iuran.');
        }
        
        redirect('admin/iuran');
    }
    
    public function update() {
        $id = $this->input->post('iuran_id');
        $data = [
            'nama_iuran' => $this->input->post('nama_iuran'),
            'keterangan' => $this->input->post('keterangan'),
            'nominal' => $this->input->post('nominal'),
            'jatuh_tempo' => $this->input->post('jatuh_tempo'),
            'status' => $this->input->post('status')
        ];
        
        if ($this->Iuran_model->update_iuran($id, $data)) {
            $this->session->set_flashdata('success_msg', 'Iuran berhasil diupdate!');
        } else {
            $this->session->set_flashdata('error_msg', 'Gagal mengupdate iuran.');
        }
        
        redirect('admin/iuran');
    }
    
    public function delete($id) {
        if ($this->Iuran_model->delete_iuran($id)) {
            $this->session->set_flashdata('success_msg', 'Iuran berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error_msg', 'Gagal menghapus iuran.');
        }
        
        redirect('admin/iuran');
    }
    
    // ========================================
    // VERIFIKASI PEMBAYARAN
    // ========================================
    public function verifikasi() {
        $data['page_title'] = 'Verifikasi Pembayaran';
        $data['pembayaran_list'] = $this->Iuran_model->get_all_pembayaran();
        
        $this->load->view('admin/iuran_verifikasi', $data);
    }
    
    public function approve($id) {
        if ($this->Iuran_model->update_status_pembayaran($id, 'disetujui')) {
            $this->session->set_flashdata('success_msg', 'Pembayaran berhasil disetujui!');
        } else {
            $this->session->set_flashdata('error_msg', 'Gagal menyetujui pembayaran.');
        }
        
        redirect('admin/iuran/verifikasi');
    }
    
    public function reject() {
        $id = $this->input->post('pembayaran_id');
        $catatan = $this->input->post('catatan_admin');
        
        if ($this->Iuran_model->update_status_pembayaran($id, 'ditolak', $catatan)) {
            $this->session->set_flashdata('success_msg', 'Pembayaran ditolak.');
        } else {
            $this->session->set_flashdata('error_msg', 'Gagal menolak pembayaran.');
        }
        
        redirect('admin/iuran/verifikasi');
    }
}
