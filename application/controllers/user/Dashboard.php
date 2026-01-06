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
            // Handle edge case: User login but no Warga data linked
            // For now, just pass empty or redirect to profile fill
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
}
