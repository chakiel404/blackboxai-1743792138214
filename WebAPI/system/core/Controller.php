<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CI_Controller {
    public function __construct() {
        // Load necessary libraries, helpers, and models
        $this->load = &get_instance()->load;
    }
}
?>