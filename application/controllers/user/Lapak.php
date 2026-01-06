<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lapak extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
        $this->load->model('Lapak_model');
    }

    public function index() {
        $cat = $this->input->get('kategori');
        $search = $this->input->get('q');
        
        $data['produk'] = $this->Lapak_model->get_all(null, $cat, $search);
        $data['my_products_count'] = count($this->Lapak_model->get_by_user($this->session->userdata('user_id')));
        
        $this->load->view('user/lapak/index', $data);
    }

    public function saya() {
        $user_id = $this->session->userdata('user_id');
        $data['produk'] = $this->Lapak_model->get_by_user($user_id);
        $this->load->view('user/lapak/manage', $data);
    }

    public function add() {
        if ($this->input->method() == 'post') {
            $user_id = $this->session->userdata('user_id');
            // Fetch WA from warga table if empty (optional logic), but here we take input
            $wa = $this->_format_wa($this->input->post('kontak_wa'));

            $data = [
                'user_id' => $user_id,
                'nama_produk' => $this->input->post('nama_produk'),
                'deskripsi' => $this->input->post('deskripsi'),
                'harga' => str_replace('.', '', $this->input->post('harga')), // Remove dots from format
                'kategori' => $this->input->post('kategori'),
                'kontak_wa' => $wa
            ];

            if (!empty($_FILES['foto']['name'])) {
                $config['upload_path'] = FCPATH . 'assets/images/lapak/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['file_name'] = 'prod_' . time();
                if (!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0777, true);

                $this->load->library('upload', $config);
                if ($this->upload->do_upload('foto')) {
                    $data['foto'] = $this->upload->data('file_name');
                }
            }

            $this->Lapak_model->create($data);
            $this->session->set_flashdata('success_msg', 'Produk berhasil ditayangkan!');
            redirect('user/lapak/saya');
        }
    }

    public function delete($id) {
        $prod = $this->Lapak_model->get_detail($id);
        if ($prod && $prod['user_id'] == $this->session->userdata('user_id')) {
            // Delete file
            if ($prod['foto'] && file_exists(FCPATH . 'assets/images/lapak/' . $prod['foto'])) {
                unlink(FCPATH . 'assets/images/lapak/' . $prod['foto']);
            }
            $this->Lapak_model->delete($id);
            $this->session->set_flashdata('success_msg', 'Produk dihapus.');
        }
        redirect('user/lapak/saya');
    }

    private function _format_wa($number) {
        $number = preg_replace('/[^0-9]/', '', $number);
        if (substr($number, 0, 1) == '0') $number = '62' . substr($number, 1);
        return $number;
    }
}
