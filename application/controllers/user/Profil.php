<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        // Check if user is logged in as warga
        if (!$this->session->userdata('user_id') || $this->session->userdata('role') != 'warga') {
            redirect('auth/login');
        }
        $this->load->model('User_model');
        $this->load->model('Warga_model');
    }
    
    // ========================================
    // HALAMAN PROFIL
    // ========================================
    public function index() {
        $user_id = $this->session->userdata('user_id');
        $warga_id = $this->session->userdata('warga_id');
        
        $data['page_title'] = 'Profil Saya';
        $data['user'] = $this->User_model->get_user_by_username($this->session->userdata('username'));
        $data['warga'] = $this->Warga_model->get_warga_by_id($warga_id);
        
        $this->load->view('user/profil', $data);
    }
    
    // ========================================
    // UBAH PASSWORD
    // ========================================
    public function change_password() {
        if ($this->input->method() == 'post') {
            $user_id = $this->session->userdata('user_id');
            $old_password = $this->input->post('old_password');
            $new_password = $this->input->post('new_password');
            $confirm_password = $this->input->post('confirm_password');
            
            // Get current user
            $user = $this->User_model->get_user_by_username($this->session->userdata('username'));
            
            // Verify old password
            $old_password_valid = false;
            if (password_verify($old_password, $user->password)) {
                $old_password_valid = true;
            } elseif ($old_password === $user->password) {
                // Plaintext fallback
                $old_password_valid = true;
            }
            
            if (!$old_password_valid) {
                $this->session->set_flashdata('error_msg', 'Password lama salah!');
                redirect('user/profil');
                return;
            }
            
            // Validate new password
            if ($new_password !== $confirm_password) {
                $this->session->set_flashdata('error_msg', 'Password baru dan konfirmasi tidak cocok!');
                redirect('user/profil');
                return;
            }
            
            if (strlen($new_password) < 6) {
                $this->session->set_flashdata('error_msg', 'Password minimal 6 karakter!');
                redirect('user/profil');
                return;
            }
            
            // Update password
            if ($this->User_model->update_password($user_id, $new_password)) {
                $this->session->set_flashdata('success_msg', 'Password berhasil diubah!');
            } else {
                $this->session->set_flashdata('error_msg', 'Gagal mengubah password.');
            }
            
            redirect('user/profil');
        }
    }
}
