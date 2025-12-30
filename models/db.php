<?php
// Database credentials
$host = '127.0.0.1';
$dbuser = 'root';
$dbpass = ''; 
$dbname = 'safenet_db'; 


function getConnection() {
    global $host, $dbuser, $dbpass, $dbname;

    // Create connection
    $con = new mysqli($host, $dbuser, $dbpass, $dbname);

    
    if ($con->connect_error) {
        die(json_encode(["status" => false, "message" => "Database Connection Failed: " . $con->connect_error]));
    }

    return $con;
}
?>