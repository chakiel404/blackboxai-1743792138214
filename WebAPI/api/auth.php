<?php
// Start output buffering at the very beginning
ob_start();

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/DB.php';
require_once __DIR__ . '/../core/helpers.php';

// Ensure clean output
if (ob_get_length()) ob_clean();

// Handle CORS preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$db = DB::getInstance();
$method = $_SERVER['REQUEST_METHOD'];
$action = isset($_GET['action']) ? $_GET['action'] : '';

try {
    switch ($method) {
        case 'POST':
            switch ($action) {
                case 'login':
                    handleLogin($db);
                    break;
                case 'register':
                    handleRegister($db);
                    break;
                default:
                    sendError('Invalid action', 404);
            }
            break;
        default:
            sendError('Method not allowed', 405);
    }
} catch (Exception $e) {
    logError('Auth Error: ' . $e->getMessage());
    sendError('An error occurred while processing your request');
}

function handleLogin($db) {
    $data = getJsonInput();
    
    // Validate required fields
    if ((!isset($data['email']) && !isset($data['nisn']) && !isset($data['nip'])) || !isset($data['password'])) {
        sendError('Email/NISN/NIP and password are required');
    }

    $password = $data['password'];
    $user = null;

    // Check if login is for a student or teacher
    if (isset($data['nisn'])) {
        $nisn = $data['nisn'];
        $stmt = $db->query("SELECT user_id, email, password, full_name, role FROM users WHERE nisn = ?", [$nisn]);
        $user = $stmt->fetch();
    } elseif (isset($data['nip'])) {
        $nip = $data['nip'];
        $stmt = $db->query("SELECT user_id, email, password, full_name, role FROM users WHERE nip = ?", [$nip]);
        $user = $stmt->fetch();
    } elseif (isset($data['email'])) {
        $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        $stmt = $db->query("SELECT user_id, email, password, full_name, role FROM users WHERE email = ?", [$email]);
        $user = $stmt->fetch();
    }

    if (!$user) {
        sendError('Invalid credentials', 401);
    }

    // Verify password
    if (!password_verify($password, $user['password'])) {
        sendError('Invalid credentials', 401);
    }

    // Generate token
    $token = generateToken($user['user_id'], $user['role']);

    // Return user data and token
    $response = [
        'token' => $token,
        'user' => [
            'id' => $user['user_id'],
            'email' => $user['email'],
            'full_name' => $user['full_name'],
            'role' => $user['role']
        ]
    ];

    // Add role-specific IDs
    if ($user['role'] === 'siswa') {
        $response['user']['nisn'] = $user['nisn'];
    } elseif ($user['role'] === 'guru') {
        $response['user']['nip'] = $user['nip'];
    }

    sendResponse($response);
}
?>