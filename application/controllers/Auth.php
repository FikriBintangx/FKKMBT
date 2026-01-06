<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function login()
	{
		// TODO: Load login view
		echo "<h1>Halaman Login (Sedang Migrasi ke CI3...)</h1>";
		echo "<p><a href='".site_url()."'>Kembali ke Home</a></p>";
	}

	public function register()
	{
		// TODO: Load register view
		echo "<h1>Halaman Register (Sedang Migrasi ke CI3...)</h1>";
		echo "<p><a href='".site_url()."'>Kembali ke Home</a></p>";
	}
    
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('');
    }
}
