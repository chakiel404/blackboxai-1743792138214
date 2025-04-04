<?php
// Error reporting - Only log errors, don't display them
error_reporting(E_ALL);
ini_set('display_errors', 1); // Changed to 1 for debugging
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/error.log');

// Database configuration
define('DB_TYPE', 'sqlite');
define('DB_FILE', __DIR__ . '/../database/smartapp.db');

// Session configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); // Set to 1 in production with HTTPS

// Application settings
define('APP_NAME', 'SmartApp');
define('APP_VERSION', '1.0.0');
define('APP_URL', 'http://localhost:8000');

// Upload directories
define('UPLOAD_DIR', __DIR__ . '/../uploads');
define('MATERIALS_DIR', UPLOAD_DIR . '/materials');
define('ASSIGNMENTS_DIR', UPLOAD_DIR . '/assignments');

// Create upload directories if they don't exist
if (!file_exists(UPLOAD_DIR)) {
    mkdir(UPLOAD_DIR, 0777, true);
    mkdir(MATERIALS_DIR, 0777, true);
    mkdir(ASSIGNMENTS_DIR, 0777, true);
}

// Create logs directory if it doesn't exist
if (!file_exists(__DIR__ . '/../logs')) {
    mkdir(__DIR__ . '/../logs', 0777, true);
}