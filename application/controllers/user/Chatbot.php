<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chatbot extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id')) {
            echo json_encode(['status' => false, 'msg' => 'Unauthorized']);
            exit;
        }
        $this->load->model('Chatbot_model');
    }

    public function index() {
        $data['history'] = $this->Chatbot_model->get_history($this->session->userdata('user_id'), 5);
        $this->load->view('user/chatbot', $data);
    }

    // API Endpoint
    public function ask() {
        $question = $this->input->post('question');
        
        if (empty($question)) {
            echo json_encode(['status' => false, 'msg' => 'Pertanyaan tidak boleh kosong']);
            return;
        }

        $answer = $this->Chatbot_model->get_answer($question);
        
        // Save to history
        $this->Chatbot_model->save_history(
            $this->session->userdata('user_id'),
            $question,
            $answer
        );

        echo json_encode([
            'status' => true,
            'question' => $question,
            'answer' => $answer,
            'timestamp' => date('H:i')
        ]);
    }
}
