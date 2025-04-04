<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_model extends CI_Model {
    public function get_all_students() {
        return $this->db->get('students')->result();
    }

    public function add_student($data) {
        return $this->db->insert('students', $data);
    }

    public function update_student($id, $data) {
        return $this->db->update('students', $data, array('student_id' => $id));
    }

    public function delete_student($id) {
        return $this->db->delete('students', array('student_id' => $id));
    }

    public function can_access_materials($student_id, $class_id) {
        // Check if the student is enrolled in the class
        $this->db->where('student_id', $student_id);
        $this->db->where('class_id', $class_id);
        $query = $this->db->get('student_classes'); // Assuming a table that links students to classes
        return $query->num_rows() > 0;
    }
}
?>