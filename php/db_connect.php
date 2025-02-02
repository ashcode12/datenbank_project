<?php
// Database connection
$servername = "localhost";
$username = "root"; // Default username for MySQL
$password = "": // Left empty for default
$dbname = "datenbank_project"; // Database name

// Create Connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if (&conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully!";
}
?>