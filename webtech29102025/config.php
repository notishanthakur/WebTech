<?php
// Database configuration
$host = 'localhost';
$username = 'root';  // Change this to your MySQL username
$password = 'root';  // Change this to your MySQL password
$default_db = 'webtech_db'; // Default database name

// Check if MySQLi is available
if (!extension_loaded('mysqli')) {
    die(json_encode(['success' => false, 'message' => 'MySQLi extension is required but not available. Please install MySQLi extension.']));
}

// Create connection to MySQL server (without selecting a database)
function getConnection() {
    global $host, $username, $password;
    
    $conn = new mysqli($host, $username, $password);
    if ($conn->connect_error) {
        die(json_encode(['success' => false, 'message' => "Connection failed: " . $conn->connect_error]));
    }
    return $conn;
}

// Create connection to specific database
function getDBConnection($dbname) {
    global $host, $username, $password;
    
    $conn = new mysqli($host, $username, $password, $dbname);
    if ($conn->connect_error) {
        die(json_encode(['success' => false, 'message' => "Connection failed: " . $conn->connect_error]));
    }
    return $conn;
}

// Set content type to JSON
header('Content-Type: application/json');
?>
