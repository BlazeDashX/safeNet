<?php
session_start();
require_once '../models/reportModel.php';
header('Content-Type: application/json');

// 1. STRICT AUTH CHECK
if (!isset($_SESSION['status']) || !isset($_SESSION['user_id'])) {
    echo json_encode(['status' => false, 'message' => 'Session expired or invalid. Please login again.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $userId = $_SESSION['user_id'];
    // Use htmlspecialchars to prevent basic XSS attacks
    $desc = htmlspecialchars(trim($_POST['description'] ?? ''));
    $rel = $_POST['relationship'] ?? '';
    $type = $_POST['type'] ?? '';

    // 2. ENHANCED VALIDATION
    if (empty($desc) || empty($rel) || empty($type)) {
        echo json_encode(['status' => false, 'message' => 'Please fill in all required fields.']);
        exit;
    }

    // Check for minimum description length
    if (strlen($desc) < 15) {
        echo json_encode(['status' => false, 'message' => 'Description must be at least 15 characters long.']);
        exit;
    }

    // 3. SECURE FILE UPLOAD VALIDATION
    $evidencePath = null;
    if (isset($_FILES['evidence']) && $_FILES['evidence']['error'] === 0) {
        
        $allowed = ['jpg', 'jpeg', 'png', 'pdf'];
        $ext = strtolower(pathinfo($_FILES['evidence']['name'], PATHINFO_EXTENSION));
        
        // Validate Extension
        if (!in_array($ext, $allowed)) {
            echo json_encode(['status' => false, 'message' => 'Invalid file type. Only JPG, PNG, PDF allowed.']);
            exit;
        }

        // Validate File Size (e.g., limit to 2MB)
        if ($_FILES['evidence']['size'] > 2 * 1024 * 1024) {
            echo json_encode(['status' => false, 'message' => 'File size too large. Maximum limit is 2MB.']);
            exit;
        }

        // Unique Name using a safer hash
        $fileName = "ev_" . bin2hex(random_bytes(8)) . "_" . time() . "." . $ext;
        
        $uploadDir = "../assets/uploads/";
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        
        $destination = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['evidence']['tmp_name'], $destination)) {
            $evidencePath = "assets/uploads/" . $fileName;
        } else {
            echo json_encode(['status' => false, 'message' => 'Server error: Could not save the uploaded file.']);
            exit;
        }
    }

    // 4. Save to DB
    $isCreated = createReport($userId, $desc, $rel, $type, $evidencePath);

    if ($isCreated) {
        echo json_encode(['status' => true, 'message' => 'Report submitted successfully!']);
    } else {
        echo json_encode(['status' => false, 'message' => 'Database error. Please try again later.']);
    }
}
?>