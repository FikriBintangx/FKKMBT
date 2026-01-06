<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tentang extends CI_Controller {
	public function index()
	{
		$data['title'] = 'Tentang Kami';
		$this->load->view('templates/header', $data);
		$this->load->view('tentang');
		$this->load->view('templates/footer');
	}
}
