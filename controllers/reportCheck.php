<?php
session_start();
require_once '../models/reportModel.php'; // Report model
header('Content-Type: application/json');

// Auth check
if (!isset($_SESSION['status']) || !isset($_SESSION['user_id'])) {
    echo json_encode(['status' => false, 'message' => 'Unauthorized']);
    exit;
}

// Request check
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $userId = $_SESSION['user_id'];
    $desc   = htmlspecialchars(trim($_POST['description'] ?? ''));
    $rel    = $_POST['relationship'] ?? '';
    $type   = $_POST['type'] ?? '';

    // Input validation
    if (empty($desc) || empty($rel) || empty($type)) {
        echo json_encode(['status' => false, 'message' => 'Required fields missing']);
        exit;
    }

    // Length check
    if (strlen($desc) < 15) {
        echo json_encode(['status' => false, 'message' => 'Description too short']);
        exit;
    }

    // File validation
    $evidencePath = null;

    if (isset($_FILES['evidence']) && $_FILES['evidence']['error'] === 0) {

        $allowed = ['jpg', 'jpeg', 'png', 'pdf'];
        $ext = strtolower(pathinfo($_FILES['evidence']['name'], PATHINFO_EXTENSION));

        // Type check
        if (!in_array($ext, $allowed)) {
            echo json_encode(['status' => false, 'message' => 'Invalid file type']);
            exit;
        }

        // Size check
        if ($_FILES['evidence']['size'] > 2 * 1024 * 1024) {
            echo json_encode(['status' => false, 'message' => 'File too large']);
            exit;
        }

        // File upload
        $fileName = 'ev_' . bin2hex(random_bytes(8)) . '_' . time() . '.' . $ext;
        $uploadDir = '../assets/uploads/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $destination = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['evidence']['tmp_name'], $destination)) {
            $evidencePath = 'assets/uploads/' . $fileName;
        } else {
            echo json_encode(['status' => false, 'message' => 'Upload failed']);
            exit;
        }
    }

    // Save report
    $status = createReport($userId, $desc, $rel, $type, $evidencePath);

    if ($status) {
        echo json_encode(['status' => true, 'message' => 'Report submitted']);
    } else {
        echo json_encode(['status' => false, 'message' => 'Database error']);
    }
}
?>
