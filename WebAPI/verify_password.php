<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/core/DB.php';

try {
    $db = DB::getInstance();
    $user = $db->fetch("SELECT * FROM users WHERE email = ?", ['admin@example.com']);
    
    echo "User found:\n";
    print_r($user);
    
    $test_password = 'admin123';
    $hash = $user['password'];
    
    echo "\nTesting password verification:\n";
    echo "Password to verify: " . $test_password . "\n";
    echo "Stored hash: " . $hash . "\n";
    echo "Verification result: " . (password_verify($test_password, $hash) ? "success" : "failed") . "\n";
    
    // Generate a new hash for comparison
    $new_hash = password_hash($test_password, PASSWORD_DEFAULT);
    echo "\nNew hash generated with same password: " . $new_hash . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}