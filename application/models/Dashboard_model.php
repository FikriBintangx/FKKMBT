<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->_check_schema();
    }

    private function _check_schema() {
        if (!$this->db->field_exists('alamat', 'warga')) {
            $this->db->query("ALTER TABLE warga ADD COLUMN alamat TEXT AFTER no_rumah");
        }
    }



    // --- ADMIN DASHBOARD QUERIES ---

    public function get_pending_payments_count() {
        $this->db->where('status', 'pending');
        return $this->db->count_all_results('pembayaran_iuran');
    }

    public function get_active_agenda_count() {
        $this->db->where('tanggal >=', date('Y-m-d'));
        return $this->db->count_all_results('kegiatan');
    }

    public function get_revenue_chart_data() {
        $query = $this->db->query("
            SELECT DATE_FORMAT(p.tgl_bayar, '%M') as bulan, SUM(m.nominal) as total 
            FROM pembayaran_iuran p 
            JOIN iuran_master m ON p.iuran_id = m.id 
            WHERE p.status='disetujui' 
            GROUP BY YEAR(p.tgl_bayar), MONTH(p.tgl_bayar) 
            ORDER BY p.tgl_bayar DESC LIMIT 6
        ");
        return $query->result_array();
    }

    public function get_core_administrators() {
        $this->db->where_in('level', [1, 2]);
        $this->db->order_by('level', 'ASC');
        $this->db->limit(5);
        return $this->db->get('struktur_organisasi')->result_array();
    }

    public function get_pending_payments_list($limit = 4) {
        $this->db->select('p.*, w.nama_lengkap, m.nama_iuran, m.nominal');
        $this->db->from('pembayaran_iuran p');
        $this->db->join('warga w', 'p.warga_id = w.id');
        $this->db->join('iuran_master m', 'p.iuran_id = m.id');
        $this->db->where('p.status', 'pending');
        $this->db->order_by('p.tgl_bayar', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

    public function get_recent_history($limit = 4) {
        $this->db->select('p.*, w.nama_lengkap, m.nama_iuran');
        $this->db->from('pembayaran_iuran p');
        $this->db->join('warga w', 'p.warga_id = w.id');
        $this->db->join('iuran_master m', 'p.iuran_id = m.id');
        $this->db->where('p.status !=', 'pending');
        $this->db->order_by('p.tgl_bayar', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

    // --- USER DASHBOARD QUERIES ---

    public function get_warga_by_user_id($user_id) {
        $this->db->where('user_id', $user_id);
        return $this->db->get('warga')->row_array();
    }

    public function get_monthly_agenda_count() {
        $current_month = date('m');
        $this->db->where("MONTH(tanggal) = '$current_month'");
        return $this->db->count_all_results('kegiatan');
    }

    public function get_unpaid_bills_count($warga_id) {
        // Query complex logic: Count iuran_master ID NOT IN (paid iuran by warga)
        $paid_iuran_sql = "SELECT iuran_id FROM pembayaran_iuran WHERE warga_id = ? AND (status = 'pending' OR status = 'disetujui')";
        $sql = "SELECT COUNT(*) as total FROM iuran_master WHERE status='aktif' AND id NOT IN ($paid_iuran_sql)";
        return $this->db->query($sql, array($warga_id))->row()->total;
    }

    public function get_total_kas_warga() {
        $sql = "SELECT SUM(im.nominal) as total FROM pembayaran_iuran pi JOIN iuran_master im ON pi.iuran_id = im.id WHERE pi.status = 'disetujui'";
        return $this->db->query($sql)->row()->total;
    }

    public function get_latest_news($limit = 2) {
        $this->db->select('k.*, o.nama_organisasi');
        $this->db->from('kegiatan k');
        $this->db->join('organisasi o', 'k.organisasi_id = o.id');
        $this->db->order_by('k.created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

    public function get_upcoming_agenda($limit = 3) {
        $this->db->where('tanggal >=', date('Y-m-d'));
        $this->db->order_by('tanggal', 'ASC');
        $this->db->limit($limit);
        return $this->db->get('kegiatan')->result_array();
    }
}
