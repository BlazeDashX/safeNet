<?php
session_start();
require_once '../models/db.php'; // DB connection
header('Content-Type: application/json');

// Auth check
if (!isset($_SESSION['status'])) {
    echo json_encode(['status' => false, 'message' => 'Login required']);
    exit;
}

// Request check
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $userId      = $_SESSION['user_id'];
    $currentPass = $_POST['currentPass'] ?? '';
    $newPass     = $_POST['newPass'] ?? '';
    $confirmPass = $_POST['confirmPass'] ?? '';

    // Validation
    if (empty($currentPass) || empty($newPass) || empty($confirmPass)) {
        echo json_encode(['status' => false, 'message' => 'Required fields missing']);
        exit;
    }

    // Match check
    if ($newPass !== $confirmPass) {
        echo json_encode(['status' => false, 'message' => 'Password mismatch']);
        exit;
    }

    // Password policy
    if (strlen($newPass) < 8) {
        echo json_encode(['status' => false, 'message' => 'Weak password']);
        exit;
    }

    // Fetch current password
    $con = getConnection();
    $stmt = $con->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verify password
    if (!$user || !password_verify($currentPass, $user['password'])) {
        echo json_encode(['status' => false, 'message' => 'Invalid current password']);
        exit;
    }

    // Update password
    $hashedPass = password_hash($newPass, PASSWORD_DEFAULT);
    $updateStmt = $con->prepare("UPDATE users SET password = ? WHERE id = ?");
    $updateStmt->bind_param("si", $hashedPass, $userId);

    // Update result
    if ($updateStmt->execute()) {
        echo json_encode(['status' => true, 'message' => 'Password updated']);
    } else {
        echo json_encode(['status' => false, 'message' => 'Database error']);
    }
}
?>
