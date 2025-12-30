<?php
require_once 'db.php';

// Check if username already exists
function isUsernameAvailable($username) {
    $con = getConnection();
    $stmt = $con->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $status = ($result->num_rows === 0);
    $stmt->close();
    $con->close();
    return $status;
}

// Check if email already exists
function isEmailAvailable($email) {
    $con = getConnection();
    $stmt = $con->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $status = ($result->num_rows === 0);
    $stmt->close();
    $con->close();
    return $status;
}

// Register User (Matches your new database columns)
function registerUser($name, $username, $email, $password, $gender, $dob, $type) {
    $con = getConnection();
    $sql = "INSERT INTO users (name, username, email, password, gender, dob, type) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("sssssss", $name, $username, $email, $password, $gender, $dob, $type);
    
    $status = $stmt->execute();
    
    $stmt->close();
    $con->close();
    return $status;
}

// Login User (Supports Email OR Username)
function loginUser($identifier) {
    $con = getConnection();
    $sql = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ss", $identifier, $identifier);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $user = null;
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
    }
    
    $stmt->close();
    $con->close();
    return $user;
}
?>