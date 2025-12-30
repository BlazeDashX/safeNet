<?php
require_once 'db.php';

function createReport($userId, $desc, $rel, $type, $evidencePath) {
    $con = getConnection();
    $sql = "INSERT INTO reports (user_id, description, relationship, type, evidence, status) VALUES (?, ?, ?, ?, ?, 'Pending')";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("issss", $userId, $desc, $rel, $type, $evidencePath);
    
    $status = $stmt->execute();
    
    $stmt->close();
    $con->close();
    return $status;
}
function getReportsByUserId($userId) {
    $con = getConnection();
    $sql = "SELECT * FROM reports WHERE user_id = ? ORDER BY created_at DESC";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
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