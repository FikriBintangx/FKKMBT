<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Check if logged in and is admin
        if (!$this->session->userdata('user_id') || $this->session->userdata('role') !== 'admin') {
            redirect('auth/login');
        }
        $this->load->model('Dashboard_model');
    }

	public function index()
	{
        // 1. Stats
        $data['count_pending'] = $this->Dashboard_model->get_pending_payments_count();
        $data['count_agenda'] = $this->Dashboard_model->get_active_agenda_count();
        
        // 2. Chart Data
        $chart_data = $this->Dashboard_model->get_revenue_chart_data();
        $data['chart_labels'] = [];
        $data['chart_values'] = [];
        foreach ($chart_data as $c) {
            array_unshift($data['chart_labels'], substr($c['bulan'], 0, 3));
            array_unshift($data['chart_values'], $c['total']);
        }

        // 3. Lists
        $data['pengurus'] = $this->Dashboard_model->get_core_administrators();
        $data['pending_list'] = $this->Dashboard_model->get_pending_payments_list();
        $data['history'] = $this->Dashboard_model->get_recent_history();

		$this->load->view('admin/dashboard', $data);
	}
}
