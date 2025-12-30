<?php
session_start();
require_once dirname(__DIR__) . '/models/userModel.php';
header('Content-Type: application/json');

$json = file_get_contents('php://input');
$data = json_decode($json, true);

$identifier = $data['identifier'];
$password = $data['password'];

if (empty($identifier) || empty($password)) {
    echo json_encode(['status' => false, 'message' => 'Please enter username/email and password']);
    exit;
}

// Check User
$user = loginUser($identifier);

if ($user && password_verify($password, $user['password'])) {
    // Set Session Variables
    $_SESSION['status'] = true;
    $_SESSION['username'] = $user['username'];
    $_SESSION['type'] = $user['type']; 
    
    echo json_encode([
        'status' => true, 
        'message' => 'Login successful', 
        'user' => ['type' => $user['type']]
    ]);
} else {
    echo json_encode(['status' => false, 'message' => 'Invalid credentials']);
}
?>