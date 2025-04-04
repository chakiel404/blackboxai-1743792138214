<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Students extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Student_model');
        
        // Check if user is admin
        if (!$this->session->userdata('is_admin')) {
            redirect('login'); // Redirect to login if not admin
        }
    }

    public function index() {
        // Load view for listing students
        $data['students'] = $this->Student_model->get_all_students();
        $this->load->view('admin/students', $data);
    }

    public function add() {
        // Logic for adding a new student
        // Validate input and call the model to add the student
    }

    public function edit($id) {
        // Logic for editing a student
        // Validate input and call the model to update the student
    }

    public function delete($id) {
        // Logic for deleting a student
        $this->Student_model->delete_student($id);
        redirect('admin/students'); // Redirect back to the student list
    }
}
?>