<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keuangan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id') || $this->session->userdata('role') !== 'admin') {
            redirect('auth/login');
        }
    }

    public function index() {
        // 1. Pending Data
        $this->db->select('p.*, w.nama_lengkap, w.blok, w.no_rumah, m.nama_iuran, m.nominal');
        $this->db->from('pembayaran_iuran p');
        $this->db->join('warga w', 'p.warga_id = w.id');
        $this->db->join('iuran_master m', 'p.iuran_id = m.id');
        $this->db->where('p.status', 'pending');
        $this->db->order_by('p.tgl_bayar', 'DESC');
        $data['pending_data'] = $this->db->get()->result_array();

        // 2. History Data
        $this->db->select('p.*, w.nama_lengkap, w.blok, w.no_rumah, m.nama_iuran, m.nominal');
        $this->db->from('pembayaran_iuran p');
        $this->db->join('warga w', 'p.warga_id = w.id');
        $this->db->join('iuran_master m', 'p.iuran_id = m.id');
        $this->db->where('p.status !=', 'pending');
        $this->db->order_by('p.tgl_bayar', 'DESC');
        $this->db->limit(10);
        $data['history'] = $this->db->get()->result_array();

        // 3. Active Masters
        $this->db->order_by('jatuh_tempo', 'DESC');
        $data['masters'] = $this->db->get('iuran_master')->result_array();

        $this->load->view('admin/keuangan', $data);
    }

    public function verify() {
        if ($this->input->method() == 'post') {
            $id = $this->input->post('id');
            $status = $this->input->post('status');
            $catatan = $this->input->post('catatan');

            $this->db->where('id', $id);
            $this->db->update('pembayaran_iuran', [
                'status' => $status,
                'catatan_admin' => $catatan
            ]);

            $this->session->set_flashdata('success_msg', 'Status iuran berhasil diperbarui!');
            redirect('admin/keuangan');
        }
    }

    public function add_master() {
        if ($this->input->method() == 'post') {
            $data = [
                'nama_iuran' => $this->input->post('nama_iuran'),
                'nominal' => $this->input->post('nominal'),
                'jatuh_tempo' => $this->input->post('jatuh_tempo'),
                'status' => 'aktif' // Default active
            ];
            $this->db->insert('iuran_master', $data);

            $this->session->set_flashdata('success_msg', 'Master iuran baru berhasil ditambahkan!');
            redirect('admin/keuangan');
        }
    }
}
