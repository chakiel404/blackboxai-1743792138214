<?php
// Check if user is logged in and is an admin
function isAdmin() {
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
}

// Check if user is logged in and is a teacher
function isTeacher() {
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'guru';
}

// Check if user is logged in and is a student
function isStudent() {
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'siswa';
}

// Get current user ID
function getCurrentUserId() {
    return $_SESSION['user']['id'] ?? null;
}

// Get current user role
function getCurrentUserRole() {
    return $_SESSION['user']['role'] ?? null;
}

// Get current user full name
function getCurrentUserName() {
    return $_SESSION['user']['full_name'] ?? null;
}

// Sanitize input
function sanitizeInput($input) {
    if (is_array($input)) {
        return array_map('sanitizeInput', $input);
    }
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// Format date
function formatDate($date, $format = 'Y-m-d H:i:s') {
    return date($format, strtotime($date));
}

// Generate random string
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

// Check if file upload is valid
function isValidUpload($file, $allowedTypes = [], $maxSize = 5242880) {
    if (!isset($file['error']) || is_array($file['error'])) {
        return false;
    }

    if ($file['size'] > $maxSize) {
        return false;
    }

    if (!empty($allowedTypes) && !in_array($file['type'], $allowedTypes)) {
        return false;
    }

    return true;
}

// Handle file upload
function handleFileUpload($file, $uploadDir, $allowedTypes = [], $maxSize = 5242880) {
    if (!isValidUpload($file, $allowedTypes, $maxSize)) {
        return false;
    }

    $fileName = generateRandomString() . '_' . basename($file['name']);
    $targetPath = $uploadDir . '/' . $fileName;

    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        return false;
    }

    return [
        'file_name' => $fileName,
        'file_path' => $targetPath,
        'file_type' => $file['type'],
        'file_size' => $file['size']
    ];
}

// Delete file
function deleteFile($filePath) {
    if (file_exists($filePath)) {
        return unlink($filePath);
    }
    return false;
}

// Format file size
function formatFileSize($bytes) {
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= pow(1024, $pow);
    return round($bytes, 2) . ' ' . $units[$pow];
}

// Get file extension
function getFileExtension($fileName) {
    return strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
}

// Check if request is AJAX
function isAjaxRequest() {
    return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
           strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

// Send JSON response
function sendJsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

// Redirect with message
function redirectWithMessage($url, $message, $type = 'success') {
    $_SESSION[$type] = $message;
    header("Location: $url");
    exit;
}

// Send error response
function sendError($message, $statusCode = 400) {
    sendJsonResponse(['error' => $message], $statusCode);
}

// Get JSON input from request
function getJsonInput() {
    $input = file_get_contents('php://input');
    return json_decode($input, true);
}

// Generate JWT token
function generateToken($userId, $role) {
    // Implementation for generating JWT token
    // This is a placeholder; actual implementation will depend on the JWT library used
    return base64_encode(json_encode(['user_id' => $userId, 'role' => $role]));
}

// Send success response
function sendResponse($data, $statusCode = 200) {
    sendJsonResponse($data, $statusCode);
}

// Check user role
function checkRole($allowedRoles) {
    $userRole = getCurrentUserRole();
    if (!in_array($userRole, $allowedRoles)) {
        sendError('Unauthorized', 403);
    }
}

// Get current academic year from settings
function getCurrentAcademicYear() {
    $db = DB::getInstance();
    $stmt = $db->query("SELECT setting_value FROM settings WHERE setting_key = 'current_academic_year'");
    return $stmt->fetchColumn();
}

// Get current semester from settings
function getCurrentSemester() {
    $db = DB::getInstance();
    $stmt = $db->query("SELECT setting_value FROM settings WHERE setting_key = 'current_semester'");
    return $stmt->fetchColumn();
}
?>