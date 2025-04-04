<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Class_test extends CI_Controller {
    public function index() {
        // Test Create Class
        $class_data = [
            'class_name' => 'Class A',
            'academic_year' => '2023-2024'
        ];
        $this->Class_model->add_class($class_data);
        
        // Test Read Class
        $classes = $this->Class_model->get_all_classes();
        print_r($classes);
        
        // Test Update Class
        $class_id = $classes[0]->class_id; // Assuming there's at least one class
        $this->Class_model->update_class($class_id, ['class_name' => 'Updated Class A']);
        
        // Test Delete Class
        $this->Class_model->delete_class($class_id);
    }
}
?>