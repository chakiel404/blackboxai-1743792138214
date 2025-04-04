<?php
$password = 'admin123';

// Generate a new hash
$hash = password_hash($password, PASSWORD_BCRYPT);
echo "Generated hash for 'admin123': " . $hash . "\n";

// Test verification
$stored_hash = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
echo "\nVerifying against stored hash:\n";
echo "Stored hash: " . $stored_hash . "\n";
echo "Verification result: " . (password_verify($password, $stored_hash) ? "success" : "failed") . "\n";

// Create a new user with this password
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/core/DB.php';

try {
    $db = DB::getInstance();
    
    // First, delete the existing admin user
    $db->query("DELETE FROM users WHERE email = ?", ['admin@example.com']);
    
    // Insert new admin user with fresh hash
    $db->query(
        "INSERT INTO users (email, password, full_name, role) VALUES (?, ?, ?, ?)",
        ['admin@example.com', $hash, 'Administrator', 'admin']
    );
    
    echo "\nNew admin user created with fresh password hash.\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}