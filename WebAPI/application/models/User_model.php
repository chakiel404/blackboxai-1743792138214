<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    public function get_all_users() {
        return $this->db->get('users')->result();
    }

    public function add_user($data) {
        return $this->db->insert('users', $data);
    }

    public function update_user($id, $data) {
        return $this->db->update('users', $data, array('user_id' => $id));
    }

    public function delete_user($id) {
        return $this->db->delete('users', array('user_id' => $id));
    }
}
?>