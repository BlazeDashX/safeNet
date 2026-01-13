<?php
session_start();
require_once '../models/userModel.php';
header('Content-Type: application/json');

if (!isset($_SESSION['status']) || $_SESSION['status'] !== true) {
    echo json_encode(['status'=>false,'message'=>'Unauthorized']);
    exit;
}

$userId = $_SESSION['user_id'];
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $user = getUserById($userId);
    if ($user) {
        echo json_encode(['status'=>true,'data'=>$user]);
    } else {
        echo json_encode(['status'=>false,'message'=>'User not found']);
    }
    exit;
}

if ($method === 'POST') {
    $name   = $_POST['name'] ?? '';
    $email  = $_POST['email'] ?? '';
    $dob    = $_POST['dob'] ?? '';
    $gender = $_POST['gender'] ?? '';

    if (empty($name) || empty($email) || empty($dob) || empty($gender)) {
        echo json_encode(['status'=>false,'message'=>'Required fields missing']);
        exit;
    }

    if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status'=>false,'message'=>'Invalid email']);
        exit;
    }

    if (!preg_match('/^[a-zA-Z\s.\-]+$/', $name)) {
        echo json_encode(['status'=>false,'message'=>'Invalid name']);
        exit;
    }

    $dobDate = new DateTime($dob);
    $age = (new DateTime())->diff($dobDate)->y;
    if ($age < 14) {
        echo json_encode(['status'=>false,'message'=>'Age restriction']);
        exit;
    }

    $status = updateUser($userId, $name, $email, $gender, $dob);

    if ($status) {
        $_SESSION['username'] = $name;
        echo json_encode(['status'=>true,'message'=>'Profile updated']);
    } else {
        echo json_encode(['status'=>false,'message'=>'Update failed']);
    }
}
?>
