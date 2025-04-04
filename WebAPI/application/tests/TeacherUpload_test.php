<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TeacherUpload_test extends CI_Controller {
    public function index() {
        // Test Teacher Upload Assignment
        $teacher_id = 1; // Assuming a valid teacher ID
        $class_id = 1; // Assuming a valid class ID
        $subject_id = 1; // Assuming a valid subject ID

        if ($this->Teacher_model->can_upload($teacher_id, $class_id, $subject_id)) {
            // Simulate assignment upload
            $assignment_data = [
                'title' => 'Math Assignment',
                'description' => 'Complete the exercises',
                'class_id' => $class_id,
                'subject_id' => $subject_id,
                'due_date' => '2025-04-10'
            ];
            // Assuming a method to handle the upload
            $this->Assignment_model->add_assignment($assignment_data);
            echo "Assignment uploaded successfully.";
        } else {
            echo "Teacher is not authorized to upload assignments for this class and subject.";
        }
    }
}
?>