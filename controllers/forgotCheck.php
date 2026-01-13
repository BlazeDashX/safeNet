<?php
require_once '../models/userModel.php'; // your DB model
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $action = $_POST['action'] ?? '';

    // 1️⃣ Verify user
    if ($action === 'verify') {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');

        if (empty($username) || empty($email)) {
            echo json_encode(['status' => false, 'message' => 'Required fields missing']);
            exit;
        }

        $con = getConnection();
        $stmt = $con->prepare("SELECT id FROM users WHERE username = ? AND email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            echo json_encode(['status' => true, 'userId' => $user['id']]);
        } else {
            echo json_encode(['status' => false, 'message' => 'Invalid credentials']);
        }

        $stmt->close();
        $con->close();
    }

    // 2️⃣ Reset password
    else if ($action === 'reset') {
        $userId = $_POST['user_id'] ?? '';
        $newPass = $_POST['new_password'] ?? '';
        $confPass = $_POST['confirm_password'] ?? '';

        if (empty($newPass) || empty($confPass)) {
            echo json_encode(['status' => false, 'message' => 'Required fields missing']);
            exit;
        }

        if (strlen($newPass) < 8) {
            echo json_encode(['status' => false, 'message' => 'Weak password']);
            exit;
        }

        if ($newPass !== $confPass) {
            echo json_encode(['status' => false, 'message' => 'Password mismatch']);
            exit;
        }

        $hashedPass = password_hash($newPass, PASSWORD_BCRYPT);

        $con = getConnection();
        $stmt = $con->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $hashedPass, $userId);

        if ($stmt->execute()) {
            echo json_encode(['status' => true, 'message' => 'Password updated']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Database error']);
        }

        $stmt->close();
        $con->close();
    }
}
?>
