<?php
error_reporting(0);
ini_set('display_errors', 0);

ob_start();
session_start();

require_once '../models/userModel.php'; // User model

ob_clean();
header('Content-Type: application/json');

// Read JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Input check
if (!$data) {
    echo json_encode(['status' => false, 'message' => 'No data received']);
    exit;
}

$identifier = $data['identifier'] ?? '';
$password   = $data['password'] ?? '';

// Validation
if (empty($identifier) || empty($password)) {
    echo json_encode(['status' => false, 'message' => 'Required fields missing']);
    exit;
}

// Credential check
$user = loginUser($identifier);

if ($user && password_verify($password, $user['password'])) {

    // Session setup
    $_SESSION['status']   = true;
    $_SESSION['user_id']  = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['type']     = $user['type'];

    // Role redirect
    $redirectUrl = '../views/user/userDashboard.php';

    if ($user['type'] === 'admin') {
        $redirectUrl = '../views/admin_consultant/adminDashboard.php';
    } elseif ($user['type'] === 'consultant') {
        $redirectUrl = '../views/admin_consultant/consultantDashboard.php';
    }

    // Success response
    echo json_encode([
        'status'   => true,
        'message'  => 'Login successful',
        'redirect' => $redirectUrl
    ]);

} else {
    echo json_encode(['status' => false, 'message' => 'Invalid credentials']);
}

exit;
?>
