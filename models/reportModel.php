<?php
require_once 'db.php';

function createReport($userId, $desc, $rel, $type, $evidencePath) {
    $con = getConnection();
    
    // Explicitly listing columns ensures we don't rely on order
    $sql = "INSERT INTO reports (user_id, description, relationship, type, evidence, status) VALUES (?, ?, ?, ?, ?, 'Pending')";
    
    $stmt = $con->prepare($sql);
    
    if (!$stmt) {
        // Log error to PHP server logs for debugging
        error_log("DB Prepare Error: " . $con->error); 
        $con->close();
        return false;
    }

    $stmt->bind_param("issss", $userId, $desc, $rel, $type, $evidencePath);
    
    $result = $stmt->execute();

    if (!$result) {
        error_log("DB Execute Error: " . $stmt->error);
    }
    
    $stmt->close();
    $con->close();
    return $result;
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