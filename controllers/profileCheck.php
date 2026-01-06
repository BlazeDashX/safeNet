<?php
session_start();
require_once '../models/userModel.php'; // User model
header('Content-Type: application/json');

// Auth check
if (!isset($_SESSION['status']) || $_SESSION['status'] !== true) {
    echo json_encode(['status' => false, 'message' => 'Unauthorized']);
    exit;
}

$userId = $_SESSION['user_id'];
$method = $_SERVER['REQUEST_METHOD'];

// Load profile
if ($method === 'GET') {

    $user = getUserById($userId);

    if ($user) {
        echo json_encode(['status' => true, 'data' => $user]);
    } else {
        echo json_encode(['status' => false, 'message' => 'User not found']);
    }
    exit;
}

// Update profile
if ($method === 'POST') {

    $data = json_decode(file_get_contents('php://input'), true);

    $name   = $data['name'] ?? '';
    $email  = $data['email'] ?? '';
    $dob    = $data['dob'] ?? '';
    $gender = $data['gender'] ?? '';

    // Required check
    if (empty($name) || empty($email) || empty($dob) || empty($gender)) {
        echo json_encode(['status' => false, 'message' => 'Required fields missing']);
        exit;
    }

    // Email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => false, 'message' => 'Invalid email']);
        exit;
    }

    // Name validation
    if (!preg_match('/^[a-zA-Z\s.\-]+$/', $name)) {
        echo json_encode(['status' => false, 'message' => 'Invalid name']);
        exit;
    }

    // Age validation
    $dobDate = new DateTime($dob);
    $age = (new DateTime())->diff($dobDate)->y;

    if ($age < 14) {
        echo json_encode(['status' => false, 'message' => 'Age restriction']);
        exit;
    }

    // Update data
    $status = updateUser($userId, $name, $email, $gender, $dob);

    if ($status) {
        $_SESSION['username'] = $name;
        echo json_encode(['status' => true, 'message' => 'Profile updated']);
    } else {
        echo json_encode(['status' => false, 'message' => 'Update failed']);
    }
    exit;
}
?>
