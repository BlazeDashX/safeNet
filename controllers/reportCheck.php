<?php
session_start();
require_once '../models/reportModel.php';
header('Content-Type: application/json');

// Auth check
if (!isset($_SESSION['status']) || !isset($_SESSION['user_id'])) {
    echo json_encode(['status'=>false, 'message'=>'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $desc   = trim($_POST['description'] ?? '');
    $rel    = $_POST['relationship'] ?? '';
    $type   = $_POST['type'] ?? '';
    $evidencePath = null;

    // Required fields
    if (!$desc || !$rel || !$type) {
        echo json_encode(['status'=>false, 'message'=>'Required fields missing']);
        exit;
    }

    if (strlen($desc) < 15) {
        echo json_encode(['status'=>false, 'message'=>'Description too short']);
        exit;
    }

    // Handle file upload
    if (isset($_FILES['evidence']) && $_FILES['evidence']['error'] === 0) {
        $allowed = ['jpg','jpeg','png','pdf'];
        $ext = strtolower(pathinfo($_FILES['evidence']['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            echo json_encode(['status'=>false, 'message'=>'Invalid file type']);
            exit;
        }

        if ($_FILES['evidence']['size'] > 2*1024*1024) {
            echo json_encode(['status'=>false, 'message'=>'File too large']);
            exit;
        }

        $fileName = 'ev_'.bin2hex(random_bytes(8)).'_'.time().'.'.$ext;
        $uploadDir = '../assets/uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        if (move_uploaded_file($_FILES['evidence']['tmp_name'], $uploadDir.$fileName)) {
            $evidencePath = 'assets/uploads/'.$fileName;
        } else {
            echo json_encode(['status'=>false, 'message'=>'Upload failed']);
            exit;
        }
    }

    // Save report
    $status = createReport($userId, htmlspecialchars($desc), $rel, $type, $evidencePath);

    if ($status) {
        echo json_encode(['status'=>true, 'message'=>'Report submitted']);
    } else {
        echo json_encode(['status'=>false, 'message'=>'Database error']);
    }
}
?>
