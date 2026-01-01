<?php
session_start();
require_once '../models/reportModel.php';
header('Content-Type: application/json');

// 1. STRICT AUTH CHECK
// Ensure 'user_id' is actually set in your Login Controller!
if (!isset($_SESSION['status']) || !isset($_SESSION['user_id'])) {
    echo json_encode(['status' => false, 'message' => 'Session expired or invalid. Please relogin.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $userId = $_SESSION['user_id'];
    $desc = trim($_POST['description'] ?? '');
    $rel = $_POST['relationship'] ?? '';
    $type = $_POST['type'] ?? '';

    // 2. Validate Inputs
    if (empty($desc) || empty($rel) || empty($type)) {
        echo json_encode(['status' => false, 'message' => 'All text fields are required.']);
        exit;
    }

    // 3. Handle File Upload
    $evidencePath = null;
    if (isset($_FILES['evidence']) && $_FILES['evidence']['error'] === 0) {
        
        $allowed = ['jpg', 'jpeg', 'png', 'pdf'];
        $ext = strtolower(pathinfo($_FILES['evidence']['name'], PATHINFO_EXTENSION));
        
        if (!in_array($ext, $allowed)) {
            echo json_encode(['status' => false, 'message' => 'Invalid file type. Only JPG, PNG, PDF allowed.']);
            exit;
        }

        // Unique Name
        $fileName = "evidence_" . $userId . "_" . time() . "." . $ext;
        
        // PHYSICAL PATH (Where PHP moves the file)
        $uploadDir = "../assets/uploads/";
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        
        $destination = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['evidence']['tmp_name'], $destination)) {
            // DB PATH (What we save in Database - relative to project root)
            $evidencePath = "assets/uploads/" . $fileName;
        } else {
            echo json_encode(['status' => false, 'message' => 'Failed to move uploaded file. Check folder permissions.']);
            exit;
        }
    }

    // 4. Save to DB
    $isCreated = createReport($userId, $desc, $rel, $type, $evidencePath);

    if ($isCreated) {
        echo json_encode(['status' => true, 'message' => 'Report submitted successfully!']);
    } else {
        echo json_encode(['status' => false, 'message' => 'Database insertion failed. See server logs.']);
    }
}
?>