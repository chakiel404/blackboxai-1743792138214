<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminLogin extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function index() {
        // Load the admin login view
        $this->load->view('admin/login');
    }

    public function authenticate() {
        // Logic for authenticating admin login
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        // Validate input
        if (empty($email) || empty($password)) {
            $this->session->set_flashdata('error', 'Email and password are required.');
            redirect('admin/login');
        }

        // Check credentials
        $user = $this->User_model->get_user_by_email($email);
        if ($user && password_verify($password, $user['password'])) {
            // Set session data
            $this->session->set_userdata('is_admin', true);
            $this->session->set_userdata('user_id', $user['user_id']);
            redirect('admin/dashboard');
        } else {
            $this->session->set_flashdata('error', 'Invalid credentials.');
            redirect('admin/login');
        }
    }

    public function logout() {
        // Logic for logging out admin
        $this->session->unset_userdata('is_admin');
        $this->session->unset_userdata('user_id');
        redirect('admin/login');
    }
}
?>