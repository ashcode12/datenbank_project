<?php
// Database connection details
$servername = "fbwallinone24.th-brandenburg.de";  // MySQL server hostname
$username = "baurtaul";  // Your phpMyAdmin username
$password = "mango";  // Your phpMyAdmin password
$dbname = "baurtaul";  // Name of the database you created in phpMyAdmin

// Create a connection to the MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection status
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully to the university database!";
}
?>

