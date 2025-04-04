<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_test extends CI_Controller {
    public function index() {
        // Test Update Settings
        $settings_data = [
            'current_academic_year' => '2023-2024',
            'current_semester' => '1',
            'school_name' => 'Test School',
            'school_address' => '123 Test St',
            'school_phone' => '1234567890',
            'school_email' => 'school@test.com',
            'maintenance_mode' => '0',
            'max_file_size' => '10',
            'allowed_file_types' => 'pdf,doc,docx,jpg,png'
        ];
        $this->Setting_model->update_settings($settings_data);
        
        // Test Read Settings
        $settings = $this->Setting_model->get_all_settings();
        print_r($settings);
    }
}
?>