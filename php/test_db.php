<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost"; // Update with your server
$username = "baurtaul"; // Your username
$password = "mango"; // Your password
$dbname = "datenbank_project"; // Your database

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Database connection successful!";
?>
