<?php
// DB credentials
$host = '127.0.0.1';
$dbuser = 'root';
$dbpass = '';
$dbname = 'safenet_db';

// Get DB connection
function getConnection() {
    global $host, $dbuser, $dbpass, $dbname;

    // Connect
    $con = new mysqli($host, $dbuser, $dbpass, $dbname);

    // Connection check
    if ($con->connect_error) {
        die(json_encode([
            "status" => false,
            "message" => "DB Connection Failed: " . $con->connect_error
        ]));
    }

    return $con;
}
?>
