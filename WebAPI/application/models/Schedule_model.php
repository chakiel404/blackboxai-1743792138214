<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schedule_model extends CI_Model {
    public function get_all_schedules() {
        $query = $this->db->get('schedules');
        return $query->result_array();
    }

    public function add_schedule($data) {
        return $this->db->insert('schedules', $data);
    }

    public function update_schedule($id, $data) {
        $this->db->where('schedule_id', $id);
        return $this->db->update('schedules', $data);
    }

    public function delete_schedule($id) {
        return $this->db->delete('schedules', array('schedule_id' => $id));
    }
}
?>