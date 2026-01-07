<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
        $this->load->model('Dashboard_model');
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        $data['warga'] = $this->Dashboard_model->get_warga_by_user_id($user_id);
        $data['user'] = $this->db->get_where('users', ['id' => $user_id])->row_array();
        
        $this->load->view('user/profil', $data);
    }

    public function update() {
        $user_id = $this->session->userdata('user_id');
        $data_warga = [
            'nama_lengkap' => $this->input->post('nama_lengkap'),
            'no_hp' => $this->input->post('no_hp'),
            'blok' => $this->input->post('blok'),
            'no_rumah' => $this->input->post('no_rumah'),
            'alamat' => $this->input->post('alamat')
        ];
        
        $this->db->where('user_id', $user_id);
        $this->db->update('warga', $data_warga);
        
        $password = $this->input->post('password');
        if (!empty($password)) {
            $data_user = ['password' => password_hash($password, PASSWORD_DEFAULT)];
            $this->db->where('id', $user_id);
            $this->db->update('users', $data_user);
        }

        $this->session->set_flashdata('success_msg', 'Profil berhasil diperbarui!');
        redirect('user/profil');
    }
}
