<?php
require_once 'config.php';

// Get the action from the request
$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'create_database':
        createDatabase();
        break;
    case 'create_table':
        createTable();
        break;
    case 'insert_record':
        insertRecord();
        break;
    case 'search_records':
        searchRecords();
        break;
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        break;
}

function createDatabase() {
    $dbName = $_POST['db_name'] ?? '';
    
    if (empty($dbName)) {
        echo json_encode(['success' => false, 'message' => 'Database name is required']);
        return;
    }
    
    $conn = getConnection();
    
    // Create database
    $sql = "CREATE DATABASE IF NOT EXISTS `$dbName`";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true, 'message' => "Database '$dbName' created successfully"]);
    } else {
        echo json_encode(['success' => false, 'message' => "Error creating database: " . $conn->error]);
    }
    
    $conn->close();
}

function createTable() {
    $dbName = $_POST['db_name'] ?? 'webtech_db';
    $tableName = $_POST['table_name'] ?? '';
    
    if (empty($tableName)) {
        echo json_encode(['success' => false, 'message' => 'Table name is required']);
        return;
    }
    
    $conn = getDBConnection($dbName);
    
    // Create table with specified columns
    $sql = "CREATE TABLE IF NOT EXISTS `$tableName` (
        ID INT AUTO_INCREMENT PRIMARY KEY,
        FNAME VARCHAR(100) NOT NULL,
        LNAME VARCHAR(100) NOT NULL,
        REGNI VARCHAR(50) NOT NULL,
        SEC VARCHAR(10) NOT NULL,
        ADDRESS TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true, 'message' => "Table '$tableName' created successfully"]);
    } else {
        echo json_encode(['success' => false, 'message' => "Error creating table: " . $conn->error]);
    }
    
    $conn->close();
}

function insertRecord() {
    $dbName = $_POST['db_name'] ?? 'webtech_db';
    $tableName = $_POST['table_name'] ?? 'students';
    
    $fname = $_POST['fname'] ?? '';
    $lname = $_POST['lname'] ?? '';
    $regni = $_POST['regni'] ?? '';
    $sec = $_POST['sec'] ?? '';
    $address = $_POST['address'] ?? '';
    
    if (empty($fname) || empty($lname) || empty($regni) || empty($sec)) {
        echo json_encode(['success' => false, 'message' => 'All fields except address are required']);
        return;
    }
    
    $conn = getDBConnection($dbName);
    
    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO `$tableName` (FNAME, LNAME, REGNI, SEC, ADDRESS) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $fname, $lname, $regni, $sec, $address);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Record inserted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error inserting record: ' . $stmt->error]);
    }
    
    $stmt->close();
    $conn->close();
}

function searchRecords() {
    $dbName = $_POST['db_name'] ?? $_GET['db_name'] ?? 'webtech_db';
    $tableName = $_POST['table_name'] ?? $_GET['table_name'] ?? 'students';
    
    $searchId = $_POST['search_id'] ?? $_GET['search_id'] ?? '';
    $searchFname = $_POST['search_fname'] ?? $_GET['search_fname'] ?? '';
    $searchLname = $_POST['search_lname'] ?? $_GET['search_lname'] ?? '';
    
    $conn = getDBConnection($dbName);
    
    // Build search query
    $whereConditions = [];
    $params = [];
    $types = '';
    
    if (!empty($searchId)) {
        $whereConditions[] = "ID = ?";
        $params[] = $searchId;
        $types .= 'i';
    }
    
    if (!empty($searchFname)) {
        $whereConditions[] = "FNAME LIKE ?";
        $params[] = "%$searchFname%";
        $types .= 's';
    }
    
    if (!empty($searchLname)) {
        $whereConditions[] = "LNAME LIKE ?";
        $params[] = "%$searchLname%";
        $types .= 's';
    }
    
    $sql = "SELECT * FROM `$tableName`";
    if (!empty($whereConditions)) {
        $sql .= " WHERE " . implode(" AND ", $whereConditions);
    }
    $sql .= " ORDER BY ID DESC";
    
    $stmt = $conn->prepare($sql);
    
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    $records = [];
    while ($row = $result->fetch_assoc()) {
        $records[] = $row;
    }
    
    echo json_encode([
        'success' => true, 
        'records' => $records,
        'count' => count($records)
    ]);
    
    $stmt->close();
    $conn->close();
}
?>
