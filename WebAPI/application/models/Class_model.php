<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Class_model extends CI_Model {
    public function get_all_classes() {
        return $this->db->get('classes')->result();
    }

    public function add_class($data) {
        return $this->db->insert('classes', $data);
    }

    public function update_class($id, $data) {
        return $this->db->update('classes', $data, array('class_id' => $id));
    }

    public function delete_class($id) {
        return $this->db->delete('classes', array('class_id' => $id));
    }
}
?>