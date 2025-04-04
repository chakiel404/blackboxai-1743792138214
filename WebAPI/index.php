<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$system_path = 'system';
$application_folder = 'application';

if (realpath($system_path) !== FALSE) {
    $system_path = realpath($system_path);
}

$system_path = rtrim($system_path, '/').'/';
$application_folder = rtrim($application_folder, '/').'/';

define('BASEPATH', $system_path);
define('APPPATH', $system_path.$application_folder);
define('FCPATH', dirname(__FILE__).'/');

require_once BASEPATH.'core/CodeIgniter.php';
?>