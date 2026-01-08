<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kas extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id') || $this->session->userdata('role') != 'warga') {
            redirect('auth/login');
        }
        $this->load->model('Iuran_model');
    }
    
    public function index() {
        $data['page_title'] = 'Laporan Kas Warga';
        
        // Ambil data total pemasukan dari iuran yang sudah lunas
        $total_pemasukan = $this->db->select_sum('jumlah_bayar')
                                    ->where('status', 'Lunas')
                                    ->get('pembayaran_iuran')
                                    ->row()
                                    ->jumlah_bayar; // Menggunakan jumlah_bayar alias nominal yg dibayar
                                    
        // Karena belum ada tabel pengeluaran, kita set pengeluaran dummy atau 0
        // Untuk simulasi agar terlihat func, saya set 0 dulu
        $data['pemasukan'] = $total_pemasukan ? $total_pemasukan : 0;
        $data['pengeluaran'] = 0; 
        $data['saldo'] = $data['pemasukan'] - $data['pengeluaran'];

        // Ambil riwayat pemasukan terakhir (5 transaksi terakhir)
        $this->db->select('p.*, w.nama_lengkap, i.nama_iuran');
        $this->db->from('pembayaran_iuran p');
        $this->db->join('warga w', 'w.id_warga = p.id_warga');
        $this->db->join('iuran_master i', 'i.id_iuran = p.id_iuran');
        $this->db->where('p.status', 'Lunas');
        $this->db->order_by('p.tanggal_bayar', 'DESC');
        $this->db->limit(10);
        $data['transaksi'] = $this->db->get()->result_array();

        $this->load->view('user/kas', $data);
    }
}
