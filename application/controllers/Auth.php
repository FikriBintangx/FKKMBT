<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('form_validation');
    }

    public function login() {
        // Redirect if already logged in
        if ($this->session->userdata('user_id')) {
            $role = $this->session->userdata('role');
            if ($role == 'admin') {
                redirect('admin/dashboard');
            } else {
                redirect('user/dashboard');
            }
        }

        $data['error_msg'] = $this->session->flashdata('error_msg');
        $data['success_msg'] = $this->session->flashdata('success_msg');

        if ($this->input->method() == 'post') {
            $this->_process_login();
        } else {
            $this->load->view('auth/login', $data);
        }
    }

    private function _process_login() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->User_model->get_user_by_username($username);

        if ($user) {
            // Check password (Hash then Plaintext fallback)
            $auth_success = false;
            if (password_verify($password, $user->password)) {
                $auth_success = true;
            } elseif ($password === $user->password) {
                // Plaintext fallback
                $auth_success = true;
            }

            if ($auth_success) {
                // Set Session
                $session_data = array(
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'role' => $user->role
                );
                $this->session->set_userdata($session_data);

                // Redirect
                if ($user->role == 'admin') {
                    redirect('admin/dashboard');
                } else {
                    redirect('user/dashboard');
                }
            } else {
                $this->session->set_flashdata('error_msg', 'Password salah!');
                redirect('auth/login');
            }
        } else {
            $this->session->set_flashdata('error_msg', 'Username tidak ditemukan!');
            redirect('auth/login');
        }
    }

    public function register_admin() {
        if ($this->input->method() == 'post') {
            $pin = $this->input->post('admin_pin');
            
            if ($pin !== 'FKKMBT_Secure_2025') {
                $this->session->set_flashdata('error_msg', 'PIN Admin Salah! Pendaftaran ditolak.');
                redirect('auth/login');
            }

            $username = $this->input->post('username');
            
            if ($this->User_model->check_username_exists($username)) {
                $this->session->set_flashdata('error_msg', 'Username sudah terdaftar!');
                redirect('auth/login');
            }

            $data = array(
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'fullname' => $this->input->post('fullname'),
                'jabatan'  => $this->input->post('jabatan')
            );

            if ($this->User_model->register_admin($data)) {
                $this->session->set_flashdata('success_msg', 'Admin berhasil didaftarkan! Silakan login.');
                redirect('auth/login');
            } else {
                $this->session->set_flashdata('error_msg', 'Gagal mendaftarkan admin. Silakan coba lagi.');
                redirect('auth/login');
            }
        } else {
            redirect('auth/login');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}
