<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Student_model');
        $this->load->model('Teacher_model');
        $this->load->model('Class_model');
        $this->load->model('Subject_model');
        $this->load->model('Setting_model');
        
        // Check if user is admin
        if (!$this->session->userdata('is_admin')) {
            redirect('login'); // Redirect to login if not admin
        }
    }

    public function index() {
        // Load admin dashboard view
        $this->load->view('admin/dashboard');
    }

    public function upload_assignment() {
        $teacher_id = $this->session->userdata('user_id'); // Assuming user_id is stored in session
        $class_id = $this->input->post('class_id');
        $subject_id = $this->input->post('subject_id');
        
        if ($this->Teacher_model->can_upload($teacher_id, $class_id, $subject_id)) {
            // Proceed with assignment upload
        } else {
            // Show error message
            $this->session->set_flashdata('error', 'You are not authorized to upload assignments for this class and subject.');
            redirect('admin/assignments');
        }
    }

    public function view_materials() {
        $student_id = $this->session->userdata('user_id'); // Assuming user_id is stored in session
        $class_id = $this->input->post('class_id');
        
        if ($this->Student_model->can_access_materials($student_id, $class_id)) {
            // Proceed to fetch and display materials
        } else {
            // Show error message
            $this->session->set_flashdata('error', 'You are not authorized to access materials for this class.');
            redirect('admin/materials');
        }
    }
}
?>