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
        
        // 1. Hitung Total Pemasukan (Status: disetujui)
        // Karena nominal ada di tabel iuran_master, kita harus JOIN
        $this->db->select_sum('i.nominal');
        $this->db->from('pembayaran_iuran p');
        $this->db->join('iuran_master i', 'i.id = p.iuran_id');
        $this->db->where('p.status', 'disetujui');
        
        $query = $this->db->get();
        $total_pemasukan = $query->row()->nominal;
                                    
        // Karena belum ada tabel pengeluaran, kita set pengeluaran dummy atau 0
        $data['pemasukan'] = $total_pemasukan ? $total_pemasukan : 0;
        $data['pengeluaran'] = 0; 
        $data['saldo'] = $data['pemasukan'] - $data['pengeluaran'];

        // 2. Ambil Riwayat Transaksi
        $this->db->select('p.*, w.nama_lengkap, i.nama_iuran, i.nominal'); // Select i.nominal
        $this->db->from('pembayaran_iuran p');
        $this->db->join('warga w', 'w.id = p.warga_id'); // Note: cek id_warga vs warga_id di tabel warga
        $this->db->join('iuran_master i', 'i.id = p.iuran_id');
        $this->db->where('p.status', 'disetujui');
        $this->db->order_by('p.tgl_bayar', 'DESC'); // tgl_bayar bukan tanggal_bayar
        $this->db->limit(10);
        $data['transaksi'] = $this->db->get()->result_array();

        $this->load->view('user/kas', $data);
    }
}
