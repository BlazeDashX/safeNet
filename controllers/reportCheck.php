<?php
session_start();
require_once '../models/reportModel.php';
header('Content-Type: application/json');

// 1. Check Login
if (!isset($_SESSION['status']) || $_SESSION['status'] !== true) {
    echo json_encode(['status' => false, 'message' => 'Please login first']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $userId = $_SESSION['user_id'];
    $desc = $_POST['description'] ?? '';
    $rel = $_POST['relationship'] ?? '';
    $type = $_POST['type'] ?? '';

    // 2. Validate Text Fields
    if (empty($desc) || empty($rel) || empty($type)) {
        echo json_encode(['status' => false, 'message' => 'All fields are required']);
        exit;
    }

    // 3. Handle File Upload (Evidence)
    $evidencePath = null;
    if (isset($_FILES['evidence']) && $_FILES['evidence']['error'] === 0) {
        $fileName = time() . '_' . basename($_FILES['evidence']['name']);
        $targetDir = "../assets/uploads/";
        
        // Create folder if not exists
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

        $targetFile = $targetDir . $fileName;
        
        // Move file
        if (move_uploaded_file($_FILES['evidence']['tmp_name'], $targetFile)) {
            $evidencePath = "assets/uploads/" . $fileName; // Store relative path
        } else {
            echo json_encode(['status' => false, 'message' => 'Failed to upload image']);
            exit;
        }
    }

    // 4. Save to Database
    $status = createReport($userId, $desc, $rel, $type, $evidencePath);

    if ($status) {
        echo json_encode(['status' => true, 'message' => 'Report submitted successfully!']);
    } else {
        echo json_encode(['status' => false, 'message' => 'Database error']);
    }
}
?>