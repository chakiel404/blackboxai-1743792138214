<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_test extends CI_Controller {
    public function index() {
        // Test Create Student
        $student_data = [
            'email' => 'teststudent@example.com',
            'full_name' => 'Test Student',
            'nisn' => '123456789',
            'gender' => 'L',
            'birth_date' => '2000-01-01',
            'birth_place' => 'City',
            'address' => '123 Street',
            'phone' => '1234567890',
        ];
        $this->Student_model->add_student($student_data);
        
        // Test Read Student
        $students = $this->Student_model->get_all_students();
        print_r($students);
        
        // Test Update Student
        $student_id = $students[0]->student_id; // Assuming there's at least one student
        $this->Student_model->update_student($student_id, ['full_name' => 'Updated Student']);
        
        // Test Delete Student
        $this->Student_model->delete_student($student_id);
    }
}
?>