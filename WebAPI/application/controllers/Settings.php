<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Setting_model');
        
        // Check if user is admin
        if (!$this->session->userdata('is_admin')) {
            redirect('login'); // Redirect to login if not admin
        }
    }

    public function index() {
        // Load view for managing settings
        $data['settings'] = $this->Setting_model->get_all_settings();
        $this->load->view('admin/settings', $data);
    }

    public function update() {
        // Logic for updating settings
        // Validate input and call the model to update the settings
    }
}
?>