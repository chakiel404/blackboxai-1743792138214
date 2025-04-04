<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subject_model extends CI_Model {
    public function get_all_subjects() {
        return $this->db->get('subjects')->result();
    }

    public function add_subject($data) {
        return $this->db->insert('subjects', $data);
    }

    public function update_subject($id, $data) {
        return $this->db->update('subjects', $data, array('subject_id' => $id));
    }

    public function delete_subject($id) {
        return $this->db->delete('subjects', array('subject_id' => $id));
    }
}
?>