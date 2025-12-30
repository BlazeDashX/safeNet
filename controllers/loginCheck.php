<?php
session_start();
require_once dirname(__DIR__) . '/models/userModel.php';
header('Content-Type: application/json');

// 1. Get JSON input
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Check if data was actually received
if (!$data) {
    echo json_encode(['status' => false, 'message' => 'No data received']);
    exit;
}

// 2. Safe Extraction (Prevent Undefined Index warnings)
$identifier = $data['identifier'] ?? '';
$password = $data['password'] ?? '';

// 3. Server-side Validation
if (empty($identifier) || empty($password)) {
    echo json_encode(['status' => false, 'message' => 'Both fields are required']);
    exit;
}

// 4. Check User in Database
// (This function checks both Username AND Email)
$user = loginUser($identifier);

if ($user && password_verify($password, $user['password'])) {
    // 5. Login Successful - Set Session
    $_SESSION['status'] = true;
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['type'] = $user['type']; 
    
    // Return Success JSON with User Type for redirect logic
    echo json_encode([
        'status' => true, 
        'message' => 'Login successful', 
        'user' => ['type' => $user['type']]
    ]);
} else {
    // 6. Login Failed
    echo json_encode(['status' => false, 'message' => 'Invalid username/email or password']);
}
?>