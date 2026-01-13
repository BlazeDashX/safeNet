<?php
session_start();
require_once '../models/db.php';
header('Content-Type: application/json');

// Admin check
if (!isset($_SESSION['status']) || $_SESSION['type'] !== 'admin') {
    echo json_encode(['success'=>false, 'message'=>'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $userId = intval($_POST['id']);
    $con = getConnection();

    // Prevent self-delete
    $adminId = $_SESSION['id'] ?? ($_SESSION['user_id'] ?? 0);
    if ($userId === $adminId) {
        echo json_encode(['success'=>false, 'message'=>'Action denied']);
        exit;
    }

    $stmt = $con->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        echo json_encode(['success'=>true]);
    } else {
        echo json_encode(['success'=>false, 'message'=>'Database error']);
    }

    $stmt->close();
    $con->close();
    exit;
}

echo json_encode(['success'=>false, 'message'=>'Invalid request']);
exit;
?>
