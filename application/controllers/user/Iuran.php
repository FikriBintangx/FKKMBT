<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Iuran extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
        $this->load->model('Dashboard_model');
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        $warga = $this->Dashboard_model->get_warga_by_user_id($user_id);
        
        if (!$warga) {
            $this->session->set_flashdata('error_msg', 'Data warga tidak ditemukan.');
            redirect('user/dashboard');
        }

        // Get unpaid bills
        $data['warga'] = $warga;
        $data['tagihan'] = $this->get_unpaid_bills($warga['id']);
        $data['riwayat'] = $this->get_payment_history($warga['id']);
        
        $this->load->view('user/iuran', $data);
    }

    private function get_unpaid_bills($warga_id) {
        $paid_ids_query = $this->db->select('iuran_id')
                                   ->where('warga_id', $warga_id)
                                   ->where_in('status', ['pending', 'disetujui'])
                                   ->get('pembayaran_iuran')
                                   ->result_array();
        
        $paid_ids = array_column($paid_ids_query, 'iuran_id');
        
        $this->db->where('status', 'aktif');
        if (!empty($paid_ids)) {
            $this->db->where_not_in('id', $paid_ids);
        }
        return $this->db->get('iuran_master')->result_array();
    }

    private function get_payment_history($warga_id) {
        $this->db->select('p.*, m.nama_iuran, m.nominal');
        $this->db->from('pembayaran_iuran p');
        $this->db->join('iuran_master m', 'p.iuran_id = m.id');
        $this->db->where('p.warga_id', $warga_id);
        $this->db->order_by('p.tgl_bayar', 'DESC');
        return $this->db->get()->result_array();
    }

    public function bayar() {
        $iuran_id = $this->input->post('iuran_id');
        $user_id = $this->session->userdata('user_id');
        $warga = $this->Dashboard_model->get_warga_by_user_id($user_id);

        if ($_FILES['bukti']['name']) {
            $config['upload_path']   = './assets/images/pembayaran/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['file_name']     = 'pay_' . time();
            
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('bukti')) {
                $upload_data = $this->upload->data();
                $data = [
                    'warga_id' => $warga['id'],
                    'iuran_id' => $iuran_id,
                    'tgl_bayar' => date('Y-m-d H:i:s'),
                    'bukti_bayar' => $upload_data['file_name'],
                    'status' => 'pending'
                ];
                $this->db->insert('pembayaran_iuran', $data);
                $this->session->set_flashdata('success_msg', 'Konfirmasi pembayaran berhasil dikirim!');
            } else {
                $this->session->set_flashdata('error_msg', $this->upload->display_errors());
            }
        }
        redirect('user/iuran');
    }
}
