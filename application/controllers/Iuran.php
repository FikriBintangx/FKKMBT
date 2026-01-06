<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Iuran extends CI_Controller {
	public function index()
	{
		$data['title'] = 'Info Iuran';
		$this->load->view('templates/header', $data);
		$this->load->view('iuran');
		$this->load->view('templates/footer');
	}
}
