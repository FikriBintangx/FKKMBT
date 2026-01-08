<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifikasi extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        // Cek login
        if (!$this->session->userdata('user_id') || $this->session->userdata('role') != 'warga') {
            redirect('auth/login');
        }
    }
    
    public function index() {
        $data['page_title'] = 'Notifikasi';
        
        // Data Dummy Notifikasi (Nanti bisa diganti dengan database)
        $data['notifikasi'] = [
            [
                'judul' => 'Pembayaran Iuran Diterima',
                'pesan' => 'Pembayaran Iuran Keamanan Bulan Januari Anda telah diverifikasi oleh admin.',
                'tipe' => 'success',
                'waktu' => '2 jam yang lalu'
            ],
            [
                'judul' => 'Jadwal Kerja Bakti',
                'pesan' => 'Diingatkan kepada seluruh warga untuk mengikuti kerja bakti besok pagi pukul 07.00 WIB.',
                'tipe' => 'info',
                'waktu' => '1 hari yang lalu'
            ],
            [
                'judul' => 'Tagihan Iuran Sampah',
                'pesan' => 'Tagihan Iuran Sampah bulan Februari telah terbit. Silakan lakukan pembayaran sebelum tanggal 10.',
                'tipe' => 'warning',
                'waktu' => '3 hari yang lalu'
            ]
        ];

        $this->load->view('user/notifikasi', $data);
    }
}
