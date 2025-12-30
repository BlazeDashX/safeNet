<?php
require_once '../models/db.php'; // Adjust path if needed

$name = "dddd";
$username = "dddd"; 
$email = "dddd@dd.dd";
$raw_password = "dddd";
$gender = "Male";
$dob = "2000-01-01";
$type = "admin";

// 1. Hash the password securely
$hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);

// 2. Insert into Database
$con = getConnection();
$sql = "INSERT INTO users (name, username, email, password, gender, dob, type) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $con->prepare($sql);
$stmt->bind_param("sssssss", $name, $username, $email, $hashed_password, $gender, $dob, $type);

if ($stmt->execute()) {
    echo "Admin created successfully! You can now login.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$con->close();
?>