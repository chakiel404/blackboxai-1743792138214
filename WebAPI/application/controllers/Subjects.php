<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subjects extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Subject_model');
        
        // Check if user is admin
        if (!$this->session->userdata('is_admin')) {
            redirect('login'); // Redirect to login if not admin
        }
    }

    public function index() {
        // Load view for listing subjects
        $data['subjects'] = $this->Subject_model->get_all_subjects();
        $this->load->view('admin/subjects', $data);
    }

    public function add() {
        // Logic for adding a new subject
        // Validate input and call the model to add the subject
    }

    public function edit($id) {
        // Logic for editing a subject
        // Validate input and call the model to update the subject
    }

    public function delete($id) {
        // Logic for deleting a subject
        $this->Subject_model->delete_subject($id);
        redirect('admin/subjects'); // Redirect back to the subject list
    }
}
?>