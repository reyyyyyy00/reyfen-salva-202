<?php
// Database configuration
$host = 'localhost';
$dbname = 'educ_env_energy';
$username = 'root';
$password = '';

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start session
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
?>