<?php
require_once '../models/db.php'; // DB connection

// User data
$name = "dddd";
$username = "dddd";
$email = "dddd@dd.dd";
$password = "dddd";
$gender = "Male";
$dob = "2000-01-01";
$type = "admin";

// Password hashing
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Database insert
$con = getConnection();
$sql = "INSERT INTO users (name, username, email, password, gender, dob, type)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $con->prepare($sql);
$stmt->bind_param(
    "sssssss",
    $name,
    $username,
    $email,
    $hashedPassword,
    $gender,
    $dob,
    $type
);

// Execution check
if ($stmt->execute()) {
    echo "Admin created successfully.";
} else {
    echo "Insertion failed.";
}

// Close resources
$stmt->close();
$con->close();
?>
