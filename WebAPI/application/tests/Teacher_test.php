<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher_test extends CI_Controller {
    public function index() {
        // Test Create Teacher
        $teacher_data = [
            'email' => 'testteacher@example.com',
            'full_name' => 'Test Teacher',
            'nip' => '987654321',
            'gender' => 'P',
            'birth_date' => '1980-01-01',
            'birth_place' => 'City',
            'address' => '456 Avenue',
            'phone' => '0987654321',
        ];
        $this->Teacher_model->add_teacher($teacher_data);
        
        // Test Read Teacher
        $teachers = $this->Teacher_model->get_all_teachers();
        print_r($teachers);
        
        // Test Update Teacher
        $teacher_id = $teachers[0]->teacher_id; // Assuming there's at least one teacher
        $this->Teacher_model->update_teacher($teacher_id, ['full_name' => 'Updated Teacher']);
        
        // Test Delete Teacher
        $this->Teacher_model->delete_teacher($teacher_id);
    }
}
?>