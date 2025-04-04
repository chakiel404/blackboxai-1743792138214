<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teachers extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Teacher_model');
        
        // Check if user is admin
        if (!$this->session->userdata('is_admin')) {
            redirect('login'); // Redirect to login if not admin
        }
    }

    public function index() {
        // Load view for listing teachers
        $data['teachers'] = $this->Teacher_model->get_all_teachers();
        $this->load->view('admin/teachers', $data);
    }

    public function add() {
        // Logic for adding a new teacher
        // Validate input and call the model to add the teacher
    }

    public function edit($id) {
        // Logic for editing a teacher
        // Validate input and call the model to update the teacher
    }

    public function delete($id) {
        // Logic for deleting a teacher
        $this->Teacher_model->delete_teacher($id);
        redirect('admin/teachers'); // Redirect back to the teacher list
    }
}
?>