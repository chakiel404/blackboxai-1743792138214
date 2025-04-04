<?php
try {
    $pdo = new PDO("sqlite:" . __DIR__ . '/database/smartapp.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Drop users table if exists
    $pdo->exec("DROP TABLE IF EXISTS users");
    
    // Create users table
    $sql = "CREATE TABLE users (
        user_id INTEGER PRIMARY KEY AUTOINCREMENT,
        email TEXT NOT NULL UNIQUE,
        password TEXT NOT NULL,
        full_name TEXT NOT NULL,
        role TEXT CHECK(role IN ('admin', 'guru', 'siswa')) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    $pdo->exec($sql);
    
    // Insert admin user
    $sql = "INSERT INTO users (email, password, full_name, role) VALUES 
            ('admin@example.com', 
             '\$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
             'Administrator',
             'admin')";
    
    $pdo->exec($sql);
    
    echo "Test initialization successful!\n";
    
    // Verify admin user
    $stmt = $pdo->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "Users in database:\n";
    print_r($users);
    
} catch (PDOException $e) {
    die("Error: " . $e->getMessage() . "\n");
}