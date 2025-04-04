<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/core/DB.php';

try {
    // Create or connect to SQLite database
    $pdo = new PDO("sqlite:" . DB_PATH);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Drop existing tables
    $pdo->exec("DROP TABLE IF EXISTS quiz_submissions");
    $pdo->exec("DROP TABLE IF EXISTS assignment_submissions");
    $pdo->exec("DROP TABLE IF EXISTS student_classes");
    $pdo->exec("DROP TABLE IF EXISTS teacher_subjects");
    $pdo->exec("DROP TABLE IF EXISTS materials");
    $pdo->exec("DROP TABLE IF EXISTS quiz_questions");
    $pdo->exec("DROP TABLE IF EXISTS quizzes");
    $pdo->exec("DROP TABLE IF EXISTS assignments");
    $pdo->exec("DROP TABLE IF EXISTS students");
    $pdo->exec("DROP TABLE IF EXISTS teachers");
    $pdo->exec("DROP TABLE IF EXISTS subjects");
    $pdo->exec("DROP TABLE IF EXISTS settings");
    $pdo->exec("DROP TABLE IF EXISTS users");
    $pdo->exec("DROP TABLE IF EXISTS classes");

    // Read and execute schema.sql
    $schema = file_get_contents(__DIR__ . '/database/schema.sql');
    $pdo->exec($schema);

    // Read and execute init_data.sql
    $initData = file_get_contents(__DIR__ . '/database/init_data.sql');
    $pdo->exec($initData);

    echo "Database reinitialized successfully!\n";
    
    // Verify admin user was created
    $stmt = $pdo->query("SELECT * FROM users WHERE role = 'admin'");
    $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "\nAdmin users in database:\n";
    print_r($admins);

} catch (PDOException $e) {
    die("Error: " . $e->getMessage() . "\n");
}