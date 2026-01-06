<?php
session_start();
require_once dirname(__DIR__) . '/models/userModel.php'; // User model
header('Content-Type: application/json');

// Read JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Input check
if (!$data) {
    echo json_encode(['status' => false, 'message' => 'No data received']);
    exit;
}

// Data extraction
$name     = $data['name'] ?? '';
$username = $data['username'] ?? '';
$email    = $data['email'] ?? '';
$password = $data['password'] ?? '';
$rePass   = $data['rePassword'] ?? '';
$gender   = $data['gender'] ?? '';
$dob      = $data['dob'] ?? '';
$type     = $data['type'] ?? '';

// Required validation
if (
    empty($name) || empty($username) || empty($email) ||
    empty($password) || empty($gender) || empty($dob) || empty($type)
) {
    echo json_encode(['status' => false, 'message' => 'Required fields missing']);
    exit;
}

// Password check
if ($password !== $rePass) {
    echo json_encode(['status' => false, 'message' => 'Password mismatch']);
    exit;
}

// Duplicate checks
if (!isUsernameAvailable($username)) {
    echo json_encode(['status' => false, 'message' => 'Username exists']);
    exit;
}

if (!isEmailAvailable($email)) {
    echo json_encode(['status' => false, 'message' => 'Email exists']);
    exit;
}

// Password hashing
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Save user
$status = registerUser(
    $name,
    $username,
    $email,
    $hashedPassword,
    $gender,
    $dob,
    $type
);

// Response
if ($status) {
    echo json_encode(['status' => true, 'message' => 'Account created']);
} else {
    echo json_encode(['status' => false, 'message' => 'Database error']);
}
?>
