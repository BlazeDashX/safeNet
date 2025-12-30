<?php
session_start();
require_once '../models/db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['status']) || ($_SESSION['type'] != 'admin' && $_SESSION['type'] != 'consultant')) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reportId = $_POST['id'];
    $newStatus = $_POST['status'];

    $con = getConnection();
    $sql = "UPDATE reports SET status = ? WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("si", $newStatus, $reportId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
    $con->close();
}
?>