<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StudentAccess_test extends CI_Controller {
    public function index() {
        // Test Student Access to Materials
        $student_id = 1; // Assuming a valid student ID
        $class_id = 1; // Assuming a valid class ID

        if ($this->Student_model->can_access_materials($student_id, $class_id)) {
            // Simulate fetching materials
            $materials = $this->Material_model->get_materials_by_class($class_id);
            print_r($materials);
        } else {
            echo "Student is not authorized to access materials for this class.";
        }
    }
}
?>