<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Warga extends CI_Controller {
	public function index()
	{
		$data['title'] = 'Direktori Warga';
		// In a real app, you would fetch data from a model here
		// $data['warga'] = $this->Warga_model->get_all();
		
		$this->load->view('templates/header', $data);
		$this->load->view('warga');
		$this->load->view('templates/footer');
	}
}
