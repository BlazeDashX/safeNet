<?php
session_start();
require_once dirname(__DIR__) . '/models/userModel.php';
header('Content-Type: application/json');

// 1. Get JSON data from JavaScript
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!$data) {
    echo json_encode(['status' => false, 'message' => 'No data received']);
    exit;
}

// 2. Extract variables (Safe Extraction using Null Coalescing '??')
$name = $data['name'] ?? '';
$username = $data['username'] ?? '';
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';
$confirmPassword = $data['rePassword'] ?? '';
$gender = $data['gender'] ?? '';
$dob = $data['dob'] ?? '';
$type = $data['type'] ?? '';

// 3. Backend Validation (Essential Security Layer)
if (empty($name) || empty($username) || empty($email) || empty($password) || empty($gender) || empty($dob) || empty($type)) {
    echo json_encode(['status' => false, 'message' => 'Please fill all required fields (Server Check)']);
    exit;
}

if ($password !== $confirmPassword) {
    echo json_encode(['status' => false, 'message' => 'Passwords do not match']);
    exit;
}

// 4. Check duplicates
if (!isUsernameAvailable($username)) {
    echo json_encode(['status' => false, 'message' => 'Username already taken']);
    exit;
}

if (!isEmailAvailable($email)) {
    echo json_encode(['status' => false, 'message' => 'Email already used']);
    exit;
}

// 5. Hash Password and Save
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$status = registerUser($name, $username, $email, $hashedPassword, $gender, $dob, $type);

if ($status) {
    echo json_encode(['status' => true, 'message' => 'Account created successfully!']);
} else {
    echo json_encode(['status' => false, 'message' => 'Database error. Try again.']);
}
?>