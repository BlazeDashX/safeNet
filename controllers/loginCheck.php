<?php
// 1. SILENCE WARNINGS (Crucial for JSON)
error_reporting(0);
ini_set('display_errors', 0);

// 2. Start Buffer (Catches accidental spaces)
ob_start();

session_start();

// Adjust this path if needed. 
// If loginCheck.php is in 'controllers', and userModel is in 'models', use this:
require_once '../models/userModel.php'; 

// 3. Clean the Buffer (Deletes any warnings/spaces printed by included files)
ob_clean();

header('Content-Type: application/json');

// --- START LOGIC ---

$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!$data) {
    echo json_encode(['status' => false, 'message' => 'No data received']);
    exit;
}

$identifier = $data['identifier'] ?? '';
$password = $data['password'] ?? '';

if (empty($identifier) || empty($password)) {
    echo json_encode(['status' => false, 'message' => 'Both fields are required']);
    exit;
}

// Check user credentials
$user = loginUser($identifier);

if ($user && password_verify($password, $user['password'])) {
    
    // Set Session
    $_SESSION['status'] = true;
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['type'] = $user['type'];

    // CALCULATE REDIRECT URL
    $redirectUrl = '../views/user/userDashboard.php'; // Default

    if ($user['type'] === 'admin') {
        $redirectUrl = '../views/admin_consultant/adminDashboard.php';
    } 
    elseif ($user['type'] === 'consultant') {
        $redirectUrl = '../views/admin_consultant/consultantDashboard.php';
    }

    // Send Clean JSON
    echo json_encode([
        'status' => true, 
        'message' => 'Login successful', 
        'redirect' => $redirectUrl 
    ]);

} else {
    echo json_encode(['status' => false, 'message' => 'Invalid credentials']);
}

// 4. Force Stop
exit;
?>