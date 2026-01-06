<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Voting extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id')) redirect('auth/login');
        $this->load->model('Voting_model');
    }

    public function index() {
        $data['voting'] = $this->Voting_model->get_active_voting();
        if ($data['voting']) {
            $data['kandidat'] = $this->Voting_model->get_kandidat($data['voting']['id']);
            $data['has_voted'] = $this->Voting_model->check_has_voted($data['voting']['id'], $this->session->userdata('user_id'));
            $data['results'] = $this->Voting_model->get_results($data['voting']['id']);
        }
        $this->load->view('user/voting', $data);
    }

    public function vote($kandidat_id) {
        $voting = $this->Voting_model->get_active_voting();
        if (!$voting) {
            $this->session->set_flashdata('error_msg', 'Tidak ada pemilihan aktif.');
            redirect('user/voting');
        }

        $has_voted = $this->Voting_model->check_has_voted($voting['id'], $this->session->userdata('user_id'));
        if ($has_voted) {
            $this->session->set_flashdata('error_msg', 'Anda sudah memberikan suara.');
        } else {
            $this->Voting_model->cast_vote($voting['id'], $kandidat_id, $this->session->userdata('user_id'));
            $this->session->set_flashdata('success_msg', 'Suara berhasil dicatat!');
        }
        redirect('user/voting');
    }
}
