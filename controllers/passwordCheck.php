<?php
session_start();
require_once '../models/db.php';
header('Content-Type: application/json');

// 1. Security Check
if (!isset($_SESSION['status'])) {
    echo json_encode(['status' => false, 'message' => 'Please login first']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $currentPass = $_POST['currentPass'];
    $newPass = $_POST['newPass'];
    $confirmPass = $_POST['confirmPass'];

    // 2. Server-Side Validation
    if (empty($currentPass) || empty($newPass) || empty($confirmPass)) {
        echo json_encode(['status' => false, 'message' => 'All fields are required']);
        exit;
    }
    if ($newPass !== $confirmPass) {
        echo json_encode(['status' => false, 'message' => 'New passwords do not match']);
        exit;
    }
    if (strlen($newPass) < 8) { 
        echo json_encode(['status' => false, 'message' => 'New password must be at least 8 chars']);
        exit;
    }

    // 3. Verify Current Password
    $con = getConnection();
    $sql = "SELECT password FROM users WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Use password_verify since passwords are hashed in DB
    if (!$user || !password_verify($currentPass, $user['password'])) {
        echo json_encode(['status' => false, 'message' => 'Incorrect current password']);
        exit;
    }

    // 4. Update with New Hash
    $newPassHashed = password_hash($newPass, PASSWORD_DEFAULT);

    $updateSql = "UPDATE users SET password = ? WHERE id = ?";
    $updateStmt = $con->prepare($updateSql);
    $updateStmt->bind_param("si", $newPassHashed, $userId);
    
    if ($updateStmt->execute()) {
        echo json_encode(['status' => true, 'message' => 'Password updated successfully']);
    } else {
        echo json_encode(['status' => false, 'message' => 'Database error']);
    }
}
?>