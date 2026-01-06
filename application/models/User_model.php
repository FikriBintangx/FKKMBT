<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_user_by_username($username) {
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        return $query->row(); // Returns object or null
    }

    public function register_admin($data) {
        $this->db->trans_start();

        // 1. Insert into users
        $user_data = array(
            'username' => $data['username'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'role'     => 'admin'
        );
        $this->db->insert('users', $user_data);
        $user_id = $this->db->insert_id();

        // 2. Insert into admins
        $admin_data = array(
            'user_id'      => $user_id,
            'nama_lengkap' => $data['fullname'],
            'jabatan'      => $data['jabatan']
        );
        $this->db->insert('admins', $admin_data);

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function check_username_exists($username) {
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        return $query->num_rows() > 0;
    }
}
