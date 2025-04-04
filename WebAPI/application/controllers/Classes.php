<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Classes extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Class_model');
        
        // Check if user is admin
        if (!$this->session->userdata('is_admin')) {
            redirect('login'); // Redirect to login if not admin
        }
    }

    public function index() {
        // Load view for listing classes
        $data['classes'] = $this->Class_model->get_all_classes();
        $this->load->view('admin/classes', $data);
    }

    public function add() {
        // Logic for adding a new class
        // Validate input and call the model to add the class
    }

    public function edit($id) {
        // Logic for editing a class
        // Validate input and call the model to update the class
    }

    public function delete($id) {
        // Logic for deleting a class
        $this->Class_model->delete_class($id);
        redirect('admin/classes'); // Redirect back to the class list
    }
}
?>