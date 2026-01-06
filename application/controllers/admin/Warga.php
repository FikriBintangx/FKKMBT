<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Warga extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Check Admin Login
        if (!$this->session->userdata('user_id') || $this->session->userdata('role') !== 'admin') {
            redirect('auth/login');
        }
        $this->load->model('User_model');
    }

    public function index() {
        // Fetch all warga with username/password info
        // Note: Joining with users table to get login info
        $this->db->select('w.*, u.username, u.password as raw_password, u.id as user_id');
        $this->db->from('warga w');
        $this->db->join('users u', 'w.user_id = u.id');
        $this->db->order_by('w.blok', 'ASC');
        $this->db->order_by('w.no_rumah', 'ASC');
        $data['warga_list'] = $this->db->get()->result_array();
        
        $this->load->view('admin/warga', $data);
    }

    public function create() {
        if ($this->input->method() == 'post') {
            $nama = $this->input->post('nama_lengkap');
            $blok = $this->input->post('blok');
            $no_rumah = $this->input->post('no_rumah');
            $no_hp = $this->input->post('no_hp');
            $jenis_kelamin = $this->input->post('jenis_kelamin');
            
            // Username Logic
            $manual_username = trim($this->input->post('username'));
            if (!empty($manual_username)) {
                // Check duplicate
                if ($this->User_model->check_username_exists($manual_username)) {
                    $this->session->set_flashdata('error_msg', "Username '$manual_username' sudah dipakai!");
                    redirect('admin/warga');
                }
                $username = $manual_username;
            } else {
                // Auto generate
                $username = strtolower(str_replace(' ', '', $nama));
                // Add number if exists
                if ($this->User_model->check_username_exists($username)) {
                    $username .= rand(10, 99);
                }
            }

            // Password Logic
            $password = $this->input->post('password');
            if (empty($password)) {
                $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                $password = substr(str_shuffle($chars), 0, 8);
            }
            
            // IMPORTANT: User wanted Plain Text visible admin side as per legacy code
            // But good practice is hash. Integrating legacy logic:
            // "hashed" variable in legacy was actually plaintext if requested.
            // We will store HASH in DB for security in CI3, BUT legacy showed 'raw_password'.
            // To support Legacy "Show Password" requirement without fully compromising security:
            // The legacy code actually stored plaintext if commented out.
            // Let's stick to Hash for real login, but if the user REALLY wants to see it, 
            // we can't reverse hash. 
            // CHECKING LEGACY CODE AGAIN: `$hashed = $password;` (line 75 of kelola_warga.php)
            // It seems they stored it PLAIN TEXT.
            // OK, I will follow the legacy code's potentially insecure method because required.
            // But I'll use password_hash for the actual login auth in Auth.php which uses password_verify.
            // Wait, proper Auth.php uses password_verify. If I store plain, `password_verify` might fail 
            // unless Auth.php handles both.
            // Auth.php line 42: `if (password_verify($password, $user->password))`
            // Auth.php line 44: `elseif ($password === $user->password)` (Plaintext fallback)
            // So it supports both! I will store PLAIN TEXT as per Legacy request so Admin can see it.
            
            $final_password = $password; 

            // 1. Insert User
            $user_data = [
                'username' => $username,
                'password' => $final_password,
                'role' => 'warga'
            ];
            $this->db->insert('users', $user_data);
            $user_id = $this->db->insert_id();

            // 2. Insert Warga
            $warga_data = [
                'user_id' => $user_id,
                'nama_lengkap' => $nama,
                'blok' => $blok,
                'no_rumah' => $no_rumah,
                'no_hp' => $no_hp,
                'jenis_kelamin' => $jenis_kelamin
            ];
            $this->db->insert('warga', $warga_data);

            $this->session->set_flashdata('success_msg', "Warga berhasil ditambahkan!");
            $this->session->set_flashdata('generated_password', "Username: <strong>$username</strong> | Password: <strong>$password</strong>");
            redirect('admin/warga');
        }
    }

    public function update() {
        if ($this->input->method() == 'post') {
            $warga_id = $this->input->post('warga_id');
            $nama = $this->input->post('nama_lengkap');
            $blok = $this->input->post('blok');
            $no_rumah = $this->input->post('no_rumah');
            $no_hp = $this->input->post('no_hp');
            $jenis_kelamin = $this->input->post('jenis_kelamin');

            // Update Warga
            $this->db->where('id', $warga_id);
            $this->db->update('warga', [
                'nama_lengkap' => $nama,
                'blok' => $blok,
                'no_rumah' => $no_rumah,
                'no_hp' => $no_hp,
                'jenis_kelamin' => $jenis_kelamin
            ]);

            // Update User Login Info if provided
            $warga = $this->db->get_where('warga', ['id' => $warga_id])->row();
            if ($warga) {
                $user_updates = [];
                
                $username = trim($this->input->post('username'));
                if (!empty($username)) {
                    // Check duplicate excluding self
                    $chk = $this->db->where('username', $username)
                                    ->where('id !=', $warga->user_id)
                                    ->get('users');
                    if ($chk->num_rows() == 0) {
                        $user_updates['username'] = $username;
                    }
                }

                $password = $this->input->post('password');
                if (!empty($password)) {
                    $user_updates['password'] = $password; // Plaintext as per legacy
                }

                if (!empty($user_updates)) {
                    $this->db->where('id', $warga->user_id);
                    $this->db->update('users', $user_updates);
                }
            }

            $this->session->set_flashdata('success_msg', "Data warga berhasil diupdate!");
            redirect('admin/warga');
        }
    }

    public function delete() {
        if ($this->input->method() == 'post') {
            $warga_id = $this->input->post('warga_id');
            $warga = $this->db->get_where('warga', ['id' => $warga_id])->row();
            
            if ($warga) {
                $this->db->delete('warga', ['id' => $warga_id]);
                $this->db->delete('users', ['id' => $warga->user_id]);
                $this->session->set_flashdata('success_msg', "Warga berhasil dihapus!");
            }
            redirect('admin/warga');
        }
    }
}
