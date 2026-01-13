<?php
session_start();
require_once dirname(__DIR__) . '/models/userModel.php';
header('Content-Type: application/json');

//  POST
if (!isset($_POST['user'])) {
    echo json_encode(['status' => false, 'message' => 'No data received']);
    exit;
}

$data = json_decode($_POST['user'], true);

$name     = $data['name'] ?? '';
$username = $data['username'] ?? '';
$email    = $data['email'] ?? '';
$password = $data['password'] ?? '';
$rePass   = $data['rePassword'] ?? '';
$gender   = $data['gender'] ?? '';
$dob      = $data['dob'] ?? '';
$type     = $data['type'] ?? '';

// Required fields check
if (empty($name) || empty($username) || empty($email) || empty($password) || empty($rePass) || empty($gender) || empty($dob) || empty($type)) {
    echo json_encode(['status' => false, 'message' => 'Required fields missing']);
    exit;
}

// Password match
if ($password !== $rePass) {
    echo json_encode(['status' => false, 'message' => 'Password mismatch']);
    exit;
}

// Check duplicates
if (!isUsernameAvailable($username)) {
    echo json_encode(['status' => false, 'message' => 'Username exists']);
    exit;
}
if (!isEmailAvailable($email)) {
    echo json_encode(['status' => false, 'message' => 'Email exists']);
    exit;
}

// Hash password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Register user
$status = registerUser($name, $username, $email, $hashedPassword, $gender, $dob, $type);

if ($status) {
    echo json_encode(['status' => true, 'message' => 'Account created']);
} else {
    echo json_encode(['status' => false, 'message' => 'Database error']);
}
?>
