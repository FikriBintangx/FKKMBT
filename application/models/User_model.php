<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {



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

    public function get_user_by_email($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        return $query->row(); // Returns object or null
    }

    public function get_warga_by_user_id($user_id) {
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('warga');
        return $query->row_array();
    }

    public function check_email_exists($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        return $query->num_rows() > 0;
    }

    public function update_password($user_id, $new_password) {
        $data = [
            'password' => password_hash($new_password, PASSWORD_DEFAULT)
        ];
        $this->db->where('id', $user_id);
        return $this->db->update('users', $data);
    }

    // Helper function to generate email from name
    public static function generate_email_from_name($nama) {
        // Convert to lowercase
        $email = strtolower($nama);
        // Replace spaces with dots
        $email = str_replace(' ', '.', $email);
        // Remove special characters
        $email = preg_replace('/[^a-z0-9.]/', '', $email);
        // Add domain
        $email = $email . '@fkkmbt.or.id';
        return $email;
    }
}
