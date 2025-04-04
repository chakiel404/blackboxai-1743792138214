<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CI_Model {
    public function __construct() {
        // Load database connection
        $this->load = &get_instance()->load;
        $this->db = $this->load->database();
    }
}
?>