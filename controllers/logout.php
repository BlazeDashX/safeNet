<?php
session_start();
// Destroy all session data
session_unset();
session_destroy();

// Return success to the JavaScript
header('Content-Type: application/json');
echo json_encode(['status' => true, 'message' => 'Logged out']);
?>