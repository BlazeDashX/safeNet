<?php
require_once 'db.php';

// Create report
function createReport($userId, $desc, $rel, $type, $evidencePath) {
    $con = getConnection();

    // Insert query
    $sql = "INSERT INTO reports 
            (user_id, description, relationship, type, evidence, status) 
            VALUES (?, ?, ?, ?, ?, 'Pending')";

    $stmt = $con->prepare($sql);

    // Prepare check
    if (!$stmt) {
        $con->close();
        return false;
    }

    // Bind values
    $stmt->bind_param("issss", $userId, $desc, $rel, $type, $evidencePath);

    // Execute query
    $result = $stmt->execute();

    $stmt->close();
    $con->close();
    return $result;
}

// Fetch reports
function getReportsByUserId($userId) {
    $con = getConnection();

    // Select query
    $sql = "SELECT * FROM reports 
            WHERE user_id = ? 
            ORDER BY created_at DESC";

    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();

    // Fetch result
    $result = $stmt->get_result();
    $reports = [];

    while ($row = $result->fetch_assoc()) {
        $reports[] = $row;
    }

    $stmt->close();
    $con->close();
    return $reports;
}
?>
