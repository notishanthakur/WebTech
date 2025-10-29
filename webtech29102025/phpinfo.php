<?php
// Simple PHP info checker
echo "<h2>PHP Extensions Check</h2>";

// Check MySQLi
if (extension_loaded('mysqli')) {
    echo "<p style='color: green;'>✓ MySQLi extension is available</p>";
    echo "<p style='color: blue; font-weight: bold;'>→ Application will use MySQLi (MySQL)</p>";
} else {
    echo "<p style='color: red;'>✗ MySQLi extension is NOT available</p>";
    echo "<p style='color: red; font-weight: bold;'>→ Application will NOT work without MySQLi!</p>";
    echo "<h3>To Fix This:</h3>";
    echo "<ul>";
    echo "<li><strong>XAMPP:</strong> MySQLi should be enabled by default</li>";
    echo "<li><strong>WAMP:</strong> Enable MySQLi in PHP extensions</li>";
    echo "<li><strong>Manual:</strong> Uncomment 'extension=mysqli' in php.ini</li>";
    echo "</ul>";
}

echo "<h3>PHP Version:</h3>";
echo "<p>PHP Version: " . phpversion() . "</p>";

echo "<h3>MySQL Connection Test:</h3>";
if (extension_loaded('mysqli')) {
    $host = 'localhost';
    $username = 'root';
    $password = '';
    
    $conn = new mysqli($host, $username, $password);
    
    if ($conn->connect_error) {
        echo "<p style='color: red;'>✗ MySQL Connection Failed: " . $conn->connect_error . "</p>";
        echo "<p>Make sure MySQL server is running and credentials are correct in config.php</p>";
    } else {
        echo "<p style='color: green;'>✓ MySQL Connection Successful</p>";
        $conn->close();
    }
} else {
    echo "<p style='color: red;'>Cannot test MySQL connection - MySQLi not available</p>";
}
?>
