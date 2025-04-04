<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/DB.php';
require_once __DIR__ . '/../core/helpers.php';

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
        case 'GET':
            getMaterials($db);
            break;

        case 'POST':
            // Only teachers can upload materials
            $user = checkRole(['admin', 'guru']);
            uploadMaterial($db, $user);
            break;

        default:
            sendError('Method not allowed', 405);
    }
} catch (Exception $e) {
    logError('Materials Error: ' . $e->getMessage());
    sendError('An error occurred while processing your request');
}

function getMaterials($db) {
    try {
        // Get user schedule
        $user = checkRole(['admin', 'guru', 'siswa']);
        $schedule = $db->fetchAll("SELECT subject_id FROM schedules WHERE teacher_id = ? OR student_id = ?", [$user->userId, $user->userId]);

        // Prepare subject IDs for filtering
        $subjectIds = array_column($schedule, 'subject_id');

        $query = "SELECT m.*, s.name as subject_name, u.full_name as uploaded_by_name
                 FROM materials m
                 JOIN subjects s ON m.subject_id = s.subject_id
                 JOIN users u ON m.uploaded_by = u.user_id
                 WHERE m.subject_id IN (" . implode(',', $subjectIds) . ") 
                 ORDER BY m.created_at DESC";

        $materials = $db->fetchAll($query);

        // Format the response
        $formattedMaterials = array_map(function($material) {
            return [
                'id' => $material['material_id'],
                'title' => $material['title'],
                'description' => $material['description'],
                'subject' => [
                    'id' => $material['subject_id'],
                    'name' => $material['subject_name']
                ],
                'uploadedBy' => [
                    'id' => $material['uploaded_by'],
                    'name' => $material['uploaded_by_name']
                ],
                'createdAt' => $material['created_at']
            ];
        }, $materials);

        sendResponse(['materials' => $formattedMaterials]);
    } catch (Exception $e) {
        logError('Get Materials Error: ' . $e->getMessage());
        sendError('Failed to fetch materials');
    }
}

function uploadMaterial($db, $user) {
    try {
        // Validate required fields
        if (!isset($_POST['title']) || !isset($_POST['subject_id'])) {
            sendError('Title and subject are required', 400);
        }

        // Validate subject exists
        $subject = $db->fetch("SELECT subject_id FROM subjects WHERE subject_id = ?", [$_POST['subject_id']]);
        if (!$subject) {
            sendError('Invalid subject', 400);
        }

        // Handle file upload if present
        $filePath = null;
        $fileName = null;
        $fileSize = null;
        $mimeType = null;

        if (isset($_FILES['file'])) {
            $uploadResult = handleFileUpload($_FILES['file'], MATERIALS_DIR);
            if (!$uploadResult['success']) {
                sendError($uploadResult['message'], 400);
            }
            $filePath = $uploadResult['filePath'];
            $fileName = $uploadResult['fileName'];
            $fileSize = $uploadResult['fileSize'];
            $mimeType = $uploadResult['mimeType'];
        }

        // Insert material
        $materialId = $db->insert('materials', [
            'title' => sanitizeInput($_POST['title']),
            'description' => isset($_POST['description']) ? sanitizeInput($_POST['description']) : '',
            'subject_id' => $_POST['subject_id'],
            'uploaded_by' => $user->userId,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_size' => $fileSize,
            'mime_type' => $mimeType,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        sendResponse(['message' => 'Material uploaded successfully', 'materialId' => $materialId], 201);
    } catch (Exception $e) {
        logError('Upload Material Error: ' . $e->getMessage());
        sendError('Failed to upload material');
    }
}
?>