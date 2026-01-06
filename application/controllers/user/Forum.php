<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forum extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id')) redirect('auth/login');
        $this->load->model('Forum_model');
    }

    public function index() {
        $kategori = $this->input->get('kategori');
        $data['threads'] = $this->Forum_model->get_threads($kategori);
        $this->load->view('user/forum/index', $data);
    }

    public function thread($id) {
        $this->Forum_model->increment_view($id);
        $data['thread'] = $this->Forum_model->get_thread($id);
        $data['replies'] = $this->Forum_model->get_replies($id);
        $this->load->view('user/forum/thread', $data);
    }

    public function create() {
        if ($this->input->method() == 'post') {
            $data = [
                'user_id' => $this->session->userdata('user_id'),
                'kategori' => $this->input->post('kategori'),
                'judul' => $this->input->post('judul'),
                'isi' => $this->input->post('isi')
            ];
            $this->Forum_model->create_thread($data);
            $this->session->set_flashdata('success_msg', 'Thread berhasil dibuat.');
            redirect('user/forum');
        }
    }

    public function reply($thread_id) {
        if ($this->input->method() == 'post') {
            $data = [
                'thread_id' => $thread_id,
                'user_id' => $this->session->userdata('user_id'),
                'isi' => $this->input->post('isi')
            ];
            $this->Forum_model->create_reply($data);
            $this->session->set_flashdata('success_msg', 'Balasan ditambahkan.');
            redirect('user/forum/thread/'.$thread_id);
        }
    }
}
