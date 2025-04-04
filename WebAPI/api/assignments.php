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
            if (isset($_GET['id'])) {
                if ($action === 'submissions') {
                    // Only teachers can view submissions
                    $user = checkRole(['admin', 'guru']);
                    getAssignmentSubmissions($db, $_GET['id'], $user);
                } else {
                    getAssignment($db, $_GET['id']);
                }
            } else {
                // Get assignments based on user role and schedule
                $user = checkRole(['admin', 'guru', 'siswa']);
                getAssignments($db, $user);
            }
            break;

        case 'POST':
            if ($action === 'submit' && isset($_GET['id'])) {
                // Students submit assignments
                $user = checkRole(['siswa']);
                submitAssignment($db, $_GET['id'], $user);
            } else {
                // Only teachers can create assignments
                $user = checkRole(['admin', 'guru']);
                createAssignment($db, $user);
            }
            break;

        case 'PUT':
            if ($action === 'grade' && isset($_GET['id'])) {
                // Teachers grade submissions
                $user = checkRole(['admin', 'guru']);
                gradeSubmission($db, $_GET['id'], $user);
            } else {
                // Update assignment
                $user = checkRole(['admin', 'guru']);
                if (!isset($_GET['id'])) {
                    sendError('Assignment ID is required', 400);
                }
                updateAssignment($db, $_GET['id'], $user);
            }
            break;

        case 'DELETE':
            $user = checkRole(['admin', 'guru']);
            if (!isset($_GET['id'])) {
                sendError('Assignment ID is required', 400);
            }
            deleteAssignment($db, $_GET['id'], $user);
            break;

        default:
            sendError('Method not allowed', 405);
    }
} catch (Exception $e) {
    logError('Assignments Error: ' . $e->getMessage());
    sendError('An error occurred while processing your request');
}

function getAssignments($db, $user) {
    try {
        // Get user schedule
        $schedule = $db->fetchAll("SELECT subject_id FROM schedules WHERE teacher_id = ? OR student_id = ?", [$user->userId, $user->userId]);

        // Prepare subject IDs for filtering
        $subjectIds = array_column($schedule, 'subject_id');

        $query = "SELECT a.*, s.name as subject_name, u.full_name as created_by_name,
                        (SELECT COUNT(*) FROM assignment_submissions WHERE assignment_id = a.assignment_id) as submission_count
                 FROM assignments a
                 JOIN subjects s ON a.subject_id = s.subject_id
                 JOIN users u ON a.created_by = u.user_id
                 WHERE a.subject_id IN (" . implode(',', $subjectIds) . ") 
                 ORDER BY a.due_date ASC";

        $assignments = $db->fetchAll($query);

        // Format the response
        $formattedAssignments = array_map(function($assignment) {
            return [
                'id' => $assignment['assignment_id'],
                'title' => $assignment['title'],
                'description' => $assignment['description'],
                'subject' => [
                    'id' => $assignment['subject_id'],
                    'name' => $assignment['subject_name']
                ],
                'createdBy' => [
                    'id' => $assignment['created_by'],
                    'name' => $assignment['created_by_name']
                ],
                'dueDate' => $assignment['due_date'],
                'submissionCount' => $assignment['submission_count'],
                'fileName' => $assignment['file_name'],
                'fileSize' => $assignment['file_size'],
                'mimeType' => $assignment['mime_type'],
                'createdAt' => $assignment['created_at']
            ];
        }, $assignments);

        sendResponse(['assignments' => $formattedAssignments]);
    } catch (Exception $e) {
        logError('Get Assignments Error: ' . $e->getMessage());
        sendError('Failed to fetch assignments');
    }
}

// Other functions remain unchanged...
?>