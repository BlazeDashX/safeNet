<?php
error_reporting(0);
ini_set('display_errors', 0);

session_start();
require_once '../models/userModel.php';

header('Content-Type: application/json');

//  POST handling
if (!isset($_POST['user'])) {
    echo json_encode(['status' => false, 'message' => 'No data received']);
    exit;
}

$data = json_decode($_POST['user'], true);

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

    $_SESSION['status']   = true;
    $_SESSION['user_id']  = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['type']     = $user['type'];

    $redirectUrl = '../views/user/userDashboard.php';

    if ($user['type'] === 'admin') {
        $redirectUrl = '../views/admin_consultant/adminDashboard.php';
    } elseif ($user['type'] === 'consultant') {
        $redirectUrl = '../views/admin_consultant/consultantDashboard.php';
    }

    echo json_encode([
        'status'   => true,
        'message'  => 'Login successful',
        'redirect' => $redirectUrl
    ]);

} else {
    echo json_encode(['status' => false, 'message' => 'Invalid credentials']);
}
?>
