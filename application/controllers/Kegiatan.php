<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kegiatan extends CI_Controller {
	public function index()
	{
		$data['title'] = 'Kegiatan Warga';
		$this->load->view('templates/header', $data);
		$this->load->view('kegiatan');
		$this->load->view('templates/footer');
	}
}
