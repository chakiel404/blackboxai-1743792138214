<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/core/DB.php';

try {
    $db = DB::getInstance();
    $pdo = $db->getConnection();
    
    // Begin transaction
    $pdo->beginTransaction();
    
    try {
        // Check if admin user exists
        $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email = ? AND role = 'admin'");
        $stmt->execute(['admin@example.com']);
        $admin = $stmt->fetch();
        
        if (!$admin) {
            // Create admin user if not exists
            $hashedPassword = password_hash('password', PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("
                INSERT INTO users (email, password, full_name, role, status) 
                VALUES (?, ?, ?, 'admin', 'active')
            ");
            $stmt->execute(['admin@example.com', $hashedPassword, 'Administrator']);
            echo "Admin user created successfully\n";
        } else {
            echo "Admin user already exists\n";
        }
        
        // Check if default settings exist
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM settings");
        $stmt->execute();
        $settingsCount = $stmt->fetchColumn();
        
        if ($settingsCount == 0) {
            // Insert default settings
            $defaultSettings = [
                ['current_academic_year', '2023-2024'],
                ['current_semester', '1'],
                ['school_name', 'Smart School'],
                ['school_address', 'Jl. Pendidikan No. 1'],
                ['school_phone', '021-1234567'],
                ['school_email', 'info@smartschool.edu']
            ];
            
            $stmt = $pdo->prepare("
                INSERT INTO settings (setting_key, setting_value) 
                VALUES (?, ?)
            ");
            
            foreach ($defaultSettings as $setting) {
                $stmt->execute($setting);
            }
            echo "Default settings created successfully\n";
        } else {
            echo "Settings already exist\n";
        }
        
        $pdo->commit();
        echo "Initialization completed successfully\n";
        
    } catch (Exception $e) {
        $pdo->rollBack();
        throw $e;
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}