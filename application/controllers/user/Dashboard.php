<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Check if logged in and is user
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
    }

	public function index()
	{
		echo "<h1>WELCOME USER / WARGA DASHBOARD</h1>";
        echo "<p>Login Berhasil! (Ini Halaman CI3 Sementara)</p>";
        echo "<a href='".site_url('auth/logout')."'>Logout</a>";
	}
}
