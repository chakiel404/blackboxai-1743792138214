<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        
        // Check if user is logged in
        if (!$this->session->userdata('is_logged_in')) {
            redirect('login'); // Redirect to login if not logged in
        }
    }

    public function index() {
        // Load view for editing profile
        $data['user'] = $this->User_model->get_user($this->session->userdata('user_id'));
        $this->load->view('admin/profile', $data);
    }

    public function update() {
        // Logic for updating user profile
        // Validate input and call the model to update the user
    }
}
?>