<?php
session_start();
require_once '../models/userModel.php';
header('Content-Type: application/json');

// 1. SECURITY: Check if logged in
if (!isset($_SESSION['status']) || $_SESSION['status'] !== true) {
    echo json_encode(['status' => false, 'message' => 'Not authorized']);
    exit;
}

$userId = $_SESSION['user_id'];
$method = $_SERVER['REQUEST_METHOD'];

// --- GET REQUEST: Load Profile Data (For filling the form) ---
if ($method === 'GET') {
    $user = getUserById($userId);
    if ($user) {
        echo json_encode(['status' => true, 'data' => $user]);
    } else {
        echo json_encode(['status' => false, 'message' => 'User not found']);
    }
    exit;
}

// --- POST REQUEST: Save Profile Data (With VALIDATION) ---
if ($method === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $name = $data['name'] ?? '';
    $email = $data['email'] ?? '';
    $dob = $data['dob'] ?? '';
    $gender = $data['gender'] ?? '';

    // --- STRICT PHP VALIDATION START ---

    // 1. Check Empty Fields
    if (empty($name) || empty($email) || empty($dob) || empty($gender)) {
        echo json_encode(['status' => false, 'message' => 'All fields are required (PHP Check)']);
        exit;
    }

    // 2. Validate Email Format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => false, 'message' => 'Invalid email format']);
        exit;
    }

    // 3. Validate Name (Letters and spaces only)
    // allowing . and - for names like "St. John" or "Mary-Jane"
    if (!preg_match("/^[a-zA-Z\s\.\-]+$/", $name)) {
        echo json_encode(['status' => false, 'message' => 'Name can only contain letters']);
        exit;
    }

    // 4. Validate Age (Must be 14+)
    $dobDate = new DateTime($dob);
    $now = new DateTime();
    $age = $now->diff($dobDate)->y;
    
    if ($age < 14) {
        echo json_encode(['status' => false, 'message' => 'You must be at least 14 years old']);
        exit;
    }

    // --- PHP VALIDATION END ---

    // Update Database
    $status = updateUser($userId, $name, $email, $gender, $dob);

    if ($status) {
        $_SESSION['username'] = $name; // Update session name immediately
        echo json_encode(['status' => true, 'message' => 'Profile updated successfully']);
    } else {
        echo json_encode(['status' => false, 'message' => 'Database update failed']);
    }
    exit;
}