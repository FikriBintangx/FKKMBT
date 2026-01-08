<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lainnya extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id')) redirect('auth/login');
    }
    public function index() {
        $data['page_title'] = 'Menu Lainnya';
        $this->load->view('user/templates/header');
        echo '<div class="header-section" style="background: linear-gradient(135deg, #022c22 0%, #14532d 100%); padding: 30px 20px 80px; color: white; border-radius: 0 0 30px 30px; position: relative; z-index: 1;">
                <div class="d-flex align-items-center gap-3">
                    <a href="'.base_url('user/dashboard').'" class="text-white text-decoration-none bg-white bg-opacity-10 rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <h5 class="fw-bold mb-0">Menu Lainnya</h5>
                </div>
              </div>
              <main class="container py-4" style="margin-top: -60px; position: relative; z-index: 2;">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="card border-0 shadow-sm rounded-4 text-center p-3 h-100">
                             <i class="bi bi-info-circle fs-3 text-info mb-2"></i>
                             <h6 class="small fw-bold">Tentang App</h6>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card border-0 shadow-sm rounded-4 text-center p-3 h-100">
                             <i class="bi bi-question-circle fs-3 text-primary mb-2"></i>
                             <h6 class="small fw-bold">Bantuan</h6>
                        </div>
                    </div>
                </div>
              </main>';
        $this->load->view('user/templates/footer');
    }
}
