<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subject_test extends CI_Controller {
    public function index() {
        // Test Create Subject
        $subject_data = [
            'name' => 'Mathematics',
            'description' => 'Study of numbers and shapes'
        ];
        $this->Subject_model->add_subject($subject_data);
        
        // Test Read Subject
        $subjects = $this->Subject_model->get_all_subjects();
        print_r($subjects);
        
        // Test Update Subject
        $subject_id = $subjects[0]->subject_id; // Assuming there's at least one subject
        $this->Subject_model->update_subject($subject_id, ['name' => 'Advanced Mathematics']);
        
        // Test Delete Subject
        $this->Subject_model->delete_subject($subject_id);
    }
}
?>