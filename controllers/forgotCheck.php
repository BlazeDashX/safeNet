<?php
require_once '../models/userModel.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // --- STEP 1: VERIFY USER ---
    if ($action === 'verify') {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');

        if (empty($username) || empty($email)) {
            echo json_encode(['status' => false, 'message' => 'Both fields are required.']);
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
            echo json_encode(['status' => false, 'message' => 'Username and Email do not match.']);
        }
        $stmt->close();
        $con->close();
    }

    // --- STEP 2: RESET PASSWORD ---
    else if ($action === 'reset') {
        $userId = $_POST['user_id'] ?? '';
        $newPass = $_POST['new_password'] ?? '';
        $confPass = $_POST['confirm_password'] ?? '';

        if (empty($newPass) || empty($confPass)) {
            echo json_encode(['status' => false, 'message' => 'All fields are required.']);
            exit;
        }

        // Updated requirement: Minimum 8 characters
        if (strlen($newPass) < 8) {
            echo json_encode(['status' => false, 'message' => 'Password must be at least 8 characters long.']);
            exit;
        }

        if ($newPass !== $confPass) {
            echo json_encode(['status' => false, 'message' => 'Passwords do not match.']);
            exit;
        }

        // Hashing the password for security
        $hashedPass = password_hash($newPass, PASSWORD_BCRYPT);

        $con = getConnection();
        $stmt = $con->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $hashedPass, $userId);
        
        if ($stmt->execute()) {
            echo json_encode(['status' => true, 'message' => 'Password updated successfully!']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Database error. Please try again.']);
        }
        $stmt->close();
        $con->close();
    }
}
?>