<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Iuran_model extends CI_Model {
    
    // ========================================
    // IURAN MASTER (Jenis Iuran)
    // ========================================
    
    public function get_all_iuran() {
        return $this->db->get('iuran_master')->result_array();
    }
    
    public function get_iuran_aktif() {
        $this->db->where('status', 'aktif');
        return $this->db->get('iuran_master')->result_array();
    }
    
    public function get_iuran_by_id($id) {
        return $this->db->get_where('iuran_master', ['id' => $id])->row_array();
    }
    
    public function create_iuran($data) {
        return $this->db->insert('iuran_master', $data);
    }
    
    public function update_iuran($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('iuran_master', $data);
    }
    
    public function delete_iuran($id) {
        $this->db->where('id', $id);
        return $this->db->delete('iuran_master');
    }
    
    // ========================================
    // PEMBAYARAN IURAN
    // ========================================
    
    public function get_all_pembayaran() {
        $this->db->select('p.*, w.nama_lengkap, w.blok, w.no_rumah, i.nama_iuran, i.nominal');
        $this->db->from('pembayaran_iuran p');
        $this->db->join('warga w', 'w.id = p.warga_id');
        $this->db->join('iuran_master i', 'i.id = p.iuran_id');
        $this->db->order_by('p.tgl_bayar', 'DESC');
        return $this->db->get()->result_array();
    }
    
    public function get_pembayaran_by_status($status) {
        $this->db->select('p.*, w.nama_lengkap, w.blok, w.no_rumah, i.nama_iuran, i.nominal');
        $this->db->from('pembayaran_iuran p');
        $this->db->join('warga w', 'w.id = p.warga_id');
        $this->db->join('iuran_master i', 'i.id = p.iuran_id');
        $this->db->where('p.status', $status);
        $this->db->order_by('p.tgl_bayar', 'DESC');
        return $this->db->get()->result_array();
    }
    
    public function get_pembayaran_by_warga($warga_id) {
        $this->db->select('p.*, i.nama_iuran, i.nominal, i.jatuh_tempo');
        $this->db->from('pembayaran_iuran p');
        $this->db->join('iuran_master i', 'i.id = p.iuran_id');
        $this->db->where('p.warga_id', $warga_id);
        $this->db->order_by('p.tgl_bayar', 'DESC');
        return $this->db->get()->result_array();
    }
    
    public function create_pembayaran($data) {
        return $this->db->insert('pembayaran_iuran', $data);
    }
    
    public function update_status_pembayaran($id, $status, $catatan = null) {
        $data = ['status' => $status];
        if ($catatan) {
            $data['catatan_admin'] = $catatan;
        }
        $this->db->where('id', $id);
        return $this->db->update('pembayaran_iuran', $data);
    }
    
    public function get_pembayaran_by_id($id) {
        $this->db->select('p.*, w.nama_lengkap, w.blok, w.no_rumah, i.nama_iuran, i.nominal');
        $this->db->from('pembayaran_iuran p');
        $this->db->join('warga w', 'w.id = p.warga_id');
        $this->db->join('iuran_master i', 'i.id = p.iuran_id');
        $this->db->where('p.id', $id);
        return $this->db->get()->row_array();
    }
    
    // ========================================
    // STATISTIK & LAPORAN
    // ========================================
    
    public function get_total_pemasukan_bulan_ini() {
        $this->db->select_sum('i.nominal');
        $this->db->from('pembayaran_iuran p');
        $this->db->join('iuran_master i', 'i.id = p.iuran_id');
        $this->db->where('p.status', 'disetujui');
        $this->db->where('MONTH(p.tgl_bayar)', date('m'));
        $this->db->where('YEAR(p.tgl_bayar)', date('Y'));
        $result = $this->db->get()->row_array();
        return $result['nominal'] ?? 0;
    }
    
    public function get_jumlah_pending() {
        $this->db->where('status', 'pending');
        return $this->db->count_all_results('pembayaran_iuran');
    }
    
    public function check_sudah_bayar($warga_id, $iuran_id, $bulan, $tahun) {
        $this->db->where('warga_id', $warga_id);
        $this->db->where('iuran_id', $iuran_id);
        $this->db->where('MONTH(tgl_bayar)', $bulan);
        $this->db->where('YEAR(tgl_bayar)', $tahun);
        $this->db->where_in('status', ['pending', 'disetujui']);
        return $this->db->count_all_results('pembayaran_iuran') > 0;
    }
}
