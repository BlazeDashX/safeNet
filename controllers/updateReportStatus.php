<?php
session_start();
require_once '../models/db.php'; // DB connection
header('Content-Type: application/json');

// Role check
if (
    !isset($_SESSION['status']) ||
    ($_SESSION['type'] !== 'admin' && $_SESSION['type'] !== 'consultant')
) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

// Request check
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $reportId  = $_POST['id'] ?? '';
    $newStatus = $_POST['status'] ?? '';

    // Input validation
    if (empty($reportId) || empty($newStatus)) {
        echo json_encode(['success' => false, 'message' => 'Invalid input']);
        exit;
    }

    // Update status
    $con = getConnection();
    $stmt = $con->prepare("UPDATE reports SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $newStatus, $reportId);

    // Execution result
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }

    $stmt->close();
    $con->close();
}
?>
