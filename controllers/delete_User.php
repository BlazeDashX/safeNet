<?php
error_reporting(0);
ini_set('display_errors', 0);

session_start();
require_once '../models/db.php';

// JSON response
header('Content-Type: application/json');

// Authorization check
if (!isset($_SESSION['status']) || $_SESSION['type'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

// Request validation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {

    $userId = $_POST['id'];
    $con = getConnection();

    // Current admin ID
    $adminId = $_SESSION['id'] ?? ($_SESSION['user_id'] ?? 0);

    // Self-delete prevention
    if ($userId == $adminId) {
        echo json_encode(['success' => false, 'message' => 'Action denied']);
        exit;
    }

    // Delete query
    $stmt = $con->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);

    // Execution result
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'DB error']);
    }

    $stmt->close();
    $con->close();

} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
exit;
?>
