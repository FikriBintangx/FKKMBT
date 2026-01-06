<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kegiatan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id') || $this->session->userdata('role') !== 'admin') {
            redirect('auth/login');
        }
    }

    public function index() {
        // Fetch All Kegiatan
        $this->db->select('k.*, o.nama_organisasi');
        $this->db->from('kegiatan k');
        $this->db->join('organisasi o', 'k.organisasi_id = o.id');
        $this->db->order_by('k.tanggal', 'DESC');
        $data['kegiatan_list'] = $this->db->get()->result_array();

        // Process for Calendar
        $data['activity_dates'] = [];
        foreach ($data['kegiatan_list'] as $row) {
            $d = date('Y-m-d', strtotime($row['tanggal']));
            $data['activity_dates'][$d] = true;
        }

        // Fetch Organizations for dropdown
        $data['organisasi_list'] = $this->db->get('organisasi')->result_array();

        $this->load->view('admin/kegiatan', $data);
    }

    private function _handle_upload($kegiatan_id) {
        $target_dir = FCPATH . "assets/images/kegiatan/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $count = count($_FILES['media']['name']);
        $uploaded = 0;
        $errors = [];

        for ($i = 0; $i < $count; $i++) {
            if (!empty($_FILES['media']['name'][$i])) {
                $_FILES['file']['name'] = $_FILES['media']['name'][$i];
                $_FILES['file']['type'] = $_FILES['media']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['media']['tmp_name'][$i];
                $_FILES['file']['error'] = $_FILES['media']['error'][$i];
                $_FILES['file']['size'] = $_FILES['media']['size'][$i];

                $config['upload_path'] = $target_dir;
                $config['allowed_types'] = 'gif|jpg|png|jpeg|mp4|avi|mov';
                $config['file_name'] = "kegiatan_" . $kegiatan_id . "_" . uniqid();
                
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('file')) {
                    $fileData = $this->upload->data();
                    $filename = $fileData['file_name'];
                    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                    $tipe = in_array($ext, ['mp4','avi','mov']) ? 'video' : 'gambar';

                    $this->db->insert('kegiatan_galeri', [
                        'kegiatan_id' => $kegiatan_id,
                        'file' => $filename,
                        'tipe_file' => $tipe
                    ]);
                    $uploaded++;
                } else {
                    $errors[] = $this->upload->display_errors('', '');
                }
            }
        }

        // Update Main Photo if exists
        if ($uploaded > 0) {
            $first = $this->db->order_by('id', 'ASC')->get_where('kegiatan_galeri', ['kegiatan_id' => $kegiatan_id])->row();
            if ($first) {
                $this->db->where('id', $kegiatan_id)->update('kegiatan', ['foto' => $first->file]);
            }
        }

        return ['count' => $uploaded, 'errors' => implode(', ', $errors)];
    }

    public function add() {
        if ($this->input->method() == 'post') {
            $data = [
                'judul' => $this->input->post('judul'),
                'deskripsi' => $this->input->post('deskripsi'),
                'tanggal' => $this->input->post('tanggal'),
                'organisasi_id' => $this->input->post('organisasi_id')
            ];
            $this->db->insert('kegiatan', $data);
            $id = $this->db->insert_id();

            $res = $this->_handle_upload($id);
            $this->session->set_flashdata('success_msg', "Kegiatan ditambahkan. Upload: " . $res['count']);
            redirect('admin/kegiatan');
        }
    }

    public function edit() {
        if ($this->input->method() == 'post') {
            $id = $this->input->post('id');
            $data = [
                'judul' => $this->input->post('judul'),
                'deskripsi' => $this->input->post('deskripsi'),
                'tanggal' => $this->input->post('tanggal'),
                'organisasi_id' => $this->input->post('organisasi_id')
            ];
            $this->db->where('id', $id)->update('kegiatan', $data);

            $this->_handle_upload($id);
            $this->session->set_flashdata('success_msg', "Perubahan disimpan.");
            redirect('admin/kegiatan');
        }
    }

    public function delete($id) {
        // Delete Files
        $files = $this->db->get_where('kegiatan_galeri', ['kegiatan_id' => $id])->result();
        foreach ($files as $f) {
            $path = FCPATH . "assets/images/kegiatan/" . $f->file;
            if (file_exists($path)) unlink($path);
        }
        
        $this->db->delete('kegiatan_galeri', ['kegiatan_id' => $id]);
        $this->db->delete('kegiatan', ['id' => $id]);
        
        $this->session->set_flashdata('success_msg', "Kegiatan dihapus.");
        redirect('admin/kegiatan');
    }

    public function delete_media($id) {
        $file = $this->db->get_where('kegiatan_galeri', ['id' => $id])->row();
        if ($file) {
            $path = FCPATH . "assets/images/kegiatan/" . $file->file;
            if (file_exists($path)) unlink($path);
            $this->db->delete('kegiatan_galeri', ['id' => $id]);
        }
        $this->session->set_flashdata('success_msg', "Media dihapus.");
        redirect('admin/kegiatan');
    }
    
    // API Helper for Fetching Media in Edit Modal
    public function get_media($kegiatan_id) {
        $data = $this->db->get_where('kegiatan_galeri', ['kegiatan_id' => $kegiatan_id])->result_array();
        echo json_encode($data);
    }
}
