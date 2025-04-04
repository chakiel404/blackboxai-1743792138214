<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_model extends CI_Model {
    public function get_all_settings() {
        return $this->db->get('settings')->result();
    }

    public function update_settings($data) {
        foreach ($data as $key => $value) {
            $this->db->update('settings', ['setting_value' => $value], ['setting_key' => $key]);
        }
        return true;
    }
}
?>