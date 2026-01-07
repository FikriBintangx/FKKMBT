<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Check if logged in and is user
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
        $this->load->model('Dashboard_model');
    }

	public function index()
	{
        $user_id = $this->session->userdata('user_id');
        
        // 1. Warga Data
        $warga = $this->Dashboard_model->get_warga_by_user_id($user_id);
        if (!$warga) {
            $data['warga'] = []; 
            $data['unpaid'] = 0;
        } else {
            $data['warga'] = $warga;
            $data['unpaid'] = $this->Dashboard_model->get_unpaid_bills_count($warga['id']);
        }

        // 2. Stats
        $data['status_iuran'] = ($data['unpaid'] > 0) ? 'Belum Lunas' : 'LUNAS';
        $data['status_class'] = ($data['unpaid'] > 0) ? 'text-danger' : 'text-success';
        $data['icon_class'] = ($data['unpaid'] > 0) ? 'bi-exclamation-circle-fill text-danger' : 'bi-check-circle-fill text-success';
        $data['status_desc'] = ($data['unpaid'] > 0) ? 'Ada '.$data['unpaid'].' tagihan tertunggak' : 'Terima kasih atas partisipasi Anda';

        $data['kegiatan_count'] = $this->Dashboard_model->get_monthly_agenda_count();
        $data['total_kas'] = $this->Dashboard_model->get_total_kas_warga();

        // 3. News & Agenda
        $data['news'] = $this->Dashboard_model->get_latest_news();
        $data['agenda'] = $this->Dashboard_model->get_upcoming_agenda();

		$this->load->view('user/dashboard', $data);
	}

    public function notifikasi() {
        $user_id = $this->session->userdata('user_id');
        $data['warga'] = $this->Dashboard_model->get_warga_by_user_id($user_id);
        $data['page_title'] = 'Notifikasi';
        
        $data['notifications'] = [
            ['title' => 'Tagihan Baru', 'desc' => 'Iuran Keamanan bulan Januari telah terbit.', 'time' => '1 jam yang lalu', 'icon' => 'bi-wallet2', 'bg' => 'bg-primary'],
            ['title' => 'Kegiatan Warga', 'desc' => 'Kerja bakti akan dilaksanakan hari Minggu besok.', 'time' => '3 jam yang lalu', 'icon' => 'bi-people', 'bg' => 'bg-success'],
            ['title' => 'Surat Selesai', 'desc' => 'Permohonan surat pengantar domisili Anda telah disetujui.', 'time' => '1 hari yang lalu', 'icon' => 'bi-file-earmark-check', 'bg' => 'bg-info']
        ];

        $this->load->view('user/notifikasi', $data);
    }
}
