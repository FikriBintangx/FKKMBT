<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Panic extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id')) {
            echo json_encode(['status' => false, 'msg' => 'Unauthorized']);
            exit;
        }
        $this->load->model('Panic_model');
    }

    // API Endpoint for Triggering Panic
    public function trigger() {
        if ($this->input->method() == 'post') {
            $user_id = $this->session->userdata('user_id');
            $jenis = $this->input->post('jenis'); // KEBAKARAN, MALING, etc.
            $lat = $this->input->post('lat');
            $long = $this->input->post('long');
            
            $data = [
                'user_id' => $user_id,
                'jenis_darurat' => $jenis,
                'lokasi_lat' => $lat,
                'lokasi_long' => $long,
                'status' => 'OPEN'
            ];

            $alert_id = $this->Panic_model->create_alert($data);
            
            // In real world, send WA/Push Notif here
            
            echo json_encode(['status' => true, 'id' => $alert_id]);
        }
    }
    
    public function history() {
        $data['alerts'] = $this->db->order_by('created_at','DESC')->get_where('panic_log', ['user_id' => $this->session->userdata('user_id')])->result_array();
        // View not created yet, mainly for API or future usage
        echo json_encode($data);
    }
}
