<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher_model extends CI_Model {
    public function get_all_teachers() {
        return $this->db->get('teachers')->result();
    }

    public function add_teacher($data) {
        return $this->db->insert('teachers', $data);
    }

    public function update_teacher($id, $data) {
        return $this->db->update('teachers', $data, array('teacher_id' => $id));
    }

    public function delete_teacher($id) {
        return $this->db->delete('teachers', array('teacher_id' => $id));
    }

    public function can_upload($teacher_id, $class_id, $subject_id) {
        // Check if the teacher is assigned to the class and subject
        $this->db->where('teacher_id', $teacher_id);
        $this->db->where('class_id', $class_id);
        $this->db->where('subject_id', $subject_id);
        $query = $this->db->get('teacher_subjects'); // Assuming a table that links teachers to classes and subjects
        return $query->num_rows() > 0;
    }
}
?>