<?php
// 1. SILENCE ALL WARNINGS (Crucial for JSON APIs)
error_reporting(0);
ini_set('display_errors', 0);

session_start();
require_once '../models/db.php';

// 2. Set Header
header('Content-Type: application/json');

// Security Check
if (!isset($_SESSION['status']) || $_SESSION['type'] != 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    
    $userId = $_POST['id'];
    $con = getConnection();

    // 3. SAFE CHECK: Handle case where session ID might be missing
    // This uses 'user_id' if 'id' doesn't exist, or 0 if neither exists.
    $currentAdminId = isset($_SESSION['id']) ? $_SESSION['id'] : (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0);

    if ($userId == $currentAdminId) {
        echo json_encode(['success' => false, 'message' => 'You cannot delete yourself.']);
        exit;
    }

    $stmt = $con->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
    $con->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
exit;
?>