<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forum extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id') || $this->session->userdata('role') != 'warga') {
            redirect('auth/login');
        }
        $this->load->model('Forum_model');
    }
    
    public function index() {
        $data['page_title'] = 'Forum Warga';
        $data['forums'] = $this->Forum_model->get_all_forum();
        $this->load->view('user/forum', $data);
    }

    public function submit() {
        $konten = $this->input->post('konten');
        if (!empty($konten)) {
            $data = [
                'warga_id' => $this->session->userdata('warga_id'), // Pastikan session warga_id ada
                'konten' => $konten,
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->Forum_model->create_forum($data);
            $this->session->set_flashdata('success', 'Postingan berhasil dikirim!');
        } else {
            $this->session->set_flashdata('error', 'Konten tidak boleh kosong.');
        }
        redirect('user/forum');
    }

    public function delete($id) {
        $warga_id = $this->session->userdata('warga_id');
        if ($this->Forum_model->delete_forum($id, $warga_id)) {
            $this->session->set_flashdata('success', 'Postingan berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus postingan (Mungkin bukan milik Anda).');
        }
        redirect('user/forum');
    }
}
